<?php

namespace App\Http\Controllers;

use App\Writing;
use Illuminate\Http\Request;

// 表单验证
use Validator;
use Illuminate\Validation\Rule;

// 身份验证
use Illuminate\Support\Facades\Auth;
use App\Model\Department;
use App\Model\Position;

class WritingController extends Controller
{

    public function __construct() {

        $this->middleware('auth.basic.once')->only(['store', 'update', 'destroy']);

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
    public function index()
    {
        return Writing::All();
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
            'username' => 'required',
            'introduction' => 'required',
            'html_content' => 'required',
            'published_at' => 'date'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $newWriting = new Writing;
        $newWriting->title = $request->title; 
        $newWriting->username = $request->username; 
        $newWriting->introduction = $request->introduction; 
        $newWriting->html_content = $request->html_content; 
        $newWriting->image = $request->image ? $request->image : null;
        $newWriting->published_at = $request->published_at ? $request->published_at : null;
        $newWriting->user_id = Auth::id();
        $newWriting->view = 0;

        $newWriting->save();

        error_log(env('APP_URL'));
        return response()->json(['status' => 200, 'msg' => 'the store of writing successful', 'id' => $newWriting->id, 
                                'url' => env('APP_URL') . '/writings/' . $newWriting->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Writing  $writing
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Writing::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Writing  $writing
     * @return \Illuminate\Http\Response
     */
    public function edit(Writing $writing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Writing  $writing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input. id must be a number']);
        }

        // 修改草稿 => 主席团&宣传部
        if(!($this->department == Department::ZHUXITUAN 
             || $this->department == Department::XUANCHUANBU || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'invalid identity!']);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'username' => 'required',
            'introduction' => 'required',
            'html_content' => 'required',
            'published_at' => 'date'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $updateWriting = Writing::find($id);

        if($updateWriting === null) {
            return response()->json(['status' => 404, 'msg' => 'writing not exists']);
        }

        $updateWriting->title = $request->title; 
        $updateWriting->username = $request->username; 
        $updateWriting->introduction = $request->introduction; 
        $updateWriting->html_content = $request->html_content; 
        $updateWriting->image = $request->image ? $request->image:$updateWriting->image;
        $updateWriting->published_at = $request->published_at ? $request->published_at:$updateWriting->published_at;

        $updateWriting->save();

        return response()->json(['status' => 200, 'msg' => 'the writing id : '.$updateWriting->id." updates successfully! "]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Writing  $writing
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

        $writingDel = Writing::find($id);

        if($writingDel === null) {
            return response()->json(['status' => 404, 'msg' => 'Writing not exists']);
        }

        //已发布内容
        if($writingDel->published_at != null) {
            if(!($this->department == Department::ZHUXITUAN || $this->department == Department::XIANGMUKAIFABU
                || ($this->department == Department::XUANCHUANBU
                && ($this->position == Position::BUZHANG || $this->position == Position::FUBUZHANG) ))) {
                return response()->json(['status' => 403, 'msg' => 'invalid identity']);
            }
        }

        $writingDel->delete();

        return response()->json(['status' => 200, 'msg' => 'the writing id : '.$writingDel->id.' deletes successfully! ']);
    }
}
