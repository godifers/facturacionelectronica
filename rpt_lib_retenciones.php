<?php 
require_once('lib/phpconex.php');
$enlace = conectarbd();
$var_fech_ini = $_GET['f1'];
$var_fech_fin = $_GET['f2'];
$identificador = $_GET['indent'];

if ($identificador == 1) {
	
	$cad="SELECT VALR_COD_RET AS codRet,'CUENTA' AS descCuenta,  VALR_BASE_IMP as baseImp, VALR_PORCENT as porcent, VALR_VAL_RET as valRet, 
		VALR_NUM_RET as numReten, VALR_NUMFACT as numFact, CP_NOMBRE as nomProve , CP_APELLIDO as apeProvee, 
		COM_AUTORIZACION_SRI as autoriRet, CP_CEDULA as cedula , COM_FEC_CREA as fechaCrea
		from t_val_retenciones, t_comprobante, t_client_provee 
		where IDT_COMPROBANTE = VALR_IDT_RETENCION and VALR_ESTADO = 1 and COM_ESTADO_SIS =1 
		and VALR_FK_IDCLIPROV = IDT_CLIENT_PROVEE and (VALR_FECHA_ENV BETWEEN '".$var_fech_ini."' and '".$var_fech_fin."') 
		union all 
		SELECT '332' AS codRet, PCU_DESCRIPCION AS descCuenta, COM_VAL_SUBT as baseImp, 0 as porcent, 0 as valRet,
		'SIN/RET' as numReten, COM_NUM_COMPROB as numFact, CP_APELLIDO as nomProve, CP_NOMBRE as apeProvee,
		'SIN/AUTORIZA' as autoriRet , CP_CEDULA as cedula, COM_FEC_CREA as fechaCrea
		FROM t_client_provee, t_comprobante, t_asiento,t_plancuentas where COM_ESTADO_SIS= 1 and ASI_CUENTA='2.1.3.01.24' and IDT_COMPROBANTE= ASI_FK_IDCOMPROB 
		and COM_FKID_CLI_PROV= IDT_CLIENT_PROVEE and ASI_CUENTA= PCU_CUENTA 
		and PCU_EMPRESA =1 and (COM_FEC_CREA BETWEEN '".$var_fech_ini."' and '".$var_fech_fin."') order by codRet";
	require_once"PHPExcel.php";
	require_once"PHPExcel/IOFactory.php";

	$objPHPExcel = new PHPExcel();
	$archivo ="LIBRO RET ".date('Y/M/d').".xls";

	$objPHPExcel->getProperties()->setCreator("weblocalhost")
		->setLastModifiedBy("weblocalhost")
		->setTitle("Reporte XLS")
		->setSubject("Reporte")
		->setDescription("")
		->setKeywords("")
		->setCategory("");

	$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(40);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(40);

	$y=1;
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A".$y,'CUENTA.')
		->setCellValue("B".$y,'COD RET.')
		->setCellValue("C".$y,'BASE IMP.')
		->setCellValue("D".$y,'%.')
		->setCellValue("E".$y,'VAL. RET.')
		->setCellValue("F".$y,'No. RETENCION.')
		->setCellValue("G".$y,'No. FACTURA.')
		->setCellValue("H".$y,'AUTORIZACION.')
		->setCellValue("I".$y,'TERCERO.')
		->setCellValue("J".$y,'RUC.')
		->setCellValue("K".$y,'FECHA.');
	$objPHPExcel->getActiveSheet()
				->getStyle('A1:K1')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()->setARGB('FFEEEEEEE');

		$borders = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF0000000'),
				) 
			), 
		);

	$objPHPExcel->getActiveSheet()
				->getStyle('A1:K1')
				->applyFromArray($borders);


	//$consql="SELECT CP_NOMBRE, CP_CEDULA  FROM t_client_provee;";
	$respsql=mysql_query($cad);
	mysql_close($enlace);
	while ($row=mysql_fetch_array($respsql)) {

		$y++;
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y.":F".$y.":G".$y.":H".$y.":I".$y)
		->applyFromArray($borders);
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit("A".$y, $row['descCuenta'],PHPExcel_Cell_DataType::TYPE_STRING)	
		->setCellValueExplicit("B".$y, $row['codRet'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit("C".$y, $row['baseImp'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit("D".$y, $row['porcent'],PHPExcel_Cell_DataType::TYPE_NUMERIC)	
		->setCellValueExplicit("E".$y, $row['valRet'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit("F".$y, $row['numReten'],PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit("G".$y, $row['numFact'],PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit("H".$y, utf8_encode($row['autoriRet']),PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit("I".$y, utf8_encode($row['nomProve'].' '.$row['apeProvee']),PHPExcel_Cell_DataType::TYPE_STRING)	
		->setCellValueExplicit("J".$y, utf8_encode($row['cedula']),PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit("K".$y, utf8_encode($row['fechaCrea']),PHPExcel_Cell_DataType::TYPE_STRING)
		;

	}
	header('Content-Type: aplication/vnd.ms-excel');
	header('Content-Disposition:attachment;filename="'.$archivo.'"');
	header('Cache-Control: max-age=0');
	$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');

	exit;
} else if($identificador == 2) {
	$cad="SELECT VALR_COD_RET AS codRet,'CUENTA' AS descCuenta,  sum(VALR_BASE_IMP) as baseImp, VALR_PORCENT as porcent, sum(VALR_VAL_RET) as valRet, count(VALR_NUMFACT) as numFact
		from t_val_retenciones, t_comprobante, t_client_provee 
		where IDT_COMPROBANTE = VALR_IDT_RETENCION and VALR_ESTADO = 1 and COM_ESTADO_SIS =1 
		and VALR_FK_IDCLIPROV = IDT_CLIENT_PROVEE and (VALR_FECHA_ENV BETWEEN '".$var_fech_ini."' and '".$var_fech_fin."') group by  codRet
		union all 
		SELECT '332' AS codRet, PCU_DESCRIPCION AS descCuenta, sum(COM_VAL_SUBT) as baseImp, 0 as porcent, Sum(0) as valRet, count(COM_NUM_COMPROB) as numFact
		FROM t_client_provee, t_comprobante, t_asiento,t_plancuentas where COM_ESTADO_SIS= 1 and ASI_CUENTA='2.1.3.01.24' and IDT_COMPROBANTE= ASI_FK_IDCOMPROB 
		and COM_FKID_CLI_PROV= IDT_CLIENT_PROVEE and ASI_CUENTA= PCU_CUENTA 
		and PCU_EMPRESA =1 and (COM_FEC_CREA between '".$var_fech_ini."' and '".$var_fech_fin."') group by  codRet";
	
	require_once"PHPExcel.php";
	require_once"PHPExcel/IOFactory.php";

	$objPHPExcel = new PHPExcel();
	$archivo ="RESUMEN DE RETENCIONES".date('Y/M/d').".xls";

	$objPHPExcel->getProperties()->setCreator("weblocalhost")
		->setLastModifiedBy("weblocalhost")
		->setTitle("Reporte XLS")
		->setSubject("Reporte")
		->setDescription("")
		->setKeywords("")
		->setCategory("");

	$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Narrow');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);



	$y=1;
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue("A".$y,'EMPRESA.')
		->setCellValue("B".$y,'COD RET.')
		->setCellValue("C".$y,'BASE IMP.')
		->setCellValue("D".$y,'%.')
		->setCellValue("E".$y,'VAL. RET.')
		->setCellValue("F".$y,'CANTIDAD DE FATURAS.');

	$objPHPExcel->getActiveSheet()
				->getStyle('A1:E1')
				->getFill()
				->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()->setARGB('FFEEEEEEE');

	$objPHPExcel->getActiveSheet()
				->getStyle('A1:E1')
				->applyFromArray($borders);


	//$consql="SELECT CP_NOMBRE, CP_CEDULA  FROM t_client_provee;";
	$respsql=mysql_query($cad);
	mysql_close($enlace);
	while ($row=mysql_fetch_array($respsql)) {

		$y++;
		$objPHPExcel->setActiveSheetIndex(0)
		->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y)
		->applyFromArray($borders);
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit("A".$y, $row['descCuenta'],PHPExcel_Cell_DataType::TYPE_STRING)	
		->setCellValueExplicit("B".$y, $row['codRet'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit("C".$y, $row['baseImp'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit("D".$y, $row['porcent'],PHPExcel_Cell_DataType::TYPE_NUMERIC)	
		->setCellValueExplicit("E".$y, $row['valRet'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit("F".$y, $row['numFact'],PHPExcel_Cell_DataType::TYPE_NUMERIC);

	}
	header('Content-Type: aplication/vnd.ms-excel');
	header('Content-Disposition:attachment;filename="'.$archivo.'"');
	header('Cache-Control: max-age=0');
	$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');

	exit;

}
 ?>