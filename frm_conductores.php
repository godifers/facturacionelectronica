<?php 
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	?>
	<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Conductores</title>
</head>
<body onload="mostarconductores(1);">
	<form action="" style="width:auto; margin:0 auto;margin-top:10px;">
		<table class="cl_tabresultados">
			<tr>
				<td colspan="10">
					<h4 style="width:100%;text-align;center;">IDENTIFICACION DE LA PERSONA ENCARGADA DEL TRASPORTE</h4><br>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" class="cl_txt" name="c_identificador_con" id="id_identificador_con"  value="0" style="width:100px;" readonly/>
					<input type="text" class="cl_txt" name="c_alerta_con" id="id_aletra_con" value="NUEVO.."style="background:green;width:100px;" readonly/>
					<input type="text" class="cl_txt" name="c_idconductor" id="id_idconductor" style="width:20px;" readonly/>
				</td>
				<td colspan="9" align="right">
					Buscador:<input type="text" class="cl_txt" style="width:600px;" onkeyup="buscar_conduct(this.value,'2');">
					<div class="cl_div_clientes" id="id_buscadorconductores">
							
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="3">Nombre/Razon Sicial.</td>
				<td colspan="2">Cedula/Ruc/Id.</td>
				<td>Placas.</td>
				<td>Chasis.</td>
				<td>Color.</td>
				<td colspan="2">Marca.</td>
			</tr>
			<tr>
				<td colspan="3"><input type="text" class="cl_txt" name="c_conductor_con" id="id_conductor_con" style="width:300px;" required/></td>
				<td colspan="2"><input type="text" class="cl_txt" name="c_ruc_id_con" id="id_ruc_id_con" style="width:130px;" required/></td>
				<td><input type="text" class="cl_txt" name="c_placas_con" id="id_placas_con" style="width:70px;" required/></td>
				<td><input type="text" class="cl_txt" name="c_chasis_con" id="id_chasis_con" style="width:180px;"></td>
				<td><input type="text" class="cl_txt" name="c_color_con" id="id_color_con" style="width:70px;" required/></td>
				<td colspan="2" align="right"><input type="text" class="cl_txt" name="c_marca_con" id="id_marca_con" style="width:100px;" required/></td>				
			</tr>
			<tr>
				<td colspan="4">Descripción.<input type="text" class="cl_txt" name="c_descript_con" id="id_descript_con" style="width:250px;" required/></td>
				<td colspan="3">Modelo. <input type="text" class="cl_txt" name="c_modelo_con" id="id_modelo_con" style="width:250px;" ></td>
				<td colspan="3" align="right">
					
					<input type="button" value="Salir" name="c_btn" onclick="">
					<input type="button" value="Limpiar" name="c_btn" onclick="">
					<input type="button" value="Guardar" name="c_btn" onclick="saveconductor();">
				</td>
			</tr>
			<tr>
				<td colspan="10">
					<div class="cl_cjconductores" id="id_cjconductores">
						
					</div>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
	<?php 
} else {
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
}

 ?>