<?php 
if ($_SESSION['cargo']==1) {
include("lib/phpconexcion.php");
$enlace = conectar_buscadores();
$cad_bancos = "SELECT IDT_BANCO, BAN_BANCCO , BAN_CUENTA FROM t_bancos  where BAN_ESTADO =1";
$eje_cad_bancos = mysql_query($cad_bancos);
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
					<td colspan="5" align="center"><h3 style="margin:20px auto; border-bottom: solid 2px #e89980;">MOVIMIENTOS DE CUENTAS POR EMPRESA</h3></td>
				</tr>
				<tr>
					<td>Seleccione una cuenta</td>
					<td>Código cuenta</td>
					<td>Fecha Desde</td>
					<td>Fecha Hasta</td>
				</tr>
				<tr>
					<td><input type="text" class="cl_txt" name="c_movcuentaingresar" id="id_movcuentaingresar" onkeyup="buscarcuentas(this.value,'6')" style="width:400px;height:19px;" placeholder="Ingrse una cuenta">
					<div class="cl_div_clientes" id="id_div_cuentas">
						
					</div>
					</td>
					<td><input type="text" class="cl_txt" name="c_movcodcuenta" id="id_movcodcuenta" style="width:120px;height:19px;" placeholder ="1.1.1.01.01" readonly/></td>
					<td><input type="date" class="cl_dat" name="c_movdesde" id="id_movdesde" style="width:140px"></td>
					<td><input type="date" class="cl_dat" name="c_movhasta" id="id_movhasta" style="width:140px"></td>
					<td align="right"><input type="button" name="c_movbuscar" id="id_movbuscar" value="Buscar Mov." onclick="reportemovcuentas();"></td>
				</tr>
				<tr>
					<td colspan="11">
						<div id="id_resultadoreport" class="cl_resultadoreport" style="width:1024px;min-heigth:auto;max-height:500px;overflow:auto;">
							
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