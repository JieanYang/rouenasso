<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
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
        $post->published_at = date("Y-m-d H:i:s");

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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'catagory' => 'required|integer',
            'html_content' => 'required'
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
        $postDel = Post::find($id);

        if($postDel === null) {
            return response()->json(['status' => 500, 'msg' => 'Post not exists']);
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
