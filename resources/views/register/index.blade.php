<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="{{ asset('assets/css/register_style.css') }}">

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <div class="background">
        <div class="container">
            <div class="intro">
                <h1>Welcome</h1>
                <h2>to ToDoApp</h2>
            </div>
            <div class="register">
                <form method="post" action="{{route('register.store')}}" onsubmit="return validateForm()">
                    @csrf
                    @method('post')
                    <h1>Register</h1>
                    <div class="input-box">
                        <input type="text" name='username' placeholder="Username" required>
                        <i class="bx bxs-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" id="password" name='password' placeholder="Password" required>
                        <i class="bx bxs-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" id="confirmPassword" name='password' placeholder="Confirm Password" required>
                        <i class="bx bxs-lock-alt"></i>
                    </div>
                    <button type="submit" class="btn">Create Account</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
