<footer class="bg3 p-t-75 p-b-32">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Categories
                </h4>

                <ul>
                    <li class="p-b-10">
                        <a href="index.php?p=product" class="stext-107 cl7 hov-cl1 trans-04">
                            Bag
                        </a>
                    </li>

                    <li class="p-b-10">
                        <a href="index.php?p=product" class="stext-107 cl7 hov-cl1 trans-04">
                            Sunglasses
                        </a>
                    </li>

                    
                </ul>
            </div>

            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Help
                </h4>

                <ul>
                    <li class="p-b-10">
                        <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                            Track Order
                        </a>
                    </li>

                    <li class="p-b-10">
                        <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                            Returns
                        </a>
                    </li>

                    <li class="p-b-10">
                        <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                            Shipping
                        </a>
                    </li>

                    <li class="p-b-10">
                        <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                            FAQs
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    GET IN TOUCH
                </h4>

                <p class="stext-107 cl7 size-201">
                Any questions? You can ask in message or call us on (+855)123456789
                </p>

                <div class="p-t-27">
                    <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                        <i class="fa fa-facebook"></i>
                    </a>

                    <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                        <i class="fa fa-instagram"></i>
                    </a>

                    <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                        <i class="fa fa-pinterest-p"></i>
                    </a>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Newsletter
                </h4>

                <form>
                    <div class="wrap-input1 w-full p-b-4">
                        <input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email"
                            placeholder="az@gamil.com">
                        <div class="focus-input1 trans-04"></div>
                    </div>

                    <div class="p-t-18">
                        <button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                            Subscribe
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="p-t-40">
            <div class="flex-c-m flex-w p-b-18">
                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-01.png" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-02.png" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-03.png" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-04.png" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="images/icons/icon-pay-05.png" alt="ICON-PAY">
                </a>
            </div>

            <p class="stext-107 cl6 txt-center">
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;<script>
                document.write(new Date().getFullYear());
                </script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a
                    href="https://colorlib.com" target="_blank">Colorlib</a> &amp; distributed by <a
                    href="https://themewagon.com" target="_blank">ThemeWagon</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

            </p>
        </div>
    </div>
</footer>


<!-- Back to top -->
<div class="btn-back-to-top" id="myBtn">
    <span class="symbol-btn-back-to-top">
        <i class="zmdi zmdi-chevron-up"></i>
    </span>
</div>


<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<script>
$(".js-select2").each(function() {
    $(this).select2({
        minimumResultsForSearch: 20,
        dropdownParent: $(this).next('.dropDownSelect2')
    });
})
</script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/slick/slick.min.js"></script>
<script src="js/slick-custom.js"></script>
<!--===============================================================================================-->
<script src="vendor/parallax100/parallax100.js"></script>
<script>
$('.parallax100').parallax100();
</script>
<!--===============================================================================================-->
<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
<script>
$('.gallery-lb').each(function() { // the containers for all your galleries
    $(this).magnificPopup({
        delegate: 'a', // the selector for gallery item
        type: 'image',
        gallery: {
            enabled: true
        },
        mainClass: 'mfp-fade'
    });
});
</script>
<!--===============================================================================================-->
<script src="vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/sweetalert/sweetalert.min.js"></script>
<script>
$('.js-addwish-b2').on('click', function(e) {
    e.preventDefault();
});

$('.js-addwish-b2').each(function() {
    var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
    $(this).on('click', function() {
        swal(nameProduct, "is added to wishlist !", "success");

        $(this).addClass('js-addedwish-b2');
        $(this).off('click');
    });
});

$('.js-addwish-detail').each(function() {
    var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

    $(this).on('click', function() {
        swal(nameProduct, "is added to wishlist !", "success");

        $(this).addClass('js-addedwish-detail');
        $(this).off('click');
    });
});

/*---------------------------------------------*/

