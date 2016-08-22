<?php 
session_start();
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
	include('phpconex.php');
	$c_hdn_cli_prov = $_POST['c_hdn_cli_prov'];
	$c_identificador_ingresos_egresos = $_POST['c_identificador_ingresos_egresos'];
	$c_valor_egre_ingr = $_POST['c_valor_egre_ingr'];
	$c_concepro_egre_ingre = $_POST['c_concepro_egre_ingre'];
	$c_cuidad_egre_ingre = $_POST['c_cuidad_egre_ingre'];
	$c_fecha_recibo = $_POST['c_fecha_recibo'];

	$enlace = conectarbd();
	$cad_insert_ingre_egre = "CALL SP_GURDAR_EGRE_INGRES(".$c_hdn_cli_prov.", ".$c_valor_egre_ingr.",'".strtoupper($c_concepro_egre_ingre)."', 
	'".$c_cuidad_egre_ingre."', '".$c_identificador_ingresos_egresos."',".$_SESSION['empresa']."
	,".$_SESSION['empresa'].",".$_SESSION['id_user'].",'".$c_fecha_recibo."')"; // ejecuta sp

	$ejec_ccad_egre_ingre = mysql_query($cad_insert_ingre_egre);
	//echo $cad_insert_ingre_egre.'<br>';
	mysql_close($enlace);
	$resultado_egre_ingre = mysql_fetch_row($ejec_ccad_egre_ingre);
	$idt_compro = $resultado_egre_ingre[0];
	$tipode_ingres_egres = $resultado_egre_ingre[1];
	$num_compro_egre = $resultado_egre_ingre[2];
	$veridi_entrada = 0;

	if(is_array($_POST['c_cuenta1'])){
                  //echo "sieeeeeeeeee ingresa detalle";
	     while(list($key,$nom_cuneta) = each($_POST['c_cuenta1']) and list($key,$cod_cuenta) = each($_POST['c_condigo_cu1']) 
	      and list($key,$debe) = each($_POST['c_debe_cu1']) and list($key,$haber) = each($_POST['c_haber_cu1']) ) 
	      { 
	      	$enlace = conectarbd(); 
	      	$cad_excep = "SELECT * FROM t_excepc_cuent where EXC_ESTADO = 1 and EXC_CUENTA='".$cod_cuenta."' and EXC_TIPO_TRANS ='".$tipode_ingres_egres."'";
	      	//echo $cad_excep.'<br>';
	      	$eje_execp = mysql_query($cad_excep);
	      	$num_de_filas = mysql_num_rows($eje_execp);
	      	if (is_null($num_de_filas)) {
	      		$num_de_filas  = 0;
	      	} else {
	      		$num_de_filas  = $num_de_filas ;
	      	}
	      	
	      	if ($num_de_filas  > 0 and $veridi_entrada  == 0) {
	      		$enlace = conectarbd(); 
	      		$cad_sp_act_comp = "CALL SP_UDDATE_COMP(".$idt_compro.",'".$num_compro_egre."','".$tipode_ingres_egres."')";
	      		//echo $cad_sp_act_comp;
	      		$ejec_cad_update = mysql_query($cad_sp_act_comp);
	      		$veridi_entrada  = 1;
	      		//echo "si entro";
	      	} 
	      	
	        $enlace = conectarbd();     
	        $cad_insert_asiento = "INSERT INTO t_asiento VALUES (NULL, '".$idt_compro."', '".$cod_cuenta."', ".$debe.", ".$haber.", 1)";
	        //echo $cad_insert_asiento.'<br>';
	        $res_inser_serv=mysql_query($cad_insert_asiento);
	        mysql_close($enlace);
	      }
	}
	echo "<script>alert('Datos guardados correctamente');		
		window.location='../inicio.php?id=frm_administrar_comprobante.php&idcomprobante=".$idt_compro."&num_comprob_Fac=".$num_compro_egre."';
	</script>";
}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}

 ?>