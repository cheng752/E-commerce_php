<?php
require "../conn.php";
require "lib/libraryCRUD.php";

$crud = new CRUDLibrary($pdo);

// Fetch brands and categories for dropdowns
$brands = $crud->read("brands");
$categories = $crud->read("categories");

// Handle Add, Edit, and Delete actions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'];

    // Ensure product_id is set for updates
    if (isset($_POST["product_id"])) {
        $product_id = $_POST["product_id"];
    }

    $data = [
        "product_name" => $_POST["product_name"],
        "description" => $_POST["description"],
        "price" => $_POST["price"],
        "stock" => $_POST["stock"],
        "brand_id" => $_POST["brand_id"],
        "category_id" => $_POST["category_id"]
    ];

    // Handle Image Upload
    if (!empty($_FILES["product_image"]["name"])) {
        $targetDir = "uploads/products/";
        $fileName = basename($_FILES["product_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFilePath);
        $data["product_image"] = $fileName;
    } else {
        // If no new image is uploaded, retain the existing image
        if ($action === "edit") {
            $existingProduct = $crud->read("products", "product_id = ?", [$product_id])[0];
            $data["product_image"] = $existingProduct["product_image"];
        }
    }

    if ($action === "add") {
        $crud->create("products", $data);
    } elseif ($action === "edit") {
        // Update the product
        $crud->update("products", $data, "product_id = ?", [$product_id]);
    }
}

// Handle product deletion
if (isset($_GET["delete"])) {
    $product_id = $_GET["delete"];
    $crud->delete("products", "product_id = ?", [$product_id]);
    exit;
}

// Fetch all products with brand and category names
$products = $crud->read(
    "products p 
     LEFT JOIN brands b ON p.brand_id = b.brand_id 
     LEFT JOIN categories c ON p.category_id = c.category_id",
    "",
    []
);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Product Management</h5>
            <button class="btn btn-primary mb-3" onclick="showForm('add')">Add New Product</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['product_id'] ?></td>
                            <td><img src="uploads/products/<?= htmlspecialchars($product['product_image'] ?? '') ?>" width="50" height="50"></td>
                            <td><?= htmlspecialchars($product['product_name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($product['description'] ?? '') ?></td>
                            <td>$<?= number_format($product['price'], 2) ?></td>
                            <td><?= $product['stock'] ?></td>
                            <td><?= htmlspecialchars($product['brand_name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($product['category_name'] ?? '') ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="showForm('edit', <?= htmlspecialchars(json_encode($product)) ?>)">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $product['product_id'] ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Product Form Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="productModalLabel" class="modal-title">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productFormElement" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" id="product_id">
                    <input type="hidden" name="action" id="formAction">

                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" id="price" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" id="stock" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Brand</label>
                        <select name="brand_id" id="brand_id" class="form-control" required>
                            <option value="">Select Brand</option>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?= $brand['brand_id'] ?>"><?= htmlspecialchars($brand['brand_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="product_image" id="product_image" class="form-control">
                    </div>

                    <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showForm(action, data = null) {
    // Show the modal
    var modal = new bootstrap.Modal(document.getElementById('productModal'));
    modal.show();

    // Set form action (add or edit)
    document.getElementById("formAction").value = action;
    document.getElementById("productModalLabel").innerText = action === "add" ? "Add New Product" : "Edit Product";
    document.getElementById("submitButton").innerText = action === "add" ? "Submit" : "Update";

    if (action === "edit" && data) {
        document.getElementById("product_id").value = data.product_id;
        document.getElementById("product_name").value = data.product_name;
        document.getElementById("description").value = data.description;
        document.getElementById("price").value = data.price;
        document.getElementById("stock").value = data.stock;
        document.getElementById("brand_id").value = data.brand_id;
        document.getElementById("category_id").value = data.category_id;
    }
}

function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this product?")) {
        window.location.href = "index.php?p=product&delete=" + id;
    }
}
</script>

<!-- Make sure you include the necessary Bootstrap scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
