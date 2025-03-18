<?php
$error = '';
if (!empty($_REQUEST['error'])) {
    $error = '<div style="text-align: center;">El usuario o Contraseña son incorrectos</div>';
}
require_once("intranet/inicio.php");
?>