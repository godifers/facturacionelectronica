<?php
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
	if ($_SESSION['cargo']==1) {
		include("lib/phpconexcion.php");
		$enlace = conectar_buscadores();
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Document</title>
	</head>
	<body>
		<form action="">
			<div>
				<table>
					<tr>
						<td colspan="3" align="center">
							<h4>ADMINITRACIÓN DE PLAN DE CUENTAS</h4>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							Buscador <br>
							<input type="text" class="cl_txt" id="id_nombreidcuenta" name="c_nombreidcuenta" style="width:700px;" onkeyup="buscarcuentas(this.value,'5');">
							<input type="text" class="cl_txt" id="id_identificador_txt" name="c_identificador_txt" style="width:100px;background:green;text-align:center;" value="NUEVO" readonly/><br>
							<input type="hidden" name="c_identific" id="id_identific" value="0">
							<div class="cl_div_clientes" id="id_div_cuentas" value="0" readonly/>
													
							</div>
						</td>
					</tr>
					<tr>
						<td>COD CUENTA</td>
						<td>NOMBRE</td>
						<td>CUENTA PADRE.</td>
					</tr>
					<tr>					
						<td><input type="text" name="c_cuenta" id="id_cuenta" class="cl_txt" style="width:150px;"></td>
						<td><input type="text" name="c_nom_cuentas" id="id_nom_cuentas" class="cl_txt" style="width:350px;"></td>
						<td>
							<select name="c_cuenta_pad" id="id_cuenta_pad" class="cl_cmb" style="width:300px;height:22px;" onchange="sacar_cuenta(this.value)">
								<option value="">NINGUNA..</option>
							<?php 
							$cad_cuenta_pad = "SELECT PCU_CUENTA, PCU_DESCRIPCION FROM t_plancuentas";
							$ejec_cad_cuenta_pad = mysql_query($cad_cuenta_pad);
							while ($res_cuen_pad = mysql_fetch_array($ejec_cad_cuenta_pad)) {
								?>
								<option value="<?php echo $res_cuen_pad['PCU_CUENTA']; ?>"><?php echo utf8_encode($res_cuen_pad['PCU_DESCRIPCION']); ?></option>
								<?php
							}
							?>
							</select> 
						</td>
					</tr>
					<tr>
						<td>CUENT. MOV ?</td>
						<td>SALDO INI TUL.</td>
						<td>SALDO INI SAN GA.</td>
					</tr>
					<tr>
						<td>
							<select name="c_mov" id="id_mov" class="cl_cmb" style="width:150px;height:22px;">
							<option value="">SELECCIONE</option>
							<option value="1">SI</option>
							<option value="0">NO</option>
							</select>
						</td>
						<td>
							<input type="number" step="0.01" name="c_saldo1" id="id_saldo1" class="cl_txt">
							<input type="hidden" name="c_idt1" id="id_idt1" style="width:30px;" value="0" readonly/>
						</td>
						<td>
							<input type="number" step="0.01" name="c_saldo2" id="id_saldo2" class="cl_txt">
							<input type="hidden" name="c_idt2" id="id_idt2" style="width:30px;" value="0" readonly/>
						</td>
					</tr>				
					<tr>
						<td colspan="3" align="right">
							<input type="button" value="Limpiar" onclick="javascript:location.reload();">
							<input type="button" value="Guardar" onclick="guardar_cuent_sald();">
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<div class="cl_Res_cuentas" id="id_Res_cuentas" style="width:100%;text-align:center;">
								
							</div>
						</td>
					</tr>
				</table>
			</div>
		</form>
		
	</body>
	</html>
	<?php 
	}else{
		?>
		<div class="" style="width:550px;height:550px;margin: 0 auto ;background:none;text-align:center;">
			<p>USTED NO PUEDE INGRESAR A ESTE MODULO ..(NO ESTA ASIGANDO CON PRIVILEGIOS)</p>
			<img src="img/error.png" alt="" style="width:520x;">
		</div>
		<?php
	}
}else{
	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}
?>