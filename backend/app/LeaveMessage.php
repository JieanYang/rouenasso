<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveMessage extends Model
{
	protected $table = 'leaveMessages';

    use SoftDeletes;

    protected $fillable=[ 'name_leaveMessage', 'phone_leaveMessage', 'email_leaveMessage', 'agreeContact_leaveMessage', 'contactWay_leaveMessage', 'message_leaveMessage'];

    // sofe deleted date 
    protected $dates = ['deleted_at'];
}
