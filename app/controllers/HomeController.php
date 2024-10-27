<?php
// homeController.php

include $_SERVER['DOCUMENT_ROOT'] .'/app/config/database.php';


class HomeController {
    //private $userModel;

    //public function __construct($userModel) {
     //   $this->userModel = $userModel;
   // }

    public function login($email, $password, $user_type) {

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
            header('Location: app/views/dashboard/dashboard_student.php');
        } else {
            header('Location: app/views/dashboard/dashboard_company.php');
        }
        exit();
    } else {
        //echo "Invalid credentials.";
            // Redirect back to login with an error
    header('Location: http://alkadev.lovestoblog.com?error=Invalid credentials');
    }

    $stmt->close();
    $conn->close();
    }

    
    // جلب كل الفرص التدريبية
public function getAllOpportunities() {
    $db = new Database();
    $conn = $db->connect();

    if (!$conn) {
        error_log("Failed to connect to the database."); // تسجيل الخطأ
        return [];
    }

    $sql = "SELECT * FROM opportunities ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if (!$result) {
        // تسجيل الخطأ
        error_log("Database query failed: " . $conn->error);
        return []; // يمكنك إرجاع مصفوفة فارغة أو التعامل بطريقة أخرى
    }

    $opportunities = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $opportunities[] = $row;
        }
    }
    $result->free(); // تحرير الذاكرة
    $conn->close();
    return $opportunities;
}

    // جلب كل  companies
public function getAllCompanies() {
    $db = new Database();
    $conn = $db->connect();

    if (!$conn) {
        error_log("Failed to connect to the database."); // تسجيل الخطأ
        return [];
    }

    $sql = "SELECT * FROM 	companies ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if (!$result) {
        // تسجيل الخطأ
        error_log("Database query failed: " . $conn->error);
        return []; // يمكنك إرجاع مصفوفة فارغة أو التعامل بطريقة أخرى
    }

    $companies = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $companies[] = $row;
        }
    }
    $result->free(); // تحرير الذاكرة
    $conn->close();
    return $companies;
}

}
?>