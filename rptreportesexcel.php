<?php 
require_once('lib/phpconexcion.php');
$enlace = $enlace = conectar_buscadores();
$cad = $_GET['cadena'];

//date_default_timezone_set('American/Ecuador');
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo ="REPORTE COMPROBANTES.xls";

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
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(50);


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
	->setCellValue("J".$y,'TOTAL')
	->setCellValue("K".$y,'Estado')
	->setCellValue("L".$y,'Est. Sis')
	->setCellValue("M".$y,'Autoriz. SRI')
	->setCellValue("N".$y,'Doc. Afectado.')
	->setCellValue("O".$y,'Detalle.');

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


//$consql="SELECT CP_NOMBRE, CP_CEDULA  FROM t_client_provee;";
$respsql=mysql_query($cad);
//mysql_close($enlace);
while ($row=mysql_fetch_array($respsql)) 
{
	$cadDetGa = "SELECT DETG_DESCRIPCION FROM t_detalle_gasto WHERE  DETG_FK_ID_COMPR = ".$row['IDT_COMPROBANTE']. " ORDER BY IDT_DETALLE_GASTO ASC ";
	$ejecCadDet = mysql_query($cadDetGa);
	//echo $cadDetGa;
	//mysql_close($enlace);
	$resDetGas = mysql_fetch_row($ejecCadDet);
	$res = $resDetGas['0'];
	
if ($row['COM_ESTADO_PAGO']==0) {
	$etiqpago='Pagado';
} else {
	$etiqpago='Pendiente';
}	
if ($row['COM_ESTADO_SIS']==0) {
	$estadosis='Anulado';
	$var_subt = 0.00;
	$var_b0 = 0.00;
	$var_b12 = 0.00;
	$var_iva = 0.00;
	$total = 0.00;

} else {
	$estadosis='Activo';
	$var_subt = $row['COM_VAL_SUBT'];
	$var_b0 = $row['COM_VAL_BASE0'];
	$var_b12 = $row['COM_VAL_BASE12'];
	$var_iva = $row['COM_IVA'];
	$total = $row['COM_TOT'];
}
	$y++;
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y.":F".$y.":G".$y.":H".$y.":I".$y.":J".$y.":K".$y.":L".$y)
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit("A".$y, utf8_encode($row['CP_APELLIDO'].' '.$row['CP_NOMBRE']),PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("B".$y, $row['CP_CEDULA'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("C".$y, $row['COM_TIPO_COMPR'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("D".$y, $row['COM_FEC_CREA'],PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("E".$y, $row['COM_NUM_COMPROB'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("F".$y, $var_subt ,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("G".$y, $var_b0 ,PHPExcel_Cell_DataType::TYPE_NUMERIC)	
	->setCellValueExplicit("H".$y, $var_b12 ,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("I".$y, $var_iva  ,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("J".$y, $var_iva  ,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("K".$y, $etiqpago,PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("L".$y, $estadosis,PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("M".$y, $row['COM_AUTORIZACION_SRI'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("N".$y, $row['COM_DOCAFECTADO'],PHPExcel_Cell_DataType::TYPE_STRING)
	
	//$enlace = conectar_buscadores();	 
	->setCellValueExplicit("O".$y, $res,PHPExcel_Cell_DataType::TYPE_STRING);

}
header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 ?>