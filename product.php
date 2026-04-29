<?php include("conn.php")?>
<section class="bg0 p-t-23 p-b-140">
    <div class="container">
      <div class="p-b-10">
        <h3 class="ltext-103 cl5">
          Product Overview
        </h3>
      </div>

      <div class="flex-w flex-sb-m p-b-52">
      </div>
      <div class="row isotope-grid">  
      <?php
$sql = "SELECT * FROM products";  

try {
    $stmt = $pdo->query($sql);

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '
            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item category-' . $row['category_id'] . '">
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="admin/uploads/products/' . $row['product_image'] . '" alt="' . $row['product_name'] . '">
                        <a href="index.php?p=product-detail&id=' . $row['product_id'] . '" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                            View Detail
                        </a>
                    </div>
                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l ">
                            <a href="index.php?p=product-detail&id=' . $row['product_id'] . '" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                ' . $row['product_name'] . '
                            </a>
                            <span class="stext-105 cl3">
                                $' . $row['price'] . '
                            </span>
                        </div>
                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png" alt="ICON">
                                <img class="icon-heart2 dis-block trans-04 ab-t-l" src="images/icons/icon-heart-02.png" alt="ICON">
                            </a>
                        </div>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo "<p>No products found</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
</div>
      <!-- Load more -->
      <div class="flex-c-m flex-w w-full p-t-45">
        <a href="index.php?p=product" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
          Load More
        </a>
      </div>
    </div>
  </section>
