<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/note.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Homepage</title>
    <style>
        .error-message {
            color: white !important;
            text-align: center;
            margin-top: 10px;
        }

        #password-error,
        #email-error,
        #phone-error {
            color: white;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>ToDoApp</h1>
        <a href="#" class="settings-icon"><i class='bx bx-cog'></i></a>
    </header>
    <div class="container">
        <!-- Create Note Section -->
        <div class="create-note-container">
            <div class="create-note">
                <h2>Create Note</h2>
                <div>
                    @if($errors->any())
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                <form id="createNoteForm" action="{{ route('note.store') }}" method="POST">
                    @csrf
                    <div class="input-box">
                        <input type="text" name="title" placeholder="Title" required>
                    </div>
                    <div class="input-box">
                        <textarea name="content" placeholder="Content" required></textarea>
                    </div>
                    <input type="hidden" name="account_id" value="{{ $account_id }}">
                    <button type="submit" id="createNoteBtn">Create</button>
                </form>
            </div>
        </div>

        <!-- Task Container -->
        <div class="task-container">
            <h2>Tasks</h2>
            @foreach($notes as $note)
            <div class="task-item">
                <form method="post" action="{{ route('note.update', ['id' => $note->notes_id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="task-title">
                        <h4>Title:</h4>
                        <input type="text" name="title" value="{{ $note->title }}" class="title-input" required>
                    </div>
                    <div class="note-description">
                        <h4>Description:</h4>
                        <textarea name="content" class="description-input" required>{{ $note->content }}</textarea>
                    </div>
                    <div class="status-container">
                        <label for="status">Status:</label>
                        <select id="status" name="status">
                            <option value="active" {{ $note->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="finished" {{ $note->status === 'finished' ? 'selected' : '' }}>Finished</option>
                        </select>
                    </div>
                    <button type="submit">Update</button>
                </form>

                <form action="{{ route('note.destroy', ['id' => $note->notes_id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" id="deleteBtn-{{ $note->notes_id }}">Delete</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Settings Box -->
    <div class="settings-box" id="settingsBox">
        <form id="updateAccountForm" action="{{ route('accounts.update', ['id' => $account->account_id]) }}" method="POST">
            @csrf
            @method('PUT')
            <span class="close-icon">&times;</span>
            <h1>Settings</h1>
            <h3>Username:</h3>
            <textarea name="username" id="username" class="Username-input" required>{{ old('username', $account->username ?? '') }}</textarea>
            <div id="username-error" class="error-message"></div>
            <h3>Email:</h3>
            <input type="email" name="email" class="Email-input" required value="{{ old('email', $account->email ?? '') }}">
            <div id="email-error" class="error-message"></div>
            <h3>Phone Number:</h3>
            <input type="text" name="phone" class="Phone-input" required value="{{ old('phone', $account->phone ?? '') }}">
            <div id="phone-error" class="error-message"></div>
            <h3>Password:</h3>
            <input type="password" name="password" class="Password-input" required>
            <div id="password-error"></div>
            <div class="update-account">
                <button id="update-btn" type="submit">Update</button>
            </div>
        </form>
        <form id="logoutForm" action="{{ route('account.logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
        <form id="deleteAccountForm" action="{{ route('account.delete', ['id' => $account->account_id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="delete-btn" type="submit" id="deleteAccountBtn">Delete Account</button>
        </form>
    </div>
    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const settingsIcon = document.querySelector('.settings-icon');
            const settingsBox = document.getElementById('settingsBox');
            const closeIcon = document.querySelector('.close-icon');

            settingsIcon.addEventListener('click', function () {
                settingsBox.classList.toggle('show');
            });

            closeIcon.addEventListener('click', function () {
                settingsBox.classList.remove('show');
            });

            function isStrongPassword(password) {
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*_-~`]{8,}$/;
                return passwordRegex.test(password);
            }

            function isValidPhoneNumber(phone) {
                const phoneNumberRegex = /^\d{11}$/;
                return phoneNumberRegex.test(phone);
            }

            function isValidEmail(email) {
                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                return emailRegex.test(email);
            }

            document.getElementById('updateAccountForm').addEventListener('submit', function (event) {
                const password = document.querySelector('.Password-input').value;
                const passwordError = document.getElementById('password-error');
                const email = document.querySelector('.Email-input').value;
                const emailError = document.getElementById('email-error');
                const phone = document.querySelector('.Phone-input').value;
                const phoneError = document.getElementById('phone-error');

                passwordError.textContent = ''; // Clear previous error messages
                emailError.textContent = '';
                phoneError.textContent = '';

                let isValid = true;

                if (!isStrongPassword(password)) {
                    passwordError.textContent = 'Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
                    isValid = false;
                }

                if (!isValidEmail(email)) {
                    emailError.textContent = 'Please enter a valid email address.';
                    isValid = false;
                }

                if (!isValidPhoneNumber(phone)) {
                    phoneError.textContent = 'Phone number must be all numbers and exactly 11 digits long.';
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault(); // Prevent form submission if any validation fails
                }
            });
        });

        $(document).ready(function () {
            $('#deleteAccountForm').submit(function (event) {
                event.preventDefault();

                fetch(`/admin/accounts/{{ $account->account_id }}/notes`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error checking associated notes');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const noteIds = data.note_ids;

                        if (noteIds.length > 0) {
                            $.ajax({
                                url: `/admin/accounts/{{ $account->account_id }}/notes`,
                                type: 'DELETE',
                                data: { note_ids: noteIds, _token: getCsrfToken() },
                                success: function (response) {
                                    deleteAccountAndRedirectToLogin('{{ route("login.index") }}');
                                },
                                error: function (xhr, status, error) {
                                    console.error('Error deleting associated notes:', error);
                                    alert('Error deleting associated notes');
                                }
                            });
                        } else {
                            deleteAccountAndRedirectToLogin('{{ route("login.index") }}');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error checking associated notes');
                    });
            });

            function deleteAccountAndRedirectToLogin(redirectRoute) {
                fetch(`/account/{{ $account->account_id }}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => {
                        if (response.ok) {
                            window.location.href = redirectRoute;
                        } else {
                            alert('Error deleting account');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting account');
                    });
            }
        });
    </script>
</body>

</html>
