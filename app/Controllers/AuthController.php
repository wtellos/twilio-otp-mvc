<?php

namespace App\Controllers;

use App\Models\User;
use Twilio\Rest\Client;


class AuthController {
    private $twilio;
    private $serviceSid;

    public function __construct() {
        $this->twilio = new Client(
            $_ENV['TWILIO_ACCOUNT_SID'],
            $_ENV['TWILIO_TOKEN']
        );
        $this->serviceSid = $_ENV['TWILIO_VERIFY_SID'];
    }

    public function showLogin() {
        require BASE_PATH . '/views/login.php';
    }

    public function showRegister() {
        require BASE_PATH . '/views/register.php';
    }

    // Handles initial form submission for both Register and Login
    public function sendOtp() {
        $phone = trim($_POST['phone'] ?? '');
        $action = $_POST['action'] ?? 'login';

        if ($phone === '') {
            die("Phone number is required.");
        }

        $user = User::findByPhone($phone);

        if ($action === 'register') {
            if ($user) {
                die("Phone number already registered. Please log in.");
            }

            // Collect and validate the profile up front so we don't fail
            // after the OTP has already been consumed.
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName  = trim($_POST['last_name']  ?? '');
            $email     = trim($_POST['email']      ?? '');

            if ($firstName === '' || $lastName === '' || $email === '') {
                die("First name, last name, and email are required.");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("Invalid email address.");
            }
            if (User::findByEmail($email)) {
                die("Email already registered. Please log in.");
            }

            // Stash for the post-OTP create step.
            $_SESSION['pending_registration'] = [
                'first_name' => $firstName,
                'last_name'  => $lastName,
                'email'      => $email,
            ];
        }

        if ($action === 'login' && !$user) {
            die("Phone number not found. Please register first.");
        }

        try {
            $this->twilio->verify->v2->services($this->serviceSid)
                                     ->verifications
                                     ->create($phone, "sms");

            $_SESSION['verify_phone']  = $phone;
            $_SESSION['verify_action'] = $action;

            header("Location: /verify");
            exit;
        } catch (\Exception $e) {
            die("Twilio Error: " . $e->getMessage());
        }
    }

    public function showVerify() {
        if (!isset($_SESSION['verify_phone'])) {
            header("Location: /login");
            exit;
        }
        require BASE_PATH . '/views/verify.php';
    }

    // Verifies the user token input
    public function verifyOtp() {
        $code   = trim($_POST['code'] ?? '');
        $phone  = $_SESSION['verify_phone']  ?? '';
        $action = $_SESSION['verify_action'] ?? '';

        if (!$phone || !$code) {
            die("Invalid request session.");
        }

        try {
            $check = $this->twilio->verify->v2->services($this->serviceSid)
                                              ->verificationChecks
                                              ->create(["to" => $phone, "code" => $code]);

            if ($check->status !== "approved") {
                die("Incorrect OTP code. Go back and try again.");
            }

            if ($action === 'register') {
                $profile = $_SESSION['pending_registration'] ?? null;
                if (!$profile) {
                    die("Registration session expired. Please start over.");
                }

                User::create([
                    'first_name' => $profile['first_name'],
                    'last_name'  => $profile['last_name'],
                    'email'      => $profile['email'],
                    'phone'      => $phone,
                    'email_verified_at' => date('Y-m-d H:i:s'),
                    'phone_verified_at' => date('Y-m-d H:i:s'),
                ]);

                unset($_SESSION['pending_registration']);
            }

            // Security: Issue a persistent auth cookie to handle the logged-in session
            $sessionToken = bin2hex(random_bytes(32));
            $_SESSION['user_phone'] = $phone;
            setcookie("auth_session", $sessionToken, time() + 86400, "/");
            unset($_SESSION['verify_phone'], $_SESSION['verify_action']);

            header("Location: /dashboard");
            exit;
        } catch (\Exception $e) {
            die("Verification error: " . $e->getMessage());
        }
    }

    public function logout() {
        setcookie("auth_session", "", time() - 3600, "/");
        unset($_SESSION['pending_registration']);
        session_destroy();
        header("Location: /login");
        exit;
    }
}
