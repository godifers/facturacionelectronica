<?php 
if ($_SESSION['cargo']==1) {
	include("lib/phpconexcion.php");
	$enlace = conectar_buscadores();
	$cad_excep = "SELECT EXC_CUENTA, PCU_DESCRIPCION, EXC_TIPO_TRANS,EXC_FECHA, USU_LOGER , EXC_ESTADO,IDT_EXCEPC_CUENT
	from t_excepc_cuent, t_usuario, t_plancuentas where EXC_ESTADO=1 and  EXC_USU = IDT_USUARIO and PCU_CUENTA = EXC_CUENTA";
	//echo $cad_excep;
	$ejec_cad_excp = mysql_query($cad_excep);
	?>
	<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>frm_cambiar inventario</title>
</head>
<body>
	<form action="" style="width:800px; margin: 0 auto ;">
		<table style="width:100%;">
			<tr>
				<td colspan="4">
					<h4>Administre las excepciones</h4><hr>
				</td>
			</tr>
			<tr>
				<td>BUSQUE UNA CUENTA PARA </td>
				<td>CODIGO</td>
				<td>TIPO COMP.</td>
				<td></td>
			</tr>
			<tr>
				<td>
					<input type="text" class="cl_txt" class="cl_txt" name="c_cuenta" id="id_movcuentaingresar" style="width:550px;height:18px;" onkeyup="buscarcuentas(this.value,'1');">
					<div class="cl_div_clientes" id="id_div_cuentas">
						
					</div>
				</td>
				<td align="right"><input type="text" class="cl_txt" class="cl_txt" name="c_codigo_cuent" id="id_movcodcuenta" style="width:120px;height:18px;" readonly/></td>
				<td>
					<select name="c_tipo_trns" id="id_tipo_trans" class="cl_cmb">
						<option value="0">Seleccione</option>
						<option value="I">Ingresos.</option>
						<option value="J">Egresos.</option>
					</select>
				</td>
				<td><input type="button" value="Guardar" onclick="guradarexcepciones();"></td>
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
							<td><strong style="font-size:12px;">CUENTA</strong></td>
							<td><strong style="font-size:12px;">COD. CUENT.</strong></td>
							<td><strong style="font-size:12px;">TRANSAC AFECT.</strong></td>
							<td><strong style="font-size:12px;">CREADO POR.</strong></td>
							<td><strong style="font-size:12px;">CREADO EN</h4></td>
							<td></td>
						</tr>
					
					<?php 
					while ($res_execp = mysql_fetch_array($ejec_cad_excp)) {
						//EXC_CUENTA, PCU_DESCRIPCION, EXC_TIPO_TRANS,EXC_FECHA, USU_LOGER 
						if ($res_execp['EXC_TIPO_TRANS']=='I') {
							$tip_Tr = '<p style="margin:3px 0 3px 0;background:#FDD275;">INGRESOS</p>';
						} else  if ($res_execp['EXC_TIPO_TRANS']=='J'){
							$tip_Tr = '<p style="margin:3px 0 3px 0;background:#4BC97C;">EGRESOS</p>';
						}else{
							$tip_Tr = '<p style="margin:3px 0 3px 0;background:red;">OTROS</p>';
						}
						
						?>
						<tr>
							<td><input type="text" class="cl_txt" id="" value="<?php echo $res_execp['PCU_DESCRIPCION']; ?>" style="width:400px;"></td>
							<td><input type="text" class="cl_txt" id="" value="<?php echo $res_execp['EXC_CUENTA']; ?>" readonly/></td>
							<td><?php echo $tip_Tr;; ?></tcl_txtd>
							<td><input type="text" class="cl_txt" id="" value="<?php echo $res_execp['USU_LOGER']; ?>" readonly/></td>
							<td><input type="text" class="cl_txt" id="" value="<?php echo $res_execp['EXC_FECHA']; ?>" readonly/></td>
							<td><input type="button" value="Eliminar" onclick="eliminar_exc('<?php echo $res_execp['IDT_EXCEPC_CUENT']; ?>');"></td>
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