<?php
session_start();

$rooms = [
    [
        'name' => 'deluxe',
        'type' => 'Deluxe Suite',
        'price' => 789,
        'discount' => 15,
        'perks' => ['King Size Bed', 'Ocean View', 'Mini Bar', 'Room Service', 'Free WiFi'],
        'image' => 'https://images.pexels.com/photos/2506990/pexels-photo-2506990.jpeg?auto=compress&cs=tinysrgb&w=600',
        'description' => 'Luxurious suite with panoramic ocean views',
        'size' => '45 sq m',
        'rating' => 4.8,
        'reviews' => [
            ['text' => 'Absolutely stunning room with incredible views!', 'author' => 'Mamta Sharma', 'rating' => 5],
            ['text' => 'Perfect for our stay', 'author' => 'Sahil Chahar', 'rating' => 5]
        ]
    ],
    [
        'name' => 'standard',
        'type' => 'Executive Room',
        'price' => 999,
        'discount' => 10,
        'perks' => ['Queen Size Bed', 'City View', 'Work Desk', 'Free WiFi'],
        'image' => 'https://images.unsplash.com/photo-1601565415267-724db0e9fbdf?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTIzfHxob3RlbCUyMHJvb21zfGVufDB8fDB8fHww',
        'description' => 'Perfect for business travelers',
        'size' => '35 sq m',
        'rating' => 4.6,
        'reviews' => [
            ['text' => 'Great business amenities', 'author' => 'Rishabh', 'rating' => 4],
            ['text' => 'Comfortable and quiet', 'author' => 'Divya', 'rating' => 5]
        ]
    ],
    [
        'name' => 'suite',
        'type' => 'Family Suite',
        'price' => 1499,
        'discount' => 20,
        'perks' => ['2 Queen Beds', 'Kitchen', 'Living Room', 'Kids Area', 'Free WiFi'],
        'image' => 'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTZ8fGhvdGVsJTIwcm9vbXN8ZW58MHx8MHx8fDA%3D',
        'description' => 'Spacious suite perfect for families',
        'size' => '65 sq m',
        'rating' => 4.9,
        'reviews' => [
            ['text' => 'Perfect for our family of 4', 'author' => 'Ayush Kapoor', 'rating' => 5],
            ['text' => 'Kids loved the play area', 'author' => 'Praveen', 'rating' => 5]
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Rooms - Luxury Hotel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --accent-color: #3498db;
            --background-color: #f5f6fa;
            --text-color: #2c3e50;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .rooms-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .rooms-header h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .rooms-header p {
            font-size: 1.2rem;
            color: #666;
        }

        .bento-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .room-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: var(--card-shadow);
        }

        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .room-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .room-content {
            padding: 1.5rem;
        }

        .room-type {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .room-description {
            color: #666;
            margin-bottom: 1rem;
        }

        .room-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .room-size {
            color: #666;
        }

        .room-rating {
            color: #f1c40f;
        }

        .price-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .original-price {
            text-decoration: line-through;
            color: #999;
        }

        .discounted-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--secondary-color);
        }

        .discount-badge {
            background: var(--secondary-color);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .perks-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .perk {
            background: #f0f2f5;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.9rem;
            color: var(--primary-color);
        }

        .reviews-section {
            border-top: 1px solid #eee;
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .review {
            margin-bottom: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .review-text {
            font-style: italic;
            margin-bottom: 0.5rem;
        }

        .review-author {
            color: #666;
            font-size: 0.9rem;
        }

        .book-button {
            display: block;
            width: 100%;
            padding: 1rem;
            background: var(--primary-color);
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 10px;
            transition: background 0.3s ease;
            margin-top: 1rem;
        }

        .book-button:hover {
            background: var(--secondary-color);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .bento-grid {
                grid-template-columns: 1fr;
            }

            .room-card {
                margin-bottom: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="rooms-header">
            <h1>Experience Luxury</h1>
            <p>Choose from our carefully curated selection of premium rooms and suites</p>
        </div>

        <div class="bento-grid">
            <?php foreach($rooms as $room): ?>
                <div class="room-card">
                    <img src="<?php echo htmlspecialchars($room['image']); ?>" alt="<?php echo htmlspecialchars($room['type']); ?>" class="room-image">
                    <div class="room-content">
                        <h2 class="room-type"><?php echo htmlspecialchars($room['type']); ?></h2>
                        <p class="room-description"><?php echo htmlspecialchars($room['description']); ?></p>
                        
                        <div class="room-details">
                            <span class="room-size">
                                <i class="fas fa-expand-arrows-alt"></i> 
                                <?php echo htmlspecialchars($room['size']); ?>
                            </span>
                            <span class="room-rating">
                                <i class="fas fa-star"></i> 
                                <?php echo number_format($room['rating'], 1); ?>
                            </span>
                        </div>

                        <div class="price-section">
                            <span class="original-price"> ₹<?php echo $room['price']; ?></span>
                            <span class="discounted-price">
                                ₹<?php echo $room['price'] * (1 - $room['discount']/100); ?>
                            </span>
                            <span class="discount-badge">
                                <?php echo $room['discount']; ?>% OFF
                            </span>
                        </div>

                        <div class="perks-list">
                            <?php foreach($room['perks'] as $perk): ?>
                                <span class="perk">
                                    <i class="fas fa-check"></i> 
                                    <?php echo htmlspecialchars($perk); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>

                        <div class="reviews-section">
                            <?php foreach($room['reviews'] as $review): ?>
                                <div class="review">
                                    <div class="review-text">"<?php echo htmlspecialchars($review['text']); ?>"</div>
                                    <div class="review-author">
                                        - <?php echo htmlspecialchars($review['author']); ?>
                                        <span class="review-rating">
                                            <?php for($i = 0; $i < $review['rating']; $i++): ?>
                                                <i class="fas fa-star"></i>
                                            <?php endfor; ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a href="make-reservation.php?room=<?php echo urlencode($room['name']); ?>" class="book-button">
                        Book Now
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>