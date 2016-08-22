<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="">
		<div class="cl_generareport" id="id_generareport">
			<table>
				<tr>
					<td colspan="5" align="center"><h3 style="margin:20px auto; border-bottom: solid 2px #e89980;">GENERACION DE REPORTE</h3></td>	
				</tr>
				<tr>
					<td></td>
					<td>Inicio</td>
					<td>Final</td>
					<td><input type="checkbox" class="cl_cbx">Total
					<input type="checkbox" class="cl_cbx">Por Cliente</td>
				</tr>
				<tr>
					<td>Escoja el Rango de Fechas: </td>
					<td><input type="date" class="cl_txt" name="c_grdesde" id="id_grdesde" style="width:250px;height:20px;"></td>
					<td><input type="date" class="cl_txt" name="c_grhasta" id="id_grhasta" style="width:250px;height:20px;"></td>
					<td><input type="button" class="cl_btn" id="id_button"value="Generar Informe"></td>
					<td><input type="button" class="cl_btn" id="id_button"value="Ver Informe"></td>
				</tr>
			</table>
		</div>
	</form>
</body>
</html>