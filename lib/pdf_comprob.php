<?php 
session_start();
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
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
	COM_VAL_SUBT, COM_VAL_BASE0, COM_VAL_BASE12, COM_IVA, COM_TOT, COM_FEC_LLEGADA
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
	$fecha_autoriza = $res_comprob[22];

	$pdf = new FPDF('P','mm','a4');
	$pdf->SetMargins(0, 15 , 20); 
	$pdf->SetAutoPageBreak(true,0); 
	$pdf->AddPage();
	$pdf->SetFont('Arial', '', 8);

	if ($tipo_comprob=='V') {
		$etique1 = 'FACTURA';
	} else if ($tipo_comprob=='G') {
		$etique1 = 'GUÍA DE REMISIÓN';
	}else if($tipo_comprob=='H'){
		$etique1 = 'GUÍA DE REMISIÓN';
	}
	

	$pdf->Ln(0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(10, 5,'',0); //margen
	$pdf->image("../img/logo.png", 8,10,95,20,'PNG');
	$pdf->SetFont('Arial', 'B', 13);
	$pdf->Cell(100, 5,'',0); 
	$pdf->Cell(50, 5, utf8_decode($etique1),0,0,'L');

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
	$pdf->Cell(70, 5,$fecha_autoriza,0);

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
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(180, 12,'',1);

	$pdf->Ln(3);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(15, 2,utf8_decode('CLIENTE : '),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(85, 2, utf8_encode($nombre_cli_provee ),0);
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

	$enlace = conectarbd();

	if ($_SESSION['porcenIVA'] == 1.12) {
			$etiqIVA = " 12%:";
		} else if ($_SESSION['porcenIVA'] == 1.14){
			$etiqIVA = " 14%:";
		}

	$caddetalleventa ="SELECT DET_FK_IDPROD,PR_DETALLE,PR_PRESENTACION,DET_CANTIDAD,DET_VAL_UNIT,DET_VAL_TOT , DET_TIPO_TRNS 
	FROM t_detalles,t_prodcutos where DET_FK_IDCOMPROB=".$idt_comp." AND DET_NUM_FACTU='".$num_comprob."'
 	AND DET_FK_IDPROD= PR_COD_PROD AND PR_EMPRESA=".$_SESSION['empresa'];
	$eje_caddetalleventa = mysql_query($caddetalleventa);
	//echo $caddetalleventa;
	mysql_close($enlace);

	$pdf->Ln(5);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(40, 5,utf8_decode('COD PROD'),0);
	$pdf->Cell(68, 5,utf8_decode('DESCRIPCION'),0);
	$pdf->Cell(30, 5,utf8_decode('CANTID.'),0);
	$pdf->Cell(30, 5,utf8_decode('V UNIT.'),0);
	$pdf->Cell(30, 5,utf8_decode('V. TOT.'),0);
	$pdf->Ln(3);
	while ($num_fila_guia = mysql_fetch_array($eje_caddetalleventa)) {
		$pdf->Ln(5);
		$pdf->Cell(10, 5,'',0);
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(40, 2,$num_fila_guia['DET_FK_IDPROD'],0);
		$pdf->Cell(60, 2,utf8_decode($num_fila_guia['PR_DETALLE'].' '.$num_fila_guia['PR_PRESENTACION']),0);
		$pdf->Cell(7, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_CANTIDAD'],0,0,'R');
		$pdf->Cell(13, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_UNIT'],0,0,'R');
		$pdf->Cell(15, 5,'',0);
		$pdf->Cell(15, 5,$num_fila_guia['DET_VAL_TOT'],0,0,'R');
	}
	//if ($tipo_comprob =!'G') {
		
	
		$pdf->Ln(10);
		$pdf->Cell(10, 5,'',0);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(40, 2,'',0);
		$pdf->Cell(60, 2,'',0);
		$pdf->Cell(7, 5,'',0);
		$pdf->Cell(15, 5,'',0,0,'R');
		$pdf->Cell(25, 5,'',0);
		$pdf->Cell(15, 5,'SUBTOTAL',0,0,'R');
		$pdf->Cell(5, 5,'',0);
		$pdf->Cell(13, 5,$sutot,0,0,'R');

		$pdf->Ln(6);
		$pdf->Cell(10, 5,'',0);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(40, 2,'',0);
		$pdf->Cell(60, 2,'',0);
		$pdf->Cell(7, 5,'',0);
		$pdf->Cell(15, 5,'',0,0,'R');
		$pdf->Cell(25, 5,'',0);
		$pdf->Cell(15, 5,'BASE 0%.',0,0,'R');
		$pdf->Cell(5, 5,'',0);
		$pdf->Cell(13, 5,$base0,0,0,'R');

		$pdf->Ln(6);
		$pdf->Cell(10, 5,'',0);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(40, 2,'',0);
		$pdf->Cell(60, 2,'',0);
		$pdf->Cell(7, 5,'',0);
		$pdf->Cell(15, 5,'',0,0,'R');
		$pdf->Cell(25, 5,'',0);
		$pdf->Cell(15, 5,'BASE '.$etiqIVA,0,0,'R');
		$pdf->Cell(5, 5,'',0);
		$pdf->Cell(13, 5,$base12,0,0,'R');

		

		$pdf->Ln(6);
		$pdf->Cell(10, 5,'',0);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(40, 2,'',0);
		$pdf->Cell(60, 2,'',0);
		$pdf->Cell(7, 5,'',0);
		$pdf->Cell(15, 5,'',0,0,'R');
		$pdf->Cell(25, 5,'',0);
		$pdf->Cell(15, 5,'I.V.A '.$etiqIVA,0,0,'R');
		$pdf->Cell(5, 5,'',0);
		$pdf->Cell(13, 5,$iva,0,0,'R');

		$pdf->Ln(6);
		$pdf->Cell(10, 5,'',0);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(40, 2,'',0);
		$pdf->Cell(60, 2,'',0);
		$pdf->Cell(7, 5,'',0);
		$pdf->Cell(15, 5,'',0,0,'R');
		$pdf->Cell(25, 5,'',0);
		$pdf->Cell(15, 5,'TOTAL.',0,0,'R');
		$pdf->Cell(5, 5,'',0);
		$pdf->Cell(13, 5,$total,0,0,'R');
	//}

	$pdf->Output();

	$pdf->Output('C:\Users\USER\Desktop\PDFFACTURAS/'.$num_comprob.'.pdf','F');
	$pdf->Output('C:\xml\01_FACTURAS\PDF/'.$num_comprob.'.pdf','F');

	if ($tipo_comprob=='V') {
		/*$pdf->Output('C:/xml/01_FACTURAS/PDF/'.$num_comprob.'.pdf','F');
		$file=fopen("C:/xml/enviomail/proceso.bat","w") or die("Problemas");
		fwrite($file, 'cd/' . PHP_EOL);
		fwrite($file, 'cd xml/enviomail' . PHP_EOL);
		fwrite($file, 'java -jar EnvioCorreo.jar C:\xampp\htdocs\bddfacturacion_agromundosc\lib\xmlenviados\01_FACTURAS\requestSRI/Autorizado_'.$num_comprob.'.xml '.$mail_cli_provee.' C:\Users\USER\Desktop\PDFFACTURAS/'.$num_comprob.'.pdf "AGROMUNDO S.C. le entrega su Documento ."   "AGROMUNDO S.C. En este correo se adjunta sus documentos de compra No: '.$num_comprob.'. Gracias por preferirnos." agromundotulcan.sc@gmail.com nancy2014' . PHP_EOL);
		fclose($file);

		exec('C:\xml\enviomail\proceso.bat');*/
		$pdf->Output('C:/xml/01_FACTURAS/PDF/'.$num_comprob.'.pdf','F');
		$file=fopen("C:/xml/enviomail/proceso.bat","w") or die("Problemas");
		//vamos añadiendo el contenido
		fwrite($file, 'cd/' . PHP_EOL);
		fwrite($file, 'cd xml/enviomail' . PHP_EOL);
		fwrite($file, 'java -jar EnvioCorreo.jar C:\xampp\htdocs\bddfacturacion_agromundosc\lib\xmlenviados\01_FACTURAS\requestSRI/Autorizado_'.$num_comprob.'.xml '.$mail_cli_provee.' C:\Users\USER\Desktop\PDFFACTURAS/'.$num_comprob.'.pdf "AGROMUNDO S.C. le entrega su Documento ."   "AGROMUNDO S.C.. Adjunto a este correo se encuentra su Documento No: '.$num_comprob.'. Gracias por preferirnos." agromundotulcan.sc@gmail.com nancy2014' . PHP_EOL);
		fclose($file);
		exec('C:\xml\enviomail\proceso.bat');

	} else if ($tipo_comprob=='G') {
		$pdf->Output('C:/xml/04_GUIAS_DE_REM/PDF/'.$num_comprob.'.pdf','F');
		$file=fopen("C:/xml/enviomail/proceso.bat","w") or die("Problemas");
		fwrite($file, 'cd/' . PHP_EOL);
		fwrite($file, 'cd xml/enviomail' . PHP_EOL);
		fwrite($file, 'java -jar EnvioCorreo.jar C:\xampp\htdocs\bddfacturacion_agromundosc\lib\xmlenviados\04_GUIAS_DE_REM\requestSRI/Autorizado_'.$num_comprob.'.xml '.$mail_cli_provee.' C:\Users\USER\Desktop\PPDFFACTURAS/'.$num_comprob.'.pdf "AGROMUNDO S.C. le entrega su Documento ."   "AGROMUNDO S.C. Adjunto a este correo se encuentra su Documento No: '.$num_comprob.'. Gracias por preferirnos." agromundotulcan.sc@gmail.com nancy2014' . PHP_EOL);
		fclose($file);
	}else if($tipo_comprob=='H'){
		$etique1 = 'GUÍA DE REMISIÓN';
	}

 }else{
  echo "<script>
      alert('USTED NO HA INICIADO SESION');
      window.location='index.php';
    </script>";
}
?>