<?php

namespace App\Http\Controllers;

use App\ViewLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewLogController extends Controller
{
    public function __construct() {
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
}
