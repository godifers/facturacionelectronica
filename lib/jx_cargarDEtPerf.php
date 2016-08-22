<?php 
session_start();
if (isset($_SESSION['empresa'])){
include("phpconexcion.php");
$enlace = conectar_buscadores();
$tipo_trans =$_POST['tipo_trans'];
$forma_pago =$_POST['forma_pago'];
$tipo_contr =$_POST['tipo_contr'];
$ca_id_perfil = "SELECT IDT_PERFIL FROM t_perfil WHERE PERI_TIPO_CONTRIB = ".$tipo_contr." and PER_COD_UNIC = ".$forma_pago." 
	and PER_TIPO_TRANS = '".$tipo_trans."';";
//echo $ca_id_perfil;
$eje_CadIDPErf = mysql_query($ca_id_perfil);
$res_cadIDPErf = mysql_fetch_row($eje_CadIDPErf);
$resID = $res_cadIDPErf[0];
//echo $resID;

$cad_DetPerf = "SELECT * FROM t_detalle_perfil , t_plancuentas WHERE  DETP_CUENTA = PCU_CUENTA and DETP_FK_IDPERFIL = ". $resID.";";
$EjecCadDeta = mysql_query($cad_DetPerf);

if (mysql_num_rows($EjecCadDeta)== 0) {
	echo "<p style='font-size:20px;background:red;text-align:center;border-radius:3px;'>No le ha asignado cuentas para este tipo de transacción</p>";
} else {
	echo "<table style='width:100%;'><tr><td colspan='6'>Detalle del perfil</td></tr>";
	while ($RsDetP = mysql_fetch_array($EjecCadDeta)) {
		?>
		<tr>
			<td><input type="text" class="cl_txt" value="<?php echo $RsDetP['DETP_CODRET']; ?>" class="cl_txt3" style="width:30px;text-align:center;" readonly/></td><!--este campo DETP_CODRET nos basaremos en el orden para el sp-->
			<td>
				<input type="text" class="cl_txt" value="<?php echo $RsDetP['PCU_DESCRIPCION']; ?>" style="width:400px" readonly/><br>
				<input type="hidden" class="cl_txt" value="<?php echo $RsDetP['IDT_DETALLE_PERFIL']; ?>" readonly/>
			</td>
			<td><input type="text" class="cl_txt" value="<?php echo $RsDetP['PCU_CUENTA']; ?>" style="width:120px" readonly/></td>
			<td><input type="text" class="cl_txt3" value="<?php echo $RsDetP['DETP_TIPO']; ?>" readonly/></td>
			<td><input type="text" class="cl_txt3" value="<?php echo $RsDetP['DETP_PORCENTAJE']; ?>" readonly/></td>
			<td><input type="button" value="E" title="Cambiar cuenta" onclick="mostraFormCuen('<?php echo $RsDetP['PCU_DESCRIPCION']; ?>',
				'<?php echo $RsDetP['IDT_DETALLE_PERFIL']; ?>','<?php echo $RsDetP['PCU_CUENTA']; ?>',
				'<?php echo $RsDetP['DETP_TIPO']; ?>','<?php echo $RsDetP['DETP_PORCENTAJE']; ?>');">
			</td>
		</tr>
		<?php
	}
	?>
		<tr>
			<td colspan="6">
				<div class="cl_div_formNewCuent" id="id_div_formNewCuent" style="display:none;width:100%;">
					<table style="width:100%;">
						<tr>
							<td colspan="6">
								<p style="font-size:20px">Edite la cuenta seleccionada</p><hr>
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="cl_txt" name="c_newNumOrden" id="id_newNumOrden" style="width:30px;text-align:center;">
							</td>
							<td>
								<input type="text" class="cl_txt" name="c_newNomCuent" id="id_newNomCuent" style="width:380px" onkeyup="buscarcuentas(this.value,'7');"><br>
								<input type="hidden" class="cl_txt" name="c_idt_detperf" id="id_idt_detperf"  style="width:20px">
								<div class="cl_div_clientes" id="id_div_cuentas">
												
								</div>
							<td/>
							<td><input type="text" class="cl_txt" name="c_newCodCuent" id="id_newCodCuent" style="width:100px" readonly/></td>
							<td>
								<select name="c_newTipoHab" id="id_newTipoHab" class="cl_cmb" style="width:120px">
									<option value="">Seleccione..</option>
									<option value="D">DEBE</option>
									<option value="H">HABER</option>
								</select>
							</td>
							<td><input type="text" class="cl_txt3" name="c_newPorcent" id="id_newPorcent" style="width:50px"></td>
							<td><input type="button" value="G" title="Cambiar cuenta" onclick="ActCuentaDetPerf();"></td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
	<?php
}

}else{
	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}