<!-- /views/auth/register_company.php -->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include '../../config/database.php'; // تأكد من وضع مسار قاعدة البيانات الصحيح
$db = new Database();
$conn = $db->connect();

$msg = '';
$msgClass = '';

// تحقق من أن الطلب هو POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && filter_has_var(INPUT_POST, 'submit')) {
    // جمع البيانات من النموذج
    $name = $_POST['company_name'];
    $type = $_POST['type'];
    $established_date = $_POST['established_date'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $website = $_POST['website'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $category = $_POST['category'];

    // Check required fields
    if (!empty($name) && !empty($type) && !empty($address) && !empty($phone)) {
        // استعلام الإدخال
        $stmt = $conn->prepare("INSERT INTO companies (company_name, type, established_date, address, phone, email,password, website, description, status, category) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $name, $type, $established_date, $address, $phone, $email,$password, $website, $description, $status, $category);

        // تنفيذ الاستعلام والتحقق من النجاح
        if ($stmt->execute()) {
            $msg = "تم تسجيل المؤسسة بنجاح! <a href='login.php' class='black-text'>Login</a>";
            $msgClass = "green";
        } else {
            $msg = "خطأ في إضافة المؤسسة: " . $stmt->error;
            $msgClass = "red";
        }
        // إغلاق البيان
        $stmt->close();
    } else {
        // إذا كانت الحقول المطلوبة غير مكتملة
        $msg = "يرجى ملء جميع الحقول المطلوبة.";
        $msgClass = "red";
    }
    // إغلاق الاتصال
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة مؤسسة</title>
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
                    <span class="card-title center-align">Company Registration Form</span>
                    <div class="row">
                        <form class="col s12" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                            <div class="input-field">
                                <i class="material-icons prefix">account_circle</i>
                                <label for="company_name">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">business</i>
                                <label for="type">Type of Company</label>
                                <input type="text" class="form-control" id="type" placeholder="Type of company (Government, Private, Non-profit, etc.)" name="type" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">event</i>
                                <label for="established_date">Established Date</label>
                                <input type="date" class="form-control" id="established_date" name="established_date" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">home</i>
                                <label for="address">Company Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">phone</i>
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">email</i>
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                                <div class="input-field">
                                <label for="password" class="form-label">Password</label>
                                 <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">language</i>
                                <label for="website">Website</label>
                                <input type="url" class="form-control" id="website" name="website">
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">verified_user</i>
                                <label for="status">Company Status</label>
                                <select id="status" name="status" required>
                            
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="closed">Closed</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">description</i>
                                <label for="description">Company Description</label>
                                <textarea class="materialize-textarea" placeholder="Detailed description of the company's goals and activities" id="description" name="description"></textarea>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">category</i>
                                <label for="category"> Category</label>
                              <input type="url" class="form-control" id="category" name="category">

                            </div>
                            <button type="submit" name="submit" class="btn">Register Company</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('textarea');
            var instances = M.Textarea.init(elems);
        });
    </script>
</body>
</html>

