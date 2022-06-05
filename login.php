<?php
// Inicializa la sesión
session_start();
 
// Compruebe si el usuario ya ha iniciado sesión; si es así, redirige a la página de bienvenida
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
// CAMBIAR LA RUTA LOCALIZACIÓN DE BIENVENIDA O QUE QUERAMOS REDIRIGIR UNA VEZ INICIADA SESIÓN //  
  header("location: welcome.php");
  exit;
}
// Incluir el archivo config.php
require_once "config.php";
// Definir variables e inicializar con valores vacios
$username = $password = "";
$username_err = $password_err = "";
// Procesar los datos del formulario al inicializar
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Comrpueba si el usuario está vacio
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese su usuario.";
    } else{
        $username = trim($_POST["username"]);
    }
    // Comrpueba si la contraseña está vacia
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor ingrese su contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }
    // Validar credenciales
    if(empty($username_err) && empty($password_err)){
        // Ejecutar el comando SELECT de la tabla users
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Vincular variables a la declaración preparada como parámetros
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Configurar parámetros
            $param_username = $username;
            
            // Intentar ejecutar la declaración preparada
            if(mysqli_stmt_execute($stmt)){
                // Guarda el resultado
                mysqli_stmt_store_result($stmt);
                
                // Comprueba que el usuario existe, si es así, comprueba la contraseña
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // La contraseña es correcta, así que inicializa sesión
                            session_start();
                            
                            // Almacena los datos de usuarios
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirige a la página de bienvenida
                            header("location: welcome.php");
                        } else{
                            // Muestra mensaje de contraseña incorrecta o inválida
                            $password_err = "La contraseña que has ingresado no es válida.";
                        }
                    }
                } else{
                    // Muestra mensaje de error si el usuario es incorrecto o inexistente
                    $username_err = "No existe cuenta registrada con ese nombre de usuario.";
                }
            } else{
                echo "Algo salió mal, por favor vuelve a intentarlo.";
            }
        }
        
        // Cierra la declaración
        mysqli_stmt_close($stmt);
    }
    
    // Cierra la conexión o sesión
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login THP Electronic Markets</title>
<!-- HOJA DE ESTILOS BOOTSTRAP -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body style="font: 14px sans-serif; background-image: url(/assets/images/marble_wall.jpg); ")><center>
    <div class="wrapper" style="width: 350px; padding: 20px;">
        <!-- Formulario-->
        <a href="//proyecto.rf.gd"><img src="assets/images/thplogo.png" style="width: 25%; height: auto;"></a>
        <h1 style="text-transform: uppercase; font-weight: 500; color: white;">Login</h1>
        <p style="color: white;">Rellena los campos para iniciar sesión.</p>
        <form action="login.php" method="post">
            <div class="form-group ">
                <label style="color: white;">Usuario</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label style="color: white;">Contraseña</label>
                    <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p style="color: white;">¿No tienes una cuenta? <a href="register.php" style="color: cyan;">Regístrate ahora</a>.</p>
        </form>
    </div>
    </center>    
</body>
</html>
