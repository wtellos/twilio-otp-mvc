<?php

namespace App\Models;
use App\Config\Database;

class User {
    public static function findByPhone($phone) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE phone = ?");
        $stmt->execute([$phone]);
        return $stmt->fetch();
    }

    public static function findByEmail($email) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public static function create(array $data) {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            "INSERT INTO users
                (first_name, last_name, email, phone, email_verified_at, phone_verified_at)
            VALUES
                (:first_name, :last_name, :email, :phone, :email_verified_at, :phone_verified_at)"
        );
        $stmt->execute([
            ':first_name'        => $data['first_name'],
            ':last_name'         => $data['last_name'],
            ':email'             => $data['email'],
            ':phone'             => $data['phone'],
            ':email_verified_at' => $data['email_verified_at'] ?? null,
            ':phone_verified_at' => $data['phone_verified_at'] ?? null,
        ]);
        return $db->lastInsertId();
    }
}