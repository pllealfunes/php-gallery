<?php

use Core\App;
use Core\Database;
use Core\Session;

$db = App::resolve(Database::class);

$user = $db->query('SELECT * FROM users WHERE name = :name', [
    'name' =>  $_SESSION['user']['name']
])->findOrFail();


$photo = $db->query('select * from photos where id = :id', [
    'id' => $_GET['id']
])->findOrFail();

authorize(intval($photo['user_id']) === $user['id']);

view("photos/edit.view.php", [
    'heading' => 'Edit Photo',
    'errors' => Session::get('errors'),
    'photo' => $photo,
    'photoName' => Session::get('photoName'),
    'successMsg' => Session::get('successMsg')
]);

Session::unflash();