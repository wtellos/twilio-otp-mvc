<?php
$pageTitle = 'Register';
require BASE_PATH . '/views/partials/head.php';
?>

<div class="uk-container uk-flex uk-flex-center uk-margin-large-top">
    <div class="uk-card uk-card-default uk-card-body uk-width-large">
        <h2 class="uk-card-title">Create an Account</h2>

        <form action="/send-otp" method="POST">
            <input type="hidden" name="action" value="register">

            <div class="uk-grid-small" uk-grid>
                <div class="uk-width-1-2@s">
                    <label class="uk-form-label">First Name</label>
                    <input class="uk-input" type="text" name="first_name" required>
                </div>
                <div class="uk-width-1-2@s">
                    <label class="uk-form-label">Last Name</label>
                    <input class="uk-input" type="text" name="last_name" required>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">Email</label>
                <input class="uk-input" type="email" name="email" required>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label">Phone Number</label>
                <input class="uk-input" type="text" name="phone"
                       placeholder="+1234567890" required>
            </div>

            <button class="uk-button uk-button-primary uk-width-1-1" type="submit">
                Verify Phone Number
            </button>
        </form>

        <p class="uk-margin-top uk-text-center uk-text-small">
            Already have an account?
            <a href="/login">Login here</a>
        </p>
    </div>
</div>

<?php require BASE_PATH . '/views/partials/footer.php'; ?>