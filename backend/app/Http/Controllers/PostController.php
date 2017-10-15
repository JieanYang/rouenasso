<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Model\Department;
use App\Model\Position;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $department;
    private $position;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->department = Auth::user()->department;
            $this->position = Auth::user()->position;

            return $next($request);
        });
    }

    /**
     * GET /posts
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::All();
    }

    /**
     * GET /posts/create
     * 
     * Deprecated.  Use POST /post instead
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('404');
    }

    /**
     * POST /posts
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 新增内容 => 主席团&宣传部
        if(!($this->department == Department::ZHUXITUAN || $this->department == Department::XUANCHUANBU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden']);
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'catagory' => 'required|integer',
            'user_id' => 'required|integer',
            'html_content' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        

        $post = new Post;

        $post->title = $request->title;
        $post->catagory = $request->catagory;
        $post->user_id = $request->user_id;
        $post->html_content = $request->html_content;
        $post->published_at = $request->published_at;

        $post->save();

        return response()->json(['status' => 200, 'msg' => 'success']);
    }

    /**
     * GET /posts/{post.id}
     * 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::where('id', $id)
                    ->get();
    }

    /**
     * GET /posts/{post}/edit
     *
     * Deprecated.
     * Use POST /posts instead

     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('404');
    }

    /**
     * PUT/PATCH /users/{user.id}
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 修改草稿 => 主席团&宣传部
        if(!($this->department == Department::ZHUXITUAN || $this->department == Department::XUANCHUANBU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden']);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'catagory' => 'required|integer',
            'html_content' => 'required'
            'published_at' => 'date'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        
        $postDB = Post::find($id);

        if($postDB === null) {
            return response()->json(['status' => 500, 'msg' => 'Post not exists']);
        }

        $postDB->title = $request->title;
        $postDB->catagory = $request->catagory;
        $postDB->html_content = $request->html_content;

        $postDB->save();

        return response()->json(['status' => 200, 'msg' => 'success']);
    }

    /**
     * DELETE /posts/{post.id}
     *
     * Soft delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 删除内容 => 主席团&宣传部部长&宣传部副部长
        // 删除草稿 => 主席团&宣传部
        if(!($this->department == Department::ZHUXITUAN || $this->department == Department::XUANCHUANBU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden']);
        }

        $postDel = Post::find($id);

        if($postDel === null) {
            return response()->json(['status' => 500, 'msg' => 'Post not exists']);
        }

        if($postDel->published_at != null) { // 已发布 非草稿
            if(!($this->department == Department::ZHUXITUAN || ($this->department == Department::XUANCHUANBU
                && ($this->position == Position::BUZHANG || $this->position == Position::FUBUZHANG) ))) {
                return response()->json(['status' => 403, 'msg' => 'forbidden']);
            }
        }

        $postDel->delete();

        return response()->json(['status' => 200, 'msg' => 'success']);
    }


    /**
     * GET /posts/catagory/{catagory.id}
     *
     * Get all posts of a given catagory.
     *
     * @param  int  $catagory_id
     * @return \Illuminate\Http\Response
     */
    public function showPostsByCatagoryId(int $catagory_id)
    {
        return Post::where('catagory', $catagory_id)->get();
    }

}
