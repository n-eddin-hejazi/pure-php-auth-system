<?php

namespace App\Controllers\Auth;
// use Database\Database;

class RegisterController
{
     public string $name;
     public string $email;
     public string $password;
     public string $password_confirmation;
     
     public function index()
     {
          return view('auth.register');
     }

     public function store()
     {
          if($_SERVER['REQUEST_METHOD'] === 'POST'){
               if(isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password_confirmation'])){

                    // assign preperties
                    $this->name = htmlspecialchars(strip_tags($_POST['name'])) ;
                    $this->email = htmlspecialchars(strip_tags($_POST['email']));
                    $this->password = $_POST['password'];
                    $this->password_confirm = $_POST['password_confirmation'];


                    // connect to database
                    
                    
                    // check the validations
                    $this->validation();

                    // create new account
                    $this->craeteNewAccount();
                    
               }
          }

     }

     private function craeteNewAccount()
     {
          include 'database/db_connection.php';
          try{
               $stmt = $db->prepare("INSERT INTO `users` (`name`, `password`, `email`) VALUES(?, ?, ?)");
               $stmt->execute([$this->name, password_hash($this->password, PASSWORD_DEFAULT), $this->email]);
               if($stmt->rowCount()){
                    session()->setFlash('success', 'Registered sucessfully');
                    return back();
               }else{
                    session()->setFlash('db_fail', 'There is an error, please try again later!');
                    return back();
               }
          } catch (Exception $e) {
               session()->setFlash('db_fail', $e->getMessage());
               return back();
          }

     }

     public function validation()
     {
          $name_errors = $this->nameValidation();
          if(!empty($name_errors)){
               session()->setFlash('name_errors', $name_errors);
          }

          $email_errors = $this->emailValidation();
          if(!empty($email_errors)){
               session()->setFlash('email_errors', $email_errors);
          }

          $password_errors = $this->passwordValidation();
          if(!empty($password_errors)){
               session()->setFlash('password_errors', $password_errors);
          }

          if(!empty($name_errors) || !empty($email_errors) || !empty($password_errors)){
               session()->setFlash('name', $this->name);
               session()->setFlash('email', $this->email);
               return back();
          }

     }

     public function nameValidation()
     {
          $name_errors = [];

          // name validation
          if(empty($this->name)){
               $name_errors[] = 'name is required';
          }

          // name validation
          if(strlen($this->name) < 3){
               $name_errors[] = 'the length of username field shloud be grater than 3';
          }

          // name validation
          if(strlen($this->name) > 32){
               $name_errors[] = 'the length of username field shloud be less than 32';
          }

          return $name_errors;
     }

     public function emailValidation()
     {
          $email_errors = [];
          // email validation
          if(empty($this->email)){
               $email_errors[] = "email is required";
          }

          // email validation
          if(!filter_var($this->email, FILTER_VALIDATE_EMAIL) || strlen($this->email) < 6 || strlen($this->email) > 40){
               $email_errors[] = "invalid email";
          }

          // email validation
          include 'database/db_connection.php';
          $stmt = $db->prepare("SELECT * FROM `users` WHERE `email` = ?");
          $stmt->execute([$this->email]);
          if($stmt->rowCount()){
               $email_errors[] = "email is alerady taken, please pick up another one";
          }

          return $email_errors;
     }

     public function passwordValidation()
     {
          $password_errors = [];
          // password validation
          if(empty($this->password)){
               $password_errors[] = "password is required";
          }

          // password validation
          if(strlen($this->password) < 8){
               $password_errors[] = "the password should be grater than 7";
          }

          // password validation
          if(strlen($this->password) > 32){
               $password_errors[] = "the password should be less than 33";
          }

          // password validation
          if($this->password_confirm !== $this->password){
               $password_errors[] = "password confirmation doesn't match";
          }

          return $password_errors;
         
     }

}