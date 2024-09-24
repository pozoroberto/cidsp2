<?php

namespace App\Controllers;

use App\Config\Database;
use PDO;

class EstadisticasController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function obtenerEstadisticas()
    {
        // Obtener estadísticas de ejemplo
        $stmt = $this->db->prepare("SELECT COUNT(*) as total_usuarios FROM users");
        $stmt->execute();
        $totalUsuarios = $stmt->fetch(PDO::FETCH_ASSOC)['total_usuarios'];

        $stmt = $this->db->prepare("SELECT COUNT(*) as total_investigadores FROM users WHERE role_id = 1");
        $stmt->execute();
        $totalInvestigadores = $stmt->fetch(PDO::FETCH_ASSOC)['total_investigadores'];

        $stmt = $this->db->prepare("SELECT COUNT(*) as total_asistentes FROM users WHERE role_id = 2");
        $stmt->execute();
        $totalAsistentes = $stmt->fetch(PDO::FETCH_ASSOC)['total_asistentes'];

        $stmt = $this->db->prepare("SELECT COUNT(*) as total_administradores FROM users WHERE role_id = 3");
        $stmt->execute();
        $totalAdministradores = $stmt->fetch(PDO::FETCH_ASSOC)['total_administradores'];

        return [
            'total_usuarios' => $totalUsuarios,
            'total_investigadores' => $totalInvestigadores,
            'total_asistentes' => $totalAsistentes,
            'total_administradores' => $totalAdministradores
        ];
    }
}