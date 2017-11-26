<?php

namespace App\Http\Controllers;

use App\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


// 表单验证
use Validator;
use Illuminate\Validation\Rule;

// 身份验证
use Illuminate\Support\Facades\Auth;
use App\Model\Department;
use App\Model\Position;

// category 判断后使用
use App\Work;
use App\Writing;

class MovementController extends Controller
{


    public function __construct() {

        $this->middleware('auth.basic.once')->only(['store', 'update', 'destroy', 'index_user_drafts', 'show_user_draft', 'countPost', 'showPostsCalendar']);

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
    public function index($category)
    {
        if($category === 'movements')
            $posts = Movement::whereNotNull('published_at')->get();
        else if($category === 'works')
            $posts = Work::whereNotNull('published_at')->get();
        else if($category === 'writings')
            $posts = Writing::whereNotNull('published_at')->get();
        else 
            return response()->json(['status' => 400, 'msg' => 'Bad Request : wrong category']);

        // 不返回html
        foreach ($posts as $ch) {
            $ch->setHidden(['html_content', 'user_id', 'updated_at', 'deleted_at']);
            $dateArray = explode(" ", $ch->published_at);
            $ch->published_at = $dateArray[0];
        };
        return $posts;
    }


    // 显示草稿某个id用户所有的草稿，需用户认证
    public function index_user_drafts($category) {
        if($category === 'movements')
            $posts_drafts = Movement::whereNull('published_at')->where('user_id', Auth::id())->get();
        else if($category === 'works')
            $posts_drafts = Work::whereNull('published_at')->where('user_id', Auth::id())->get();
        else if($category === 'writings')
            $posts_drafts = Writing::whereNull('published_at')->where('user_id', Auth::id())->get();
        else 
            return response()->json(['status' => 400, 'msg' => 'Bad Request : wrong category']);
        
        return $posts_drafts;
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
    public function store($category, Request $request)
    {
        // 新增内容 => 主席团&宣传部
        if(!($this->department == Department::ZHUXITUAN 
             || $this->department == Department::XUANCHUANBU || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'invalid identity'], 403);
        }

        if($category === 'movements'){
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'introduction' => 'required',
                'html_content' => 'required',
                'published_at' => 'date'
            ]);

            if ($validator->fails()) {
                return $validator->errors();
            }

            $newPost = new Movement;
            $newPost->title = $request->title;
            $newPost->introduction = $request->introduction;
            $newPost->image = $request->image ? $request->image : null;
        }
        else if($category === 'works'){
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

            $newPost = new Work;
            $newPost->job = $request->job;
            $newPost->company = $request->company;
            $newPost->city = $request->city;
            $newPost->salary = $request->salary;
        }
        else if($category === 'writings'){
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

            $newPost = new Writing;
            $newPost->title = $request->title; 
            $newPost->username = $request->username; 
            $newPost->introduction = $request->introduction; 
            $newPost->image = $request->image ? $request->image : null;
        }
        else 
            return response()->json(['status' => 400, 'msg' => 'Bad Request : wrong category']);

        //三种类型帖子共同属性
        $newPost->html_content = $request->html_content; 
        $newPost->published_at = $request->published_at ? $request->published_at : null;
        $newPost->user_id = Auth::id();
        $newPost->view = 0;
        $newPost->created_at = date("Y-m-d H:i:s");

        $newPost->save();

        error_log(env('APP_URL'));
        return response()->json(['status' => 200, 'msg' => 'the store of '.substr($category, 0, -1).' successful!', 'id' => $newPost->id, 
                                'url' => env('APP_URL') . '/'.$category.'/' . $newPost->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movement  $movement
     * @return \Illuminate\Http\Response
     */
    // 已发布特定id的活动
    public function show($category,$id)
    {
        if($category === 'movements')
                $post = Movement::whereNotNull('published_at')->where('id', $id)->get();
            else if($category === 'works')
                $post = Work::whereNotNull('published_at')->where('id', $id)->get();
            else if($category === 'writings')
                $post = Writing::whereNotNull('published_at')->where('id', $id)->get();
            else 
                return response()->json(['status' => 400, 'msg' => 'Bad Request : wrong category']);

        // 隐藏不必要信息
        $post[0]->setHidden([ 'user_id', 'updated_at', 'deleted_at']);

        return $post[0];
    }

    //显示某个id用户的某一个id草稿 
    public function show_user_draft($category, $id) {
        if($category === 'movements')
            $post = Movement::whereNull('published_at')->where(['id' => $id, 'user_id' => Auth::id()])->get();
        else if($category === 'works')
            $post = Work::whereNull('published_at')->where(['id' => $id, 'user_id' => Auth::id()])->get();
        else if($category === 'writings')
            $post = Writing::whereNull('published_at')->where(['id' => $id, 'user_id' => Auth::id()])->get();
        else 
            return response()->json(['status' => 400, 'msg' => 'Bad Request : wrong category']);
        

        return $post[0];
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
    public function update($category, Request $request, $id)
    {
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input. id must be a number'], 400);
        }

        // 修改草稿 => 主席团&宣传部
        if(!($this->department == Department::ZHUXITUAN 
             || $this->department == Department::XUANCHUANBU || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'invalid identity!']);
        }


        if($category === 'movements'){
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'introduction' => 'required',
                'html_content' => 'required',
                'published_at' => 'date'
            ]);

            if ($validator->fails()) {
                return $validator->errors();
            }

            $updatePost = Movement::find($id);

            if($updatePost === null) {
                return response()->json(['status' => 404, 'msg' => substr($category, 0, -1).' not exists']);
            }

            $updatePost->title = $request->title;
            $updatePost->introduction = $request->introduction;
            $updatePost->image = $request->image?$request->image:$updatePost->image;
        }
        else if($category === 'works'){
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

            $updatePost = Work::find($id);

            if($updatePost === null) {
                return response()->json(['status' => 404, 'msg' => substr($category, 0, -1).' not exists']);
            }

            $updatePost->job = $request->job;
            $updatePost->company = $request->company;
            $updatePost->city = $request->city;
            $updatePost->salary = $request->salary;
        }
        else if($category === 'writings'){
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

            $updatePost = Writing::find($id);

            if($updatePost === null) {
                return response()->json(['status' => 404, 'msg' => substr($category, 0, -1).' not exists']);
            }

            $updatePost->title = $request->title; 
            $updatePost->username = $request->username; 
            $updatePost->introduction = $request->introduction; 
            $updatePost->image = $request->image ? $request->image:$updatePost->image;
        }
        else 
            return response()->json(['status' => 400, 'msg' => 'Bad Request : wrong category']);

