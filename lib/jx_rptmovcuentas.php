<?php 
session_start();
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
require_once('phpconex.php');
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
	$enlace = conectarbd();
	$cuenta = $_POST['cuenta'];
	$fecha_ini = $_POST['fecha_ini'];
	$cad_query_saldos ="CALL SP_SUMAR_CUENTA_BAL ('".$cuenta."',".$_SESSION['empresa'].",'".$fecha_ini ."' )";
	//echo $cad_query_saldos;
	$ejec_cad_saldos = mysql_query($cad_query_saldos);
	$res_query_saldos = mysql_fetch_row($ejec_cad_saldos);
	$saldo_fin  = $res_query_saldos[0];
	$fecha_cort  = $res_query_saldos[1];
	mysql_close($enlace);

	$enlace = conectarbd();
	$cad=$_POST['cad1'];
	$cad = $cad.' and COM_ESTADO_SIS=1 and COM_EPRESA ='.$_SESSION['empresa'];
	//echo $cad;
	$ejeccad = mysql_query($cad);
	mysql_close($enlace);
	if (mysql_num_rows($ejeccad)==0) {
		echo "No existen datos";
	}else{

	echo "<table class='cl_tabresultados' style='width:100%;'>

		<tr>
			<td style='width:40%;'><h5>NOMBRES Y APELLIDOS</h5></td>
			<td><h5>N° COMPROBANTE</h5></td>
			<td><h5>TIPO</h5></td>
			<td><h5>FECHA COMPROB.</h5></td>
			<td><h5>DEBE</h5></td>
			<td><h5>HABER</h5></td>
			<td><h5>SALDOS</h5></td>
		</tr>";

	echo "<tr>
		<td align='right' colspan='7'>
			<p style='background:#489550;margin:0;padding:5px;'> SALDO INI A : <strong> ".$fecha_cort."</strong></p>
		</td>
		<td align='right'>
			".$saldo_fin."
		</td>
	</tr>";

	while ($resulresporte = mysql_fetch_array($ejeccad)) {
		$saldo_fin  = $saldo_fin + $resulresporte['ASI_DEBE'] - $resulresporte['ASI_HABER'];
		?>
			<tr>
				<td><?php echo utf8_encode($resulresporte['CP_APELLIDO']); ?>
					<?php echo utf8_encode($resulresporte['CP_NOMBRE']); ?></td>
				<td><?php echo $resulresporte['COM_NUM_COMPROB']; ?></td>
				<td><?php echo $resulresporte['COM_TIPO_COMPR']; ?></td>
				<td><?php echo $resulresporte['COM_FEC_CREA']; ?></td>
				<td align='right' ><?php echo number_format($resulresporte['ASI_DEBE'],2); ?></td>
				<td align='right' ><?php echo number_format($resulresporte['ASI_HABER'],2); ?></td>
				<td align='right' style="background:#ABABAB;" ><?php echo number_format($saldo_fin,2); ?></td>
			</tr>
		<?php
	}
	echo '<tr>
			<td colspan="8" align="right">
				<a href="rptcuentasexcel.php?cadena='.$cad.'&cuenta='.$cuenta.'&fecha_ini='.$fecha_ini.'&emp='.$_SESSION['empresa'].'&identfic=1" targert="blank">Exportar</a>
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


