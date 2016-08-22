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
					<td colspan="4" align="center"><h3 style="margin:20px auto; border-bottom: solid 2px #e89980;">MOVIMIENTOS DE CUENTAS POR EMPRESA</h3></td>
				</tr>
				<tr>
					<td>Seleccione una cuenta</td>
					<td>Fecha Desde</td>
					<td>Fecha Hasta</td>
					<td></td>
				</tr>
				<tr>
					<td>
						<select name="c_movcodcuenta" id="id_movcodcuenta" style="width:300px;">
							<option value="1.1.1.01.01">CAJA PRINCIPAL</option>
						</select>						
					</td>
					<td><input type="date" class="cl_dat" name="c_movdesde" id="id_movdesde" style="width:140px"></td>
					<td><input type="date" class="cl_dat" name="c_movhasta" id="id_movhasta" style="width:140px"></td>
					<td align="right"><input type="button" name="c_movbuscar" id="id_movbuscar" value="Buscar Mov." onclick="reportemovcuentas();"></td>
				</tr>
				<tr>
					<td colspan="4">
						<div id="id_resultadoreport" class="cl_resultadoreport" style="width:1024px;min-heigth:auto;max-height:500px;overflow:auto;">
							
						</div>
					</td>
				</tr>
			</table>
		</div>
	</form>	
</body>
</html>