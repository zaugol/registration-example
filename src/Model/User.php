<?php
namespace App\Model;

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($name, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $verificationToken = bin2hex(random_bytes(16));

        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, verification_token) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword, $verificationToken]);

        return $verificationToken;
    }

    public function verifyEmail($token) {
        $stmt = $this->db->prepare("UPDATE users SET verified = 1 WHERE verification_token = ?");
        return $stmt->execute([$token]);
    }
}