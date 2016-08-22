<?php 
require_once('lib/phpconex.php');
$enlace = conectarbd();
$cad = $_GET['cadena'];

//date_default_timezone_set('American/Ecuador');
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo ="CARTERA UNITARIA.xls";

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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

$y=1;
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'NOMBRES Y APELLIDOS')
	->setCellValue("B".$y,'N° COMPROBANTE')
	->setCellValue("C".$y,'TIPO COMPROB')
	->setCellValue("D".$y,'TOTAL')
	->setCellValue("E".$y,'ABONO')
	->setCellValue("F".$y,'SALDO');

$objPHPExcel->getActiveSheet()
			->getStyle('A1:F1')
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
			->getStyle('A1:F1')
			->applyFromArray($borders);

//SELECT * FROM t_comprobante, t_client_provee where COM_ESTADO_SIS=1 AND COM_FKID_CLI_PROV=IDT_CLIENT_PROVEE and COM_FKID_CLI_PROV=1897 and COM_ESTADO_PAGO=1

$respsql=mysql_query($cad);
mysql_close($enlace);
while ($row=mysql_fetch_array($respsql)) 
{
	$y++;
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y.":F".$y)
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit("A".$y, utf8_encode($row['CP_NOMBRE'])."".utf8_encode($row['CP_APELLIDO']),PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("B".$y, $row['COM_NUM_COMPROB'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("C".$y, $row['COM_TIPO_COMPR'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("D".$y, $row['COM_TOT'],PHPExcel_Cell_DataType::TYPE_NUMERIC)	
	->setCellValueExplicit("E".$y, $row['COM_ABONO'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("F".$y, $row['COM_SALDO'],PHPExcel_Cell_DataType::TYPE_NUMERIC);	

}
header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 ?>
