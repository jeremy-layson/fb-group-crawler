<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'fb_group_id',
        'fb_member_id',
        'member_name',
        'activity',
        'kicked',
        'join_date'
    ];
}
