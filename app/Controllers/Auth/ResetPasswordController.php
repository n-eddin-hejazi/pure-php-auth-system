<?php
namespace App\Controllers\Auth;

class ResetPasswordController
{
    public function index()
    {
        ifAuth();
        return view('auth.reset-password');
    }
}