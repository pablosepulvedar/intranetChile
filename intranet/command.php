<?php
    include('conexion.php');
$cmd = $_REQUEST['cmd'];
switch ($cmd) {
    case 'reservas':
        $fecha = $_REQUEST['fecha'];
        $query = "SELECT r.idreserva, v.valor AS hora, r.nombre, r.cantidad, r.total, r.abono, r.usuario, r.observaciones, r.valida FROM reservas r
        JOIN valores v 
        ON r.idhora = v.idvalor
        WHERE fecha = '$fecha' AND eliminado <> 1 ORDER BY hora ASC"; /* el % se usa para seleccionar todos los elementos que se le parezcan */
        $resultado = mysqli_query($conexion, $query);
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
        break;
    case 'comprobarpermisos':
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
    case 'horarios':
        $query = "SELECT * FROM valores WHERE tipo = 'horario' ORDER BY orden ASC";
        $resultado = mysqli_query($conexion, $query);
        if (!$resultado) {
            die('Query Error'.mysqli_error($conexion));
        }
        $json = array();
        while ($row = mysqli_fetch_array($resultado)) {
            $json[] = array(
                'idvalor' => $row['idvalor'],
                'valor' => $row['valor']
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
        break;
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
        if ($idreserva == 0) {
            $query = 'INSERT INTO `reservas`(`valorunitario`,`valorpareja`,`vueloalma`,`idhora`,`nombre`,`cantidad`,`total`,`abono`,`adeudado`,`usuario`,`fecha`,`observaciones`,`telefono`,`email`) VALUES ('.$valorUni.','.$valorDuo.','.$checkAlma.','.$idHora.',\''.$nombre.'\','.$cantidad.','.$total.','.$abono.','.$adeudado.',\''.$usuario.'\',\''.$fecha.'\',\''.$observaciones.'\',\''.$telefono.'\',\''.$email.'\')';
        } else {
            $query = 'UPDATE `reservas` SET `valorunitario`='.$valorUni.',`valorpareja`='.$valorDuo.',`vueloalma`='.$checkAlma.',`idhora`='.$idHora.',`nombre`=\''.$nombre.'\',`cantidad`='.$cantidad.',`total`='.$total.',`abono`='.$abono.',`usuario`=\''.$usuario.'\',`fecha`=\''.$fecha.'\',`observaciones`=\''.$observaciones.'\',`telefono`=\''.$telefono.'\',`email`=\''.$email.'\' WHERE idreserva = '.$idreserva.'';
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
                'email'         => $row['email']
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
        $resultado = mysqli_query($conexion, $query);
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
        break;
    default:
        echo 'Codigo no registrado';
        break;
}

