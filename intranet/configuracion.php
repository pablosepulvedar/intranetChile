<?php 
$configura = $_SESSION['config'];
if ($configura) {
    require 'conexion.php';
    $query = "SELECT * FROM usuarios WHERE idusuario = '$usuario'";
    $resultado = mysqli_query($conexion, $query);
    $row = mysqli_fetch_array($resultado);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Reserva</title>
</head>
<body>
    <?php if ($configura) { ?>
        <div id="divconfig" style="display: none;" >
            <h1>Configuración</h1>
            <p>Configuraciones de <?= $row['nombre'] ?></p>
        </div>
    <?php } ?>
</body>
</html>