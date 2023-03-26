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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Reserva</title>
</head>
<body>
    <div id="editReservas" style="display: none;">
        <input type="button" value="Volver" onclick="volver()"> 
        <p> Formulario de edicion de reservas</p>
        <input type="hidden" id="idreserva" value='0'>
        <table>
            <tr>
                <td>
                    <label for="valorUni">Valor Unitario</label>
                    <input type="text" id="valorUni" value='50000' disabled style="width: 90px;text-align:end;">
                </td>
                <td>
                    <label for="valorDuo">Valor por Pareja</label>
                    <input type="text" id="valorDuo" value='95000' disabled style="width: 90px;text-align:end;">
                </td>
                <td>
                    <input type="button" id="btnValores" value="Modificar Valores" onclick="modificarValores()">
                </td>
                <td>
                    <label for="alma">Vuelo del Alma</label>
                    <input type="checkbox" id="alma" onchange="cambioChekAlma(this)">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="nombre">Nombre*</label>
                </td>
                <td>
                    <label for="cantidad">Cantidad*</label>
                </td>
                <td>
                    <label for="hora">Hora</label>
                </td>
                <td>
                    <label for="fechaForm">Fecha*</label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" id="nombre" style="width: 95%;">
                </td>
                <td>
                    <input type="number" id="cantidad" onchange="calcularValores()" style="width: 95%;">
                </td>
                <td>
                    <select id="hora" style="width: 120px;"></select>
                </td>
                <td>
                    <input type="date" id="fechaForm" style="width: 95%;">
                </td>
            </tr>
            <tr>
            <td>
                    <label for="total">Total</label>
                </td>
                <td>
                    <label for="abono">Abono</label>
                </td>
                <td>
                    <label for="adeudado">Adeudado</label>
                </td>
                <?php if ($usuario == 'psepulveda') { ?>   
                <td>
                    <input type="button" id="cambiarUsuario" value="Cambiar Usuario" onclick="cambiarUsuari()">
                </td>
                <?php } ?>
            </tr>
            <tr>
                <td>
                    <input type="text" id="total" onchange="calcularValores()" style="width: 95%;">
                </td>
                <td>
                    <input type="text" id="abono" onchange="calcularValores()" style="width: 95%;">
                </td>
                <td>
                    <input type="text" id="adeudado" disabled style="width: 113px;">
                </td>
                <td>
                    <input type="text" id="idusuarioinsert" disabled <?=$estilo?>>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="telefono">Telefono*</label>
                </td>
                <td>
                    <label for="email">Email</label>
                </td>       
            </tr>
            <tr>
                <td>
                    <input type="text" id="telefono" placeholder="+56945117793">
                </td>
                <td>
                    <input type="text" id="email" placeholder="correo@dominio.com">
                </td>       
            </tr>
            <tr>
                <td colspan="4">
                    <label for="observacion">Observaciones</label>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <textarea id="observaciones" cols="30" rows="10" style="width: 100%;"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;">
                    <input type="button" id="btnReserva" value="Modificar" onclick="insertarReserva()">
                </td>
            </tr>
        </table>
    </div>
</body>
</html>