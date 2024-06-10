    <?php

    use Core\App;
    use Core\Authenticator;
    use Core\Database;
    use Core\Validator;


    $db = App::resolve(Database::class);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = [];


    if (!Validator::string($password, 7, 255)) {
        $errors['password'] = 'Please provide a password of at least 7 characters.';
    }

    if (!Validator::email($email)) {
        $errors['email'] = 'Please provide a valid email address.';
    }
    
    if (!Validator::string($name, 4, 255)) {
        $errors['name'] = 'Please provide a name of at least 4 characters.';
    }

    if (! empty($errors)) {
        return view('registration/create.view.php', [
            'errors' => $errors
        ]);
    }

    $user = $db->query('select * from users where email = :email', [
        'email' => $email
    ])->find();

    if ($user) {
        header('location: /');
        exit();
    }else {
        $db->query('INSERT INTO users(name, email, password) VALUES(:name, :email, :password)', [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);

        (new Authenticator)->login(['name' => $name]);
        
        header('location: /');
        exit();
    }