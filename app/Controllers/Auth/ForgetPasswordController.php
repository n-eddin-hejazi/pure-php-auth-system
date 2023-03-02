<?php
namespace App\Controllers\Auth;
use App\Core\Support\Mail;
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

    private function sendEmail()
    {
        // email validation
        include 'database/db_connection.php';
        $stmt = $db->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $stmt->execute([$this->email]);

        // if email not exist, return back
        if (!$stmt->rowCount()) {
            sleep(3);
            session()->setFlash('success', "You will receive an email if your email is registered.");
            return to('login');
        }

        // if email exist, send email
        if ($stmt->rowCount()) {
            $subject = env('APP_NAME') . " Account recovery information";
            $HTML_message = file_get_contents(view_path() . 'emails/forget-passowrd-email.view.php');
            if(Mail::sendMail($this->email, $subject, $HTML_message)){
                session()->setFlash('success', "You will receive an email if your email is registered.");
                return to('login');
            }else{
                session()->setFlash('fail', "There is an error, please try again later!.");
                return back();
            }
            
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
}