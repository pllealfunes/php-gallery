<?php

use Core\App;
use Core\Validator;
use Core\Database;
use Core\Session;

$config = require base_path('config.php');
$db = App::resolve(Database::class);

 // Fetch the original photo record
 $photo = $db->query('SELECT * FROM photos WHERE id = :id', [
    'id' => $_POST['id']
])->findOrFail();

$user = $db->query('SELECT * FROM users WHERE name = :name', [
    'name' =>  $_SESSION['user']['name']
])->findOrFail();


// Authorize the user
authorize($photo['user_id'] === $user['id']);

$errors = [];


function checkDescription(){
    $errors = [];

    if (! Validator::string($_POST['description'], 1, 255)) {
        $errors['description'] = 'A body of no more than 255 characters is required.';
    }
    return $errors;
}


    
function checkPhoto($file, $originalPhoto) {
    $errors = [];
    $photoContent = '';

    if (!empty($file["name"])) {
        // Get file info
        $fileName = basename($file["name"]);

        if (Validator::fileType($fileName)) {
            $newPhoto = $file['tmp_name'];
            $photoContent = file_get_contents($newPhoto);
        } else {
            $errors['photo'] = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
        }
    } else {
        // If no new photo is uploaded, keep the original photo
        $photoContent = $originalPhoto;
    }

    return ['errors' => $errors, 'photoContent' => $photoContent];
}




if (isset($_POST["submit"])) { 
    
     // Check description
     $descriptionErrors = checkDescription($_POST['description']);
     $errors = array_merge($errors, $descriptionErrors);
 
     // Check photo
     $photoCheck = checkPhoto($_FILES['photo'], $photo['photo']);
     $errors = array_merge($errors, $photoCheck['errors']);
     $photoContent = $photoCheck['photoContent'];


      // If no errors, update the database
      if (empty($errors)) {
        try {
            $updateValues = [
                'id' => $_POST['id'],
                'description' => $_POST['description'],
                'photo' => $photoContent,
                'user_id' => $photo['user_id']
            ];
            $db->query('UPDATE photos SET description = :description, photo = :photo, user_id = :user_id WHERE id = :id', $updateValues);
            
            $successMsg = "Update Successfully";
            Session::flash('successMsg', $successMsg);
            header('Location: /photo/edit?id='. $_POST['id']);
            exit;
        } catch (PDOException $e) {
            $errors['db'] = "Database error: " . $e->getMessage();
        }
    } 

    Session::flash('errors', $errors);
    Session::flash('photoName', $_FILES['photo']['name']);
 
     header('Location: /photo/edit?id='. $_POST['id']);
     exit;
};