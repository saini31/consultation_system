<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <h1>Login</h1>
    <form id="loginForm">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
    <p id="message"></p>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the form from submitting traditionally

                var formData = {
                    email: $('#email').val(),
                    password: $('#password').val(),
                };

                $.ajax({
                    url: '/api/login', // Your API route
                    type: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Handle success
                        if (response.token) {
                            // Get user ID from the response
                            var userId = response.user.id;
                            // Redirect to the user's profile page with their ID
                            window.location.href = "{{ route('userProfile', ['id' => '__ID__']) }}".replace('__ID__', userId);
                        }
                    },
                    error: function(xhr) {
                        // Handle error
                        var response = xhr.responseJSON;
                        $('#message').text(response.error || 'Login failed!');
                    }
                });
            });
        });
    </script>
</body>

</html>