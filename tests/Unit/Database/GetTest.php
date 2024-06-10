<?php

use Core\Authenticator;
use Core\Database;
use Core\App;



beforeEach(function () {
    // Mock the Database class
    $this->mockDatabase = Mockery::mock(Database::class);
    $this->mockDatabase->shouldReceive('query')->andReturnSelf();

    // Mock the get method to return an array of photos
    $this->mockDatabase->shouldReceive('get')->andReturn([
        ['id' => 1, 'user_id' => 1, 'url' => 'photo1.jpg'],
        ['id' => 2, 'user_id' => 1, 'url' => 'photo2.jpg'],
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

it('it gets all photos from logged in user', function () {

    $photos = $this->mockDatabase->query('SELECT * FROM photos WHERE user_id = :user_id', [
        'user_id' => 1
    ])->get();

    // Assert that the result is an array
    expect($photos)->toBeArray();

    // Additional assertions to verify the contents of the array
    expect($photos)->toHaveCount(2);
    expect($photos[0]['url'])->toBe('photo1.jpg');
    expect($photos[1]['url'])->toBe('photo2.jpg');
 
    
});