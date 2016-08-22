<?php 
require_once('lib/phpconex.php');
$enlace = conectarbd();
$cad = "SELECT BALA_EMP, BALA_CUENTA, PCU_DESCRIPCION, BALA_SALDO_INI , BALA_SALDO_FIN ,BALA_CUENTA_AUX
	FROM t_balance_aux, t_plancuentas where BALA_CUENTA= PCU_CUENTA order by BALA_EMP asc,BALA_CUENTA asc ";

//date_default_timezone_set('American/Ecuador');
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo ="BALANCE POR EMPRESA.xls";

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
while ($row=mysql_fetch_array($respsql)) {

	$filaE = '';
	$filaF = '';
	$filaG = '';
	$filaH = '';
	$filaI = '';
	$filaJ = '';
	/*echo  $row['BALA_CUENTA_AUX']; */

	if (strlen ($row['BALA_CUENTA_AUX']) == 1) {
		$filaJ = $row['BALA_SALDO_FIN'];
	} else if (strlen($row['BALA_CUENTA_AUX']) == 2) {
		$filaI = $row['BALA_SALDO_FIN'];
	} else if (strlen($row['BALA_CUENTA_AUX']) == 3) {
		$filaH = $row['BALA_SALDO_FIN'];
	} else if (strlen($row['BALA_CUENTA_AUX']) == 4) {
		$filaG = $row['BALA_SALDO_FIN'];
	} else if (strlen($row['BALA_CUENTA_AUX']) == 5) {
		$filaF = $row['BALA_SALDO_FIN'];
	} else  {
		$filaE = $row['BALA_SALDO_FIN'];
	}


	$y++;
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y)
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit("A".$y, $row['BALA_EMP'],PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("B".$y, $row['BALA_CUENTA'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("C".$y, utf8_encode($row['PCU_DESCRIPCION']),PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("D".$y, $row['BALA_SALDO_INI'],PHPExcel_Cell_DataType::TYPE_NUMERIC)	
	->setCellValueExplicit("E".$y, $filaE,PHPExcel_Cell_DataType::TYPE_NUMERIC)	
	->setCellValueExplicit("F".$y, $filaF,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("G".$y, $filaG,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("H".$y, $filaH,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("I".$y, $filaI,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("J".$y, $filaJ,PHPExcel_Cell_DataType::TYPE_NUMERIC);		

}
header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 ?>