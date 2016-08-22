<?php 
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user']) and $_SESSION['empresa']== 1) {
	require("lib/phpconex.php");
	//IDT_FORMAS_PAG0, TP_DESCRIPCION, TP_TIPO_TRANSFER, TP_ESTADO, TP_EMPRESA, TP_OFFI
	$enlace = conectarbd();
	$queryformaspago="SELECT IDT_FORMAS_PAG0, TP_DESCRIPCION FROM t_formas_pago 
			where TP_TIPO_TRANSFER = 'V' and IDT_FORMAS_PAG0>0 ";
	//echo $queryformaspago;
	$ejecformaspago = mysql_query($queryformaspago);
	mysql_close($enlace);
	//oci_execute($ejecformaspago);	
	$valf= date("Y/m/d");
	//echo $valf;		
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Compras</title> 
</head>
<body>
	<form action="lib/phpingreso_compras.php" method="post" name="frm_compras" id="id_frm_compras" autocomplete="off">		
		<div class="cl_datoscompra" id="id_datoscompra" style="width:1000px;margin:0 auto;">
			<table>
				<tr>
					<td colspan="7" align="center"><h3 style="margin:20px auto; border-bottom: solid 2px #e89980">INGRESO DE COMPRAS</h3></td>						
				</tr>					
				<tr>
					<td>Ingreso</td>
					<td>F. Pago</td>
					<td>Fec. Compra</td>
					<td>Plazo</td>
					<td>Fec. Pago</td>
					<td>Datos del Proveedor</td>						
				</tr>
				<tr>
					<td>
						<select name="c_ingreso" id="id_cingreso" class="cl_cmb" style="width:134px;">
							<option value="0">SELECCIONAR..</option>
							<option value="1">FACTURA</option>
							<option value="2">NOTAS DE VENTA</option>
							<option value="3">NOTAS DE CREDITO</option>
							<option value="4">LIQ. DE COM. BIENES Y SERV.</option>
							<option value="5">NOTAS DE DEBITO</option>
							<option value="0">-----------OTROS-----------</option>
							<option value="6">NOTA PEDIDO</option>
							<option value="7">TRASPASO</option>	
							<option value="8">DIEZ</option>	
							<option value="9">GUIA DE REMIÓN</option>	
						</select>
					</td>
					<td>
						<select name="c_formapago" id="id_cformapago" class="cl_cmb" style="width:134px;">	
							<option value="0">SELECCIONAR..</option>						
							<?php 
							while ($res_formapago = mysql_fetch_array($ejecformaspago)) {				
						    ?>
							<option value="<?php echo $res_formapago['IDT_FORMAS_PAG0']; ?>"><?php echo $res_formapago['TP_DESCRIPCION']; ?></option>							   	
						    <?php 
								}
							?>	 
						</select>
					</td>
					<td><input type="date" name="c_fechcompra" id="id_cfechcompra" max="<?php echo date('Y-m-d'); ?>" class="cl_dat" style="width:134px;" required/></td>
					<td><select name="c_plazo" id="cid_plazo" class="cl_cmb" onchange="plazodepago();" style="width:50px;">
						<option value="0">0</option>
						<option value="15">15</option>
						<option value="30">30</option>
						<option value="45">45</option>
						<option value="60">60</option>
						<option value="90">90</option>
					</select></td>
					<td><input type="text" name="c_fechpago" id="id_cfechpago" class="cl_txt" style="width:100px;" readonly/></td>
					<td colspan="2">
						<input type="text" name="c_datosprov" id="id_clienteprovee_glo" class="cl_txt" style="width:270px;" onkeyup="buscaracli('2','<?php echo $_SESSION['empresa']; ?>');" required/>
						<input type="text" name="c_ruc_ced" id="id_ruc_ced"  class="cl_txt" style="width:120px;" readonly/><br>
						<input type="hidden" name="c_id_prov_cli" id="id_prov_cli">
						<div class="cl_div_clientes" id="id_div_clientes">
					
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="3">FACTURA N° 
						<input type="text" name="c_numserie" id="id_numserie" class="cl_txt" maxlength="3" placeholder="001" style="width:50px" required/>
						<input type="text" name="c_numserie2" id="id_numserie2" class="cl_txt" maxlength="3" placeholder="001" style="width:50px" required/>
						<input type="text" name="c_num" id="id_num" class="cl_txt" maxlength="9" placeholder="000000001" style="width:150px;" required/></td>
					<td colspan="4" align="right">
						Autorización <input type="text" name="c_autorizacion" id="id_autorizacion" class="cl_txt" style="width:300px;" required/>
						<input type="text" name="c_contribuyente" class="cl_txt" id="id_contribuyente" style="width:147px;" readonly/>
					</td>
				</tr>					
				<tr>
					<td colspan="4"> Observaciones <br>	
						<input type="text" name="c_obervacion" id="id_observacion" class="cl_txt" style="width:99%">
					</td>
					<td colspan="2">
						Sustento Tributario <br>
						<select name="c_sustributario" id="id_sustributario" class="cl_cmb" style="width:320px;">
							<option value="0">SELECCIONAR..</option>
							<option value="01">01-Crédito tributario para la declaración del IVA</option>
							<option value="02">02-Costo o gasto para la declaración del impuesto a la renta </option>
							<option value="03">03-Activo fijo - Crédito  tributario para la declaración de IVA</option>
							<option value="04">04-Activo fijo - coto o gasto para la declaración  del imp. a la renta</option>
							<option value="05">05-Liquidación  de gastos de viaje. Hospedaje y alimentación a nombre de empleados</option>
							<option value="06">06-Inventario- Crédito  tributario para la declaración  del IVA</option>
							<option value="07">07-Inventario- Costo o Gasto para le declaración  de imp. al a renta</option>
							<option value="08">08-Valor pagado para solicitar reembolso de Gastos </option>
							<option value="09">09-Reembolso  de siniestros </option>
							<option value="10">10-Distribución  de dividendos, Beneficios o utilidades</option>
							<option value="11">11-Convenios de débito o recaudación para IFI´S</option>
							<option value="12">12-Impuesto  retenciones preduntivos</option>
							<option value="13">13-Valores reconocidas por entidades públicas a favor de sujetos pasivos</option>
						</select>
					</td>
					<td style="background:#BBBBBB;" align="right">Parte Relacional <br>
						SI  <input type="radio" value="SI" name="c_parterel">
						NO  <input type="radio" value="NO" name="c_parterel" checked/>							
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<input type="button" class="cl_btn" value="Ingreso Inventario" onclick="validacioncampos('1');" ></input>
						<input type="button" class="cl_btn" value="Ingreso Gastos" onclick="validacioncampos('2');"></input>
						<input type="button" class="cl_btn" value="Nota de Crédito" onclick="validacioncampos('3');" ></input>
						<input type="hidden" name="c_identificador" id="id_identificador" value="C" style="width:10px;" required/>
					</td>
					<td colspan="3" align="right">
						<input type="button" class="cl_btn" value="Limpiar"></input>
						<input type="button" class="cl_btn" value="Salir"></input>
					</td>
				</tr>
				<tr>
					<td colspan="7"><!-- ----------------------------------------------------------------------------------------------- -->
						<div class="cl_invent" id="id_invent"  style="width:100%;margin:0 auto; display:none;">
							<table class="cl_tabresultados"  style="width:100%;">
								<tr>
									<td colspan="2"><h4 style="background:green;">INGRESO DE PRODUCTOS</h4></td>
									<td colspan="8"><hr></td>
								</tr>
								<tr>
									<td>Descripción</td>
									<td>Cod.</td>
									<td>Cant.</td>
									<td>V. Com</td>
									<td>Val. Min</td>
									<td>Val. Med</td>
									<td>Val. Max</td>
									<td>Val. PVP</td>
									<td>Total</td>
									<td></td>
								</tr>
								<tr>
									<td><input type="text" class="cl_txt" name="c_descripcion" id="id_descripcion" onkeyup="buscarprod(this.value,2,'<?php echo $_SESSION['empresa'] ?>');" style="width:350px;">
										<input type="hidden" name="c_invcompra" id="id_inivacompra" style="width:30px;">
										<div class="cl_div_clientes" id="id_div_filtroprod">
									
										</div>
									</td>
									<td><input type="text" class="cl_txt" name="c_cod" id="id_cod" style="width:65px"></td>
									<td><input type="text" class="cl_txt" name="c_cant" id="id_cant" onblur="sacarvaltot(2);"style="width:65px"></td>
									<td><input type="number" step="0.00001" class="cl_txt" name="c_vcompra" id="id_vcompra" onblur="sacarvaltot(2);" style="width:65px"></td>
									<td><input type="number" step="0.01" class="cl_txt" name="c_valmin" id="id_valmin" style="width:65px"></td>
									<td><input type="number" step="0.01" class="cl_txt" name="c_valmed" id="id_valmed" style="width:65px"></td>
									<td><input type="number" step="0.01" class="cl_txt" name="c_valmax" id="id_valmax" style="width:65px"></td>
									<td><input type="number" step="0.01" class="cl_txt" name="c_valpvp" id="id_valpvp" style="width:65px"></td>
									<td><input type="number" step="0.01" class="cl_txt" name="c_total" id='id_valtotp' style="width:65px"></td>
									<td><input type="button" class="cl_btn" onclick="ingresoinventario();" value=" + "></input></td>
								</tr>
								<tr>
									<td colspan="10">
										<div class="cl_detalleinventario" id="id_detalleinventario">								
										</div>
									</td>
								</tr>
							</table>
						</div><!-- ----------------------------------------------------------------------------------------------- -->
					</td>
				</tr>
				<tr>
					<td colspan="7">
						<!-- ------------------------------------------------------------------------------------------------------ -->
						<div class="cl_div_notas_cred" id="id_div_notas_cred"  style="width:100%;display:none;max-height:250px;overflow:auto;">
							
						</div>
						<!-- ------------------------------------------------------------------------------------------------------ -->
					</td>
				</tr>	
				<tr>
					<td colspan="7">
						<!-- ------------------------------------------------------------------------------------------------------ -->
						<div class="cl_gastos" id="id_gastos" style="width:100%;margin:0 auto;display:none;">
							<table class="cl_tabresultados"  style="width:100%;">
								<tr>
									<td><h4 style="background:green;">INGRESO DE GATOS</h4></td>
									<td colspan="4"><hr></td>
								</tr>
								<tr>
									<td>Concepto del Gasto</td>
									<td>CANTIDAD</td>
									<td>VAL. UNIT</td>
									<td>VAL. TOT</td>
									<td></td>			
								</tr>
								<tr>
									<td><input type="text" class="cl_txt" name="c_descripcion_gast" id="id_descripcion_gast" style="width:370px;"></td>
									<td><input type="number" step="0.01" class="cl_txt2" name="c_cant_gast" id="id_cant_gast" style="width:110px;"></td>
									<td><input type="number" step="0.01" class="cl_txt2" name="c_val_unit_gast" id="id_val_unit_gast" style="width:110px;"></td>
									<td><input type="number" step="0.01" class="cl_txt2" name="c_val_tota_gast" id="id_val_tota_gast" style="width:110px;"></td>
									<td><input type="button" value="+" onclick="construirgasto();"></td>				
								</tr>
								<tr>
									<td colspan="5">
										<div class="cl_detalle_gasto" id="id_detalle_gasto">
											
										</div>
									</td>
								</tr>
																
							</table>
						</div>	
						<!-- ------------------------------------------------------------------------------------------------------ -->
					</td>
				</tr>
				<tr>
					<td colspan="7">
						<div style="width:100%;display:none;" name="cl_div_asiento_comp" id="id_div_asiento_comp">
							<table style="width:100%;">
								<tr>
									<td><h4 style="background:green;">ASIENTO CONTABLE</h4></td>
									<td colspan="4"><hr></td>
								</tr>
								<tr>
									<td>CUENTAS</td>
									<td align="right">CÓDIGO</td>
									<td align="right">DEBE</td>
									<td align="right">HABER</td>	
									<td align="right"></td>						
								</tr>
								<tr>
									<td>
										<input type="text" class="cl_txt" name="c_cuenta" id="id_movcuentaingresar" style="width:600px" onkeyup="buscarcuentas(this.value,'2');">
										<div class="cl_div_clientes" id="id_div_cuentas">
											
										</div>
									</td>
									<td align="right"><input type="text" class="cl_txt" name="c_codigo_cuent" id="id_movcodcuenta" style="width:80px;"></td>
									<td align="right" align="right"><input type="number" step="0.01" class="cl_txt2" name="c_debe_cuent" id="id_recreciingreso" style="width:110px;"></td>
									<td align="right" align="right"><input type="number" step="0.01" class="cl_txt2" name="c_haber_cuent" id="id_recreciegreso" style="width:110px;"></td>
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
										<input type="number" step="0.01" name="c_total_debe" id="id_total_debe" value="0" class="cl_txt2" readonly/>
										<input type="number" step="0.01" name="c_total_haber" id="id_total_haber" value="0" class="cl_txt2" readonly/>
									</td>
								</tr>	
							</table>	
						</div>					
					</td>
				</tr>
				<tr>
					<td colspan="7">
						<div class="cl_div_otros_prod" id="id_div_otros_prod" style="width:100%;display:none;">
							<table style="width:100%;">
								<tr>
									<td><h4 style="background:green;">Ingreso de productos de las notas de credito </h4> </td>
									<td align="right" colspan="5"><hr></td>
								</tr>
								<tr>
									<td>Descripción</td>
									<td>Cod.</td>
									<td>Cant.</td>
									<td>V. unit</td>
									<td>Total</td>
									<td></td>
								</tr>
								<tr>
									<td>
										<input type="text" class="cl_txt" name="c_product" id="id_product_ingr_l" onkeyup="buscarprod2(this.value,6,'<?php echo $_SESSION['empresa'] ?>');"  style="width:480px"><br>						
										<div class="cl_div_clientes" id="id_div_filtroprod2">
								
										</div>
									</td>
									<td><input type="text" class="cl_txt" name="c_codprod" id="id_codprod_ingr_l" style="width:100px"></td>
									<td><input type="number" class="cl_txt2" name="c_cantpro" id="id_cantpro_ingr_l" style="width:75px" onblur="sacarvaltot_prod_l_costear();"></td>
									<td><input type="number" class="cl_txt2" step="0.00001" name="c_valprod" id="id_valprod_ingr_l" style="width:75px" onblur="sacarvaltot_prod_l_costear();"></td>
									<td><input type="number" class="cl_txt2" step="0.01" name="c_valtotp" id="id_valtotp_ingr_l" style="width:75px" onblur="sacarvaltot_prod_l_costear();" onkeyup="sacarvaltot_prod_l_costear();"></td>
									<td><input type="button"  onclick="datalle_l_ingreso();" value="+"></td>
								</tr>	
								<tr>
									<td colspan="6">
										<div class="cl_cj_datelle_ing_l" id="id_cj_datelle_ing_l">
											
										</div>
									</td>
								</tr>			
								<tr>
									<td colspan="6" align="right">
										<input type="number" step="0.01" class="cl_txt2" name="c_tot_ing_l" id="id_tot_ingr_l"  placeholder="0.00" style="width:75px;display:none;" readonly/>
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>

			<!-- ------------------------------------------------------------------------------------------------------ -->			
				<tr>
					<td colspan="7" align="right">Subtotal <input type="text" class="number" step="0.01" name="c_subt_inv" id="id_subt_inv" style="width:120px; text-align:right;" onkeyup="calcular_valo_nc_gast();" value="0.00" required/></td>						
				</tr>
				<tr>
					<td colspan="7" align="right">Bases Impo 12% <input type="text" class="number" step="0.01" name="c_base12_inv" id="id_base12_inv" style="width:120px; text-align:right;"onkeyup="calcular_valo_nc_gast();"  value="0.00" required/></td>						
				</tr>
				<tr>
					<td colspan="7" align="right">Base Impo 0% <input type="text" class="number" step="0.01" name="c_base0_inv" id="id_base0_inv" style="width:120px; text-align:right;"onkeyup="calcular_valo_nc_gast();"  value="0.00" required/></td>						
				</tr>
				<tr>
					<td colspan="7" align="right">IVA 12% <input type="text" class="number" step="0.01" name="c_iva_inv" id="id_iva_inv" style="width:120px; text-align:right;" onkeyup="calcular_valo_nc_gast();" value="0.00" required/></td>						
				</tr>
				<tr>
					<td colspan="7" align="right">TOTAL <input type="text" class="number" step="0.01" name="c_tot_inv" id="id_tot_inv" style="width:120px; text-align:right;"  value="0.00" required/></td>						
				</tr>
				<tr>
					<td colspan="7" align="right">
						<input type="button" class="cl_btn" value="Limpiar" onclick="javascript:location.reload();"></input>
						<input type="button" class="cl_btn" value="Cancelar" onclick="javascript:location.reload();"></input>
						<input type="submit" value="Guardar" class="cl_btn" id="btn_guardar_compras" style="display:none;">
					</td>						
				</tr>				
			<!-- ------------------------------------------------------------------------------------------------------ -->											
			</table>
			<div class="cl_borderbottom" style="width:100%;border: solid 1px #e89980; margin:10px auto;">				
			</div>
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
?>