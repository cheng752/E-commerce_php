<!DOCTYPE html>
<html lang="en">
<?php 
    session_start();
    include "config.php";
    include "./components/head.php";
    $pages = "home.php";
    $p = "home";
    $banner = true;
    $breadcrumb = false;
    $cart = true;
    $footer = true;
    $header = true;
    $header2 = false;
    $slider = true;
    if(isset($_GET['p'])){
        $p = $_GET['p'];
        switch($p){
            case "home": {
                $pages = "home.php";
                $banner = true;
                $breadcrumb = false;
                $cart = true;
                $footer = true;
                $header = true;
                $header2 = false;
                $slider = true;
                break;
            }
            case "product": {
                $pages = "product.php";
                $banner = false;
                $breadcrumb = false;
                $cart = true;
                $footer = true;
                $header = false;
                $header2 = true;
                $slider = false;
                break;
            }
            case "shoping-cart": {
                $pages = "shoping-cart.php";
                $banner = false;
                $breadcrumb = true;
                $cart = true;
                $footer = true;
                $header = false;
                $header2 = true;
                $slider = false;
                break;
            }
            case "blog": {
                $pages = "blog.php";
                $banner = false;
                $breadcrumb = false;
                $cart = true;
                $footer = true;
                $header = false;
                $header2 = true;
                $slider = false;
                break;
            }
            case "about": {
                $pages = "about.php";
                $banner = false;
                $breadcrumb = false;
                $cart = true;
                $footer = true;
                $header = false;
                $header2 = true;
                $slider = false;
                break;
            }
            case "contact": {
                $pages = "contact.php";
                $banner = false;
                $breadcrumb = false;
                $cart = true;
                $footer = true;
                $header = false;
                $header2 = true;
                $slider = false;
                break;
            }
            case "product-detail": {
                $pages = "product-detail.php";
                $banner = false;
                $breadcrumb = true;
                $cart = true;
                $footer = true;
                $header = false;
                $header2 = true;
                $slider = false;
                break;
            }
            case "checkout": {
                $pages = "checkout.php";
                $banner = false;
                $breadcrumb = false;
                $cart = true;
                $footer = false;
                $header = false;
                $header2 = true;
                $slider = false;
                break;
            }
        }
    }
?>

<body class="animsition">

    <!-- Header -->
    <?php if($header) include "./components/header.php" ?>
    <?php if($header2) include "./components/header2.php" ?>

    <!-- Cart -->
    <?php if($cart) include "./components/cart.php" ?>

    <!-- Slider -->
    <?php if($slider) include "./components/slider.php" ?>

    <!-- Banner -->
    <?php if($banner) include "./components/banner.php" ?>

    <!-- Product -->
    <!-- Home -->
    <?php include "./$pages" ?>

    <!-- Model -->
    <?php include "./components/model.php" ?>

    <!-- Footer -->
    <?php include "./components/footer.php" ?>
    

</body>

</html>