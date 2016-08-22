<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <title>Document</title>
 </head>
 <body>
    <form action="lib/phpmail.php" method="post" enctype="multipart/form-data" name="phpmailer">
        <table>
            <tr>
                <td><input type="text" name="c_nombre" placeholder="Nombre"required></td>
            </tr>
            <tr>
                <td><input type="text" name="c_correo" placeholder="Correo"required></td>
            </tr>
            <tr>
                <td><input type="text" name="c_telefono" placeholder="Telefono"required></td>
            </tr>
            <tr>
                <td><textarea name="c_mensaje" id="id_mensaje" placeholder="Escriba aquin su mensaje"></textarea></td>
            </tr>
            <tr>
                <td><input type="file" name="c_selecarchivo" required></td>
            </tr>
            <tr>
                <td><input type="submit" name="c_enviar" value="Enviar Email"></td></tr>
            
        </table>
    </form>
 </body>
 </html>