<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start();

include 'controllers/HomeController.php';

$homeController = new HomeController();
$opportunities = $homeController->getAllOpportunities();
$companies = $homeController->getAllCompanies();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    $homeController->login($email, $password, $user_type);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Opportunities Finder</title>
    <link rel="stylesheet" href="app/assets/css/styles_proj.css">
    <link rel="stylesheet" href="app/assets/css/home_hero_style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!--  
<link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
  -->
</head>

<body>
    <!-- Navigation Bar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Training Finder</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Opportunities</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Institutions</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                    </ul>
                    <div class="nav-right d-flex align-items-center">
                  
                        <a href="views/auth/register_student.php" class="btn btn-outline-primary" >Register as
                            Student</a>
                        <a href="views/auth/register_company.php" class="btn btn-outline-secondary ml-2">Register as
                            Institution</a>
                        <!-- <a href="views/auth/login.php" class="btn btn-outline-success ml-2">Login</a> -->
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- hero  -->
        <section class="hero d-flex flex-column flex-md-row align-items-center justify-content-center py-5">
            <div class="hero-content text-center text-md-left mb-4 mb-md-0 col-md-6">
                <h1 class="display-4">Find the Perfect Training Opportunity</h1>
                <p class="lead">Connecting students with the best training opportunities across the country.Available Training Opportunities</p>
                <div class="hero-buttons">
                    <a href="#" class="btn btn-primary btn-lg mr-2" >Get Started</a>
                    <a href="#" class="btn btn-secondary btn-lg">Learn More</a>
                </div>
            </div>


<div class="hero-signin text-center text-md-left bg-white rounded shadow p-4 col-md-4" style="max-width:400px;">
    <h3>Sign In</h3>
    <hr/>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="example@example.com" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password" class="form-control">
        </div>
        <div class="mb-3">
            <label for="user_type" class="form-label">User Type</label>
            <select class="form-control" id="user_type" name="user_type" required>
                <option value="student">Student</option>
                <option value="company">Company</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Sign In</button>
    </form>
</div>
        </section>

        <!-- Section for AI-powered recommendations 
        <section class="recommendations">
            <h2>Smart Recommendations</h2>
            <p>Get personalized training opportunities based on your skills and interests.</p>
            <div class="recommendation-cards">
                <div class="recommendation-card">
                    <h3>Software Development Internship</h3>
                    <p>Location: Riyadh</p>
                    <p>Duration: 3 months</p>
                    <a href="#" class="btn btn-secondary">Learn More</a>
                </div>
                <div class="recommendation-card">
                    <h3>Data Science Training</h3>
                    <p>Location: Jeddah</p>
                    <p>Duration: 6 months</p>
                    <a href="#" class="btn btn-secondary">Learn More</a>
                </div>
            </div>
        </section>
-->
        <!-- Section for displaying available opportunities -->
 <section class="opportunities">
  <h2 class="text-center mb-4">Available Training Opportunities</h2>
     <div class="opportunity-cards">
    <?php foreach ($opportunities as $opportunity) : ?>
      <div class="opportunity-card">

             <img src="assets/images/hero-image.jpg" alt="Company Logo">
            <h3 ><?php echo $opportunity['opportunity_title']; ?></h3>
            <p >Company:<?php echo substr($opportunity['company_name_fk'], 0, 100) . '...'; ?></p>
            <p>Location:<?php echo $opportunity['location']; ?></p>
            <a href="views/opportunities/details.php?id=<?php echo $opportunity['id']; ?>" class="btn btn-secondary">View Details</a>

      </div>
    <?php endforeach; ?>
  </div>
</section>
 <!--
<section class="opportunities">
    <h2 class="text-le mb-4">Available Training Opportunities</h2>
    <div class="container">
        <div class="row">
            <?php foreach ($opportunities as $opportunity) : ?>
                <div class="col-md-4 mb-4"> 
                    <div class="card">
                        <img src="assets/images/hero-image.jpg" class="card-img-top" alt="Company Logo">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo htmlspecialchars($opportunity['opportunity_title']); ?></h3>
                            <p class="card-text">Company: <?php echo htmlspecialchars(substr($opportunity['company_name_fk'], 0, 100) . '...'); ?></p>
                            <p class="card-text">Location: <?php echo htmlspecialchars($opportunity['location']); ?></p>
                            <a href="views/opportunities/details.php?id=<?php echo $opportunity['id']; ?>" class="btn btn-secondary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section> -->
 

        <!-- Section for institutions -->
        <section class="institutions">
            <h2>Partnered Institutions</h2>
            <div class="institution-cards">
              <?php foreach ($companies as $company) : ?>
                <div class="institution-card">
                    <img src="assets/images/company.png" alt="Institution 1">
                    <h3><?php echo $company['company_name']; ?></h3>
                    <p><?php echo $company['description']; ?></p>
                    <a href="views/dashboard/compony/company_details.php?id=<?php echo $company['id']; ?>" class="btn btn-secondary">View Details</a>

                </div>
              <?php endforeach; ?>
        
            </div>
           <!-- <a href="#" class="btn btn-primary">See All Institutions</a> -->
        </section>


    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-col">
                <h4>Contact</h4>
                <p>Training Opportunities Finder<br>
                    Phone: (123) 456-7890<br>
                    Email: info@trainingfinder.com</p>
            </div>
            <div class="footer-col">
                <h4>Follow Us</h4>
                <ul class="social-links">
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">LinkedIn</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Opportunities</a></li>
                    <li><a href="#">Institutions</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Training Opportunities Finder. All rights reserved.</p>
        </div>
    </footer>
    
</body>

<script src="app/assets/js/home.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>