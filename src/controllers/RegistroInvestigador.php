<?php

namespace App\Controllers;

use App\Config\Database;
use PDO;

class RegistroInvestigador
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function registrarInvestigador($data)
    {
        // Generar contraseña automáticamente
        $password = $data['numeroDocumento'] . strtoupper(substr($data['primerNombre'], 0, 1)) . strtoupper(substr($data['primerApellido'], 0, 1));
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertar datos del investigador en la base de datos
        $stmt = $this->db->prepare("INSERT INTO users (first_name, last_name, email, password, role_id) VALUES (:first_name, :last_name, :email, :password, 1)");
        $stmt->bindParam(':first_name', $data['primerNombre']);
        $stmt->bindParam(':last_name', $data['primerApellido']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        // Enviar correo electrónico con los datos de registro y la clave de acceso
        $this->enviarCorreo($data['email'], $password);
    }

    private function enviarCorreo($email, $password)
    {
        $to = $email;
        $subject = "Datos de Registro y Clave de Acceso";
        $message = "Su registro ha sido exitoso. Su clave de acceso es: " . $password;
        $headers = "From: no-reply@tudominio.com";

        mail($to, $subject, $message, $headers);
    }
}