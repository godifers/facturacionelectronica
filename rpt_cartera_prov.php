<?php 
require("lib/phpconexcion.php");
$enlace = conectar_buscadores();

$cad = "SELECT * FROM t_comprobante, t_client_provee,t_asiento where IDT_CLIENT_PROVEE = COM_FKID_CLI_PROV 
	and ASI_FK_IDCOMPROB= IDT_COMPROBANTE
	AND COM_ESTADO_SIS = 1 	AND COM_ESTADO_PAGO=1 and ASI_CUENTA = '2.1.1.01.01'
	ORDER BY CP_APELLIDO asc , CP_NOMBRE asc, COM_NUM_COMPROB asc";

require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo ="CARTERA PORVEE ".date('y/M/d').".xls";

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
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);


$y=1;
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'NUM')
	->setCellValue("B".$y,'CLIENTE')
	->setCellValue("C".$y,'TIPO')
	->setCellValue("D".$y,'NUMERO')
	->setCellValue("E".$y,'FECHA')
	->setCellValue("F".$y,'DEBE')
	->setCellValue("G".$y,'HABER')
	->setCellValue("H".$y,'SALDO');

$objPHPExcel->getActiveSheet()
			->getStyle('A1:H1')
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
			->getStyle('A1:H1')
			->applyFromArray($borders);

$respsql=mysql_query($cad);
$icont=1;
while ($row=mysql_fetch_array($respsql)) {

	$y++;
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y.":F".$y.":G".$y.":H")
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit("A".$y, $icont,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("B".$y, utf8_encode($row['CP_NOMBRE'].' '.$row['CP_APELLIDO']),PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("C".$y, $row['COM_TIPO_COMPR'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("D".$y, $row['COM_NUM_COMPROB'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("E".$y, $row['COM_FEC_CREA'],PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("F".$y, $row['ASI_DEBE'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("G".$y, $row['ASI_HABER'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("H".$y, $row['COM_SALDO'],PHPExcel_Cell_DataType::TYPE_NUMERIC)	;
	$icont++;		

}

header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 ?>