<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/admin_style.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <title>Admin</title>
</head>
<body>
    <header>
        <h1>Admin Page<h1>
        <a href="{{ route('login.index') }}" class="logout-icon"><i class='bx bx-log-out'></i></a>    
    </header>     
    <div class="content">
        <div class="table">
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Date Created</th>
                    <th>Date Updated At</th>
                    <th>Action</th>
                </tr>
                <tbody>
                    @foreach ($accounts as $account)
                        <tr>
                            <td>{{ $account->account_id }}</td>
                            <td>{{ $account->username }}</td>
                            <td>{{ $account->password }}</td>
                            <td>{{ $account->created_at}}</td>
                            <td>{{ $account->updated_at}}</td>
                            <td>
                                @if ($account->account_id !== 1) 
                                    <form action="{{ route('admin.accounts.delete', ['id' => $account->account_id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" id="deleteBtn-{{ $account->account_id }}">Delete</button>
                                    </form>                               
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function deleteAccount(account_id) {
            // Make a GET request to check if there are associated notes
            fetch(`/admin/accounts/${account_id}/notes`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error checking associated notes');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.notes.length > 0) {
                        // If there are associated notes, show an error message
                        alert('Cannot delete account. Associated notes exist.');
                    } else {
                        // If there are no associated notes, proceed with the DELETE request
                        if (confirm("Are you sure you want to delete this account?")) {
                            fetch(`/admin/accounts/${account_id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    location.reload(); 
                                } else {
                                    throw new Error('Error deleting account');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Error deleting account');
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error checking associated notes');
                });
        }
    </script>    
</body>
</html>