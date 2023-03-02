<?php
use App\Core\View\View;
use App\Core\Support\Session;

if(!function_exists('env'))
{
     function env($key)
     {
          return $_ENV[$key] ?? $_ENV[$key];
     }
}


if(!function_exists('view'))
{
     function view($view_name, $data = null)
     {
          $view = View::make($view_name);

          if($data != null){
               extract($data);
          }
          
          require $view;
     }
}


if(!function_exists('view_path'))
{
     function view_path()
     {
          return dirname(dirname(dirname(__DIR__))) . '/resources/views/';
     }
}

if(!function_exists('base_path'))
{
     function base_path()
     {
          return dirname(dirname(dirname(__DIR__)));
     }
}

if(!function_exists('main_url'))
{
     function main_url()
     {
          return env('APP_URL') . "/" . env('MAIN_URL');
     }
}


if(!function_exists('session'))
{
     function session()
     {
          static $instance = null;

          if (!$instance) {
               $instance = new Session();
          }

          return $instance;
     }
}

if(!function_exists('back'))
{
     function back()
     {
          header('Location:' . $_SERVER['HTTP_REFERER']);
          exit;
     }
}

if (!function_exists('old')) {
     function old($key)
     {
          if (session()->hasFlash($key)) {
               return session()->getFlash($key);
          }
     }
}
