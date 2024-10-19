<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Controller/UserController.php';

try {
    $db = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=".Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$controller = new App\Controller\UserController($db);

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    if ($controller->verifyEmail($token)) {
        echo "Email verified successfully. You can now log in.";
    } else {
        echo "Invalid or expired verification token.";
    }
} else {
    echo "No verification token provided.";
}