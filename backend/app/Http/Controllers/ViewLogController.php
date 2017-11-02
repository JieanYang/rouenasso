<?php

namespace App\Http\Controllers;

use App\ViewLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Model\Department;
use App\Model\Position;

class ViewLogController extends Controller
{
    private $department;
    private $position;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->department = Auth::user() ? Auth::user()->department : null;
            $this->position = Auth::user() ? Auth::user()->position : null;
            return $next($request);
        }, ['except' => 'addLog']);
    }

    /**
     * increment View times of a post
     *
     * @param  $id post id
     * @return \Illuminate\Http\Response
     */
    public function addLog(Request $request) {
        $vl = new ViewLog;
        $vl->ip = $request->ip();
        $vl->user = $request->user;
        $vl->save();
    }
    
    /**
     * Get today's view count
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodayCount() {
        if(!($this->department == Department::ZHUXITUAN 
             || $this->department == Department::XUANCHUANBU 
             || $this->department == Department::MISHUBU 
             || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden'], 403);
        }
        
        return ViewLog::whereDate('created_at', '=', Carbon::today()->toDateString())->count();
    }
    
    /**
     * Get today's view count
     *
     * @return \Illuminate\Http\Response
     */
    public function getToday() {
        if(!($this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden'], 403);
        }
        return ViewLog::whereDate('created_at', '=', Carbon::today()->toDateString())->get();
    }
    
    /**
     * Get given day's view count
     *
     * @param  string $date date str in Y-M-D
     * @return \Illuminate\Http\Response
     */
    public function getOneDayCount(string $date) {
        if(!($this->department == Department::ZHUXITUAN 
             || $this->department == Department::XUANCHUANBU 
             || $this->department == Department::MISHUBU 
             || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden'], 403);
        }
        return ViewLog::whereDate('created_at', '=', date($date))->count();
    }
    
    /**
     * Get given day's view count
     *
     * @param  string $date date str in Y-M-D
     * @return \Illuminate\Http\Response
     */
    public function getOneDay(string $date) {
        if(!($this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden'], 403);
        }
        return ViewLog::whereDate('created_at', '=', date($date))->get();
    }
}
