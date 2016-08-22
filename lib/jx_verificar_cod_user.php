<?php 
session_start();
	if (isset($_SESSION['empresa']) ){
	include("phpconexcion.php");
	$enlace = conectar_buscadores();
	$cod_usuario =$_POST['cod_usuario'];

	$ca_user = "SELECT IDT_USUARIO, USU_LOGER, USU_CLAVE_DOC FROM t_usuario where USU_CLAVE_DOC='".$cod_usuario."'";
	$ejec_cad_user = mysql_query($ca_user);
	//echo $ca_user;
	if (mysql_num_rows($ejec_cad_user)==1) {
		$res_user = mysql_fetch_row($ejec_cad_user);
		$idt_user = $res_user[0];
		$loger_us = $res_user[1];
		$clave_us = $res_user[2];
		echo $idt_user.'|'.$loger_us.'|'.$clave_us.'|1';
	} else {
		echo '0|0|0|0';
	}
}