<?php 
session_start();
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
  require_once('phpconex.php');
	$cli_prov = $_POST['q'];
	$enlace = conectarbd(); 
	$cad_compras  = "SELECT IDT_COMPROBANTE, COM_NUM_COMPROB, COM_VAL_SUBT, COM_VAL_BASE12, COM_VAL_BASE0, COM_IVA, COM_TOT,
		COM_TOT_SIN_RET, COM_ABONO, COM_SALDO FROM t_comprobante
		WHERE (COM_TIPO_COMPR='C' or COM_TIPO_COMPR='D') and  COM_ESTADO_PAGO = 1 AND COM_ESTADO_SIS=1 AND COM_FKID_CLI_PROV=".$cli_prov;
	$ejec_cad_compras = mysql_query($cad_compras);
	mysql_close($enlace);
	if (mysql_num_rows($ejec_cad_compras)==0) {
		echo "<h4 style='background:red;'>NO SE HA ENCONTRADO RESULTADOS</h4>";
	} else {
		echo "<table class='cl_tabresultados' style='width:100%'><tr>
			<td><strong>N° FACTURA</strong></td>
			<td><strong>SUBT.</strong></td>
			<td><strong>BASE 12%.</strong></td>
			<td><strong>BASE 0%.</strong></td>
			<td><strong>I.V.A.</strong></td>
			<td><strong>TOTAL.</strong></td>
			<td><strong>TOT. SIN RET.</strong></td>
			<td><strong>SALDO ACT.</strong></td>
			<td><strong>ABONO.</strong></td>
			<td><strong>SALDO.</strong></td>
			<td><strong></strong></td>
		</tr>";
		$i=0;
		while ($re = mysql_fetch_array($ejec_cad_compras)) {
		?>
		<tr>
			<td>
				<input type="text" name="c_num_comp[]" id="<?php echo "nc".$i; ?>" value="<?php echo $re['COM_NUM_COMPROB']; ?>" style="width:150px;" class="cl_txt1" readonly/>
				<input type="hidden" name="c_idt_comp[]" value="<?php echo $re['IDT_COMPROBANTE']; ?>" class="cl_txt3"  readonly/>
				<input type="hidden" name="c_estado_nc[]" id="<?php echo "id_estado_nc_txt".$i; ?>" value="0" class="cl_txt3" readonly/>
			</td>
			<td><input type="text" name="c_subtot[]" id="<?php echo "sub".$i; ?>" value="<?php echo $re['COM_VAL_SUBT']; ?>" class="cl_txt2"readonly/></td>
			<td><input type="text" name="c_base12[]" id="<?php echo "b12".$i; ?>" value="<?php echo $re['COM_VAL_BASE12']; ?>" class="cl_txt2"readonly/></td>
			<td><input type="text" name="c_base_0[]" id="<?php echo "b0".$i; ?>" value="<?php echo $re['COM_VAL_BASE0']; ?>" class="cl_txt2"readonly/></td>
			<td><input type="text" name="c_valiva[]" id="<?php echo "iv".$i; ?>" value="<?php echo $re['COM_IVA']; ?>" class="cl_txt2" readonly/></td>
			<td><input type="text" name="c_totfac[]" id="<?php echo "t1".$i; ?>" value="<?php echo $re['COM_TOT']; ?>" class="cl_txt2" readonly/></td>
			<td><input type="text" name="c_totsre[]" id="<?php echo "t2".$i; ?>" value="<?php echo $re['COM_TOT_SIN_RET']; ?>" class="cl_txt2"readonly/></td>
			<td><input type="text" name="c_vsaldo_act[]" id="<?php echo "sact".$i; ?>" value="<?php echo $re['COM_SALDO']; ?>" class="cl_txt2" style="background:#939393;" readonly/></td>
			<td><input type="text" name="c_vabono[]" id="<?php echo "ab".$i; ?>" value="<?php echo $re['COM_SALDO']; ?>" onkeyup="calcular_Saldo_nc('<?php echo $i; ?>')" class="cl_txt2" readonly/></td>
			<td><input type="text" name="c_vsaldo[]" id="<?php echo "sa".$i; ?>" value="<?php echo $re['COM_SALDO']; ?>" class="cl_txt2" readonly/></td>
			<td><input type="checkbox" name="c_chk_compras_nc" id="<?php echo "id_chk_nc_com".$i; ?>" onclick="seleccionar_from_nc_com('<?php echo $i; ?>');" readonly/></td>
		</tr>
		<?php 
		$i++;
		}
		echo "</table>";
	}

}else{
echo "<script>
      alert('USTED NO HA INICIADO SESION');
      window.location='index.php';
    </script>";
}
?>