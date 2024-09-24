<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <link rel="stylesheet" href="/cidsp2/public/css/styles.css">
</head>
<body>
  <h1>Registro</h1>
  <form action="/cidsp2/register" method="POST">
    <label for="first_name">Nombre:</label>
    <input type="text" id="first_name" name="first_name" required>
    <label for="last_name">Apellido:</label>
    <input type="text" id="last_name" name="last_name" required>
    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Registrarse</button>
  </form>
</body>
</html>