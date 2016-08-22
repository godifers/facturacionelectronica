<?php 
session_start();
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
	include("phpconexcion.php");
	$enlace = conectar_buscadores();
	$var_cuenta = $_POST['var_cuenta'];
	$var_tipo = $_POST['var_tipo'];
	$idt_excp = $_POST['idt_excp'];
	$identificadoe_accion = $_POST['identificadoe_accion'];

	if ($identificadoe_accion  == 1) {
	
		$enlace = conectar_buscadores();
		$cad_inset = "CALL SP_SAVE_EXCEP ('".$var_cuenta."','".$var_tipo."', ".$_SESSION['empresa']." , ".$_SESSION['id_user'].")";
		//echo $cad_inset;
		$eje_spinsert = mysql_query($cad_inset);
		$res_query_ejep = mysql_fetch_row($eje_spinsert);
		$result = $res_query_ejep[0];
		$tipo = $res_query_ejep[1];

		
		if ($result ==0) {
			if ($tipo =='J') {
				$msn = '<h5 style="text-align:center;font-size:20px;background:red;">La cuenta ya esta guardade para los  EGRESOS...!</h5>';
			} else {
				$msn = '<h5 style="text-align:center;font-size:20px;background:red;">La cuenta ya esta guardade para los INGRESOS...!</h5>';
			}	 	
		 } else {
		 	if ($tipo =='J') {
				$msn = '<h5 style="text-align:center;font-size:20px;background:green;">OK .. La cuenta se ha guardado correctamenet para los EGRESOS...!</h5>';
			} else {
				$msn = '<h5 style="text-align:center;font-size:20px;background:green;">OK .. La cuenta se ha guardado correctamenet para los INGRESOS...!</h5>';
			}	
		 }
		  
	} else if  ($identificadoe_accion  == 2) {
		$enlace = conectar_buscadores();
		$cad_delete = "UPDATE t_excepc_cuent SET EXC_ESTADO = 0 WHERE IDT_EXCEPC_CUENT =".$idt_excp;
		//echo $cad_delete;
		$eje_spinsert = mysql_query($cad_delete);
		$msn = '<h5 style="text-align:center;font-size:20px;background:yellow;">CUENTA ELIMINADA EXITOSAMENTE!</h5>';
	}else{
		$msn = '<h5 style="text-align:center;font-size:20px;background:red;">ERROR GRAVE!</h5>';
	}
	echo $msn;

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}	
?>