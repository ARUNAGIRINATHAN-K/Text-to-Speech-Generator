<?php
session_start();
require_once '../src/config.php';
require_once '../src/modules/auth/User.php';
require_once '../src/modules/requests/Request.php';
require_once '../src/modules/workflows/Approval.php';

$user = new User();
if (!$user->isLoggedIn() || $_SESSION['role'] !== 'manager') {
    header('Location: login.php');
    exit;
}

$request_handler = new Request();
$approval_handler = new Approval();

// Requests waiting for approval by this manager
$pending_approvals = $approval_handler->getPendingApprovalsForApprover($_SESSION['user_id']); // This method doesn't exist yet

include_once '../templates/header.php';
?>

<h2>Manager Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['user_name'] ?? 'Manager'; ?>!</p>

<div class="card mt-4">
    <div class="card-header">
        Requests Awaiting My Approval
    </div>
    <div class="card-body">
        <?php if (!empty($pending_approvals)) : ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Submitted By</th>
                        <th>Current Level</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending_approvals as $approval) : ?>
                        <tr>
                            <td><?php echo $approval['request_id']; ?></td>
                            <td><?php echo $approval['request_title']; ?></td>
                            <td><?php echo $approval['request_type']; ?></td>
                            <td><?php echo $approval['user_name']; ?></td>
                            <td><?php echo $approval['level']; ?></td>
                            <td><?php echo $approval['created_at']; ?></td>
                            <td>
                                <a href="view_request.php?id=<?php echo $approval['request_id']; ?>" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No requests currently awaiting your approval.</p>
        <?php endif; ?>
    </div>
</div>

<?php include_once '../templates/footer.php'; ?>
