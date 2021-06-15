<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News Games - Login</title>
    <link rel="stylesheet" href="{{ url('assets/css/admin/auth.css') }}" />
</head>
<body>
    <div class="box">
        <h1>Login</h1>

        @if ($errors->any())
            <div class="flash">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form method="POST" >
            @csrf

            <input type="email" name="email" placeholder="Seu e-mail" value="{{ old('email') }}" />

            <input type="password" name="password" placeholder="Sua senha" />

            <input type="submit" value="Entrar" />

        </form>

    </div>
</body>
</html>
