<?php 
session_start();
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
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

	$enlace = conectarbd();
	$cadenaquery_ret ="SELECT COM_FEC_ENVIO , CP_NOMBRE, CP_APELLIDO ,CP_TIPO_ID, CP_CEDULA,CP_DIRECCION , CP_MAIL, CP_TELEFONO, COM_AUTORIZACION_SRI,
	COM_FEC_ENVIO, COM_AMBIENTE, COM_CLAVEACESO_SRI,COM_NUM_COMPROB, COM_FKID_CLI_PROV, USU_NOMBRE , USU_APELLIDO
	FROM t_comprobante ,t_client_provee, t_usuario where IDT_CLIENT_PROVEE= COM_FKID_CLI_PROV AND COM_FKID_USER_CREA = IDT_USUARIO
	AND COM_NUM_COMPROB='".$num_comprob."' and IDT_COMPROBANTE=".$idt_comp;
	//echo $cadenaquery_ret;
	$ejec_cadquery_ret = mysql_query($cadenaquery_ret);
	mysql_close($enlace);
	$resultado_retencion = mysql_fetch_row($ejec_cadquery_ret);
	$fecha_envio = $resultado_retencion[0];
	$nombre_cli_provee = $resultado_retencion[1].' '.$resultado_retencion[2];
	$tipo_ruc_cli_provee = $resultado_retencion[3];
	$ruc_client_provee = $resultado_retencion[4];
	$direccion_cli_provee = $resultado_retencion[5];
	$mail_cli_provee = $resultado_retencion[6];
	$telf_cli_procee = $resultado_retencion[7];
	$autorizacion = $resultado_retencion[8];
	$fcha_cre = $resultado_retencion[9];
	$ambiente = $resultado_retencion[10];
	$clave_acceso = $resultado_retencion[11];
	$num_gioremi = $resultado_retencion[12];
	$id_client = $resultado_retencion[13];
	$user =$resultado_retencion[14].' '.$resultado_retencion[15];

	$pdf = new FPDF('P','mm','a4');
	$pdf->SetMargins(0, 15 , 20); 
	$pdf->SetAutoPageBreak(true,0); 
	$pdf->AddPage();
	$pdf->SetFont('Arial', '', 8);

	$pdf->Ln(0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(10, 5,'',0); //margen
	$pdf->image("../img/logo.png", 8,10,95,20,'PNG');
	$pdf->SetFont('Arial', 'B', 13);
	$pdf->Cell(100, 5,'',0); 
	$pdf->Cell(50, 5, utf8_decode('GUÍA DE REMISIÓN'),0,0,'L');

	$pdf->Ln(6);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(10, 5,'',0); //margen
	$pdf->SetFont('Arial', 'B', 13);
	$pdf->Cell(100, 5,'',0); 
	$pdf->Cell(50, 5, utf8_decode('N° ').$num_gioremi,0,0,'L');

	$pdf->Ln(10);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(90, 5,'ALMACEN DE INSUMOS AGRICOLAS, VETERINARIOS Y',0);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(90, 5,utf8_decode('NÚMERO DE AUTORIZACIÓN'),0);

	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(90, 5,'PRESTACION DE SERVICIOS AGROMUNDO S.C.',0);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(90, 5,$autorizacion,0);

	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(15, 5,'RUC.:',0);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(75, 5,$ruc_emp,0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(40, 5,utf8_decode('FECHA DE AUTORIZACIÓN : '),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(70, 5,$fecha_envio,0);

	if ($ambiente==1) {
		$amb = 'PRUEBAS';
	} else if($ambiente==2) {
		$amb = 'PRODUCCIÓN';
	}else{
		$amb = 'Error';
	}
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(15, 5,utf8_decode('DIR. MATRÍZ:'),0);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(75, 5,$direci_matriz_emp,0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(40, 5,utf8_decode('AMBIENTE : '),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(70, 5,$amb,0);

	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(43, 5,utf8_decode('CONTRIBUYENTE ESPECIAL Nº:'),0);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(47, 5,$num_contrib,0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(40, 5,utf8_decode('CLAVE DE ACCESO : '),0);

	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(45, 5,utf8_decode('OBLIGADO A LLEVAR CONTABILIDAD:'),0);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(45, 5,$obligado_llev,0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(40, 5,$clave_acceso,0);

	$pdf->Ln(5);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(180, 12,'',1);

	$pdf->Ln(3);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(15, 2,utf8_decode('CLIENTE : '),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(85, 2, utf8_decode($nombre_cli_provee ),0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(30, 2,utf8_decode('IDENTIFICACIÓN : '),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(50, 2, utf8_decode($ruc_client_provee ),0);

	$pdf->Ln(5);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(30, 2,utf8_decode('FECHA DE EMISIÓN : '),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(85, 2, $fecha_envio,0);

	$pdf->Ln(5);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(180, 60,'',1);

	$enlace = conectarbd();

	$caddetalleventa ="SELECT DET_FK_IDPROD,PR_DETALLE,PR_PRESENTACION,DET_CANTIDAD,DET_VAL_UNIT,DET_VAL_TOT , DET_TIPO_TRNS 
	FROM t_detalles,t_prodcutos where DET_FK_IDCOMPROB=".$idt_comp." AND DET_NUM_FACTU='".$num_comprob."'
 	AND DET_FK_IDPROD= PR_COD_PROD AND PR_EMPRESA=".$_SESSION['empresa'];
	$eje_caddetalleventa = mysql_query($caddetalleventa);
	//echo $caddetalleventa;
	mysql_close($enlace);

	$pdf->Ln(2);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(40, 5,utf8_decode('COD PROD'),0);
	$pdf->Cell(60, 5,utf8_decode('DESCRIPCION'),0);
	$pdf->Cell(30, 5,utf8_decode('CANTID.'),0);
	$pdf->Cell(30, 5,utf8_decode('V UNIT.'),0);
	$pdf->Cell(30, 5,utf8_decode('V. TOT.'),0);

	while ($num_fila_guia = mysql_fetch_array($eje_caddetalleventa)) {
		$pdf->Ln(5);
		$pdf->Cell(10, 5,'',0);
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(40, 2,$num_fila_guia['DET_FK_IDPROD'],0);
		$pdf->Cell(60, 2,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0);
		$pdf->Cell(7, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'R');
		$pdf->Cell(7, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(14, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');
	}

$pdf->Output();

 }else{
  echo "<script>
      alert('USTED NO HA INICIADO SESION');
      window.location='index.php';
    </script>";
}
?>