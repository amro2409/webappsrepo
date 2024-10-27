<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'company') {
    header('Location: login.php');
    exit();
}

include '../../../config/database.php';
$db = new Database();
$conn = $db->connect();

$company_name = $_SESSION['company_name'];

// استعلام لجلب الفرص المضافة من قبل الشركة
$stmt = $conn->prepare("SELECT * FROM opportunities WHERE company_name_fk = ?");
$stmt->bind_param("s", $company_name);
$stmt->execute();
$result = $stmt->get_result();

?>

<div class="container mt-5">
    <h2>My Opportunities</h2>
    <?php if ($result->num_rows > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                
                    <th>City</th>
                    <th>Major</th>
                    <th>Specialization</th>
                    <th>Location</th>
                    <th>Duration</th>
                    <th>Students Needed</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['opportunity_title']); ?></td>
                  
                        <td><?php echo htmlspecialchars($row['city']); ?></td>
                        <td><?php echo htmlspecialchars($row['major']); ?></td>
                        <td><?php echo htmlspecialchars($row['specialization']); ?></td>
                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                        <td><?php echo htmlspecialchars($row['duration']); ?></td>
                        <td><?php echo htmlspecialchars($row['students_needed']); ?></td>
                        <td>
                           <a href="compony/opportunity_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                           <a href="compony/opportunity_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this opportunity?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No opportunities found.</p>
    <?php endif; ?>
</div>

<?php
$stmt->close();
$conn->close();
?>
