<?php

namespace App\Controllers\Auth;
class LoginController
{
     public string $email;
     public string $password;

     public function index()
     {
          return view('auth.login');
     }
     
     public function store()
     {
          if($_SERVER['REQUEST_METHOD'] === 'POST'){
               if(isset($_POST['email'], $_POST['password'])){
                    // assign preperties
                    $this->email = htmlspecialchars(strip_tags($_POST['email']));
                    $this->password = $_POST['password'];

                    // check the validations
                    $this->validation();

                    // check credits
                    $this->checkCredits();
               }
          }

          


     }

     public function validation()
     {
          $email_errors = $this->emailValidation();
          if(!empty($email_errors)){
               session()->setFlash('email_errors', $email_errors);
          }

          $password_errors = $this->passwordValidation();
          if(!empty($password_errors)){
               session()->setFlash('password_errors', $password_errors);
          }

          if(!empty($email_errors)){
               session()->setFlash('email', $this->email);
               return back();
          }

     }

     public function emailValidation()
     {
          $email_errors = [];
          // email validation
          if(empty($this->email)){
               $email_errors[] = "The email field is required.";
          }

          // email validation
          if(!filter_var($this->email, FILTER_VALIDATE_EMAIL) || strlen($this->email) < 6 || strlen($this->email) > 40){
               $email_errors[] = "Invalid email.";
          }

          return $email_errors;
     }

     public function passwordValidation()
     {
          $password_errors = [];
          // password validation
          if(empty($this->password)){
               $password_errors[] = "The password field is required.";
          }

          // password validation
          if(strlen($this->password) < 8){
               $password_errors[] = "The password field should be grater than or equal to 8 characters.";
          }

          // password validation
          if(strlen($this->password) > 32){
               $password_errors[] = "The password field should be less than or equal to 32 characters.";
          }

          return $password_errors;
     }

     public function checkCredits()
     {
          include 'database/db_connection.php';
          $stmt = $db->prepare("SELECT * FROM `users` WHERE `email` = ?");
          $stmt->execute([$this->email]);

          $user = $stmt->rowCount() ? $stmt->fetch() : null;

          if(!$stmt->rowCount()){
               session()->setFlash('db_fail', 'Username or password incorrect!.');
               return back();
          }

          if($stmt->rowCount() && !password_verify($this->password, $user['password'])){
               session()->setFlash('db_fail', 'Username or password incorrect!.');
               return back();
          }

          if($stmt->rowCount() && password_verify($this->password, $user['password'])){
               $_SESSION['loggedin'] = true;
               $_SESSION['get_id'] = $user['id'];
               $_SESSION['get_name'] = $user['name'];
               $_SESSION['get_email'] = $user['email'];

               session()->setFlash('success', "Welcome {$user['name']}, you are logged in");
               return back();
          }
      

     }



}   