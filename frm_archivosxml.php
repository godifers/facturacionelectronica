<?php 
if ($_SESSION['cargo']==1) {

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="">
		<div class="cl_movxcta" name="c_movxcta" id="id_movxcta">
			<table>
				<tr>
					<p style="font-size:20px;margin:0;"><strong>Lectura de archivos xml</strong></p>
					<hr>
				</tr>
				<tr>
					<td>Tipo de archivos</td>
					<td>Empresa</td>
					<td></td>
				</tr>
				<tr>
					<td>
						<select name="c_carpetta" id="id_carpeta">
						<option value="">Seleccione..</option>
						<option value="01_FACTURAS">01_FACTURAS</option>
						<option value="02_NOTAS_CREDITO_VENTAS">02_NOTAS_CREDITO_VENTAS</option>
						<option value="04_GUIAS_DE_REM">04_GUIAS_DE_REM</option>
						<option value="07_RETENCIONES">07_RETENCIONES</option>
						</select>
					</td>
					<td>
						<select name="c_empresa" id="id_empresa">
							<option value="">Seleccione..</option>
							<option value="001">Tulcán</option>
							<option value="002">San Gabr.</option>
						</select>
					</td>
					<td>
						<input type="number" step="1" name="c_max_fact" id="id_max_fact" placeholder="77600">
					</td>
					<td><input type="button" value="Bucar archivos" onclick="buscar_xmls();"></td>
				</tr>
				<tr>
					<td colspan="4">
						<div class="cl_res_arc" id="id_res_arch">
							
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
		<p>ACCESO RESTRINGIDO</p>
		<img src="img/error.png" alt="" style="width:520x;">
	</div>
	<?php
}	
?>