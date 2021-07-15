@extends('admin.template')

@section('title', 'News Games - Dashboard')

@section('content')
    
    <section class="content">
        <h1>Usuário - <span>Editar Usuário</span></h1>

        <form action="{{route('user.update', ['user'=>$data->id])}}" method="POST" class="form-post">
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
                <div class="input-area--title">Nome</div>
                <div class="input-area--field">
                    <input type="text" name="name" value="{{ $data->name }}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">E-mail</div>
                <div class="input-area--field">
                    <input type="email" name="email"  value="{{ $data->email }}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Nova Senha(Opcional)</div>
                <div class="input-area--field">
                    <input type="password" name="password" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Confirma a senha(Opcional)</div>
                <div class="input-area--field">
                    <input type="password" name="password_confirmation" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title"></div>
                <div class="input-area--field btn-del-relativo">
                    <input type="submit" value="Atualizar Usuário" />
                </div>
            </div>
        </form>

        @if($data->master == 0) 
            <form method="POST" action="{{ route('user.destroy', ['user'=>$data->id]) }}" onsubmit="return confirm('Tem certeza que deseja deletar usuário?')">
                @method('DELETE')
                @csrf
                <button class="btn-del-absolute">
                    Deletar Usuário
                </button>
            </form>
        @endif
    </section>

@endsection