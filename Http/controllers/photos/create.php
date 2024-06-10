<?php


use Core\Session;

view("photos/create.view.php", [
    'heading' => 'Add New Photo',
    'errors' => Session::get('errors'),
    'old' => Session::get('old', []),
    'photoName' => Session::get('photoName')
]);

Session::unflash();