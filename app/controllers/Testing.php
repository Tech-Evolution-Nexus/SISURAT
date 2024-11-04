<?php

use app\controllers\AuthController;
use app\services\Session;
use PHPUnit\Framework\TestCase;

class Testing extends TestCase
{
    protected function setUp(): void
    {
        // Set up session
        if (!isset($_SESSION)) {
            $_SESSION = [];
        }
    }
    //method mengecek apakah email kosong
    public function testEmptyEmail()
    {
        $_POST['email'] = '';
        $_POST['password'] = 'password123';

        $auth = new AuthController(); // Replace with the actual class name containing the authentic() method
        $auth->authentic();

        // $this->assertArrayHasKey("usernameErr", $_SESSION);
        $this->assertEquals('email tidak boleh kosong', $_SESSION["usernameErr"]);
    }

    //method mengecek apakah password kosong
    public function testEmptyPassword()
    {
        $_POST['email'] = 'test@example.com';
        $_POST['password'] = '';

        $auth = new AuthController();
        $auth->authentic();

        // $this->assertArrayHasKey("passwordErr", $_SESSION);
        $this->assertEquals('Kata sandi tidak boleh kosong', $_SESSION["passwordErr"]);
    }

    //method mengecek apakah panjang password kurang dari 8
    public function testPasswordTooShort()
    {
        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'short';

        $auth = new AuthController();
        $auth->authentic();

        // $this->assertArrayHasKey("passwordErr", $_SESSION);
        $this->assertEquals('Kata sandi minimal 8 karakter', $_SESSION["passwordErr"]);
    }

    //method mengecek apakah akun tidak benar
    public function testInvalidCredentials()
    {
        $_POST['email'] = 'muh2@example.com';
        $_POST['password'] = 'incorrectpassword';

        // Mock database connection and query result
        // $dbMock = $this->createMock(Database::class);
        // $dbMock->method('getConnection')->willReturn($this->getMockPDO(false));

        $auth = new AuthController();
        // $auth->setDatabase($dbMock); // Method to set the database connection in the authentic() method
        $auth->authentic();

        // $this->assertArrayHasKey("usernameErr", $_SESSION);
        $this->assertEquals('Username tidak terdaftar', $_SESSION["usernameErr"]);
    }

    //method mengecek login dengan benar 
    public function testSuccessfulLogin()
    {
        $_POST['email'] = 'test@example.com';
        $_POST['password'] = 'validpassword';

        $auth = new AuthController();
        // $auth->setDatabase($dbMock);
        $auth->authentic();
        $session = new Session();
        $this->assertTrue(!!$session->get("user"));
        // Checking if headers have been sent as expected for a successful login
    }
}
