<?php
require_once "../conn.php";
require "lib/libraryCRUD.php";

$crud = new CRUDLibrary($pdo);

// header("Content-Type: application/json");

// Handle AJAX requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'];

    if ($action === "delete") {
        $ssid = $_POST["ssid"];
        $crud->delete("tbl_slidshow", "ssid = ?", [$ssid]);
        echo json_encode(["success" => true]);
        exit;
    }

    $ssid = $_POST["ssid"] ?? null;
    $data = [
        "ssid" => $_POST["ssid"],
        "title" => $_POST["title"],
        "subtitle" => $_POST["subtitle"],
        "link" => $_POST["link"],
        "text" => $_POST["text"],
        "enable" => isset($_POST["enable"]) ? 1 : 0,
        "ssorder" => $_POST["ssorder"]
    ];

    // Handle Image Upload
    if (!empty($_FILES["ss_image"]["name"])) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["ss_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        move_uploaded_file($_FILES["ss_image"]["tmp_name"], $targetFilePath);
        $data["ss_image"] = $fileName;
    } else {
        if ($action === "edit") {
            $existingSlide = $crud->read("tbl_slidshow", "ssid = ?", [$ssid])[0];
            $data["ss_image"] = $existingSlide["ss_image"];
        }
    }

    if ($action === "add") {
        $ssid = $crud->create("tbl_slidshow", $data);
    } elseif ($action === "edit") {
        $crud->update("tbl_slidshow", $data, "ssid = ?", [$ssid]);
    }

    $data["ssid"] = $ssid;
    echo json_encode(["success" => true, "slide" => $data]);
    exit;
}

// Fetch all slideshows for initial load
$slideshows = $crud->read("tbl_slidshow");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slideshow Management</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-3">Slideshow Management</h2>
    <button class="btn btn-primary mb-3" onclick="showForm('add')">Add New Slideshow</button>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="slideshowTable">
            <?php foreach ($slideshows as $slide): ?>
                <tr id="row-<?= $slide['ssid'] ?>">
                    <td><?= $slide['ssid'] ?></td>
                    <td><?= htmlspecialchars($slide['title']) ?></td>
                    <td><img src="uploads/<?= htmlspecialchars($slide['ss_image']) ?>" width="50"></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="showForm('edit', <?= htmlspecialchars(json_encode($slide)) ?>)">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $slide['ssid'] ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Slideshow Modal -->
<div class="modal fade" id="slideshowModal" tabindex="-1" aria-labelledby="slideshowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="slideshowModalLabel" class="modal-title">Add New Slideshow</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="slideshowForm" enctype="multipart/form-data">
                    <input type="hidden" name="ssid" id="ssid">
                    <input type="hidden" name="action" id="formAction">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subtitle</label>
                        <input type="text" name="subtitle" id="subtitle" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="ss_image" id="ss_image" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Enable</label>
                        <input type="checkbox" name="enable" id="enable">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <input type="number" name="ssorder" id="ssorder" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link</label>
                        <input type="text" name="link" id="link" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Text</label>
                        <textarea name="text" id="text" class="form-control"></textarea>
                    </div>

                    <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById("slideshowForm").addEventListener("submit", function(event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("slideshow.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) 
    .then(data => {
        if (data.success) {
            updateSlideshowTable(data.slide);
            var modal = bootstrap.Modal.getInstance(document.getElementById('slideshowModal'));
            modal.hide();
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});

function updateSlideshowTable(slide) {
    let tableBody = document.getElementById("slideshowTable");
    let existingRow = document.getElementById("row-" + slide.ssid);

    let rowHTML = `
        <tr id="row-${slide.ssid}">
            <td>${slide.ssid}</td>
            <td>${slide.title}</td>
            <td><img src="uploads/${slide.ss_image}" width="50"></td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="showForm('edit', ${JSON.stringify(slide)})">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="confirmDelete(${slide.ssid})">Delete</button>
            </td>
        </tr>
    `;

    if (existingRow) {
        existingRow.outerHTML = rowHTML;
    } else {
        tableBody.innerHTML += rowHTML;
    }
}

function showForm(action, data = null) {
    var modal = new bootstrap.Modal(document.getElementById('slideshowModal'));
    modal.show();

    document.getElementById("formAction").value = action;
    document.getElementById("ssid").value = data ? data.ssid : '';
    document.getElementById("title").value = data ? data.title : '';
}

function confirmDelete(id) {
    if (confirm("Are you sure?")) {
        fetch("slideshow.php", {
            method: "POST",
            body: new URLSearchParams({ action: "delete", ssid: id })
        }).then(() => document.getElementById("row-" + id).remove());
    }
}
</script>
</body>
</html>
