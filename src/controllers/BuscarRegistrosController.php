<?php

namespace App\Controllers;

use App\Config\Database;
use PDO;

class BuscarRegistrosController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function verRegistros()
    {
        // Obtener todos los registros de usuarios
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarRegistros($query)
    {
        // Buscar registros de usuarios por nombre o apellido
        $stmt = $this->db->prepare("SELECT * FROM users WHERE first_name LIKE :query OR last_name LIKE :query");
        $searchQuery = '%' . $query . '%';
        $stmt->bindParam(':query', $searchQuery);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}