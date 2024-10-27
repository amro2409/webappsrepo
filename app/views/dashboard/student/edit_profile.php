<?php
session_start();
include '../../../config/database.php'; // تأكد من وضع مسار قاعدة البيانات الصحيح
$db = new Database();
$conn = $db->connect();
$user_id = $_SESSION['user_id'];
$msg = '';
$msgClass = '';

// تحقق من أن الطالب مسجل الدخول
if (!isset($user_id)) {
    echo "<p>Access denied.</p>";
    exit();
}

// جلب بيانات الطالب
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "<p>Student not found.</p>";
    exit();
}

$stmt->close();

// تحقق من أن الطلب هو POST لتحديث بيانات الطالب
if ($_SERVER['REQUEST_METHOD'] == 'POST' && filter_has_var(INPUT_POST, 'submit')) {
    // جمع البيانات من النموذج
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];
    $specialization = $_POST['specialization'];
    $address = $_POST['address'];
       $city = $_POST['city'];

    // Check required fields
    if (!empty($name) && !empty($email) && !empty($phone)) {
        // استعلام التحديث
        $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, phone_number = ?, birthdate = ?, specialization = ?, city = ?,address = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $name, $email, $phone, $birthdate, $specialization, $city, $address, $user_id);

        // تنفيذ الاستعلام والتحقق من النجاح
        if ($stmt->execute()) {
            $msg = "تم تحديث بيانات الطالب بنجاح! <a href='../dashboard_student.php' class='black-text'>العودة</a>";
            $msgClass = "green";
        } else {
            $msg = "خطأ في تحديث البيانات: " . $stmt->error;
            $msgClass = "red";
        }
        // إغلاق البيان
        $stmt->close();
    } else {
        // إذا كانت الحقول المطلوبة غير مكتملة
        $msg = "يرجى ملء جميع الحقول المطلوبة.";
        $msgClass = "red";
    }
}

// إغلاق الاتصال
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>  Edit Data profile</title>
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
                    <span class="card-title center-align"> Edit Data profile</span>
                    <div class="row">
                        <form class="col s12" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                            <div class="input-field">
                                <i class="material-icons prefix">account_circle</i>
                                <label for="name"> Name </label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">email</i>
                                <label for="email">Email </label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">phone</i>
                                <label for="phone">phone No </label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone_number']); ?>" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">event</i>
                                <label for="birthdate">Dirthdate </label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($student['birthdate']); ?>" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">school</i>
                                <label for="specialization">specialization</label>
                                <input type="text" class="form-control" id="specialization" name="specialization" value="<?php echo htmlspecialchars($student['specialization']); ?>">
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">city</i>
                                <label for="address">City</label>
                                <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($student['city']); ?>">
                            </div>
                               <div class="input-field">
                                <i class="material-icons prefix">home</i>
                                <label for="address">address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($student['address']); ?>">
                            </div>
                            <button type="submit" name="submit" class="btn">UPDATE Data profile</button>
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
</body>
</html>