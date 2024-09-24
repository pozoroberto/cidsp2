<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\AuthController;

session_start();

$authController = new AuthController();

$requestUri = str_replace('/cidsp2', '', $_SERVER['REQUEST_URI']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($requestUri === '/register') {
    $data = [
      'first_name' => $_POST['first_name'],
      'last_name' => $_POST['last_name'],
      'email' => $_POST['email'],
      'password' => $_POST['password']
    ];
    $authController->register($data);
    header('Location: /cidsp2/login');
    exit;
  }

  if ($requestUri === '/login') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($authController->login($email, $password)) {
      header('Location: /cidsp2/dashboard');
      exit;
    } else {
      echo 'Credenciales incorrectas';
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if ($requestUri === '/register') {
    require_once __DIR__ . '/views/auth/register.php';
  }

  if ($requestUri === '/login') {
    require_once __DIR__ . '/views/auth/login.php';
  }

  if ($requestUri === '/dashboard') {
    echo 'Bienvenido al dashboard';
  }
}