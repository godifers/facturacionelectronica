<?php 
session_start();
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
	include("phpconex.php");
	$c_total_haber = $_POST['c_total_haber'];
	$c_fecha_notcon = $_POST['c_fecha_notcon'];

	$enlace = conectarbd();	
	$cad_l_cont = "CALL SP_GUARDAR_NOT_CONT (".$c_total_haber.", ".$_SESSION['empresa']." , ".$_SESSION['empresa'].", 'L',".$_SESSION['id_user'].",'".$c_fecha_notcon."')";
	$ejec_cad_sp = mysql_query($cad_l_cont);
	//echo $cad_l_cont;
	mysql_close($enlace);
	$res_not_cotn = mysql_fetch_row($ejec_cad_sp);
	$idt_comprob =  $res_not_cotn[0];
	$res_num_not_cont = $res_not_cotn[1];
	$id_clienet = $res_not_cotn[2];

	if (isset($_POST['c_codidet_l_egre'])) {
	
		if(is_array($_POST['c_codidet_l_egre'])) {
			 while(list($key,$codprod) = each($_POST['c_codidet_l_egre']) and list($key,$cant) = each($_POST['c_cant_l_egre']) 
			 	and list($key,$vunit) = each($_POST['c_vuni_l_egre']) and list($key,$vtot) = each($_POST['c_vtot_l_egre']) ) 
			{  	    		
				$enlace = conectarbd();
				$cant = $cant *(-1);     		
				$iser_detall_venta="CALL SP_GUARDAR_PRROD('".$codprod."', ".$cant.", ".$vunit.", ".$vtot.", 
					'L' ,".$_SESSION['empresa'].", ".$_SESSION['empresa'].",".$idt_comprob." , 
					'".$res_num_not_cont."',0 ,0 ,0 , 0,".$id_clienet.")";
				//echo $iser_detall_venta;
				$res_inser_serv=mysql_query($iser_detall_venta) or die(mysql_error());
				mysql_close($enlace);
			 }
		}
	}

	if (isset($_POST['c_codidet_l_ingre'])) {
		if(is_array($_POST['c_codidet_l_ingre'])) {
			echo "SI ENTRA"	;
			 while(list($key,$codprod) = each($_POST['c_codidet_l_ingre']) and list($key,$cant) = each($_POST['c_cant_l_ingre']) 
			 	and list($key,$vunit) = each($_POST['c_vuni_l_ingre']) and list($key,$vtot) = each($_POST['c_vtot_l_ingre']) ) 
			{  	    		
				$enlace = conectarbd();	   		
				$iser_detall_venta="CALL SP_GUARDAR_PRROD('".$codprod."', ".$cant.", ".$vunit.", ".$vtot.", 
					'L' ,".$_SESSION['empresa'].", ".$_SESSION['empresa'].",".$idt_comprob." , 
					'".$res_num_not_cont."',0 ,0 ,0 , 0,".$id_clienet.")";
				//echo $iser_detall_venta;
				$res_inser_serv=mysql_query($iser_detall_venta) or die(mysql_error());
				mysql_close($enlace);
			 }
		}
	}
	if(is_array($_POST['c_cuenta1'])){
                  //echo "sieeeeeeeeee ingresa detalle";
	     while(list($key,$nom_cuneta) = each($_POST['c_cuenta1']) and list($key,$cod_cuenta) = each($_POST['c_condigo_cu1']) 
	      and list($key,$debe) = each($_POST['c_debe_cu1']) and list($key,$haber) = each($_POST['c_haber_cu1']) ) 
	      {   
	        $enlace = conectarbd();     
	        $cad_insert_asiento = "INSERT INTO t_asiento VALUES (NULL, '".$idt_comprob."', '".$cod_cuenta."', ".$debe.", ".$haber.", 1)";
	        //echo $cad_insert_asiento.'<br>';
	        $res_inser_serv=mysql_query($cad_insert_asiento);
	        mysql_close($enlace);
	      }
	}
	echo "<script>alert('Datos guardados correctamente');		
		window.location='../inicio.php?id=frm_notascont.php';
		window.open('../inicio.php?id=frm_administrar_comprobante.php&idcomprobante=".$idt_comprob."&num_comprob_Fac=".$res_num_not_cont."')
	</script>";

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}

?>
