<?php 
session_start();
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
	include("phpconexcion.php");
	$enlace = conectar_buscadores();
	$var_cuenta = $_POST['var_cuenta'];
	$var_nom_ba = $_POST['var_nom_ba'];	
	$id_bancos = $_POST['id_bancos'];
	$estad = $_POST['estad'];
	$identificador = $_POST['identificador'];
	
	
	$enlace = conectar_buscadores();
	$cad_inset_banco = "CALL SP_SAVE_BANCO ('".$var_cuenta."','".$var_nom_ba."',".$_SESSION['empresa']." ,".$_SESSION['id_user'].",
		".$id_bancos.",".$estad.",".$identificador.")";
	//echo $cad_inset_banco;
	$eje_spinsert_banco = mysql_query($cad_inset_banco);
	$res_query_ejep = mysql_fetch_row($eje_spinsert_banco);
	$result = $res_query_ejep[0];
	
	if ($result ==1) {
		$msn ='<h5 style="text-align:center;font-size:20px;background:green;">OK .. BANCO GUARDADO CORRECTAMENTE...!</h5>';	
	 } elseif($result ==2) {
	 	$msn ='<h5 style="text-align:center;font-size:20px;background:green;">BANCO ACTIVADO CORRECTAMENTE...!</h5>';
	 }elseif($result ==3) {
	 	$msn ='<h5 style="text-align:center;font-size:20px;background:yellow;">BANDO DAO DE BAJA CORRECTAMENTE...!</h5>';
	 }else {
	 	$msn ='<h5 style="text-align:center;font-size:20px;background:red;">EROR...!</h5>';
	 }
	
	echo $msn;

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}	
?>