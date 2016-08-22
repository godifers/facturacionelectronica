<?php 
include("lib/phpconexcion.php");
$enlace = conectar_buscadores();
$cad = "SELECT LMY_CUENTA,PCU_DESCRIPCION,LMY_FEHA,LMY_SAL_INI,LMY_TOT_DEBE,LMY_TOT_HABER, LMY_SALDO_FIN 
FROM t_libromayor, t_plancuentas where LMY_CUENTA= PCU_CUENTA order by PCU_CUENTA;";
$ejeCadLibMay = mysql_query($cad);

//date_default_timezone_set('American/Ecuador');
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo ="LibroMayor.xls";

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
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);

$y=1;
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'CUENTA')
	->setCellValue("B".$y,'DESCRIP')
	->setCellValue("C".$y,'ULTIMA FECH')
	->setCellValue("D".$y,'SALDO INI.')
	->setCellValue("E".$y,'TOTAL DEBE.')
	->setCellValue("F".$y,'TOTAL HABER.')
	->setCellValue("G".$y,'SALDO FIN');

$objPHPExcel->getActiveSheet()
			->getStyle('A1:G1')
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


while ($row=mysql_fetch_array($ejeCadLibMay)) 
{	
	$y++;
	
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y.":F".$y.":G".$y)
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit("A".$y, $row['LMY_CUENTA'],PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("B".$y, utf8_encode($row['PCU_DESCRIPCION']),PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("C".$y, $row['LMY_FEHA'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("D".$y, $row['LMY_SAL_INI'],PHPExcel_Cell_DataType::TYPE_NUMERIC)	
	->setCellValueExplicit("E".$y, $row['LMY_TOT_DEBE'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("F".$y, $row['LMY_TOT_HABER'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("G".$y, $row['LMY_SALDO_FIN'],PHPExcel_Cell_DataType::TYPE_NUMERIC);	
}


header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 ?>