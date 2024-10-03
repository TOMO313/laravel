<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedByAuthUser():bool
    {
        $authUserId = Auth::id();

        $likesArray = array();

        foreach($this->likes as $postlike){
            array_push($likesArray, $postlike->user_id);
        }

        if(in_array($authUserId, $likesArray)){
            return true;
        }else{
            return false;
        }
    }
}
