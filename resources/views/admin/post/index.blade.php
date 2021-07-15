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
                <form id="form">
                    @csrf
                    <input id="inputSearch" name="s" type="text" placeholder="Pesquisar..." />
                    <i class="fas fa-search"></i>  
                </form>
                <div class="filter-category">
                    <p>Categoria<p>
                    <select id="selectCategories">
                        <option value="all">Todos</option>
                        <option value="news">Notícia</option>
                        <option value="reviews">Avaliação</option>
                        <option value="artigo">Artigo</option>
                    </select>
                </div>
            </div>

            <div class="post-feed-content">
                <table>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Status</th>
                        <th>Autor</th>
                        <th>Data criada</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody class="feed">
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{$post->id}}</td>
                                <td><p>{{$post->title}}</p></td>
                                @if ($post->status == 1) 
                                    <td class="span_status active"><span>Ativo</span></td>
                                @else 
                                    <td class="span_status desative"><span>Desativo</span></td>
                                @endif
                                <td>{{$post->user->name}}</td>
                                <td>{{date('d/m/Y', strtotime($post->created_at))}}</td>
                                <td class="td-btns">
                                    <a href="{{ route('post.edit', ['post'=>$post->id]) }}" class="btn edit"><i class="fas fa-edit"></i></a> 

                                    <form method="POST" class="token" action="{{ route('post.destroy', ['post'=>$post->id]) }}" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn-del">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>

                                    <a href=""  class="btn view"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>


<script>
const BASE = '{{URL::to('/')}}';
const input  = document.querySelector('#inputSearch');
const select = document.querySelector('#selectCategories');
const form = document.querySelector('#form');
const areaFeed = document.querySelector('.feed');
let timer;
let token;
if(document.querySelector('.token')) {
    let form = document.querySelector('.token');
    token = form.querySelector('input[name=_token]').value;  
}

select.addEventListener('change', async ()=> {
    getPost();
});
input.addEventListener('keyup', async(e)=> {
    clearTimeout(timer);
    timer = setTimeout(function() {getPost()}, 1200);
});

async function getPost() {
    let data = new FormData(form);
    data.append('category', select.value);

    let req = await fetch("{{route('search')}}", {
        method: 'POST',
        body: data
    });
    let json = await req.json();

    areaFeed.innerHTML = '';
    if(json.length > 0) {
        
        let html = '';
        json.map((feed, index)=> {
            html += '<tr>';
            html += `<td>${feed.id}</td>`;
            html +=  `<td><p>${feed.title}</p></td>`;
            if(feed.status == 1) {
                html +=  `<td class="span_status active"><span>Ativo</span></td>`;
            } else {
                html += `<td class="span_status desative"><span>Desativo</span></td>`;
            }
            html += `<td>${feed.user.name}</td>`;
            html += `<td>${feed.created_at}</td>`;
            html += `<td class="td-btns">`;
            html +=     `<a href="${BASE}/dashboard/post/${feed.id}/edit" class="btn edit"><i class="fas fa-edit"></i></a>`;
            html +=     `<form method="POST" class="token" action="${BASE}/dashboard/post/${feed.id}" onsubmit="return confirm('Tem certeza que deseja excluir?')">`;
            html +=         `<input type="hidden" name="_method" value="DELETE">`;
            html +=         `<input type="hidden" name="_token" value="${token}">`;
            html +=         `<button class="btn-del">`;
            html +=             `<i class="fas fa-trash-alt" aria-hidden="true"></i>`;
            html +=         `</button>`;
            html +=     `</form>`;
            html +=     `<a href=""  class="btn view"><i class="fas fa-eye"></i></a>`;
            html += `</td>`;
            html += `</tr>`;
        });
        areaFeed.innerHTML = html;
    }
}

</script>

@endsection
