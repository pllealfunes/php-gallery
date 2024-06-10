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

});

afterEach(function () {
    // Clean up the session
    session_unset();
    session_destroy();

    // Close Mockery
    Mockery::close();
});

it('logs user out and destroys session', function () {
   // Start a session if none exists
   if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

    expect($_SESSION)->toBeEmpty(); // Verify session user
  
});