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
	$enlace = conectarbd();
	$cad=$_POST['cad1'];
	$cad = $cad .' order by COM_FEC_CREA asc';
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
			<td><h5>EMPRESA</h5></td>
			<td><h5>FECHA COMPROB.</h5></td>
			<td align='center'><h5>DEBE / ING</h5></td>
			<td align='center'><h5>HABER / ENGR</h5></td>
			<td align='center'><h5>SALDOS</h5></td>
		</tr>";

	echo "<tr>
		<td align='right' colspan='7'>
			<p style='background:#489550;margin:0;padding:5px;'> SALDO INI A : <strong> ".$fecha_cort."</strong></p>
		</td>
		<td align='right'>
			".$saldo_tot."
		</td>
	</tr>";

	while ($resulresporte = mysql_fetch_array($ejeccad)) {
		$saldo_tot  = $saldo_tot + $resulresporte['ASI_DEBE'] - $resulresporte['ASI_HABER'];
		if ($resulresporte['COM_EPRESA'] == 1) {
			$var_emp = '<p style="background:#3A87A9;color:#FFF;margin:0;border-radius:2px;text-align:center;">TULCAN.</p>';
		} else {
			$var_emp = '<p style="background:#D8AC4D;color:#FFF;margin:0;border-radius:2px;text-align:center;">SAN GA.</p>';
		}
		
		?>
			<tr>
				<td><?php echo utf8_encode($resulresporte['CP_NOMBRE']); ?>
					<?php echo utf8_encode($resulresporte['CP_APELLIDO']); ?></td>
				<td><?php echo $resulresporte['COM_NUM_COMPROB']; ?></td>
				<td align='center'><?php echo $resulresporte['COM_TIPO_COMPR']; ?></td>
				<td align="right"><?php echo $var_emp; ?> </td>
				<td align='center' style="width:155px;font-size:14px;"><?php echo $resulresporte['COM_FEC_CREA']; ?></td>
				<td align='right' style="width:155px;"><?php echo number_format($resulresporte['ASI_DEBE'],2); ?></td>
				<td align='right' style="width:155px;"><?php echo number_format($resulresporte['ASI_HABER'],2); ?></td>
				<td align='right' style="width:155px;background:#ABABAB;"><?php echo number_format($saldo_tot,2); ?></td>
			</tr>
		<?php
	}
	echo '<tr>
			<td colspan="8" align="right">
				<a href="rptcuentasexcel.php?cadena='.$cad.'&cuenta='.$cuenta.'&fecha_ini='.$fecha_ini.'&emp='.$_SESSION['empresa'].'&identfic=2" targert="blank">Exportar</a>
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


