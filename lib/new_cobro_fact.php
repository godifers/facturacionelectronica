<?php 
session_start();
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	include('phpconex.php');
	$enlace = conectarbd();
	$c_cidtcliente=$_POST['c_cidtcliente'];
	$c_tot_new_abon=$_POST['c_tot_new_abon'];

	$cad_guardar_cobro ="CALL SP_GUARDAR_COBRO (".$c_cidtcliente." , ".$c_tot_new_abon.", ".$_SESSION['empresa'].",".$_SESSION['empresa'].",".$_SESSION['id_user'].")";
	//echo $cad_guardar_cobro.'<br>';
	$jec_cad_guardar_conbro= mysql_query($cad_guardar_cobro);
	mysql_close($enlace);
	$resultado_cobro  = mysql_fetch_row($jec_cad_guardar_conbro);
	$idt_comprob = $resultado_cobro[0];
	$numero_comprob_pago = $resultado_cobro[1];

	if(is_array($_POST['c_idt_coprob'])) {
		 while(list($key,$idt_coprob) = each($_POST['c_idt_coprob']) and list($key,$num_fact) = each($_POST['c_num_fact']) 
		 	and list($key,$identific) = each($_POST['c_identificador']) and list($key,$abono_fact) = each($_POST['c_new_abono']) 
		 	AND list($key,$saldo_fact)= each($_POST['c_new_saldo'])) 
		{  	    		
			$enlace = conectarbd();
			if ($identific==1) {
				$inser_detalle_pago_fact="CALL SP_GUARDAR_DETALLE_PAGO(".$abono_fact.", '".$num_fact."',".$idt_coprob.", ".$c_cidtcliente.",
				".$saldo_fact.", 'V',".$_SESSION['empresa'].", ".$_SESSION['empresa']." ,".$_SESSION['id_user'].",".$idt_comprob.",'".$numero_comprob_pago."','A')";
				//echo $inser_detalle_pago_fact.'<br>';
				$res_inser_serv=mysql_query($inser_detalle_pago_fact) or die(mysql_error());
				mysql_close($enlace);
			}			
		}
	}

	echo "<script>
	alert('EL PAGO SE HA GENERADO CORRECATAMENTE..!');
	window.open('php_imp_pago_cobro.php?id_comprob=".$idt_comprob ."&num_comprob=".$numero_comprob_pago."','_blanck');
	window.location='../inicio.php';
	</script>";

	
}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}
 ?>