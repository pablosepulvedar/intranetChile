<?php
$inicio         = $_SESSION['inicio'];
$insreserva     = $_SESSION['insreserva'];
$confirmreserva = $_SESSION['confirmreserva'];
$config         = $_SESSION['config'];
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
                    <input type="button" value="Reservas" onclick="irmenureservas()">
                </td>
                <?php } 
                 if ($confirmreserva) { ?>
                <td>
                    <input type="button" value="Validar Reserva" onclick="irmenuvalidar()">
                </td>
                <?php } 
                if ($config) { ?>
                <td>
                    <input type="button" value="Configuración">
                </td>
                <?php } ?>
            </tr>
        </tbody>
    </table>
</body>
</html>