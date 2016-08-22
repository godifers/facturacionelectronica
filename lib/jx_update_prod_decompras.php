<?php 
session_start(); 
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
	require_once('phpconex.php');
	$idt_prod = $_POST['idt_prod'];
	$nuevo_cod_prod = $_POST['cod_prod'];
	$nueva_cant = $_POST['cant_prod'];
	$nuevo_v_unit = $_POST['v_unit'];
	$nuevo_v_tot = $_POST['v_tot'];
	$enlace = conectarbd();

	$cad_sp_camb_prod ="CALL SP_CAMBIAR_PROD_COMP (".$idt_prod .",'".$nuevo_cod_prod."', ".$nueva_cant .",".$_SESSION['empresa'].",
		".$_SESSION['id_user'].",".$nuevo_v_unit.",".$nuevo_v_tot.")";
	echo $cad_sp_camb_prod;
	$ejec_cad_sp =  mysql_query($cad_sp_camb_prod);
	echo "<p style='background:green;'>OK ..CAMBIO COREECTO<p>";


 }else{
 	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
 }
 ?>