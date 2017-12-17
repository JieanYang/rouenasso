<?php

namespace App\Http\Controllers;

use App\Createlink;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Model\Department;
use App\Model\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class CreatelinkController extends Controller
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

    public function index()
    {
        return Createlink::All();
    }

    public function store(Request $request)
    {
        if(!($this->department == Department::ZHUXITUAN || $this->department == Department::XUANCHUANBU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden'], 403);
        }
        // $validator = Validator::make($request->all(), [
        //     // 'user_id' => 'required|integer',
        //     // 'link' => 'required',
        // ]);
        //
        // if ($validator->fails()) {
        //     return $validator->errors();
        // }  //暂不需要validator进行输入验证
        $createlink =new Createlink;
        $createlink->user_id = Auth::user()->id; //自动获取用户id
        $createlink->link = str_random(30); //自动生成30位字符token
        //增加链接过期时间
        $createlink->expires=Carbon::now()->addHours(1);


        $createlink->save();
        return response()->json(['status' => 200, 'msg' => 'success']);
    }
}
