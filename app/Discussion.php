<?php

namespace LaravelForum;

use LaravelForum\Reply;
use LaravelForum\Channel;
use LaravelForum\Watcher;
use Illuminate\Support\Facades\Auth;
use LaravelForum\Notifications\ReplyMarkedAsBestReply;

class Discussion extends Model
{
    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    public function author(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function getRouteKeyName(){
        return 'slug';
    }

    // public function getBestReply(){
    //     return Reply::find($this->reply_id);
    // }

    public function getBestReply(){
        return $this->belongsTo(Reply::class, 'reply_id');
    }

    public function scopeFilterByChannels($builder){
       
        if (request()->query('channel')){
            $channel = Channel::where('slug',request()->query('channel'))->first();
        
            if ($channel){
                return $builder->where('channel_id', $channel->id);
            }
            return $builder;
        }  
        return $builder;
    }

    public function markAsBestReply(Reply $reply){
        $this->update([
            'reply_id' => $reply->id
        ]);
        if ($reply->owner->id==$this->author->id){
            return;
        }    
        $reply->owner->notify(new ReplyMarkedAsBestReply($reply->discussion));
    }
    public function channel(){
        return $this->belongsTo(Channel::class);
    }

    public function watchers(){
        return $this->hasMany(Watcher::class);
    }

    public function is_being_watched_by_auth_user(){
        $id = Auth::id();
        $watchers_ids = array();
        foreach ($this->watchers as $watcher):
            array_push($watchers_ids,$watcher->user_id);
        endforeach;            
        if (in_array($id, $watchers_ids)){
            return true;
        }
        else{
            return false;
        }
    }
   
}
