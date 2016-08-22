<?php 
session_start();
require_once('phpconex.php');
if ( isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
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
	$cad=$_POST['query_creditos'];
	//echo $cad;
	$ejeccad = mysql_query($cad);
	mysql_close($enlace);
	if (mysql_num_rows($ejeccad)==0) {
		echo "No existen datos";
	}else{

		echo "<table class='cl_tabresultados' style='width:100%;'>

			<tr>
				<td align='center'><h5>CLIENT./PROVEE.</h5></td>
				<td align='center'><h5>N° COMPROBANTE</h5></td>
				<td align='center'><h5 style='text-align:center;'>TIPO COMPROB.</h5></td>	
				<td align='center'><h5>TOTAL</h5></td>	
				<td align='center'><h5>ABONO</h5></td>	
				<td align='center'><h5>SALDO</h5></td>	
				<td align='center'><h5>NUE. ABON</h5></td>
				<td align='center'><h5>NUE. SALD</h5></td>
				<td align='center'><h5>PAGAR</h5></td>
			</tr>";
		$i=0;
		$sumasaldo = 0;
		$sum =0;
		$sumaabono = 0;
		while ($resulresporte = mysql_fetch_array($ejeccad)) {
			if ($resulresporte['ASI_CUENTA'] == '1.1.2.01.01') {
				$val = $resulresporte['COM_SALDO'];
			} else {
				$val = '-'.$resulresporte['COM_SALDO'];
			}
			
			?>
				<tr>
					<td style="font-size:12px;"><?php echo utf8_encode($resulresporte['CP_NOMBRE']); ?>
						<?php echo utf8_encode($resulresporte['CP_APELLIDO']); ?>
					</td>
					<td align="center" style="padding:0 3px 0 3px;">
						<input type="hidden" value="<?php echo $resulresporte['IDT_COMPROBANTE']; ?>" class="cl_txt" name="c_idt_coprob[]" id="<?php echo "id_idt_comrpob".$i; ?>"style="width:20px;" readonly/>
						<input type="text" value="<?php echo $resulresporte['COM_NUM_COMPROB']; ?>" class="cl_txt" name="c_num_fact[]" id="<?php echo "id_num_fact".$i; ?>"style="width:150px; font-size:15px;text-align:center;" readonly/>
						<input type="hidden" value="0" name="c_identificador[]" id="<?php echo "id_identificador_pago".$i; ?>" style="width:20px;" readonly/>
						<input type="hidden" value="<?php echo $resulresporte['COM_TIPO_COMPR']; ?>" name="c_com_tipoComp[]" id="<?php echo "id_com_tipoComp".$i; ?>" style="width:20px;" readonly/>
					</td>
					<td align="center"><?php echo $resulresporte['COM_TIPO_COMPR']; ?></td>
					<td><input type="number" step="0.01" value="<?php echo $resulresporte['COM_TOT']; ?>"   class="cl_txt2" name="c_tot_factu[]" id="<?php echo "id_tot_factu".$i; ?>" style="background:#A4A4A4;" readonly/></td>
					<td><input type="number" step="0.01" value="<?php echo $resulresporte['COM_ABONO']; ?>" class="cl_txt2" name="c_ant_abono[]" id="<?php echo "id_ant_abono".$i; ?>" readonly/></td>
					<td><input type="number" step="0.01" value="<?php echo $val ; ?>" class="cl_txt2" name="c_ant_saldo[]" id="<?php echo "id_ant_saldo".$i; ?>" readonly/></td>	
					<td><input type="number" step="0.01" value="<?php echo $val ; ?>" class="cl_txt2" name="c_new_abono[]" id="<?php echo "id_new_abono".$i; ?>" onkeyup="calcular_nuevo_abono_saldo(<?php echo $i; ?>);" onblur="calcular_nuevo_abono_saldo(<?php echo $i; ?>);" readonly/></td>
					<td><input type="number" step="0.01" value="<?php echo $val ; ?>" class="cl_txt2" name="c_new_saldo[]" id="<?php echo "id_new_saldo".$i; ?>" readonly/></td>	
					<td align="right"><input type="checkbox" value="<?php echo $i; ?>" name="c_chk_pago" id="<?php echo "id_chk_pago".$i; ?>" onclick="calcularpago(this.value);"></td>			
				</tr>
			<?php
			$sum = $sum + floatval($val );
			$sumaabono = number_format (floatval($sumaabono) + floatval($resulresporte['COM_ABONO']),2);
			//$sumasaldo = number_format (floatval($sumasaldo) + floatval($resulresporte['COM_SALDO']),2);
			$i++;
		}
		?>
		<tr>			
			<td colspan="4" align="right">TOTALES</td>
			<td><input type="number" step="0.01"  name="c_tot_abono_act" id="id_tot_abono_act" value="<?php echo $sumaabono; ?>" class="cl_txt2" readonly/></td>
			<td><input type="number" step="0.01"  name="c_tot_saldo_act" id="id_tot_saldo_act" value="<?php echo $sum; ?>" class="cl_txt2" readonly/></td>
			<td><input type="number" step="0.01" name="c_tot_new_abon" id="id_tot_new_abon" value="<?php echo $sum; ?>" class="cl_txt2" readonly/></td>
			<td><input type="number" step="0.01"  name="c_tot_new_saldo" id="id_tot_new_saldo" value="<?php echo $sum; ?>" class="cl_txt2" readonly/></td>
			<td align="right"><input type="checkbox" disabled/></td>
		</tr>
		<?php
		echo '<tr>
				<td colspan="9" align="right">
					<a href="rpt_saldos_clie.php?cadena='.$cad.'" targert="blank">Exportar a Excel</a>
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

