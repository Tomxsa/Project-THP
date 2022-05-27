<?php
/* Variables para la conexión a PHPMyAdmin de InfinityFree */
define('DB_SERVER', 'sql309.epizy.com');
define('DB_USERNAME', 'epiz_31410522');
define('DB_PASSWORD', 'yAQtGmMjrNLx');
define('DB_NAME', 'epiz_31410522_proyecto');
/* Cambiar la variable "DB_Name" si fuera necesario por tu nombre de DB*/
 
/* Accede a la bases de datos de PHPMyAdmin seleccionado. Si no, devuelve error */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
