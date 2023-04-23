<?php 
$configura = $_SESSION['config'];
if ($configura) {
    require 'conexion.php';
    $query = "SELECT u.nombre, sum(c.cantidadvuelos) AS totalvuelos FROM containstructores c JOIN usuarios u ON u.idusuario = c.idinstructor WHERE u.idusuario = '$usuario'";
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
            <?php if ($_SESSION['perfil'] == 'instructor') { ?>
                <p>Cantidad de vuelos este año: <?= $row['totalvuelos'] ?></p>
                <h2>Detalles</h2>
                <select name="periodo" id="periodo"></select>
                <table>
                    <tr>
                        <td>
                            <input type="button" value="&larr;" onclick="cambiarFecha(0,'fechaconfig')">
                            <label for="fechaconfig">Fecha</label>
                            <input type="button" value="&rarr;" onclick="cambiarFecha(1,'fechaconfig')">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="date" name="fechaconfig" id="fechaconfig">
                            <input type="button" onclick="cargarReservas()" value="Buscar">
                        </td>
                    </tr>
                </table>
            <?php } ?>
        </div>
    <?php } ?>
</body>
</html>