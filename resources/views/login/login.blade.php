<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('img/flavicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
<div class="container">
    <div class="banner">

    </div>
    <div class="login-container">
        <h1 class="login-title">LOGIN</h1>

        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        @if(auth()->check())
            <p>Está logado - <a href="{{ route('logout') }}">Sair</a></p>
        @else
            @error('error')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
            @enderror

            <form action="{{ route('login') }}" method="post" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="email">Usuário</label>
                    <input class="input-email" type="text" name="email" id="email"
                           placeholder="Usuário" value="teste@gmail.com" required>
                    @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input class="input-senha" type="password" name="password" id="password"
                           value="123" placeholder="Senha" required>
                    @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <a href="#" class="forgot-password">Recuperar senha?</a>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary btn-lg">LOGIN</button>
                </div>
            </form>
        @endif
    </div>
</div>
</body>
</html>
