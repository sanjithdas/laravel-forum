@extends('layouts.app')

@section('content')
    @foreach ($discussions as $discussion)
        <div class="card mb-4">
            @include('partials.discussion-header')
            <div class="card-body">
                <div class="text-center">
                    <strong>
                            {!! $discussion->title !!}
                    </strong>
                </div>
            </div>
            <div class="card card-header"><span class="badge badge-light text-left">{{ $discussion->replies->count()}} {{ $discussion->replies->count() >1 ? 'replies' : 'reply'}}</span><span class="badge bagde-primary text-right">{{ $discussion->channel->name}}</span></div>
        </div>
    @endforeach
    {{$discussions->appends(['channel' => request()->query('channel')])->links()}}
@endsection
