<?php 
session_start();
require_once('phpconex.php');
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {

	$c_cliente = $_POST ['c_adcnombre'];
	$c_apellido = $_POST ['c_adcapellido'];
	$c_contribuyente = $_POST ['c_adccontribuyente'];
	$c_telf = $_POST ['c_adctelf'];
	$c_documento = $_POST ['c_adcdumento'];
	$c_numdoc = $_POST ['c_adcnumdoc'];
	$c_direcc = $_POST ['c_adcdirecc'];
	$c_ciudad = $_POST ['c_adcciudad'];
	$c_mail = $_POST ['c_adcmail'];
	$c_credito = $_POST ['c_adccredito'];
	$c_estado = $_POST ['c_adcestado'];
	$id_cli = $_POST['c_identificador'];
	$c_tipo = $_POST['c_tipo'];


	//$c_plazo = $POST ['c_adcplazo']

	$enlace = conectarbd();
	$call_SP_GUARDARCLIENTES = "SELECT F_GUARDARCLIENTES('".$c_cliente."', '".$c_apellido."', '".$c_numdoc."', '".$c_direcc."',                  
		'".$c_telf."', '".$c_mail."', '".$c_ciudad."', ".$c_contribuyente.",".$c_estado.",".$c_credito.",".$c_documento.", 
		".$_SESSION['empresa'].", ".$_SESSION['empresa'].", ".$c_tipo.",".$id_cli .")";
	//echo $call_SP_GUARDARCLIENTES;
	$cadcall=mysql_query($call_SP_GUARDARCLIENTES);
	mysql_close($enlace);
	$res_cli = mysql_fetch_row($cadcall);
	$res = $res_cli[0];
	if ($res==0) {
		$msn='Ha ocurrido un error al crear el nuevo cliente o proveedor ya existe en su BD..!';
	}elseif($res==1) {
		$msn = 'El cliente o proveedor se ha creado correctamente..!';
	}elseif ($res==2) {
		$msn = 'Los datos se han actualizado correctamente..!';
	}else{
		$msn = 'ERRO CRITICO';
	}
	
	echo "<script>alert('".$msn."'); 
		window.location='../inicio.php?id=frm_clientes.php'; </script>";

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
}	

?>