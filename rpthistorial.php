<?php 
require_once('lib/phpconex.php');
$enlace = conectarbd();
$cad = $_GET['cadena'];
$emp = $_GET['emp'];
$cod_prod =$_GET['cod_prod'];

//date_default_timezone_set('American/Ecuador');
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo ="Reporte_Historial.xls";

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
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('j')->setWidth(10);

$y=1;
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'PRODUCTO')
	->setCellValue("B".$y,'COD. PROD')
	->setCellValue("C".$y,'CLINTE/PROVEE')
	->setCellValue("D".$y,'TIPO DOC.')
	->setCellValue("E".$y,'FECHA COMPROB.')
	->setCellValue("F".$y,'N° COMPROB.')
	->setCellValue("G".$y,'V.UNIT')
	->setCellValue("H".$y,'V.TOTAL')
	->setCellValue("I".$y,'CANT.')
	->setCellValue("J".$y,'SALDOS');
	
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
			->getStyle('A1:I1')
			->applyFromArray($borders);

$y=2;
$cad_stock_ini = "SELECT INI_STOK_INI FROM t_invetario_inicial where INI_EMPRESA= ".$emp." and INI_FK_COD_PROD='".$cod_prod."';";
$ejec_cad_stock = mysql_query($cad_stock_ini);
//echo $cad_stock_ini ;
mysql_close($enlace);
$res_stock_ini = mysql_fetch_row($ejec_cad_stock);
$val_ini = $res_stock_ini[0];
if ($val_ini == '' or is_null($val_ini) ) {
	$val_ini = 0;
} else {
	$val_ini = $val_ini;
}


$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'')
	->setCellValue("B".$y,'')
	->setCellValue("C".$y,'')
	->setCellValue("D".$y,'.')
	->setCellValue("E".$y,'')
	->setCellValue("F".$y,'')
	->setCellValue("G".$y,'')
	->setCellValue("H".$y,'')
	->setCellValue("I".$y,'SALDO INI')
	->setCellValue("J".$y, $val_ini);

//$consql="SELECT CP_NOMBRE, CP_CEDULA  FROM t_client_provee;";
$enlace = conectarbd();
$respsql=mysql_query($cad);
mysql_close($enlace);

while ($row=mysql_fetch_array($respsql)) 
{	
	$y++;
	if ($row['COM_TIPO_COMPR']=='V' or $row['COM_TIPO_COMPR']=='G' or $row['COM_TIPO_COMPR']=='M' or $row['COM_TIPO_COMPR']=='W' or $row['COM_TIPO_COMPR']=='X') {
		$can_act = $row['DET_CANTIDAD'] *(-1);
	} else {
		$can_act = $row['DET_CANTIDAD'] ;
	} 
	$val_ini =  $val_ini + $can_act;
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y.":F".$y.":G".$y.":H".$y.":I".$y)
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit("A".$y, $row['PR_DETALLE'],PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("B".$y, $row['PR_PRESENTACION'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("C".$y, utf8_encode($row['CP_NOMBRE'])."".utf8_encode($row['CP_APELLIDO']),PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("D".$y, $row['COM_TIPO_COMPR'],PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("E".$y, $row['COM_FEC_CREA'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("F".$y, $row['COM_NUM_COMPROB'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("G".$y, $row['DET_VAL_UNIT'],PHPExcel_Cell_DataType::TYPE_NUMERIC)	
	->setCellValueExplicit("H".$y, $row['DET_VAL_TOT'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("I".$y, $can_act ,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("J".$y, $val_ini ,PHPExcel_Cell_DataType::TYPE_NUMERIC);	
}
$y= $y +1;
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'')
	->setCellValue("B".$y,'')
	->setCellValue("C".$y,'')
	->setCellValue("D".$y,'.')
	->setCellValue("E".$y,'')
	->setCellValue("F".$y,'')
	->setCellValue("G".$y,'')
	->setCellValue("H".$y,'')
	->setCellValue("I".$y,'SALDO FIN')
	->setCellValue("J".$y, $val_ini);

header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 ?>