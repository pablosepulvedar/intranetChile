<?php 
$configura = $_SESSION['config'];
if ($configura) {
    require 'conexion.php';
    $query = "SELECT u.nombre, sum(c.cantidadvuelos) AS totalvuelos FROM containstructores c JOIN usuarios u ON u.idusuario = c.idinstructor WHERE u.idusuario = '$usuario'";
    $resultado = mysqli_query($conexion, $query);
    $row = mysqli_fetch_array($resultado);
    $canttotal = $row['totalvuelos'];
    $minutos = $canttotal*15;
    $horas = intval(($minutos/60));
    $minutos = ($minutos/60-$horas)*60;
    if ($minutos < 10) {
        $minutos = '0'.$minutos;
    }

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
            <?php if ($_SESSION['perfil'] == 'instructor') { ?>
                <p>Cantidad de vuelos este año: <?= $canttotal ?> &rarr; $<?= $canttotal*20000 ?></p>
                <p>Cantidad Horas (Aprox 15 min por vuelos): &rarr; <?= $horas.' Horas '.$minutos.' Minutos' ?></p>
                <h2>Detalles</h2>
                <select name="periodo" id="periodo" onchange="cargarRegInstructores()"></select>
                <div id="tablaRegInstructores" style="text-align: center;"></div>
            <?php } ?>
        </div>
    <?php } ?>
</body>
</html>