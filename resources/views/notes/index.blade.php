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
        <h1>ToDoApp<h1>
        <a href="#" class="settings-icon"><i class='bx bx-cog'></i></a>
    </header>
    <div class="create-note-container">
        <div class="create-note">
            <h2>Create Note</h2>
            <form id="createNoteForm" action="{{ route('note.store') }}" method="POST">
                @csrf
                <div class="input-box">
                    <input type="text" name="title" placeholder="Title" required>
                </div>
                <div class="input-box">
                    <textarea name="description" placeholder="Description" required></textarea>
                </div>
                <button type="submit" id="createNoteBtn">Create</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const createNoteForm = document.getElementById('createNoteForm');
        const createNoteBtn = document.getElementById('createNoteBtn');

        createNoteForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            // Get form data
            const formData = new FormData(createNoteForm);

            // Make AJAX request
            fetch('/note', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token for Laravel
                }
            })
            .then(response => {
                if (response.ok) {
                    // Note created successfully
                    alert('Note created successfullgyyrtyuy!');
                    // Optionally, you can redirect or update the UI here
                } else {
                    // Error creating note
                    alert('Error creating note');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error creating note');
            });
        });
    });

    </script>
</body>
</html>