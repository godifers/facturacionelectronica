<?php 
session_start();
if (isset($_SESSION['empresa']) and  isset($_SESSION['id_user'])) {
	include("phpconex.php");
	require_once('../fpdf/fpdf.php');
	$id_comtpb = $_GET['id_comprob'];
	$num_comprob = $_GET['num_comprob'];

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
	$cad_comrpobante = "SELECT CP_NOMBRE, CP_APELLIDO, CP_DIRECCION, CP_TELEFONO, CP_CEDULA, USU_LOGER, COM_FKID_CLI_PROV,COM_FEC_CREA,
	 COM_TOT, COM_FKID_FORMAPAGO
	FROM t_comprobante, t_client_provee ,t_usuario 
	where IDT_CLIENT_PROVEE= COM_FKID_CLI_PROV  AND COM_FKID_USER_CREA= IDT_USUARIO 
	AND IDT_COMPROBANTE=".$id_comtpb ." AND COM_NUM_COMPROB='".$num_comprob."'";
	//echo $cad_comrpobante;
	$ejec_cad_compro = mysql_query($cad_comrpobante);
	mysql_close($enlace);
	$resultado_Comp_pago = mysql_fetch_row($ejec_cad_compro);
	$nom_cli = $resultado_Comp_pago[0].' '. $resultado_Comp_pago[1];
	$direc_cli = $resultado_Comp_pago[2];
	$telf_cli = $resultado_Comp_pago[3];
	$ced_ruc_cli = $resultado_Comp_pago[4];
	$usu_crea = $resultado_Comp_pago[5];
	$id_cliente_provee = $resultado_Comp_pago[6];
	$fecah_pago = $resultado_Comp_pago[7];
	$total_comprob = $resultado_Comp_pago[8];
	$froma_pago  = $resultado_Comp_pago[9];


	$pdf = new FPDF('P','mm','a4');
	$pdf->SetMargins(5, 15 , 20); 
	$pdf->SetAutoPageBreak(true,0); 
	$pdf->AddPage();
	$pdf->SetFont('Arial', '', 8);

	$pdf->Ln(0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(10, 5,'',0); //margen
	$pdf->image("../img/logo.png", 15,10,95,20,'PNG');
	$pdf->SetFont('Arial', 'B', 13);
	$pdf->Cell(102, 5,'',0); 
	$pdf->Cell(80, 5, utf8_decode('COMPROBANTE DE PAGO '),0,0,'R');

	$pdf->Ln(6);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(10, 5,'',0); //margen
	$pdf->SetFont('Arial', 'B', 13);
	$pdf->Cell(102, 5,'',0); 
	$pdf->Cell(80, 5, utf8_decode('N° ').$num_comprob,0,0,'R');

	$pdf->Ln(8);
	$pdf->SetFont('Arial', 'B', 5);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(90, 5,'ALMACEN DE INSUMOS AGRICOLAS, VETERINARIOS Y PRESTACION DE SERVICIOS AGROMUNDO S.C.',0);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(90, 5,'',0);

	$pdf->Ln(5);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(180, 22,'',1);
	
	$pdf->Ln(2);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(30, 2,utf8_decode(strtoupper('INFORMACIÓN  DEL CLIENTE')),0);

	$pdf->Ln(5);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(20, 2,utf8_decode(strtoupper('DIRECCIÓN')),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(80, 2,utf8_decode(strtoupper($nom_cli)),0);

	$pdf->Ln(5);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(20, 2,utf8_decode(strtoupper('DIRECCIÓN')),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(80, 2,utf8_decode(strtoupper($direc_cli)),0);
	$pdf->Cell(5, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(20, 2,utf8_decode(strtoupper('FECHA:')),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(18, 2,utf8_decode(strtoupper($fecah_pago)),0);
	$pdf->Cell(2, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(17, 2,utf8_decode(strtoupper('TELÉFONO:')),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(40, 2,utf8_decode(strtoupper($telf_cli)),0);

	$pdf->Ln(5);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(20, 2,utf8_decode(strtoupper('CÉDULA/RUC:')),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(80, 2,utf8_decode(strtoupper($ced_ruc_cli)),0);
	$pdf->Cell(5, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(25, 2,utf8_decode(strtoupper('PAGADO POR:')),0);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(40, 2,utf8_decode(strtoupper($usu_crea)),0); 

	$pdf->Ln(7);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(180, 14,'',1);

	

	if ($froma_pago == 3) {
		$enlace = conectarbd();
		$cad_chque = "SELECT CHE_NUM_CHUQUE, CHE_VALOR, CHE_EMITIDO_A, CHE_FECHA_COBRO, BAN_BANCCO FROM t_chques_emitidos, t_bancos WHERE CHE_FK_ID_BANCO = IDT_BANCO AND CHE_FK_ID_COMPROBANTE=".$id_comtpb;
		$ejec_cab_cheque = mysql_query($cad_chque);
		$res_chque = mysql_fetch_row($ejec_cab_cheque);

	$pdf->Ln(2);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(148, 4,utf8_decode(strtoupper('VALOR TOTAL DEL PAGO : ')),0,0,'L');
	$pdf->Cell(30, 4,$res_chque['1'].'   $$ DOLARES',0,0,'R');

	$pdf->Ln(4);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(33, 4, 'CHEQUE EMITIDO  A : ',0,0,'L');
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(50, 4, $res_chque['2'],0,0,'L') ;


	$pdf->Ln(4);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(33, 4,utf8_decode(strtoupper('NÚMERO CHEQUE : ')),0,0,'L');
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(10, 4, $res_chque['0'],0,0,'L');
	$pdf->Cell(30, 4, 'CON : '.$res_chque['4'],0,0,'L');
	$pdf->Cell(30, 4, 'EL DIA  : '.$res_chque['3'],0,0,'L');

	}else{
		$pdf->Ln(2);
		$pdf->Cell(10, 5,'',0);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(148, 4,utf8_decode(strtoupper('VALOR TOTAL DEL PAGO : ')),0,0,'L');
		$pdf->Cell(30, 4,$total_comprob.'   $$ DOLARES',0,0,'R');
	}

	$pdf->Ln(10);
	$pdf->Cell(10, 5,'',0);
	$pdf->Cell(180, 50,'',1);
	$pdf->Ln(2);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(30, 2,utf8_decode(strtoupper('DETALLE DEL PAGO Y DOCS. AFECTADOS')),0);

	$pdf->Ln(3);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(70, 5,utf8_decode(strtoupper('NÚMERO DE FACTURA./ANTI./EGRE.')),0,0,'L');
	$pdf->Cell(24, 5,utf8_decode(strtoupper('TIPO DOC.')),0,0,'L');
	$pdf->Cell(45, 5,utf8_decode(strtoupper('VALOR ABONADO')),0,0,'R');
	$pdf->Cell(40, 5,utf8_decode(strtoupper('SALDO PENDIENTE')),0,0,'R'); 
	
	$enlace = conectarbd();
	$cad_detalle_pago = "SELECT PAG_NUM_FAC_AFECTADO, PAG_VALOR, COM_SALDO, COM_TIPO_COMPR from t_pagos_factu_comp ,t_comprobante 
		where PAG_FK_ID_COMPRO_AFECTADO= IDT_COMPROBANTE AND PAG_NUM_FAC_AFECTADO= COM_NUM_COMPROB AND 
		PAG_FK_IC_CLIE_PROVEE=".$id_cliente_provee." AND PAG_FK_ID_COM_PAGO=".$id_comtpb." AND
		PAG_NUM_COMPR_PAGO='".$num_comprob."'";
	$ejec_cad_detalle_pag = mysql_query($cad_detalle_pago);
	//echo $cad_detalle_pago;
	mysql_close($enlace);
	while ($reS_detall_pag= mysql_fetch_array($ejec_cad_detalle_pag)) {
		$pdf->Ln(5);
		$pdf->Cell(10, 5,'',0);
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(75, 5,$reS_detall_pag['PAG_NUM_FAC_AFECTADO'],0,0,'L');
		$pdf->Cell(24, 5,$reS_detall_pag['COM_TIPO_COMPR'],0,0,'L');
		$pdf->Cell(40, 5,$reS_detall_pag['PAG_VALOR'],0,0,'R');
		$pdf->Cell(40, 5,$reS_detall_pag['COM_SALDO'],0,0,'R'); 
	}
	
	$pdf->Ln(45);

	$pdf->Ln(3);
	$pdf->Cell(10, 5,'',0);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(95, 5,utf8_decode(strtoupper('DETALLE ROL DE PAGO')),0,0,'L');
	$pdf->Cell(25, 5,utf8_decode(strtoupper('CODIGO')),0,0,'L');
	$pdf->Cell(25, 5,utf8_decode(strtoupper('INGRESOS')),0,0,'R');
	$pdf->Cell(25, 5,utf8_decode(strtoupper('HEGRESOS')),0,0,'R');

	$enlace = conectarbd();
	$cad_aiento = "SELECT PCU_DESCRIPCION, PCU_CUENTA, ASI_DEBE, ASI_HABER FROM t_plancuentas, t_asiento 
	WHERE ASI_FK_IDCOMPROB= ".$id_comtpb." AND ASI_CUENTA = PCU_CUENTA AND AS_ESTADO= 1";
	$ejec_cad_asienot = mysql_query($cad_aiento);
	//echo $cad_detalle_pago;
	mysql_close($enlace);
	while ($res_asiento= mysql_fetch_array($ejec_cad_asienot)) {
		$pdf->Ln(5);
		$pdf->Cell(10, 5,'',0);
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(95, 5,$res_asiento['PCU_DESCRIPCION'],0,0,'L');
		$pdf->Cell(25, 5,$res_asiento['PCU_CUENTA'],0,0,'L');
		$pdf->Cell(25, 5,$res_asiento['ASI_DEBE'],0,0,'R');
		$pdf->Cell(25, 5,$res_asiento['ASI_HABER'],0,0,'R'); 
	}

	

	$pdf->Output();

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}
 ?>