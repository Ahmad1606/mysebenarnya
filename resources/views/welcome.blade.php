<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySebenarnya - News Verification System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1565c0;
            --secondary-color: #e3f2fd;
            --accent-color: #ff8f00;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        
        .navbar-custom {
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-custom .navbar-brand {
            font-weight: 700;
            color: white;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0d47a1 100%);
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }
        
        .hero-title {
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .hero-subtitle {
            font-weight: 300;
            margin-bottom: 30px;
            font-size: 1.25rem;
        }
        
        .btn-hero {
            padding: 12px 30px;
            font-weight: 500;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        
        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .btn-primary-custom {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .btn-primary-custom:hover {
            background-color: #ef6c00;
            border-color: #ef6c00;
        }
        
        .btn-outline-custom {
            color: white;
            border-color: white;
        }
        
        .btn-outline-custom:hover {
            background-color: white;
            color: var(--primary-color);
        }
        
        .feature-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            border: none;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }
        
        .testimonial-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: none;
        }
        
        .testimonial-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 50px;
            font-weight: 600;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: var(--accent-color);
        }
        
        footer {
            background-color: #343a40;
            color: white;
            padding: 50px 0 20px;
            margin-top: auto;
        }
        
        .footer-title {
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .footer-links {
            list-style: none;
            padding-left: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.1);
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background-color: var(--accent-color);
            color: white;
            transform: translateY(-3px);
        }
        
        .copyright {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            margin-top: 30px;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 70px 0;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-check-circle me-2"></i>MySebenarnya
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#how-it-works">How It Works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-2" href="{{ route('register') }}">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="hero-title display-4">Verify News with Confidence</h1>
            <p class="hero-subtitle col-md-8 mx-auto">MySebenarnya is Malaysia's official news verification platform, connecting citizens with government agencies to combat misinformation.</p>
            <div class="mt-5">
                <a href="{{ route('register') }}" class="btn btn-primary-custom btn-hero me-3">
                    <i class="fas fa-user-plus me-2"></i>Create Account
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-custom btn-hero">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="features">
        <div class="container">
            <h2 class="text-center section-title">Key Features</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card text-center p-4">
                        <div class="card-body">
                            <i class="fas fa-search feature-icon"></i>
                            <h4 class="card-title">Verify News</h4>
                            <p class="card-text">Submit news items for official verification by government agencies to determine their accuracy.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card text-center p-4">
                        <div class="card-body">
                            <i class="fas fa-shield-alt feature-icon"></i>
                            <h4 class="card-title">Official Responses</h4>
                            <p class="card-text">Receive verified information directly from authorized government agencies.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card text-center p-4">
                        <div class="card-body">
                            <i class="fas fa-chart-line feature-icon"></i>
                            <h4 class="card-title">Track Progress</h4>
                            <p class="card-text">Monitor the status of your inquiries in real-time through our transparent verification process.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-5 bg-light" id="how-it-works">
        <div class="container">
            <h2 class="text-center section-title">How It Works</h2>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://via.placeholder.com/600x400" alt="How It Works" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6">
                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fw-bold">1</span>
                            </div>
                        </div>
                        <div>
                            <h4>Submit an Inquiry</h4>
                            <p>Register an account and submit the news you want to verify along with any supporting evidence.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fw-bold">2</span>
                            </div>
                        </div>
                        <div>
                            <h4>MCMC Review</h4>
                            <p>The Malaysian Communications and Multimedia Commission reviews your inquiry and assigns it to the appropriate agency.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fw-bold">3</span>
                            </div>
                        </div>
                        <div>
                            <h4>Agency Verification</h4>
                            <p>Government agencies investigate and provide an official response regarding the accuracy of the news.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="me-4">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <span class="fw-bold">4</span>
                            </div>
                        </div>
                        <div>
                            <h4>Get Results</h4>
                            <p>Receive official verification results and share them to combat misinformation.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5" id="testimonials">
        <div class="container">
            <h2 class="text-center section-title">What Users Say</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card testimonial-card text-center p-4">
                        <div class="card-body">
                            <img src="https://via.placeholder.com/150" alt="User" class="testimonial-img">
                            <h5>Ahmad Bin Abdullah</h5>
                            <p class="text-muted">Public User</p>
                            <p class="card-text">"MySebenarnya helped me verify a viral message about COVID-19 that was spreading in my community. The official response came within days."</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card testimonial-card text-center p-4">
                        <div class="card-body">
                            <img src="https://via.placeholder.com/150" alt="User" class="testimonial-img">
                            <h5>Sarah Tan</h5>
                            <p class="text-muted">Teacher</p>
                            <p class="card-text">"As an educator, I use MySebenarnya to teach my students about media literacy and the importance of verifying information before sharing."</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card testimonial-card text-center p-4">
                        <div class="card-body">
                            <img src="https://via.placeholder.com/150" alt="User" class="testimonial-img">
                            <h5>Rajesh Kumar</h5>
                            <p class="text-muted">Business Owner</p>
                            <p class="card-text">"When false information about my business was circulating online, MySebenarnya helped me get an official clarification from authorities."</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-primary text-white text-center">
        <div class="container">
            <h2 class="mb-4">Ready to verify news?</h2>
            <p class="lead mb-4">Join thousands of Malaysians who are fighting misinformation with MySebenarnya</p>
            <a href="{{ route('register') }}" class="btn btn-lg btn-light">Get Started Now</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="footer-title">MySebenarnya</h5>
                    <p>Malaysia's official news verification platform, connecting citizens with government agencies to combat misinformation.</p>
                    <div class="mt-4">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="footer-title">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#testimonials">Testimonials</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="footer-title">Resources</h5>
                    <ul class="footer-links">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Community</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5 class="footer-title">Contact Us</h5>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt me-2"></i> MCMC Headquarters, Cyberjaya</li>
                        <li><i class="fas fa-phone me-2"></i> +603-8688 8000</li>
                        <li><i class="fas fa-envelope me-2"></i> info@mysebenarnya.gov.my</li>
                    </ul>
                </div>
            </div>
            <div class="text-center copyright">
                <p>&copy; {{ date('Y') }} MySebenarnya - Malaysian Communications and Multimedia Commission. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
