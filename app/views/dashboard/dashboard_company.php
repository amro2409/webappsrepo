<!-- /views/dashboard/dashboard_company.php -->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'company') {
    header('Location: login.php');
    exit();
}

// جلب بيانات المؤسسة من قاعدة البيانات
include '../../config/database.php';
$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("SELECT * FROM companies WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$company = $stmt->get_result()->fetch_assoc();
$_SESSION['company_name'] = $company['company_name'];
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
        .content {
            padding: 20px;
            padding-left: 310px;
        }

        @media only screen and (max-width : 780px) {
            .content {
                padding-left: 20px;
            }
        }
        .accepted {
    color: green;
}
.rejected {
    color: red;
}
.pending {
    color: orange;
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

                <li>
                    <a class="nav-link active" href="#" onclick="loadContent('compony/profile_details');return false;">
                        <i class="fas fa-user-circle"></i>&nbsp; Profile
                    </a>
                </li>
                <li>
                    <a class="nav-link active" href="#" onclick="loadContent('compony/opportunity_add');return false;"
                        class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>&nbsp; Add Opportunity
                    </a>
                </li>
                <li>
                    <a class="nav-link active" href="#" onclick="loadContent('compony/opportunity_list');return false;"
                        class="btn btn-primary">
                        <i class="fas fa-list-alt"></i>&nbsp; List Opportunity
                    </a>
                </li>
                <li>
                    <a class="nav-link active" href="#" onclick="loadContent('compony/applications_view');return false;"
                        class="btn btn-primary">
                        <i class="fas fa-inbox"></i>&nbsp; Received Applications
                    </a>
                </li>


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
                    <span class="name grey-text text-darken-4">
                        <?php echo $_SESSION['user_id']; ?>
                    </span>
                </a>
                <a href="#">
                    <span class="email grey-text text-darken-4">
                        <?php echo $_SESSION['email']; ?>
                    </span>
                </a>
            </div>
        </li>

        <li><a href="dashboard_company.php"><i class="fas fa-home"></i>&nbsp; Home</a></li>
        <li>
            <a class="nav-link active" href="#" onclick="loadContent('compony/profile_details');return false;">
                <i class="fas fa-user-circle"></i>&nbsp; Profile
            </a>
        </li>
        <li>
            <a class="nav-link active" href="#" onclick="loadContent('compony/opportunity_add');return false;"
                class="btn btn-primary">
                <i class="fas fa-plus-circle"></i>&nbsp; Add Opportunity
            </a>
        </li>
        <li>
            <a class="nav-link active" href="#" onclick="loadContent('compony/opportunity_list');return false;"
                class="btn btn-primary">
                <i class="fas fa-list-alt"></i>&nbsp; List Opportunity
            </a>
        </li>
        <li>
            <a class="nav-link active" href="#" onclick="loadContent('compony/applications_view');return false;"
                class="btn btn-primary">
                <i class="fas fa-inbox"></i>&nbsp; Received Applications
            </a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>
        <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp; Logout</a></li>
        <?php else: ?>
        <li><a href="login.php"><i class="fas fa-sign-in-alt"></i>&nbsp; Login</a></li>
        <?php endif; ?>
    </ul>

    <div class="content flex-grow-1" id="content-area">
     <!-- عرض رسالة النجاح إذا كانت موجودة -->
    <?php if (isset($_GET['message']) && $_GET['message'] === 'opportunity_added'): ?>
        <div id="msgBox" class="alert alert-success" role="alert">
            Opportunity added successfully!
        </div>
    <?php endif; ?>
        <?php if (isset($_GET['message']) && $_GET['message'] === 'opportunity_updated'): ?>
        <div id="msgBox" class="alert alert-success" role="alert">
            Opportunity updated successfully!
        </div>
    <?php endif; ?>
        <h2>Welcome!, <strong style="color:rgb(0, 255, 98);">
                <?php echo $company['company_name']; ?>
            </strong></h2>
        <p>Manage your training opportunities and view student applications.</p>
        <hr />

        <div class="row mt-2">
            <div class="col-md-6 mb-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-user fa-2x mb-2"></i> <!-- Font Awesome icon -->
                        <h5 class="card-title">Profile</h5>
                        <p class="card-text">View and edit your company profile. .</p>
                        <a href="#" onclick="loadContent('compony/profile_details');return false;"
                            class="btn btn-primary">View Profile</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-file-alt fa-2x mb-2"></i>
                        <h5 class="card-title">Add opportunity</h5>
                        <p class="card-text">Create a new training opportunity for students .</p>
                        <a href="#" onclick="loadContent('compony/opportunity_add');return false;"
                            class="btn btn-primary">Add Opportunity </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6 mb-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-paper-plane fa-2x mb-2"></i>
                        <h5 class="card-title">Opportunity List</h5>
                        <p class="card-text">Display all your training opportunities.
                        </p>
                        <a href="#" onclick="loadContent('compony/opportunity_list');return false;"
                            class="btn btn-primary">Submit Application</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-6">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-bell fa-2x mb-2"></i>
                        <h5 class="card-title">Received Applications</h5>
                        <p class="card-text">Check applications submitted by students. .</p>
                        <a href="#" onclick="loadContent('compony/applications_view');return false;"
                            class="btn btn-primary">View Notifications</a>
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
      $(document).ready(function () {
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
            setTimeout(function () {
                $('#msgBox').hide();
            }, 5000);
     
  });

    
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

        // وظيفة لتحديث محتوى الطلبات مع الفلترة


        function filterApplications() {
            const specializationInput = document.getElementById('specialization');
            const cityInput = document.getElementById('city');

            if (!specializationInput || !cityInput) {
                console.error('Specialization or City input fields not found.');
                return;
            }

            const specialization = specializationInput.value;
            const city = cityInput.value;

            fetch('view_applications.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    specialization: specialization,
                    city: city
                })
            })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('content-area').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        }

        function updateApplicationStatus(applicationId, status) {
            const message = status === 'accepted'
                ? 'Are you sure you want to accept this application?'
                : 'Are you sure you want to reject this application?';

            if (confirm(message)) {
                fetch('update_application.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        id: applicationId,
                        status: status
                    })
                })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data);
                        console.log(`Updating status for application ID: ${applicationId}`);
                        // تحديث واجهة المستخدم مباشرة
                        const applicationStatusElement = document.querySelector(`#application-${applicationId} .status`);
                        console.log(applicationStatusElement); // تحقق مما إذا كان العنصر موجودًا
                        if (applicationStatusElement) {
                            applicationStatusElement.innerText = status.charAt(0).toUpperCase() + status.slice(1); // تحديث النص
                            applicationStatusElement.className = `status ${status}`; // تغيير الفئة لتحديث اللون
                        } else {
                            console.error(`Element not found for application ID: ${applicationId}`);
                        }

                        // عرض رسالة Toast
                        Toastify({
                            text: `Application has been ${status}.`,
                            duration: 3000,
                            gravity: "top",
                            position: 'right',
                            backgroundColor: status === 'accepted' ? "green" : "red",
                            stopOnFocus: true
                        }).showToast();
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

    </script>
</body>

</html>