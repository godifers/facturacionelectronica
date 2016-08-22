<?php 
require_once('lib/phpconex.php')
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="lib/addusuario.php" method="post" enctype="multipart/form-data">
		<div class="cl_adminusuarios" id="id_adminusuarios">
			<table>
				<tr>
					<td colspan="4" align="center"><h3 style="margin:20px auto; border-bottom: solid 2px #e89980;">ADMINISTRACION DE USUARIOS</h3></td>	
				</tr>			
				<tr>
					<td>Login</td>
					<td>Cargo</td>					
					<td>Password</td>
					<td>Confirme Password</td>
				</tr>
				<tr>
					<td><input type="text" class="cl_txt" name="c_aduslogin" id="id_aduslogin" style="width:160px;" placeholder="Ingrese Usuario"></td>					
					<td><select name="c_aduscargo" id="id_aduscargo" style="height:20px;width:160px;">
						<option value="1">Administrador</option>
						<option value="2">Contador</option>
						<option value="3">Bodeguero</option>
						<option value="4">Contador</option>
					</select></td>
					<td><input type="password" class="cl_txt" name="c_aduspass" id="id_aduspass" style="width:145px;"></td>
					<td><input type="password" class="cl_txt" name="c_adusconfirmepass" id="id_adusconfirmepass" style="width:145px;"></td>
				</tr>
				<tr>
					<td colspan="2">Nombres</td>					
					<td colspan="2">Apellidos</td>
				</tr>	
				<tr>
					<td colspan="2"><input type="text" class="cl_txt" name="c_adusnombre" id="id_adusnombre" style="width:320px;" placeholder="Nombres"></td>
					<td colspan="2"><input type="text" class="cl_txt" name="c_adusapellido" id="id_adusapellido" style="width:320px;" placeholder="Apellidos"></td>
				</tr>		
				
				<tr>
					<td colspan="3">Empresa</td>
					<td>Estado</td>
				</tr>
				<tr>
					<td colspan="3"><select name="c_adusempresa" id="id_adusempresa" style="height:20px;width:390px;">
						<?php 		
								$enlace = conectarbd();				
								$cadempresa="SELECT * FROM t_empresa";
								$ejecadempresa=mysql_query($cadempresa);
								mysql_close($enlace);
								while ($resultempresa=mysql_fetch_array($ejecadempresa)) {
									//IDT_EMPRESA, EMP_RAZON_SOCIAL, EMP_RUC, EMP_DIRECCION, EMP_TELEFONO, EMP_IMPUESTO, EMP_PRIMER_FACT, EMP_FECH_CREA, EMP_COTIZACION, 
									//EMP_MAX_ITEMS, EMP_VALMIN_CF, EMP_NOMBRE, EMP_CODIGO, EMP_ESTADO, EMP_AMBIENTE, EMP_FECHA_TRABAJO,
									?>
									<option value="<?php echo $resultempresa['IDT_EMPRESA'];?>"
										><?php echo $resultempresa['EMP_RAZON_SOCIAL'];?></option>	
									<?php 
									}
							?>
					</select></td>
					<td><select name="c_adusestado" id="id_adusestado" style="height:20px;width:160px;">
						<option value="1">Activo</option>
						<option value="2">Inactivo</option>
					</select></td>
				</tr>
				<tr>
					<td colspan="4" align="right">
						<input type="button" class="cl_btn" id="id_botton" value="Nuevo">
						<input type="button" class="cl_btn" id="id_botton" value="Limpiar">
						<input type="button" class="cl_btn" id="id_botton" value="Eliminar">
						<input type="submit" class="cl_btn" id="id_botton" value="Guardar">
						<input type="button" class="cl_btn" id="id_botton" value="Salir">
					</td>
				</tr>
			</table>
		</div>
	</form>
	
</body>
</html>