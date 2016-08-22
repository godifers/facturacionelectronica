<?php 
require_once('lib/phpconex.php');
$enlace = conectarbd();
$emp = $_GET['emp'];
$cad = "SELECT * FROM t_comprobante, t_client_provee , t_asiento
	where IDT_CLIENT_PROVEE = COM_FKID_CLI_PROV and COM_ESTADO_SIS=1 AND COM_ESTADO_PAGO=1 and 
	ASI_FK_IDCOMPROB= IDT_COMPROBANTE and (ASI_CUENTA='1.1.2.01.01' OR ASI_CUENTA='2.3.1.01')
	AND COM_EPRESA=".$emp." ORDER BY COM_TIPO_COMPR desc, CP_APELLIDO asc , CP_NOMBRE asc, COM_NUM_COMPROB asc";

//date_default_timezone_set('American/Ecuador');
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo ="CARTERA.xls";

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
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);


$y=1;
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'Razón Social')
	->setCellValue("B".$y,'RUC/C.I.')
	->setCellValue("C".$y,'Tipo Doc.')
	->setCellValue("D".$y,'Fecha')
	->setCellValue("E".$y,'N° Doc.')
	->setCellValue("F".$y,'Subtotal')
	->setCellValue("G".$y,'Base 0')
	->setCellValue("H".$y,'Base 12')
	->setCellValue("I".$y,'IVA')
	->setCellValue("J".$y,'PAGO')
	->setCellValue("K".$y,'Est. Sis')
	->setCellValue("L".$y,'ABONADO')
	->setCellValue("M".$y,'SALDO');

$objPHPExcel->getActiveSheet()
			->getStyle('A1:M1')
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
			->getStyle('A1:M1')
			->applyFromArray($borders);


//$consql="SELECT CP_NOMBRE, CP_CEDULA  FROM t_client_provee;";
$respsql=mysql_query($cad);
mysql_close($enlace);
while ($row=mysql_fetch_array($respsql)) {
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

if ($row['ASI_CUENTA'] == '1.1.2.01.01') {
	$val = $row['COM_SALDO'];
} else {
	$val = '-'.$row['COM_SALDO'];
}
	$y++;
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y.":F".$y.":G".$y.":H".$y.":I".$y.":J".$y.":K".$y.":L".$y.":M".$y)
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit("A".$y, utf8_decode($row['CP_APELLIDO'].' '.$row['CP_NOMBRE']),PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("B".$y, $row['CP_CEDULA'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("C".$y, $row['COM_TIPO_COMPR'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("D".$y, $row['COM_FEC_CREA'],PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("E".$y, $row['COM_NUM_COMPROB'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("F".$y, $row['COM_VAL_SUBT'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("G".$y, $row['COM_VAL_BASE0'],PHPExcel_Cell_DataType::TYPE_NUMERIC)	
	->setCellValueExplicit("H".$y, $row['COM_VAL_BASE12'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("I".$y, $row['COM_IVA'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("J".$y, $etiqpago,PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("K".$y, $estadosis,PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("L".$y, $row['COM_ABONO'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("M".$y, $val,PHPExcel_Cell_DataType::TYPE_NUMERIC);		
	if ($row['ASI_CUENTA']=='2.3.1.01') {
		$objPHPExcel->getActiveSheet()
			->getStyle('L'.$y.':L'.$y.'')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('FFEEOOOOO');
	}

}
header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 ?>