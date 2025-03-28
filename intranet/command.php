<?php
require 'conexion.php';
session_start();
$usuariosesion = $_SESSION['usuario'];
$cmd = $_REQUEST['cmd'];

switch ($cmd) {
    case 'reservas':
        $fecha = pg_escape_string($_REQUEST['fecha']);
        //$query = "SELECT r.idreserva, v.valor AS hora, r.nombre, r.cantidad, r.total, r.abono, r.usuario, r.observaciones, r.valida, r.telefono, vv.valor AS tipovuelo 
        //FROM reservas r
        //JOIN valores v ON r.idhora = v.idvalor
        //JOIN valores vv ON r.tipovuelo = vv.idvalor
        //WHERE fecha = '$fecha' AND eliminado <> 1 ORDER BY hora ASC";
        $query = "SELECT * FROM reservas ";
        $resultado = pg_query($conn, $query);
        if (!$resultado) {
            die('Query Error: ' . pg_last_error($conn));
        }
        $json = array();
        while ($row = pg_fetch_assoc($resultado)) {
            //$row['telefono'] = ($_SESSION['wathsapp'] == false && $_SESSION['usuario'] != $row['usuario']) ? '' : $row['telefono'];
            $json[] = $row;
        }
        echo json_encode($json);
        break;
    /*case 'comprobarpermisos':
        $idusuario = $_REQUEST['idusuario'];
        $query = "SELECT permisos FROM usuarios WHERE idusuario = '$idusuario'";
        $resultado = mysqli_query($conexion, $query);
        if (!$resultado) {
            die('Query Error'.mysqli_error($conexion));
        }
        $json = array();
        while ($row = mysqli_fetch_array($resultado)) {
            $json[] = array(
                'permisos' => $row['permisos']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
        break;
    */
    case 'horarios':
        $query = "SELECT * FROM valorescombobox WHERE tipo = 'horario' ORDER BY orden ASC";
        $resultado = pg_query($conn, $query); // Usamos pg_query para PostgreSQL
        if (!$resultado) {
            die('Query Error: ' . pg_last_error($conn)); // Manejo de errores para PostgreSQL
        }
        $json = array();
        while ($row = pg_fetch_assoc($resultado)) { // Usamos pg_fetch_assoc para obtener los resultados como un array asociativo
            $json[] = array(
                'idvalor' => $row['id'],
                'valor' => $row['valor']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    break;
    /*
    case 'insertarReserva':
        $idreserva      = $_REQUEST['idreserva'];
        $valorUni       = $_REQUEST['valorUni'];
        $valorDuo       = $_REQUEST['valorDuo'];
        $checkAlma      = $_REQUEST['checkAlma'] == 'true' ? 1 : 0;
        $nombre         = $_REQUEST['nombre'];
        $cantidad       = $_REQUEST['cantidad'];
        $idHora         = $_REQUEST['idHora'];
        $fecha          = $_REQUEST['fecha'];
        $total          = $_REQUEST['total'];
        $abono          = $_REQUEST['abono'];
        $adeudado       = $_REQUEST['adeudado'];
        $observaciones  = $_REQUEST['observaciones'];
        $usuario        = $_REQUEST['usuario'];
        $telefono       = $_REQUEST['telefono'];
        $email          = $_REQUEST['email'];
        $tipovuelo      = $_REQUEST['tipovuelo'];
        if ($idHora == '' || $idHora == 0) {
            die('Error con Horario');
        }
        if ($idreserva == 0) {
            $query = 'INSERT INTO `reservas`(`valorunitario`,`valorpareja`,`vueloalma`,`idhora`,`nombre`,`cantidad`,`total`,`abono`,`adeudado`,`usuario`,`fecha`,`observaciones`,`telefono`,`email`,`tipovuelo`) VALUES ('.$valorUni.','.$valorDuo.','.$checkAlma.','.$idHora.',\''.$nombre.'\','.$cantidad.','.$total.','.$abono.','.$adeudado.',\''.$usuario.'\',\''.$fecha.'\',\''.$observaciones.'\',\''.$telefono.'\',\''.$email.'\',\''.$tipovuelo.'\')';
        } else {
            $query = 'UPDATE `reservas` SET `valorunitario`='.$valorUni.',`valorpareja`='.$valorDuo.',`vueloalma`='.$checkAlma.',`idhora`='.$idHora.',`nombre`=\''.$nombre.'\',`cantidad`='.$cantidad.',`total`='.$total.',`abono`='.$abono.',`usuario`=\''.$usuario.'\',`fecha`=\''.$fecha.'\',`observaciones`=\''.$observaciones.'\',`telefono`=\''.$telefono.'\',`email`=\''.$email.'\',`tipovuelo`=\''.$tipovuelo.'\' WHERE idreserva = '.$idreserva.'';
        }
        $resultado = mysqli_query($conexion, $query);
        if (!$resultado) {
            die('Query Error'.mysqli_error($conexion));
        }else{
            if ($idreserva == 0) {
                echo 'ins ok';
            }else {
                echo 'mod ok';
            } 
        }
        break;
    case 'traerReserva':
        $idreserva = $_REQUEST['idreserva'];
        $query = 'SELECT * FROM reservas WHERE idreserva = '.$idreserva.'';
        $resultado = mysqli_query($conexion, $query);
        if (!$resultado) {
            die('Query Error'.mysqli_error($conexion));
        }
        $json = array();
        while ($row = mysqli_fetch_array($resultado)) {
            $json[] = array(
                'idreserva'     => $row['idreserva'],
                'valoruni'      => $row['valorunitario'],
                'valorduo'      => $row['valorpareja'],
                'vueloalma'     => $row['vueloalma'],
                'idhora'        => $row['idhora'],
                'nombre'        => $row['nombre'],
                'cantidad'      => $row['cantidad'],
                'total'         => $row['total'],
                'abono'         => $row['abono'],
                'adeudado'      => $row['adeudado'],
                'usuario'       => $row['usuario'],
                'fecha'         => $row['fecha'],
                'observaciones' => $row['observaciones'],
                'telefono'      => $row['telefono'],
                'email'         => $row['email'],
                'tipovuelo'     => $row['tipovuelo']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
        break;
    case 'eliminar':
        $idreserva = $_REQUEST['idreserva'];
        $query = "UPDATE reservas SET eliminado=1, fechaelimina = now() WHERE idreserva = ".$idreserva."";
        $resultado = mysqli_query($conexion, $query);
        if (!$resultado) {
            die('Query Error'.mysqli_error($conexion));
        }
        echo 'ok';
        break;
case 'confirm':
        $query = "SELECT r.idreserva, v.valor AS hora, r.nombre, r.cantidad, r.total, r.abono, r.usuario, r.observaciones, r.valida FROM reservas r
                    JOIN valores v 
                    ON r.idhora = v.idvalor
                    WHERE r.valida = 1 AND eliminado <> 1"; /* el % se usa para seleccionar todos los elementos que se le parezcan */
/*        $resultado = mysqli_query($conexion, $query);
        if (!$resultado) {
            die('Query Error'.mysqli_error($conexion));
        }
        $json = array();
        while ($row = mysqli_fetch_array($resultado)) {
            $json[] = array(
                'idreserva'     => $row['idreserva'],
                'hora'          => $row['hora'],
                'nombre'        => $row['nombre'],
                'cantidad'      => $row['cantidad'],
                'total'         => $row['total'],
                'abono'         => $row['abono'],
                'usuario'       => $row['usuario'],
                'observaciones' => $row['observaciones'],
                'valida'        => $row['valida']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
        break;*/
    case 'tipovuelos':
        $query = "SELECT * FROM valorescombobox WHERE tipo = 'tipo_vuelo' ORDER BY orden ASC";
        $resultado = pg_query($conn, $query); // Usamos pg_query para PostgreSQL
        if (!$resultado) {
            die('Query Error: ' . pg_last_error($conn)); // Manejo de errores para PostgreSQL
        }
        $json = array();
        while ($row = pg_fetch_assoc($resultado)) { // Usamos pg_fetch_assoc para obtener los resultados como un array asociativo
            $json[] = array(
                'idvalor' => $row['id'], // Cambié 'idvalor' por 'id' ya que eso es lo que devuelve el query
                'valor' => $row['valor']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    break;
    /*case 'validar':
        $idreserva = $_REQUEST['idreserva'];
        if ($usuariosesion == 'psepulveda') {
            $query = "UPDATE reservas SET valida=1 WHERE idreserva = ".$idreserva."";
            $resultado = mysqli_query($conexion, $query);
            if (!$resultado) {
                //die('Query Error'.mysqli_error($conexion));
                $msj = 'error';
            } else {
                $msj = 'Validada con Exito';
            }  
        } else {
            $msj = 'Usted no puede ajecutar esta acción';
        }
        echo $msj;
        break;
    case 'cargarperiodo':
        $query = "SELECT DATE_FORMAT(fecha, '%m-%Y') AS periodo , DATE_FORMAT(fecha, '%Y-%m') AS periodovalue FROM containstructores WHERE idinstructor = '".$_SESSION['usuario']."' GROUP BY periodo ORDER BY fecha DESC";
            $resultado = mysqli_query($conexion, $query);

            if (!$resultado) {
                die('Query Error'.mysqli_error($conexion));
            }
            $json = array();
            while ($row = mysqli_fetch_array($resultado)) {
                $json[] = array(
                    'periodo'     => $row['periodo'],
                    'periodovalue'=> $row['periodovalue']
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        break;
    case 'reginstructores':
        $periodo = $_REQUEST['periodo'];
        $query = "SELECT DATE_FORMAT(fecha, '%d-%m-%Y') AS fecha, cantidadvuelos FROM containstructores WHERE idinstructor = '".$_SESSION['usuario']."' AND fecha LIKE '%".$periodo."%' ORDER BY fecha ASC ";
        $resultado = mysqli_query($conexion, $query);

        if (!$resultado) {
            die('Query Error'.mysqli_error($conexion));
        }
        $json = array();
        while ($row = mysqli_fetch_array($resultado)) {
            $json[] = array(
                'fecha'         => $row['fecha'],
                'cantidadvuelos'=> $row['cantidadvuelos']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
        break;
    case 'cambioClave':
        $pass = $_REQUEST['pass'];
        $nuevapass = $_REQUEST['nuevapass'];
        $confirmpass = $_REQUEST['confirmpass'];
        $pass = md5($pass.'@chileparapente');

        $query = "SELECT * FROM usuarios WHERE idusuario = '$usuariosesion' AND password = '$pass'"; /* el % se usa para seleccionar todos los elementos que se le parezcan */
/*        $resultado = mysqli_query($conexion, $query);
        if (!$resultado) {
            die('Query Error'.mysqli_error($conexion));
        }

        if (mysqli_num_rows($resultado) > 0) {
            $nuevapass = md5($nuevapass.'@chileparapente');
            $query = "UPDATE usuarios SET password='$nuevapass' WHERE idusuario = '$usuariosesion' AND password = '$pass'";
            $resultado = mysqli_query($conexion, $query);
            if (!$resultado) {
                die('Query Error'.mysqli_error($conexion));
            }
            die('Cambio de contraseña exitoso');
        } else {
            die('Contraseña Incorrecta');
        }
        break;*/
    default:
        echo 'Codigo no registrado';
        break;
}
