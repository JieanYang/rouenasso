<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\Model\Department;
use App\Model\Position;
use Illuminate\Support\Facades\Auth;
use App\Createlink;
use Carbon\Carbon;

class UserController extends Controller
{
    private $department;
    private $position;

    public function __construct()
    {
        $this->middleware('auth.basic.once', ['except' => ['store', 'countUser']]);

        $this->middleware(function ($request, $next) {
            $this->department = Auth::user() ? Auth::user()->department : null;
            $this->position = Auth::user() ? Auth::user()->position : null;
            return $next($request);
        })->except('store');
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
        if(!($this->department == Department::ZHUXITUAN
             || $this->department == Department::MISHUBU || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden'], 403);
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
    public function store(Request $request, string $link)
    {
        //尝试加入搜索link功能,如果找到可以注册，找不到返回一个错误
        $searchlink = Createlink::find($link);
        if($searchlink == null) {
            return response()->json(['status' => 400, 'msg' => 'Invalid token!'], 400);
        }
        //比较当前注册时间与数据库中expires过期时间，如果大于，不允许注册，链接失效
        $expires = (Createlink::find($link)->expires);
        $expires_time = (date_parse_from_format("y-m-d H:i:s",$expires));


        $now = Carbon::now();
        $now_time = (date_parse_from_format("y-m-d H:i:s",$now));

        if($expires_time<($now_time)){
          return response()->json(['status' => 400, 'msg' => 'Link times out!'], 400);
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
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.'], 400);
        }

        // 搜索查看成员 => 主席团&秘书部
        if(!($this->department == Department::ZHUXITUAN
             || $this->department == Department::MISHUBU || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden'], 403);
        }

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
    public function update(Request $request, $id)
    {
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.'], 400);
        }

        // 修改成员 => 主席团&秘书部部长&秘书部副部长
        if(!($this->$department == Department::ZHUXITUAN ||
             $this->department == Department::XIANGMUKAIFABU ||
            ($this->$department == Department::MISHUBU &&
                ($this->position == Position::BUZHANG || $this->position == Position::FUBUZHANG)))) {
            return response()->json(['status' => 403, 'msg' => 'forbidden'], 403);
        }

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
            return response()->json(['status' => 400, 'msg' => 'User not exists'], 403);
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
    public function destroy($user_id)
    {
        if(!ctype_digit($user_id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.'], 400);
        }

        // 删除 => 主席团&秘书部部长&秘书部副部长
        if(!($this->department == Department::ZHUXITUAN ||
            $this->department == Department::XIANGMUKAIFABU ||
            ($this->department == Department::MISHUBU &&
                ($this->position == Position::BUZHANG || $this->position == Position::FUBUZHANG)))) {
            return response()->json(['status' => 403, 'msg' => 'forbidden'], 403);
        }

        $userDel = User::find($user_id);

        if ($userDel === null) {
            return response()->json(['status' => 400, 'msg' => 'User not exists'], 403);
        }
        if ($userDel->id === $user_id) {
            return response()->json(['status' => 400, 'msg' => 'You can not delete your self'], 400);
        }

        $userDel->delete();

        return response()->json(['status' => 200, 'msg' => 'success']);
    }

    /**
     * GET /users/count/show
     *
     * count user
     *
     * @return \Illuminate\Http\Response
     */
    public function countUser()
    {
        // 搜索查看成员 => 主席团&秘书部
        if(!($this->department == Department::ZHUXITUAN
             || $this->department == Department::MISHUBU
             || $this->department == Department::XUANCHUANBU
             || $this->department == Department::XIANGMUKAIFABU)) {
            return response()->json(['status' => 403, 'msg' => 'forbidden'], 403);
        }

        return User::All()->count();
    }

    /**
     * GET /users/{user.id}/posts
     *
     * Get all post of a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function showPostsByUserId($id) {
        if(!ctype_digit($id)) {
            return response()->json(['status' => 400, 'msg' => 'Bad Request. Invalid input.'], 400);
        }

        $result = User::find($id)->posts()->get();
        foreach($result as $p){
            $p->setHidden(['html_content']);
        };
        return $result;
    }
}
