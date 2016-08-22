<?php 
require_once('lib/phpconex.php');
$enlace = conectarbd();
$cad = $_GET['cadena'];

//date_default_timezone_set('American/Ecuador');
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo ="Reportesexcel.xls";

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
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);


$y=1;
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'Razón Social')
	->setCellValue("B".$y,'RUC/C.I.')
	->setCellValue("C".$y,'Tipo Doc.')
	->setCellValue("D".$y,'Fecha')
	->setCellValue("E".$y,'N° Doc.')
	->setCellValue("F".$y,'Subtotal');

$objPHPExcel->getActiveSheet()
			->getStyle('A1:L1')
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
			->getStyle('A1:L1')
			->applyFromArray($borders);


//$consql="SELECT CP_NOMBRE, CP_CEDULA  FROM t_client_provee;";
$respsql=mysql_query($cad);
mysql_close($enlace);
while ($row=mysql_fetch_array($respsql)) 

{
if ($row['COM_ESTADO_PAGO']==0) {
	$etiqpago='Pagado';
} else {
	$etiqpago='Pendiente';
}	
if ($row['COM_ESTADO_SIS']==0) {
	$estadosis='Anulado';
} else {
	$estadosis='Activo';
}
	$y++;
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y.":F".$y)
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit("A".$y, $row['IDT_CLIENT_PROVEE'],PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("B".$y, $row['COM_NUM_COMPROB'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("C".$y, 'kkkkk',PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("D".$y, $row['COM_FKID_CLI_PROV_ced'],PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("E".$y, $row['COM_SALDO'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("F".$y, $row['COM_FEC_CREA'],PHPExcel_Cell_DataType::TYPE_STRING);		

}
header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 ?>