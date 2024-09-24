<?php

namespace App\Models;

use App\Config\Database;

class User
{
  private $db;
  public $id;
  public $email;
  public $password;
  public $first_name;
  public $last_name;

  public function __construct($data = [])
  {
    $this->db = Database::getConnection();
    $this->email = $data['email'] ?? null;
    $this->password = $data['password'] ?? null;
    $this->first_name = $data['first_name'] ?? null;
    $this->last_name = $data['last_name'] ?? null;
  }

  public static function findByEmail($email)
  {
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $data = $stmt->fetch();

    if ($data) {
      return new self($data);
    }

    return null;
  }

  public function save()
  {
    $stmt = $this->db->prepare("INSERT INTO users (email, password, first_name, last_name) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$this->email, password_hash($this->password, PASSWORD_BCRYPT), $this->first_name, $this->last_name]);
  }
}