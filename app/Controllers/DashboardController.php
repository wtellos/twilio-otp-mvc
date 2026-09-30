<?php
namespace App\Controllers;

class DashboardController {
    public function index() {
        // Authenticate via cookie presence
        if (!isset($_COOKIE['auth_session']) || !isset($_SESSION['user_phone'])) {
            header("Location: /login");
            exit;
        }

        $userPhone = $_SESSION['user_phone'];
        require BASE_PATH . '/views/dashboard.php';
    }
}
