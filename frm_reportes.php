<?php
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
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
			<div>
				<table>
					<tr>
						<td colspan="12" align="center"><h3 style="margin:20px auto; border-bottom: solid 2px #e89980;">REPORTE DE VENTAS</h3></td>					
					</tr>
					<tr>
						<td colspan="12">Seleccione los campos que desees mostrar en la consulta</td>
					</tr>
					<tr>	
						<td><div style="width:80px;height:50px;margin:20px 0; "><input type="checkbox" class="cl_cbx" id="id_rvcompras"><h6 style="font-size:12px;font-weight: normal; padding:0; margin:0;" >Compras </h6> </div></td>
						<td><div style="width:80px;height:50px;margin:20px 0; "><input type="checkbox" class="cl_cbx" id="id_rvnotaventas"><h6 style="font-size:12px;font-weight: normal; padding:0; margin:0;" >Notas de Ventas </h6> </div></td>
						<td><div style="width:80px;height:50px;margin:20px 0; "><input type="checkbox" class="cl_cbx" id="id_rvgastos"><h6 style="font-size:12px;font-weight: normal; padding:0; margin:0;" >Gastos </h6> </div></td>
						<td><div style="width:80px;height:50px;margin:20px 0; "><input type="checkbox" class="cl_cbx" id="id_rvnotasc"><h6 style="font-size:12px;font-weight: normal; padding:0; margin:0;" >Notas de Crédito compras </h6> </div></td>					
						<td><div style="width:80px;height:50px;margin:20px 0; "><input type="checkbox" class="cl_cbx" id="id_rvventas"><h6 style="font-size:12px;font-weight: normal; padding:0; margin:0;" >Ventas </h6> </div></td>
						<td><div style="width:80px;height:50px;margin:20px 0; "><input type="checkbox" class="cl_cbx" id="id_rvnotasv"><h6 style="font-size:12px;font-weight: normal; padding:0; margin:0;" >Notas de crédito ventas </h6> </div></td>					
						<td><div style="width:80px;height:50px;margin:20px 0; "><input type="checkbox" class="cl_cbx" id="id_rvingreso"><h6 style="font-size:12px;font-weight: normal; padding:0; margin:0;" >Ingresos </h6> </div></td>
						<td><div style="width:80px;height:50px;margin:20px 0; "><input type="checkbox" class="cl_cbx" id="id_rvegreso"><h6 style="font-size:12px;font-weight: normal; padding:0; margin:0;" >Egresos </h6> </div></td>
						<td><div style="width:80px;height:50px;margin:20px 0; "><input type="checkbox" class="cl_cbx" id="id_rvrecibosc"><h6 style="font-size:12px;font-weight: normal; padding:0; margin:0;" >Recibos de cobros </h6> </div></td>
						<td><div style="width:80px;height:50px;margin:20px 0; "><input type="checkbox" class="cl_cbx" id="id_rvpagoprov"><h6 style="font-size:12px;font-weight: normal; padding:0; margin:0;" >Pagos a proveedores </h6> </div></td>
						<td><div style="width:100px;height:50px;margin:20px 0;"><input type="checkbox" class="cl_cbx" id="idt_guias"><h6 style="font-size:12px;font-weight: normal; padding:0; margin:0;" >Guias </h6> </div></td>
						<td><div style="width:80px;height:50px;margin:20px 0; "><input type="checkbox" class="cl_cbx" id="id_rvnotcont"><h6 style="font-size:12px;font-weight: normal; padding:0; margin:0;" >Notas Contables </h6> </div></td>					
					</tr>				
					<tr>
						<td colspan="5"><input type="date" class="cl_txt" id="id_rvdesde" style="width:400px;"></td>
						<td colspan="5"><input type="date" class="cl_txt" id="id_rvhasta" style="width:400px;"></td>
						<td colspan="2"><input type="button" class="cl_" id="id_" value="Buscar" onclick="reportetablas();"></td>
					</tr>
					<tr>
						<td colspan="12" align="right">
							Total: <input type="text" cl="cl_txt" id="id_rvtotal" name="c_rvtotal" style="width:200px;">
						</td>
					</tr>				
					<tr>
						<td colspan="12">
							<div id="id_resultadoreport" class="cl_resultadoreport" style="overflow:auto;height:auto;max-height:600px;">
								
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