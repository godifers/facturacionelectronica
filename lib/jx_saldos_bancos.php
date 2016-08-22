<?php 
session_start();
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
	include("phpconexcion.php");
	$enlace = conectar_buscadores();
	$cuenta = $_POST['cuenta'];
	$cad_query_saldos ="call SP_SALDOS_BANCOS('".$cuenta ."',".$_SESSION['empresa'].")";
	//echo $cad_query_saldos;
	$ejec_saldos_bancos = mysql_query($cad_query_saldos) ;
	$res_saldos = mysql_fetch_row($ejec_saldos_bancos);
	$saldo_fin = $res_saldos[0];
	
	echo '<p style="font-size:20px;">'.$saldo_fin.' $$</p>';

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}	
?>