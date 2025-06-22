<?php
require 'conexion.php';  // Asegúrate de tener la conexión a PostgreSQL en este archivo
session_start();
$usuario = $_POST['username'];
$password = $_POST['password'];
$empresa =$_POST['empresa'];
$_SESSION['empresa'] = $empresa;
//$password = md5($_POST['password'].'@chileparapente');

// Realizar la consulta con pg_query_params para prevenir inyecciones SQL
$query = "SELECT u.id
            FROM usuarios u
            JOIN empresas e ON u.idempresa = e.id
        WHERE u.usuario = $1
        AND u.contraseña = $2
        AND e.nombreempresa = $3";
$resultado = pg_query_params($conn, $query, array($usuario, $password, $empresa));

// Verificar si la consulta devolvió algún resultado
if (!$resultado) {
    die('Query Error: ' . pg_last_error($conn));  // Usar pg_last_error() para PostgreSQL
}
// Verificar si el usuario existe
if (pg_num_rows($resultado) > 0) {
    $row = pg_fetch_assoc($resultado);
    $idusuario = $row['id'];
    // Si el usuario existe, puedes iniciar sesión
    $_SESSION['usuario'] = $usuario;
    //Leer y asignar los permisos
    $sql = "
        SELECT * FROM permisos 
        WHERE idusuario = $1
    ";
    $resultado = pg_query_params($conn, $sql, array($idusuario));

    $json = array();
    $row = pg_fetch_assoc($resultado);
    $_SESSION['modusuario'] = $row['modusuario'];
    $_SESSION['valreserva'] = $row['valreserva'];
    $_SESSION['verwathsapp'] = $row['verwathsapp'];
    $_SESSION['modreserva'] = $row['modreserva'];
    $_SESSION['ingreserva'] = $row['ingreserva'];
    $_SESSION['ingusuario'] = $row['ingusuario'];
    $_SESSION['hojadiaria'] = $row['hojadiaria'];
    $_SESSION['cerrardia'] = $row['cerrardia'];
    $_SESSION['listausuario'] = $row['listausuario'];
    // Redirigir al usuario a una página protegida (por ejemplo, dashboard.php)
    header('location: reservas.php');
    exit();
} else {
    header('location: ../intranet.php?error=true');
    // Si no existe, mostrar un mensaje de error
    //echo "Usuario o contraseña incorrectos.";
}
?>