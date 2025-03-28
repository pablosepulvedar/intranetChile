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
            <h1>Interfaz de Validar</h1>
        </div>
    <?php } ?>
</body>
</html>