<?php 
session_start();
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
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
	//echo $cad;
	$ejeccad = mysql_query($cad);
	if (mysql_num_rows($ejeccad)==0) {
		echo "No existen datos";
	}else{

		echo "<table class='cl_tabresultados' style='width:100%;'>

			<tr>
				<td align='center'><h5>CLIENT./PROVEE.</h5></td>
				<td align='center'><h5>N° COMPROBANTE</h5></td>
				<td align='center'><h5 style='text-align:center;'>FECH. COMP</h5></td>
				<td align='center'><h5 style='text-align:center;'>FECH. PAGO</h5></td>
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
			$fecha = date_create($resulresporte['COM_FEC_CREA']);
			date_add($fecha, date_interval_create_from_date_string($resulresporte['CP_PLAZO_PAG'].'days'));
			$fec_pag=  date_format($fecha, 'Y-m-d');
			if ($fec_pag > date('Y-m-d')) {
				$color = "red";
			} else if ($fec_pag < date('Y-m-d')) {
				$color = "green";
			} else{
				$color = "green";
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
					</td>
					<td>
						<input type="text" class="cl_txt" name="c_fec_comp" id="id_fech_comp" value="<?php echo $resulresporte['COM_FEC_CREA']; ?>" style="width:100px;" readonly/>
					</td>
					<td>
						<input type="text" class="cl_txt" name="c_fec_comp" id="id_fech_comp" value="<?php echo $fec_pag; ?>" style="width:100px;background:<?php echo $color; ?>" readonly/>
					</td>
					<td align="center">
						<?php echo $resulresporte['COM_TIPO_COMPR']; ?>
						<input type="hidden" name="c_tip_comp[]" id="<?php echo "id_tipo_comp".$i; ?>" value="<?php echo $resulresporte['COM_TIPO_COMPR']; ?>" style="width:10px;">
						<input type="hidden" name="c_cont_verif" id="<?php echo "id_cont_verif".$i; ?>" value="<?php echo $i; ?>" style="width:10px;">
					</td>
					<td><input type="number" step="0.01" value="<?php echo $resulresporte['COM_TOT']; ?>"   class="cl_txt2" name="c_tot_factu[]" id="<?php echo "id_tot_factu".$i; ?>" readonly/></td>
					<td><input type="number" step="0.01" value="<?php echo $resulresporte['COM_ABONO']; ?>" class="cl_txt2" name="c_ant_abono[]" id="<?php echo "id_ant_abono".$i; ?>" readonly/></td>
					<td><input type="number" step="0.01" value="<?php echo $resulresporte['COM_SALDO']; ?>" class="cl_txt2" name="c_ant_saldo[]" id="<?php echo "id_ant_saldo".$i; ?>" style="background:#A4A4A4;" readonly/></td>	
					<td><input type="number" step="0.01" value="<?php echo $resulresporte['COM_SALDO']; ?>" class="cl_txt2" name="c_new_abono[]" id="<?php echo "id_new_abono".$i; ?>" onkeyup="calcular_nuevo_abono_saldo_prov(<?php echo $i; ?>);"  readonly/></td>
					<td><input type="number" step="0.01" value="<?php echo $resulresporte['COM_SALDO']; ?>" class="cl_txt2" name="c_new_saldo[]" id="<?php echo "id_new_saldo".$i; ?>" readonly/></td>	
					<td align="right"><input type="checkbox" value="<?php echo $i; ?>" name="c_chk_pago" id="<?php echo "id_chk_pago".$i; ?>" onclick="calcularpago_proveedor(this.value);"></td>			
				</tr>
			<?php
			$sum = $sum + floatval($resulresporte['COM_SALDO']);
			$sumaabono = number_format (floatval($sumaabono) + floatval($resulresporte['COM_ABONO']),2);
			//$sumasaldo = number_format (floatval($sumasaldo) + floatval($resulresporte['COM_SALDO']),2);
			$i++;
		}
		?>
		<tr>			
			<td colspan="6" align="right">TOTALES</td>
			<td><input type="number" step="0.01"  name="c_tot_abono_act" id="id_tot_abono_act" value="<?php echo $sumaabono; ?>" class="cl_txt2" readonly/></td>
			<td><input type="number" step="0.01"  name="c_tot_saldo_act" id="id_tot_saldo_act" value="<?php echo $sum; ?>" class="cl_txt2" readonly/></td>
			<td><input type="number" step="0.01" name="c_tot_new_abon" id="id_tot_new_abon" value="0.00" class="cl_txt2" readonly/></td>
			<td><input type="number" step="0.01"  name="c_tot_new_saldo" id="id_tot_new_saldo" value="<?php echo $sum; ?>" class="cl_txt2" readonly/></td>
			<td align="right"><input type="checkbox" disabled/></td>
		</tr>
		<?php
		echo '<tr>
				<td colspan="11 readonly/" align="right">
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

