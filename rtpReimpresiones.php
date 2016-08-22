<?php 
include("lib/phpconexcion.php");
$enlace = conectar_buscadores();
$cad = $_GET['cad'];
//echo $cad;
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo ="REPORTE REIMPRESIONES.xls";

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
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);


$y=1;
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'NOMBRE / RAZON SOC.	')
	->setCellValue("B".$y,'RUC / C.I.')
	->setCellValue("C".$y,'GEN. POR.')
	->setCellValue("D".$y,'FECHA.')
	->setCellValue("E".$y,'FORMA PAGO.')
	->setCellValue("F".$y,'ESTADO PAGO.')
	->setCellValue("G".$y,'TIPO.')
	->setCellValue("H".$y,'NUM FACTURA.')
	->setCellValue("J".$y,'ESTADO.');

$objPHPExcel->getActiveSheet()
			->getStyle('A1:N1')
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
			->getStyle('A1:N1')
			->applyFromArray($borders);

$respsql=mysql_query($cad);
while ($row=mysql_fetch_array($respsql)){

	if ($row['COM_ESTADO_PAGO']==0) {
		$etiq_pag2 ="PAGADO";
	} else if ($row['COM_ESTADO_PAGO']==1) {
		$etiq_pag2 ="PENDIENTE";
	}

	if ($row['COM_ESTADO_SIS']==0) {
		$etiqEsta = "Anulado";
	} else if ($row['COM_ESTADO_SIS']==1  ){
		$etiqEsta = "ACtivo";
	}

	$y++;
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y.":F".$y.":G".$y.":H")
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit("A".$y, utf8_encode($row['CP_APELLIDO'].' '.$row['CP_NOMBRE']),PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("B".$y, $row['CP_CEDULA'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("C".$y, $row['USU_LOGER'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("D".$y, $row['COM_FEC_CREA'],PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("E".$y, $etiq_pag2,PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("F".$y, $row['TP_DESCRIPCION'] ,PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("G".$y, $row['COM_TIPO_COMPR'] ,PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("H".$y, $row['COM_NUM_COMPROB'] ,PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("J".$y, $etiqEsta ,PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("K".$y, $row['COM_TOT'] ,PHPExcel_Cell_DataType::TYPE_NUMERIC);

}
header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;


?>
