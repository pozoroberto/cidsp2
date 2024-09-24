<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\RegistroInvestigador;
use App\Controllers\EstadisticasController;
use App\Controllers\BuscarRegistrosController;
use App\Controllers\BackupController;

session_start();

$authController = new AuthController();
$userController = new UserController();
$registroInvestigador = new RegistroInvestigador();
$estadisticasController = new EstadisticasController();
$buscarRegistrosController = new BuscarRegistrosController();
$backupController = new BackupController();

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

  // Ejemplos de uso de los controladores
  if ($requestUri === '/update-profile') {
    $data = [
      'first_name' => 'John',
      'last_name' => 'Doe',
      'email' => 'john.doe@example.com'
    ];
    $userController->updateProfile(1, $data);
    echo 'Perfil actualizado';
  }

  if ($requestUri === '/register-investigator') {
    $data = [
      'primerNombre' => 'Jane',
      'primerApellido' => 'Smith',
      'email' => 'jane.smith@example.com',
      'numeroDocumento' => '123456'
    ];
    $registroInvestigador->registrarInvestigador($data);
    echo 'Investigador registrado';
  }

  if ($requestUri === '/estadisticas') {
    $estadisticas = $estadisticasController->obtenerEstadisticas();
    echo 'Estadísticas: ' . json_encode($estadisticas);
  }

  if ($requestUri === '/ver-registros') {
    $registros = $buscarRegistrosController->verRegistros();
    echo 'Registros: ' . json_encode($registros);
  }

  if ($requestUri === '/buscar-registros') {
    $query = 'John';
    $resultados = $buscarRegistrosController->buscarRegistros($query);
    echo 'Resultados de búsqueda: ' . json_encode($resultados);
  }

  if ($requestUri === '/backup') {
    $backupController->hacerCopiaDeSeguridad();
    echo 'Copia de seguridad realizada';
  }

  if ($requestUri === '/restore-backup') {
    $backupFile = __DIR__ . '/backups/backup.sql';
    $backupController->restaurarCopiaDeSeguridad($backupFile);
    echo 'Copia de seguridad restaurada';
  }
}
?>