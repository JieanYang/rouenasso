<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Model\Department;
use App\Model\Position;
use Illuminate\Support\Facades\Auth;

class PostNoAuthController extends Controller
{
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
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.'], 400);
        }
        
        $count = $request->count;
        $split = $request->split;
        $latest = $request->latest;
        
        $paramCount = 0;
        if($count){ $paramCount++; }
        if($split){ $paramCount++; }
        if($latest){ $paramCount++; }
        if($paramCount > 1) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Mixed params.'], 400);
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
     * GET /posts/{post.id}
     * 
     * return the post with the given id but must be publishedm, return 404 if not found or is draft.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function showPost($id)
    {
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.'], 400);
        }
        
        $p = Post::find($id);
        
        return $p ? (
                        $p->published_at ? $this->incrementView($p)
                        :
                        Response()->json(['status' => 404, 'msg' => 'Post not found.'], 400)
                    ) : Response()->json(['status' => 404, 'msg' => 'Post not found.'], 404);
    }

    /**
     * increment View times of a post
     *
     * @param  $id post id
     * @return \Illuminate\Http\Response
     */
    private function incrementView(Post $p) {
        $p->view++;
        $p->save();
        return $p;
    }
}
