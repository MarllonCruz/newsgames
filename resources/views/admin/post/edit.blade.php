@extends('admin.template')

@section('title', 'News Games - Dashboard')

@section('content')
    
    <section class="content">
        <h1>Postagens - <span>Editar Postagem</span></h1>

        <form action="{{route('post.update', ['post'=>$post->id])}}" method="POST" class="form-post" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            @if ($errors->all())
                <div class="flash error">
                    @foreach ($errors->all() as $error)
                        <span>{{$error}}</span>
                    @endforeach         
                </div>
            @endif
           
            @if (session()->has('success'))
                <div class="flash success">
                    <span>{{ session()->get('success') }}</span>
                </div>
            @endif

            <div class="input-area">
                <div class="input-area--title">Título</div>
                <div class="input-area--field">
                    <input type="text" name="title" value="{{$post->title}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Subtítulo</div>
                <div class="input-area--field">
                    <input type="text" name="subtitle" value="{{$post->subtitle}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Categoria</div>
                <div class="input-area--field">
                    <select name="category">
                        <option value="news" {{$post->category=="news"?'selected="selected"':''}}>Notícia</option>
                        <option value="reviews" {{$post->category=="reviews"?'selected="selected"':''}}>Avaliação</option>
                        <option value="artigo" {{$post->category=="artigo"?'selected="selected"':''}}>Artigo</option>
                    </select>
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Ativo</div>
                <div class="input-area--field">
                    <input type="checkbox" name="status"  {{$post->status==1?'checked':''}}/>
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Capa</div>
                <div class="input-area--field">
                    <input type="file" name="cover" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Conteúdo</div>
                <div class="input-area--field">
                    <textarea name="body" class="bodyfield">{{$post->body}}</textarea>
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title"></div>
                <div class="input-area--field">
                    <input type="submit" value="Editar" />
                </div>
            </div>

        </form>
    </section>

<script 
src="https://cdn.tiny.cloud/1/rblr2ts2nr4u73scbsw9kdzcnekf9rwzhopc89sgwkntmxex
/tinymce/5/tinymce.min.js" referrerpolicy="origin">
</script>
<script>
    tinymce.init({
        selector:'textarea.bodyfield',
        min_height: 600,
        menubar:false,
        plugins:['link','table','image','autoresize','lists'],
        toolbar:'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | table | link image | bullist numlist',
        content_css:[
            '{{asset('assets/css/content.css')}}'
        ],
        images_upload_url:'{{route('imageupload')}}',
        images_upload_credentials:true,
        convert_urls:false
    });
</script>
<style>
/*--- Não é recomentado desabilitar notificação no "SITE" apenas no "LOCALHOST" ---*/
.tox-notifications-container{ display: none !important; }
</style>

@endsection