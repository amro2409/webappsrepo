<?php
session_start();

$msg = '';
$msgClass = '';
 
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    header('Location: ../auth/login.php');
    exit();
}

include '../../config/database.php';
$db = new Database();
$conn = $db->connect();

$opportunity_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $opportunity_id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email =  $_SESSION['email'] ;
    $city = $_POST['city'];
    $cover_letter = $_POST['cover_letter'];

    // التعامل مع رفع السيرة الذاتية
    $resume = $_FILES['resume'];
    $resume_name = $resume['name'];
    $resume_tmp = $resume['tmp_name'];
    $resume_ext = strtolower(pathinfo($resume_name, PATHINFO_EXTENSION));
    $allowed_exts = ['pdf', 'doc', 'docx'];

    if (in_array($resume_ext, $allowed_exts)) {
        $resume_new_name = uniqid() . '.' . $resume_ext;
        $resume_dir = '../../uploads/resumes/' . $resume_new_name;

        if (move_uploaded_file($resume_tmp, $resume_dir)) {
            // إدخال البيانات في قاعدة البيانات
            $stmt = $conn->prepare("INSERT INTO applications (opportunity_id_fk, student_id_fk, full_name, email, city, cover_letter, resume,status) VALUES (?,?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iisssss", $opportunity_id, $_SESSION['user_id'], $full_name, $email, $city, $cover_letter, $resume_new_name,"pending");

            if ($stmt->execute()) {
                $msg = "Applied successfully! <a href='http://alkadev.lovestoblog.com/app/views/opportunities/index.php' class='black-text'>Login</a>";
                $msgClass = "green";
            } else {
                $msg = "Error submitting your application: " . $stmt->error;
                $msgClass = "red";
            }
        } else {
            $msg = "Error uploading your resume.";
            $msgClass = "red";
        }
    } else {
        $msg = "Only PDF, DOC, and DOCX files are allowed.";
        $msgClass = "red";
    }
}

?>


<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Applied </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col s10 m6 l6 offset-s1 offset-m3 offset-l4">
            <?php if ($msg != ''): ?>
                <div id="msgBox" class="card-panel <?php echo $msgClass; ?>">
                    <span class="white-text"><?php echo $msg; ?></span>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-content">   
                    <span class="card-title center-align">Apply for Opportunity Form</span>
                    <div class="row">   
                        <form class="col s12" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <input type="hidden" class="form-control" name="id" value="<?php echo $opportunity_id; ?>">
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
                            </div>
                          
                            <div class="mb-3">
                                <input type="text" class="form-control" name="city" placeholder="City" required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" name="cover_letter" placeholder="Cover Letter" rows="5" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="resume">Upload Your Resume (PDF, DOC, DOCX)</label>
                                <input type="file" class="form-control" name="resume" id="resume" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Application</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>