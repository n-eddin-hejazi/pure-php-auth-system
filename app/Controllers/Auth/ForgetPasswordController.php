<?php
namespace App\Controllers\Auth;
use App\Core\Support\Mail;
use App\Core\Support\QueryBuilder;
class ForgetPasswordController
{
    private string $email;

    public function index()
    {
        ifAuth();
        return view('auth.forget-password');
    }

    public function forgetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['email'])) {
                // assign preperties
                $this->email = htmlspecialchars(strip_tags($_POST['email']));

                // check the validations
                $this->validation();

                // send mail
                $this->sendEmail();

            }
        }
    }

    private function checkIfEmailNotExist()
    {
        // email validation
        $user = QueryBuilder::get('users', 'email', '=', $this->email);
        // if email not exist, return to login
        if(!$user){
            sleep(3);
            $this->makePropertiesEmpty();
            session()->setFlash('success', "You will receive an email if your email is registered.");
            return to('login');
        }

    }

    private function firstSending()
    {
        // get user
        $user = QueryBuilder::get('users', 'email', '=', $this->email);
        
        // start - prepare the data of email
        $subject = env('APP_NAME') . " Account recovery information";
        $email = $this->email;
        $token = $this->generateUniqueToken();
        $url = main_url() . "/reset-passowrd?email={$this->email}&token={$token}";
        $HTML_message = file_get_contents(view_path() . 'emails/forget-passowrd-email.html');
        $HTML_message = str_replace('{url}', $url, $HTML_message);
        // end - prepare the data of email 

        // send mail        
        if(Mail::sendMail($this->email, $subject, $HTML_message)){
            // Insert the email and token into the password_resets table
            $data = ['email' => $email, 'token' => $token];
            QueryBuilder::insert('password_resets', $data);

            // assign class property as empty values
            $this->makePropertiesEmpty();
            
            // send success message
            session()->setFlash('success', "You will receive an email if your email is registered.");
            return to('login');  
        }else{
            // assign class property as empty values
            $this->makePropertiesEmpty();

            // send fail message
            session()->setFlash('fail', "There is an error, please try again later!.");
            return back();
        }
        
    }

    private function sendEmail()
    {
        $this->checkIfEmailNotExist();
        $this->firstSending();
    }

    private function generateUniqueToken()
    {
        $token = bin2hex(random_bytes(25));
        $old_token = QueryBuilder::get('password_resets', 'token', '=', $token);
        if($old_token){
            // Token already exists in the database
            return $this->generateUniqueToken();
        }else{
            // Token does not exist in the database
            return $token;
        }
        
    }

    private function validation()
    {
        $email_errors = $this->emailValidation();
        if (!empty($email_errors)) {
            session()->setFlash('email_errors', $email_errors);
        }

        if (!empty($email_errors)) {
            session()->setFlash('email', $this->email);
            return back();
        }

    }

    private function emailValidation()
    {
        $email_errors = [];
        // email validation
        if (empty($this->email)) {
            $email_errors[] = "The email field is required.";
        }

        // email validation
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL) || strlen($this->email) < 6 || strlen($this->email) > 40) {
            $email_errors[] = "Invalid email.";
        }

        return $email_errors;
    }

    private function makePropertiesEmpty()
    {
        $this->email = '';
    }
}
