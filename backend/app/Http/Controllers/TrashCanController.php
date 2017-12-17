<?php

namespace App\Http\Controllers;

use Validator;
use App\Post;
// use App\LeaveMessage;
use App\Model\Department;
use App\Model\Position;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrashCanController extends Controller
{
    private $department;
    private $position;

    public function __construct() {
        $this->middleware('auth.basic.once');

        $this->middleware(function ($request, $next) {	
            $this->department = Auth::user() ? Auth::user()->department : null;
            $this->position = Auth::user() ? Auth::user()->position : null;
            return $next($request);
        });
    }

    public function index()
    {
    	return Post::onlyTrashed()->get();
    }

    public function show($id)
    {   
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.']);
        }

        $showPost = Post::onlyTrashed()->find($id);
        return $showPost? $showPost: Response()->json(['status' => 404, 'msg' => 'Not found']);
    }

    public function restore($id)
    {
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.']);
        }

        $restorePost = Post::onlyTrashed()->find($id);
        if(!$restorePost){
            return Response()->json(['status' => 404, 'msg' => 'Not found']);
        }
        else{
            $restorePost->restore();
            return response()->json(['status' => 200, 'msg' => 'success']);
        }
    }

    public function forceDelete($id)
    {
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.']);
        }

        //验证部门 宣传部、主席团和项目开发部
        if(!($this->department == Department::ZHUXITUAN 
             || $this->department == Department::XUANCHUANBU || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'Bad identification!'], 403);
        }

        $postForceDel = Post::onlyTrashed()->find($id);

        if(!$postForceDel){
            return Response()->json(['status' => 404, 'msg' => 'Not found']);
        }else{
            $postForceDel->forceDelete();
            return response()->json(['status' => 200, 'msg' => 'Post '.$id.' force delete successfully!']);
        }
        
    }
}
