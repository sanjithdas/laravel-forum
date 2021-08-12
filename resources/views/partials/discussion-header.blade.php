
<div class="card-header">
    
        <div class="d-flex justify-content-between">
            <div>
                <img width="40px" height="40px" style="border-radius:50%" src="{{ Gravatar::src($discussion->author->email) }}" alt="">    
                <span class="ml-2 font-weight-bold">{{$discussion->author->name}}</span>
            </div>
            <div>
                
                @if (isset($page))
                    @if ($discussion->is_being_watched_by_auth_user())
                        <a href="{{ route('discussion.unwatch',$discussion->id)}}" class="btn btn-success btn-sm">Unwatch</a>
                    @else
                        <a href="{{route('discussion.watch',$discussion->id)}}" class="btn btn-success btn-sm">watch</a>
                    @endif
                @else
                <a href="{{route('discussions.show',$discussion->slug)}}" class="btn btn-success btn-sm">View</a>
                @endif
            </div>                        
        </div>
        
    </div>
