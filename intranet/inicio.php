<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Intranet</title>
</head>
<body>
    <div id='formlogin' style="margin: 18% 39% 0% 44%;">
        <form action="intranet/loguear.php" method="POST">
            <table>
                <tr>
                    <td>
                        <label for="usuario">Usuario</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="usuario" name="usuario" value="psepulveda">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Contraseña</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="password" name="password" id="password" value="cordrack88">
                    </td>
                </tr>
                <tr style="text-align: center;">
                    <td>
                        <button type="submit" style="margin-top: 10px;">Entrar</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>