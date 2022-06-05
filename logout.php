<?php
// Comprobar la inicialización de sesión para pasar a destruirla
session_start();

// Obtiene todas las cadenas para destruir todas las variables de la sesión actual.
$_SESSION = array();

// Si deseamos destruir la sesión, borramos las cookies que almacena la variable.
// Esto hará destruir por completo la sesión y limpiar la cookie almacenada.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Sesión destruida.
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="3;url=//proyecto.rf.gd" />
    <title>End of Session</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body style="font: 14px sans-serif; text-align: center; background-image: url(/assets/images/marble_wall.jpg);")>">
    <div class="page-header">
        <h1 style="color: white;">You ended this session</h1>
        <h3 style="color: cyan;" >Now please wait 3 seconds to redirect to the landing page</h3>
    </div>
<!-- Fin redirecciones -->
</body>
</html>
