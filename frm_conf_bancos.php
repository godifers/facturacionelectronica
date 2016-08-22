<?php 
if ($_SESSION['cargo']==1) {
	include("lib/phpconexcion.php");
	$enlace = conectar_buscadores();
	$cad_bancos_Act = "SELECT BAN_BANCCO , BAN_CUENTA, PCU_DESCRIPCION, BAN_ESTADO, IDT_BANCO , USU_LOGER , BAN_FECHA_ED
 	FROM t_bancos , t_plancuentas, t_usuario where PCU_CUENTA=BAN_CUENTA AND IDT_USUARIO = BAN_USER";
	//echo $cad_bancos_Act;
	$ejec_cad_bancos = mysql_query($cad_bancos_Act);
	?>
	<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>frm_cambiar inventario</title>
</head>
<body>
	<form action="" style="width:1000px; margin: 0 auto ;">
		<table style="width:100%;">
			<tr>
				<td colspan="4">
					<h4>Administre las excepciones</h4><hr>
				</td>
			</tr>
			<tr>
				<td>NOM. BANCO</td>
				<td>BUSQUE UNA CUENTA PARA </td>
				<td>CODIGO</td>
				<td></td>
			</tr>
			<tr>
				<td>
					<input type="text" class="cl_txt" name="c_nom_banco" id="id_nom_banco" style="width:200px;height:18px;">
				</td>
				<td>
					<input type="text" class="cl_txt" name="c_cuenta" id="id_movcuentaingresar" style="width:500px;height:18px;" onkeyup="buscarcuentas(this.value,'1');">
					<div class="cl_div_clientes" id="id_div_cuentas">
						
					</div>
				</td>
				<td align="right"><input type="text" class="cl_txt" name="c_codigo_cuent" id="id_movcodcuenta" style="width:120px;height:18px;" readonly/></td>
				<td><input type="button" value="Guardar" onclick="guardar_banco();"></td>
			</tr>
			<tr>
				<td colspan="4">
					<div class="cl_res_excepcion" id="id_res_excepcion">
						
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table class="cl_tabresultados">
						<tr>
							<td><strong style="font-size:12px;">BANCO</strong></td>
							<td><strong style="font-size:12px;">CUENTA CONTABLE</strong></td>
							<td><strong style="font-size:12px;">DESCRIPCION DE CUENTA</strong></td>
							<td><strong style="font-size:12px;">GENERADO POR</strong></td>
							<td><strong style="font-size:12px;">EN.</strong></td>
							<td><strong style="font-size:12px;">ESTADO</strong></td>
							<td><strong style="font-size:12px;"></h4></td>
						</tr>
					
					<?php 
					while ($res_bancos= mysql_fetch_array($ejec_cad_bancos)) {
						//EXC_CUENTA, PCU_DESCRIPCION, EXC_TIPO_TRANS,EXC_FECHA, USU_LOGER 
						if ($res_bancos['BAN_ESTADO']==0) {
							$tip_Tr = '<p style="margin:3px 0 3px 0;background:#FDD275;">DESACTIVADO</p>';
						} else  {
							$tip_Tr = '<p style="margin:3px 0 3px 0;background:#4BC97C;">ACTIVO</p>';
						}
						
						?>
						<tr>
							<td><input type="text" class="cl_txt" id="" value="<?php echo $res_bancos['BAN_BANCCO']; ?>" style="width:150px;" readonly/></td>
							<td><input type="text" class="cl_txt" id="" value="<?php echo $res_bancos['BAN_CUENTA']; ?>" readonly/></td>
							<td><input type="text" class="cl_txt" id="" value="<?php echo utf8_encode($res_bancos['PCU_DESCRIPCION']); ?>" style="width:400px;" readonly/></td>
							<td><input type="text" class="cl_txt" id="" value="<?php echo $res_bancos['USU_LOGER']; ?>" readonly/></td>
							<td><input type="text" class="cl_txt" id="" value="<?php echo $res_bancos['BAN_FECHA_ED']; ?>" style="width:100PX;;" readonly/></td>
							<td><?php echo $tip_Tr; ?></td>							
							<td>
								<?php
								if ($res_bancos['BAN_ESTADO']==0) {
									?>
									<input type="button" value="Activar" onclick="eliminar_activar_banc('<?php echo $res_bancos['IDT_BANCO']; ?>','<?php echo $res_bancos['BAN_ESTADO']; ?>');">
									<?php 
								} else  {
									?>
									<input type="button" value="Eliminar" onclick="eliminar_activar_banc('<?php echo $res_bancos['IDT_BANCO']; ?>','<?php echo $res_bancos['BAN_ESTADO']; ?>');">
									<?php
								}
								?>
							</td>
						</tr>
						<?php 
					}
					 ?>
					 </table>
				</td>
			</tr>
		</table>
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
?>