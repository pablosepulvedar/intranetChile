<?php
require 'conexion.php';
session_start();

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$query = "SELECT * FROM usuarios WHERE idusuario = '$usuario' AND password = '$password'"; /* el % se usa para seleccionar todos los elementos que se le parezcan */
$resultado = mysqli_query($conexion, $query);
if (!$resultado) {
    die('Query Error'.mysqli_error($conexion));
}
//$array = mysqli_fetch_array($resultado);
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
}
?>