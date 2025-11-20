<?php
require_once '../src/config.php';
require_once '../src/modules/auth/User.php';
include_once '../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $department = $_POST['department'];

    if ($user->register($name, $email, $password, $role, $department)) {
        header('Location: login.php');
        exit;
    } else {
        $error = 'Registration failed';
    }
}
?>

<h2>Register</h2>

<?php if (isset($error)) : ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<form action="register.php" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role">
            <option value="employee">Employee</option>
            <option value="manager">Manager</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="department" class="form-label">Department</label>
        <input type="text" class="form-control" id="department" name="department">
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
</form>

<?php include_once '../templates/footer.php'; ?>
