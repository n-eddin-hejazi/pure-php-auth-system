<?php

namespace App\Controllers\Auth;
class LogoutController
{
    public function index()
    {
        session_start();
        session_unset();
        session_destroy();
        return to('');
    }

}