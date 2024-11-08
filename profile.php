<?php
require_once 'config.php';
require_once 'User.php';
session_start();

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$bookingStmt = $conn->prepare("
    SELECT booking_id, room_type, check_in, check_out, status, booking_date 
    FROM bookings 
    WHERE user_id = ? 
    ORDER BY booking_date DESC
");
$bookingStmt->execute([$_SESSION['user_id']]);
$bookings = $bookingStmt->fetchAll(PDO::FETCH_ASSOC);

$success = $error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newUsername = trim($_POST['username']);
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    
    if(empty($newUsername)) {
        $error = "Username cannot be empty";
    } elseif(strlen($newUsername) < 3) {
        $error = "Username must be at least 3 characters long";
    } else {
        try {
            $updateStmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
            $updateStmt->execute([$newUsername, $_SESSION['user_id']]);
            
            if(!empty($currentPassword) && !empty($newPassword)) {
                $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $userData = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if(password_verify($currentPassword, $userData['password'])) {
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $updateStmt->execute([$hashedNewPassword, $_SESSION['user_id']]);
                    $success = "Profile updated successfully";
                } else {
                    $error = "Current password is incorrect";
                }
            } else {
                $success = "Profile updated successfully";
            }
            
            $_SESSION['username'] = $newUsername;
            
        } catch(PDOException $e) {
            $error = "Update failed: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Luxury Hotel</title>
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
            padding: 2rem;
        }

        .profile-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #eee;
        }

        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .bookings-table th,
        .bookings-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .message {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .success { background: var(--success-color); color: white; }
        .error { background: var(--error-color); color: white; }

        .btn {
            padding: 0.75rem 1.5rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background: var(--secondary-color);
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
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1>My Profile</h1>
        
        <?php if($success): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="section">
            <h2>Profile Information</h2>
            <form method="POST" action="profile.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" 
                           value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email (cannot be changed)</label>
                    <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" 
                           readonly disabled>
                </div>

                <h3>Change Password</h3>
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password">
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password">
                </div>

                <button type="submit" class="btn">Update Profile</button>
            </form>
        </div>

        <div class="section">
            <h2>Booking History</h2>
            <?php if(empty($bookings)): ?>
                <p>No bookings found.</p>
            <?php else: ?>
                <table class="bookings-table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Room Type</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($bookings as $booking): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['booking_id']); ?></td>
                                <td><?php echo htmlspecialchars($booking['room_type']); ?></td>
                                <td><?php echo htmlspecialchars($booking['check_in']); ?></td>
                                <td><?php echo htmlspecialchars($booking['check_out']); ?></td>
                                <td><?php echo htmlspecialchars($booking['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div>
            <a href="logout.php" class="btn" style="background: var(--secondary-color);">Logout</a>
            <a href="index.php" class="btn">Back to Home</a>
        </div>
    </div>
</body>
</html>