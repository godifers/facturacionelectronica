<?php 
session_start();
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
	include("phpconexcion.php");
	$c_total_debe = $_POST['c_total_debe'];
	$c_total_haber = $_POST['c_total_haber'];
	$c_idt_comprob = $_POST['c_idt_comprob'];
	$c_num_comprob = $_POST['c_num_comprob'];
	$tipo_comp = $_POST['c_tipo_comp'];

	$enlace = conectar_buscadores();
	$cad_delete_asiento =  "DELETE FROM t_asiento WHERE ASI_FK_IDCOMPROB=".$c_idt_comprob;
	$ejec_Cad_delete = mysql_query($cad_delete_asiento);

	$enlace = conectar_buscadores();
	$cad_update_L =  "UPDATE t_comprobante SET COM_TOT =".$c_total_haber." WHERE COM_NUM_COMPROB='".$c_num_comprob."' AND IDT_COMPROBANTE =".$c_idt_comprob ;
	$ejec_Cad_update = mysql_query($cad_update_L);

	$veridi_entrada = 0;

	$enlace = conectar_buscadores();
	if(is_array($_POST['c_cuenta1'])){
         //echo "sieeeeeeeeee ingresa detalle";
	     while(list($key,$nom_cuneta) = each($_POST['c_cuenta1']) and list($key,$cod_cuenta) = each($_POST['c_condigo_cu1']) 
	      and list($key,$debe) = each($_POST['c_debe_cu1']) and list($key,$haber) = each($_POST['c_haber_cu1']) ) 
	      {   
	      	if ($tipo_comp =='J') {
	      		$enlace = conectar_buscadores();
		      	$cad_excep = "SELECT * FROM t_excepc_cuent where EXC_ESTADO = 1 and EXC_CUENTA='".$cod_cuenta."' and EXC_TIPO_TRANS ='".$tipo_comp ."'";
		      	//echo $cad_excep.'<br>';
		      	$eje_execp = mysql_query($cad_excep);
		      	$num_de_filas = mysql_num_rows($eje_execp);
		      	if (is_null($num_de_filas)) {
		      		$num_de_filas  = 0;
		      	} else {
		      		$num_de_filas  = $num_de_filas ;
		      	}

		      	if ($num_de_filas  > 0 and $veridi_entrada  == 0) {
		      		$enlace = conectar_buscadores();
		      		$cad_sp_act_comp = "CALL SP_UDDATE_COMP(".$c_idt_comprob.",'".$c_num_comprob."','".$tipo_comp ."')";
		      		//echo $cad_sp_act_comp;
		      		$ejec_cad_update = mysql_query($cad_sp_act_comp);
		      		$veridi_entrada  = 1;
		      		//echo "si entro";
		      	} 
	      		//-----------------
	      	} 	      	
	        $enlace = conectar_buscadores();   
	        $cad_insert_asiento = "INSERT INTO t_asiento VALUES (NULL, '".$c_idt_comprob."', '".$cod_cuenta."', ".$debe.", ".$haber.", 1)";
	        //echo $cad_insert_asiento.'<br>';
	        $res_inser_serv=mysql_query($cad_insert_asiento);
	      }
	}
	echo "<script>alert('Datos guardados correctamente');		
		window.history.back();
	</script>";

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}

?>
