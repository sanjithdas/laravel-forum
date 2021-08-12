<?php

namespace LaravelForum;

use LaravelForum\Reply;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['reply_id','user_id'];

    public function reply(){
        return $this->belongsTo(Reply::class);
    }

    // person who like this reply

    public function user(){
        return $this->belongsTo(User::Class);
    }
}
