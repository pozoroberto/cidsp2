<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="/cidsp2/public/css/styles.css">
</head>
<body>
  <h1>Iniciar sesión</h1>
  <form action="/cidsp2/login" method="POST">
    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Iniciar sesión</button>
  </form>
</body>
</html>