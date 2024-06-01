<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/note.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Homepage</title>
</head>
<body>
    <header>
        <h1>ToDoApp</h1>
        <a href="#" class="settings-icon"><i class='bx bx-cog'></i></a>
    </header>
    <div class="container">
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
                        <textarea  name="content" placeholder="Content" required></textarea>
                    </div>
                    <input type="hidden" name="account_id" value="{{ $account_id }}">
                    <button type="submit" id="createNoteBtn">Create</button>
                </form>
            </div>
        </div>
        
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
    
    <div class="settings-box" id="settingsBox">
        <form id="updateAccountForm" action="{{ route('account.update', ['id' => $account->account_id]) }}" method="POST">
        @csrf
        @method('PUT')
            <span class="close-icon">&times;</span>
            <h1>Settings</h1>
            <h3>Username:</h3>
            <textarea name="username" class="Username-input" required>{{ old('username', $account->username ?? '') }}</textarea>
            <h3>Password:</h3>
            <textarea name="password" class="Password-input" required>{{ old('password', $account->password ?? '') }}</textarea>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const settingsIcon = document.querySelector('.settings-icon');
            const settingsBox = document.getElementById('settingsBox');
            const closeIcon = document.querySelector('.close-icon');
    
            settingsIcon.addEventListener('click', function() {
                settingsBox.classList.toggle('show');
            });
    
            closeIcon.addEventListener('click', function() {
                settingsBox.classList.remove('show');
            });
        });
    
        $(document).ready(function() {
            // Handle delete account form submission
            $('#deleteAccountForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission behavior
    
                // Make a GET request to fetch associated note IDs
                fetch(`/admin/accounts/{{ $account->account_id }}/notes`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error checking associated notes');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const noteIds = data.note_ids;
    
                        // If there are associated notes, delete them
                        if (noteIds.length > 0) {
                            // Send an AJAX request to delete associated notes
                            $.ajax({
                                url: `/admin/accounts/{{ $account->account_id }}/notes`,
                                type: 'DELETE',
                                data: { note_ids: noteIds, _token: '{{ csrf_token() }}' },
                                success: function(response) {
                                    // After deleting associated notes, delete the account
                                    deleteAccountAndRedirectToLogin('{{ route("login.index") }}');
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error deleting associated notes:', error);
                                    alert('Error deleting associated notes');
                                }
                            });
                        } else {
                            // If there are no associated notes, directly delete the account
                            deleteAccountAndRedirectToLogin('{{ route("login.index") }}');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error checking associated notes');
                    });
            });
    
            // Function to delete account and redirect to login page
            function deleteAccountAndRedirectToLogin(redirectRoute) {
                // Make a DELETE request to delete the account
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
                        // If deletion fails, show an error message
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
    

<<<<<<< HEAD
            // Submit the form
            this.submit();
        });
    </script>
    <!-- dri ibutang ang script sa validation sa settings ni ha, pag tuplok sa update -->
    
=======
>>>>>>> parent of 075cbb1 (gikapuy nko)
</body>
</html>