<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Important for responsiveness -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Bootstrap Icons -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

<div class="card shadow p-4" style="min-width: 300px; max-width: 400px; width: 100%;">
    <h6 class="text-center mb-1" style="color:tomato">Ms-HR</h6>
    <h3 class="text-center mb-4">Login</h3>
    <form method="post">
        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-3 position-relative">
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
        <!-- Eye Icon for Password Visibility Toggle -->
        <span id="togglePassword" style="position: absolute; top: 18%; right: 10px; cursor: pointer;">
            <i class="bi bi-eye-slash"></i>  <!-- Bootstrap Icon (You can use any icon library) -->
        </span>
    </div>
        <button class="btn btn-primary w-100">Login</button>
    </form>
    <?php if (!empty($error)) echo '<div class="alert alert-danger mt-3">'.$error.'</div>'; ?>
</div>
<script>
    // Toggle password visibility
    $('#togglePassword').click(function () {
        var passwordField = $('#password');
        var icon = $(this).find('i');
        
        // Toggle the password field type between text and password
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        }
    });
</script>
</body>
</html>
