<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth;

class GetSelfController extends Controller
{
    /**
     * GET /login
     *
     * Return logged in user
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function getSelf()
    {
        return Auth::user();
    }
}