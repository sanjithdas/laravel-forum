@extends('layouts.app')

@section('content')
<div class="card">
    <?php
        $page = 'show';
    ?>
   @include('partials.discussion-header')
    
    <div class="card-body">
        <div class="text-center">
            <strong> {!! $discussion->title !!}</strong>
        </div>

       
        <hr>
        {!!$discussion->content !!}
        <div class="card card-header">
            <div class="d-flex justify-content-between">
                <a class="btn btn-light btn-sm float-left">
                    <span class="badge badge-primary">
                        {{ $discussion->replies->count()}}
                    </span> Replies
                </a>
                <a class="btn btn-light btn-sm ">
                    <span class="badge badge-primary ">
                        {{ $discussion->channel->name}}
                    </span> 
                </a>
            </div>
        </div>
        @if ($discussion->getBestReply)
        <div class="card bg-success my-5" style="color:#fff">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                            <img width="40px" height="40px" style="border-radius:50%" class="mr-2" src="{{ Gravatar::src($discussion->getBestReply->owner->email)}}" alt="">
                            <strong>
                                    {{ $discussion->getBestReply->owner->name }}
                            </strong>
                    </div>
                    
                    <div>
                        <strong>Best Reply</strong>
                    </div>
                </div>
               
            </div>
            <div class="card-body">
                    {!! $discussion->getBestReply->reply !!}
                   
            </div>
               
        </div>
        
    @endif
    </div>
</div>

@foreach ($discussion->replies()->paginate(3) as $reply)
    <div class="card my-5">
        <div class="card-subheading">Replies:--</div>
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <img width="40px" height="40px" style="border-radius:50%" src="{{ Gravatar::src($reply->owner->email) }}" alt="">
                    <span>{{ $reply->owner->name}}</span>
                </div>
                <div>
                   @auth
                    @if(auth()->user()->id == $discussion->user_id)
                        <form action="{{ route('discussion.best-reply',['discussion' =>  $discussion->slug, 'reply' => $reply->id])}}" method="post">@csrf
                            <button type="submit" class="btn btn-primary btn-sm">Mark as best</button>
                        </form> 
                    @endif     
                   @endauth
                </div>
            </div>
        </div>
        <div class="card-body">
            {!! $reply->reply !!}
        </div>
        <div class="card-header">
            @if ($reply->is_liked_by_auth_user())
                <a href="{{ route('reply.unlike', $reply->id) }}" class="btn btn-danger btn-sm">Unlike <span class="badge badge-light">{{ $reply->likes->count()}}</a>
            @else
        <a href="{{ route('reply.like',  $reply->id) }}" class="btn btn-success btn-sm">Like <span class="badge badge-light">{{ $reply->likes->count()}}</span></a>
            @endif 
           
        </div>
    </div>
@endforeach
{{ $discussion->replies()->paginate(3)->links()}}
<div class="card my-5">
    <div class="card-header">
        Add a reply
    </div>
    <div class="card-body">
        @auth
            <form action="{{route('replies.store', $discussion->slug)}}" method="post"> @csrf
                <input type="hidden" name="reply" id="reply">
                <trix-editor input="reply"></trix-editor>
                <button class="btn btn-success my-2 btn-sm" type="submit">Add Reply</button>
            </form>
        @else
            <a href="{{route('login')}}" class="btn btn-info">Please login to add reply..</a>
        @endauth    
    </div>
</div>
@endsection
@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.1/trix.css">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.1/trix.js"></script>
@endsection

