<?php 
session_start();
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
	include("phpconexcion.php");
	$enlace = conectar_buscadores();
	$identific= $_POST['identific'];
	$cod_cuenta= $_POST['cod_cuenta'];
	$nom_cuenta= $_POST['nom_cuenta'];
	$cod_cuenta_pad= $_POST['cod_cuenta_pad'];
	$mov_cuenta= $_POST['mov_cuenta'];
	$saldo1= $_POST['saldo1'];
	$idt1= $_POST['idt1'];
	$saldo2= $_POST['saldo2'];
	$idt2= $_POST['idt2'];	
	
	if ( $identific== 0 and (substr($cod_cuenta,0,strlen($cod_cuenta_pad)) != substr ($cod_cuenta_pad,0,strlen($cod_cuenta_pad)))) {
		echo substr($cod_cuenta,0,strlen($cod_cuenta_pad)).'<br>';
		echo substr ($cod_cuenta_pad,0,strlen($cod_cuenta_pad));
		echo '<p style="text-align:center;background:yellow;width:300px;padding:5px;border-radius:3px;margin:0 auto;">LA CUENTA PADRE Y LA NUEVA NO CONCUERDAN</p>';
	}else{
		$cad_cuentas = "CALL SP_INSER_UP_CUENTAS(".$identific.", '".$cod_cuenta."', '".$nom_cuenta."', '".$cod_cuenta_pad."', 
			".$mov_cuenta." , ".$saldo1." , ".$idt1.", ".$saldo2.", ".$idt2.", ".$_SESSION['id_user'].")";
		//echo $cad_cuentas;
		$ejec_sp_cuentas = mysql_query($cad_cuentas);
		$res_sp_cuentas = mysql_fetch_row($ejec_sp_cuentas);
		$respuesta = $res_sp_cuentas['0'];
		if ($respuesta == 0) {
			$msn = '<p style="text-align:center;background:red;width:300px;padding:5px;border-radius:3px;margin:0 auto;">HA OCURRIDO UN ERROR..!</p>';
		}else if($respuesta == 2){
			$msn = '<p style="text-align:center;background:green;width:300px;padding:5px;border-radius:3px;margin:0 auto;">CUENTA CREADA SATISFACTORIAMENTE</p>';
		}else if($respuesta == 1){
			$msn = '<p style="text-align:center;background:green;width:300px;padding:5px;border-radius:3px;margin:0 auto;">DATOS ACTUALIZADOS CORRECTAMENTE</p>';
		}else if($respuesta == 3){
			$msn = '<p style="text-align:center;background:green;width:300px;padding:5px;border-radius:3px;margin:0 auto;">LA CUENTAS YA ESTA EN SU PLAN DE CUENTAS</p>';
		}else{
			$msn = '<p style="text-align:center;background:red;width:300px;padding:5px;border-radius:3px;margin:0 auto;">ERROR FATAL!</p>';
		}
		echo $msn;
	}

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}	
?>