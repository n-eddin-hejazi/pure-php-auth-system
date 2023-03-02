<?php
session_start();
use Dotenv\Dotenv;
use App\Core\Http\Route;
     
     ini_set('display_errors', 'On');
     require_once 'vendor/autoload.php';
     $dotenv = Dotenv::createImmutable(__DIR__);
     $dotenv->load();
     require_once 'app/core/Support/helpers.php';
     require_once 'database/db_connection.php';
     require_once 'routes/web.php';
     (new Route)->resolve();
     
     