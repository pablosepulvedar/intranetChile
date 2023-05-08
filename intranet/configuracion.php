<?php 
$configura = $_SESSION['config'];
if ($configura) {
    require 'conexion.php';
    $query = "SELECT u.nombre, sum(c.cantidadvuelos) AS totalvuelos FROM containstructores c JOIN usuarios u ON u.idusuario = c.idinstructor WHERE u.idusuario = '$usuario' AND fecha LIKE '%2023%'";
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
            <div style="background-color: yellow;">Se irá poblando los datos desde este mes a los proximos, por eso el total anual no calza hasta ahora. Paciencia por favor.</div>
            <p>Configuraciones de <?= $row['nombre'] ?></p>
            <?php if ($_SESSION['perfil'] == 'instructor') { ?>
                <p>Cantidad de vuelos este año: <?= $canttotal ?> &rarr; $<?= $canttotal*20000 ?></p>
                <p>Cantidad Horas (Aprox 15 min por vuelos): &rarr; <?= $horas.' Horas '.$minutos.' Minutos' ?></p>
                <h2>Detalles</h2>
                <select name="periodo" id="periodo" onchange="cargarRegInstructores()"></select>
                <div id="tablaRegInstructores" style="text-align: center;"></div>
            <?php } ?>
            <div id='cambioclave'>
                <h3>Cambio Contraseña</h3>
                <table>
                    <tr>
                        <td>
                            <label for="clave">Contraseña Actual:</label>
                        </td>
                        <td>
                            <label for="nuevaclave">Nueva Contraseña:</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" id="pass">
                        </td>
                        <td>
                            <input type="password" id="nuevapass">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="nuevaclave">Confirmar Nueva Contraseña:</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" id="confirmpass">
                        </td>
                        <td style="text-align: center;">
                            <input type="button" value="Cambiar" onclick="cambiarPass()">
                        </td>
                    </tr>
                </table>                
            </div>
        </div>
    <?php } ?>
</body>
</html>
