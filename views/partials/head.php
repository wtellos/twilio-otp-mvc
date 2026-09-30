<!DOCTYPE html>
<html lang="en" data-uk-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle ?? 'OTP Auth'); ?></title>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.25.25/dist/css/uikit.min.css" />

    <!-- Dark mode -->
    <style>
        :root { color-scheme: dark; }
        body  { background: #0f0f12; color: #e6e6e6; height: 100vh; }
        .uk-card { background: #1a1a20; }
        .uk-input, .uk-button-primary { text-transform:none; }
    </style>

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.25.25/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.25.25/dist/js/uikit-icons.min.js"></script>
</head>
<body class="uk-background-default uk-padding" style="background-color: #0f0f12;">