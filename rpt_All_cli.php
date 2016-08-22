<?php 
require_once('lib/phpconexcion.php');
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo ="LISTA CLIENTES.xls";

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
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);

$y=1;
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'NUM.')
	->setCellValue("B".$y,'APELLIDOS.')
	->setCellValue("C".$y,'NOMBRES.')
	->setCellValue("D".$y,'CEDULA/RUC.')
	->setCellValue("E".$y,'DIRECCION.')
	->setCellValue("F".$y,'TELÉFONO.')
	->setCellValue("G".$y,'TIPO.')
	->setCellValue("H".$y,'CUPO CREDI.')
	->setCellValue("I".$y,'CREDITO.')
	->setCellValue("J".$y,'SALDO.');

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
			->getStyle('A1:J1')
			->applyFromArray($borders);

$con_cli = 1;

$enlace = conectar_buscadores();
$cad_clientes="SELECT * FROM t_client_provee where CP_EMPRESA = 1 and (CP_TIPO_CLI_PROV=1 or CP_TIPO_CLI_PROV=3) order by  CP_APELLIDO asc ";
$ejec_cad_clientes=mysql_query($cad_clientes);
while ($resCli=mysql_fetch_array($ejec_cad_clientes)) 
{
	if ( $resCli['CP_TIPO_ID']==1) {
		$eti_tipo_doc ='Cedula';
	} else if ( $resCli['CP_TIPO_ID']==2){
		$eti_tipo_doc ='RUC';
	}else if( $resCli['CP_TIPO_ID']==4){
		$eti_tipo_doc ='Extranjero';
	}

	$enlace = conectar_buscadores();
	$query_saldoc_li = "SELECT sum(COM_SALDO) from t_comprobante where COM_ESTADO_SIS=1 AND  
	COM_ESTADO_PAGO=1 and COM_FKID_CLI_PROV=".$resCli['IDT_CLIENT_PROVEE'] ;
	set_time_limit(0);
	$ejec_query_Saldo = mysql_query($query_saldoc_li);
	$respuesta_saldo = mysql_fetch_row($ejec_query_Saldo);
	$sado=$respuesta_saldo[0];
	$cupo=$resCli['CP_VAL_CREDIT'];
	$new_cupo = $cupo -$sado;


	$y++;
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$y.":J".$y)
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)


	->setCellValueExplicit("A".$y, $con_cli ,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("B".$y, utf8_encode($resCli['CP_APELLIDO']),PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("C".$y, utf8_encode($resCli['CP_NOMBRE']),PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("D".$y, $resCli['CP_CEDULA'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("E".$y, utf8_encode($resCli['CP_DIRECCION']),PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("F".$y, $resCli['CP_TELEFONO'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("G".$y, $eti_tipo_doc,PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("H".$y, $resCli['CP_VAL_CREDIT'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("I".$y, $sado,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("J".$y, $new_cupo,PHPExcel_Cell_DataType::TYPE_NUMERIC);
	$con_cli ++;	

}
header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 ?>
