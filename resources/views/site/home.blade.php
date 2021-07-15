@extends('site.template')

@section('title', '')

@section('content')
    
    <!-- start slider -->
    <x-slider :dados="$sliders" />
    <!-- end slider -->

    <!--section feeds highlights start-->
		<section class="feeds-highlights">
			<!-- feed smalls start-->
			@for ($i = 0; $i < 4; $i++)
				<a href="{{ url('/feed/'.$highlights[$i]->post->slug) }}" class="feed-box small">
					<img src="{{url('/media/covers/'.$highlights[$i]->post->cover)}}" alt="" />
					<div class="feed-info">
						<h2>{{ $highlights[$i]->post->title }}</h2>
						<p>{{ $highlights[$i]->post->subtitle }}</p>
					</div>
					<span><i class="fas fa-clock"></i> {{$highlights[$i]->post->date}}</span>
				</a>	
			@endfor
			<!-- feed smalls end-->

			<!-- feed medium start-->
			<a href="{{ url('/feed/'.$highlights[4]->post->slug) }}" class="feed-box medium">
				<div class="feed-info">
					<h2>{{ $highlights[4]->post->title }}</h2>
					<p>{{ $highlights[4]->post->subtitle }}</p>
				</div>
				<img src="{{url('/media/covers/'.$highlights[4]->post->cover)}}" alt="" />
				<span><i class="fas fa-clock"></i> {{$highlights[4]->post->date}}</span>
			</a>
			<!-- feed medium end-->

			<!-- feed large start-->
			<a href="{{ url('/feed/'.$highlights[5]->post->slug) }}" class="feed-box large">
				<div class="feed-info">
					<h2>{{ $highlights[5]->post->title }}</h2>
					<p>{{ $highlights[5]->post->subtitle }}</p>
				</div>
				<img src="{{url('/media/covers/'.$highlights[5]->post->cover)}}" alt="" />
				<span><i class="fas fa-clock"></i> {{$highlights[5]->post->date}}</span>
			</a>
			<!-- feed large end-->

			<!-- feed-news start-->
			<div class="feed-box feed-news">
				<h2>News</h2> 
			
				<a href="{{  url('/feed/'.$latestPosts[0]->slug) }}" class="feed-news--feed">
					<img src="{{ url('/media/covers/'.$latestPosts[0]->cover) }}" alt="" />
					<p>{{ $latestPosts[0]->date }}</p>
					<h4>{{ $latestPosts[0]->title }}</h4>
				</a>
				@for ($i = 1; $i < 5; $i++)
					<a href="{{ url('/feed/'.$latestPosts[$i]->slug) }}" class="feed-news--feed">
						<p>{{ $latestPosts[$i]->date }}</p>
						<h4>{{ $latestPosts[$i]->title }}</h4>
					</a>
				@endfor

				<a href="{{ route('filter', ['news'=>'on']) }}" class="link-all" >All News</a>
			</div>
			<!-- feed-news end-->

			<!-- ad start-->
			<a href="#" class="feed-box ad">
				<img src="{{ url('/assets/media/laravel.png') }}" alt="" />
			</a>
			<!-- ad end-->
		</section>
		<!--section feeds highlights end-->

@endsection