<?php

namespace App\Http\Controllers;

use App\Movement;
use Illuminate\Http\Request;

// 表单验证
use Validator;
use Illuminate\Validation\Rule;

// 身份验证
use Illuminate\Support\Facades\Auth;
use App\Model\Department;
use App\Model\Position;


class MovementController extends Controller
{


    public function __construct() {

        $this->middleware('auth.basic.once')->only(['store', 'update', 'destroy', 'index_user_drafts', 'show_user_draft']);

         $this->middleware(function ($request, $next) {
            $this->department = Auth::user() ? Auth::user()->department : null;
            $this->position = Auth::user() ? Auth::user()->position : null;
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // 已发布的全部活动
    public function index()
    {
        $movements = Movement::whereNotNull('published_at')->get();

        // 不返回html
        foreach ($movements as $ch) {
            $ch->setHidden(['html_content', 'user_id', 'updated_at', 'deleted_at']);
        };
        return $movements;
    }


    // 显示草稿某个id用户所有的草稿，需用户认证
    public function index_user_drafts() {
        $movement_drafts = Movement::whereNull('published_at')->where('user_id', Auth::id())->get();
        return $movement_drafts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 新增内容 => 主席团&宣传部
        if(!($this->department == Department::ZHUXITUAN 
             || $this->department == Department::XUANCHUANBU || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'invalid identity'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'introduction' => 'required',
            'html_content' => 'required',
            'published_at' => 'date'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $movement = new Movement;
        $movement->title = $request->title;
        $movement->introduction = $request->introduction;
        $movement->html_content = $request->html_content;
        $movement->image = $request->image ? $request->image : null;
        $movement->published_at = $request->published_at ? $request->published_at : null;
        $movement->user_id = Auth::id();
        $movement->view = 0;
        $movement->created_at = date("Y-m-d");

        $movement->save();

        error_log(env('APP_URL'));
        return response()->json(['status' => 200, 'msg' => 'the store of movement successful', 'id' => $movement->id, 
                                'url' => env('APP_URL') . '/movements/' . $movement->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movement  $movement
     * @return \Illuminate\Http\Response
     */
    // 已发布特定id的活动
    public function show($id)
    {
        $movement = Movement::whereNotNull('published_at')->where('id', $id)->get();

        if($movement === null) {
            return response()->json(['status' => 404, 'msg' => 'The id Movement :'.$id.' not exists']);
        }

        // 隐藏不必要信息
        $movement[0]->setHidden([ 'user_id', 'updated_at', 'deleted_at']);
        return $movement[0];
    }

    //显示某个id用户的某一个id草稿 
    public function show_user_draft($id) {
        $movement = Movement::whereNull('published_at')->where(['id' => $id, 'user_id' => Auth::id()])->get();

        if($movement === null) {
            return response()->json(['status' => 404, 'msg' => 'The id Movement draft :'.$id.' not exists']);
        }

        return $movement[0];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function edit(Movement $movement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input. id must be a number'], 400);
        }

        // 修改草稿 => 主席团&宣传部
        if(!($this->department == Department::ZHUXITUAN 
             || $this->department == Department::XUANCHUANBU || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'invalid identity!']);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'introduction' => 'required',
            'html_content' => 'required',
            'published_at' => 'date'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $movementDB = Movement::find($id);

        if($movementDB === null) {
            return response()->json(['status' => 404, 'msg' => 'Movement not exists']);
        }

        $movementDB->title = $request->title;
        $movementDB->introduction = $request->introduction;
        $movementDB->html_content = $request->html_content;
        $movementDB->image = $request->image?$request->image:$movementDB->image;
        $movementDB->published_at = $request->published_at?$request->published_at:$movementDB->published_at;

        $movementDB->save();

        return response()->json(['status' => 200, 'msg' => 'the movement id : '.$movementDB->id." updates successfully! "]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input. id must be a number!']);
        }

        // 删除内容 => 主席团&宣传部部长&宣传部副部长
        // 删除草稿 => 主席团&宣传部
        if(!($this->department == Department::ZHUXITUAN 
             || $this->department == Department::XUANCHUANBU || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'invalide department']);
        }

        $movementDel = Movement::find($id);

        if($movementDel === null) {
            return response()->json(['status' => 404, 'msg' => 'Movement not exists']);
        }

        //已发布内容
        if($movementDel->published_at != null) {
            if(!($this->department == Department::ZHUXITUAN || $this->department == Department::XIANGMUKAIFABU
                || ($this->department == Department::XUANCHUANBU
                && ($this->position == Position::BUZHANG || $this->position == Position::FUBUZHANG) ))) {
                return response()->json(['status' => 403, 'msg' => 'invalid identity']);
            }
        }

        $movementDel->delete();

        return response()->json(['status' => 200, 'msg' => 'the movement id : '.$movementDel->id.' deletes successfully! ']);

    }
}
