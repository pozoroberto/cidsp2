<?php

namespace App\Controllers;

use App\Config\Database;
use PDO;

class BackupController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function hacerCopiaDeSeguridad()
    {
        $backupFile = __DIR__ . '/../../backups/backup_' . date('Y-m-d_H-i-s') . '.sql';
        $command = "mysqldump --user=" . getenv('DB_USER') . " --password=" . getenv('DB_PASS') . " --host=" . getenv('DB_HOST') . " " . getenv('DB_NAME') . " > " . $backupFile;

        system($command, $output);

        if ($output !== 0) {
            throw new \Exception("Error al hacer la copia de seguridad.");
        }
    }

    public function restaurarCopiaDeSeguridad($backupFile)
    {
        $command = "mysql --user=" . getenv('DB_USER') . " --password=" . getenv('DB_PASS') . " --host=" . getenv('DB_HOST') . " " . getenv('DB_NAME') . " < " . $backupFile;

        system($command, $output);

        if ($output !== 0) {
            throw new \Exception("Error al restaurar la copia de seguridad.");
        }
    }
}