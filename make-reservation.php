<?php
require_once 'Booking.php';
require_once 'config.php';
session_start();

$room_configs = [
    'standard' => [
        'name' => 'Executive Room',
        'price' => 499,
        'image' => 'https://images.unsplash.com/photo-1601565415267-724db0e9fbdf?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTIzfHxob3RlbCUyMHJvb21zfGVufDB8fDB8fHww',
        'max_guests' => 2
    ],
    'deluxe' => [
        'name' => 'Deluxe Suite',
        'price' => 699,
        'image' => 'https://images.pexels.com/photos/2506990/pexels-photo-2506990.jpeg?auto=compress&cs=tinysrgb&w=600',
        'max_guests' => 3
    ],
    'suite' => [
        'name' => 'Family Suite',
        'price' => 799,
        'image' => 'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTZ8fGhvdGVsJTIwcm9vbXN8ZW58MHx8MHx8fDA%3D',
        'max_guests' => 4
    ]
];

$selected_room_type = 'standard'; 
if (isset($_GET['room'])) {
    $room_key = strtolower(str_replace(' ', '', trim($_GET['room'])));
    if (array_key_exists($room_key, $room_configs)) {
        $selected_room_type = $room_key;
    }
}

$selected_room = $room_configs[$selected_room_type];
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$database = new Database();
$db = $database->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_type = $_POST['room_type'] ?? '';
    $check_in = $_POST['check_in'] ?? '';
    $check_out = $_POST['check_out'] ?? '';
    $guests = $_POST['guests'] ?? '';

    if (isset($room_configs[$room_type]) && $check_in && $check_out && $guests) {
        $booking = new Booking($db);
        if ($booking->createBooking($user_id, $room_type, $check_in, $check_out, $guests)) {
            $success = "Booking request received for {$room_configs[$room_type]['name']}";
        } else {
            $error = "Failed to create booking.";
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .booking-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .room-preview {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .room-info {
            margin-top: 15px;
        }

        .room-price {
            font-size: 24px;
            color: #2c3e50;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #2c3e50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #34495e;
        }

        .success {
            background-color: #2ecc71;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .error {
            background-color: #e74c3c;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        img.room-image {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <h2>Make a Reservation</h2>
        
        <?php if(isset($success)): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if(isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="room-preview">
            <img src="<?php echo htmlspecialchars($selected_room['image']); ?>" 
                 alt="<?php echo htmlspecialchars($selected_room['name']); ?>"
                 class="room-image">
            <div class="room-info">
                <h3><?php echo htmlspecialchars($selected_room['name']); ?></h3>
                <p class="room-price">₹<?php echo htmlspecialchars($selected_room['price']); ?> per night</p>
                <p>Maximum guests: <?php echo htmlspecialchars($selected_room['max_guests']); ?></p>
            </div>
        </div>

        <form method="POST">
    <div class="form-group">
        <label for="room_type">Room Type:</label>
        <select name="room_type" id="room_type" required>
            <?php foreach ($room_configs as $type => $room): ?>
                <option value="<?php echo htmlspecialchars($type); ?>"
                        <?php echo $type === $selected_room_type ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($room['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="check_in">Check-in Date:</label>
        <input type="date" id="check_in" name="check_in" required
               min="<?php echo date('Y-m-d'); ?>">
    </div>

    <div class="form-group">
        <label for="check_out">Check-out Date:</label>
        <input type="date" id="check_out" name="check_out" required
               min="<?php echo date('Y-m-d'); ?>">
    </div>

    <div class="form-group">
        <label for="guests">Number of Guests:</label>
        <input type="number" id="guests" name="guests" required min="1" max="<?php echo $selected_room['max_guests']; ?>">
    </div>

    <button type="submit" class="btn">Make Reservation</button>
</form>


    <script>
        document.getElementById('room_type').addEventListener('change', function() {
            window.location.href = 'make-reservation.php?room=' + this.value;
        });
    </script>
</body>
</html>