<?php

namespace App\Config;

use PDO;

class Database
{
  private static $connection;

  public static function getConnection()
  {
    if (!self::$connection) {
      $dotenv = parse_ini_file(__DIR__ . '/../../.env');
      $host = $dotenv['DB_HOST'];
      $dbname = $dotenv['DB_NAME'];
      $user = $dotenv['DB_USER'];
      $pass = $dotenv['DB_PASS'];

      self::$connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
      self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return self::$connection;
  }
}