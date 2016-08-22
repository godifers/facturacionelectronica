<?php 
session_start();
include("../../phpconex.php");
$nf =$_GET['nunf'];
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	$idcomprobante = $_GET['idcomprobante'];
	$direc =$_GET['direc'];
	//echo $nf ;
		$file1=fopen("C:/xml/proceso.bat","w") or die("Problemas");
		fputs($file1,"C:/xml/WebServices123.jar C:/xml/".$direc."/".$nf.".xml");
		fclose($file1);
		exec('C:\xml\proceso.bat');
		
		//$nf1 = '001001000000056';	

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
			,COM_ESTADO_SRI= '".$esatdo."'
			 where IDT_COMPROBANTE = ".$idcomprobante."  and COM_NUM_COMPROB = '".$nf."'  ";
			//echo $cad_update_comprobante;
			$ejec_update =mysql_query($cad_update_comprobante);
			mysql_close($enlace);
			echo '<script>window.open("http://181.113.67.126:2015/bddfacturacion_agromundosc/lib/pdf_comprob.php?idt_comp='.$idcomprobante.'&nun_comp='.$nf.'","_blank");</script>';

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
			
			echo "<script>alert('EL ARCHIVO NOS E HA GENERADO CORRECTAMENTE');</script>";
		}
		//echo "<script>window.close()</script>";
		echo '<script>document.location.href="http://181.113.67.126:2015/bddfacturacion_agromundosc/inicio.php?id=frm_impresion.php&idcomp='.$idcomprobante.'&numf='.$nf.'"</script>';
	}
	else
	{
		echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../../index.php';
		</script>";
	}
 ?>