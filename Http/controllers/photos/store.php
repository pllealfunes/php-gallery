<?php

use Core\App;
use Core\Validator;
use Core\Database;
use Core\Session;


$config = require base_path('config.php');
$db = App::resolve(Database::class);

$user = $db->query('SELECT * FROM users WHERE name = :name', [
    'name' =>  $_SESSION['user']['name']
])->findOrFail();


$errors = [];


function checkDescription(){
    $errors = [];

    if (! Validator::string($_POST['description'], 1, 255)) {
        $errors['description'] = 'A body of no more than 255 characters is required.';
    }
    return $errors;
}


function checkPhoto($file){
    $errors = [];
    $photoContent = '';

    if (!empty($file["name"])) { 
        // Get file info 
        $fileName = basename($file["name"]); 
        
 
        if (Validator::fileType($fileName)) { 
            $photo = $file['tmp_name']; 
            $photoContent = file_get_contents($photo); 
        } else { 
            $errors['photo'] = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    } else { 
        $errors['photo'] = 'Please select an image file to upload.'; 
    }

    return ['errors' => $errors, 'photoContent' => $photoContent];
}


if (isset($_POST["submit"])) {

    // Check description
    $descriptionErrors = checkDescription($_POST['description']);
    $errors = array_merge($errors, $descriptionErrors);

    // Check photo
    $photoCheck = checkPhoto($_FILES['photo']);
    $errors = array_merge($errors, $photoCheck['errors']);
    $photoContent = $photoCheck['photoContent'];

    // If no errors, insert into database
    if (empty($errors)) {
        try {
            $db->query('INSERT INTO photos (description, photo, user_id) VALUES (:description, :photo, :user_id)', [             
                                'description' => $_POST['description'],
                                'photo' => $photoContent,
                                'user_id' => $user['id']
                            ]);
                            
            $successMsg = "Added New Photo Successfully";
            Session::flash('successMsg', $successMsg);
            header('location: /photos');
            die();
        } catch (PDOException $e) {
            $errors['db'] = "Database error: " . $e->getMessage();
        }
    } 

    Session::flash('old', $_POST);
    Session::flash('errors', $errors);
    Session::flash('photoName', $_FILES['photo']['name']);


    // Redirect back to the form
    header('Location: /photos/create');
    exit;
};