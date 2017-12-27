<?php

namespace App\Http\Controllers;

use App\Createlink;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Model\Department;
use App\Model\Position;
use Illuminate\Support\Facades\Auth;
//一小时过期
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


        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required|integer',
            // 'link' => 'required',
            'department' => [
            	'required',
            	Rule::in(\App\Model\Department::getKeys()),
            ],
            'position' => [
            	'required',
            	Rule::in(\App\Model\Position::getKeys()),
            ],
        ]);
        
        if ($validator->fails()) {
            return $validator->errors();
        }

        $array_key_department = \App\Model\Department::getKeys();
        $array_value_department = \App\Model\Department::getValues();
    	for($x=0;$x<count($array_key_department);$x++){
    		if ($array_key_department[$x] == $request->department){
    			$request->department = $array_value_department[$x];
    		}
    	}
    	$array_key_position = \App\Model\Position::getKeys();
        $array_value_position = \App\Model\Position::getValues();
    	for($x=0;$x<count($array_key_position);$x++){
    		if ($array_key_position[$x] == $request->position){
    			$request->position = $array_value_position[$x];
    		}
    	}


        $createlink =new Createlink;
        $createlink->user_id = Auth::user()->id; //自动获取用户id
        // $createlink->link = $request->link;//手动写token
        $createlink->department = $request->department;
        $createlink->position = $request->position;
        $createlink->link = str_random(30); //自动生成30位字符token
        //增加链接过期时间
        $createlink->expires=Carbon::now()->addHours(1);


        $createlink->save();
        return response()->json(['status' => 200, 'msg' => 'success']);
    }
}
