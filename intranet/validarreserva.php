<?php 
$confirmreserva = true;//$_SESSION['confirmreserva'];
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
    <?php if ($confirmreserva) { ?>
        <div id="divvalidar" style="display: none;" >
            <div id="cabecera">
                <table>
                    <tr>
                        <td class="titulo">
                            <h1>Validación de Reservas</h1>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="tablaReservasNoValidas" style="text-align: center;"></div>
        </div>
    <?php } ?>
</body>
</html>