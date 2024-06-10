<?php

$router->get('/', '/index.php');

$router->get('/photos', 'photos/index.php')->only('auth');

$router->get('/photo', 'photos/show.php')->only('auth');
$router->delete('/photo', 'photos/destroy.php')->only('auth');

$router->get('/photo/edit', 'photos/edit.php')->only('auth');
$router->patch('/photo', 'photos/update.php')->only('auth');

$router->get('/photos/create', 'photos/create.php')->only('auth');
$router->post('/photos', 'photos/store.php')->only('auth');

$router->get('/register', 'registration/create.php')->only('guest');
$router->post('/register', 'registration/store.php')->only('guest');

$router->get('/login', 'session/create.php')->only('guest');
$router->post('/session', 'session/store.php')->only('guest');
$router->delete('/session', 'session/destroy.php')->only('auth');