<?php

namespace LaravelForum\Http\Controllers;

use LaravelForum\User;
use LaravelForum\Reply;
use Illuminate\Http\Request;
use LaravelForum\Discussion;
use LaravelForum\Http\Requests\CreateDiscussionRequest;

class DiscussionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    public function __construct(){
        $this->middleware(['auth','verified'])->only(['create','store']);
    }
    public function index()
    {
        //filterByChannels() is a query scope which is defined in the Discussion class.

        return view('discussions.index', [
            'discussions' => Discussion::filterByChannels()->paginate(3)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('discussions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDiscussionRequest $request)
    {
        // need to have has many relationships....
        auth()->user()->discussions()->create([
            'title'     =>  $request->title,
            'slug'      =>  str_slug($request->title),
            'content'   =>  $request->content,
            'channel_id'   =>  $request->channel
        ]);
        session()->flash('success', 'Discussion Posted');    
        return redirect()->route('discussions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Discussion $discussion)
    {
       return view('discussions.show',[
            'discussion'    => $discussion
       ]);
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
    public function reply(Discussion $discussion, Reply $reply){
        $discussion->markAsBestReply($reply);

        // send a notification, each time a reply  is added to the watched discussion..
       
        
        session()->flash('success', 'Marked as best reply.');
        return redirect()->back();
    }
}
