<?php
    class Product {
        private $id;
        private $image;
        private $productName;
        private $price;
        private $quantity;
        public function __construct($id, $image, $productName, $price, $quantity) {
            $this->id = $id;
            $this->image = $image;
            $this->productName = $productName;
            $this->price = $price;
            $this->quantity = $quantity;

            
        }
    }

?>