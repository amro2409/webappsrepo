<!-- /views/dashboard/student/search_opportunities.php -->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
//include '../../../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    header('Location: ../../auth/login.php');
    exit();
}


$search_query = isset($_POST['query']) ? $_POST['query'] : '';

include '../../../config/database.php';
$db = new Database();
$conn = $db->connect();

// البحث في قاعدة البيانات عن الفرص بناءً على المدينة أو التخصص أو اسم المؤسسة
$stmt = $conn->prepare("SELECT * FROM opportunities WHERE city LIKE ? OR specialization LIKE ? OR company_name_fk LIKE ?");
$search_term = "%$search_query%";
$stmt->bind_param("sss", $search_term, $search_term, $search_term);
$stmt->execute();
$opportunities = $stmt->get_result();
?>



<div class="container mt-5">
    <!-- نموذج الفلترة -->
    <form method="POST" onsubmit="event.preventDefault(); filterOpportunities();" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" id="query" name="query" class="form-control" placeholder="بناءً على المدينة أو التخصص أو اسم المؤسس" value="<?php echo htmlspecialchars($search_query); ?>">
            </div>
  
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <h2>Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h2>

    <?php if ($opportunities->num_rows > 0): ?>
        <ul class="list-group">
            <?php while ($opportunity = $opportunities->fetch_assoc()): ?>
                <li class="list-group-item">
                    <h5><?php echo htmlspecialchars($opportunity['opportunity_title']); ?></h5>
                    <p><?php echo htmlspecialchars($opportunity['description']); ?></p>
                    <p><strong>City:</strong> <?php echo htmlspecialchars($opportunity['city']); ?></p>
                    <p><strong>Major:</strong> <?php echo htmlspecialchars($opportunity['major']); ?></p>
                    <p><strong>Company:</strong> <?php echo htmlspecialchars($opportunity['company_name_fk']); ?></p>
                    <a href="../opportunities/details.php?id=<?php echo $opportunity['id']; ?>" class="btn btn-primary">View Details</a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No opportunities found for your search.</p>
    <?php endif; ?>
</div>
