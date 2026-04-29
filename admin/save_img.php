<?php 

    $image = $_FILES['pro_image']['name'];
    $path = "./assets/images/" .$image;
    move_uploaded_file($_FILES['pro_image']['tmp_name'], $path);
    echo $image;
?>