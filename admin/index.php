<?php
  // require "lib/connection.php";
  $page = "dashboard.php";
  $p = "dashboard";
  $footer = true;
  if(isset($_GET['p'])){
    $p = $_GET['p'];
    if($p == "categories"){
      $page = "categories.php";
      $footer = false;
    }elseif($p == "product"){
      $page = "product.php";
      $footer = false;
    }elseif($p == "user"){
      $page = "user.php";
      $footer = false;
    }elseif($p == "order"){
      $page = "order.php";
      $footer = false;
    }elseif($p == "payment"){
      $page = "payment.php";
      $footer = false;
    }elseif($p == "brand"){
      $page = "brand.php";
      $footer = false;
    } elseif($p == "slideshow"){
      $page = "slideshow.php";
      $footer = false;
    }elseif($p == "about"){
      $page = "about.php";
      $footer = false;
    }
    else {
      $page = "invoice.php";
      $footer = false;
    }
  }
 
?>

<!doctype html>
<html lang="en">

<?php include "include/head.php" ?>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <?php include "include/sidebar.php" ?>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <?php include "include/header.php" ?>
      <!--  Header End -->
      <!-- container -->
       <div class="container-fluid">
           <?php include "$page" ?>
       </div>
       <!-- container End -->
      <!-- footer -->
       <?php  //if($footer) include "include/footer.php" ?>
        <?php  include "include/footer.php" ?>
      <!-- footer end -->
    </div>
  </div>
  <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/sidebarmenu.js"></script>
  <script src="./assets/js/app.min.js"></script>
  <script src="./assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="./assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="./assets/js/dashboard.js"></script>
</body>

</html>
