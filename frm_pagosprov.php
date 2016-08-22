<?php 
if ($_SESSION['cargo']==1) {
include("lib/phpconexcion.php");
$enlace = conectar_buscadores();
$cad_bancos = "SELECT IDT_BANCO, BAN_BANCCO , BAN_CUENTA FROM t_bancos  where BAN_ESTADO =1";
$eje_cad_bancos = mysql_query($cad_bancos);

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="lib/new_pago_provee.php" method ="post" autocomplete="off" name="c_frm_cobros_facturas" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
		<div class="cl_datoscobro" id="id_datoscobro">
			<table>
				<tr>
					<td colspan="7" align="center"><h3 style="margin:20px auto; border-bottom: solid 2px #e89980;">ADMINITRACION DE PAGOS A PROVEEDORES</h3></td>										
				</tr>
				<tr>
					<td colspan="3">
						Buscador de proveedores: <br>
						<input type="text" class="cl_txt" name="c_datosprov" id="id_clienteprovee_glo" onkeyup="buscaracli('7','<?php echo $_SESSION['empresa']; ?>')" placeholder="Nombres del cliente" style="width:550px;height:18px;">
						<div class="cl_div_clientes" id="id_div_clientes">
							
						</div>
					</td>
					<td>
						Cédula: <br>
						<input type="text" name="c_cobcedula" class="cl_txt" id="id_cobcedula" placeholder="Cédula" style="width:120px;height:18px;" readonly/>
						<input type="hidden" class="cl_txt" name="c_cidtcliente" id="id_cidtcliente" style="width:50px;" readonly/>
					</td>
					<td>
						Fecha de pago: <br>
						<input type="date" name="c_fecha_pago" class="cl_dat" id="id_fecha_pago" required/>
					</td>
					<td align="right">Froma de pago <br>
						<select name="c_forma_pag" id="id_forma_pag" class="cl_cmb" style="width:150px;" onchange="consulta_pagos(this.value);">
						<!--<select name="c_forma_pag" id="id_forma_pag" class="cl_cmb" style="width:150px;">-->
							<option value="0">Selecione..</option>
							<option value="3">Cheques</option>
							<option value="1">Caja</option> 
						</select>							
					</td>
					<td>
						<br>
						<input type="button"  value="Buscar Créditos" onclick="pagos_provedor();"> 
					</td>
				</tr>				
				<tr>
					<td colspan="7">
						<div id="id_resultadoreport" class="cl_resultadoreport" style="min-height:auto;max-height:350px;overflow:auto;">
							
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="7">
						<div class="cl_descipcionrecibo" id="id_div_generador_asiento" style="width:100%;display:block">
							<table>
								<tr>
									<td>
										Genere asiento contable
									</td>
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
										<input type="text" class="cl_txt" class="cl_txt" name="c_cuenta" id="id_movcuentaingresar" style="width:480px" onkeyup="buscarcuentas(this.value,'2');">
										<div class="cl_div_clientes" id="id_div_cuentas">
											
										</div>
									</td>
									<td align="right"><input type="text" class="cl_txt" class="cl_txt" name="c_codigo_cuent" id="id_movcodcuenta" style="width:80px;"></td>
									<td align="right"><input type="number" class="cl_txt" name="c_debe_cuent" id="id_recreciingreso" style="width:110px;"></td>
									<td align="right"><input type="number" class="cl_txt" name="c_haber_cuent" id="id_recreciegreso" style="width:110px;"></td>
									<td align="right"><input type="button" value="+" id="id_agregar_cuenta" onclick="generartablacuentas();" style="display:block;"></input></td>
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
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="7">
						<div class="cl_div_cheque" id="id_div_cheque" style="display:none;">
							<table>	
								<tr>
									<td colspan="2" rowspan="3" align="left">
										<div class="cl_div_Saldo" id="id_div_saldo" style="background:#fff;width:150px;height:60px;margin: 0 20px 0 0;text-align:center;padding-top:0.2em;">
											<p style="font-size:20px;">0.00</p>
										</div>
									</td>
									<td colspan="6">
										<h4>Ingrese datos del chque...</h4>
									</td>
								</tr>
								<tr>
									<td>Banco.</td>
									<td>N° de cheque</td>
									<td>Persona o empresa</td>
									<td>Valor.</td>
									<td>Fecha de cobro</td>
									<td></td>
								</tr>
								<tr>
									<td>
										<select name="c_banco_ch" id="id_banco_ch" class="cl_cmb" style="height:22px;" onchange="ver_chque(this.value);" required/>
											<option value=" ">Seleccione..</option>
											<?php 
											while ($res_bancos = mysql_fetch_array($eje_cad_bancos)) {
											$enlace = conectar_buscadores();
											$cad_last_cheque = "SELECT max(CAST(CHE_NUM_CHUQUE as UNSIGNED )) FROM t_chques_emitidos where CHE_FK_ID_BANCO = ".$res_bancos['IDT_BANCO'];
											//echo $cad_last_cheque;
											$ejec_cad_las_chque = mysql_query($cad_last_cheque);
											$res_cheque = mysql_fetch_row($ejec_cad_las_chque);
											$num_cheque = $res_cheque[0];
											$num_cheque  = $num_cheque  + 1;
												?>

												<option value="<?php echo $num_cheque.'|'.$res_bancos['IDT_BANCO'].'|'.$res_bancos['BAN_CUENTA'] ?>"><?php echo $res_bancos['BAN_BANCCO']; ?></option>
												<?php
											}
											?>											
										</select>
									</td>
									<td><input type="Number" class="cl_txt2" name="c_numcheque_ch" id="id_numchque_ch" style="width:100px;"  required/></td>
									<td><input type="text" class="cl_txt" name="c_nombrepago_ch" id="id_nombrepago_ch" style="width:300px;"  required/></td>
									<td><input type="number" class="cl_txt2" step="0.01" name="c_valchque_ch" id="id_valchque_ch" style="width:120px;"  required/></td>
									<td><input type="date" class="cl_txt" name="c_fechacob_ch" id="id_fechacob_ch" style="height:17px;" required/></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="7" align="center">
						<!--<input type="submit" value="Generar pago" id="id_generar_pago" style="display:none;">-->
						<input type="text" id="id_banco" name="c_banco" value="0" style="display:none;">
						<input type="text" value="0" id="id_txt_idetificador" name="c_txt_idetificador" style="display:none;" readonly/>
						<input type="submit" value="Generar pago" id="btn_guardar_compras" name="c_btn_guardar_egreso" style="display:none;padding:5px;bakcground:green;">
					</td>
				</tr>
				<tr>
					<td colspan="7">
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<hr>
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
?>