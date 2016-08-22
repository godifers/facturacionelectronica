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
	<form action="lib/php_ingre_egreso.php"  method="post" autocomplete="off">		
			<div class="cl_datosrecibo" >
				<table border="0">
					<tr>
						<td colspan="4" align="center"><h3 style="margin:20px auto; border-bottom: solid 2px #e89980;">ADMINISTRACION DE EGRESOS</h3></td>										
					</tr>
					<tr>
						<td colspan="4" align="right">N°
							<input type="text" class="cl_txt" name="c_recnum" class="cl_txt" id="id_recnum" style="width:80px;height:40px" readonly/>
						</td>
					</tr>
					<tr>
						<td>Entregue a</td>
						<td colspan="2">
							<input type="text" class="cl_txt" placeholder="Busque por Nombre o Cédula" name="c_datosprov" id="id_clienteprovee_glo"  onkeyup="buscaracli('4','<?php echo $_SESSION['empresa']; ?>')" style="width:470px;" required/>
							<br><input type="hidden" name="c_hdn_cli_prov" id="id_hdn_cli_prov" readonly/>
							<input type="hidden" class="cl_txt" name="c_identificador_ingresos_egresos" value="J" class="cl_txt" readonly/>
							<div class="cl_div_clientes" id="id_div_clientes">
						
							</div>
						</td>
						<td align="right"><input type="text" class="cl_txt" placeholder="Cédula" id="id_reccedul" readonly/></td>															
					</tr>
					<tr>
						<td>La cantidad de</td>
						<td colspan="3" align="right"><input type="text" class="cl_txt" name="c_valor_egre_ingr" id="id_valor_egre_ingr" placeholder="Ingrese valor en números" style="width:700px;" required/></td>																				
					</tr>
					<tr>
						<td>Por concepto de</td>
						<td colspan="3" align="right"><input type="text" class="cl_txt" name="c_concepro_egre_ingre" id="id_concepro_egre_ingre" placeholder="Ingrese el concepto" style="width:700px;" required/></td>																				
					</tr>
					<tr>
						<td>Ciudad</td>
						<td><input type="text" class="cl_txt" name="c_cuidad_egre_ingre" id="id_cuidad_egre_ingre" placeholder="Ingrese la ciudad" style="width:400px;" required/></td>
						<td>Fecha</td>
						<td align="right"><input type="date" class="cl_txt" name="c_fecha_recibo" id="id_fecha_recibo" required/></td>
					</tr>
					<tr>
						<td colspan="4">
							<div class="cl_descipcionrecibo"style="width:100%;">
								<table>
									<tr>
										<td>CUENTAS</td>
										<td align="right">CÓDIGO</td>
										<td align="right">DEBE/INGRE</td>
										<td align="right">HABER/EGRES</td>	
										<td align="right"></td>						
									</tr>
									<tr>
										<td>
											<input type="text" class="cl_txt" class="cl_txt" name="c_cuenta" id="id_movcuentaingresar" style="width:480px" onkeyup="buscarcuentas(this.value,'2');">
											<div class="cl_div_clientes" id="id_div_cuentas">
												
											</div>
										</td>
										<td align="right"><input type="text" class="cl_txt" class="cl_txt" name="c_codigo_cuent" id="id_movcodcuenta" style="width:80px;"></td>
										<td align="right"><input type="number" class="cl_txt" name="c_debe_cuent" id="id_recreciingreso" style="width:110px;"></td>
										<td align="right"><input type="number" class="cl_txt" name="c_haber_cuent" id="id_recreciegreso" style="width:110px;"></td>
										<td align="right"><input type="button" value="+" onclick="generartablacuentas();"></input></td>
									</tr>
									<tr>
										<td colspan="5">
											<div class="cl_div_asiento" id="id_div_asiento">
												
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="5" align="right">
											<input type="text" class="cl_txt" name="c_total_debe" id="id_total_debe" value="0" class="cl_txt2" style="width:100px;" readonly/>
											<input type="text" class="cl_txt" name="c_total_haber" id="id_total_haber" value="0" class="cl_txt2" style="width:100px;" readonly/>
										</td>
									</tr>	
									<tr>
										<td colspan="5" align="center">
											<input type="submit" name="c_btn_guardar_egreso" id="btn_guardar_compras" value="Guardar" style="display:none;padding:5px;background:green;color:#FFF;">
										</td>
									</tr>		
								</table>
							</div>
						</td>
					</tr>									
				</table >
			</div>
	</form>	
</body>
</html>
