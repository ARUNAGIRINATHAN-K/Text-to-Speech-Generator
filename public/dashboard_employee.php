<?php
session_start();
require_once '../src/config.php';
require_once '../src/modules/auth/User.php';
require_once '../src/modules/requests/Request.php';

$user = new User();
if (!$user->isLoggedIn() || $_SESSION['role'] !== 'employee') {
    header('Location: login.php');
    exit;
}

$request_handler = new Request();
$my_requests = $request_handler->getRequestsByUserId($_SESSION['user_id']);

include_once '../templates/header.php';
?>

<h2>Employee Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['user_name'] ?? 'Employee'; ?>!</p>

<div class="card mt-4">
    <div class="card-header">
        My Recent Requests
    </div>
    <div class="card-body">
        <?php if (!empty($my_requests)) : ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Level</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($my_requests as $req) : ?>
                        <tr>
                            <td><?php echo $req['id']; ?></td>
                            <td><?php echo $req['request_title']; ?></td>
                            <td><?php echo $req['request_type']; ?></td>
                            <td><?php echo $req['status']; ?></td>
                            <td><?php echo $req['current_level']; ?></td>
                            <td><?php echo $req['created_at']; ?></td>
                            <td>
                                <a href="view_request.php?id=<?php echo $req['id']; ?>" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>You have not submitted any requests yet.</p>
            <a href="create_request.php" class="btn btn-primary">Submit New Request</a>
        <?php endif; ?>
    </div>
</div>

<?php include_once '../templates/footer.php'; ?>
