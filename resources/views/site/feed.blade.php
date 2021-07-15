@extends('site.template')

@section('title', '')

@section('content')
    
    <div class="feed-content">
        <div class="feed-info-header">
            <div class="feed-info--cover">
                <img src="{{ url('/media/covers/'.$feed->cover) }}" />
            </div>
            <div class="feed-info--title-subtitle">
                <h2>{{ $feed->title }}</h2>
                <p>{{ $feed->subtitle }}</p>
                <span><i class="fas fa-clock"></i> {{$feed->date}}</span>
            </div>
        </div>
        <div class="feed-info-body">
            <div class="feed-left">
                <div class="feed-body">{!! $feed->body !!}</div>
            </div>
            <div class="feed-right">
                <a href="" class="ad">
                    <img src="{{ url('/assets/media/laravel.png') }}" alt="" />
                </a>

                @if($latestPosts)
                    <div class="latest-post">
                        <h2>News</h2> 
                    
                        <a href="{{  url('/feed/'.$latestPosts[0]->slug) }}" class="latest-post--feed">
                            <img src="{{ url('/media/covers/'.$latestPosts[0]->cover) }}" alt="" />
                            <p>{{ $latestPosts[0]->date }}</p>
                            <h4>{{ $latestPosts[0]->title }}</h4>
                        </a>
                        @for ($i = 1; $i < 5; $i++)
                            <a href="{{ url('/feed/'.$latestPosts[$i]->slug) }}" class="latest-post--feed">
                                <p>{{ $latestPosts[$i]->date }}</p>
                                <h4>{{ $latestPosts[$i]->title }}</h4>
                            </a>
                        @endfor
        
                        <a href="{{ route('filter', ['news'=>'on']) }}" class="link-all" >All News</a>
                    </div>
                @endif 
            </div>
        </div>
    </div>

@endsection