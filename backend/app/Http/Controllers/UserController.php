<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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
     * Deprecated. Use post /user instead
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * GET /users/{user.id}
     * 
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
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

    }

    /**
     * POST /users/{user.id}
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {

        error_log('in');
        
        $userDb <- User::where('id', $request -> input('id'))
                    ->get();

        if ($userDb === null) {
            return 'User not exists';
        }



        $user->isAvaible = $request->input('isAvaible');
        $user->dimission_date = $request->input('dimission_date');
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
