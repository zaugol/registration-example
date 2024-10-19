<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../src/Controller/UserController.php';

// This file would typically handle routing and serve as the entry point for your application
// For simplicity, we'll just include the registration form here
include __DIR__ . '/../src/View/register.php';