<?php
session_start();
if (empty($_SESSION['usuario'])) {
    header('location: ../intranet.php');
}
$idusuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="contenedor">
        <!-- Encabezado con sesión y enlace a logout -->
        <header>
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: end;">
                        <a href="logout.php">Cerrar Sesión</a>
                    </td>
                    <td style="text-align: end; width: 5%">
                        <p><?=$idusuario?></p>
                    </td>
                </tr>
            </table>
        </header>
        
        <?php include 'menus.php'; ?>

        <input type="hidden" id="idusuario" value="<?=$idusuario?>">

        <div id="cabecera">
            <table>
                <tr>
                    <td>
                        <input type="button" value="&larr;" onclick="cambiarFecha(0, 'fecha')">
                        <label for="fecha">Fecha</label>
                        <input type="button" value="&rarr;" onclick="cambiarFecha(1, 'fecha')">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="date" name="fecha" id="fecha">
                        <input type="button" onclick="cargarReservas()" value="Buscar">
                        <input type="button" value="Nueva Reserva" onclick="modReserva(0)">
                    </td>
                </tr>
            </table>
        </div>

        <div id="tablaReservas" style="text-align: center;"></div>

        <?php if (true) {
            include 'modreservas.php';
        } else {
            echo 'No cuenta con permisos para acceder aquí';
        }
        if (true) {
            include 'validarreserva.php';
        }
        if (true) {
            include 'configuracion.php';
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
    <script src="controlador.js?v=1.7"></script>
    <script>
        window.onload = function(){
            inicFecha('fecha')
            cargarReservas()
            cargarHorarios()
            cargarTipoVuelo()
        }
    </script>
</body>
</html>