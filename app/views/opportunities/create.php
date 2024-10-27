<!-- /views/opportunities/create.php -->
<?php
include '../../includes/header.php';
include '../../controllers/OpportunityController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $duration = $_POST['duration'];
    $requirements = $_POST['requirements'];
    $positions = $_POST['positions'];
    $company = $_POST['company'];

    $opportunityController = new OpportunityController();
    $opportunityController->createOpportunity($title, $description, $location, $duration, $requirements, $positions, $company);
}
?>

<div class="container mt-5">
  <h3>Add New Training Opportunity</h3>
  <form action="create.php" method="POST">
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
    </div>
    <div class="mb-3">
      <label for="location" class="form-label">Location</label>
      <input type="text" class="form-control" id="location" name="location" required>
    </div>
    <div class="mb-3">
      <label for="duration" class="form-label">Duration</label>
      <input type="text" class="form-control" id="duration" name="duration" required>
    </div>
    <div class="mb-3">
      <label for="requirements" class="form-label">Requirements</label>
      <textarea class="form-control" id="requirements" name="requirements" rows="4" required></textarea>
    </div>
    <div class="mb-3">
      <label for="positions" class="form-label">Number of Positions</label>
      <input type="number" class="form-control" id="positions" name="positions" required>
    </div>
    <div class="mb-3">
      <label for="company" class="form-label">Company Name</label>
      <input type="text" class="form-control" id="company" name="company" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Opportunity</button>
  </form>
</div>

<?php include '../../includes/footer.php'; ?>
