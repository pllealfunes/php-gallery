<?php

use Core\App;
use Core\Database;
use Core\Session;


$config = require base_path('config.php');
$db = App::resolve(Database::class);

$user = $db->query('SELECT * FROM users WHERE name = :name', [
    'name' =>  $_SESSION['user']['name']
])->findOrFail();


$photos = $db->query('SELECT * FROM photos WHERE user_id = :user_id', [
    'user_id' => $user['id']
])->get();



view("photos/index.view.php", [
    'heading' => 'Gallery',
    'photos' => $photos,
    'successMsg' => Session::get('successMsg')
]);

Session::unflash();