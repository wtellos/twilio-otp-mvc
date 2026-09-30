<?php
$pageTitle = 'Login';
require BASE_PATH . '/views/partials/head.php';
?>

<div class="uk-container uk-flex uk-flex-center uk-margin-large-top">
    <div class="uk-card uk-card-default uk-card-body uk-width-medium">
        <h2 class="uk-card-title">Login with OTP</h2>

        <form action="/send-otp" method="POST">
            <input type="hidden" name="action" value="login">

            <div class="uk-margin">
                <label class="uk-form-label">Phone Number</label>
                <input class="uk-input" type="text" name="phone"
                       placeholder="+1234567890" required>
                <small class="uk-text-muted">E.164 format, e.g. +1234567890</small>
            </div>

            <button class="uk-button uk-button-primary uk-width-1-1" type="submit">
                Send Code
            </button>
        </form>

        <p class="uk-margin-top uk-text-center uk-text-small">
            Don't have an account?
            <a href="/register">Register here</a>
        </p>
    </div>
</div>

<?php require BASE_PATH . '/views/partials/footer.php'; ?>