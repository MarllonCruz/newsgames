@extends('admin.template')

@section('title', 'News Games - Dashboard')

@section('content')
    
    <section class="content">
        <h1>Sliders</h1>

        <form action="{{route('highlightAction')}}" method="POST" class="form-post">
            @csrf
           
            @if (session()->get('error'))
                <div class="flash error">
                    @foreach (session()->get('error') as $error)
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
                <div class="input-area--title">Destaque 1 (P)</div>
                <div class="input-area--field">
                    <input required type="number" name="small1" value="{{$highlights[0]->id_post}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Destaque 2 (P)</div>
                <div class="input-area--field">
                    <input required type="number" name="small2"  value="{{$highlights[1]->id_post}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Destaque 3 (P)</div>
                <div class="input-area--field">
                    <input required type="number" name="small3"  value="{{$highlights[2]->id_post}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Destaque 4 (P)</div>
                <div class="input-area--field">
                    <input required type="number" name="small4"  value="{{$highlights[3]->id_post}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Destaque 5 (M)</div>
                <div class="input-area--field">
                    <input required type="number" name="medium"  value="{{$highlights[4]->id_post}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Destaque 6 (G)</div>
                <div class="input-area--field">
                    <input required type="number" name="large"  value="{{$highlights[5]->id_post}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title"></div>
                <div class="input-area--field btn-del-relativo">
                    <input type="submit" value="Salvar" />
                </div>
            </div>
        </form>
    </section>

@endsection