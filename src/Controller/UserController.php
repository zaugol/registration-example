<?php

namespace App\Controller;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';
use App\Model\User;
use Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class UserController {
    private $user;
    private $mailer;

    public function __construct($db) {
        $this->user = new User($db);
        $this->mailer = new PHPMailer(true);

        // Configure PHPMailer
        $this->mailer->isSMTP();
        $this->mailer->Host = Config::SMTP_HOST;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = Config::SMTP_USER;
        $this->mailer->Password = Config::SMTP_PASS;
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = Config::SMTP_PORT;
    }

    // Add these methods for testing
    public function setUserModel(User $user) {
        $this->user = $user;
    }

    public function setMailer(PHPMailer $mailer) {
        $this->mailer = $mailer;
    }

    public function register($name, $email, $password) {
        $token = $this->user->register($name, $email, $password);
        $this->sendVerificationEmail($email, $token);
    }

    private function sendVerificationEmail($email, $token) {
        try {
            $this->mailer->setFrom('noreply@youvpn.click', 'Test Reg App');
            $this->mailer->addAddress($email);
            $this->mailer->Subject = 'Email Verification for reg.01dev.click';
            $this->mailer->Body = "Please click the following link to verify your email: https://reg.01dev.click/verify.php?token=$token";
            $this->mailer->send();
        } catch (Exception $e) {
            // Handle email sending error
            error_log("Email sending failed: {$this->mailer->ErrorInfo}");
        }
    }

    public function verifyEmail($token) {
        return $this->user->verifyEmail($token);
    }
}