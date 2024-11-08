<?php
require_once 'config.php';
require_once 'User.php';
session_start();

if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $conn = $db->connect();
    $user = new User($conn);

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];
    
    if(empty($username)) {
        $errors[] = "Username is required";
    } elseif(strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters long";
    }

    if(empty($email)) {
        $errors[] = "Email is required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if($stmt->rowCount() > 0) {
        $errors[] = "Email already registered";
    }

    if(empty($password)) {
        $errors[] = "Password is required";
    } elseif(strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }

    if($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    if(empty($errors)) {
        try {
            if($user->register($username, $email, $password)) {
                $success = "Registration successful! Please login.";
                
                if($user->login($email, $password)) {
                    header('Location: index.php');
                    exit();
                }
            } else {
                $error = "Registration failed. Please try again.";
            }
        } catch(PDOException $e) {
            $error = "Registration failed: " . $e->getMessage();
        }
    } else {
        $error = implode("<br>", $errors);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Luxury Hotel</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --success-color: #27ae60;
            --error-color: #c0392b;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            background: #f5f6fa;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 1rem;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h1 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .btn {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: var(--secondary-color);
        }

        .message {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
        }

        .success {
            background: var(--success-color);
            color: white;
        }

        .error {
            background: var(--error-color);
            color: white;
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .login-link a:hover {
            color: var(--secondary-color);
        }

        .password-requirements {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="form-header">
            <h1>Create Account</h1>
            <p>Join Luxury Hotel to start booking your perfect stay</p>
        </div>

        <?php if($success): ?>
            <div class="message success">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <?php if($error): ?>
            <div class="message error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                >
                <div class="password-requirements">
                    Password must be at least 6 characters long
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password" 
                    required
                >
            </div>

            <button type="submit" class="btn">Register</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>