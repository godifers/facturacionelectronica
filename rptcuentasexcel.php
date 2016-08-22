<?php 
require_once('lib/phpconex.php');
$enlace = conectarbd();
$cad = $_GET['cadena'];
$cuenta = $_GET['cuenta'];
$fecha_ini = $_GET['fecha_ini'];
$emp = $_GET['emp'];
$identfic = $_GET['identfic'];

if ($identfic ==1) {
	$title = "ReporteMOVCuentas".date('YMd').".xls";
} else {
	$title = "MayorPorCuenta".date('YMd').".xls";
}

//date_default_timezone_set('American/Ecuador');
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo =$title;

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
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

$y=1;
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'NOMBRES Y APELLIDOS')
	->setCellValue("B".$y,'CEDULA')
	->setCellValue("C".$y,'N° COMPROBANTE')
	->setCellValue("D".$y,'TIPO COMPROB.')
	->setCellValue("E".$y,'PUNTO DE VENTA')
	->setCellValue("F".$y,'FECHA COMPROB.')
	->setCellValue("G".$y,'DEBE')
	->setCellValue("H".$y,'HABER')
	->setCellValue("I".$y,'SALDOS');
	

$objPHPExcel->getActiveSheet()
			->getStyle('A1:I1')
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

$y=$y+1;

	
	if ($identfic == 1) {
		$cad_query_saldos ="CALL SP_SUMAR_CUENTA_BAL ('".$cuenta."',".$emp.",'".$fecha_ini ."' )";
		//echo $cad_query_saldos;
		$ejec_cad_saldos = mysql_query($cad_query_saldos);
		$res_query_saldos = mysql_fetch_row($ejec_cad_saldos);
		$saldo_fin  = $res_query_saldos[0];
		$fecha_cort  = $res_query_saldos[1];
		mysql_close($enlace);
	} else {
		$enlace = conectarbd();
	
		$cad_query_saldos ="CALL SP_SUMAR_CUENTA_BAL ('".$cuenta."',1,'".$fecha_ini ."' )";
		//echo $cad_query_saldos .'<br>';
		$ejec_cad_saldos = mysql_query($cad_query_saldos);
		$res_query_saldos = mysql_fetch_row($ejec_cad_saldos);
		$saldo_fin  = $res_query_saldos[0];
		$fecha_cort  = $res_query_saldos[1];
		mysql_close($enlace);

		$enlace = conectarbd();
		$cad_query_saldos2 ="CALL SP_SUMAR_CUENTA_BAL ('".$cuenta."',2,'".$fecha_ini ."' )";
		//echo $cad_query_saldos2;
		$ejec_cad_saldos2 = mysql_query($cad_query_saldos2);
		$res_query_saldos2 = mysql_fetch_row($ejec_cad_saldos2);
		$saldo_fin2  = $res_query_saldos2[0];
		$fecha_cort2  = $res_query_saldos2[1];
		mysql_close($enlace);

		$saldo_tot = $saldo_fin + $saldo_fin2;
		$saldo_fin  = $saldo_tot ;

	}
	
	

$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'')
	->setCellValue("B".$y,'')
	->setCellValue("C".$y,'')
	->setCellValue("D".$y,'')
	->setCellValue("E".$y,'')
	->setCellValue("F".$y,'')
	->setCellValue("G".$y,'')
	->setCellValue("H".$y,'')
	->setCellValueExplicit("I".$y, $saldo_fin,PHPExcel_Cell_DataType::TYPE_NUMERIC);	


$objPHPExcel->getActiveSheet()
			->getStyle('A1:I1')
			->applyFromArray($borders);


//$consql="SELECT CP_NOMBRE, CP_CEDULA  FROM t_client_provee;";
$enlace = conectarbd();
$respsql=mysql_query($cad);
mysql_close($enlace);
while ($row=mysql_fetch_array($respsql)) 
{
	$saldo_fin =   $saldo_fin + $row['ASI_DEBE'] - $row['ASI_HABER'];
	$y++;
	//if ($identfic == 1) {
		if ($row['COM_EPRESA']==1) {
			$objPHPExcel->setActiveSheetIndex(0)
			->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y.":F".$y.":G".$y.":H".$y.":I".$y)
			->applyFromArray($borders);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueExplicit("A".$y, utf8_encode($row['CP_APELLIDO'])."".utf8_encode($row['CP_NOMBRE']),PHPExcel_Cell_DataType::TYPE_STRING)	
			->setCellValueExplicit("B".$y, $row['CP_CEDULA'],PHPExcel_Cell_DataType::TYPE_STRING)
			->setCellValueExplicit("C".$y, $row['COM_NUM_COMPROB'],PHPExcel_Cell_DataType::TYPE_STRING)
			->setCellValueExplicit("D".$y, $row['COM_TIPO_COMPR'],PHPExcel_Cell_DataType::TYPE_STRING)
			->setCellValueExplicit("E".$y, 'TULCAN',PHPExcel_Cell_DataType::TYPE_STRING)
			->setCellValueExplicit("F".$y, $row['COM_FEC_CREA'],PHPExcel_Cell_DataType::TYPE_STRING)	
			->setCellValueExplicit("G".$y, $row['ASI_DEBE'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
			->setCellValueExplicit("H".$y, $row['ASI_HABER'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
			->setCellValueExplicit("I".$y, $saldo_fin,PHPExcel_Cell_DataType::TYPE_NUMERIC);

			$objPHPExcel->getActiveSheet()
			->getStyle('E'.$y.':E'.$y)
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('#71B9D5');
		} else {
			$objPHPExcel->setActiveSheetIndex(0)
			->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y.":F".$y.":G".$y.":H".$y)
			->applyFromArray($borders);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueExplicit("A".$y, utf8_encode($row['CP_NOMBRE'])."".utf8_encode($row['CP_APELLIDO']),PHPExcel_Cell_DataType::TYPE_STRING)	
			->setCellValueExplicit("B".$y, $row['CP_CEDULA'],PHPExcel_Cell_DataType::TYPE_STRING)
			->setCellValueExplicit("C".$y, $row['COM_NUM_COMPROB'],PHPExcel_Cell_DataType::TYPE_STRING)
			->setCellValueExplicit("D".$y, $row['COM_TIPO_COMPR'],PHPExcel_Cell_DataType::TYPE_STRING)
			->setCellValueExplicit("E".$y, 'SAN GA',PHPExcel_Cell_DataType::TYPE_STRING)
			->setCellValueExplicit("F".$y, $row['COM_FEC_CREA'],PHPExcel_Cell_DataType::TYPE_STRING)	
			->setCellValueExplicit("G".$y, $row['ASI_DEBE'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
			->setCellValueExplicit("H".$y, $row['ASI_HABER'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
			->setCellValueExplicit("I".$y, $saldo_fin,PHPExcel_Cell_DataType::TYPE_NUMERIC);

			$objPHPExcel->getActiveSheet()
			->getStyle('E'.$y.':E'.$y)
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()->setARGB('#DFBA77');
		}
		
	//}
	
	

}
header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 ?>