<?php 
session_start();
if ( isset($_SESSION['empresa']) ) {
include("phpconexcion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Document</title>
</head>
<body>
	<?php 		
	$enlace = conectar_buscadores();
	$cad=$_POST['cad1'];
	$cad= $cad ." , t_client_provee, t_invetario_inicial where INI_VIGENTE=1 and INI_FK_COD_PROD =  PR_COD_PROD  AND PR_ESTADO=1 and   PR_EMPRESA = INI_EMPRESA AND 
	 PR_FK_PROVEEDOR = IDT_CLIENT_PROVEE AND PR_EMPRESA=".$_SESSION['empresa'];
	 //echo $cad;
	$ejeccad = mysql_query($cad);
	//mysql_close($enlace);
	if (mysql_num_rows($ejeccad)==0) {
		echo "No existen datos";
	}else{
/*PR_COD_PROD, PR_DETALLE, PR_PRESENTACION, 
 PR_STOK_INI, PR_VAL_COMPRA, 
PR_VAL_MIN, PR_VAL_MED, PR_VAL_MAX, PR_VAL_PVP, 
PR_OFFI, PR_EMPRESA, PR_BARRAS, PR_FK_PROVEEDOR */
	echo "<table class='cl_tabresultados' style='width:100%'>
		<tr>
			<td></td>
			<td><p style='font-size:13px;'><strong>COD. PROD</strong></p></td>
			<td><p style='font-size:13px;'><strong>PRODUCTO.</strong></p></td>			
			<td><p style='font-size:13px;'><strong>PRESENT.</strong></p></td>
			<td><p style='font-size:13px;'><strong>STOCK INI.</strong></p></td>
			<td><p style='font-size:13px;'><strong>STOCK ACT.</strong></p></td>
			<td><p style='font-size:13px;'><strong>V.COMPRA</strong></p></td>
			<td><p style='font-size:13px;'><strong>V.MIN</strong></p></td>
			<td><p style='font-size:13px;'><strong>V.MED</strong></p></td>
			<td><p style='font-size:13px;'><strong>V.MAX</strong></p></td>
			<td><p style='font-size:13px;'><strong>PVP</strong></p></td>
			<td><p style='font-size:13px;'><strong>PROVEEDOR</strong></p></td>
			<td><p style='font-size:13px;'><strong>FECH. COMP</strong></p></td>
			<td><p style='font-size:13px;'><strong>FECH. VEN</strong></p></td>
		</tr>";
	echo '<tr>
			<td colspan="14" align="right">
				<a href="rpt_inventarioprod.php?cadena='.$cad.'&emp='.$_SESSION['empresa'].'" targert="blank">Reporte Excel</a>
			</td>			
		</tr>';
	$i=1;
	while ($resulresporte = mysql_fetch_array($ejeccad)) {	

		$enlace = conectar_buscadores();
		
		if ($_SESSION['empresa']==1) {
			$fecha_cor_inven="2015-12-03";
		} else if($_SESSION['empresa'] == 2) {
			$fecha_cor_inven="2015-12-24";
		}

		$cad_stoc_actual = "SELECT DET_CANTIDAD, DET_TIPO_TRNS, COM_TIPO_COMPR FROM t_detalles, t_comprobante 
		WHERE DET_NUM_FACTU= COM_NUM_COMPROB 
		and DET_FK_IDCOMPROB= IDT_COMPROBANTE and COM_ESTADO_SIS=1 
		and DET_EMP= COM_EPRESA and (COM_FEC_CREA >= '".$fecha_cor_inven."')  AND DET_EMP=".$_SESSION['empresa']." AND DET_FK_IDPROD='".$resulresporte['PR_COD_PROD']."'";
		//echo $cad_stoc_actual;
		$ejec_cad_stock  = mysql_query($cad_stoc_actual);
		//mysql_close($enlace);
		$can_act= $resulresporte['INI_STOK_INI'];
		while ( $res_cal_detalle = mysql_fetch_array($ejec_cad_stock)) {
			if ($res_cal_detalle['COM_TIPO_COMPR']=='V' or $res_cal_detalle['COM_TIPO_COMPR']=='W' or $res_cal_detalle['COM_TIPO_COMPR']=='G' or $res_cal_detalle['COM_TIPO_COMPR']=='M' or $res_cal_detalle['COM_TIPO_COMPR']=='X') {
				$can_act = $can_act -  $res_cal_detalle['DET_CANTIDAD'];
			} else if($res_cal_detalle['COM_TIPO_COMPR']=='P' ){
				$can_act = $can_act +  0;
			} else {
				$can_act = $can_act +  $res_cal_detalle['DET_CANTIDAD'];
			} 
		}	
			$cad_las_fech_comp ="SELECT max(COM_FEC_CREA) FROM t_comprobante, t_detalles WHERE IDT_COMPROBANTE= DET_FK_IDCOMPROB 
			AND  COM_EPRESA=".$_SESSION['empresa']."  AND COM_ESTADO_SIS= 1 AND COM_TIPO_COMPR='C' AND DET_FK_IDPROD='".$resulresporte['PR_COD_PROD']."'";
			set_time_limit(0);
			$ejec_Cad_comp = mysql_query($cad_las_fech_comp);
			$res_las_comp = mysql_fetch_row($ejec_Cad_comp);
			$fech_comp = $res_las_comp[0];

			$cad_las_fech_ven ="SELECT max(COM_FEC_CREA) FROM t_comprobante, t_detalles WHERE IDT_COMPROBANTE= DET_FK_IDCOMPROB 
			AND  COM_EPRESA=".$_SESSION['empresa']."  AND COM_ESTADO_SIS= 1 AND COM_TIPO_COMPR='V' AND DET_FK_IDPROD='".$resulresporte['PR_COD_PROD']."'";
			set_time_limit(0);
			$ejec_Cad_ven = mysql_query($cad_las_fech_ven);
			$res_las_ven = mysql_fetch_row($ejec_Cad_ven);
			$fech_ven = $res_las_ven[0];

		?>
			<tr>
				<td><p style="font-size:12px;"><?php echo $i; ?></p></td>
				<td><p style="font-size:12px;"><?php echo $resulresporte['PR_COD_PROD']; ?></p></td>
				<td style="width:180px;"><p style="font-size:12px;"><?php echo utf8_encode($resulresporte['PR_DETALLE']); ?></p></td>
				<td style="width:100px;"><p style="font-size:12px;"><?php echo $resulresporte['PR_PRESENTACION']; ?></p></td>
				<td><p style="font-size:12px;"><?php echo $resulresporte['INI_STOK_INI']; ?></p></td>
				<td style="background:#AFAFAF;"><p style="font-size:12px;"><?php echo $can_act; ?></p></td>
				<td><p style="font-size:12px;"><?php echo $resulresporte['PR_VAL_COMPRA']; ?></p></td>
				<td><p style="font-size:12px;"><?php echo $resulresporte['PR_VAL_MIN']; ?></p></td>
				<td><p style="font-size:12px;"><?php echo $resulresporte['PR_VAL_MED']; ?></p></td>
				<td><p style="font-size:12px;"><?php echo $resulresporte['PR_VAL_MAX']; ?></p></td>
				<td><p style="font-size:12px;"><?php echo $resulresporte['PR_VAL_PVP']; ?></p></td>
				<td><p style="font-size:12px;"><?php echo $resulresporte['CP_NOMBRE']; ?></p></td>
				<td style="width:100px;"><p style="font-size:12px;"><?php echo $fech_comp; ?></p></td>
				<td style="width:100px;"><p style="font-size:12px;"><?php echo $fech_ven; ?></p></td>
			</tr>
		<?php
	$i++;
	}	
	echo "</table>";
	}
	 ?>
</body>
</html>
<?php 

}else{
echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}
?>