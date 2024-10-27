<!-- /views/auth/register_student.php -->
<?php
include '../head.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // تشفير كلمة المرور

    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("INSERT INTO students (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
          header('Location: login.php');
         echo "Registration successful. You can now log in.";

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}else{
     print( "ready!"); 
}
?>

<div class="container mt-5 bg-white rounded  shadow p-4 col-lg-5" >
  <h2>Student Registration</h2>
  <form action="register_student.php" method="POST">
  <hr/>
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" required>
    </div>
<div class="mb-3">
      <label for="city" class="form-label">City:</label>
      <input type="text"  class="form-control" id="city" name="city" required>
   </div>
    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</div>

<!-- <form action="process_registration.php" method="POST">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        
        <label for="city">City:</label>
        <input type="text" id="city" name="city" required><br>
        
        <button type="submit">Register</button>
    </form> -->

<?php include '../footer.php'; ?>
