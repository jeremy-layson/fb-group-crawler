<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    protected $hidden = ['created_at', 'updated_at'];

    public function kickable()
    {
        $period = Carbon::now()->subMonths(3);

        return $this
            ->whereDate('join_date', '<', $period->format('Y-m-d'))
            ->where('activity', '=', 'unprocessed')
            ->where('kicked', '=', '0')
            ->orderBy('join_date')->paginate(100);
    }

    public function kickList()
    {
        return $this
            ->where('activity', '=', 'remove')
            ->where('kicked', '=', '0')
            ->orderBy('updated_at')
            ->get();
    }

    public function getQueryAttribute()
    {
        return urlencode($this->member_name);
    }

    public function findMember($name)
    {
        return $this->where('member_name', $name)->get()->first();
    }
}
