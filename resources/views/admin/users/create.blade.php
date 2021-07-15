@extends('admin.template')

@section('title', 'News Games - Dashboard')

@section('content')
    
    <section class="content">
        <h1>Usuário - <span>Novo Usuário</span></h1>

        <form action="{{route('user.store')}}" method="POST" class="form-post">
            @csrf

            @if ($errors->all())
                <div class="flash error">
                    @foreach ($errors->all() as $error)
                        <span>{{$error}}</span>
                    @endforeach         
                </div>
            @endif

            <div class="input-area">
                <div class="input-area--title">Nome</div>
                <div class="input-area--field">
                    <input type="text" name="name" value="{{old('name')}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">E-mail</div>
                <div class="input-area--field" >
                    <input type="email" name="email" value="{{old('email')}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Senha</div>
                <div class="input-area--field">
                    <input type="password" name="password" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Confirma a senha</div>
                <div class="input-area--field">
                    <input type="password" name="password_confirmation" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title"></div>
                <div class="input-area--field">
                    <input type="submit" value="Criar Usuário" />
                </div>
            </div>

        </form>
    </section>

@endsection