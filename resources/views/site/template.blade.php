<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Games @yield('title')</title>
    <link rel="stylesheet" href="{{ url('assets/css/site/style.css') }}" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<head>
<body>
	<!--header start-->
	<header>
		<section>
			<div class="header-top">
				<a href="{{ route('/') }}">News Games</a>
			</div>
			<span></span>
			<div class="header-bottom" style="{{$header==false?'display:none;':''}}">
				<div class="btn-openMenu"></div>
				<ul>
					<div class="btn-closeMenu"></div>
					<a href="{{ route('filter', ['news'=>'on']) }}"><li>News</li></a>
					<a href="{{ route('filter', ['reviews'=>'on']) }}"><li>Reviews</li></a>
					<a href="{{ route('filter', ['artigos'=>'on']) }}"><li>Artigos</li></a>
				</ul>
				<form action="{{ route('filter') }}">
					<input type="text" name="s" />
					<i class="fas fa-search"></i>
				</form>
			</div>
		</section>
	</header>
	<!--header end-->

    <!--content start-->
	<div class="content">
    	@yield('content')
	</div>
    <!--content end-->

    <!--footer start-->
    <footer>
		<section>
			<h1>News Games</h1>
			<h3>Developed by: Marlon Cruz</h3>
		</section>
	</footer>
    <!--footer end-->

	<!--scripts-->
	<script src="https://kit.fontawesome.com/07df3e3170.js" crossorigin="anonymous"></script>
	<script src="{{ url('assets/js/script.js') }}"></script>
</body>
</html>