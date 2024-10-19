<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Controller/UserController.php';

try {
    $db = new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$controller = new App\Controller\UserController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $controller->register($name, $email, $password);
    echo "Registration successful. Please check your email to verify your account.";
}