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
            $this->department = Auth::user() ? Auth::user()->department : null;
            $this->position = Auth::user() ? Auth::user()->position : null;
            return $next($request);
        }, ['except' => ['index', 'showPostsBycategoryId']]);
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
            'category' => 'required|integer',
            'user_id' => 'required|integer',
            'html_content' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        

        $post = new Post;

        $post->title = $request->title;
        $post->category = $request->category;
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
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.']);
        }
        
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
     * @param  $id
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
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.']);
        }
        
        // 修改草稿 => 主席团&宣传部
        if(!($this->department == Department::ZHUXITUAN || $this->department == Department::XUANCHUANBU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden']);
        }
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category' => 'required|integer',
            'html_content' => 'required',
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
        $postDB->category = $request->category;
        $postDB->html_content = $request->html_content;

        $postDB->save();

        return response()->json(['status' => 200, 'msg' => 'success']);
    }

    /**
     * DELETE /posts/{post.id}
     *
     * Soft delete the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.']);
        }
        
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
     * GET /posts/category/{category.id}
     *
     * Get all or apart or latest post(s) of a given category, or count number of post of a category
     *
     * @param  $category_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showPostsBycategoryId(Request $request, $category_id)
    {
        if(!ctype_digit($category_id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.']);
        }
        
        $count = $request->count;
        $split = $request->split;
        $latest = $request->latest;
        
        $paramCount = 0;
        if($count){ $paramCount++; }
        if($split){ $paramCount++; }
        if($latest){ $paramCount++; }
        if($paramCount > 1) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Mixed params.']);
        }
        
        // count
        $postsCount = 0;
        $postsCount = Post::where([['category', $category_id], ['published_at', '!=', null]])->get()->count();
        
        if($count){
            return response()->json(['category' => $category_id, 'count' => $postsCount]);
        }
        
        // split
        if($split) {
            $offset = $request->offset ? intval($request->offset) : 0;
            $length = $request->length ? intval($request->length) : intval($postsCount);
            return array_slice(Post::where
                           ([
                                ['category', $category_id], 
                                ['published_at', '!=', null]
                            ])
                           ->get()
                           ->toArray(), $offset, $length);
        }
        
        // latest
        if($latest) {
            return Post::where('category', $category_id)->orderBy('published_at', 'desc')->first();
        }
        
        // all
        return Post::where([['category', $category_id], ['published_at', '!=', null]])->get();
    }
    
    /**
     * GET /posts/category/{category.id}/drafts
     *
     * Get all draft of a given category
     *
     * @param  $category_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showDraftsByCategoryId(Request $request, $category_id) {
        // 草稿 => 主席团&宣传部
        if(!($this->department == Department::ZHUXITUAN || $this->department == Department::XUANCHUANBU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden']);
        }
        return Post::where([['category', $category_id], ['published_at', '=', null]])->get();
    }

}
