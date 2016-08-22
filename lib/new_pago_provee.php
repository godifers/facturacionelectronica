<?php 
session_start();
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	
	$identificado_forma_pag = $_POST['c_txt_idetificador'];
	$cmb_banco = $_POST['c_banco'];
	$num_cheue = $_POST['c_numcheque_ch'];
	$val_chueq = $_POST['c_valchque_ch'];

	/*if (isset($_POST['c_numcheque_ch'])) {
		$val_chueq = $_POST['c_valchque_ch'];
		$c_tot_new_abon = $val_chueq;
	} else {
		$c_tot_new_abon = $_POST['c_tot_new_abon'];
	}*/
	
	$fecha_cobr = $_POST['c_fechacob_ch'];

	$nombreaquiva_chque = $_POST['c_nombrepago_ch'];
	$c_forma_pag  = $_POST['c_forma_pag'];
	$c_fecha_pago = $_POST['c_fecha_pago'];
	$fecha_cobr = trim($fecha_cobr);
	$c_cidtcliente=$_POST['c_cidtcliente'];

	include('phpconex.php');
	$enlace = conectarbd();
	//c_forma_pag
	/*if (isset($_POST['c_tot_new_abon'])) {
		$c_tot_new_abon = $_POST['c_tot_new_abon'];
	}else{
		$c_tot_new_abon = $val_chueq;
	}*/

	if ($c_forma_pag == 1) {
		$num_cheue = '000';
		$val_chueq = 0.00;
		$fecha_cobr = date('Y-m-d');
		$c_tot_new_abon = $_POST['c_tot_new_abon'];
	}else{
		$c_tot_new_abon = $val_chueq;
	}

	if (is_null($fecha_cobr) or $fecha_cobr=='') {
		$fecha_cobr = date('Y-m-d');
	}else{
		$fecha_cobr = $fecha_cobr;
	} 
	//echo $fecha_cobr;	

	$cad_guardar_cobro ="CALL SP_GUARDAR_PAGO_PROVEE (".$c_cidtcliente." ,".$c_tot_new_abon.", ".$_SESSION['empresa'].",".$_SESSION['empresa'].",
		".$_SESSION['id_user'].",".$cmb_banco.",'".$num_cheue."', ".$val_chueq.",'".$fecha_cobr."', '".utf8_decode($nombreaquiva_chque)."',".$c_forma_pag.",'".$c_fecha_pago."')";

	//echo $cad_guardar_cobro.'<br>';
	$jec_cad_guardar_conbro= mysql_query($cad_guardar_cobro);
	mysql_close($enlace);
	$resultado_cobro  = mysql_fetch_row($jec_cad_guardar_conbro);
	$idt_comprob = $resultado_cobro[0];
	$numero_comprob_pago = $resultado_cobro[1];

	if (isset($_POST['c_idt_coprob'])) {
		if(is_array($_POST['c_idt_coprob'])) {
			 while(list($key,$idt_coprob) = each($_POST['c_idt_coprob']) and list($key,$num_fact) = each($_POST['c_num_fact']) 
			 	and list($key,$identific) = each($_POST['c_identificador']) and list($key,$abono_fact) = each($_POST['c_new_abono']) 
			 	AND list($key,$saldo_fact)= each($_POST['c_new_saldo']) AND list($key,$tipo)= each($_POST['c_tip_comp'])) 
			{  	    		
				$enlace = conectarbd();
				if ($identific==1) {
					$inser_detalle_pago_fact="CALL SP_GUARDAR_DETALLE_PAGO(".$abono_fact.", '".$num_fact."',".$idt_coprob.", ".$c_cidtcliente.",
					".$saldo_fact.", '".$tipo."',".$_SESSION['empresa'].", ".$_SESSION['empresa']." ,".$_SESSION['id_user'].",".$idt_comprob.",'".$numero_comprob_pago."','B')";
					//echo $inser_detalle_pago_fact.'<br>';
					$res_inser_serv=mysql_query($inser_detalle_pago_fact) or die(mysql_error());
					mysql_close($enlace);
				}			
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

	echo "<script>
	alert('EL PAGO SE HA GENERADO CORRECATAMENTE..!');
	window.open('php_imp_pago_provee.php?id_comprob=".$idt_comprob ."&num_comprob=".$numero_comprob_pago."','_blank');
	window.open('php_imp_cheque.php?id_comprobrob=".$idt_comprob ."&num_comprob=".$numero_comprob_pago."','_blank');
	window.location='../inicio.php';
	</script>";

	
}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}
 ?>