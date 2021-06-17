@extends('admin.template')

@section('title', 'News Games - Dashboard')

@section('content')
    
    <section class="content">
        <h1>Postagens - <span>Nova Postagem</span></h1>

        <form action="{{route('post.store')}}" method="POST" class="form-post" enctype="multipart/form-data">
            @csrf

            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p><br/>
            @endforeach

            <div class="input-area">
                <div class="input-area--title">Título</div>
                <div class="input-area--field">
                    <input type="text" name="title" value="{{old('title')}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Subtítulo</div>
                <div class="input-area--field" value="{{old('subtitle')}}" >
                    <input type="text" name="subtitle" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Categoria</div>
                <div class="input-area--field">
                    <select name="category">
                        <option value="news">Notícia</option>
                        <option value="reviews">Avaliação</option>
                        <option value="artigo">Artigo</option>
                    </select>
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
                    <textarea name="body" class="bodyfield"></textarea>
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title"></div>
                <div class="input-area--field">
                    <input type="submit" value="Criar Postagem" />
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