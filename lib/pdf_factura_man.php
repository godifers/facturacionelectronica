<?php 
session_start();
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
 	require_once('phpconex.php');
	require_once('../fpdf/fpdf.php');
	$idt_comp= $_GET['idt_comp'];
	$num_comprob= $_GET['nun_comp'];
 	$enlace = conectarbd();
	$cad_query_emp ="SELECT EMP_RUC, EMP_RAZON_SOCIAL, EMP_AMBIENTE, EMP_NOMBRE, EMP_DIRECCION_MATRIZ , EMP_NUMERO_CONTRIB, 
	EMP_OBLIGADO_LLEVAR_CONTAB ,EMP_DIR_LOCAL
	FROM t_empresa where  IDT_EMPRESA=".$_SESSION['empresa'];
	$ejec_cad_emp = mysql_query($cad_query_emp);
	mysql_close($enlace);
	$resultados_emp = mysql_fetch_row($ejec_cad_emp);
	$ruc_emp = $resultados_emp[0];
	$razon_social_emp= $resultados_emp[1];
	$ambiente_emp = $resultados_emp[2];
	$nombre_emp = $resultados_emp[3];
	$direci_matriz_emp = $resultados_emp[4];
	$num_contrib = $resultados_emp[5];
	$obligado_llev =$resultados_emp[6];
	$direc_local_emp = $resultados_emp[7];

	/*IDT_COMPROBANTE, COM_TIPO_COMPR, COM_SUBTIPO_COMP, COM_SECUEN_TIPO, COM_NUM_COMPROB, COM_VAL_SUBT, COM_VAL_BASE0, COM_VAL_BASE12, COM_IVA, 
	COM_TOT, COM_TOT_SIN_RET, COM_TOT_PAGO_COBR, COM_PARTEREL, COM_SUSTENTO_TRIB, COM_FKID_FORMAPAGO, COM_ABONO, COM_SALDO, COM_DOCAFECTADO, 
	COM_FKID_DOCAFECT, COM_CLAVEACESO_SRI, COM_AUTORIZACION_SRI, COM_ESTADO_SIS, COM_ESTADO_CONTAB, COM_ESTADO_ATS_SRI, COM_ESTADO_PAGO, 
	COM_ESTADO_SRI, COM_ESTADO_NULL, COM_MSN_SRI, COM_AMBIENTE, COM_OBSERV_TIPOTRANSAC, COM_OBSERV_GENRL, COM_FKID_CLI_PROV, COM_FKID_USER_CREA,
	 COM_FKID_USER_EDIT, COM_FKID_USER_ANULA, COM_FEC_CREA, COM_FEC_EDIT, COM_FEC_ANULA, COM_FEC_ENVIO, COM_FEC_LLEGADA, COM_FEC_CORTE, COM_FEC_PAGO,
	  COM_PLAZO, COM_EPRESA, COM_OFCINA, IDT_COMPROBANTE, id*/

	$enlace = conectarbd();
	$cadquer_comprob ="SELECT COM_FEC_CREA , CP_NOMBRE, CP_APELLIDO ,CP_TIPO_ID, CP_CEDULA,CP_DIRECCION , CP_MAIL, CP_TELEFONO, COM_AUTORIZACION_SRI,
	COM_FEC_ENVIO, COM_AMBIENTE, COM_CLAVEACESO_SRI,COM_NUM_COMPROB, COM_FKID_CLI_PROV, USU_NOMBRE , USU_APELLIDO, COM_TIPO_COMPR,
	COM_VAL_SUBT, COM_VAL_BASE0, COM_VAL_BASE12, COM_IVA, COM_TOT
	FROM t_comprobante ,t_client_provee, t_usuario where IDT_CLIENT_PROVEE= COM_FKID_CLI_PROV AND COM_FKID_USER_CREA = IDT_USUARIO
	AND COM_NUM_COMPROB='".$num_comprob."' and IDT_COMPROBANTE=".$idt_comp." AND COM_EPRESA=".$_SESSION['empresa'];
	//echo $cadquer_comprob;
	$ejec_cad_comprob = mysql_query($cadquer_comprob);
	mysql_close($enlace);
	$res_comprob = mysql_fetch_row($ejec_cad_comprob);
	$fecha_envio = $res_comprob[0];
	$nombre_cli_provee = $res_comprob[1].' '.$res_comprob[2];
	$tipo_ruc_cli_provee = $res_comprob[3];
	$ruc_client_provee = $res_comprob[4];
	$direccion_cli_provee = $res_comprob[5];
	$mail_cli_provee = $res_comprob[6];
	$telf_cli_procee = $res_comprob[7];
	$autorizacion = $res_comprob[8];
	$fcha_cre = $res_comprob[9];
	$ambiente = $res_comprob[10];
	$clave_acceso = $res_comprob[11];
	$num_gioremi = $res_comprob[12];
	$id_client = $res_comprob[13];
	$user =$res_comprob[14].' '.$res_comprob[15];
	//--- otros datos  -----
	$tipo_comprob = $res_comprob[16];
	$sutot = $res_comprob[17];
	$base0 = $res_comprob[18] ;
	$base12 = $res_comprob[19];
	$iva = $res_comprob[20];
	$total = $res_comprob[21];

	//$pdf = new FPDF('P','mm','a4');
	$pdf = new FPDF('P','mm',array(200, 250));
	$pdf->SetMargins(0, 45, 18); 
	$pdf->SetAutoPageBreak(true,0); 
	$pdf->AddPage();
	$pdf->SetFont('Arial', '', 8);

	$pdf->Ln(5);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 15);
	$pdf->Cell(107, 5,utf8_decode(''),0);
	$pdf->SetFont('Arial', 'B', 14);
	$pdf->Cell(50, 5, str_replace("-", "  ", $fecha_envio),0);

	$pdf->Ln(9);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(30, 5,utf8_decode('  '),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(85, 5, utf8_encode($nombre_cli_provee ),0);

	$pdf->Ln(7);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(30, 5,utf8_decode('  '),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(50, 5, utf8_decode($ruc_client_provee ),0);

	$pdf->Ln(7);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(30, 5,utf8_decode('  '),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(92, 5, utf8_decode($direccion_cli_provee ),0);
	$pdf->Cell(50, 5, $telf_cli_procee ,0);
	

	$enlace = conectarbd();

	$caddetalleventa ="SELECT DET_FK_IDPROD,PR_DETALLE,PR_PRESENTACION,DET_CANTIDAD,DET_VAL_UNIT,DET_VAL_TOT , DET_TIPO_TRNS 
	FROM t_detalles,t_prodcutos where DET_FK_IDCOMPROB=".$idt_comp." AND DET_NUM_FACTU='".$num_comprob."'
 	AND DET_FK_IDPROD= PR_COD_PROD AND PR_EMPRESA=".$_SESSION['empresa'];
	$eje_caddetalleventa = mysql_query($caddetalleventa);
	//echo $caddetalleventa;
	mysql_close($enlace);
	$pdf->Ln(5);
	$varlong = 0;
	while ($num_fila_guia = mysql_fetch_array($eje_caddetalleventa)) {
		$pdf->Ln(6);
		$pdf->Cell(22, 5,'',0);
		$pdf->Cell(12, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'C');
		$pdf->Cell(4, 5,'',0);
		$pdf->Cell(70, 5,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0,0,'L');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');

		/*$pdf->Ln(6);
		$pdf->Cell(22, 5,'',0);
		$pdf->Cell(12, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'C');
		$pdf->Cell(4, 5,'',0);
		$pdf->Cell(70, 5,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0,0,'L');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');

		$pdf->Ln(6);
		$pdf->Cell(22, 5,'',0);
		$pdf->Cell(12, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'C');
		$pdf->Cell(4, 5,'',0);
		$pdf->Cell(70, 5,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0,0,'L');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');


		$pdf->Ln(6);
		$pdf->Cell(22, 5,'',0);
		$pdf->Cell(12, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'C');
		$pdf->Cell(4, 5,'',0);
		$pdf->Cell(70, 5,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0,0,'L');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');

		$pdf->Ln(6);
		$pdf->Cell(22, 5,'',0);
		$pdf->Cell(12, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'C');
		$pdf->Cell(4, 5,'',0);
		$pdf->Cell(70, 5,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0,0,'L');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');

		$pdf->Ln(6);
		$pdf->Cell(22, 5,'',0);
		$pdf->Cell(12, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'C');
		$pdf->Cell(4, 5,'',0);
		$pdf->Cell(70, 5,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0,0,'L');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');

		$pdf->Ln(6);
		$pdf->Cell(22, 5,'',0);
		$pdf->Cell(12, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'C');
		$pdf->Cell(4, 5,'',0);
		$pdf->Cell(70, 5,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0,0,'L');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');


		$pdf->Ln(6);
		$pdf->Cell(22, 5,'',0);
		$pdf->Cell(12, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'C');
		$pdf->Cell(4, 5,'',0);
		$pdf->Cell(70, 5,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0,0,'L');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');

		
		$pdf->Ln(6);
		$pdf->Cell(22, 5,'',0);
		$pdf->Cell(12, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'C');
		$pdf->Cell(4, 5,'',0);
		$pdf->Cell(70, 5,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0,0,'L');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');

		$pdf->Ln(6);
		$pdf->Cell(22, 5,'',0);
		$pdf->Cell(12, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'C');
		$pdf->Cell(4, 5,'',0);
		$pdf->Cell(70, 5,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0,0,'L');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');

		$pdf->Ln(6);
		$pdf->Cell(22, 5,'',0);
		$pdf->Cell(12, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'C');
		$pdf->Cell(4, 5,'',0);
		$pdf->Cell(70, 5,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0,0,'L');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');

		$pdf->Ln(6);
		$pdf->Cell(22, 5,'',0);
		$pdf->Cell(12, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'C');
		$pdf->Cell(4, 5,'',0);
		$pdf->Cell(70, 5,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0,0,'L');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(2, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');*/

		

		$varlong++;
	}
	//$varlong = 12;
	if ($varlong == 1) {
		$espacio = 117;
	}else if($varlong == 2){
		$espacio = 112;
	}else if($varlong == 3){
		$espacio = 106;
	}else if($varlong == 4){
		$espacio = 100;
	}else if($varlong == 5){
		$espacio = 94;
	}else if($varlong == 6){
		$espacio = 88;
	}else if($varlong == 7){
		$espacio = 82;
	}else if($varlong == 8){
		$espacio = 76;
	}else if($varlong == 9){
		$espacio = 70;
	}else if($varlong == 10){
		$espacio = 64;
	}else if($varlong == 11){
		$espacio = 58;
	}else if($varlong == 12){
		$espacio = 52;
	}else if($varlong == 13){
		$espacio = 46;
	}else if($varlong == 14){
		$espacio = 40;
	}else{
		$espacio = 123;
	}
	$pdf->Ln($espacio);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(118, 5,'',0,0,'L');
	$pdf->Cell(15, 5,'',0,0,'R');//SUBTOTAL
	$pdf->Cell(5, 5,'',0);
	$pdf->Cell(4, 5,$sutot,0,0,'R');

	$pdf->Ln(8);
	$pdf->Cell(118, 5,'',0,0,'L');
	$pdf->Cell(15, 5,'',0,0,'R');//I.V.A.
	$pdf->Cell(5, 5,'',0);
	$pdf->Cell(4, 5,$iva,0,0,'R');

	$pdf->Ln(8);
	$pdf->Cell(118, 5,'',0,0,'L');
	$pdf->Cell(15, 5,'',0,0,'R');//BASE 12 %.
	$pdf->Cell(5, 5,'',0);
	$pdf->Cell(4, 5,$base12,0,0,'R');

	$pdf->Ln(8);
	$pdf->Cell(118, 5,'',0,0,'L');
	$pdf->Cell(15, 5,'',0,0,'R');//TOTAL.
	$pdf->Cell(5, 5,'',0);
	$pdf->Cell(4, 5,$total,0,0,'R');

	$pdf->Ln(4);
	$pdf->SetFont('Arial', 'B', 5);
	$pdf->Cell(118, 5,'',0,0,'L');
	$pdf->Cell(15, 5,'',0,0,'R');//SUBTOTAL
	$pdf->Cell(5, 5,'',0);
	$pdf->Cell(4, 5,$num_comprob,0,0,'R');

	

	/*$pdf->Ln(6);
	$pdf->Cell(118, 5,'',0,0,'L');
	$pdf->Cell(15, 5,'.',0,0,'R');
	$pdf->Cell(5, 5,'',0);
	$pdf->Cell(4, 5,$varlong,0,0,'R');*/

	$pdf->Output();
	$pdf->Output('C:\Users\USER\Desktop\PDF FACTURAS/'.$num_comprob.'.pdf','F');

 }else{
  echo "<script>
      alert('USTED NO HA INICIADO SESION');
      window.location='index.php';
    </script>";
}
?>