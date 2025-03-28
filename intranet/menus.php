<?php
$inicio         = true;//$_SESSION['inicio'];
$insreserva     = true;//$_SESSION['insreserva'];
$confirmreserva = true;//$_SESSION['confirmreserva'];
$config         = true;//$_SESSION['config'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menus</title>
</head>
<body>
    <table class="table table-dark">
        <tbody>
            <tr>
                <?php if ($inicio) { ?>
                <td>
                    <input type="button" value="Reservas" onclick="irmenu('reservas')">
                </td>
                <?php } 
                 if ($confirmreserva) { ?>
                <td>
                    <input type="button" value="Validar Reserva" onclick="irmenu('validar')">
                </td>
                <?php } 
                if ($config) { ?>
                <td>
                    <input type="button" value="Configuración" onclick="irmenu('config')">
                </td>
                <?php } ?>
            </tr>
        </tbody>
    </table>
</body>
</html>