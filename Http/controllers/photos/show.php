<?php

use Core\App;
use Core\Database;

$config = require base_path('config.php');
$db = App::resolve(Database::class);


$user = $db->query('SELECT * FROM users WHERE name = :name', [
    'name' =>  $_SESSION['user']['name']
])->findOrFail();


    $photo = $db->query('SELECT * FROM photos WHERE id = :id', [
        'id' => $_GET['id']
    ])->findOrFail();

    
    authorize(intval($photo['user_id']) === $user['id']);


view("photos/show.view.php", [
    'heading' => 'Photo',
    'photo' => $photo
]);