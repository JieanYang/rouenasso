<?php

namespace App\Http\Controllers;

use App\Work;
use Illuminate\Http\Request;

// 表单验证
use Validator;
use Illuminate\Validation\Rule;

// 身份验证
use Illuminate\Support\Facades\Auth;
use App\Model\Department;
use App\Model\Position;

class WorkController extends Controller
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
        return Work::All();
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
            'job' => 'required',
            'company' => 'required',
            'city'=>'required',
            'salary'=>'required',
            'html_content' => 'required',
            'published_at'=>'date'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $newWork = new Work;
        $newWork->job = $request->job;
        $newWork->company = $request->company;
        $newWork->city = $request->city;
        $newWork->salary = $request->salary;
        $newWork->html_content = $request->html_content;
        $newWork->published_at = $request->published_at ? $request->published_at : null;
        $newWork->user_id = Auth::id();
        $newWork->view = 0;
        $movement->created_at = date("Y-m-d");

        $newWork->save();

        error_log(env('APP_URL'));
        return response()->json(['status' => 200, 'msg' => 'the store of work successful', 'id' => $newWork->id, 
                                'url' => env('APP_URL') . '/works/' . $newWork->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Work::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function edit(Work $work)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Work  $work
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
            'job' => 'required',
            'company' => 'required',
            'city'=>'required',
            'salary'=>'required',
            'html_content' => 'required',
            'published_at'=>'date'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $updateWork = Work::find($id);

        if($updateWork === null) {
            return response()->json(['status' => 404, 'msg' => 'Work not exists']);
        }

        $updateWork->job = $request->job;
        $updateWork->company = $request->company;
        $updateWork->city = $request->city;
        $updateWork->salary = $request->salary;
        $updateWork->html_content = $request->html_content;
        $updateWork->published_at = $request->published_at ? $request->published_at : $updateWork->published_at;

        $updateWork->save();

        return response()->json(['status' => 200, 'msg' => 'the work id : '.$updateWork->id." updates successfully! "]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Work  $work
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

        $WorkDel = Work::find($id);

        if($WorkDel === null) {
            return response()->json(['status' => 404, 'msg' => 'Work not exists']);
        }

        //已发布内容
        if($WorkDel->published_at != null) {
            if(!($this->department == Department::ZHUXITUAN || $this->department == Department::XIANGMUKAIFABU
                || ($this->department == Department::XUANCHUANBU
                && ($this->position == Position::BUZHANG || $this->position == Position::FUBUZHANG) ))) {
                return response()->json(['status' => 403, 'msg' => 'invalid identity']);
            }
        }

        $WorkDel->delete();

        return response()->json(['status' => 200, 'msg' => 'the work id : '.$WorkDel->id.' deletes successfully! ']);
    }
}
