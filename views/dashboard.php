<?php
$pageTitle = 'Dashboard';
require BASE_PATH . '/views/partials/head.php';
?>

<div class="uk-container uk-margin-large-top">
    <div class="uk-card uk-card-default uk-card-body">
        <h2 class="uk-card-title">Welcome to your Dashboard</h2>

        <p>
            Your authenticated phone:
            <strong><?php echo htmlspecialchars($userPhone ?? ($_SESSION['user_phone'] ?? 'unknown')); ?></strong>
        </p>

        <p class="uk-text-muted">
            Secure cookies are protecting this view context layout.
        </p>

        <a href="/logout" class="uk-button uk-button-danger">Log Out</a>
    </div>
</div>

<?php require BASE_PATH . '/views/partials/footer.php'; ?>