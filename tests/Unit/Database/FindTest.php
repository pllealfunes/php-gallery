<?php

use Core\Authenticator;
use Core\Database;
use Core\App;



beforeEach(function () {
    // Mock the Database class
    $this->mockDatabase = Mockery::mock(Database::class);
    $this->mockDatabase->shouldReceive('query')->andReturnSelf();

   // Mock the find method to return a specific photo
   $this->mockDatabase->shouldReceive('find')->andReturn([
    'id' => 1,
    'user_id' => 1,
    'url' => 'photo1.jpg'
]);

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


it('finds 1 photo by id', function () {

    $photo = $this->mockDatabase->query('SELECT * FROM photos WHERE id = :id', [
        'id' => 1
    ])->find();

    // Assert that the result is an array
    expect($photo)->toBeArray();
    expect($photo['id'])->toBe(1);
    expect($photo['url'])->toBe('photo1.jpg');
    
});