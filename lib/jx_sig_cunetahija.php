<?php 
session_start();
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
	include("phpconexcion.php");
	$enlace = conectar_buscadores();
	$cupadre= $_POST['cupadre'];
	$cad_max_cuent_hija = "SELECT max(PCU_CUENTA) from  t_plancuentas where PCU_CUENTA_PADRE='".$cupadre."'";
	$ejec_cad_max = mysql_query($cad_max_cuent_hija);
	$res_max = mysql_fetch_row($ejec_cad_max);
	$max = $res_max['0'];
	echo $max;

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}	
?>