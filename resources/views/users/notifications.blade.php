@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Notifications</div>

    <div class="card-body">
            
       <ul class="list-group">
        @foreach ($notifications as $notification)
           <li class="list-group-item">
                {{-- @json($notification->data['discussion']['slug']) --}}
                @if($notification->type == 'LaravelForum\Notifications\NewReplyAdded')
                    A new reply was added to {{Auth::user()->name}} discussion 
                    <strong> {{  $notification->data['discussion']['title'] }} </strong>
                    <a href="{{ route('discussions.show', $notification->data['discussion']['slug'])}}" class="btn btn-sm btn-info float-right"> View discussion</a>
                @endif     
               @if ($notification->type=='LaravelForum\Notifications\ReplyMarkedAsBestReply')
                    Your reply to the discussion <strong> {{ $notification->data['discussion']['title']}} </strong> was marked as best reply. 
                    <a href="{{ route('discussions.show', $notification->data['discussion']['slug'])}}" class="btn btn-sm btn-info float-right"> View discussion</a>
               @endif
           </li>
        @endforeach
        </ul>
    </div>

</div>
@endsection
