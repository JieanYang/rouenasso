<?php

namespace App\Http\Controllers;

use App\LeaveMessage;
use Illuminate\Http\Request;

class LeaveMessageController extends Controller
{
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
        return view('404');
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
    public function destroy(LeaveMessage $leaveMessage)
    {
        return view('404');
    }
}
