<?php 
require_once('lib/phpconex.php');
//$enlace = conectar_buscadores();
$enlace = conectarbd();
$cad = "SELECT BALAG_EMP, BALAG_CUENTA, PCU_DESCRIPCION, BALAG_SALDO_INI , BALAG_SALDO_FIN , BALAG_CUENTA_AUX
	FROM t_balance_gen_aux, t_plancuentas where BALAG_CUENTA= PCU_CUENTA order by BALAG_EMP asc, BALAG_CUENTA asc ";

//date_default_timezone_set('American/Ecuador');
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo ="BALANCE GENERAL.xls";

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
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);


$y=1;
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'EMPRESA.')
	->setCellValue("B".$y,'CUENTA.')
	->setCellValue("C".$y,'DESCRIPCION.')
	->setCellValue("D".$y,'SALDO INI.')
	->setCellValue("E".$y,'SALDO FIN.')
	->setCellValue("F".$y,'SALDO FIN.')
	->setCellValue("G".$y,'SALDO FIN.')
	->setCellValue("H".$y,'SALDO FIN.')
	->setCellValue("I".$y,'SALDO FIN.')
	->setCellValue("J".$y,'SALDO FIN.');

$objPHPExcel->getActiveSheet()
			->getStyle('A1:J1')
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
			->getStyle('A1:J1')
			->applyFromArray($borders);


//$consql="SELECT CP_NOMBRE, CP_CEDULA  FROM t_client_provee;";
$respsql=mysql_query($cad);
mysql_close($enlace);

/*$cadMaxLength= "SELECT MAX(length(BALAG_CUENTA_AUX)) FROM t_balance_gen_aux";
$ejecCadMax = mysql_query($cadMaxLength);
$resCadMax = mysql_fetch_row($ejecCadMax);
$longitud = $resCadMax['0'];*/

while ($row = mysql_fetch_array($respsql)) {

	$filaE = '';
	$filaF = '';
	$filaG = '';
	$filaH = '';
	$filaI = '';
	$filaJ = '';
	/*echo  $row['BALAG_CUENTA_AUX']; */

	if (strlen ($row['BALAG_CUENTA_AUX']) == 1) {
		$filaJ = $row['BALAG_SALDO_FIN'];
		//$color  = "FFF";
	} else if (strlen($row['BALAG_CUENTA_AUX']) == 2) {
		$filaI = $row['BALAG_SALDO_FIN'];
		//$color  = "FFEEEEEEE";
	} else if (strlen($row['BALAG_CUENTA_AUX']) == 3) {
		$filaH = $row['BALAG_SALDO_FIN'];
		//$color  = "FFEEEEEEE";
	} else if (strlen($row['BALAG_CUENTA_AUX']) == 4) {
		$filaG = $row['BALAG_SALDO_FIN'];
		//$color  = "FFEEEEEEE";
	} else if (strlen($row['BALAG_CUENTA_AUX']) == 5) {
		$filaF = $row['BALAG_SALDO_FIN'];
		//$color  = "FFEEEEEEE";
	} else  {
		$filaE = $row['BALAG_SALDO_FIN'];
		//$color = "FFEEEEEEE";
	}

	$y++;
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y.":F".$y.":G".$y.":H".$y.":I".$y.":J".$y)
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit("A".$y, $row['BALAG_EMP'],PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("B".$y, $row['BALAG_CUENTA'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("C".$y, utf8_decode($row['PCU_DESCRIPCION']),PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("D".$y, $row['BALAG_SALDO_INI'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("E".$y, $filaE,PHPExcel_Cell_DataType::TYPE_NUMERIC)	
	->setCellValueExplicit("F".$y, $filaF,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("G".$y, $filaG,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("H".$y, $filaH,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("I".$y, $filaI,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("J".$y, $filaJ,PHPExcel_Cell_DataType::TYPE_NUMERIC);

/*	$objPHPExcel->getActiveSheet()
			->getStyle('A'.$y.':J'.$y.'')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB($color);*/

	$objPHPExcel->getActiveSheet()
			->getStyle('D'.$y)
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('FFEEEEEEE');

}
header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 ?>