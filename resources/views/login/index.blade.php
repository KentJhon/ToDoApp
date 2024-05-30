<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <div class="background">
        <div class="container">
            <div class="intro">
                <h1>Welcome</h1>
                <h2>to ToDoApp</h2>
            </div>
            <div class="login">
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <h1>Login</h1>
                    <div class="input-box">
                        <input type="text" name="username" placeholder="Username" required>
                        <i class="bx bxs-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" name="email" placeholder="Email" required>
                        <i class="bx bxs-envelope"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" placeholder="Password" required>
                        <i class="bx bxs-lock-alt"></i>
                    </div>
                    <button type="submit" class="btn">Login</button>
                </form>
                <div class="register">
                    <p>
                        Don't have an account?
                        <a href="{{ route('register.index') }}">Register</a>
                    </p>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
