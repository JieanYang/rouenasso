<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * GET /user
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::All();
    }

    /**
     * GET /users/create
     * 
     * Deprecated.  Use post /user instead
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('404');
    }

    /**
     * Post /users
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users|max:255',
            'name' => 'required|max:100',
            'department' => 'required|max:100',
            'position' => 'required|max:100',
            'school' => 'required|max:100',
            'phone_number' => 'required|digits_between:10,15',
            'birthday' => 'required|date',
            'arrive_date' => 'required|date',
            'password' => 'required'
        ]);
        // 验证失败自动返回错误

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->department = $request->department;
        $user->position = $request->position;
        $user->school = $request->school;
        $user->phone_number = $request->phone_number;
        $user->birthday = $request->birthday;
        $user->arrive_date = $request->arrive_date;
        $user->password = $request->password;

        $user->isWorking = True;
        $user->isAvaible = True;
        
        $user->save();

        return 'ok';
    }

    /**
     * GET /users/{user.id}
     * 
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::where('id', $id)
                    ->get();
    }

    /**
     * Deprecated.
     * Use POST /users instead
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('404');
    }

    /**
     * POST /users/{user.id}
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        
        $userDb = User::find($id);

        if ($userDb === null) {
            return 'User not exists';
        }

        if($request->name) {
            $userDb->name = $request->name;
        }
        if($request->email) {
            $userDb->email = $request->email;
        }
        if($request->department) {
            $userDb->department = $request->department;
        }
        if($request->position) {
            $userDb->position = $request->position;
        }
        if($request->school) {
            $userDb->school = $request->school;
        }
        if($request->phone_number) {
            $userDb->phone_number = $request->phone_number;
        }
        if($request->birthday) {
            $userDb->birthday = $request->birthday;
        }
        if($request->arrive_date) {
            $userDb->arrive_date = $request->arrive_date;
        }
        if($request->password) {
            $userDb->password = $request->password;
        }
        if($request->isWorking) {
            $userDb->isWorking = $request->isWorking;
        }
        if($request->isAvaible) {
            $userDb->isAvaible = $request->isAvaible;
        }
        if($request->dimission_date) {
            $userDb->dimission_date = $request->dimission_date;
        }


        error_log($userDb);

        $userDb->save();

        return 'ok';
    }

    /**
     * Deprecated.
     * Not allowed
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        
    }
}
