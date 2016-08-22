<?php 
session_start();
include("phpconex.php");
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo'])) {
	$enlace = conectarbd();
	$id_cli=$_POST['id_cli'];
	$nunfact=$_POST['nunfact'];
	$idt_val_ret=$_POST['idt_val_ret'];
	$codsust=$_POST['codsust'];
	$cod_ret=$_POST['cod_ret'];
	$baseret=$_POST['baseret'];
	$val_ret=$_POST['val_ret'];
	$porcret=$_POST['porcret'];
	$letra = $_POST['letra'];
	$identificador = $_POST['identific'];

	$update_val_ret="call bd_facelectronica.SP_UPDATE_RETENCION(".$id_cli.", '".$nunfact."', ".$idt_val_ret.", ".$codsust.", '".$cod_ret."',
		 ".$baseret.", ".$val_ret.", ".$porcret.", ".$identificador.", ".$_SESSION['empresa'].", ".$_SESSION['empresa'].",'".$letra."');";
	//echo $update_val_ret;
	$ejec_update_val_ret = mysql_query($update_val_ret);
	mysql_close($enlace);
	$res_update = mysql_fetch_row($ejec_update_val_ret);
	$res_verificador = $res_update[0];
	if ($res_verificador==1) {
		$msn ="<h5 style='background:#60A251;'>LOS VALORES DE RETENCION Y FACTURA SE HAN ACTUALIZADO CORRECTAMETE</h5>";
	}elseif ($res_verificador==2) {
		$msn ="<h5 style='background:#D0CB71;'>USTED HA ANULADO ESTE VALOR DE LA RETENCIÓN FACTURA ACTUALIZADA CORRECTAMETE</h5>";
	}elseif ($res_verificador==3) {
		$msn ="<h5 style='background:#60A251;'>EL VALOR SE HA INGRESADO CORRECTAMENTE FACTURAACTUALIZADA CORRECTAMETE</h5>";
	}elseif ($res_verificador==0) {
		$msn ="<h5 style='background:red;'>TENEMOS UN ERROR .. COMUNIQUESE CON EL ADMINISTRADOR DE SISTEMA..!</h5>";
	}
	echo $msn;
	echo "<script>
			alert('".$msn."');
		</script>";
}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
}

 ?>


