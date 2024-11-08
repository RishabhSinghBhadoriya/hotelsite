<?php
require_once 'config.php';
require_once 'User.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $conn = $db->connect();
    $user = new User($conn);

    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($user->login($email, $password)) {
        if (isset($_POST['remember_me'])) {
            setcookie('user_email', $email, time() + (86400 * 30), "/");
        }
        header('Location: index.php');
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
        }
        .form-container {
            max-width: 500px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .btn {
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: var(--secondary-color);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember_me"> Remember me
                </label>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
