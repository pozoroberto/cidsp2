<?php

namespace App\Controllers;

use App\Config\Database;
use PDO;

class UserController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function updateProfile($userId, $data)
    {
        // Verificar que el usuario es un investigador
        $stmt = $this->db->prepare("SELECT role_id FROM users WHERE id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user['role_id'] != 1) {
            throw new \Exception("No tiene permiso para actualizar el perfil.");
        }

        // Actualizar los datos del perfil
        $stmt = $this->db->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email WHERE id = :userId");
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }

    public function modificarRegistro($userId, $data, $adminKey)
    {
        // Verificar la clave del administrador
        $adminClave = 'clave_del_administrador'; // Esta clave debe ser almacenada de manera segura
        if ($adminKey !== $adminClave) {
            throw new \Exception("Clave del administrador incorrecta.");
        }

        // Modificar los datos del registro
        $stmt = $this->db->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email WHERE id = :userId");
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }

    public function establecerPermisos($userId, $permisos, $adminKey)
    {
        // Verificar la clave del administrador
        $adminClave = 'clave_del_administrador'; // Esta clave debe ser almacenada de manera segura
        if ($adminKey !== $adminClave) {
            throw new \Exception("Clave del administrador incorrecta.");
        }

        // Establecer permisos para el usuario Asistente
        $stmt = $this->db->prepare("UPDATE users SET permisos = :permisos WHERE id = :userId AND role_id = 2");
        $stmt->bindParam(':permisos', $permisos);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }
}
