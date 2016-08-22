<?php 
//echo $_SESSION['cargo'];
if ($_SESSION['cargo']==1) {
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
				<td colspan="2">
					<h4>Administre se inventario inicial</h4><hr>
				</td>
			</tr>
			<tr>
				<td>Busque el prodcuto</td>
				<td>Codigo</td>
			</tr>
			<tr>
				<td>
					<input type="text" class="cl_txt" id="id_producto_inv_ini" onkeyup="buscarprod(this.value,7,'<?php echo $_SESSION['empresa'] ?>')" style="width:600px;" >
					<div class="cl_div_clientes" id="id_div_filtroprod">
						
					</div>
				</td>
				<td><input type="text" class="cl_txt" id="id_cod_inv_ini" readonly/></td>
			</tr>
			<tr>
				<td colspan="2">
					Cantidad inicial <br><input type="text" class="cl_txt" name="c_canini_inv_ini" id="id_canini_inv_ini" value="0.00" readonly/> 
				</td>
			</tr>
			<tr>
				<td colspan="2">
					Nuevo valor  inicial <br> <input type="text" class="cl_txt" name="c_new_canini_inv_ini" id="id_new_canini_inv_ini"  required/>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
					<input type="button" value="Limpiar" onclick="javascript:location.reload();" style="padding:3px;">
					<input type="button" value="Actualizar" onclick="actualizarval_ini('<?php echo $_SESSION['empresa'] ?>');" style="padding:3px;">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<div class="cl_res_Actualizacion" id="id_res_actualizacion" style="width:100%;">
						
					</div>
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