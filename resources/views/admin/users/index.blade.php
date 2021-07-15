@extends('admin.template')

@section('title', 'News Games - Dashboard')

@section('content')
    
    <section class="content">
        <h1>Usuários</h1>

        <a href="{{route('user.create')}}" class="btn-add">
            <i class="fas fa-plus-square"></i>
            Novo Usuário
        </a>

        <div class="user-content">
            @foreach ($users as $item)
                <a href="{{route('user.edit', ['user'=>$item->id])}}" class="user-box" style="background-color:{{$colors[rand(0, 17)]}};">
                    <p>[ {{$item->name}} ]</p>
                    <span>{{ $item->email }}</span>
                </a>
            @endforeach
        </div>
    </section>

@endsection
