<?php

namespace App\Http\Controllers;

use App\ViewLog;
use App\Model\Department;
use App\Model\Position;
use DatePeriod;
use DateTime;
use DateInterval;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    /**
     * Get given day's view count
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function getHistoryCount(Request $request) {
        if(!($this->department == Department::ZHUXITUAN
             || $this->department == Department::XUANCHUANBU
             || $this->department == Department::MISHUBU
             || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden'], 403);
        }

        $start = $request->start;
        $end = $request->end;

        if(!($start && $end)) {
            return response()->json(['status' => 400, 'msg' => 'Bad input, param incorrect'], 400);
        }

        // generate all date in period
        $period = new DatePeriod(
             new DateTime($start),
             new DateInterval('P1D'),
             (new DateTime($end))->modify('+1 day') // end not included
        );

        // get visit logs from db
        $logs = DB::table('viewlogs')->select(DB::raw('date(created_at) as date'), DB::raw('count(*) as count'))->where(
            [['created_at', '>=', $start],['created_at', '<=', $end]]
        )->groupBy('created_at')->get();

        // get all available dates in logs
        $logDates = Array();
        foreach($logs as $obj) {
             array_push($logDates, $obj->date);
        }

        // add 0 visit for those no-data-date
        foreach ($period as $date) {
            $date_str = $date->format('Y-m-d');
            if(!in_array($date_str, $logDates)) {
              $logs->push(['date' => $date_str, 'count' => 0]);
            }
        }

        return $logs;
    }
}
