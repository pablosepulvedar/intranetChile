<?php
    //$conexion = mysqli_connect(
    //    'localhost',/*donde se conecta*/
    //    'root',/*usuario*/
    //    '', /*contraseña */
    //    'chilepa6_intranet'/*base de datos*/
    //);
//
    //if ($conexion ) {
    //    echo 'conectado';
    //} else {
    //    echo 'no conectado';
    //}

    // Datos de conexión
    $host = "localhost";  // Dirección del servidor
    $port = "5432";       // Puerto (por defecto 5432)
    $dbname = "gestionreservas"; // Nombre de la base de datos
    $user = "postgres";    // Usuario de la base de datos
    $password = "cordrack88"; // Contraseña del usuario
    
    // Cadena de conexión
    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    
    // Verificar si la conexión fue exitosa
    if (!$conn) {
        echo "Error en la conexión a la base de datos.";
    } else {
        echo "Conexión exitosa a la base de datos.";
    }
    
    // Cerrar la conexión al final
    //pg_close($conn);
    ?>