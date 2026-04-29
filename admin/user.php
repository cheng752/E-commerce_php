<?php
require_once "../conn.php";
require "lib/libraryCRUD.php";

$crud = new CRUDLibrary($pdo);

$user_id = $full_name = $email = $phone = $address = $role = $bod = "";
$editing = false;

if (isset($_POST['submit'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $role = $_POST['role'];
    $bod = $_POST['bod']; 

    if (empty($full_name) || empty($email) || empty($_POST['password'])) {
        die("Full Name, Email, and Password are required.");
    }

    try {
        $data = [
            "full_name" => $full_name,
            "email" => $email,
            "password" => $password, 
            "phone" => $phone,
            "address" => $address,
            "role" => $role,
            "BOD" => $bod  // 
        ];

        if (!$crud->create("users", $data)) die("Failed to insert user.");
    } catch (Exception $ex) {
        echo $ex;
    }
}

if (isset($_GET['edit'])) {
    $user_id = $_GET['edit'];
    $row = $crud->read("users", "user_id = ?", [$user_id])[0] ?? null;

    if ($row) {
        $full_name = $row["full_name"];
        $email = $row["email"];
        $phone = $row["phone"];
        $address = $row["address"];
        $role = $row["role"];
        $bod = isset($row["BOD"]) ? $row["BOD"] : ""; 
        $editing = true;
    }
}

if (isset($_POST['modify'])) {
    $user_id = $_POST['user_id'];
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $role = $_POST['role'];
    $bod = $_POST['bod'];  

    if (empty($full_name) || empty($email)) die("Full Name and Email are required.");

    try {
        $data = [
            "full_name" => $full_name,
            "email" => $email,
            "phone" => $phone,
            "address" => $address,
            "role" => $role,
            "BOD" => $bod  
        ];

        if (!empty($_POST['password'])) {
            $data["password"] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        if (!$crud->update("users", $data, "user_id = ?", [$user_id])) die("Failed to update user.");
    } catch (Exception $ex) {
        echo $ex;
    }
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (!$crud->delete("users", "user_id = ?", [$id])) die("User delete failed.");
}

// Fetch all users
$users = $crud->read("users");
?>

<!-- Bootstrap-based User Form -->
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $editing ? "Update User" : "Create User" ?></h5>
            <form action="index.php?p=user<?= $editing ? '&edit=' . $user_id : '' ?>" method="post">
                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" required value="<?= htmlspecialchars($full_name) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($email) ?>">
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" required value="<?= htmlspecialchars($phone) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" required value="<?= htmlspecialchars($address) ?>">
                    </div>
                </div>

                <?php if (!$editing) : ?>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <label class="form-label">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Birth of Date</label>
                        <input type="date" name="bod" class="form-control" value="<?= htmlspecialchars($bod ?? '') ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="admin" <?= $role == "admin" ? "selected" : "" ?>>Admin</option>
                        <option value="user" <?= $role == "user" ? "selected" : "" ?>>User</option>
                    </select>
                </div>

                <button type="submit" name="<?= $editing ? "modify" : "submit" ?>" class="btn btn-primary">
                    <?= $editing ? "Update" : "Submit" ?>
                </button>
                <a href="index.php?p=user" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<table class="table mt-4">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Role</th>
            <th>Birth of Date</th> <!-- Add BOD column -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?= htmlspecialchars($user['user_id']) ?></td>
                <td><?= htmlspecialchars($user['full_name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['phone']) ?></td>
                <td><?= htmlspecialchars($user['address']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td><?= htmlspecialchars($user['BOD'] ?? '') ?></td> <!-- Display BOD -->
                <td>
                    <a href="index.php?p=user&edit=<?= $user['user_id'] ?>" class="btn btn-warning">Edit</a>
                    <button class="btn btn-danger" onclick="confirmDelete(<?= $user['user_id'] ?>)">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = "index.php?p=user&delete=" + id;
        }
    }
</script>
