<?php
require "../conn.php";  // Include database connection
require "lib/libraryCRUD.php";  // Include CRUD functions

$crud = new CRUDLibrary($pdo);

// Handle Add, Edit, and Delete actions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'];

    // Ensure brand_id is set for updates
    if (isset($_POST["brand_id"])) {
        $brand_id = $_POST["brand_id"];
    }

    // Prepare data for insert/update
    $data = [
        "brand_name" => $_POST["brand_name"],
        "brand_description" => $_POST["brand_description"]
    ];

    // Create or update brand based on action
    if ($action === "add") {
        $crud->create("brands", $data);  // Insert new brand
    } elseif ($action === "edit") {
        // Update existing brand
        $crud->update("brands", $data, "brand_id = ?", [$brand_id]);
    }
}

// Handle brand deletion
if (isset($_GET["delete"])) {
    $brand_id = $_GET["delete"];
    $crud->delete("brands", "brand_id = ?", [$brand_id]);
    // header("Location: index.php?p=brand");  // Redirect after deletion
    // exit;
}

// Fetch all brands for displaying
$brands = $crud->read("brands", "", []);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Brand Management</h5>
            <button class="btn btn-primary mb-3" onclick="showForm('add')">Add New Brand</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($brands as $brand): ?>
                        <tr>
                            <td><?= $brand['brand_id'] ?></td>
                            <td><?= htmlspecialchars($brand['brand_name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($brand['brand_description'] ?? '') ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="showForm('edit', <?= htmlspecialchars(json_encode($brand)) ?>)">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $brand['brand_id'] ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Brand Form Modal -->
<div class="modal fade" id="brandModal" tabindex="-1" aria-labelledby="brandModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="brandModalLabel" class="modal-title">Add New Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="brandFormElement" method="post">
                    <input type="hidden" name="brand_id" id="brand_id">
                    <input type="hidden" name="action" id="formAction">

                    <div class="mb-3">
                        <label class="form-label">Brand Name</label>
                        <input type="text" name="brand_name" id="brand_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="brand_description" id="brand_description" class="form-control" rows="3" required></textarea>
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
    var modal = new bootstrap.Modal(document.getElementById('brandModal'));
    modal.show();

    // Set form action (add or edit)
    document.getElementById("formAction").value = action;
    document.getElementById("brandModalLabel").innerText = action === "add" ? "Add New Brand" : "Edit Brand";
    document.getElementById("submitButton").innerText = action === "add" ? "Submit" : "Update";

    if (action === "edit" && data) {
        document.getElementById("brand_id").value = data.brand_id;
        document.getElementById("brand_name").value = data.brand_name;
        document.getElementById("brand_description").value = data.brand_description;
    }
}

function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this brand?")) {
        window.location.href = "index.php?p=brand&delete=" + id;
    }
}
</script>

<!-- Make sure you include the necessary Bootstrap scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
