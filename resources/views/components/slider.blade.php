<!--section slider show start-->
<section class="slider">
	
    @foreach ($posts as $post)
        <div class="slide {{$post->active}}">
            <img src="{{url('/media/covers/'.$post->cover)}}" alt="" />
            <div class="slide-info">
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->subtitle }}</p>
                <a href="{{ url('/feed/'.$post->slug) }}">Read More</a> 
            </div>
        </div>    
    @endforeach
    
    

    <div class="navigation">
        @foreach ($posts as $post)
            <div class="btn {{$post->active}}"></div>
        @endforeach
    </div>
</section>
<!--section slider show end-->