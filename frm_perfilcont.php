<?php 
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
	if ($_SESSION['cargo']==1) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="">
		<table>
			<tr>
				<td colspan="4" align="center">
					<p style="font-size:20px;margin:0;">Administación de perfiles contables</p><hr>
				</td>
			</tr>
			<tr>
				<td><p style="margin:0;">Tipo trans.</p></td>
				<td><p style="margin:0;">Forma de pago.</p></td>
				<td><p style="margin:0;">Tipo contrib.</p></td>
				<td></td>
			</tr>
			<tr>
				<td>
					<select name="c_tipoTrans" id="id_tipoTrans" style="width:230px;" class="cl_cmb" onchange="limpiarDetP();">
						<option value="">Seleccione..</option>
						<option value="V">Ventas</option>
						<option value="C">Compras</option>
					</select>
				</td>
				<td>
					<select name="c_formaPag" id="id_formaPag" style="width:230px;" class="cl_cmb" onchange="limpiarDetP();">
						<option value="">Seleccione..</option>
						<option value="1">Contado</option>
						<option value="2">Credito</option>
					</select>
				</td>
				<td>
					<select name="c_TipoContrib" id="id_TipoContrib" style="width:230px;" class="cl_cmb" onchange="limpiarDetP();">
						<option value="">Seleccione..</option>
						<option value="1">Publicos.</option>
						<option value="2">Especiales.</option>
						<option value="3">Oblogados.</option>
						<option value="4">NO obligados.</option>
						<option value="5">Rise.</option>
						<option value="6">Pasaprote.</option>
						<option value="7">Extrangeros.</option>
					</select>
				</td>
				<td align="right">
					<input type="button" value="Buscar" onclick="cargar_Detalleperfil();">
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<div class="cl_divRespDetPerf" id="id_divRespDetPerf" style='width:100%;'>
						
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
}else{
	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}
?>