<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Helping Students Find Training</title>
      <!-- Bootstrap CSS -->
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">-->

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/materialize.min.css">
  <!-- Custom CSS -->
  <link href="../assets/css/styles.css" rel="stylesheet">
  <link href="../assets/css/styles_proj.css" rel="stylesheet">
  <link href="../assets/css/home_hero_style.css" rel="stylesheet">
  <link href="../assets/css/home_feature_style.css" rel="stylesheet">
  <!-- Custom JS -->
  <script src="../assets/js/fontawesome-all.min.js"></script>
      <!-- Toast CSS -->
    <!-- روابط المكتبات الأخرى
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/Toastify.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/Toastify.min.js"></script>  -->
    
<style>
    .sidebar {
        background-color: #f8f9fa; /* لون الخلفية الفاتح */
        background-image: url('path/to/your/background-image.jpg');
        background-size: cover; /* لتغطية الخلفية */
        background-position: center; /* مركز الصورة */
        color: #333; /* لون النص */
    }
    .sidebar .nav-link {
        color: #333; /* لون النص للروابط */
    }
    .sidebar .nav-link:hover {
        background-color: #007bff; /* لون الخلفية عند التمرير */
        color: white; /* لون النص عند التمرير */
    }
 .accepted {
    color: green;
}
.rejected {
    color: red;
}
.pending {
    color: orange;
}
</style>
</head>
<body>
  <!-- Navigation Bar -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a id="logo-container" class="navbar-brand" href="http://www.alkadev.lovestoblog.com/">Training Finder</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
       
              <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="http://localhost:81/app/views/logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>