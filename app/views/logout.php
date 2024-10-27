
<?php
session_start();

// تحقق مما إذا كانت المتغيرات موجودة قبل تفريغها
if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
}

if (isset($_SESSION['email'])) {
    unset($_SESSION['email']);
}

if (isset($_SESSION['company_name'])) {
    unset($_SESSION['company_name']);
}

// تدمير جميع بيانات الجلسة
$_SESSION = array();

// إذا كانت الجلسة مستخدمة مع ملف تعريف ارتباط، قم بتدميرها
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// تدمير الجلسة
 session_destroy();
 //session_unset();
// إعادة التوجيه إلى صفحة تسجيل الدخول أو الصفحة الرئيسية
    header("Location: auth/login.php");
    exit();
?>
