<!-- /views/auth/login.php -->
<?php
session_start();
// منع التخزين المؤقت
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include 'navbar.php';
require '../../config/database.php';
//include '../head.php';

  //Error message and class
  $msg = $msgClass = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    $db = new Database();
    $conn = $db->connect();

    if ($user_type == 'student') {
        $stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
    } else {
        $stmt = $conn->prepare("SELECT * FROM companies WHERE email = ?");
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_type'] = $user_type;
        $_SESSION['email'] = $email;
        if ($user_type == 'student') {
            header('Location: ../dashboard/dashboard_student.php');
        } else {
            header('Location: ../dashboard/dashboard_company.php');
        }
        exit();
    } else {
            // Redirect back to login with an error
           // header('Location: login.php?error=Invalid_credentials');
          // failed ouput an error
      $msg = "Invalid credentials.";
      $msgClass = "red";
    }

    $stmt->close();
    $conn->close();
}else{
          // failed ouput an error
      $msg = "Please fill in all fields";
      $msgClass = "red";
}
?>



<!-- Login form -->
<div class="container">
  <div class="box1">
    <div class="row">
    <div class="col s12 m12">
        <?php if($msg != ''): ?>
          <div id="msgBox" class="card-panel <?php echo $msgClass; ?>">
            <span class="white-text"><?php echo $msg; ?></span>
          </div>
        <?php endif ?>
        <div class="card">
          <div class="card-image">
            <img id="userimg" src="../../assets/images/user.png" class="circle responsive-img">
          </div>
          <div class="card-content">
            <h2 class="card-title center-align">User Login</h2>
            <div class="row">
              <form class="col s12" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                <div class="row">
                  <div class="input-field">
                    <i class="material-icons prefix">account_circle</i>
                    <input type="email" id="email" name="email" >
                    <label for="email" class="form-label">Email</label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field">
                      <i class="material-icons prefix">lock</i>
                    <input type="password" id="password" name="password">
                    <label for="password" class="form-label">Your Password</label>
                  </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">select_all</i>
                    
                        <select class="form-control" id="user_type" name="user_type">
                            <option value="" disabled selected>Choose your option</option>
                            <option value="student">Student</option>
                            <option value="company">Company</option>
                        </select>
                         <label for="user_type" class="form-label">User Type</label>
                    </div>
                </div>
                <div class="row">
                  <p class="center-align">
                    <button type="submit" class="waves-effect waves-light btn btn-primary" name="submit">Login</button>
                  </p>
                </div>
              </form>
            </div>
          </div>
        </div>
          </div>
    </div>
  </div>
</div>
<!-- end login form -->


<?php include 'footer.php'; ?>
