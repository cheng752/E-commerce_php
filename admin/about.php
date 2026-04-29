<?php
require_once "../conn.php";
require "lib/libraryCRUD.php";

$crud = new CRUDLibrary($pdo);
$aboutList = $crud->read("about");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>About Management</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h2>About Info Management</h2>
    <button class="btn btn-primary mb-3" onclick="showForm('add')">Add New</button>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="aboutTable">
            <?php foreach ($aboutList as $about): ?>
                <tr id="row-<?= $about['abid'] ?>">
                    <td><?= $about['abid'] ?></td>
                    <td><?= htmlspecialchars($about['abtitle']) ?></td>
                    <td><img src="uploads/<?= htmlspecialchars($about['abimage']) ?>" width="50"></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick='showForm("edit", <?= json_encode($about) ?>)'>Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $about['abid'] ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="aboutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="aboutForm" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Add About Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="abid" id="abid">
                <input type="hidden" name="action" id="formAction">

                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="abtitle" id="abtitle" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Subtitle</label>
                    <input type="text" name="absubtitle" id="absubtitle" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Text</label>
                    <textarea name="abtext" id="abtext" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label>Image</label>
                    <input type="file" name="abimage" id="abimage" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function showForm(action, data = null) {
    const modal = new bootstrap.Modal(document.getElementById('aboutModal'));
    modal.show();
    document.getElementById('formAction').value = action;
    document.getElementById('abid').value = data?.abid || '';
    document.getElementById('abtitle').value = data?.abtitle || '';
    document.getElementById('absubtitle').value = data?.absubtitle || '';
    document.getElementById('abtext').value = data?.abtext || '';
}

document.getElementById("aboutForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch("about_api.php", {
        method: "POST",
        body: formData
    }).then(res => res.json())
    .then(data => {
        if (data.success) {
            updateAboutTable(data.about);
            bootstrap.Modal.getInstance(document.getElementById('aboutModal')).hide();
        } else {
            alert("Error: " + data.message);
        }
    }).catch(console.error);
});

function updateAboutTable(item) {
    const row = document.getElementById("row-" + item.abid);
    const html = `
        <tr id="row-${item.abid}">
            <td>${item.abid}</td>
            <td>${item.abtitle}</td>
            <td><img src="uploads/${item.abimage}" width="50"></td>
            <td>
                <button class="btn btn-warning btn-sm" onclick='showForm("edit", ${JSON.stringify(item)})'>Edit</button>
                <button class="btn btn-danger btn-sm" onclick='confirmDelete(${item.abid})'>Delete</button>
            </td>
        </tr>`;
    if (row) {
        row.outerHTML = html;
    } else {
        document.getElementById("aboutTable").innerHTML += html;
    }
}

function confirmDelete(id) {
    if (confirm("Are you sure?")) {
        fetch("about_api.php", {
            method: "POST",
            body: new URLSearchParams({ action: "delete", abid: id })
        }).then(() => document.getElementById("row-" + id).remove());
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
