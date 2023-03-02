<?php

namespace App\Controllers\Auth;

class ForgetPasswordController
{
    public function index()
    {
        return view('auth.forget-password');
    }
}