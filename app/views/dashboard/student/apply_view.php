<!-- /views/opportunities/index.php -->
<?php
//include '../../head.php';
include '../../../controllers/OpportunityController.php';

$opportunityController = new OpportunityController();
$opportunities = $opportunityController->getAllOpportunities();
?>

<div class="container mt-5">
  <h2 class="text-center mb-4">Available Training Opportunities</h2>
  <div class="row">
    <?php foreach ($opportunities as $opportunity) : ?>
      <div class="col-md-4 mb-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><?php echo $opportunity['title']; ?></h5>
            <p class="card-text"><?php echo substr($opportunity['description'], 0, 100) . '...'; ?></p>
            <p><strong>Location:</strong> <?php echo $opportunity['location']; ?></p>
            <a href="../opportunities/details.php?id=<?php echo $opportunity['id']; ?>" class="btn btn-primary">View Details</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>


