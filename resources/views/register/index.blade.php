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
                <form method="post" action="{{ route('register.store') }}" onsubmit="return validateForm()">
                    @csrf
                    <h1>Register</h1>
                    <div class="input-box">
                        <input type="text" name="username" placeholder="Username" required>
                        <i class="bx bxs-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="email" id="email" name="email" placeholder="Email" required>
                        <i class="bx bxs-envelope"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" id="phone" name="phone" placeholder="Phone Number" required>
                        <i class="bx bxs-phone"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <i class="bx bxs-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Confirm Password" required>
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
            var phone = document.getElementById("phone").value;
            var email = document.getElementById("email").value;

            var strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
            var phoneNumberRegex = /^\d{11}$/;
            var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
           
            if (password != confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            if (!strongPasswordRegex.test(password)) {
                alert("Password is not strong enough. It must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.");
                return false;
            }
            if (!phoneNumberRegex.test(phone)) {
                alert("Phone number must be all numbers and exactly 11 digits long.");
                return false;
            }
            if (!emailRegex.test(email)) {
                alert("Please input a valid email.");
                return false;
            }
        }
    </script>
</body>
</html>
