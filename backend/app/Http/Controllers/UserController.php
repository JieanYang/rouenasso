<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Model\Department;
use App\Model\Position;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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

    /**
     * GET /users
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 搜索查看成员 => 主席团&秘书部
        if(!($this->department == Department::ZHUXITUAN || $this->department == Department::MISHUBU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden']);
        }
        return User::All();
    }

    /**
     * GET /users/create
     * 
     * Deprecated.  Use POST /user instead
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('404');
    }

    /**
     * POST /users
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 新增成员 => 主席团&秘书部
        if(!($this->$department == Department::ZHUXITUAN || $this->$department == Department::MISHUBU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden']);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|max:255',
            'name' => 'required|max:100',
            'department' => 'required|in:' . implode(",", \App\Model\Department::getValues()),
            'position' => 'required|in:' . implode(",", \App\Model\Position::getValues()),
            'school' => 'required|max:100',
            'phone_number' => 'required|digits_between:10,15',
            'birthday' => 'required|date',
            'arrive_date' => 'required|date',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        

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

        return response()->json(['status' => 200, 'msg' => 'success']);
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
     * GET /users/{user}/edit
     *
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
     * PUT/PATCH /users/{user.id}
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {   
        $messages = [
            'boolean' =>  'The :attribute field must be 1 or 0.',
        ];

        $validator = Validator::make($request->all(), [
            'email' => [
                'max:100',
                Rule::unique('users')->ignore($id),
            ],
            'name' => 'max:100',
            'department' => 'in:' . implode(",", \App\Model\Department::getValues()),
            'position' => 'in:' . implode(",", \App\Model\Position::getValues()),
            'school' => 'max:100',
            'phone_number' => 'digits_between:10,15',
            'birthday' => 'date',
            'arrive_date' => 'date',
            'dimission_date' => 'date',
            'isAvaible' => 'boolean',
            'isWorking' => 'boolean'
        ], 
        $messages);

        if ($validator->fails()) {
            return $validator->errors();
        }
        
        
        $userDb = User::find($id);

        if ($userDb === null) {
            return response()->json(['status' => 500, 'msg' => 'User not exists']);
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

        $userDb->save();

        return response()->json(['status' => 200, 'msg' => 'success']);
    }

    /**
     * DELETE /users/{user_id}
     *
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user_id)
    {
        $userDel = User::find($id);

        if ($userDel === null) {
            return response()->json(['status' => 500, 'msg' => 'User not exists']);
        }

        $userDel->delete();
        
        return response()->json(['status' => 200, 'msg' => 'success']);
    }

    /**
     * GET /users/{user.id}/posts
     *
     * Get all post of a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPostsByUserId(int $id) {
        return User::find($id)->posts()->get();
    }
}
