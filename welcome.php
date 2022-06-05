<?php
// Inicializa la sesión
session_start();
 
// Comprueba que el usuario se ha iniciado sesión. Si no, redirige a la página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5;url=//proyecto.rf.gd" />
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body style="font: 14px sans-serif; text-align: center; background-image: url(/assets/images/marble_wall.jpg); ")>">
    <div class="page-header">
        <h1 style="color: white;">Hola, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.<br> Te has logueado satisfactoriamente.</h1><h3 style="color: cyan;">En 5 segundos serás redirigido a la página principal</h3>
    </div>
<!-- Redirecciones -->
        <a href="reset-password.php" class="btn btn-warning">Reset Contraseña</a>
        <a href="logout.php" class="btn btn-danger">Cierra la sesión</a>
<!-- Fin redirecciones -->
</body>
</html>