        $updatePost->html_content = $request->html_content;
        $updatePost->published_at = $request->published_at?$request->published_at:$updatePost->published_at;

        $updatePost->save();

        return response()->json(['status' => 200, 'msg' => 'the '.substr($category, 0, -1).' id : '.$updatePost->id." updates successfully! "]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movement  $movement
     * @return \Illuminate\Http\Response
     */
    public function destroy($category, $id)
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


        if($category === 'movements')
            $deletePost = Movement::find($id);
        else if($category === 'works')
            $deletePost = Work::find($id);
        else if($category === 'writings')
            $deletePost = Writing::find($id);
        else 
            return response()->json(['status' => 400, 'msg' => 'Bad Request : wrong category']);

        if($deletePost === null) {
            return response()->json(['status' => 404, 'msg' => substr($category, 0, -1).' not exists']);
        }

        //已发布内容
        if($deletePost->published_at != null) {
            if(!($this->department == Department::ZHUXITUAN || $this->department == Department::XIANGMUKAIFABU
                || ($this->department == Department::XUANCHUANBU
                && ($this->position == Position::BUZHANG || $this->position == Position::FUBUZHANG) ))) {
                return response()->json(['status' => 403, 'msg' => 'invalid identity']);
            }
        }

        $deletePost->delete();

        return response()->json(['status' => 200, 'msg' => 'the '.substr($category, 0, -1).' id : '.$deletePost->id.' deletes successfully! ']);

    }


    public function countPost(Request $request, $category)
    {
        // 搜索查看成员 => 主席团&秘书部
        if(!($this->department == Department::ZHUXITUAN 
             || $this->department == Department::MISHUBU 
             || $this->department == Department::XUANCHUANBU 
             || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'invalid identity']);
        }

        if($request->published && $request->draft) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Mixed param.']);
        }else if($request->published) {
            if($category === 'movements')
                return Movement::whereNotNull('published_at')->count();
            else if($category === 'works')
                return Work::whereNotNull('published_at')->count();
            else if($category === 'writings')
                return Writing::whereNotNull('published_at')->count();
            else 
                return response()->json(['status' => 400, 'msg' => 'Bad Request : wrong category']);

        } else if ($request->draft) {
            if($category === 'movements')
                return Movement::whereNull('published_at')->count();
            else if($category === 'works')
                return Work::whereNull('published_at')->count();
            else if($category === 'writings')
                return Writing::whereNull('published_at')->count();
            else 
                return response()->json(['status' => 400, 'msg' => 'Bad Request : wrong category']);

        } else {
            if($category === 'movements')
                return Movement::All()->count();
            else if($category === 'works')
                return Work::All()->count();
            else if($category === 'writings')
                return Writing::All()->count();
            else 
                return response()->json(['status' => 400, 'msg' => 'Bad Request : wrong category']);
        }
    }

    public function showPostsCalendar($category) 
    {
        if(!($this->department == Department::ZHUXITUAN || 
             $this->department == Department::XUANCHUANBU || 
             $this->department == Department::MISHUBU || 
             $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'invalid identity!']);
        }

        $prefix = env('APP_URL') . '/movements/';

        if($category === 'movements')
                $posts = Movement::select('title', 'id',
                     DB::raw('date(published_at) as published_at'),
                     DB::raw('date(created_at) as created_at'))
                ->get();
            else if($category === 'works')
                $posts = Work::select('job', 'id',
                     DB::raw('date(published_at) as published_at'),
                     DB::raw('date(created_at) as created_at'))
                ->get();
            else if($category === 'writings')
                $posts = Writing::select('title', 'username', 'id',
                         DB::raw('date(published_at) as published_at'),
                         DB::raw('date(created_at) as created_at'))
                ->get();
            else 
                return response()->json(['status' => 400, 'msg' => 'Bad Request : wrong category']);

        

        foreach($posts as $p) {
            if($p->published_at == null) {
                $p->description = 'draft';
                $p->start = $p->created_at;
                $p->backgroundColor = '#689F38';
            } else {
                $p->description = 'published';
                $p->start = $p->published_at;
                $p->backgroundColor = '#303F9F';
            }
            $p->url = $prefix . $p->id;
        }

        return $posts;
    }


    private function incrementView(Movement $p) {
        if($p->published_at){
            $p->view++;
            $p->save();
        }
        return $p;
    }


}
