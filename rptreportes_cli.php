<?php 
require_once('lib/phpconex.php');
$enlace = conectarbd();

//date_default_timezone_set('American/Ecuador');
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo ="LISTA_CLIENTES.xls";

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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

$y=1;
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'Nombres')
	->setCellValue("B".$y, 'N° Cedula');

$objPHPExcel->getActiveSheet()
			->getStyle('A1:B1')
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
			->getStyle('A1:B1')
			->applyFromArray($borders);


$consql="SELECT CP_NOMBRE, CP_CEDULA  FROM t_client_provee;";
$respsql=mysql_query($consql);
mysql_close($enlace);
while ($row=mysql_fetch_array($respsql)) 
{
	$y++;
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$y.":B".$y)
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y, utf8_encode($row['CP_NOMBRE']))
	->setCellValueExplicit("B".$y, $row['CP_CEDULA'],PHPExcel_Cell_DataType::TYPE_STRING);		

}
header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 ?>
