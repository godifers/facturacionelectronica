<?php 
require_once("lib/phpconex.php");
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="lib/addproductos.php" method="post" name="frm_addprod" id="id_frm_addprod" autocomplete="off">
		<div>
			<table>
				<tr>
					<td colspan="8" align="center"><h3 style="margin:20px auto; border-bottom: solid 2px #e89980;">REGISTRO DE PRODUCTOS QUE INGRESAN</h3></td>
				</tr>
				<tr>
					<td>Buscador: </td>
					<td colspan="6"><input type="text" class="cl_txt" name="c_product" id="id_product" onkeyup="buscarprod(this.value,3,'<?php echo $_SESSION['empresa'] ?>');" style="width:100%;">

						<div class="cl_div_clientes" id="id_div_filtroprod">
						
						</div>
					</td>
					<td align="right">
						<input type="hidden" class="cl_txt"  name="c_regpident" id="id_regpident" VALUE="0">
						<input type="text" class="cl_accion" style="width:80px;background:green;" id="id_accion" VALUE="NUEVO.." readonly/></td>
				</tr>
				<tr>
					<td colspan="1">Código: </td>
					<td colspan="2"><input type="text" class="cl_txt" name="c_regpcod" id="id_regpcod" style="width:200px;"></td>
					<td colspan="5"> Código Barras: <input type="text" class="cl_txt" name="c_regpcodbarras" id="id_regpcodbarras" style="width:410px;"></td>
				</tr>
				<tr>
					<td>Detalle: </td>
					<td colspan="7" align="right"><input type="text" class="cl_txt" name="c_regpdetalle" id="id_regpdetalle" style="width:100%;"></td>
				</tr>
				<tr>
					<td>Presentación: </td>
					<td colspan="7"><input type="text" class="cl_txt" name="c_regppresent" id="id_regppresent" style="width:100%;"></td>
				</tr>
				<tr>
					<td>Estado</td>
					<td>Grupo</td>
					<td>Imp.</td>
					<td>Proveedor</td>
					<td align="right">V.Min</td>
					<td align="right">V.Med</td>
					<td align="right">V.Max</td>
					<td align="right">PVP</td>					
				</tr>
				<tr>
					<td><select name="c_regpestado" id="id_regpestado" class="cl_cmb" style="width:100px;">
						<option value="1">ACTIVO</option>
						<option value="0">INACTIVO</option>
					</select></td>
					<td><select name="c_regpgrupo" id="id_regpgrupo" class="cl_cmb" style="width:180px;">
							<?php 		
								$enlace = conectarbd();				
								$cadgrupo="SELECT * FROM t_grupo";
								$ejecadgrupo=mysql_query($cadgrupo);
								mysql_close($enlace);

								while ($resultgrupo=mysql_fetch_array($ejecadgrupo)) {

									?>
									<option value="<?php echo $resultgrupo['IDT_GRUPO'];?>"><?php echo $resultgrupo['GR_DETALLE'];?></option>

									<?php 
									}
							?>
						
						</select>
					</td>
					<td>
						<select name="c_regpimp" id="id_regpimo" class="cl_cmb">
							<option value="0">NO</option>
							<option value="1">SI</option>
								
						</select>
					</td>
					<td>
						<select name="c_regpprovee" id="id_regpprovee" class="cl_cmb" style="width:200px;" required/>
							<?php 				
								$enlace = conectarbd();		
								$cadprovee="SELECT * FROM t_client_provee where CP_TIPO_CLI_PROV='2' order by CP_NOMBRE asc";
								$ejcadprove=mysql_query($cadprovee);
								mysql_close($enlace);

								while ($resultprovee=mysql_fetch_array($ejcadprove)) {

									?>
									<option value="<?php echo $resultprovee['IDT_CLIENT_PROVEE'];?>"><?php echo utf8_encode($resultprovee['CP_NOMBRE'].' '.$resultprovee['CP_APELLIDO']);?></option>

									<?php 
									}

								?>							
						</select>
					</td>
					<td align="right"><input type="number" step="0.01" class="cl_txt2" name="c_regpvmin" id="id_regpvmin" style="width:60px;"></td>
					<td align="right"><input type="number" step="0.01" class="cl_txt2" name="c_regpvmed" id="id_regpvmed" style="width:60px;"></td>
					<td align="right"><input type="number" step="0.01" class="cl_txt2" name="c_regpvmax" id="id_regpvmax" style="width:60px;"></td>
					<td align="right"><input type="number" step="0.01" class="cl_txt2" name="c_regppvp" id="id_regppvp" style="width:60px;"></td>
				</tr>
				<tr>
					<td><div style="margin:10px;"></div></td>					
				</tr>
				<tr>
					<td colspan="8" align="right">
						<input type="button" value="Limpiar" onclick="javascript:location.reload();">
						<input type="button" value="Salir">
						<input type="submit" value="Guardar" class="cl_btn" id="id_invprodcutos">						
					</td>
				</tr>
				<tr>
					<td colspan="8">
						<div class="clvalComp" id="idValComp" style="width:100%;display:block;">
							<table style="margin:0;">
								<tr>
									<td colspan="3"><p style="font-size:20px;margin:0;padding:0;"><strong>Adminitar valor de compra</strong></p><hr></td>
								</tr>
								<tr>
									<td>Valor de compra</td>
									<td><input type="number" step="0.01" name="cValCompr" id="idValCompr"></td>
									<td><?php 
									if ($_SESSION['cargo'] == 1) {
										?>
										<input type="button" value="Actualizar Valor" onclick="actvalcompProd();">
										<?php
									}
									?></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="8">
						<div class="clDivAnuncioProd" id="idDivAnuncioProd" style="width:100%;">
							
						</div>
					</td>
				</tr>
			</table>
		</div>
	</form>
	
</body>
</html>