<?php

namespace App\Controllers;

use App\Models\User;
use App\Config\Database;

class AuthController
{
  private $db;

  public function __construct()
  {
    $this->db = Database::getConnection();
  }

  public function login($email, $password)
  {
    $user = User::findByEmail($email);

    if ($user && password_verify($password, $user->password)) {
      // Iniciar sesión
      $_SESSION['user_id'] = $user->id;
      return true;
    }

    return false;
  }

  public function register($data)
  {
    $user = new User($data);
    return $user->save();
  }

  public function logout()
  {
    session_destroy();
  }
}