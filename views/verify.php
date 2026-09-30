<?php
$pageTitle = 'Verify code';
require BASE_PATH . '/views/partials/head.php';
?>

<div class="uk-container uk-flex uk-flex-center uk-margin-large-top">
    <div class="uk-card uk-card-default uk-card-body uk-width-medium uk-text-center">
        <h2 class="uk-card-title">Enter Verification Code</h2>

        <p class="uk-text-muted">
            A verification code was sent to
            <strong><?php echo htmlspecialchars($_SESSION['verify_phone'] ?? ''); ?></strong>
        </p>

        <form action="/verify-otp" method="POST">
            <div class="uk-margin">
                <input class="uk-input uk-form-large uk-text-center"
                       type="text"
                       name="code"
                       placeholder="123456"
                       inputmode="numeric"
                       autocomplete="one-time-code"
                       required
                       autofocus>
            </div>

            <button class="uk-button uk-button-primary uk-width-1-1" type="submit">
                Verify &amp; Log In
            </button>
        </form>
    </div>
</div>

<?php require BASE_PATH . '/views/partials/footer.php'; ?>