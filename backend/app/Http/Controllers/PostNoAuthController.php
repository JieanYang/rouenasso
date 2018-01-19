<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Storage;
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
        $postsCount = Post::where([['category', $category_id], ['published_at', '!=', null]])
            ->whereNull('deleted_at')->get()->count();
        
        if($count){
            $result = response()->json(['category' => $category_id, 'count' => $postsCount]);
        } 
        
        else if($split) {
            $offset = $request->offset ? intval($request->offset) : 0;
            $length = $request->length ? intval($request->length) : intval($postsCount);
            $result = Post::where
                           ([
                                ['category', $category_id], 
                                ['published_at', '!=', null]
                            ])
                            ->whereNull('deleted_at')
                            ->orderBy('published_at', 'desc')
                            ->get();
        } 
        
        else if($latest) {
            $result = Post::where('category', $category_id)
                ->whereNull('deleted_at')->orderBy('published_at', 'desc')->first();
        } 
        
        else {
        // all
            $result = Post::where([['category', $category_id], ['published_at', '!=', null]])
                ->orderBy('published_at', 'desc')
                ->whereNull('deleted_at')->get();
        }
        
        // hide html content
        if(!($count || $latest)){
            foreach($result as $p){
                $p->setHidden(['html_content']);
            };
            
            if($split) {
                $result = array_slice($result->toArray(), $offset, $length);
            }
        }
        return $result;
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
                        Response()->json(['status' => 400, 'msg' => '不返回草稿, bad request'])
                    ) : Response()->json(['status' => 404, 'msg' => 'Post not found.']);
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

    /**
     * GET /downloadimg/
     *
     * Download an image
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function retrieveImg(Request $request) {
        $url = $request->url;
        $content = Storage::get($url);
        $mimetype = Storage::mimeType($url);
        error_log($mimetype);

        return Storage::exists($url) ? 
            response($content, 200)
                  ->header('Content-Type', $mimetype)
            : 
            response()->json(['status' => 404, 'msg' => 'file not found'], 404);
    }
}
