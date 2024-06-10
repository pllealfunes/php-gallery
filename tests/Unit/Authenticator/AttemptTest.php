<?php

use Core\Authenticator;
use Core\Database;
use Core\App;



beforeEach(function () {
    // Mock the Database class
    $this->mockDatabase = Mockery::mock(Database::class);
    $this->mockDatabase->shouldReceive('query')->andReturnSelf();

    // Mock the App::resolve method to return the mocked Database
    $this->mockApp = Mockery::mock('alias:' . App::class);
    $this->mockApp->shouldReceive('resolve')->with(Database::class)->andReturn($this->mockDatabase);

    // Create an instance of the Authenticator
    $this->authenticator = new Authenticator();

    // Start a session if none exists
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
});

afterEach(function () {
    // Clean up the session
    session_unset();
    session_destroy();

    // Close Mockery
    Mockery::close();
});

// Test for successful login
it('attempts login with correct credentials', function () {
    $email = 'test@example.com';
    $password = 'password';
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $user = ['name' => 'Test User', 'email' => $email, 'password' => $hashedPassword];

    // Mock the find method to return the user
    $this->mockDatabase->shouldReceive('find')->andReturn($user);

    // Call the attempt method
    $result = $this->authenticator->attempt($email, $password);

    // Additional assertions for debugging
    expect(password_verify($password, $hashedPassword))->toBeTrue(); // Verify password
    expect($result)->toBeTrue(); // Verify attempt result
    expect($_SESSION['user']['name'])->toBe('Test User'); // Verify session user
});

// Test for login failure with incorrect password
it('fails login with incorrect password', function () {
    $email = 'test@example.com';
    $password = 'wrongpassword';
    $hashedPassword = password_hash('correctpassword', PASSWORD_BCRYPT);
    $user = ['name' => 'Test User', 'password' => $hashedPassword];

    // Mock the find method to return the user
    $this->mockDatabase->shouldReceive('find')->andReturn($user);

    // Call the attempt method
    $result = $this->authenticator->attempt($email, $password);

    // Assert the results
    expect($result)->toBeFalse();
    expect(isset($_SESSION['user']))->toBeFalse();
});

// Test for login failure when user is not found
it('fails login when user not found', function () {
    $email = 'test@example.com';
    $password = 'password';

    // Ensure the find method returns null
    $this->mockDatabase->shouldReceive('find')->andReturnNull();

    // Call the attempt method
    $result = $this->authenticator->attempt($email, $password);

    // Assert the results
    expect($result)->toBeFalse();
    expect(isset($_SESSION['user']))->toBeFalse();
});