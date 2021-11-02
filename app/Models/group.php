<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    use HasFactory;
    protected $guarded = [];
// get Subscribers from group_participant according join to Models\User   
   public function participants()
    {
        return $this->belongsToMany('App\Models\User', 'group_participants', 'group_id', 'user_id');
    }
}
