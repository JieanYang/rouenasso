<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'department', 'position', 'birthday', 'school', 'phone_number', 
        'isWorking', 'isAvaible', 'arrive_date', 'dimission_date'
    ];
    
    /**
     * Sofe deleted date
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * Get the posts belongs to the user.
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    public function movements()
    {
        return $this->hasMany('App\Movement');
    }
    public function works()
    {
        return $this->hasMany('App\Work');
    }
    public function writings()
    {
        return $this->hasMany('App\Writing');
    }
}
