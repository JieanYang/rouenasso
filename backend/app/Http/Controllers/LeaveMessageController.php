<?php

namespace App\Http\Controllers;

use App\LeaveMessage;
use Illuminate\Http\Request;

// 表单验证
use Validator;
use Illuminate\Validation\Rule;

// 身份验证
use Illuminate\Support\Facades\Auth;
use App\Model\Department;
// use App\Model\Position;

class LeaveMessageController extends Controller
{



    public function __construct() {

        $this->middleware('auth.basic.once')->except('store');

        $this->middleware(function ($request, $next) {
            $this->department = Auth::user() ? Auth::user()->department : null;
            // $this->position = Auth::user() ? Auth::user()->position : null;
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
        return LeaveMessage::All();
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
        $validator = Validator::make($request->all(), [
            'name_leaveMessage' => 'required',
            'phone_leaveMessage' => 'required',
            'email_leaveMessage' => 'required',
            'agreeContact_leaveMessage' => 'required',
            'contactWay_leaveMessage' => Rule::in(['phone', 'email', null]),
            'message_leaveMessage' => 'required'
        ]);

        if($validator -> fails()) {
            return $validator -> errors();
        }

        $leaveMessage = new LeaveMessage;

        $leaveMessage->name_leaveMessage = $request->name_leaveMessage;
        $leaveMessage->phone_leaveMessage = $request->phone_leaveMessage;
        $leaveMessage->email_leaveMessage = $request->email_leaveMessage;
        $leaveMessage->agreeContact_leaveMessage = $request->agreeContact_leaveMessage;
        $leaveMessage->contactWay_leaveMessage = $request->contactWay_leaveMessage;
        $leaveMessage->message_leaveMessage = $request->message_leaveMessage;

        $leaveMessage->save();
        error_log(env('APP_URL'));
        return response()->json(['status' => 200, 'msg' => 'success', 'id' => $leaveMessage->id, 
                                'url' => env('APP_URL') . '/leaveMessages/' . $leaveMessage->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LeaveMessage  $leaveMessage
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return LeaveMessage::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LeaveMessage  $leaveMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveMessage $leaveMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LeaveMessage  $leaveMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeaveMessage $leaveMessage)
    {
        return view('404');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LeaveMessage  $leaveMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.'], 400);
        }


        if(!($this->department == Department::ZHUXITUAN 
             || $this->department == Department::XUANCHUANBU || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'invalid Authentication'], 403);
        }

        $leaveMessagesDel = LeaveMessage::find($id);

        if($leaveMessagesDel === null) {
            return response()->json(['status' => 400, 'msg' => 'LeaveMessage not exists'], 400);
        }

        $leaveMessagesDel->delete();

        return response()->json(['status' => 200, 'msg' => 'success for delete leaveMessage id : '.$id]);


    }
}
