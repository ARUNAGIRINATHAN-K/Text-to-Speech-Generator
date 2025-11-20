<?php
session_start();
require_once '../src/config.php';
require_once '../src/modules/auth/User.php';
require_once '../src/modules/requests/Request.php'; // For all requests

$user = new User();
if (!$user->isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$request_handler = new Request();
$all_requests = $request_handler->getAllRequests();

include_once '../templates/header.php'; // Use main header for consistency
?>

<h2>Admin Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['user_name'] ?? 'Admin'; ?>!</p>

<div class="card mt-4">
    <div class="card-header">
        All Requests
    </div>
    <div class="card-body">
        <?php if (!empty($all_requests)) : ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Level</th>
                        <th>Submitted By</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_requests as $req) : ?>
                        <tr>
                            <td><?php echo $req['id']; ?></td>
                            <td><?php echo $req['request_title']; ?></td>
                            <td><?php echo $req['request_type']; ?></td>
                            <td><?php echo $req['status']; ?></td>
                            <td><?php echo $req['current_level']; ?></td>
                            <td><?php echo $req['user_name']; ?></td>
                            <td><?php echo $req['created_at']; ?></td>
                            <td>
                                <a href="view_request.php?id=<?php echo $req['id']; ?>" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No requests have been submitted yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php include_once '../templates/footer.php'; ?>
