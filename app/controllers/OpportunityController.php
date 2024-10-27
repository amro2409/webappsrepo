<?php
// OpportunityController.php

include $_SERVER['DOCUMENT_ROOT'] . '/app/config/database.php';

class OpportunityController {
    
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

    // إضافة فرصة تدريب جديدة
    public function createOpportunity($title, $description, $location, $duration, $requirements, $positions, $company) {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("INSERT INTO opportunities (opportunity_title, description, location, duration, requirements, students_needed, company_name_fk) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $title, $description, $location, $duration, $requirements, $positions, $company);

        if ($stmt->execute()) {
            echo "New opportunity added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>