$('.js-addcart-detail').each(function() {
    var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
    $(this).on('click', function() {
        swal(nameProduct, "is added to cart !", "success");
    });
});
</script>
<!--===============================================================================================-->
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script>
$('.js-pscroll').each(function() {
    $(this).css('position', 'relative');
    $(this).css('overflow', 'hidden');
    var ps = new PerfectScrollbar(this, {
        wheelSpeed: 1,
        scrollingThreshold: 1000,
        wheelPropagation: false,
    });

    $(window).on('resize', function() {
        ps.update();
    })
});
</script>
<!--===============================================================================================-->
<script src="js/main.js"></script>
<script>
// Cart class definition
class Product {
    constructor(productId, image, name, price, qty) {
        this.productId = productId;
        this.image = image;
        this.name = name;
        this.price = price;
        this.qty = qty;
    }
}



// Function to add product to the cart
const addToCart = (productId, image, name, price, qty) => {
    const product = new Product(productId, image, name, price, qty);
    const existProduct = cart.find((item) => item.productId === product.productId);
    if (existProduct) {
        existProduct.qty += 1;
        localStorage.setItem('cart', JSON.stringify(cart));
    } else {
        console.log(product.productId + " " + product.name);
        cart.push(product);
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    // localStorage.clear();

    // Update the cart in the UI
    updateCart();
    window.location.reload();
};


// Function to update the cart in the UI
function updateCart() {
    const cartItemsList = document.querySelector('.header-cart-wrapitem');
    const totalPrice = document.querySelector('.header-cart-total');
    // sub total 
    const sub_total = document.querySelector('.sub-total');
    cartItemsList.innerHTML = '';

    let total = 0;
    cart.forEach(item => {
        const listItem = document.createElement('li');
        listItem.classList.add('header-cart-item', 'flex-w', 'flex-t', 'm-b-12');

        const imgDiv = document.createElement('div');
        imgDiv.classList.add('header-cart-item-img');
        const imgElement = document.createElement('img');
        imgElement.src =
            `./admin/uploads/images/products/${item.image}`; 
        imgElement.alt = `./admin/uploads/images/products/${item.image}`;
        imgDiv.appendChild(imgElement);

        const txtDiv = document.createElement('div');
        txtDiv.classList.add('header-cart-item-txt', 'p-t-8');

        const itemNameLink = document.createElement('a');
        itemNameLink.href = '#';
        itemNameLink.classList.add('header-cart-item-name', 'm-b-18', 'hov-cl1', 'trans-04');
        itemNameLink.textContent = item.name;

        const itemInfoSpan = document.createElement('span');
        itemInfoSpan.classList.add('header-cart-item-info');
        itemInfoSpan.textContent = `${item.qty} x $${item.price}`;

        txtDiv.appendChild(itemNameLink);
        txtDiv.appendChild(itemInfoSpan);

        listItem.appendChild(imgDiv);
        listItem.appendChild(txtDiv);

        cartItemsList.appendChild(listItem);

        total += item.price * item.qty;
    });

    totalPrice.textContent = `Total : \$${total.toFixed(2)}`;
    sub_total.textContent = `\$${total.toFixed(2)}`;
}

// Function to update the quantity of a product
// const updateQuantity = (id) => {
//     const product = cart.find(item => item.id === id);
//     if (product) {
//         product.qty += 1;
//         if (product.qty <= 0) {
//             // If quantity becomes zero or negative, remove the product from cart
//             removeItem(id);
//         } else {
//             // Save updated cart to localStorage
//             localStorage.setItem('cart', JSON.stringify(cart));
//             updateCart();
//         }
//     }
// };

// const incrementQuantity = () => {
//     alert("incrementQuantity");
// };

// const decrementQuantity = () => {
//     alert("decrementQuantity");
// };

// Function to remove an item from the cart
const removeItem = (id) => {
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCart();
};

// Function to remove all items from the cart
const removeAllItems = () => {
    localStorage.clear();
    updateCart();
};

// Function to calculate and display the total cart value
// const updateCartTotal = () => {
//     return totalValue = cart.reduce((total, item) => total + (item.price * item.qty), 0);
// };

document.querySelector('.cart-length').setAttribute('data-notify', cart.length);

// Call the updateCart() function to initially display the cart on page load
document.addEventListener('DOMContentLoaded', updateCart);
</script>