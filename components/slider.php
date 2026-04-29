<?php 
include("conn.php");

// Fetch slideshows from tbl_slidshow where enable = 1
try {
    $stmt = $pdo->prepare("SELECT * FROM tbl_slidshow WHERE enable = 1 ORDER BY ssorder ASC");
    $stmt->execute();
    $slides = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<section class="section-slide">
    <div class="wrap-slick1">
        <div class="slick1">
            <?php foreach ($slides as $slide) : ?>
                <div class="item-slick1" style="background-image: url('images/<?= htmlspecialchars($slide['ss_image']) ?>');">
                    <div class="container h-full">
                        <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                            
                            <!-- Subtitle -->
                            <?php if (!empty($slide['subtitle'])) : ?>
                                <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                                    <span class="ltext-101 cl2 respon2">
                                        <?= htmlspecialchars($slide['subtitle']) ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <!-- Title -->
                            <?php if (!empty($slide['title'])) : ?>
                                <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                                    <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
                                        <?= htmlspecialchars($slide['title']) ?>
                                    </h2>
                                </div>
                            <?php endif; ?>

                            <!-- Button -->
                            <?php if (!empty($slide['link'])) : ?>
                                <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                                    <a href="index.php?p=product"
                                        class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                        <?= !empty($slide['text']) ? htmlspecialchars($slide['text']) : 'Shop Now' ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
