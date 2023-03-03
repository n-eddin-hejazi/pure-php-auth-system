<?php
session_start();
use Dotenv\Dotenv;
use Database\DBConnection;
use App\Core\Http\Route;
use App\Core\Support\QueryBuilder;

    ini_set('display_errors', 'On');
    require_once 'vendor/autoload.php';
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    require_once 'app/core/Support/helpers.php';
    QueryBuilder::make(DBConnection::make());
    require_once 'routes/web.php';
    require_once 'routes/admin.php';
    (new Route)->resolve();

 
 
    

     
     