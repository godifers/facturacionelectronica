<?php 
	require("lib/phpconexcion.php");
	//$enlace = conectarbd();
	$enlace = conectar_buscadores();
	if (isset($_SESSION['empresa']) and isset($_SESSION['id_user']) ) {
	//IDT_FORMAS_PAG0, TP_DESCRIPCION, TP_TIPO_TRANSFER, TP_ESTADO, TP_EMPRESA, TP_OFFI
	$queryformaspago="SELECT IDT_FORMAS_PAG0, TP_DESCRIPCION FROM t_formas_pago 
			where TP_TIPO_TRANSFER = 'V' and IDT_FORMAS_PAG0>0 ";
	//echo $queryformaspago;
	$ejecformaspago = mysql_query($queryformaspago);
	//oci_execute($ejecformaspago);	
	//mysql_close($enlace);

	//$enlace = conectarbd();
	$enlace = conectar_buscadores();
	$cad_query_fecha_trab ="SELECT EMP_FECHA_TRABAJO from t_empresa where IDT_EMPRESA=".$_SESSION['empresa'];
	$res_emp = mysql_query($cad_query_fecha_trab);
	//mysql_close($enlace);
	$resultado_emp = mysql_fetch_row($res_emp);
	$fecha_trab = $resultado_emp[0];	
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>frm_facturacion</title>
</head>
<body>
	<form action="lib/newfactura.php" method="post" name="frm_factura" id="id_frm_Factura" autocomplete="off">
		<table border="0">
			<tr><td colspan="6"><h4 style="text-align:center;">Nueva Factura</h4></td></tr>
			<tr>
				<td>Cliente</td>
				<td>Ruc/Cédula.</td>
				<td>Tipo.</td>
				<td></td>
				<td>Seleccione tipo</td>
				<td>N° de factura</td>				
			</tr>
			<tr>
				<td>
					<input type="text" name="c_cliente" id="id_clienteprovee_glo" placeholder="Busque por nombre , ruc o Cédula" onkeyup="buscaracli('1','<?php echo $_SESSION['empresa'] ?>');" class="cl_txt" style="width:350px" required/>
					<br><input type="hidden" name="c_hdidcliente" id="id_hdidcliente" readonly/>					
					<div class="cl_div_clientes" id="id_div_clientes">
						
					</div>
				</td>
				<td><input type="text" name="c_ruc_ced" id="id_ruc_ced" placeholder="Cédula" class="cl_txt" style="width:130px" readonly/></td>
				<td><input type="text" name="c_tipoide" id="id_tipoide" placeholder="Cédula/ruc" class="cl_txt" style="width:70px" readonly/></td>
				<td><input type="button" name="cid_div_clientes_" placeholder="" class="cl_btn" value="Nuevo"></td>
				<td rowspan="2">
					<input type="radio" clas="cl_radio" value="V"  onclick="mostrarconductor(this.value);" name="c_ratiotipo" checked/>Factura. Elec<br>
					<input type="radio" clas="cl_radio" value="P"  onclick="mostrarconductor(this.value);" name="c_ratiotipo" disabled/>Proforma.<br>
					<input type="radio" clas="cl_radio" value="G"  onclick="mostrarconductor(this.value);" name="c_ratiotipo">Guia de remisión.<br>
					<input type="radio" clas="cl_radio" value="W"  onclick="mostrarconductor(this.value);" name="c_ratiotipo">Factura Manual.<br>
					<input type="radio" clas="cl_radio" value="X"  onclick="mostrarconductor(this.value);" name="c_ratiotipo" >(X) Docs. Desc. M<br>
				</td>
				<td rowspan="2">
					<input type="text" name="c_num_fact" id="id_num_fact" class="cl_txt" style="width:75px;padding:1.5em;text-align:center;">
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table style="width:100%;margin:0;">
						<tr>
							<td>Forma de pago.</td>
							<td>Cupo.</td>
							<td>Sal. Pen.</td>
							<td>Sal. Disp.</td>
							<td>Fecha act.</td>
							<td>Plazo</td>							
							<!--<td>Fecha pago</td>-->
						</tr>
						<tr>
							<td><select name="c_formapago" id="id_formapago" style="width:150px;" onchange="generardetalleventa();">
								<?php 
								while ($res_formapago = mysql_fetch_array($ejecformaspago)) {				
							   ?>
							   <option value="<?php echo $res_formapago['IDT_FORMAS_PAG0']; ?>"><?php echo $res_formapago['TP_DESCRIPCION']; ?></option>							   	
							   <?php 
								}
								 ?>
							</select></td>
							<td><input type="number" name="c_creddipo" id="id_creddipo" class="cl_txt2" style="width:75px;" readonly/></td>
							<td><input type="number" name="c_saldo_cli" id="id_saldo_cli" class="cl_txt2" style="width:75px;" readonly/></td>
							<td><input type="number" name="c_nuew_cupo" id="id_new_cupo" class="cl_txt2" style="width:75px;" readonly/></td>
							<td><input type="tetx" name="c_fechcventa" id="id_cfechcompra" class="cl_txt" style="width:90px;" value="<?php echo $fecha_trab; ?>" readonly/></td>
							<td>
								<select name="c_plazo" id="cid_plazo" class="cl_cmb" onchange="plazodepago();" style="width:60px;">
									<option value="0">0</option>
									<option value="15">15</option>
									<option value="30">30</option>
									<option value="45">45</option>
									<option value="60">60</option>
									<option value="90">90</option>
								</select>
							</td>
							<td><input type="hidden" name="c_fechpago" id="id_cfechpago" class="cl_txt" style="width:90px;"></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">Observación.</td>
				<td colspan="2">Parte relacioal</td>
				<td colspan="2" rowspan="2">
					<table>
						<tr>
							<td style="font-size:10px;">STOCK</td>
							<td style="font-size:10px;">V. MIN.</td>
							<td style="font-size:10px;">V. MAX.</td>
							<td style="font-size:10px;">V. PVP</td>
						</tr>
						<tr>
							<td><input type="text" name="c_stockact" id="id_stockact" class="cl_txt" style="width:40px;border-style:none;text-align:center;font-size:13px;" readonly></td>
							<td><input type="text" name="c_vmin" id="id_vmin" onclick="ponervalores(this.value);" class="cl_txt" style="width:40px;border-style:none;text-align:center;font-size:13px;" readonly/></td>
							<td><input type="text" name="c_vmed" id="id_vmed" onclick="ponervalores(this.value);" class="cl_txt" style="width:40px;border-style:none;text-align:center;font-size:13px;" readonly/></td>
							<td><input type="text" name="c_vmax" id="id_vmax" onclick="ponervalores(this.value);" class="cl_txt" style="width:40px;border-style:none;text-align:center;font-size:13px;" readonly/></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="text" name="c_observa" id="id_observa" class="cl_txt" style="width:450px"></td>
				<td colspan="2" align="center">
					SI.<input type="radio" class="cl_radio" name="c_relacional" value="SI"> 
					NO.<input type="radio" class="cl_radio" name="c_relacional" value="NO" checked/> 
				</td>				
			</tr>
			<tr>
				<td colspan="6">
					<div class="cl_div_Conductor_fact" id="id_div_Conductor_fact" style="border:solid 2px green;display:none;">
						<table style="width:100%;">
							<tr>
								<td><h4>SELECCIONE UN CODUCTOR</h4><hr></td>
							</tr>
							<tr>
								<td><strong>NOMBRE DEL CONDUCTOR</strong></td>
								<td><strong>PLACA</strong></td>
								<td><strong>DESCRIPCÓN</strong></td>
								<td><strong>COD CONDUCTOR</strong></td>
							</tr>
							<tr>
								<td>
									<input type="text" name="c_nombr_cond_fac" id="id_nombr_cond_fac" value="" class="cl_txt" placeholder="Busque por nombre de conductor o placa de vehículo" onkeyup="buscar_conduct(this.value,'1');" style="width:400px;" readonly/>
									<input type="hidden" name="c_ruc_cond_fact" id="id_ruc_cond_fact" readonly//>
									<div class="cl_div_clientes" id="id_buscadorconductores">
							
									</div>
								</td>
								<td><input type="text" name="c_palca_fact" id="id_palca_fact" value="" class="cl_txt" placeholder="PLACA" style="width:100px;" readonly/></td>
								<td><input type="text" name="c_descrip_fac" id="id_descrip_fac" value="" class="cl_txt" placeholder="DESCRIPCIÓN" style="width:200px;" readonly/></td>
								<td align="right"><input type="text" name="c_cod_cond_fac" id="id_cod_cond_fac" value="0" class="cl_txt" placeholder="COD CONDUCTUR." style="width:100px;" readonly/></td>
							</tr>
							<tr>
								<td>
									Dirección de partida
									<input type="text" class="cl_txt" name="c_direc_partida" id="id_direc_partida" placeholder="Dirección de partida" readonly/>
								</td>
								<td colspan="2">
									Dirección de llegada
									<input type="text" class="cl_txt" name="c_direc_llegada" id="id_direc_llegada" placeholder="Dirección de llegada" readonly/>
								</td>
								<td>
									Fecha de llegada <br>
									<input type="date" class="cl_dat" name="c_fecha_llegada_guia" id="id_fecha_llegada_guia"readonly/>
								</td>								
							</tr>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<table style="width:100%;">
						<tr>
							<td><h4>Ingreso de productos</h4></td>
						</tr>
						<tr>
							<td>Descripción</td>
							<td>Código</td>
							<td>Cantidad</td>
							<td>V. unit.</td>
							<td>V. tot</td>
							<td></td>
						</tr>
						<tr>
							<td>
								<input type="text" class="cl_txt" name="c_product" id="id_product" onkeyup="buscarprod(this.value,1,'<?php echo $_SESSION['empresa'] ?>');"  style="width:480px" placeholder="Busque un producto"><br>
								<input type="hidden" name="c_ivaprod" id="id_hdivapr" style="width:30px;">
								<input type="hidden" nmae="c_vacompra" id="id_vacompra" style="width:30px;">
								<div class="cl_div_clientes" id="id_div_filtroprod">
						
								</div>
							</td>
							<td><input type="text" class="cl_txt" name="c_codprod" id="id_codprod" style="width:100px" placeholder="Cod."></td>
							<td><input type="number" class="cl_txt" name="c_cantpro" id="id_cantpro" style="width:75px;background:#5F9B6D;text-align:center;color:#000;" onblur="sacarvaltot(1);" onkeyup="this.value = this.value.replace (/[^0-9]/, '');" placeholder="Cant"></td><!--onkeyup="validar_decimal(this.value);"-->
							<td><input type="number" step="0.01" class="cl_txt" name="c_valprod" id="id_valprod" style="width:75px;text-align:center;" onblur="sacarvaltot(1);" placeholder="$$.$$"></td>
							<td><input type="number" step="0.01" class="cl_txt" name="c_valtotp" id="id_valtotp" style="width:75px;text-align:center;" placeholder="$$.$$"  readonly/></td>
							<td><input type="button" class="cl_btn" onclick="detalleventa();" value="+"></td>
						</tr>
						<tr>						
							<td colspan="6">
								<div class="cl_cjdetallefact" id="id_cj_datellefact">
									
								</div>
							</td>
						</tr>
						<tr>
							<td rowspan="5" colspan="3">
								<!--inputs de tipo text-->
								<input type="hidden" name="c_sumcompra0" id="id_sumcompra0" value="0.00" readonly/><br>
								<input type="hidden" name="c_sumcompra12" id="id_sumcompra12" value="0.00" readonly/><br>
								<input type="hidden" name="c_idt_user" id="id_idt_user" value="0" readonly/>
								<div class="cl_div_aviso_factura" id="id_aviso_factura">
									
								</div>
							</td>
							<td colspan="3" align="right">
								Subtotal.<input type="number" step="0.01" name="c_subtotal" id="id_subtotal" placeholder="" class="cl_txt" style="text-align:right;width:100px;" required/>
							</td>
						</tr>
						<tr>
							<td colspan="3" align="right">
								Base 0%.<input type="number" step="0.01" name="c_base0" id="id_base0" placeholder="" class="cl_txt" style="text-align:right;width:100px;" required/>
							</td>
						</tr>
						<tr>
							<td colspan="3" align="right">
								Base 12%.<input type="number" step="0.01" name="c_base12" id="id_base12" placeholder="" class="cl_txt" style="text-align:right;width:100px;" required/>
							</td>
						</tr>
						<tr>
							<td colspan="3" align="right">
								I.V.A 12%<input type="number" step="0.01" name="c_iva" id="id_iva" placeholder="" class="cl_txt" style="text-align:right;width:100px;" required/>
							</td>
						</tr>						
						<tr>
							<td colspan="3" align="right">
								Total.<input type="number" step="0.01" name="c_totfactura" id="id_totfactura" placeholder="" class="cl_txt" style="text-align:right;width:100px;" required/>
							</td>
						</tr>
						<tr>
							<td colspan="6" align="right">
								<input type="button" value="Salir" class="cl_btn" onclick="javascript:location.reload();">
								<input type="button" value="Limpiar" class="cl_btn" onclick="javascript:location.reload();">
								<!--<input type="submit" value="Guardar" id="bt_guardar_fact" class="cl_btn">-->
								<input type="button" value="Guardar" id="bt_guardar_fact" class="cl_btn" onclick="fun_facturar_v();" style="display:none">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
<?php 
}else {
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
}
 ?>