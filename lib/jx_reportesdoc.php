<?php 
session_start();
require_once('phpconex.php');
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {

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
		$cad=$_POST['cad1'];
		$cad =  $cad ." AND COM_ESTADO_SIS = 1  order by COM_NUM_COMPROB asc";
		//echo $cad;

		$ejeccad = mysql_query($cad);
		mysql_close($enlace);
		if (mysql_num_rows($ejeccad)==0) {
			echo "No existen datos";
		}else{

		echo "<table class='cl_tabresultados' style='width:100%;'>
			<tr>
				<td><h5>RAZON SOCIAL</h5></td>
				<td><h5>RUC</h5></td>
				<td><h5>TIPO COMPROB.</h5></td>
				<td><h5>FECHA COMPROB.</h5></td>
				<td><h5>N° COMPROB.</h5></td>
				<td><h5>SUBTOTAL<h5></td>
				<td><h5>BASE 0<h5></td>
				<td><h5>BASE 12<h5></td>
				<td><h5>IVA<h5></td>
				<td><h5>ESTADO<h5></td>
				<td><h5>EST.SISTEMA</h5></td>
				<td><h5>AUTORIZ. SRI</h5></td>
				<td></td>
			</tr>";
		while ($resulresporte = mysql_fetch_array($ejeccad)) {
			if ($resulresporte['COM_ESTADO_PAGO']==0) {
				$etiqpago='<p>Pagado</p>';
			} else {
				$etiqpago='<p style="background:red;">Pendiente</p>';
			}
			if ($resulresporte['COM_ESTADO_SIS']==0) {
				$estadosis='<p>Anulado</p>';
			} else {
				$estadosis='<p style="background:green;">Activo</p>';
			}
			
			
			?>
				<tr>
					<td style="width:180px;"><?php echo utf8_encode($resulresporte['CP_NOMBRE']); ?></td>
					<td><?php echo $resulresporte['CP_CEDULA']; ?></td>
					<td><?php echo $resulresporte['COM_TIPO_COMPR']; ?></td>
					<td><?php echo $resulresporte['COM_FEC_CREA']; ?></td>
					<td><?php echo $resulresporte['COM_NUM_COMPROB']; ?></td>
					<td><?php echo $resulresporte['COM_VAL_SUBT']; ?></td>
					<td><?php echo $resulresporte['COM_VAL_BASE0']; ?></td>
					<td><?php echo $resulresporte['COM_VAL_BASE12']; ?></td>
					<td><?php echo $resulresporte['COM_IVA']; ?></td>
					<td><?php echo $etiqpago?></td>
					<td><?php echo $estadosis?></td>
					<td><?php echo substr($resulresporte['COM_AUTORIZACION_SRI'], 0,10); ?></td>
					<td><input type="button" value="Eliminar" onclick="eliminarregistro(<?php echo $resulresporte['IDT_COMPROBANTE'];?>)"></td>
				</tr>
			<?php
		}
		echo '<tr>
				<td colspan="13" align="right">
					<a href="rptreportesexcel.php?cadena='.$cad.'" targert="blank">Exportar</a>
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




