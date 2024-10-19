<?php
namespace Tests\Controller;

use PHPUnit\Framework\TestCase;
use App\Controller\UserController;
use App\Model\User;
use PHPMailer\PHPMailer\PHPMailer;

class UserControllerTest extends TestCase
{
    private $db;
    private $userModel;
    private $mailer;
    private $controller;

    protected function setUp(): void
    {
        $this->db = $this->createMock(\PDO::class);
        $this->userModel = $this->createMock(User::class);
        $this->mailer = $this->createMock(PHPMailer::class);

        $this->controller = new UserController($this->db);
        $this->controller->setUserModel($this->userModel);
        $this->controller->setMailer($this->mailer);
    }

    public function testRegister()
    {
        $this->userModel->expects($this->once())
            ->method('register')
            ->with('John Doe', 'john@example.com', 'password123')
            ->willReturn('verification_token');

        $this->mailer->expects($this->once())
            ->method('send')
            ->willReturn(true);

        $this->controller->register('John Doe', 'john@example.com', 'password123');

        // Assert that no exception was thrown
        $this->addToAssertionCount(1);
    }

    public function testVerifyEmail()
    {
        $this->userModel->expects($this->once())
            ->method('verifyEmail')
            ->with('valid_token')
            ->willReturn(true);

        $result = $this->controller->verifyEmail('valid_token');

        $this->assertTrue($result);
    }
}