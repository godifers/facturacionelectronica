<?php 
session_start();
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	require_once('phpconex.php');
	require_once('../fpdf/fpdf.php');
	$nunodc = $_GET['nunodc'];
	$id_doc = $_GET['id_doc'];
	//echo 'numero e doc es '.$nunodc;
	$enlace = conectarbd();
	mysql_close($enlace);

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

	/*IDT_COMPROBANTE, COM_TIPO_COMPR, COM_SUBTIPO_COMP, COM_SECUEN_TIPO, COM_NUM_COMPROB, COM_VAL_SUBT, COM_VAL_BASE0, COM_VAL_BASE12,
	 COM_IVA, COM_TOT, COM_TOT_SIN_RET, COM_TOT_PAGO_COBR, COM_PARTEREL, COM_SUSTENTO_TRIB, COM_FKID_FORMAPAGO, COM_ABONO, COM_SALDO,
	  COM_DOCAFECTADO, COM_FKID_DOCAFECT, COM_CLAVEACESO_SRI, COM_AUTORIZACION_SRI, COM_ESTADO_SIS, COM_ESTADO_CONTAB, COM_ESTADO_ATS_SRI,
	   COM_ESTADO_PAGO, COM_ESTADO_SRI, COM_ESTADO_NULL, COM_MSN_SRI, COM_AMBIENTE, COM_OBSERV_TIPOTRANSAC, COM_OBSERV_GENRL, COM_FKID_CLI_PROV,
	    COM_FKID_USER_CREA, COM_FKID_USER_EDIT, COM_FKID_USER_ANULA, COM_FEC_CREA, COM_FEC_EDIT, COM_FEC_ANULA, COM_FEC_ENVIO, COM_FEC_LLEGADA, 
	    COM_FEC_CORTE, COM_FEC_PAGO, COM_PLAZO, COM_EPRESA, COM_OFCINA, IDT_COMPROBANTE, id*/

	$enlace = conectarbd();
	$cadenaquery_ret ="SELECT COM_FEC_ENVIO , CP_NOMBRE, CP_APELLIDO ,CP_TIPO_ID, CP_CEDULA,CP_DIRECCION , CP_MAIL, CP_TELEFONO, COM_AUTORIZACION_SRI,
	COM_FEC_ENVIO, COM_AMBIENTE, COM_CLAVEACESO_SRI,COM_NUM_COMPROB, COM_FKID_CLI_PROV, USU_NOMBRE , USU_APELLIDO,COM_DOCAFECTADO,COM_FKID_DOCAFECT,COM_FEC_CREA, COM_FEC_LLEGADA
	FROM t_comprobante ,t_client_provee, t_usuario where IDT_CLIENT_PROVEE= COM_FKID_CLI_PROV AND COM_FKID_USER_CREA = IDT_USUARIO
	AND COM_NUM_COMPROB='".$nunodc."' and IDT_COMPROBANTE=".$id_doc;
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
	$num_retencion = $resultado_retencion[12];
	$id_client = $resultado_retencion[13];
	$user =$resultado_retencion[14];//.' '.$resultado_retencion[15];
	$doc_afect =  $resultado_retencion[16];
	$id_doc_afect = $resultado_retencion[17];
	$fecha_crea = $resultado_retencion[18];
	$fecha_llegada =  $resultado_retencion[19];

	$enlace = conectarbd();
	$cad_doc_afect = "SELECT COM_TIPO_COMPR FROM t_comprobante WHERE COM_NUM_COMPROB='".$doc_afect ."' AND IDT_COMPROBANTE=".$id_doc_afect;
	//echo $cad_doc_afect;
	$ejec_cad_doc_afect = mysql_query($cad_doc_afect);
	mysql_close($enlace);
	$res_doc_Afect = mysql_fetch_row($ejec_cad_doc_afect);
	$tipo_comp_afec = $res_doc_Afect[0];

	//####################################################################################################################################
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
	$pdf->Cell(50, 5, utf8_decode('COMPROBANTE DE RETENCIÓN'),0,0,'L');

	$pdf->Ln(6);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(10, 5,'',0); //margen
	$pdf->SetFont('Arial', 'B', 13);
	$pdf->Cell(100, 5,'',0); 
	$pdf->Cell(50, 5, utf8_decode('N° ').$num_retencion,0,0,'L');

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
	$pdf->Cell(70, 5,$fecha_llegada,0);

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
	$pdf->Cell(70, 5,utf8_decode($amb),0);

	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(43, 5,utf8_decode(''),0);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(47, 5,'',0);
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
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(45, 5,'',0);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(45, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(40, 5,'',0);

	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(45, 5,'',0);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(45, 5,'',0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(40, 5,'',0);

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
	$pdf->Cell(85, 2, $fecha_crea,0);

	$pdf->Ln(5);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(180, 20,'',1);

	/*IDT_VAL_RETENCIONES, VALR_COD_RET, VALR_BASE_IMP, VALR_PORCENT, VALR_VAL_RET, VALR_COD_SUST, VALR_NUMFACT, VALR_FK_IDCLIPROV, 
	VALR_EMPRESA, VALR_OFICINA, VALR_TIPO, VALR_ESTADO, VALR_FECHA_ENV, IDT_VAL_RETENCIONES, id*/

	$enlace =conectarbd();
	$cad_query_val_retenidos ="SELECT VALR_COD_SUST, VALR_COD_RET, VALR_BASE_IMP, VALR_PORCENT, VALR_VAL_RET,VALR_NUMFACT,VALR_NUMFACT
	,VALR_FECHA_ENV
	FROM t_val_retenciones 
	WHERE VALR_ESTADO=1 AND VALR_IDT_RETENCION=".$id_doc." AND VALR_FK_IDCLIPROV=".$id_client." AND VALR_NUM_RET= '".$nunodc."' order by VALR_COD_SUST asc ";
	//echo $cad_query_val_retenidos;
	$ejc_cad_val_ret =mysql_query($cad_query_val_retenidos);
	mysql_close($enlace);

	$pdf->Ln(2);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(30, 2,utf8_decode('Comprobante'),0);
	$pdf->Cell(35, 2,utf8_decode('Número'),0);
	$pdf->Cell(30, 2,utf8_decode('Fecha Emisión'),0);
	$pdf->Cell(25, 2,utf8_decode('Ejercicio Fiscal'),0);
	$pdf->Cell(20, 2,utf8_decode('Base Imp'),0);
	$pdf->Cell(20, 2,utf8_decode('Impuesto'),0);
	$pdf->Cell(10, 2,utf8_decode('%'),0);
	$pdf->Cell(20, 2,utf8_decode('Valor'),0);
	

	while ($res_Valor_ret = mysql_fetch_array($ejc_cad_val_ret)) {

		if ($tipo_comp_afec=='C' OR $tipo_comp_afec=='D') {
			$etiq_ret = 'FACTURA';
		}else if ($tipo_comp_afec == 'F'OR  $tipo_comp_afec == 'K') {
			$etiq_ret ='OTROS';
		}

		$pdf->Ln(5);
		$pdf->Cell(10, 5,'',0);
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(30, 2,$etiq_ret,0);
		$pdf->Cell(35, 2,$res_Valor_ret['VALR_NUMFACT'],0);
		$pdf->Cell(30, 2,$res_Valor_ret['VALR_FECHA_ENV'],0);

		$fecha_envio1 = date('d/m/Y',strtotime(str_replace('/', '-', $res_Valor_ret['VALR_FECHA_ENV'])));
		$periodofic = substr($fecha_envio1,3,7);

		$pdf->Cell(25, 2,$periodofic,0);

		if ($res_Valor_ret['VALR_COD_SUST']==1) {
			$tipo_imp ="RENTA";
		} else if ($res_Valor_ret['VALR_COD_SUST']==2) {
			$tipo_imp ="I.V.A";
		}
		
		$pdf->Cell(20, 2,$res_Valor_ret['VALR_BASE_IMP'],0);
		$pdf->Cell(20, 2,$tipo_imp,0);
		$pdf->Cell(10, 2,$res_Valor_ret['VALR_PORCENT'],0);
		$pdf->Cell(20, 2,$res_Valor_ret['VALR_VAL_RET'],0);
	}

	$pdf->Ln(14);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(180, 18,'',1);
	
	$pdf->Ln(2);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(30, 2,utf8_decode(strtoupper('INFORMACIÓN Adicional Sujeto Retenido')),0);

	if (is_null($telf_cli_procee) or $telf_cli_procee='0' or $telf_cli_procee=0)
	{
		$telf_cli_procee = '000000000';
	}

	if (is_null($mail_cli_provee)) {
		$mail_cli_provee = 'agromundotulcan.sc@gmail.com';
	}

	$pdf->Ln(5);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(20, 2,utf8_decode(strtoupper('DIRECCIÓN')),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(80, 2,utf8_decode(strtoupper($direccion_cli_provee)),0);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(20, 2,utf8_decode(strtoupper('TELÉFONO:')),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(40, 2,utf8_decode(strtoupper($telf_cli_procee)),0);

	$pdf->Ln(5);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(20, 2,utf8_decode(strtoupper('Correo:')),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(60, 2,utf8_decode($mail_cli_provee),0);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(45, 2,utf8_decode(strtoupper('RETENCIÓN GENERADA POR:')),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(40, 2,utf8_decode(strtoupper($user)),0); 
	$pdf->Output();

	$pdf->Output('C:/xml/07_RETENCIONES/PDF/'.$nunodc.'.pdf','F');


	$file=fopen("C:/xml/enviomail/proceso.bat","w") or die("Problemas");
	//vamos añadiendo el contenido
	fwrite($file, 'cd/' . PHP_EOL);
	fwrite($file, 'cd xml/enviomail' . PHP_EOL);
	fwrite($file, 'java -jar EnvioCorreo.jar C:\xampp\htdocs\bddfacturacion_agromundosc\lib\xmlenviados\07_RETENCIONES\requestSRI/Autorizado_'.$nunodc.'.xml '.$mail_cli_provee.' C:\xml\07_RETENCIONES\PDF/'.$nunodc.'.pdf "AGROMUNDO S.C. le entrega su Documento ."   "AGROMUNDO S.C.. Adjunto a este correo se encuentra su Documento No: '.$nunodc.' . Gracias por preferirnos." agromundotulcan.sc@gmail.com nancy2014' . PHP_EOL);
	fclose($file);
	exec('C:\xml\enviomail\proceso.bat');
	
	 ?>

	 <!DOCTYPE html>
	 <html lang="en">
	 <head>
	 	<meta charset="UTF-8">
	 	<title>RETENCION N.<?php echo $nunodc; ?></title>
	 </head>
	 <body>
	 	
	 </body>
	 <script type="text/javascript">

	function imprSelec(muestra)
	{
		var ficha=document.getElementById(muestra);
		var ventimp=window.open(' ','popimpr');
		ventimp.document.write(ficha.innerHTML);
		ventimp.document.close();
		ventimp.print();
		ventimp.close();
	}
	</script>
	 </html>
	 <?php 
	// ####################################################################################################################################
}else{
echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}
?>