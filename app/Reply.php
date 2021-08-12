<?php

namespace LaravelForum;

use LaravelForum\Like;
use LaravelForum\User;
use LaravelForum\Discussion;
use Illuminate\Support\Facades\Auth;

class Reply extends Model
{
    public function owner(){
        return ($this->belongsTo(User::class,'user_id'));
    }
    public function discussion(){
        return($this->belongsTo(Discussion::class));
    }
    // reply has many likes
    public function likes(){
        return $this->hasMany(Like::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    // to check the auth user is already liked or not....
    public function is_liked_by_auth_user(){
     
        $id = Auth::id();

        $likers = array();

        foreach ($this->likes as $like):
            array_push($likers, $like->user_id);
        endforeach;

        if (in_array($id, $likers)){
            return true;
        }
        else{
            return false;
        }
   
    }
}
