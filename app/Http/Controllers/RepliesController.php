<?php

namespace LaravelForum\Http\Controllers;

use Session;
use LaravelForum\Like;
use LaravelForum\User;
use LaravelForum\Reply;
use Illuminate\Http\Request;
use LaravelForum\Discussion;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification;
use LaravelForum\Notifications\NewReplyAdded;
use LaravelForum\Http\Requests\CreateReplyRequest;

class RepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReplyRequest $request, Discussion $discussion)
    {
        // store the replies into the db.
        auth()->user()->replies()->create([
                'discussion_id' => $discussion->id,
                'reply' => $request->reply
            ]);
          //  dd()
        if ($discussion->author->id!=auth()->user()->id){
           $discussion->author->notify(new NewReplyAdded($discussion));      
        }   
        $watchers = array();
       // dd($discussion->watchers);
        foreach($discussion->watchers as $watcher):
            array_push($watchers,User::find($watcher->user_id));
        endforeach;

        // to send notifications to multiple users , use the Notification facade
        //dd($watchers);
        Notification::send($watchers, new NewReplyAdded($discussion));

        session()->flash('success','Reply Added'); 
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function like($id){
      
        Like::create([
            'reply_id' => $id,
            'user_id' => Auth::id()
        ]);
        Session::flash('success', 'You liked the reply');
        return redirect()->back();
    }
    public function unlike($reply_id){
        $like = Like::where('reply_id',$reply_id)->where('user_id', Auth::id())->first();
        $like->delete();
        Session::flash('success', 'You unliked the reply');
        return redirect()->back();
    }
}
