<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Document</title>
</head>
<body>
	<form action="">
		<div class="cl_movxcta" name="c_movxcta" id="id_movxcta">
			<table>
				<tr>
					<td colspan="5" align="center"><h3 style="margin:20px auto; border-bottom: solid 2px #e89980;">MOVIMIENTOS POR CUENTAS</h3></td>
				</tr>
				<tr>
					<td>Nombre de Cliente</td>
					<td>Código cuenta</td>
					<td>Fecha Desde</td>
					<td>Fecha Hasta</td>
				</tr>
				<tr>
					<td><input type="text" class="cl_txt" name="c_movcuentaingresar" id="id_movcuentaingresar" onkeyup="buscarcuentas(this.value,'1')" style="width:400px">
					<div class="cl_div_clientes" id="id_div_cuentas">
						
					</div>
					</td>
					<td><input type="text" class="cl_txt" name="c_movcodcuenta" id="id_movcodcuenta" style="width:120px"></td>
					<td><input type="date" class="cl_txt" name="c_movdesde" id="id_movdesde" style="width:140px"></td>
					<td><input type="date" class="cl_txt" name="c_movhasta" id="id_movhasta" style="width:140px"></td>
					<td><input type="button" class="cl_btn" name="c_movbuscar" id="id_movbuscar" value="Buscar Movimiento" onclick="reportemovcuentas();"></td>
				</tr>
				<tr>
					<td colspan="11">
						<div id="id_resultadoreport" class="cl_resultadoreport">
							
						</div>
					</td>
				</tr>
			</table>
		</div>
	</form>
	
</body>
</html>