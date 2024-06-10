<?php

use Core\App;
use Core\Database;

$config = require base_path('config.php');
$db = App::resolve(Database::class);

$user = $db->query('SELECT * FROM users WHERE name = :name', [
    'name' =>  $_SESSION['user']['name']
])->findOrFail();


$photo = $db->query('select * from photos where id = :id', [
    'id' => $_POST['id']
    ])->findOrFail();

    authorize(intval($photo['user_id']) === $user['id']);

$db->query('delete from photos where id = :id', [
    'id' => $_POST['id']
]);

header('location: /photos');
exit();