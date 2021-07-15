@extends('site.template')

@section('title', '')

@section('content')
    
    <div class="filter-content">
        <div class="filter-area-left">
            <form method="{{ route('filter') }}">
                <h2>Filtro</h2>
                <div class="input-search">
                    <input type="text" name="s" 
                        @isset($data['s'])
                            value="{{$data['s']}}"
                        @endisset
                     />
					<i class="fas fa-search"></i>
                </div>
                <div class="input-check">
                    <div class="input-field">
                        <input type="checkbox" name="news" {{isset($data['news'])?'checked':''}} />
                    </div>
                    <div class="input-title">( News )</div>
                </div>
                <div class="input-check">
                    <div class="input-field">
                        <input type="checkbox" name="reviews" {{isset($data['reviews'])?'checked':''}}/>
                    </div>
                    <div class="input-title">( Reviews )</div>
                </div>
                <div class="input-check">
                    <div class="input-field">
                        <input type="checkbox" name="artigos" {{isset($data['artigos'])?'checked':''}} />
                    </div>
                    <div class="input-title">( Artigos )</div>
                </div>
                
                <div class="input-submit">
                    <input type="submit" value="Pesquisar" />
                </div>
            </form>
        </div>
        <div class="filter-area-right">

            @if (!empty($posts))
                @foreach ($posts as $post)
                    <a href="{{ route('feed', ['slug'=>$post->slug]) }}" class="feed">
                        <div class="feed-img">
                            <img src="{{ url('/media/covers/'.$post->cover) }}" />
                        </div>
                        <div class="feed-info">
                            <h2>{{ $post->title }}</h2>
                            <span>{{ $post->subtitle }}</span>
                        </div>
                    </a>
                @endforeach

                {{ $posts->links('vendor.pagination.custom') }}
            @else
                <h2>Nenhum resultado da busca</h2>
            @endif

        </div>
    </div>

@endsection