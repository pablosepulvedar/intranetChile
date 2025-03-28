<?php
require 'conexion.php';
$usuario = $_SESSION['usuario'];
if($usuario == 'psepulveda'){
    $estilo = 'style="display: block;"';
}else{
    $estilo = 'style="display: none;"'; 
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Reserva</title>
 
</head>
<body>
    <div id="editReservas" class="form-container">
        <input type="button" class="btn-back" value="Volver" onclick="volver()"> 
        <h2>Formulario de Edición de Reservas</h2>
        <input type="hidden" id="idreserva" value='0'>
        
        <form id="formReserva">
            <table class="form-table">
                <tr>
                    <td><label for="valorUni">Valor Unitario</label></td>
                    <td><label for="valorDuo">Valor por Pareja</label></td>
                    <td><input type="button" id="btnValores" class="btn-modificar" value="Modificar Valores" onclick="modificarValores()"></td>
                    <td><label for="tipovuelo">Tipo:</label></td>
                </tr>
                <tr>
                    <td><input type="text" id="valorUni" value='50000' disabled class="input-text"></td>
                    <td><input type="text" id="valorDuo" value='95000' disabled class="input-text"></td>
                    <td><select name="tipovuelo" id="tipovuelo" class="input-select" onchange="cambioTipoVuelo(this)"></select></td>
                </tr>
                <tr>
                    <td><label for="nombre">Nombre*</label></td>
                    <td><label for="cantidad">Cantidad*</label></td>
                    <td><label for="hora">Hora</label></td>
                    <td><label for="fechaForm">Fecha*</label></td>
                </tr>
                <tr>
                    <td><input type="text" id="nombre" class="input-text"></td>
                    <td><input type="number" id="cantidad" onchange="calcularValores()" class="input-text"></td>
                    <td><select id="hora" class="input-select"></select></td>
                    <td><input type="date" id="fechaForm" class="input-text"></td>
                </tr>
                <tr>
                    <td><label for="total">Total</label></td>
                    <td><label for="abono">Abono</label></td>
                    <td><label for="adeudado">Adeudado</label></td>
                    <?php if ($usuario == 'psepulveda') { ?>   
                    <td><input type="button" id="cambiarUsuario" class="btn-modificar" value="Cambiar Usuario" onclick="cambiarUsuari()"></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td><input type="text" id="total" onchange="calcularValores()" class="input-text"></td>
                    <td><input type="text" id="abono" onchange="calcularValores()" class="input-text"></td>
                    <td><input type="text" id="adeudado" disabled class="input-text"></td>
                    <td><input type="text" id="idusuarioinsert" disabled <?=$estilo?> class="input-text"></td>
                </tr>
                <tr>
                    <td><label for="telefono">Telefono*</label></td>
                    <td><label for="email">Email</label></td>       
                </tr>
                <tr>
                    <td><input type="text" id="telefono" class="input-text" placeholder="+56945117793"></td>
                    <td><input type="text" id="email" class="input-text" placeholder="correo@dominio.com"></td>       
                </tr>
                <tr>
                    <td colspan="4"><label for="observacion">Observaciones</label></td>
                </tr>
                <tr>
                    <td colspan="4"><textarea id="observaciones" class="input-textarea"></textarea></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center;">
                        <input type="button" id="btnReserva" class="btn-submit" value="Modificar" onclick="insertarReserva()">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>