@extends('admin.template')

@section('title', 'News Games - Dashboard')

@section('content')
    
    <section class="content">
        <h1>Sliders</h1>

        <form action="{{route('sliderAction')}}" method="POST" class="form-post">
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
                <div class="input-area--title">Slider 1</div>
                <div class="input-area--field">
                    <input type="number" name="slider1" value="{{$sliders[0]->id_post}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Slider 2</div>
                <div class="input-area--field">
                    <input type="number" name="slider2"  value="{{$sliders[1]->id_post}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Slider 3</div>
                <div class="input-area--field">
                    <input type="number" name="slider3" value="{{$sliders[2]->id_post}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Slider 4</div>
                <div class="input-area--field">
                    <input type="number" name="slider4" value="{{$sliders[3]->id_post}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Slider 5</div>
                <div class="input-area--field">
                    <input type="number" name="slider5"  value="{{$sliders[4]->id_post}}" />
                </div>
            </div>

            <div class="input-area">
                <div class="input-area--title">Slider 6</div>
                <div class="input-area--field">
                    <input type="number" name="slider6"  value="{{$sliders[5]->id_post}}" />
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