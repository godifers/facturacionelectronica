<?php 
session_start();
include("../../phpconex.php");
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	$nf =$_GET['nunf'];
	$idcomprobante = $_GET['idcomprobante'];
	$direc =$_GET['direc'];
	//echo $nf ;
		$file1=fopen("C:/xml/proceso.bat","w") or die("Problemas");
		fputs($file1,"C:/xml/WebServices123.jar C:/xml/".$direc."/".$nf.".xml");
		fclose($file1);
		exec('C:\xml\proceso.bat');
			
		/*$enlace = conectarbd();
		$cad_mail ="SELECT CP_MAIL FROM t_client_provee , t_comprobante where COM_FKID_CLI_PROV= IDT_CLIENT_PROVEE and
			IDT_COMPROBANTE=".$idcomprobante;
		//echo $cad_mail;
		$ejec_cad_mail = mysql_query($cad_mail);
		mysql_close();
		$result_mail= mysql_fetch_row($ejec_cad_mail);
		$mail_cliporov= $result_mail[0];*/

		if (file_exists("requestSRI/Autorizado_".$nf.".xml")) {

			$xml = simplexml_load_file("requestSRI/Autorizado_".$nf.".xml");
			$esatdo = $xml->estado;				
			$fechaAutorizacion =$xml->fechaAutorizacion;
			$new_fecha_aut = substr($fechaAutorizacion,0,10);
			$numeroAutorizacion = $xml->numeroAutorizacion;
			//echo $esatdo.'<br>';
			//echo $numeroAutorizacion.'<br>';
			$enlace = conectarbd();			
			$cad_update_comprobante ="UPDATE t_comprobante SET COM_AUTORIZACION_SRI= '".$numeroAutorizacion."' 
			,COM_ESTADO_SRI= '".$esatdo."',COM_FEC_LLEGADA ='".$new_fecha_aut."'
			 where IDT_COMPROBANTE = ".$idcomprobante."  and COM_NUM_COMPROB = '".$nf."'  ";
			//echo $cad_update_comprobante;
			$ejec_update =mysql_query($cad_update_comprobante);
			mysql_close($enlace);

			echo '<script>window.open("http://181.113.67.126:2015/bddfacturacion_agromundosc/lib/pdf_comprob.php?idt_comp='.$idcomprobante.'&nun_comp='.$nf.'","_blank");</script>';
			//echo '<script>window.open("http://localhost/bddfacturacion_agromundosc/lib/pdf_comprob.php?idt_comp='.$idcomprobante.'&nun_comp='.$nf.'","_blank");</script>';
			

			/*$file=fopen("C:/xml/enviomail/proceso.bat","w") or die("Problemas");
			//vamos añadiendo el contenido
			fwrite($file, 'cd/' . PHP_EOL);
			fwrite($file, 'cd xml/enviomail' . PHP_EOL);
			fwrite($file, 'java -jar EnvioCorreo.jar C:\xampp\htdocs\bddfacturacion_mysql\lib\xmlenviados\01_FACTURAS\requestSRI/Autorizado_'.$nf.'.xml '.$mail_cliporov.' C:\xml\01_FACTURAS\PDF/'.$nf.'.pdf "AGROMUNDO S.C. le entrega su Documento ."   "AGROMUNDO S.C. Adjunto a este correo se encuentra su Documento No: '.$nf.'. Gracias por preferirnos." agromundotulcan.sc@gmail.com nancy2014' . PHP_EOL);
			fclose($file);
			exec('C:\xml\enviomail\proceso.bat');*/

		} else if (file_exists("requestSRI/NOAutorizado_".$nf.".xml")){

			$xml = simplexml_load_file("requestSRI/NOAutorizado_".$nf.".xml");
			$esatdo = $xml->estado;	
			$fechaAutorizacion =$xml->fechaAutorizacion;
			$new_fecha_aut = substr($fechaAutorizacion,0,10);
			$error= $xml->mensajes->mensaje->mensaje;
			$infoadicional_error =$xml->mensajes->mensaje->informacionAdicional;
			//echo $esatdo.'<br>';
			//echo $error.'<br>';
			//echo $infoadicional_error.'<br>';
			$error_tot = $error.' '.$infoadicional_error;
			$enlace = conectarbd();
			$cad_update_comprobante ="UPDATE t_comprobante SET COM_ESTADO_SRI= '".$esatdo."', COM_MSN_SRI = '".$error_tot."'
			where  IDT_COMPROBANTE =".$idcomprobante."  and COM_NUM_COMPROB = '".$nf."' ";
			//echo $cad_update_comprobante;
			$ejec_update =mysql_query($cad_update_comprobante);
			mysql_close($enlace);

		} else if (file_exists("requestSRI/Error_".$nf.".xml")){

			$xml = simplexml_load_file("requestSRI/Error_".$nf.".xml");
			$esatdo = $xml->estado;				
			$error= $xml->comprobantes->comprobante->mensajes->mensaje->mensaje;
			$infoadicional_error =$xml->comprobantes->comprobante->mensajes->mensaje->informacionAdicional;
			//echo $esatdo.'<br>';
			//echo $error.'<br>';
			//echo $infoadicional_error.'<br>';
			$error_tot = $error.' ' .$infoadicional_error ;
			$enlace = conectarbd();
			$cad_update_comprobante ='UPDATE t_comprobante SET COM_ESTADO_SRI= "'.$esatdo.'", COM_MSN_SRI = "'.$error_tot.'"
			where  IDT_COMPROBANTE ='.$idcomprobante.'  and COM_NUM_COMPROB = "'.$nf.'" ';
			//echo $cad_update_comprobante;
			$ejec_update =mysql_query($cad_update_comprobante);
			mysql_close($enlace);

		}else{
			echo "<script>alert('EL ARCHIVO NO SE HA GENERADO CORRECTAMENTE');</script>";
		}
		//echo "<script>window.close()</script>";
		echo '<script>document.location.href="http://181.113.67.126:2015/bddfacturacion_agromundosc/inicio.php?id=frm_impresion.php&idcomp='.$idcomprobante.'&numf='.$nf.'"</script>';
		//echo '<script>document.location.href="http://localhost/bddfacturacion_agromundosc/inicio.php?id=frm_impresion.php&idcomp='.$idcomprobante.'&numf='.$nf.'"</script>';
	}
	else
	{
		echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../../index.php';
		</script>";
	}
 ?>