<?php

namespace app\controllers;

use app\models\UserModel;
use PHPUnit\Framework\TestCase; 
use Mockery as m;

class Testing extends TestCase
{
    protected function tearDown(): void
    {
        m::close(); // Close Mockery after each test
    }

    public function testUserAuthenticatesSuccessfully()
    {
        // Arrange
        $authController = new AuthController();

        // Mock request to simulate form input
        $requestMock = m::mock('alias:Request');
        $requestMock->shouldReceive('validate')->once()->with([
            "email" => "required|email",
            "password" => "required|min:8",
        ]);

        // Input values
        $email = "test@example.com";
        $password = "password123";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $requestMock->shouldReceive('input')->with('email')->andReturn($email);
        $requestMock->shouldReceive('input')->with('password')->andReturn($password);

        // Mock UserModel to find user by email
        $user = (object) ["email" => $email, "password" => $hashedPassword];
        $userModelMock = m::mock(UserModel::class);
        $userModelMock->shouldReceive('where')->with("email", "=", $email)->andReturnSelf();
        $userModelMock->shouldReceive('first')->andReturn($user);

        // Inject mock UserModel into $this->model->users
        $authController->model->users = $userModelMock;

        // Mock session
        $sessionMock = m::mock('alias:Session');
        $sessionMock->shouldReceive('set')->with("user", $user)->once();

        // Mock redirect
        $redirectMock = m::mock('alias:Redirect');
        $redirectMock->shouldReceive('to')->with("/admin")->andReturn("redirected to /admin");

        // Act
        $result = $authController->authentic();

        // Assert
        $this->assertEquals("redirected to /admin", $result);
    }


    public function testAuthenticationFailsWithInvalidPassword()
    {
        // Arrange
        $authController = new AuthController();

        // Mock request and validation
        $requestMock = m::mock('alias:Request');
        $requestMock->shouldReceive('validate')->once()->with([
            "email" => "required|email",
            "password" => "required|min:8",
        ]);

        // Input values
        $email = "test@example.com";
        $password = "invalid_password";

        $requestMock->shouldReceive('input')->with('email')->andReturn($email);
        $requestMock->shouldReceive('input')->with('password')->andReturn($password);

        // Mock UserModel to return user with different password
        $user = (object) ["email" => $email, "password" => password_hash("password123", PASSWORD_DEFAULT)];
        $userModelMock = m::mock(UserModel::class);
        $userModelMock->shouldReceive('where')->with("email", "=", $email)->andReturnSelf();
        $userModelMock->shouldReceive('first')->andReturn($user);

        $authController->model->users = $userModelMock;

        // Mock redirect back with error message
        $redirectMock = m::mock('alias:Redirect');
        $redirectMock->shouldReceive('with')->with("error", "Password salah")->andReturnSelf();
        $redirectMock->shouldReceive('back')->andReturn("redirected back with error");

        // Act
        $result = $authController->authentic();

        // Assert
        $this->assertEquals("redirected back with error", $result);
    }

    public function testAuthenticationFailsWithUnknownUser()
    {
        // Arrange
        $authController = new AuthController();

        // Mock request and validation
        $requestMock = m::mock('alias:Request');
        $requestMock->shouldReceive('validate')->once()->with([
            "email" => "required|email",
            "password" => "required|min:8",
        ]);

        // Input values
        $email = "unknown@example.com";
        $password = "password123";

        $requestMock->shouldReceive('input')->with('email')->andReturn($email);
        $requestMock->shouldReceive('input')->with('password')->andReturn($password);

        // Mock UserModel to return no user
        $userModelMock = m::mock(UserModel::class);
        $userModelMock->shouldReceive('where')->with("email", "=", $email)->andReturnSelf();
        $userModelMock->shouldReceive('first')->andReturn(null);

        $authController->model->users = $userModelMock;

        // Mock redirect back with error message
        $redirectMock = m::mock('alias:Redirect');
        $redirectMock->shouldReceive('with')->with("error", "User tidak ditemukan")->andReturnSelf();
        $redirectMock->shouldReceive('back')->andReturn("redirected back with error");

        // Act
        $result = $authController->authentic();

        // Assert
        $this->assertEquals("redirected back with error", $result);
    }
}
