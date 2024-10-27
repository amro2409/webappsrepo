<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start();

include '../../../config/database.php';
$db = new Database();
$conn = $db->connect();

$company_id = $_GET['id'];

// تحقق من وجود معرف المؤسسة في رابط URL
if (isset($company_id)) {
    // استعلام لجلب بيانات المؤسسة
    $stmt = $conn->prepare("SELECT * FROM companies WHERE id = ?");
    $stmt->bind_param("i", $company_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $institution = $result->fetch_assoc();
    } else {
        echo "Institution not found.";
         print_r("Institution not found");
        exit();
    }
} else {
    echo "ID not provided.";
    print_r("name  not provided");
    exit();
}

$stmt->close();
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../../assets/css/materialize.min.css">
</head>
<body>

    <div class="container mt-5">
        <h2>Company Details </h2>
        <hr/>
        <!-- معلومات المؤسسة -->
        <div class="card mb-4">
            <div class="card-header">
                Info Company
            </div>
            <div class="card-body">
                <h3><?php echo htmlspecialchars($institution['company_name']); ?></h3>
                <p><strong>Type:</strong> <?php echo htmlspecialchars($institution['type']); ?></p>
                <p><strong>Established Date:</strong> <?php echo htmlspecialchars($institution['established_date']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($institution['description']); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($institution['category']); ?></p>
            </div>
        </div>

        <!-- معلومات التواصل -->
        <div class="card">
            <div class="card-header">
                Info connect
            </div>
            <div class="card-body">
                <p><strong>Address:</strong> <?php echo htmlspecialchars($institution['address']); ?></p>
                <p><strong>Phone No:</strong> <?php echo htmlspecialchars($institution['phone']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($institution['email']); ?></p>
                <p><strong>Website:</strong> <a href="<?php echo htmlspecialchars($institution['website']); ?>" target="_blank"><?php echo htmlspecialchars($institution['website']); ?></a></p>
            </div>
        </div>
    </div>
    </body>
    </html>
