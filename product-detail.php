<?php 
include "cart_functions.php";
include "fetch_product-detail.php";

?>
<!-- Product Detail -->
<section class="sec-product-detail bg0 p-t-65 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-7 p-b-30">
                <div class="p-l-25 p-r-30 p-lr-0-lg">
                    <div class="wrap-slick3 flex-sb flex-w">
                        <div class="wrap-slick3-dots"></div>
                        <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                        <div class="slick3 gallery-lb">
                            <div class="item-slick3" data-thumb="admin/uploads/products/<?=$image?>">
                                <div class="wrap-pic-w pos-relative">
                                    <img src="admin/uploads/products/<?=$image?>" alt="IMG-PRODUCT" />

                                    <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                        href="admin/uploads/products/<?=$image?>">
                                        <i class="fa fa-expand"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="item-slick3" data-thumb="admin/uploads/products/<?=$image?>">
                                <div class="wrap-pic-w pos-relative">
                                    <img src="admin/uploads/products/<?=$image?>" alt="IMG-PRODUCT" />

                                    <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                        href="admin/uploads/products/<?=$image?>">
                                        <i class="fa fa-expand"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="item-slick3" data-thumb="admin/uploads/products/<?=$image?>">
                                <div class="wrap-pic-w pos-relative">
                                    <img src="admin/uploads/products/<?=$image?>" alt="IMG-PRODUCT" />

                                    <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                        href="admin/uploads/products/<?=$image?>">
                                        <i class="fa fa-expand"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-5 p-b-30">
                <div class="p-r-50 p-t-5 p-lr-0-lg">
                    <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                        <?=$product_name?>
                    </h4>

                    <span class="mtext-106 cl2"> $<?=$price?> </span>

                    <p class="stext-102 cl3 p-t-23">
                        <?=$description?>
                    </p>
        
                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-204 flex-w flex-m respon6-next">
                                 <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                    </div>

                                    <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product"
                                        id="num-product" value="1" />


                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                    </div>
                                </div>
                                <?php
// Example of calling the addToCart function
// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];
    $image = $_POST['image'];
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];

    // Call the function to add the product to the cart
    addToCart($productId, $image, $productName, $price, $qty);
}

?><!-- Form for adding product to cart -->
<form method="POST" action="">
    <input type="hidden" name="productId" value="<?=$productId?>">
    <input type="hidden" name="image" value="<?=$image?>">
    <input type="hidden" name="productName" value="<?=$product_name?>">
    <input type="hidden" name="price" value="<?=$price?>">
    <input type="hidden" name="qty" id="num-product" value="1"> <!-- default value, can be changed by user -->
    
    <button type="submit" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
        Add to cart
    </button>
</form>

                            </div>
                        </div>
                    </div>

                    <!--  -->
                    <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                        <div class="flex-m bor9 p-r-10 m-r-11">
                            <a href="#"
                                class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
                                data-tooltip="Add to Wishlist">
                                <i class="zmdi zmdi-favorite"></i>
                            </a>
                        </div>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                            data-tooltip="Facebook">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                            data-tooltip="Twitter">
                            <i class="fa fa-twitter"></i>
                        </a>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                            data-tooltip="Google Plus">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

       
    </div>

</section>
