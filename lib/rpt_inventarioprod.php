<?php 
session_start();
require_once("lib/phpconexcion.php");
$enlace = conectar_buscadores();
$cad = $_GET['cadena'];
$empres = $_GET['emp'];
if ($empres ==1) {
	$estiq_emp ='TULCAN.';
} else {
	$estiq_emp ='SAN GA.';
}

//date_default_timezone_set('American/Ecuador');
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$objPHPExcel = new PHPExcel();
$archivo ="REPORTE INV.".$estiq_emp.date('Ymd').".xls";

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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

$y=1;
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("A".$y,'ITEM')
	->setCellValue("B".$y,'COD. PROD')
	->setCellValue("C".$y,'PRODUCTO')	
	->setCellValue("D".$y,'PRESENTACION')
	->setCellValue("E".$y,'STOCK INI.')
	->setCellValue("F".$y,'STOCK ACT.')
	->setCellValue("G".$y,'V.COMPRA')
	->setCellValue("H".$y,'V.MIN')
	->setCellValue("I".$y,'V.MED')
	->setCellValue("J".$y,'V.MAX')
	->setCellValue("K".$y,'PVP')
	->setCellValue("L".$y,'PROVEEDOR')
	->setCellValue("M".$y,'ULT. FECH. COMP')
	->setCellValue("N".$y,'ULT. FECH. VENTA');
	
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
	$y++;

	$enlace = conectar_buscadores();
	if ($empres==1) {
		$fecha_cor_inven="2015-12-03";
	} else if($empres == 2) {
		$fecha_cor_inven="2015-12-24";
	}

	/*$cad_stoc_actual = "SELECT DET_CANTIDAD, DET_TIPO_TRNS, COM_TIPO_COMPR FROM t_detalles, t_comprobante 
	WHERE DET_NUM_FACTU = COM_NUM_COMPROB
	and DET_FK_IDCLIPROV = COM_FKID_CLI_PROV and (COM_FEC_CREA >= '".$fecha_cor_inven."') and DET_FK_IDCOMPROB = IDT_COMPROBANTE and COM_ESTADO_SIS=1 
	and DET_EMP = COM_EPRESA  AND DET_EMP=".$empres." AND DET_FK_IDPROD='".$row['PR_COD_PROD']."'";*/
	//echo $cad_stoc_actual;

	$cad_stoc_actual = "SELECT DET_CANTIDAD, DET_TIPO_TRNS, COM_TIPO_COMPR FROM t_detalles, t_comprobante 
		WHERE DET_NUM_FACTU= COM_NUM_COMPROB 
		and DET_FK_IDCOMPROB = IDT_COMPROBANTE and COM_ESTADO_SIS=1 
		and DET_EMP= COM_EPRESA and (COM_FEC_CREA >= '".$fecha_cor_inven."')  AND DET_EMP=".$empres." AND DET_FK_IDPROD='".$row['PR_COD_PROD']."'";
		//echo $cad_stoc_actual;
	$ejec_cad_stock  = mysql_query($cad_stoc_actual);

	//$ejec_cad_stock  = mysql_query($cad_stoc_actual);
	$can_act= $row['INI_STOK_INI'];
	
	while ( $res_cal_detalle = mysql_fetch_array($ejec_cad_stock)) {

		if ($res_cal_detalle['COM_TIPO_COMPR']=='V' or $res_cal_detalle['COM_TIPO_COMPR']=='w' or $res_cal_detalle['COM_TIPO_COMPR']=='G' or $res_cal_detalle['COM_TIPO_COMPR']=='M' ) {
			$can_act = $can_act -  $res_cal_detalle['DET_CANTIDAD'];
		} else {
			$can_act = $can_act +  $res_cal_detalle['DET_CANTIDAD'];
		} 
	}

	$cad_las_fech_comp ="SELECT max(COM_FEC_CREA) FROM t_comprobante, t_detalles WHERE IDT_COMPROBANTE= DET_FK_IDCOMPROB 
	AND  COM_EPRESA=".$_SESSION['empresa']."  AND COM_ESTADO_SIS= 1 AND COM_TIPO_COMPR='C' AND DET_FK_IDPROD='".$row['PR_COD_PROD']."'";
	$ejec_Cad_comp = mysql_query($cad_las_fech_comp);
	$res_las_comp = mysql_fetch_row($ejec_Cad_comp);
	$fech_comp = $res_las_comp[0];

	$cad_las_fech_ven ="SELECT max(COM_FEC_CREA) FROM t_comprobante, t_detalles WHERE IDT_COMPROBANTE= DET_FK_IDCOMPROB 
	AND  COM_EPRESA=".$_SESSION['empresa']."  AND COM_ESTADO_SIS= 1 AND COM_TIPO_COMPR='V' AND DET_FK_IDPROD='".$row['PR_COD_PROD']."'";
	$ejec_Cad_ven = mysql_query($cad_las_fech_ven);
	$res_las_ven = mysql_fetch_row($ejec_Cad_ven);
	$fech_ven = $res_las_ven[0];

	//mysql_close($enlace);
	$objPHPExcel->setActiveSheetIndex(0)
	->getStyle('A'.$y.":B".$y.":C".$y.":D".$y.":E".$y.":F".$y.":G".$y.":H".$y.":I".$y.":J".$y.":K".$y.":L".$y)
	->applyFromArray($borders);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValueExplicit("A".$y, $y)
	->setCellValueExplicit("B".$y, $row['PR_COD_PROD'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("C".$y, utf8_encode($row['PR_DETALLE']),PHPExcel_Cell_DataType::TYPE_STRING)	
	->setCellValueExplicit("D".$y, $row['PR_PRESENTACION'],PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("E".$y, $row['INI_STOK_INI'],PHPExcel_Cell_DataType::TYPE_NUMERIC)	
	->setCellValueExplicit("F".$y, $can_act,PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("G".$y, $row['PR_VAL_COMPRA'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("H".$y, $row['PR_VAL_MIN'],PHPExcel_Cell_DataType::TYPE_NUMERIC)	
	->setCellValueExplicit("I".$y, $row['PR_VAL_MED'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("J".$y, $row['PR_VAL_MAX'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("K".$y, $row['PR_VAL_PVP'],PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit("L".$y, utf8_encode($row['CP_NOMBRE'].' '.$row['CP_APELLIDO']),PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("M".$y, $fech_comp,PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit("N".$y, $fech_ven,PHPExcel_Cell_DataType::TYPE_STRING);	
}
header('Content-Type: aplication/vnd.ms-excel');
header('Content-Disposition:attachment;filename="'.$archivo.'"');
header('Cache-Control: max-age=0');
$objWriter= PHPExcel_IOFACTORY::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;

 ?>