<?php
    $destino="godies.cuastu@gmail.com";
    $nombre=$_POST['c_nombre'];
    $correo=$_POST['c_correo'];
    $telefono=$_POST['c_telefono'];
    $mensaje=$_POST['c_mensaje'];
    $nomarchivo= $_FILES['c_selecarchivo']['name'];
    $sizearchivo= $_FILES['c_selecarchivo']['size'];
    $typearchivo= $_FILES['c_selecarchivo']['type'];
    $temparchivo= $_FILES['c_selecarchivo']['tmp_name'];
    $contenido="Nombre: ".$nombre. "\nCorreo: ".$correo."\nTelefono: " .$telefono."\nMensaje:".$mensaje; 

    $archivo= "Content-type:application/octet-stream;";
    $archivo.= "name:" . $nomarchivo ."\r\n";
    $archivo.= "Content-Transfer-Encoding: base64\r\n";
    $archivo.= "Content-Disposition:attachment;";
    $archivo.= "filename:" . $nomarchivo . "\r\n";
    $archivo.= "\r\n";

    $fp= fopen($temparchivo,"rb");
    $file= fread($fp, $sizearchivo);
    $file= chunk_split(base64_encode($file));

    $archivo.= "$file\r\n";
    $archivo.= "\r\n";
    $archivo.= "--=P=R=U=E=B=A\"r\n";

    mail($destino,$contenido,$archivo);
    
    /*<?php


    $nomarchivo= $_FILES['c_selecarchivo']['name'];
    $sizearchivo= $_FILES['c_selecarchivo']['size'];
    $typearchivo= $_FILES['c_selecarchivo']['type'];
    $temparchivo= $_FILES['c_selecarchivo']['tmp_name'];
    
    $destino="andersonsanchez1990@gmail.com";
    $mailemisor="andersonsanchez1990@gmail.com";

    $fecha=time();
    $fechaformato=date("j/n/Y",$fecha);
    
    $asunto="Enviado por: TU PAPA";

    $cabecera= "MIME-VERSION:1.0\r\n";
    $cabecera.= "Content-type: multipart/mixed;";
    $cabecera.= "boundary=\"=P=R=U=E=B=A\"r\n";
    $cabecera.= "From: {$mailemisor}";

    $cuerpo= "--=P=R=U=E=B=A\"r\n";
    $cuerpo.="Content-type:text/plain";
    $cuerpo.= "charset=UTF-8\r\n";
    $cuerpo.= "Content-Transfer-Encoding: 8bit\r\n";
    $cuerpo.= "\r\n";
    $cuerpo.= "Correo enviado por: Tu PAPA";
    $cuerpo.= " Con fecha: " . $fechaformato . "\r\n";
    $cuerpo.= " Email:" . $mailemisor . "\r\n";
    $cuerpo.= " Mensaje: hola que haces \r\n"  ;
    $cuerpo.= " \r\n";   

    $cuerpo.= "--=P=R=U=E=B=A\"r\n";
    $cuerpo.= "Content-type:application/octet-stream;";
    $cuerpo.= "name:" . $nomarchivo ."\r\n";
    $cuerpo.= "Content-Transfer-Encoding: base64\r\n";
    $cuerpo.= "Content-Disposition:attachment;";
    $cuerpo.= "filename:" . $nomarchivo . "\r\n";
    $cuerpo.= "\r\n";

    $fp= fopen($temparchivo,"rb");
    $file= fread($fp, $sizearchivo);
    $file= chunk_split(base64_encode($file));

    $cuerpo.= "$file\r\n";
    $cuerpo.= "\r\n";
    $cuerpo.= "--=P=R=U=E=B=A\"r\n";

    if (mail($destino, $asunto, $cuerpo, $cabecera)) {
        echo "Enviado con exito";
    }else{
        echo "error de envio";
    }

?> */
   
?>    








