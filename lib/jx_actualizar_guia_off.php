<?php 
session_start(); 
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	require_once('phpconex.php');
	$idt_guia = $_POST['q'];
	$enlace = conectarbd();
	$update_gia ="UPDATE t_comprobante SET COM_ESTADO_SIS= 1 WHERE COM_TIPO_COMPR='H' and IDT_COMPROBANTE=".$idt_guia;
	//echo $update_gia;
	$ejec_updateguia = mysql_query($update_gia);
	mysql_close($enlace);

 	$enlace = conectarbd();
 	$selecl_detalle_guia ="SELECT DET_FK_IDPROD,DET_CANTIDAD 
	FROM t_detalles,t_prodcutos where  DET_FK_IDCOMPROB=".$idt_guia." AND DET_FK_IDPROD= PR_COD_PROD AND PR_EMPRESA=".$_SESSION['empresa'];
	$ejc_query_DET = mysql_query($selecl_detalle_guia);
	mysql_close($enlace);

	while ($res_datealle_guia = mysql_fetch_array($ejc_query_DET)) {
		$enlace = conectarbd();
		$actualizar_stock ="CALL SP_ACEPTAR_DETALLE_GUIA('".$res_datealle_guia['DET_FK_IDPROD']."', ".$res_datealle_guia['DET_CANTIDAD'].", 
			".$_SESSION['empresa']." , ".$_SESSION['empresa'].")";
		$ejec_sp_update_stock= mysql_query($actualizar_stock);
		mysql_close($enlace);
	}

	echo "<h4 style='background:green;'>LA GUIA SE HA INGRESADO CORRECTAMETE</h4>";

 }else{
 	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
 }
 ?>