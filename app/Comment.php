<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $hidden = array('hided','secret','user_id','zone_id','location_id','reported');

    // dateTime -> timestamp
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function poster()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function opinion()
    {
        return $this->belongsTo(Likes::class,'user_id');
    }
}
