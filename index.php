<?php 
include('lib/phpconex.php');
$enlace = conectarbd();
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<link type="image/x-icon" href="img/favicon.png" rel="shortcut icon"/>
	<title>Sistemas de Facturación</title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/index.css">
</head>
<body>
	<div class="cl_cjinicio" id="id_cj_inicio">
		<div class="cl_cjbaners cl_cjcajas" id="id_cjbaners">
			<div class="cl_cjbaner"><?php echo date('d/m/y'); ?></div>			
			<?php 
			$consul="SELECT * from t_empresa";
			$ejecon=mysql_query($consul);
			mysql_close($enlace);

			while ($rescon=mysql_fetch_array($ejecon)) {
				?>
				<div class="cl_cjbaner" style="position:relative;">
					<span style="font-size:12px;position:absolute; top:-30px; left:10px;">
						<?php echo $rescon['EMP_NOMBRE']; ?>
					</span>
				
					<span style="font-size:35px; position:absolute;left:100px;">
						<?php echo $rescon['EMP_FECHA_TRABAJO']; ?>
					</span>
							
				</div>
				<?php 
			 }	 
			 ?>			
			<div class="cl_cjbaner"></div>
		</div>
		<div class="cl_cjlogin cl_cjcajas" id=cs"id_cklogin">
			<form action="lib/ingresosis.php" method="post" autocomplete="off" >
				<table>
					<tr><td><h4>Ingrese sus datos</h4></td></tr>
					<tr><td>Seleecione BD</td>
					<tr>
						<td>
							<select id="id_cmbbd" class="cl_cmb" name="c_empresa">
								<?php 						
								$enlace = conectarbd();
								$cadempresa="SELECT * FROM t_empresa";
								$ejecadempresa=mysql_query($cadempresa);
								mysql_close($enlace);

								while ($resultgrupo=mysql_fetch_array($ejecadempresa)) {

									?>
									<option value="<?php echo $resultgrupo['IDT_EMPRESA'];?>"><?php echo $resultgrupo['EMP_NOMBRE'];?></option>
									<?php 
									}
							?>								
							</select>
						</td>
					</tr>
					<tr><td>Usuario.</td></tr>
					<tr><td><input type="text" class="cl_txt" placeholder="Usuario" name="c_user" id="id_user"></td></tr>
					<tr><td>Clave./ Contraseña.</td></tr>
					<tr><td><input type="password" class="cl_txt" placeholder="Password" name="c_pass" id="id_pass"></td></tr>				
					<tr><td align="center"><input type="submit" value="Ingresar" class="cl_btn"></td></tr>					
				</table>
			</form>
		</div>
	</div>
</body>
</html>