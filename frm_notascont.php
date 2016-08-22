<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body onload="ocultarfrm_notascont();">
	<form action="lib/new_nontcont.php" method="post" style="width:900px;margin:0 auto;">		
		<div class="cl_ncinventario" id="id_ncinventario"> 
			<table style="width:100%;">	
				<tr>
					<td><h4>Ingrese el producto que sale</h4></td>
					<td align="right" colspan="5"><hr></td>
				</tr>
				<tr>
					<td colspan="6" align="right">
						<h4>Ingrese una fecha</h4><input type="date" name="c_fecha_notcon" id="fecha_not_cont" class="cl_dat" required/>
					</td>
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
						<input type="text" class="cl_txt" name="c_product_egre_l" id="id_product_egre_l" onkeyup="buscarprod(this.value,5,'<?php echo $_SESSION['empresa'] ?>');"  style="width:480px"><br>						
						<div class="cl_div_clientes" id="id_div_filtroprod">
				
						</div>
					</td>
					<td><input type="text" class="cl_txt" name="c_codprod_egre_l" id="id_codprod_egre_l" style="width:100px" readonly/></td>
					<td><input type="number" class="cl_txt2" name="c_cantpro_egre_l" id="id_cantpro_egre_l" style="width:75px" onblur="sacarvaltot_prod_l(1);"></td>
					<td><input type="number" class="cl_txt2" step="0.01" name="c_valprod_egre_l" id="id_valprod_egre_l" style="width:75px" onblur="sacarvaltot_prod_l(1);"></td>
					<td><input type="number" class="cl_txt2" step="0.01" name="c_valtotp_egre_l" id="id_valtotp_egre_l" style="width:75px" onblur="sacarvaltot_prod_l(1);"></td>
					<td><input type="button"  onclick="datalle_l_egreso();" value="+"></td>
				</tr>	
				<tr>
					<td colspan="6">
						<div class="cl_cj_datelle_egre_l" id="id_cj_datelle_egre_l">
							
						</div>
					</td>
				</tr>			
				<tr>
					<td colspan="6" align="right">
						Total: <input type="number" step="0.01" class="cl_txt2" name="c_tot_egre_l" id="id_tot_egre_l"  placeholder="0.00" style="width:75px;" readonly/>
						<input type="button" value=" x" style="background:red;" disabled/>
					</td>
				</tr>
				<!-- ---------------------------------------------------------------------------------------------------- -->
				<tr>
					<td><h4>Ingrese el producto de contraparte</h4> </td>
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
					<td><input type="number" class="cl_txt2" name="c_cantpro" id="id_cantpro_ingr_l" style="width:75px" onblur="sacarvaltot_prod_l(2);"></td>
					<td><input type="number" class="cl_txt2" step="0.01" name="c_valprod" id="id_valprod_ingr_l" style="width:75px" onblur="sacarvaltot_prod_l(2);"></td>
					<td><input type="number" class="cl_txt2" step="0.01" name="c_valtotp" id="id_valtotp_ingr_l" style="width:75px" onblur="sacarvaltot_prod_l(2);"></td>
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
						Total: <input type="number" step="0.01" class="cl_txt2" name="c_tot_ing_l" id="id_tot_ingr_l"  placeholder="0.00" style="width:75px;" readonly/>
						<input type="button" value=" x" style="background:red;" disabled/>
					</td>
				</tr>
				<!-- -------------------------------------------------------------------------------------------------------- -->
				<tr>
					<td><h4 style="background:green;">ASIENTO CONTABLE</h4></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="6">
						<div style="width:100%;">
							<table>
								<tr>
									<td>CUENTAS</td>
									<td align="right">CÓDIGO</td>
									<td align="right">DEBE</td>
									<td align="right">HABER</td>	
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
									<td colspan="4" align="right">
										<input type="number" class="cl_txt2" name="c_total_debe" id="id_total_debe" value="0" class="cl_txt2" style="width:100px;" readonly/>
										<input type="number" class="cl_txt2" name="c_total_haber" id="id_total_haber" value="0" class="cl_txt2" style="width:100px;" readonly/>
									</td>
									<td align="right"><input type="button" value="X" style="background:red" disabled="true"></input></td>
								</tr>	
								<tr>
									<td colspan="5" align="center">
										<input type="button" value="Salir" onclick="javascript:window.location='inicio.php'">
										<input type="button" value="Limpiar" onclick="javascript:location.reload();">
										<input type="submit" name="c_btn_guardar_nontcont" id="btn_guardar_compras" value="Guardar" style="display:none;">
									</td>
								</tr>		
							</table>
						</div>
					</td>
				</tr>
			</table>
		</div>		
	</form>
</body>
</html>