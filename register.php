<?php
//Tomas Bragan
//contacto:
//fecha creaciçón
//versión
//Pagina de registo para usuario nuevos

// Incluir el archivo config.php
require_once "config.php";
 
// Definir variables e inicializar con valores vacíos
//vacio para login
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Procesamiento de datos del formulario cuando se envía el formulario
// formulario de registro usuario
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validar nombre de usuario
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese un usuario.";
    } else{
        // Ejecuta la orden SELECT
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Vincular variables a la declaración
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Configura parámetros
            $param_username = trim($_POST["username"]);
            
            // Intenta ejecutar la instrucción preparada
            if(mysqli_stmt_execute($stmt)){
                /* Almacena el resultado */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Este usuario ya fue registrado. Loguéate.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Al parecer algo salió mal. Oops";
            }
        }
         
        // Cierra la declaración
        mysqli_stmt_close($stmt);
    }
    
    // Valida la contraseña
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor ingresa una contraseña.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "La contraseña al menos debe tener 6 caracteres.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Valida la confirmación de la contraseña
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Confirma tu contraseña.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "No coincide la contraseña.";
        }
    }
    
    // Verifica los errores de entrada antes de insertar en la base de datos
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Ejecuta la orden INSERT INTO en la tabla de users
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Vincular variables a la declaración
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Configura los parámetros
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Intenta ejecutar la declaración
            if(mysqli_stmt_execute($stmt)){
                // Redirige a la páginan login.php
                header("location: login.php");
            } else{
                echo "Algo salió mal, por favor inténtalo de nuevo.";
            }
        }
         
        // Cierra declaración
        mysqli_stmt_close($stmt);
    }
    
    // Cierra o desconecta la sesión
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<head>
    <title>Registro</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body style="font: 14px sans-serif; background-image: url(/assets/images/marble_wall.jpg); ")><center>
    <center>
    <div class="wrapper" style="width: 350px; padding: 20px;">
<!-- FORMULARIO -->
        <a href="//proyecto.rf.gd"><img src="assets/images/thplogo.png" style="width: 25%; height: auto;"></a>
        <h2 style="color: white;">Registro</h2>
        <p style="color: white;">Por favor complete este formulario para crear una cuenta.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label style="color: white;">Usuario</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label style="color: white;">Contraseña</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label style="color: white;">Confirmar Contraseña</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Ingresar">
                <input type="reset" class="btn btn-default" value="Borrar">
            </div>
            <p style="color: white;">¿Ya tienes una cuenta? <a href="login.php" style="color: cyan;">Ingresa aquí</a>.</p>
        </form>
    </div>
    </center>  
</body>
</html>
