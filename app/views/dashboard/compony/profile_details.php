<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start();

include '../../../config/database.php';
$db = new Database();
$conn = $db->connect();

$company_name = $_SESSION['company_name'];

// تحقق من وجود معرف المؤسسة في رابط URL
if (isset($company_name)) {
    // استعلام لجلب بيانات المؤسسة
    $stmt = $conn->prepare("SELECT * FROM companies WHERE company_name = ?");
    $stmt->bind_param("s", $company_name);
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
    print_r("name not provided");
    exit();
}

$stmt->close();
$conn->close();
?>

<div class="container mt-5">
    <h2>Company Details</h2>
    <hr/>

    <!-- معلومات المؤسسة -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Info Company</span>
            <a href="compony/profile_edit.php" class="btn btn-info btn-sm">
             <i class="fas fa-edit"></i> Edit</a>       
    </div>
        <div class="card-body">
            <h5 class="card-title"> <i class="material-icons prefix">account_circle</i>&nbsp;<?php echo htmlspecialchars($institution['company_name']); ?></h5>
            <p> <i class="material-icons prefix">business</i>&nbsp;<strong>Type:</strong> <?php echo htmlspecialchars($institution['type']); ?></p>
            <p> <i class="material-icons prefix">event</i>&nbsp;<strong>Established Date:</strong> <?php echo htmlspecialchars($institution['established_date']); ?></p>
            <p> <i class="material-icons prefix">description</i>&nbsp;<strong>Description:</strong> <?php echo htmlspecialchars($institution['description']); ?></p>
            <p>  <i class="material-icons prefix">category</i>&nbsp;<strong>Category:</strong> <?php echo htmlspecialchars($institution['category']); ?></p>
        </div>
    </div>

    <!-- معلومات التواصل -->
    <div class="card">
        <div class="card-header">
            Info Connect
        </div>
        <div class="card-body">
            <p><i class="material-icons prefix">home</i>&nbsp;<strong>Address:</strong> <?php echo htmlspecialchars($institution['address']); ?></p>
            <p><i class="material-icons prefix">phone</i>&nbsp;<strong>Phone No:</strong> <?php echo htmlspecialchars($institution['phone']); ?></p>
            <p><i class="material-icons prefix">email</i>&nbsp;<strong>Email:</strong> <?php echo htmlspecialchars($institution['email']); ?></p>
            <p><i class="material-icons prefix">language</i>&nbsp;<strong>Website:</strong> <a href="<?php echo htmlspecialchars($institution['website']); ?>" target="_blank"><?php echo htmlspecialchars($institution['website']); ?></a></p>
        </div>
    </div>
</div>