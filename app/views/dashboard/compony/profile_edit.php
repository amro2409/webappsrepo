<?php
session_start();
include '../../../config/database.php'; // تأكد من وضع مسار قاعدة البيانات الصحيح
$db = new Database();
$conn = $db->connect();
$company_name = $_SESSION['company_name'];
$msg = '';
$msgClass = '';

// تحقق من أن الطلب هو GET لجلب بيانات الشركة
if (isset($company_name)) {
    // جلب بيانات الشركة
    $stmt = $conn->prepare("SELECT * FROM companies WHERE company_name = ?");
    $stmt->bind_param("s", $company_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $company = $result->fetch_assoc();
    } else {
        echo "<p>Company not found.</p>";
        exit();
    }

    $stmt->close();
} else {
    echo "<p>Invalid request.</p>";
    exit();
}

// تحقق من أن الطلب هو POST لتحديث بيانات الشركة
if ($_SERVER['REQUEST_METHOD'] == 'POST' && filter_has_var(INPUT_POST, 'submit')) {
    $company_id = $_GET['id'];
    // جمع البيانات من النموذج
    $name = $_POST['company_name'];
    $type = $_POST['type'];
    $established_date = $_POST['established_date'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $website = $_POST['website'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $category = $_POST['category'];

    // Check required fields
    if (!empty($name) && !empty($type) && !empty($address) && !empty($phone)) {
        // استعلام التحديث
        $stmt = $conn->prepare("UPDATE companies SET company_name = ?, type = ?, established_date = ?, address = ?, phone = ?, email = ?, website = ?, description = ?, status = ?, category = ? WHERE id = ?");
        $stmt->bind_param("ssssssssssi", $name, $type, $established_date, $address, $phone, $email, $website, $description, $status, $category, $company_id);

        // تنفيذ الاستعلام والتحقق من النجاح
        if ($stmt->execute()) {
            $msg = "تم تحديث المؤسسة بنجاح! <a href='http://www.alkadev.lovestoblog.com/app/views/dashboard/dashboard_company.php' class='black-text'>العودة</a>";
            $msgClass = "green";
        } else {
            $msg = "خطأ في تحديث المؤسسة: " . $stmt->error;
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
    <title>تعديل بيانات المؤسسة</title>
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
                    <span class="card-title center-align">تعديل بيانات المؤسسة</span>
                    <div class="row">
                        <form class="col s12" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $company['id']; ?>" novalidate>
                            <div class="input-field">
                                <i class="material-icons prefix">account_circle</i>
                                <label for="company_name">اسم المؤسسة</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo htmlspecialchars($company['company_name']); ?>" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">business</i>
                                <label for="type">نوع المؤسسة</label>
                                <input type="text" class="form-control" id="type" placeholder="نوع المؤسسة (حكومية، خاصة، غير ربحية، إلخ)" name="type" value="<?php echo htmlspecialchars($company['type']); ?>" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">event</i>
                                <label for="established_date">تاريخ التأسيس</label>
                                <input type="date" class="form-control" id="established_date" name="established_date" value="<?php echo htmlspecialchars($company['established_date']); ?>" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">home</i>
                                <label for="address">عنوان المؤسسة</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($company['address']); ?>" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">phone</i>
                                <label for="phone">رقم الهاتف</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($company['phone']); ?>" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">email</i>
                                <label for="email">البريد الإلكتروني</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($company['email']); ?>" required>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">language</i>
                                <label for="website">الموقع الإلكتروني</label>
                                <input type="url" class="form-control" id="website" name="website" value="<?php echo htmlspecialchars($company['website']); ?>">
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">verified_user</i>
                                <label for="status">حالة المؤسسة</label>
                                <select id="status" name="status" required>
                                    <option value="" disabled>Select Company Status</option>
                                    <option value="active" <?php echo ($company['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo ($company['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                    <option value="closed" <?php echo ($company['status'] == 'closed') ? 'selected' : ''; ?>>Closed</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">category</i>
                                <label for="category"> Category</label>
                              <input type="url" class="form-control" id="category" name="category">
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">description</i>
                                <label for="description">وصف المؤسسة</label>
                                <textarea class="materialize-textarea" placeholder="وصف مفصل لأهداف ونشاطات المؤسسة" id="description" name="description"><?php echo htmlspecialchars($company['description']); ?></textarea>
                            </div>
                            <button type="submit" name="submit" class="btn">تحديث المؤسسة</button>
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