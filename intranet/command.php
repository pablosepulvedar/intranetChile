<?php
require 'conexion.php';
session_start();
$usuariosesion = $_SESSION['usuario'];
$nombreEmpresa = $_SESSION['empresa'];
$cmd = $_REQUEST['cmd'];

switch ($cmd) {
case 'reservas':
    $fecha = $_REQUEST['fecha'];

    $sql = "
        SELECT 
            r.*, 
            vh.valor AS hora,
            vt.valor AS tipovuelo_texto,
            u.usuario AS nombre_usuario
        FROM reservas r
        LEFT JOIN valorescombobox vh 
            ON r.idhora = vh.id AND vh.tipo = 'horario'
        LEFT JOIN valorescombobox vt 
            ON r.tipovuelo = vt.id AND vt.tipo = 'tipo_vuelo'
        LEFT JOIN usuarios u
            ON r.usuario = u.id
        WHERE r.fecha = $1 AND r.eliminado != 1
        ORDER BY vh.orden NULLS LAST
    ";

    $resultado = pg_query_params($conn, $sql, array($fecha));

    if (!$resultado) {
        die('Query Error: ' . pg_last_error($conn));
    }

    $json = array();
    while ($row = pg_fetch_assoc($resultado)) {
        $json[] = $row;
    }

    echo json_encode($json);
break;
case 'reservasNoValidas':
    $fecha = $_REQUEST['fecha'];

    $sql = "
        SELECT 
            r.*, 
            vh.valor AS hora,
            vt.valor AS tipovuelo_texto,
            u.usuario AS nombre_usuario
        FROM reservas r
        LEFT JOIN valorescombobox vh 
            ON r.idhora = vh.id AND vh.tipo = 'horario'
        LEFT JOIN valorescombobox vt 
            ON r.tipovuelo = vt.id AND vt.tipo = 'tipo_vuelo'
        LEFT JOIN usuarios u
            ON r.usuario = u.id
        WHERE r.eliminado != 1 AND r.estado <> 'Valida' 
        ORDER BY vh.orden NULLS LAST
    ";

    $resultado = pg_query_params($conn, $sql, array());

    if (!$resultado) {
        die('Query Error: ' . pg_last_error($conn));
    }

    $json = array();
    while ($row = pg_fetch_assoc($resultado)) {
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
case 'llenarPerfiles':
    $query = "SELECT * FROM valorescombobox WHERE tipo = 'perfil' ORDER BY orden ASC";
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
    
case 'insertarReserva':
    $idreserva      = $_REQUEST['idreserva'];
    $valorUni       = $_REQUEST['valorUni'];
    $valorDuo       = $_REQUEST['valorDuo'];
    $checkAlma      = $_REQUEST['checkAlma'] == 'true' ? 1 : 0;
    $nombre         = pg_escape_string($_REQUEST['nombre']);
    $cantidad       = $_REQUEST['cantidad'];
    $idHora         = $_REQUEST['idHora'];
    $fecha          = $_REQUEST['fecha'];
    $total          = $_REQUEST['total'];
    $abono          = $_REQUEST['abono'];
    $adeudado       = $_REQUEST['adeudado'];
    $observaciones  = pg_escape_string($_REQUEST['observaciones']);
    $usuario        = pg_escape_string($_REQUEST['usuario']);
    $telefono       = pg_escape_string($_REQUEST['telefono']);
    $email          = pg_escape_string($_REQUEST['email']);
    $tipovuelo      = pg_escape_string($_REQUEST['tipovuelo']);

    if ($idHora == '' || $idHora == 0) {
        die('Error con Horario');
    }

    $sqlEmpresa = "SELECT id FROM empresas WHERE nombreempresa = $1";
    $resEmpresa = pg_query_params($conn, $sqlEmpresa, array($nombreEmpresa));
    if (!$resEmpresa || pg_num_rows($resEmpresa) == 0) {
        die("Empresa no encontrada");
    }
    $idempresa = pg_fetch_result($resEmpresa, 0, 'id');

    $sqlUsuario = "SELECT id FROM usuarios WHERE usuario = $1 AND idempresa = $2";
    $resUsuario = pg_query_params($conn, $sqlUsuario, array($usuario, $idempresa));
    if (!$resUsuario || pg_num_rows($resUsuario) == 0) {
        die("Usuario no encontrado para la empresa");
    }
    $idusuario = pg_fetch_result($resUsuario, 0, 'id');

    if ($idreserva == 0) {
        $query = "INSERT INTO reservas (
            valoruni, valorduo, idhora, nombre,
            cantidad, total, abono, adeudado, usuario,
            fecha, observaciones, telefono, email, tipovuelo
        ) VALUES (
            $valorUni, $valorDuo, $idHora, '$nombre',
            $cantidad, $total, $abono, $adeudado, '$idusuario',
            '$fecha', '$observaciones', '$telefono', '$email', '$tipovuelo'
        )";
    } else {
        $query = "UPDATE reservas SET
            valoruni = $valorUni,
            valorduo = $valorDuo,
            idhora = $idHora,
            nombre = '$nombre',
            cantidad = $cantidad,
            total = $total,
            abono = $abono,
            adeudado = $adeudado,
            usuario = '$idusuario',
            fecha = '$fecha',
            observaciones = '$observaciones',
            telefono = '$telefono',
            email = '$email',
            tipovuelo = '$tipovuelo'
        WHERE idreserva = $idreserva";
    }

    $resultado = pg_query($conn, $query);
    if (!$resultado) {
        die('Query Error: ' . pg_last_error($conn));
    } else {
        echo $idreserva == 0 ? 'ins ok' : 'mod ok';
    }
break;
case 'traerReserva':
    $idreserva = $_REQUEST['idreserva'];

    $sql = "
        SELECT 
            r.*, 
            u.usuario AS nombre_usuario
        FROM reservas r
        LEFT JOIN usuarios u ON r.usuario = u.id
        WHERE r.idreserva = $1
    ";
    $resultado = pg_query_params($conn, $sql, array($idreserva));

    if (!$resultado) {
        die('Query Error: ' . pg_last_error($conn));
    }

    $json = array();
    while ($row = pg_fetch_assoc($resultado)) {
        $json[] = array(
            'idreserva'     => $row['idreserva'],
            'valoruni'      => $row['valoruni'],
            'valorduo'      => $row['valorduo'],
            'idhora'        => $row['idhora'],
            'nombre'        => $row['nombre'],
            'cantidad'      => $row['cantidad'],
            'total'         => $row['total'],
            'abono'         => $row['abono'],
            'adeudado'      => $row['adeudado'],
            'usuario'       => $row['nombre_usuario'],
            'fecha'         => $row['fecha'],
            'observaciones' => $row['observaciones'],
            'telefono'      => $row['telefono'],
            'email'         => $row['email'],
            'tipovuelo'     => $row['tipovuelo']
        );
    }

    echo json_encode($json);
break;
case 'eliminar':
    $idreserva = $_REQUEST['idreserva'];

    $sql = "UPDATE reservas SET eliminado = 1, fechaelimina = NOW() WHERE idreserva = $1";
    $resultado = pg_query_params($conn, $sql, array($idreserva));

    if (!$resultado) {
        die('Query Error: ' . pg_last_error($conn));
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
    case 'validar':
        $idreserva = $_REQUEST['idreserva'];
        if ($usuariosesion == 'psepulveda') {
            // Usamos pg_query para la consulta en PostgreSQL
            $query = "UPDATE reservas SET estado = 'Valida' WHERE idreserva = $idreserva";
            $resultado = pg_query($conn, $query); // Realizamos la consulta usando pg_query
    
            if (!$resultado) {
                // Manejo de errores para PostgreSQL
                $msj = 'error: ' . pg_last_error($conexion);
            } else {
                $msj = 'Validada con Exito';
            }
        } else {
            $msj = 'Usted no puede ejecutar esta acción';
        }
        echo $msj;
        break; 
    /*case 'cargarperiodo':
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
