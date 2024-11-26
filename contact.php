<!DOCTYPE html>
<html lang="en">

<?php include("vendor/inc/head.php");?>

<body>
    <!-- Navigation -->
    <?php include("vendor/inc/nav.php");?>

    <!-- Hero Section -->
    <div class="contact-hero">
        <div class="overlay"></div>
        <div class="container">
            <h1 class="text-white text-center">Get In Touch</h1>
            <p class="text-white text-center lead">We're here to help and answer any questions you might have</p>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <!-- Contact Cards -->
            <div class="col-md-4 mb-4">
                <div class="contact-card text-center p-4">
                    <div class="icon-circle mb-4">
                        <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                    </div>
                    <h4>Visit Us</h4>
                    <p>123 Demo Street<br>Sample City, 12345</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="contact-card text-center p-4">
                    <div class="icon-circle mb-4">
                        <i class="fas fa-phone fa-2x text-primary"></i>
                    </div>
                    <h4>Call Us</h4>
                    <p>(123) 456-7890</p>
                    <p class="text-muted">Mon-Fri: 9:00 AM - 5:00 PM</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="contact-card text-center p-4">
                    <div class="icon-circle mb-4">
                        <i class="fas fa-envelope fa-2x text-primary"></i>
                    </div>
                    <h4>Email Us</h4>
                    <a href="mailto:citytaxi@gmail.com" class="text-decoration-none">citytaxi@gmail.com</a>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.7287805603396!2d79.86363419999999!3d6.9229902!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2593e45d939f5%3A0x6ad64989791f5800!2sCity%20taxi!5e0!3m2!1sen!2slk!4v1732349896374!5m2!1sen!2slk" 
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include("vendor/inc/footer.php");?>

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>

    <style>
        /* Custom CSS */
        .contact-hero {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('vendor/img/contact-hero.jpg');
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            position: relative;
            margin-bottom: 50px;
        }

        .contact-hero .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.1);
        }

        .contact-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .contact-card:hover {
            transform: translateY(-5px);
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .map-container {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .text-primary {
            color: #007bff !important;
        }

        .lead {
            font-size: 1.25rem;
            font-weight: 300;
        }
    </style>
</body>
</html>