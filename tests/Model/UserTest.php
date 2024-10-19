<?php
namespace Tests\Model;

use PHPUnit\Framework\TestCase;
use App\Model\User;

class UserTest extends TestCase
{
    private $db;
    private $user;

    protected function setUp(): void
    {
        // Create a mock PDO object
        $this->db = $this->createMock(\PDO::class);
        $this->user = new User($this->db);
    }

    public function testRegister()
    {
        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
            ->method('execute')
            ->with($this->callback(function($params) {
                return count($params) == 4 &&
                    $params[0] == 'John Doe' &&
                    $params[1] == 'john@example.com' &&
                    password_verify('password123', $params[2]) &&
                    strlen($params[3]) == 32; // Verify token length
            }))
            ->willReturn(true);

        $this->db->expects($this->once())
            ->method('prepare')
            ->willReturn($stmt);

        $token = $this->user->register('John Doe', 'john@example.com', 'password123');

        $this->assertIsString($token);
        $this->assertEquals(32, strlen($token));
    }

    public function testVerifyEmail()
    {
        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->expects($this->once())
            ->method('execute')
            ->with(['valid_token'])
            ->willReturn(true);

        $this->db->expects($this->once())
            ->method('prepare')
            ->willReturn($stmt);

        $result = $this->user->verifyEmail('valid_token');

        $this->assertTrue($result);
    }
}