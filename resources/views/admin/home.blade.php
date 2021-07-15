@extends('admin.template')

@section('title', 'News Games - Dashboard')

@section('content')
    
    <section class="content">
        <h1>Dashboard</h1>

        <div class="data-count">
            <div class="data-count--box">
                <i class="far fa-newspaper"></i>
                <div class="data-count--box-info">
                    <p>Total de postagens</p>
                    <span>{{ $countPosts }}</span>
                </div>
            </div>
            <div class="data-count--box">
                <i class="far fa-eye"></i>
                <div class="data-count--box-info">
                    <p>Total de visitas</p>
                    <span>{{ $countVisitors }}</span>
                </div>
            </div>
            <div class="data-count--box">
                <i class="fas fa-users"></i>
                <div class="data-count--box-info">
                    <p>Total de usúarios</p>
                    <span>{{ $countUsers }}</span>
                </div>
            </div>
            <div class="data-count--box">
                <i class="fas fa-toggle-on"></i>
                <div class="data-count--box-info">
                    <p>Online</p>
                    <span>{{ $countOnlines }}</span>
                </div>
            </div>
        </div>
    </section>

@endsection