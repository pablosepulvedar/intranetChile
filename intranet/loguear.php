<?php
require 'conexion.php';  // Asegúrate de tener la conexión a PostgreSQL en este archivo
session_start();

$empresa = $_POST['empresa'];
$usuario = $_POST['username'];
$password = $_POST['password'];
//$password = md5($_POST['password'].'@chileparapente');

// Realizar la consulta con pg_query_params para prevenir inyecciones SQL
$query = "SELECT * FROM usuarios WHERE usuario = $1 AND contraseña = $2";
$resultado = pg_query_params($conn, $query, array($usuario, $password));

// Verificar si la consulta devolvió algún resultado
if (!$resultado) {
    die('Query Error: ' . pg_last_error($conn));  // Usar pg_last_error() para PostgreSQL
}

// Verificar si el usuario existe
if (pg_num_rows($resultado) > 0) {
    // Si el usuario existe, puedes iniciar sesión
    $_SESSION['usuario'] = $usuario;
    // Redirigir al usuario a una página protegida (por ejemplo, dashboard.php)
    header('location: reservas.php');
    exit();
} else {
    header('location: ../intranet.php?error=true');
    // Si no existe, mostrar un mensaje de error
    //echo "Usuario o contraseña incorrectos.";
}/*
if (mysqli_num_rows($resultado) > 0) {
    while ($row = mysqli_fetch_array($resultado)) {
        $_SESSION['usuario'] = $row['idusuario'];
        $_SESSION['permiso1'] = false;
        $_SESSION['permiso2'] = false;
        $_SESSION['wathsapp'] = false;
        $_SESSION['inicio'] = false;
        $_SESSION['insreserva'] = false;
        $_SESSION['confirmreserva'] = false;
        $_SESSION['config'] = false;
        $_SESSION['perfil'] = $row['perfil'];
        $permisos = explode(',' , $row['permisos']);
        for ($i=0; $i < count($permisos); $i++) {
            switch ($permisos[$i]) {
                case 'permiso1':
                    $_SESSION['permiso1'] = true;
                    break;
                case 'permiso2':
                    $_SESSION['permiso2'] = true;
                    break;
                case 'wathsapp':
                    $_SESSION['wathsapp'] = true;
                    break;
                default:
                    break;
            } 
        }
        $menus = explode(',' , $row['menus']);
        for ($i=0; $i < count($menus); $i++) {
            switch ($menus[$i]) {
                case 'inicio':
                    $_SESSION['inicio'] = true;
                    break;
                case 'insreserva':
                    $_SESSION['insreserva'] = true;
                    break;
                case 'confirmreserva':
                    $_SESSION['confirmreserva'] = true;
                    break;
                case 'config':
                    $_SESSION['config'] = true;
                    break;
                default:
                    break;
            } 
        }
    }
    header('location: reservas.php');
} else {
    header('location: ../intranet.php?error=true');
}*/
?>