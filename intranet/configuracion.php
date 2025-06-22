<?php 
var_dump($_SESSION['listausuario']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
</head>
<body>
        <div id="divconfig" style="display: none;" >
            <div id="cabecera">
                <table>
                    <tr>
                        <td colspan="2" class="titulo">
                            <h1>Configuración</h1>
                        </td>
                    </tr>
                    <tr>
                        <td>                    
                            <input type="button" value="Datos Usuario">
                            <input type="button" value="Bitacora">
                            <?php if ($_SESSION['listausuario'] == 't') { ?>
                                <input type="button" value="Usuarios"> 
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="contenedorConfiguraciones">
                <div id="datosUsiario">
                    <table>
                        <tr>
                            <td>
                                Nombre 
                            </td>
                            <td>
                                Apellido
                            </td>
                            <td>
                                email
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="input-select" id="nombreusuario" disabled>
                            </td>
                            <td>
                                <input type="text" class="input-select" id="apellidousuario" disabled>
                            </td>
                            <td>
                                <input type="text" class="input-select" id="email" disabled>
                            </td>
                        </tr>
                                                <tr>
                            <td>
                                Contraseña 
                            </td>
                            <td>
                                Nueva Contraseña
                            </td>
                            <td>
                                Confirmar Contraseña
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" name="" class="input-select" id="contraseñaantigua" disabled>
                            </td>
                            <td>
                                <input type="password" name="" class="input-select" id="contraseñanueva" disabled>
                            </td>
                            <td>
                                <input type="password" name="" class="input-select" id="confirmarcontraseña" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Perfil
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select name="comboPerfil" id="comboPerfil" class="input-select" disabled></select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Permisos
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" name="modusuario" id="modusuario" checked=<?=$_SESSION['modusuario']?> disabled>
                                Modificar Datos Usuario 
                            </td>
                            <td>
                                <input type="checkbox" name="valreserva" id="valreserva" checked=<?=$_SESSION['valreserva']?> disabled>
                                Validar Reservas
                            </td>
                            <td>
                                <input type="checkbox" name="verwathsapp" id="verwathsapp" checked=<?=$_SESSION['verwathsapp']?> disabled>
                                Ver wathsapp
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" name="modreserva" id="modreserva" checked=<?=$_SESSION['modreserva']?> disabled>
                                Modificar/Eliminar Reservas
                            </td>
                            <td>
                                <input type="checkbox" name="ingreserva" id="ingreserva" checked=<?=$_SESSION['ingreserva']?> disabled>
                                Ingresar Reservas 
                            </td>
                            <td>
                                <input type="checkbox" name="ingusuario" id="ingusuario" checked=<?=$_SESSION['ingusuario']?> disabled>
                                Ingresar Usuarios
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" name="hojadiaria" id="hojadiaria" checked=<?=$_SESSION['hojadiaria']?> disabled>
                                Hoja Diaria
                            </td>
                            <td>
                                <input type="checkbox" name="cerrardia" id="cerrardia" checked=<?=$_SESSION['cerrardia']?> disabled>
                                Cerrar Día
                            </td>
                            <td>
                                <input type="checkbox" name="listausuario" id="listausuario" checked=<?=$_SESSION['listausuario']?> disabled>
                                Listado Usuarios
                            </td>
                        </tr>
                        <tr>
                            <?php if ($_SESSION['listausuario'] == 't') { ?>
                                <td colspan="3" style="text-align: center;">
                                    <input type="button" value="Modificar" onclick="modificarUsuario()">
                                </td>
                            <?php } else { ?>
                                <td colspan='3' style='text-align:center; padding: 10px; background-color: #f8d7da; color: #721c24;'>No cuenta con permisos para modificar sus datos de Usuario</td>
                            <?php } ?>
                        </tr>
                    </table>
                </div>
                <div id="bitacora" style="display: none;"></div>
                <div id="nuevoUsuario" style="display: none;"></div>
            </div>
        </div>
</body>
</html>