@extends('admin.template')

@section('title', 'News Games - Dashboard')

@section('content')
    
    <section class="content">
        <h1>Postagens</h1>

        <a href="{{route('post.create')}}" class="btn-add">
            <i class="fas fa-plus-square"></i>
            Nova postagem
        </a>

        <div class="post-content">
            <div class="post-filter">
                <form>
                    <input name="s" type="text" placeholder="Pesquisar..." />
                    <i class="fas fa-search"></i>  
                </form>
                <div class="filter-category">
                    <p>Categoria<p>
                    <select>
                        <option>Todos</option>
                        <option>Notícia</option>
                        <option>Avaliação</option>
                        <option>Artigo<option>
                    </select>
                </div>
            </div>
        </div>
    </section>

@endsection