<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    header('Location: auth/login.php');
    exit();
}
require '../../config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="../../assets/css/materialize.min.css">
    <script src="../../assets/js/fontawesome-all.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
   .content{
        padding:20px;
        padding-left: 310px;
   }
 @media only screen and (max-width : 780px) {
   .content {
     padding-left: 20px;
      }
    }
  </style>
</head>
<body>
 
        <nav class="grey darken-2 hide-on-med-and-up" role="navigation">
        <div class="nav-wrapper container">
            <span class="navbar-toggler-icon"></span>
           
                <ul id="nav-mobile" class="side-nav">
                    <li>
                        <div class="user-view">
                            <div class="background">
                                <img src="../../assets/images/bg_img.jpeg" alt="ocean">
                            </div>
                            <a href="">
                                <img src="../../assets/logo.png" alt="" class="responsive-img" height="50%" width="100%">
                            </a>
                            <a href="#">
                                <span class="name grey-text text-darken-4">Muhammed Ali</span>
                            </a>
                            <a href="#">
                                <span class="email grey-text text-darken-4">Muhammed@gmail.com</span>
                            </a>
                        </div>
                    </li>
                    <li><a href="dashboard_student.php"><i class="fas fa-home"></i>&nbsp; Home</a></li>   
                     <li><a class="nav-link active" href="#" onclick="loadContent('student/profile');return false;"> <i class="fas fa-user"></i>&nbsp; Profile</a></li>

            <li><a class="nav-link active" href="#" onclick="loadContent('student/search_opportunities');return false;" class="btn btn-primary"><i class="fas fa-paper-plane"></i>&nbsp; search opportunities Applications</a></li>

             
            <li><a class="nav-link active" href="#" onclick="loadContent('student/my_applications');return false;" class="btn btn-primary">
             <i class="fas fa-file-alt"></i>&nbsp;My Applications</a></li>
             
            <li><a class="nav-link active" href="#" onclick="loadContent('student/notifications');return false;" class="btn btn-primary">
              <i class="fas fa-bell"></i>&nbsp;notifications</a></li>
                    <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp; Logout</a></li>
                </ul>
                <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
            </div>
        </nav>
   

    <ul class="side-nav fixed">
        <li>
            <div class="user-view">
                <div class="background">
                    <img src="../../assets/images/bg_img.jpeg" alt="ocean">
                </div>
                <img src="../../assets/logo.png" alt="" class="responsive-img" height="50%" width="100%">
                <a href="#">
                    <span class="name grey-text text-darken-4"><?php echo $_SESSION['user_id']; ?></span>
                </a>
                <a href="#">
                    <span class="email grey-text text-darken-4"><?php echo $_SESSION['email']; ?></span>
                </a>
            </div>
        </li>
        <li><a href="dashboard_student.php"><i class="fas fa-home"></i>&nbsp; Home</a></li>

        <li><a class="nav-link active" href="#" onclick="loadContent('student/profile');return false;">
            <i class="fas fa-user"></i>&nbsp; Profile</a></li>

            <li><a class="nav-link active" href="#" onclick="loadContent('student/search_opportunities');return false;" class="btn btn-primary">
             <i class="fas fa-paper-plane"></i>&nbsp; search Opportunities</a></li>

             
            <li><a class="nav-link active" href="#" onclick="loadContent('student/my_applications');return false;" class="btn btn-primary">
             <i class="fas fa-file-alt"></i>&nbsp;My Applications</a></li>
             
            <li><a class="nav-link active" href="#" onclick="loadContent('student/notifications');return false;" class="btn btn-primary">
              <i class="fas fa-bell"></i>&nbsp;notifications</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp; Logout</a></li>
        <?php else: ?>
            <li><a href="login.php"><i class="fas fa-sign-in-alt"></i>&nbsp; Login</a></li>
        <?php endif; ?>
    </ul>

    <div class="content flex-grow-1" id="content-area">
        <h2>Welcome!</h2>
        <p>Select an option from the sidebar to view content.</p>
        <p>Here you can search for training opportunities, upload your resume, and manage your applications.</p>

        <div class="row mt-2">
          <div class="col-md-6 mb-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-user fa-2x mb-2"></i> <!-- Font Awesome icon -->
                        <h5 class="card-title">Profile</h5>
                        <p class="card-text">Manage your profile .</p>
                        <a href="#" onclick="loadContent('student/profile');return false;" class="btn btn-primary">View Profile</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-file-alt fa-2x mb-2"></i>
                        <h5 class="card-title">My Applications</h5>
                        <p class="card-text">View your applications.</p>
                        <a href="#" onclick="loadContent('student/my_applications');return false;" class="btn btn-primary">View Applications</a>
                    </div>
                </div>
             </div>
            </div>
     <div class="row mt-2">
            <div class="col-md-6 mb-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-paper-plane fa-2x mb-2"></i>
                        <h5 class="card-title"> New Application</h5>
                        <p class="card-text">Apply for new opportunities.</p>
                        <a href="#" onclick="loadContent('student/search_opportunities');return false;" class="btn btn-primary">Submit Application</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-bell fa-2x mb-2"></i>
                        <h5 class="card-title">Notifications</h5>
                        <p class="card-text">Check your notifications.</p>
                        <a href="#" onclick="loadContent('student/notifications');return false;" class="btn btn-primary">View Notifications</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../../assets/js/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/materialize.min.js"></script>



<script>

    function loadContent(page) {
        fetch(page + '.php')
            .then(response => {
                if (!response.ok) {
                   // throw new Error('Network response was not ok ' + response.statusText);
                    console.error('Network response was not ok ' + response.statusText);
                    document.getElementById('content-area').innerHTML = "<p>Network response was not ok .</p>";
                }
                return response.text();
            })
            .then(data => {
                document.getElementById('content-area').innerHTML = data;
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
                document.getElementById('content-area').innerHTML = "<p>Error loading content.</p>";
            });
    }
      function filterOpportunities() {
            const searchQueryInput = document.getElementById('query');
         

            if (!searchQueryInput) {
                console.error('Specialization or City input fields not found.');
                return;
            }

            const specialization = searchQueryInput.value;
          
            fetch('student/search_opportunities.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    query: specialization
                })
            })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('content-area').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        }

    $(document).ready(function() {
    $('.button-collapse').sideNav();
    // Initialize modal
    $('.modal').modal();

    // Initialize select list
    $('select').material_select();

    // Initialize datepicker
    $('.datepicker').pickadate({
      format: 'dd/mm/yy'
    });

    $('.tooltipped').tooltip();

    // Hide messagebox after 5 second
    setTimeout(function(){
      $('#msgBox').hide();
    }, 5000);

  });
</script>
</body>
</html>