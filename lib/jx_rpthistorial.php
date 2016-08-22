<?php 
session_start();
require_once('phpconex.php');
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {

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
	if ($_SESSION['empresa']==1) {
		$fecha_cor_inven="2015-12-03";
	} else if($_SESSION['empresa'] == 2) {
		$fecha_cor_inven="2015-12-24";
	}
	
	$enlace = conectarbd();
	//$cad=$_POST['cad1'];
	$cod_pro = $_POST['cod_pro'];
	$cad="SELECT PR_DETALLE, DET_FK_IDPROD,CP_NOMBRE,CP_APELLIDO, COM_TIPO_COMPR, COM_NUM_COMPROB, COM_FEC_CREA, DET_VAL_UNIT,DET_VAL_TOT,
	 DET_CANTIDAD, PR_COD_PROD, PR_EMPRESA, PR_PRESENTACION 
	 FROM t_comprobante,t_client_provee,t_detalles,t_prodcutos 
	 WHERE DET_FK_IDCLIPROV=IDT_CLIENT_PROVEE and (COM_FEC_CREA >= '".$fecha_cor_inven."') AND IDT_COMPROBANTE=DET_FK_IDCOMPROB and COM_ESTADO_SIS=1
	 AND COM_NUM_COMPROB=DET_NUM_FACTU AND DET_FK_IDCLIPROV=IDT_CLIENT_PROVEE 
	 AND PR_COD_PROD='".$cod_pro."' AND DET_FK_IDPROD=PR_COD_PROD AND PR_EMPRESA=".$_SESSION['empresa']." AND
	  COM_EPRESA= ".$_SESSION['empresa']." order by IDT_COMPROBANTE";

	
	//echo $cad;

	$ejeccad = mysql_query($cad);
	mysql_close($enlace);
	if (mysql_num_rows($ejeccad)==0) {
		echo "No existen datos";
	}else{

	echo "<table class='cl_tabresultados' style='width:100%;'>
		<tr>
			<td><h5>PRODUCTO</h5></td>
			<td><h5>CLINTE/PROVEE</h5></td>
			<td><h5>TIPO DOC.</h5></td>
			<td><h5>FECHA COMPROB.</h5></td>
			<td><h5>N° COMPROB.</h5></td>
			<td><h5>V.UNIT</h5></td>
			<td><h5>V.TOTAL</h5></td>
			<td><h5>CANT.</h5></td>
			<td><h5>SALDOS.</h5></td>
		</tr>";

	$enlace = conectarbd();
	$cad_stock_ini = "SELECT INI_STOK_INI FROM t_invetario_inicial where INI_VIGENTE=1 and  INI_EMPRESA= ".$_SESSION['empresa']." and INI_FK_COD_PROD='".$cod_pro."';";
	$ejec_cad_stock = mysql_query($cad_stock_ini);
	mysql_close($enlace);
	$res_stock_ini = mysql_fetch_row($ejec_cad_stock);
	$val_ini = $res_stock_ini[0];
	if ($val_ini == '' or is_null($val_ini) ) {
		$val_ini = 0;
	} else {
		$val_ini = $val_ini;
	}
	?>
	<tr>
		<td colspan="8" align="right">
			SALDO INI
		</td>
		<td align="right">
			<?php echo $val_ini; ?>
		</td>
	</tr>
	<?php 
	while ($resulresporte = mysql_fetch_array($ejeccad)) {
		if ($resulresporte['COM_TIPO_COMPR']=='V' or $resulresporte['COM_TIPO_COMPR']=='W' or $resulresporte['COM_TIPO_COMPR']=='X' or $resulresporte['COM_TIPO_COMPR']=='G' or $resulresporte['COM_TIPO_COMPR']=='M') {
			$can_act = $resulresporte['DET_CANTIDAD'] *(-1);
		} else if ($resulresporte['COM_TIPO_COMPR']=='P'){
			$can_act = 0 ;
		} else {
			$can_act = $resulresporte['DET_CANTIDAD'] ;
		} 
		$val_ini  = $val_ini  +	$can_act;			
		?>
			<tr>
				<td style="width:180px;"><?php echo substr(utf8_encode($resulresporte['PR_DETALLE']), 0,15).' '.utf8_encode($resulresporte['PR_PRESENTACION']); ?></td>
				<td><?php echo utf8_encode($resulresporte['CP_NOMBRE'].' '.$resulresporte['CP_APELLIDO']); ?></td>
				<td><?php echo $resulresporte['COM_TIPO_COMPR']; ?></td>
				<td><?php echo $resulresporte['COM_FEC_CREA']; ?></td>
				<td><?php echo $resulresporte['COM_NUM_COMPROB']; ?></td>
				<td><?php echo $resulresporte['DET_VAL_UNIT']; ?></td>
				<td><?php echo $resulresporte['DET_VAL_TOT']; ?></td>
				<td align="right"><?php echo $can_act; ?></td>
				<td align="right"><?php echo $val_ini  ; ?></td>					
			</tr>
		<?php
	}
	?>
	<tr>
		<td colspan="8" align="right">
			SALDO FIN
		</td>
		<td align="right">
			<?php echo $val_ini; ?>
		</td>
	</tr>
	<?php 
	echo '<tr>
			<td colspan="9" align="right">
				<a href="rpthistorial.php?cadena='.$cad.'&emp='.$_SESSION['empresa'].'&cod_prod='.$cod_pro.'" targert="blank">Reporte Excel</a>
			</td>			
		</tr>';
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