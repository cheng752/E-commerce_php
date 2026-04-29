<?php
require "../conn.php";  // Include database connection
require "lib/libraryCRUD.php";  // Include CRUD functions

$crud = new CRUDLibrary($pdo);

// Handle Add, Edit, and Delete actions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'];

    // Ensure category_id is set for updates
    if (isset($_POST["category_id"])) {
        $category_id = $_POST["category_id"];
    }

    // Prepare data for insert/update
    $data = [
        "category_name" => $_POST["category_name"],
        "category_description" => $_POST["category_description"]
    ];

    // Handle Image Upload
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "uploads/categories/"; // Path to upload directory
        $fileName = basename($_FILES["image"]["name"]); // Get file name
        $targetFilePath = $targetDir . $fileName; // Full path to save the file
        
        // Check if the upload directory exists, if not create it
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $data["image"] = $fileName;  // Store the image name in the data array
        } else {
            // Handle file upload error
            echo "Error uploading the file.";
        }
    } else {
        // If no image is uploaded, retain the existing image if editing
        if ($action === "edit") {
            $existingCategory = $crud->read("categories", "category_id = ?", [$category_id])[0];
            $data["image"] = $existingCategory["image"];
        }
    }

    // Create or update category based on action
    if ($action === "add") {
        $crud->create("categories", $data);  // Insert new category
    } elseif ($action === "edit") {
        // Update existing category
        $crud->update("categories", $data, "category_id = ?", [$category_id]);
    }
}

// Handle category deletion
if (isset($_GET["delete"])) {
    $category_id = $_GET["delete"];
    $crud->delete("categories", "category_id = ?", [$category_id]);
    header("Location: index.php?p=category");  // Redirect after deletion
    exit;
}

// Fetch all categories for displaying
$categories = $crud->read("categories", "", []);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Category Management</h5>
            <button class="btn btn-primary mb-3" onclick="showForm('add')">Add New Category</button>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= $category['category_id'] ?></td>
                            <td><img src="uploads/categories/<?= htmlspecialchars($category['image'] ?? '') ?>" width="50" height="50"></td>
                            <td><?= htmlspecialchars($category['category_name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($category['category_description'] ?? '') ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="showForm('edit', <?= htmlspecialchars(json_encode($category)) ?>)">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $category['category_id'] ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Category Form Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="categoryModalLabel" class="modal-title">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="categoryFormElement" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="category_id" id="category_id">
                    <input type="hidden" name="action" id="formAction">

                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="category_name" id="category_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="category_description" id="category_description" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category Image</label>
                        <input type="file" name="image" id="image" class="form-control">
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
    var modal = new bootstrap.Modal(document.getElementById('categoryModal'));
    modal.show();

    // Set form action (add or edit)
    document.getElementById("formAction").value = action;
    document.getElementById("categoryModalLabel").innerText = action === "add" ? "Add New Category" : "Edit Category";
    document.getElementById("submitButton").innerText = action === "add" ? "Submit" : "Update";

    if (action === "edit" && data) {
        document.getElementById("category_id").value = data.category_id;
        document.getElementById("category_name").value = data.category_name;
        document.getElementById("category_description").value = data.category_description;
    }
}

function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this category?")) {
        window.location.href = "index.php?p=category&delete=" + id;
    }
}
</script>

<!-- Make sure you include the necessary Bootstrap scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
