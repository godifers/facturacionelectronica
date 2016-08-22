<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="lib/addclientes.php" method="post" name="frm_addclientes" id="id_frm_addclientes" autocomplete="off">
		<div class="cl_adminclientes">
			<table>
				<tr>
					<td colspan="4"><h3 style="text-align:center;">REGISTRO DE NUEVOS CLIENTES</h3></td>
				</tr>
				<tr>
					<td>Buscador</td>
				</tr>
				<tr>
					<td colspan="4">
						<input type="text" class="cl_txt" autocomplete="off" name="c_datosprov" id="id_clienteprovee_glo" onkeyup="buscaracli('3','<?php echo $_SESSION['empresa'] ?>')" placeholder="Busque por Nombre y Apellido" style="width:475px; height:15px;">
						<input type="text" class="cl_txt" name="c_texto_cli" id="id_texto_cli" style="width:120px;background:green;" value="NUEVO." readonly><br>
						<input type="hidden" class="cl_txt" name="c_identificador" id="id_identificador" style="width:120px;" value="0" readonly>						
						<div class="cl_div_clientes" id="id_div_clientes">
						
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="4">Nombres:</td>
				</tr>
				<tr>
					<td colspan="4">
						<input type="text" class="cl_txt" name="c_adcnombre" id="id_adccliente" placeholder="Ingrese Nombres" style="width:600px; height:15px;" required/>
					</td>
				</tr>
				<tr>
					<td colspan="4">Apellidos:</td>					
				</tr>
				<tr>
					<td colspan="4">
						<input type="text" class="cl_txt" name="c_adcapellido" id="id_adcapellido" placeholder="Ingrese Nombres" style="width:600px; height:15px;" required/>
					</td>
					
				</tr>
				<tr>
					<td>Teléfono</td>
					<td>Documento</td>
					<td>Número de doc.</td>
					<td>Contribuyente: </td>
				</tr>
				<tr>
					<td><input type="text" class="cl_txt" name="c_adctelf" id="id_adctelf" placeholder="Teléfono" style="height:15px;" required/></td>
					<td><select name="c_adcdumento" id="id_adcdumento" class="cl_cmb" style="width:150px; height:22px;" onchange="val_tipo_doc();">
						<option value="0">Seleccione..</option>
						<option value="1">Cédula</option>
						<option value="2">RUC</option>
						<option value="4">Extranjero</option>
					</select></td>
					<td><input type="text" class="cl_txt" name="c_adcnumdoc" id="id_adcnumdoc" placeholder="N° Documento" onblur="val_tipo_doc();" style="height:15px;width:150px;" maxlength="13" required/></td>
					<td>
						<select name="c_adccontribuyente" id="id_adccontribuyente" class="cl_cmb" style="width:125px; height:22px;" required/>
							<option value="0">Seleccione</option>
							<option value="1">Público</option>
							<option value="2">Cont. Especial</option>
							<option value="3">Oblig. Cont</option>
							<option value="4">No Oblig. Cont</option>
							<option value="5">RISE</option>
							<option value="6">Exportador</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">Dirección</td>
					<td>Ciudad</td>
					<td>Cupo Crédito</td>
				</tr>
				<tr>
					<td colspan="2"><input type="text" class="cl_txt" name="c_adcdirecc" id="id_adcdirecc" placeholder="Dirección" style="height:15px;" required/></td>
					<td><input type="text" class="cl_txt" name="c_adcciudad" id="id_adcciudad"style="height:15px;width:150px;" required/></td>
					<td>
						<?php 
						if ($_SESSION['cargo']== 1) {
							?>
							<input type="number" step="0.01" class="cl_txt" name="c_adccredito" id="id_adccredito" style="height:15px;width:125px;" required/>
							<?php 
						}else{
							?>
							<input type="number" step="0.01" class="cl_txt" name="c_adccredito" id="id_adccredito" value ="0.00" style="height:15px;width:125px;" readonly/>
							<?php 
						}
						 ?>
						
					</td>
				</tr>
				<tr>
					<td colspan="2">Mail</td>
					<td>Estado</td>
					<td>Tipo.</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="email" class="cl_txt" name="c_adcmail" id="id_adcmail" style="height:15px;" placeholder="mail@mail.com" required/>
						</td>
					<td>
						<select name="c_adcestado" id="id_adcestado" class="cl_cmb" style="height:22px;width:100px;">
							<option value="1">ACTIVO</option>
							<option value="2">INACTIVO</option>
						</select>
					</td>
					<td>
						<select name="c_tipo" id="id_tipo" class="cl_cmb">
							<option value="1">Cliente</option>
							<option value="2">Proveedor</option>
							<option value="3">Client. y Prov</option>
						</select>
						<input type="hidden" class="cl_txt" name="c_adcplazo" id="id_adcplazo" style="height:15px;width:125px;" value="0">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Plazo. 
						<select name="c_plazo" id="id_plazo" class="cl_cmb">
							<option value="0">0</option>
							<option value="15">15</option>
							<option value="30">30</option>
							<option value="45">45</option>
							<option value="60">60</option>
							<option value="90">90</option>
						</select>
					</td>
					<td colspan="2" align="right">
						<div class="cl_divbotons" id="id_divbotons" style="margin-top:15px;">
							<!-- <a href="rptreportes_cli.php">Reporte</a>
							<input type="button" class="cl_btn" name="c_reportxlsclient"id="id_reportxlsclient" onClick="javascript=window.open('rptreportes_cli.php');" value="Reporte Clientes">-->
							<input type="button" class="cl_btn" id="id_button" value="Salir"> 
							<input type="button" class="cl_btn" id="id_button" value="Limpiar">
							<input type="submit" class="cl_btn" id="id_guardardatosclientes" value="Guardar">
						</div>
					</td>
				</tr>				
			</table>
		</div>
	</form>
	
</body>
</html>