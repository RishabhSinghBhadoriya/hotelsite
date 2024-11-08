<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Hotel</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
        }

        .header {
            background: var(--primary-color);
            padding: 1rem;
            position: fixed;
            width: 100%;
            z-index: 100;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            
        }

        .nav a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: color 0.3s ease;
        }

        .nav a:hover {
            color: var(--secondary-color);
        }

        .hero {
            height: 100vh;
            background: url('https://images.unsplash.com/photo-1445019980597-93fa8acb246c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8aG90ZWx8ZW58MHx8MHx8fDA%3D') center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding-top: 80px;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: fadeIn 1s ease-in;
        }

        .bento-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .bento-item {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .bento-item:hover {
            transform: translateY(-5px);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Form styles */
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
        .gallery {
            padding: 4rem 2rem;
            background: #f9f9f9;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            height: 300px;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
            filter: blur(3px) brightness(0.7);
        }

        .gallery-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            width: 90%;
        }

        .gallery-item:hover .gallery-text {
            opacity: 1;
        }

        .features {
            padding: 4rem 2rem;
            background: white;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-item {
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background: #d1d1d1;
            transition: transform 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-10px);
        }

        .special-offers {
            padding: 4rem 2rem;
            background: linear-gradient(to right, #2c3e50, #3498db);
            color: white;
        }

        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .offer-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .offer-card:hover {
            transform: scale(1.05);
        }

        .testimonials {
            padding: 4rem 2rem;
            background: #f9f9f9;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .testimonial-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            font-size: 2.5rem;
            color: var(--primary-color);
        }

        .special-offers .section-title {
            color: white;
        }

        .btn-primary {
            display: inline-block;
            padding: 1rem 2rem;
            background: var(--secondary-color);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background: #c0392b;
        }

        @keyframes slideIn {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .offer-card {
            animation: slideIn 0.5s ease forwards;
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="nav">
            <a href="index.php">Home</a>
            <a href="rooms.php">Rooms</a>
            <a href="make-reservation.php">Book Now</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div>
                <h1>Welcome to Luxury Hotel</h1>
                <p>Experience unparalleled comfort and elegance</p>
            </div>
        </section>

        <section class="bento-grid">
            <div class="bento-item">
                <h2>Luxurious Rooms</h2>
                <p>Choose from our selection of premium rooms</p>
            </div>
            <div class="bento-item">
                <h2>Fine Dining</h2>
                <p>Experience world-class cuisine</p>
            </div>
            <div class="bento-item">
                <h2>Spa & Wellness</h2>
                <p>Relax and rejuvenate</p>
            </div>
        </section>

        <section class="gallery">
            <h2 class="section-title">Explore Our Hotel</h2>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDI1fHx8ZW58MHx8fHx8" alt="Luxury Room">
                    <div class="gallery-text">
                        <h3>Luxury Suites</h3>
                        <p>Spacious rooms with premium amenities</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1581955427155-890ed868b03b?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8ZmluZSUyMGRpbm5pbmd8ZW58MHx8MHx8fDA%3D" alt="Restaurant">
                    <div class="gallery-text">
                        <h3>Fine Dining</h3>
                        <p>Culinary excellence at its finest</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1583417657209-d3dd44dc9c09?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NjN8fHNwYXxlbnwwfHwwfHx8MA%3D%3D" alt="Spa">
                    <div class="gallery-text">
                        <h3>Wellness Spa</h3>
                        <p>Rejuvenate your body and soul</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="features">
            <h2 class="section-title">Why Choose Us</h2>
            <div class="features-grid">
                <div class="feature-item">
                    <h3>24/7 Service</h3>
                    <p>Round-the-clock concierge and room service</p>
                </div>
                <div class="feature-item">
                    <h3>Prime Location</h3>
                    <p>Located in the heart of the city</p>
                </div>
                <div class="feature-item">
                    <h3>Luxury Amenities</h3>
                    <p>Premium facilities and services</p>
                </div>
                <div class="feature-item">
                    <h3>Fine Dining</h3>
                    <p>Award-winning restaurants</p>
                </div>
            </div>
        </section>

        <section class="special-offers">
            <h2 class="section-title">Special Offers</h2>
            <div class="offers-grid">
                <div class="offer-card">
                    <h3>Early Bird Special</h3>
                    <p>Book 60 days in advance and save 25%</p>
                    <p class="price">From ₹499/night</p>
                    <a href="make-reservation.php" class="btn-primary">Book Now</a>
                </div>
                <div class="offer-card">
                    <h3>Weekend Getaway</h3>
                    <p>Stay 3 nights, pay for 2 on weekends</p>
                    <p class="price">From ₹1999/night</p>
                    <a href="make-reservation.php" class="btn-primary">Book Now</a>
                </div>
                <div class="offer-card">
                    <h3>Honeymoon Package</h3>
                    <p>Complimentary spa treatment and dinner</p>
                    <p class="price">From ₹699/night</p>
                    <a href="make-reservation.php" class="btn-primary">Book Now</a>
                </div>
            </div>
        </section>

        <section class="testimonials">
            <h2 class="section-title">Guest Experiences</h2>
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <p>"An unforgettable experience. The service was impeccable and the amenities were top-notch."</p>
                    <h4>- Mamta Sharma</h4>
                </div>
                <div class="testimonial-card">
                    <p>"The perfect getaway. The spa treatments were amazing and the room view was breathtaking."</p>
                    <h4>- Shivam Singh</h4>
                </div>
                <div class="testimonial-card">
                    <p>"Outstanding service and beautiful facilities. Will definitely return!"</p>
                    <h4>- Sunny Chaudhary</h4>
                </div>
            </div>
        </section>
    </main>

    <footer style="background: var(--primary-color); color: white; padding: 2rem; text-align: center; margin-top: 4rem;">
        <p>© 2024 Luxury Hotel. All rights reserved.</p>
        <p>Contact us: info@luxuryhotel.com | +91-828283790</p>
    </footer>

    </main>
</body>
</html>