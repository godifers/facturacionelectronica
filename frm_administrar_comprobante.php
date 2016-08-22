<?php 
$IDT_COMPROBANTE =$_GET['idcomprobante'];
$COM_NUM_COMPROB =$_GET['num_comprob_Fac'];
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
	//---------------------------------------------------------------------------------------------------------------------------------------------------
	include("lib/phpconexcion.php");
	$enlace = conectar_buscadores();
	$cad_query_comprobante="SELECT COM_TIPO_COMPR, CP_NOMBRE, CP_APELLIDO ,CP_CEDULA, COM_FEC_CREA ,USU_LOGER,TP_DESCRIPCION, COM_AUTORIZACION_SRI,
	COM_FKID_CLI_PROV ,COM_VAL_SUBT, COM_VAL_BASE0, COM_VAL_BASE12, COM_TOT,COM_AMBIENTE, COM_ESTADO_SRI , COM_CLAVEACESO_SRI,COM_IVA,
	COM_OBSERV_TIPOTRANSAC, COM_FKID_FORMAPAGO, COM_OBSERV_GENRL,COM_DOCAFECTADO, COM_FEC_LLEGADA, 
	COM_ESTADO_SIS, COM_ESTADO_PAGO, COM_ABONO, COM_SALDO, COM_MSN_SRI, COM_EPRESA
	FROM t_comprobante,  t_client_provee, t_usuario,t_formas_pago 
	where IDT_CLIENT_PROVEE = COM_FKID_CLI_PROV and IDT_USUARIO= COM_FKID_USER_CREA AND IDT_FORMAS_PAG0 = COM_FKID_FORMAPAGO 
	AND COM_EPRESA = ".$_SESSION['empresa']."
	and IDT_COMPROBANTE= ".$IDT_COMPROBANTE." AND COM_NUM_COMPROB= '".$COM_NUM_COMPROB."'";
	//echo $cad_query_comprobante;
	$ejec_query_ejec_comrpbante=mysql_query($cad_query_comprobante);
	//mysql_close($enlace);
	$resultado = mysql_fetch_row($ejec_query_ejec_comrpbante);
	$tipotrans = $resultado[0]; //COM_TIPO_COMPR
	$razonsoci = $resultado[1].' '.$resultado[2]; //CP_NOMBRE
	$ruc_cedul = $resultado[3]; //CP_CEDULA
	$fech_crea = $resultado[4]; //COM_FEC_CREA
	$user_crea = $resultado[5]; //USU_LOGER
	$tipo_pago = $resultado[6]; //TP_DESCRIPCION
	$autorizac = $resultado[7]; //COM_AUTORIZACION_SRI
	$id_client = $resultado[8]; //COM_FKID_CLI_PROV
	$val_subto = $resultado[9]; //COM_VAL_SUBT
	$val_base0 = $resultado[10]; //COM_VAL_BASE0
	$val_base12 = $resultado[11]; //COM_VAL_BASE12
	$val_total = $resultado[12]; //COM_TOT
	//---otros datos para ventas
	$ambiente = $resultado[13]; //COM_AMBIENTE
	$estado_sri = $resultado[14]; //COM_ESTADO_SRI
	$calveacceso = $resultado[15]; //COM_CLAVEACESO_SRI
	$iva_comprob =$resultado[16]; //COM_IVA
	$obsert_trans = $resultado[17]; //COM_OBSERV_TIPOTRANSAC
	$formadepago = $resultado[18]; //COM_FKID_FORMAPAGO
	$onser_gener = $resultado[19]; //COM_OBSERV_GENRL
	$doc_afectad = $resultado[20]; //COM_DOCAFECTADO
	$fecha_autor = $resultado[21]; //COM_FEC_LLEGADA
	//daros boleanos o FK
	$estado_sis = $resultado[22];//COM_ESTADO_SIS
	$estado_pag = $resultado[23];//COM_ESTADO_PAGO
	$abono_sis = $resultado[24];//COM_ABONO
	$saldo_sis = $resultado[25];//COM_SALDO
	$msn_sis_sri = $resultado[26];//COM_MSN_SRI
	$emprea_ed = $resultado[27];

	?>
	<fieldset>
		<legend><input type="button" value="Adminitrador" onclick="mostar_Admin('id_div_admin_comp');"> <input type="button" value="Avanzado" onclick="mostar_Admin('id_div_admin_avanzado');"></legend>
		<?php 
		if (isset($_SESSION['cargo'])==1) {
		//echo $_SESSION['cargo'];	
		?>
		<div name="c_div_admin_avanzado" id="id_div_admin_avanzado" style="display:none;">
			<table>
				<tr>
					<td colspan="10" align="right">
						<input type="text" class="cl_txt" name="c_tip_doc_ed" id="id_tip_doc_ed" value="<?php echo $tipotrans ; ?>" style="height:30px;font-size:20px;width:50px;text-align:center;" readonly/>
						<input type="text" class="cl_txt" name="c_num_doc_ed" id="id_num_doc_ed" value="<?php echo $COM_NUM_COMPROB ; ?>" style="height:30px;font-size:20px;width:200px;text-align:center;" readonly/>
						<input type="hidden" class="cl_txt" name="c_idt_doc_ed" id="id_idt_doc_ed" value="<?php echo $IDT_COMPROBANTE; ?>">						
					</td>
				</tr>
				<tr>
					<td>FECHA:</td>	
					<td>ESTADO PAGO:</td>
					<td>ESTADO SIS:</td>
					<td>SUBTOTAL</td>
					<td>BASE 0</td>
					<td>BASE 12</td>
					<td>IVA</td>
					<td>TOTAL</td>
					<td>SALDO</td>
					<td>ABONO</td>
				</tr>
				<tr>
					<td><input type="date" class="cl_dat" name="c_fecha_sis_edt" id="id_fecha_sis_ed" value="<?php echo str_replace("/", "-", $fech_crea); ?>"></td>
					<td>
						<select name="c_esato_pag_ed" id="id_Estado_pag_ed" class="cl_cmb" selectedValue="<?php echo $estado_pag; ?>">
							<?php 
							if ($estado_pag ==1) {
								?>
								<option value="">Seleccione..</option>
								<option value="1" selected="true">Por pagar</option>
								<option value="0">Pagado</option>	
								<?php
							} else if ($estado_pag ==0) {
								?>
								<option value="">Seleccione..</option>
								<option value="1" >Por pagar</option>
								<option value="0" selected="true">Pagado</option>	
								<?php
							}else{
								?>
								<option value="" selected="true">Seleccione..</option>
								<option value="1" >Por pagar</option>
								<option value="0" >Pagado</option>	
								<?php
							}						
							?>															
						</select>
					</td>
					<td>
						<select name="c_esato_sis_ed" id="id_Estado_sis_ed" class="cl_cmb"  selectedValue="<?php echo $estado_sis; ?>">
							<?php 
							if ($estado_sis ==1) {
								?>
								<option value="">Seleccione..</option>
								<option value="1" selected="true">ACTIVO</option>
								<option value="0">ANULADO</option>	
								<?php
							} else if ($estado_sis ==0) {
								?>
								<option value="">Seleccione..</option>
								<option value="1" >ACTIVO</option>
								<option value="0" selected="true">ANULADO</option>	
								<?php
							}else{
								?>
								<option value="" selected="true">Seleccione..</option>
								<option value="1" >ANULADO</option>
								<option value="0" >ANULADO</option>	
								<?php
							}						
							?>															
						</select>
					</td>
					<td><input type="number" class="cl_txt2" step="0.01" name="c_subto_ed" id="id_subto_ed" value="<?php echo $val_subto; ?>"></td>
					<td><input type="number" class="cl_txt2" step="0.01" name="c_base0_ed" id="id_base0_ed" value="<?php echo $val_base0; ?>"></td>
					<td><input type="number" class="cl_txt2" step="0.01" name="c_bas12_ed" id="id_bas12_ed" value="<?php echo $val_base12; ?>"></td>
					<td><input type="number" class="cl_txt2" step="0.01" name="c_iva_ed" id="id_iva_ed" value="<?php echo $iva_comprob; ?>"></td>
					<td><input type="number" class="cl_txt2" step="0.01" name="c_total_ed" id="id_total_ed" value="<?php echo $val_total; ?>"></td>
					<td><input type="number" class="cl_txt2" step="0.01" name="c_saldo_ed" id="id_saldo_ed" value="<?php echo $saldo_sis; ?>" onkeyup="cal_saldo_avan(this.value,1)"></td>
					<td><input type="number" class="cl_txt2" step="0.01" name="c_abono_ed" id="id_abono_ed" value="<?php echo $abono_sis; ?>" onkeyup="cal_saldo_avan(this.value,2)"></td>
				</tr>
				<tr>
					<td>Observación</td>
					<td colspan="8" align="right">
						<input type="text" class="cl_txt" name="c_observacion_ed" id="id_observacion_ed" >
					</td>
					<td>
						<input type="button" name="c_btn_actu_dat_avanz" id="id_btn_actu_dat_avanz" value="ACTUALIZAR" style="background:#5E9767;width:90px;height:30px;font-size:12px;" onclick="actualizar_datos();">
					</td>
				</tr>
				<tr>
					<td colspan="5">
						<strong>Relacionar a:(en caso de compras con que doc. lo va a pagar)</strong>
					</td>
					<td colspan="5">
						<hr>
					</td>
				</tr>
				<tr>
					<td colspan="10">
						<table style="width:100%">
							<!-- ---------------------------------------------------------------------------------------------------- -->
							<tr>
								<td><h4>Ingreso de productos</h4> </td>
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
									<input type="text" class="cl_txt" name="c_product" id="id_product_ingr_l" onkeyup="buscarprod2(this.value,11,'<?php echo $_SESSION['empresa'] ?>');"  style="width:480px"><br>						
									<div class="cl_div_clientes" id="id_div_filtroprod2">
							
									</div>
								</td>
								<td><input type="text" class="cl_txt" name="c_codprod" id="id_codprod_ingr_l" style="width:100px" readonly/></td>
								<td><input type="number" class="cl_txt2" name="c_cantpro" id="id_cantpro_ingr_l" style="width:75px" onblur="sacarvaltot_prod_l(2);"></td>
								<td><input type="number" class="cl_txt2" step="0.01" name="c_valprod" id="id_valprod_ingr_l" style="width:75px" onblur="sacarvaltot_prod_l(2);"></td>
								<td><input type="number" class="cl_txt2" step="0.01" name="c_valtotp" id="id_valtotp_ingr_l" style="width:75px" onblur="sacarvaltot_prod_l(2);"></td>
								<td><input type="button"  onclick="agregar_prod_avnz();" value="AGR. DOC." title="Agregar al doc"></td>
							</tr>	
							<!-- -------------------------------------------------------------------------------------------------------- -->
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="10">
						<div class="cl_div_relacionado" id="id_div_relacionado">
							<table>
								<tr>
									<td  colspan="9"><strong>Buscador de docs.</strong></td>
									
									<td>Tipo doc.</td>
									<td colspan="2">Numero de  doc.</td>
								</tr>
								<tr>
									<td colspan="9">
										<input type="text" name="c_busc_doc_af" id="id_busc_doc_af" placeholder="Ingrese un numero de documento" class="cl_txt" onkeyup="searchdocs(this.value,'1')">
										<div class="cl_div_clientes" id="id_div_search_docs">
								
										</div>
									</td>
									<td><input type="text" class="cl_txt2" name="c_tip_doc_af" id="id_tip_doc_af" readonly/></td>
									<td colspan="2">
										<input type="text" class="cl_txt" name="c_num_doc_af" id="id_num_doc_af" value="" readonly/>
										<input type="hidden" class="cl_txt" name="c_idt_doc_af" id="id_idt_doc_af" readonly/>
									</td>
								</tr>
								<tr>								
									<td colspan="2"><strong>Fecha doc.</strong></td>
									<td><strong>Estado pag.</strong></td>
									<td><strong>Estado sis</strong></td>
									<td><strong>Subtotal</strong></td>
									<td><strong>Base 0</strong></td>
									<td><strong>Base 12</strong></td>
									<td><strong>I.V.A.</strong></td>
									<td><strong>Total</strong></td>
									<td><strong>Saldo.</strong></td>
									<td><strong>Abono.</strong></td>
								</tr>
								<tr>									
									<td colspan="2">
										<input type="date" class="cl_dat" name="c_fec_doc_af" id="id_fec_doc_af" value="">
									</td>
									<td>
										<select name="c_est_doc_af" id="id_esp_doc_af" class="cl_cmb">
											<option value="">Seleccione..</option>
											<option value="1">Pendiente</option>
											<option value="0">Pagado</option>
										</select>
									</td>
									<td>
										<select name="c_est_doc_af" id="id_ess_doc_af" class="cl_cmb">
											<option value="">Seleccione..</option>
											<option value="1">Activo</option>
											<option value="0">anulado</option>
										</select>
									</td>
									<td><input type="number" step="0.01" name="c_subt_doc_af" id="id_subt_doc_af" class="cl_txt2"></td>
									<td><input type="number" step="0.01" name="c_bas0_doc_af" id="id_bas0_doc_af" class="cl_txt2"></td>
									<td><input type="number" step="0.01" name="c_ba12_doc_af" id="id_ba12_doc_af" class="cl_txt2"></td>
									<td><input type="number" step="0.01" name="c_iva_doc_af" id="id_iva_doc_af" class="cl_txt2"></td>
									<td><input type="number" step="0.01" name="c_tota_doc_af" id="id_tota_doc_af" class="cl_txt2"></td>
									<td><input type="number" step="0.01" name="c_sald_doc_af" id="id_sald_doc_af" class="cl_txt2"></td>
									<td>
										<input type="number" step="0.01" name="c_abon_doc_af" id="id_abon_doc_af" class="cl_txt2">
										<input type="button" name="c_btn_agreg_pag"  id="id_btn_agreg_pag" value="Agre. al P." onclick="agrega_al_pag();" disabled/>
									</td>
								</tr>	
								<tr>
									<td colspan="11">
										<div class="cl_div_res_det_avan" id="id_cl_div_res_det_avan" style="width:100%;">
											
										</div>
									</td>
								</tr>							
							</table>
						</div>
					</td>
				</tr>				
			</table>
		</div>
		<?php 
		}else {
		?>
		<div name="c_div_admin_avanzado" id="id_div_admin_avanzado" style="display:none;text-align:center;"><img src="img/error.png" alt=""></div>
		<?php
		}
		?>
		<div name="c_div_admin_comp" id="id_div_admin_comp" style="display:block;">
			<?php

			if (is_null($fecha_autor)) {
				$fecha_autor = $fech_crea.'.';
			}else{
				$fecha_autor = $fecha_autor;
			}	 
			/*IDT_COMPROBANTE, COM_TIPO_COMPR, COM_SUBTIPO_COMP, COM_SECUEN_TIPO, COM_NUM_COMPROB, COM_VAL_SUBT, COM_VAL_BASE0, COM_VAL_BASE12, 
			COM_IVA, COM_TOT, COM_TOT_SIN_RET, COM_TOT_PAGO_COBR, COM_PARTEREL, COM_SUSTENTO_TRIB, COM_FKID_FORMAPAGO, COM_ABONO, COM_SALDO, COM_DOCAFECTADO, 
			COM_FKID_DOCAFECT, COM_CLAVEACESO_SRI, COM_AUTORIZACION_SRI, COM_ESTADO_SIS, COM_ESTADO_CONTAB, COM_ESTADO_ATS_SRI, COM_ESTADO_PAGO, COM_ESTADO_SRI, 
			COM_ESTADO_NULL, COM_MSN_SRI, COM_AMBIENTE, COM_OBSERV_TIPOTRANSAC, COM_OBSERV_GENRL, COM_FKID_CLI_PROV, COM_FKID_USER_CREA, COM_FKID_USER_EDIT, 
			COM_FKID_USER_ANULA, COM_FEC_CREA, COM_FEC_EDIT, COM_FEC_ANULA, COM_FEC_ENVIO, COM_FEC_LLEGADA, COM_FEC_CORTE, COM_FEC_PAGO, COM_PLAZO, COM_EPRESA, 
			COM_OFCINA, IDT_COMPROBANTE, id*/
			//echo $tipotrans;
			if ($tipotrans=='V' or $tipotrans=='W' or  $tipotrans=='X' or  $tipotrans=='N' or $tipotrans=='M' or $tipotrans=='G' or $tipotrans=='H' or $tipotrans=='L') {
				/*echo '<script>
					window.location="inicio.php?id=frm_impresion.php&idcomp='.$IDT_COMPROBANTE.'&numf='.$COM_NUM_COMPROB.'";		
				 </script>';*/
				 $enlace = conectar_buscadores();
				 $cad_query_emp ="SELECT EMP_RAZON_SOCIAL,EMP_RUC,EMP_DIRECCION_MATRIZ,EMP_NUMERO_CONTRIB FROM t_empresa where IDT_EMPRESA =".$_SESSION['empresa'];
				 $ejec_cad_Emp = mysql_query($cad_query_emp);
				 //mysql_close($enlace);
				 $resultado_emp = mysql_fetch_row($ejec_cad_Emp);
				 $razsoc_emp= $resultado_emp[0];
				 $ruc_emp = $resultado_emp[1];
				 $dir_matriz_emp = $resultado_emp[2];
				 $num_contrib_emp = $resultado_emp[3];
				 ?>
				 <div class="c_div_admin_venta" id="did_iv_admin_venta" style="width:800px;background:#fff;margin:0 auto;margin-top:10px;">
				 	<!-- -------------------------------------------------------------------------------------------------------------------------- -->
				 	<form action="lib/new_nc_venta.php" method="post" name="c_frm_fact_nc">
				 	<table border="0" class="t_impres">
						<tr>
							<td colspan="4" align="center">
								<img src="img/logo.png" alt="Logo" style="height:60px;">
							</td>
							<td colspan="2">						
								<?php 
								if ($tipotrans=='V') {
									?> 
									<br>
									<h5>FACTURA</h5>
									<?php
								} else if ($tipotrans=='N'){
									?> 
									<br>
									<h5>NOTA DE CREDITO</h5>
									<?php
								} else if ($tipotrans=='G'){
									?> 
									<br>
									<h5>GUIA DE REMISIÓN</h5>
									<?php
								}
								else if ($tipotrans=='H'){
									?> 
									<br>
									<h5>GUIA DE REMISIÓN ENTRANTE</h5>
									<?php
								}else if ($tipotrans=='L'){
									?> 
									<br>
									<h5>NOTA CONTABLE</h5>
									<?php
								}else if ($tipotrans=='W'){
									?> 
									<br>
									<h5>FACTURA MANUAL.</h5>
									<?php
								}else if ($tipotrans=='M'){
									?> 
									<br>
									<h5>NOTA DE CREDITO .</h5>
									<?php
								}else{
									?> 
									<br>
									<h5>DOC. SIN TITULO.</h5>
									<?php
								}
								?>
								 <p><strong>N°</strong><?php echo $COM_NUM_COMPROB ; ?></p>						
							</td>
						</tr> 						
						<tr>
							<td colspan="6">
								<table border="0">
									<tr>
		 							<td style="width:60%;" align="center"><p class="cl_pimp cl_etiq" style="sont-size:10px;"><?php echo $razsoc_emp; ?></p></td>
		 							<td style="width:40%;"><p class="cl_pimp cl_etiq"><strong>NÚMERO DE AUTORIZACIÓN</strong> <br><?php echo $autorizac ; ?></p></td>
		 						</tr>
		 						<tr>
		 							<td><p class="cl_pimp cl_etiq"><strong>R.U.C. </strong><?php echo $ruc_emp; ?></p></td>
		 							<td><p class="cl_pimp cl_etiq"><strong>Fecha de autorizacion</strong> <?php echo $fecha_autor; ?></p></td>
		 						</tr>
		 						<tr>
		 							<td><p class="cl_pimp cl_etiq"><strong>Dir. Matriz</strong> <?php echo $dir_matriz_emp; ?></p></td>
		 							<td><p class="cl_pimp cl_etiq"><strong>Ambiente: </strong><?php echo $ambiente.'  -  '; ?> <strong>Estado: </strong><?php echo $estado_sri; ?></p></td>
		 						</tr>
		 						<tr>
		 							<td colspna="2"><p class="cl_pimp cl_etiq"><strong>Contribuyente especial N° <?php echo $num_contrib_emp; ?></strong></p></td>
		 							<td rowspan="2"><p class="cl_pimp cl_etiq"><strong>CLAVE DE ACCESO </strong></p><p style="font-size:9px;"><?php echo $calveacceso; ?></p></td>
		 						</tr>
		 						<tr>
		 							<td><p class="cl_pimp cl_etiq" style="font-size:10px;"><strong>OBLIGADO A LLEVAR CONTABILIDAD: SI</strong></p></td>
		 						</tr>
								</table>
							</td>
						</tr> 						
						<tr>
							<td colspan="6">
								<table border="1" style="width:100%;" class="cl_tabresultados">
									<tr>
										<td colspan="6">
											<table style="width:100%;" >
												<tr>
		 										<td colspan="3"><p class="cl_pimp"><strong>Cliente:</strong> <?php echo utf8_encode($razonsoci); ?></p></td>
		 										<td colspan="2" align="right"><p class="cl_pimp"><strong>Identificacion:</strong> <?php echo $ruc_cedul; ?></p></td>
			 									</tr>
			 									<tr>
			 										<td colspan="3"><p class="cl_pimp"><strong>Fecha Emisión:</strong> <?php echo $fech_crea; ?></p></td>
			 										<td colspan="2" align="right">
			 										<?php 
			 										if ($tipotrans=='N' or $tipotrans=='M') {
			 											?>
				 											<p class="cl_pimp"><strong>Doc. afectado:</strong> <?php echo $doc_afectad; ?>		 										
			 											<?php
			 										}
			 										 ?>	 
			 										 </td>										
			 									</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td><p class="cl_pimp cl_etiq"><strong>CODIGO</strong></p></td>
										<td><p class="cl_pimp cl_etiq"><strong>DESCRIPCIÓN</strong></p></td>
										<td align="right"><p class="cl_pimp cl_etiq"><strong>CANTIDAD</strong></p></td>
										<td align="right"><p class="cl_pimp cl_etiq"><strong>V. UNIT.</strong></p></td>
										<td align="right"><p class="cl_pimp cl_etiq"><strong>C. TOT.</strong></p></td>
										<td align="right"><p class="cl_pimp cl_etiq"><strong>N. C.</strong></td>
									</tr>	
								<?php 
								$enlace = conectar_buscadores();
								$caddetalleventa ="SELECT DET_FK_IDPROD,PR_DETALLE,PR_PRESENTACION,DET_CANTIDAD,DET_VAL_UNIT,DET_VAL_TOT ,PR_IMPUESTO
								FROM t_detalles, t_prodcutos
								where DET_EMP =".$_SESSION['empresa']." AND PR_EMPRESA=".$_SESSION['empresa']." AND DET_FK_IDCOMPROB=".$IDT_COMPROBANTE." AND DET_NUM_FACTU='".$COM_NUM_COMPROB."' 
									AND DET_FK_IDPROD= PR_COD_PROD and DET_TIPO_TRNS='".$tipotrans."'";
								$eje_caddetalleventa = mysql_query($caddetalleventa);
								
								//echo $caddetalleventa;
								//mysql_close($enlace);
								$i=0;
								while($resdetalles=mysql_fetch_array($eje_caddetalleventa)) 
								  {
								  	?>
								  	<tr>
								  	<td>
								  		<input type="text" name="c_cod_nc[]" id="<?php echo "id_cod_nc".$i; ?>" class="cl_txt1" value="<?php echo $resdetalles['DET_FK_IDPROD']; ?>" readonly/>
								  		<input type="hidden" name="<?php echo "c_ipuesto_nc".$i; ?>" id="<?php echo "id_imp_nc".$i; ?>" value="<?php echo $resdetalles['PR_IMPUESTO']; ?>" class="cl_txt2" readonly/>
								  		<input type="hidden" name="c_verificador_nc[]" id="<?php echo "id_verificador_nc".$i; ?>" value="0" readonly/>
								  	</td>
								  	<td><input type="text" name="<?php echo "c_descr_nc".$i; ?>" id="<?php echo "id_descr_nc".$i; ?>" class="cl_txt" value="<?php echo $resdetalles['PR_DETALLE'].' '.$resdetalles['PR_PRESENTACION']; ?>" style="width:370px;" readonly/></td>
								  	<td align="right"><input type="text" name="c_cant_nc[]" id="<?php echo "id_cant_nc".$i; ?>" class="cl_txt2" value="<?php echo $resdetalles['DET_CANTIDAD']; ?>" onkeyup="calcular_val_nc('<?php echo $i; ?>')" onblur="calcular_val_nc('<?php echo $i; ?>')" readonly/></td>
								  	<td align="right"><input type="text" name="c_vuni_nc[]" id="<?php echo "id_vuni_nc".$i; ?>" class="cl_txt2" value="<?php echo $resdetalles['DET_VAL_UNIT']; ?>" onkeyup="calcular_val_nc('<?php echo $i; ?>')" onblur="calcular_val_nc('<?php echo $i; ?>')" readonly/></td>
								  	<td align="right"><input type="text" name="c_ctot_nc[]" id="<?php echo "id_vtot_nc".$i; ?>" class="cl_txt2" value="<?php echo $resdetalles['DET_VAL_TOT']; ?>" onblur="sumar_checks();" readonly/></td>
								  	<?php 
								  	if ($tipotrans=='V') {
							  		?>
							  		<td align="right"><input type="checkbox" name="c_chk_nc" id="<?php echo "id_chk_nc".$i; ?>" onclick="activar_cajas_para_nc('<?php echo $i; ?>');" title="Seleccione para que este prodcuto este en la N. C."></td>
							  		<?php
								  	}else{
								  	?>
								  	<td  align="right"><input type="checkbox" title="Esta ya es una N.C" disabled/></td>
								  	<?php
								  	}
								  	 ?>
								  	
								  	</tr>
								  	<?php 
								  	$i++;
								  }
								?>	
								<tr>
									<td colspan="2" rowspan="6">
										<table style="margin:0;">
											<tr>
												<td><p class="cl_pimp">FORMA DE PAGO :</p></td>
												<td><p class="cl_pimp"><?php echo $tipo_pago; ?></p></td>
											</tr>									
											<tr>
												<td><p class="cl_pimp">OBSERVACIÓN : </p></td>
												<td><p class="cl_pimp"><?php echo $obsert_trans; ?></p></td>
											</tr>
											<tr>
												<td><p class="cl_pimp">OBSERVACIÓN : </p></td>
												<td><p class="cl_pimp"><?php echo $onser_gener ; ?></p></td>
											</tr>
										</table>
									</td>
									<td colspan="2" align="right"><p class="cl_pimp">SUBTOTAL</p></td>
									<td align="right"><input type="text" class="cl_txt2" name="c_subtota_nc" id="id_subtota_nc" value="<?php echo $val_subto; ?>" required/></td>
									<td align="right"><input type="checkbox" disabled/></td>
								</tr>
								<tr>
									<td colspan="2" align="right"><p class="cl_pimp">DESCUENTO</p></td>
									<td align="right"><input type="text" class="cl_txt2" name="c_desc_nc" id="id_desc_nc" value="0.00" required/></td>
									<td align="right"><input type="checkbox" disabled/></td>
								</tr>
								<tr>
									<td colspan="2" align="right"><p class="cl_pimp">BASE 12%:</p></td>
									<td align="right"><input type="text" class="cl_txt2" name="c_base12_nc" id="id_base12_nc" value="<?php echo $val_base12; ?>" required/></td>
									<td align="right"><input type="checkbox" disabled/></td>
								</tr>
								<tr>
									<td colspan="2" align="right"><p class="cl_pimp">BASE 0%:</p></td>
									<td align="right"><input type="text" class="cl_txt2" name="c_base0_nc" id="id_base0_nc" value="<?php echo $val_base0; ?>" required/></td>
									<td align="right"><input type="checkbox" disabled/></td>
								</tr>
								<tr>
									<td colspan="2" align="right"><p class="cl_pimp">I.V.A 12%:</p></td>
									<td align="right"><input type="text" class="cl_txt2" name="c_iva_nc" id="id_iva_nc" value="<?php echo $iva_comprob; ?>" required/></td>
									<td align="right"><input type="checkbox" disabled/></td>
								</tr>
								<tr>
									<td colspan="2" align="right"><p class="cl_pimp">TOTAL:</p></td>
									<td align="right"><input type="text" class="cl_txt2" name="c_total_nc_nc" id="id_total_nc_nc" value="<?php echo $val_total; ?>" required/></td>
									<td align="right"><input type="checkbox" disabled/></td>
								</tr>								
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="8" align="right">
								<div class="cl_div_resultcambio" id="id_div_resultcambio" style="display:inline-block;">
									<img src="img/cargar.gif" alt="" id="id_gif_cargar" style="display:none;">
								</div>
								<input type="hidden" name="c_idt_cliente_nc" value="<?php echo $id_client; ?>" id="id_idt_cliente_nc" readonly/>
								<input type="hidden" name="c_idt_comprobante" value="<?php echo $IDT_COMPROBANTE; ?>" id="id_idt_comprobante" readonly>
								<input type="hidden" name="c_num_comprobante" value="<?php echo $COM_NUM_COMPROB; ?>" id="id_num_comprobante" readonly>
								<?php 
								if ($tipotrans== 'V') {
									?>
									<a href="lib/pdf_comprob.php?idt_comp=<?php echo $IDT_COMPROBANTE; ?>&nun_comp=<?php echo $COM_NUM_COMPROB; ?>" target="_blank">PDF</a>
									<?php
								} else {
									?>
									<a href="lib/pdf_factura_man.php?idt_comp=<?php echo $IDT_COMPROBANTE; ?>&nun_comp=<?php echo $COM_NUM_COMPROB; ?>" target="_blank">PDF</a>
									<?php
								}
								
								?>
								
								<input type="button" value="Imprimir" onclick="javascript:window.location='inicio.php?id=frm_impresion.php&idcomp=<?php echo $IDT_COMPROBANTE ; ?>&numf=<?php echo $COM_NUM_COMPROB ; ?>'" style="padding:5px;">
								<input type="button" value="Recargar" onclick="javascript:window.location.reload();" style="padding:5px;">
								<?php 
								if (($tipotrans== 'V'  or $tipotrans== 'W') and $formadepago == 1) {
								?>
								<input type="button" value="A Credito" onclick="cambiarfactura('<?php echo $IDT_COMPROBANTE; ?>','<?php echo $COM_NUM_COMPROB; ?>','<?php echo $tipotrans ; ?>',1);" style="padding:5px;">
								<?php
								} 						
								?>
								<?php 
								if ($tipotrans=='V') {
									?> 
									<input type="button" value="Gen. Guia" onclick="gen_guia('<?php echo $IDT_COMPROBANTE;?>');" style="padding:5px;">
									<input type="submit" value ="Generar N.C." style="padding:5px;" id="id_btn_gen_nc" disabled/>
									<?php
								} 			
								?>						
							</td>
						</tr>
						<tr>
							<td colspan="8">
								<div class="cl_div_Conductor_fact" id="id_div_Conductor_fact" style="border:solid 2px green;display:none;background:#1E6677;">
									<table style="width:100%;">
										<tr>
											<td><h4>SELECCIONE UN CODUCTOR</h4><hr></td>
										</tr>
										<tr>
											<td><strong>NOMBRE DEL CONDUCTOR</strong></td>
											<td><strong>PLACA</strong></td>
											<td><strong>DESCRIPTCION</strong></td>
											<td><strong>COD CONDUCTOR</strong></td>
										</tr>
										<tr>
											<td>
												<input type="text" name="c_nombr_cond_fac" id="id_nombr_cond_fac" value="" class="cl_txt" placeholder="Busque condcutor o vehiculo" onkeyup="buscar_conduct(this.value,'1');" style="width:300px;">
												<input type="hidden" name="c_ruc_cond_fact" id="id_ruc_cond_fact" readonly//>
												<div class="cl_div_clientes" id="id_buscadorconductores">
										
												</div>
											</td>
											<td><input type="text" name="c_palca_fact" id="id_palca_fact" value="" class="cl_txt" placeholder="PLACA" style="width:100px;" readonly/></td>
											<td><input type="text" name="c_descrip_fac" id="id_descrip_fac" value="" class="cl_txt" placeholder="DESCRIPTCIÓN" style="width:200px;" readonly/></td>
											<td align="right">
												<input type="text" name="c_cod_cond_fac" id="id_cod_cond_fac" class="cl_txt" placeholder="COD CONDUCTUR." style="width:100px;" readonly/>
												<input type="hidden" name="c_cod_num_fact" id="id_cod_num_fact" >
											</td>
										</tr>
										<tr>
											<td>
												Dirección de partida
												<input type="text" class="cl_txt" name="c_direc_partida" id="id_direc_partida" placeholder="Dirección de partida" >
											</td>
											<td colspan="2">
												Dirección de llegada
												<input type="text" class="cl_txt" name="c_direc_llegada" id="id_direc_llegada" placeholder="Dirección de llegada" >
											</td>
											<td>
												Fecha de llegada <br>
												<input type="date" class="cl_dat" name="c_fecha_llegada_guia" id="id_fecha_llegada_guia">
											</td>								
										</tr>
										<tr>
											<td colspan="4" align="center">
												<input type="button" value="Generar Guia" onclick="enviar_guia();" style="padding:5px;">
											</td>
										</tr>
										<tr>
											<div id="id_resGuiasDeFact" style="widht:100%;">
											</div>
										</tr>
									</table>
								</div>
							</td>
						</tr>
					</table> 
					</form>				
				 	<!-- -------------------------------------------------------------------------------------------------------------------------- -->
				 	<!--<div class="cl_doc_Relacionados" id="id_doc_Relacionados">
				 		<table style="width:100%;" class="cl_tabresultados">
				 			<tr>
				 				<td colspan="5">
				 					<h4>Docs. Relacionados</h4>
				 				</td>
				 			</tr>
				 			<tr>
				 				<td>Num doc.</td>
				 				<td>Tipo de doc</td>
				 				<td>Fecha comprob</td>
				 				<td>Valor</td>
				 				<td>Creado por</td>
				 			</tr>
				 		<?php 
				 		$enlace = conectar_buscadores();
				 		$cad_dos_rel = "SELECT IDT_COMPROBANTE, COM_NUM_COMPROB, COM_TIPO_COMPR, COM_FEC_CREA, COM_TOT, USU_LOGER  
							FROM t_pagos_factu_comp, t_comprobante , t_usuario where 
							 PAG_FK_ID_COM_PAGO= IDT_COMPROBANTE and  PAG_NUM_COMPR_PAGO= COM_NUM_COMPROB and 
							 COM_FKID_USER_CREA = IDT_USUARIO and 
							 PAG_NUM_FAC_AFECTADO='".$COM_NUM_COMPROB ."' and PAG_TIPO_FACT_COMP = '".$tipotrans."'";
						$ejec_cad_rel = mysql_query($cad_dos_rel);
						while ($res_docs_rel = mysql_fetch_array($ejec_cad_rel)) {
							?>
						<tr>
							<td><a href="inicio.php?id=frm_administrar_comprobante.php&idcomprobante=<?php echo $res_docs_rel['IDT_COMPROBANTE']; ?>&num_comprob_Fac=<?php echo $res_docs_rel['COM_NUM_COMPROB']; ?>" 
								target="_blank"><?php echo $res_docs_rel['COM_NUM_COMPROB']; ?></a></td>
							<td><?php echo $res_docs_rel['COM_TIPO_COMPR']; ?></td>
							<td><?php echo $res_docs_rel['COM_FEC_CREA']; ?></td>
							<td><?php echo $res_docs_rel['COM_TOT']; ?></td>
							<td><?php echo $res_docs_rel['USU_LOGER']; ?></td>
						</tr>
							<?php 
						}
				 		 ?>
				 		<tr>
				 			<td colspan="5">
				 				<hr>
				 			</td>
				 		</tr>
				 		</table>
				 	</div>-->
				 </div>
				 <?php 
			} else if ($tipotrans=='C' or $tipotrans=='F' or $tipotrans=='E' or $tipotrans=='D' or $tipotrans=='K') {
				?>
				<div class="cl_div_admin_compra" id="id_div_admin_compras" style="width:850px;margin:0 auto;">
					<table>
						<tr>
							<td colspan="5">
								<hr>
							</td>
						</tr>
						<tr>
							<td colspan="3">PROVEEDOR.</td>
							<td>RUC. / ID.</td>
							<td>NUM. FACTURA.</td>
						</tr>
						<tr>
							<td colspan="3">
								<input type="text" class="cl_txt_comp" name="c_nom_provee_comp" id="id_clienteprovee_glo" value="<?php echo $razonsoci; ?>" style="width:500px;" onkeyup="buscaracli('8','<?php echo $_SESSION['empresa']; ?>');" readonly/>
								<br>
								<input type="hidden" class="cl_txt_comp" name="c_id_provee_comp" id="id_id_provee_comp" value="<?php echo $id_client; ?>" >
								<input type="hidden" class="cl_txt_comp" name="c_idt_comprob_comp" id="id_idt_comprob_comp" value="<?php echo $IDT_COMPROBANTE ; ?>">
								<input type="hidden" class="cl_txt_comp" name="c_tipo_trans_comp" id="id_tipo_trans" value="<?php echo $tipotrans; ?>">
								<div class="cl_div_clientes" id="id_div_clientes">
							
								</div>
							</td>
							<td>
								<input type="text" class="cl_txt_comp" name="c_ruc_provee_comp" id="id_ruc_provee_comp" value="<?php echo $ruc_cedul; ?>" readonly/>
							</td>
							<td align="right">
								<input type="text" class="cl_txt_comp" name="c_num_fac_comp" id="id_num_fac_comp" value="<?php echo $COM_NUM_COMPROB; ?>" readonly/>
							</td>
						</tr>
						<tr>
							<td>FECHA INGRESO</td>
							<td>CREADO POR.</td>					
							<td>F.PAGO</td>
							<td colspan="2">AUTORIZACIÓN</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="cl_txt_comp" name="c_fecha_ing_comp" id="id_fecha_ing_comp" value="<?php echo str_replace("/", "-", $fech_crea) ?>" readonly/>
								<input type="date" class="cl_dat" name="c_new_date_comp" id="id_new_date_comp" style="display:none;" value="<?php echo str_replace("/", "-", $fech_crea) ?>">
							</td>
							<td>
								<input type="text" class="cl_txt_comp" class="cl_txt" name="c_" id="id_" value="<?php echo $user_crea ?>" readonly/>
							</td>					
							<td>
								<input type="text" class="cl_txt_comp" class="cl_txt" name="c_" id="id_" value="<?php echo $tipo_pago; ?>" readonly/>
							</td>
							<td colspan="2" align="right">
								<input type="text" class="cl_txt_comp" class="cl_txt" name="c_aut_comp" id="id_aut_comp" value="<?php echo $autorizac; ?>" style="width:310px;font-size:11px;height:18px;" readonly/>
							</td>
						</tr>
						<tr>
							<td>
								<h4 style="background:#999896;margin:3px 0 3px 0;text-align:center;color:#000;">DETALLE COMP.</h4>
							</td>
							<td colspan="3" align="right">
								<hr>
							</td>
							<td align="right">
								<input type="button" value="Editar" name="c_btn_edi_compra" id="id_btn_edi_compra" onclick="edit_compra();">
								<input type="button" value="Cancelar" name="c_btn_can_edit_compra" id="id_btn_can_edit_compra" style="display:none;" onclick="javascript:window.location.reload();">
								<input type="button" value="Guardar" name="c_btn_save_new_compra" id="id_btn_save_new_compra" style="display:none;" onclick="actualizar_compra();">
							</td>
						</tr>
						<tr>
							<td colspan="5">
								<div class="cl_div_detalle_compra_admin" id="id_div_detalle_compra_admin">
									<table class="cl_tabresultados" style="width:100%" border="1">
										<tr>
											<td><strong>CODIGO</strong></td>
											<td><strong>DETALLE</strong></td>
											<td><strong>CANTIDAD</strong></td>
											<td><strong>VAL. UNIT</strong></td>
											<td><strong>VA. TOTAL</strong></td>
											<td></td>
										</tr>
									<?php 
									/*IDT_DETALLES, DET_FK_IDPROD, DET_CANTIDAD, DET_VAL_UNIT, DET_VAL_TOT, DET_TIPO_TRNS, DET_EMP, DET_OFF, 
									DET_FK_IDCOMPROB, DET_NUM_FACTU, DET_FK_IDCLIPROV,*/

									/*PR_COD_PROD, PR_DETALLE, PR_PRESENTACION, PR_IMPUESTO, PR_ESTADO, PR_TIPO, PR_STOK_INI, PR_VAL_COMPRA, 
									PR_VAL_MIN, PR_VAL_MED, PR_VAL_MAX, PR_VAL_PVP, PR_OFFI, PR_EMPRESA, PR_BARRAS, PR_FK_PROVEEDOR, PR_COD_PROD, id*/
									$enlace = conectar_buscadores();
									$cad_detalle ="SELECT DET_FK_IDPROD,PR_DETALLE, PR_PRESENTACION, DET_CANTIDAD, DET_VAL_UNIT, DET_VAL_TOT , IDT_DETALLES
									FROM t_detalles,t_prodcutos 
									WHERE DET_EMP =".$_SESSION['empresa']." AND PR_EMPRESA=".$_SESSION['empresa']."
									AND DET_ESTADO=1 AND DET_FK_IDPROD= PR_COD_PROD and DET_NUM_FACTU='".$COM_NUM_COMPROB."' 
									AND  DET_FK_IDCOMPROB = ".$IDT_COMPROBANTE;	
									//echo $cad_detalle;						
									$ejec_cad_detalle=mysql_query($cad_detalle);
									//mysql_close($enlace);
									if (mysql_num_rows($ejec_cad_detalle)==0){
										echo "<tr><td colspan='5' style='background:#EBDE48;text-align:center'><h4>NO SE HA ENCONTADO INVENTARIO PARA ESTA COMPRA..!</h4></td><td></td></tr>";
									}
									while ($resdetalle=mysql_fetch_array($ejec_cad_detalle)) {
										?>
										<tr>
											<td><?php echo $resdetalle['DET_FK_IDPROD']; ?></td>
											<td><?php echo $resdetalle['PR_DETALLE'].' '.$resdetalle['PR_PRESENTACION']; ?></td>
											<td><?php echo $resdetalle['DET_CANTIDAD']; ?></td>
											<td><?php echo $resdetalle['DET_VAL_UNIT']; ?></td>
											<td align="right"><?php echo $resdetalle['DET_VAL_TOT']; ?></td>									
											<?php
											if ($_SESSION['cargo']== 1) {
												?>
												<td align="right">
													<input type="button" name="" id="" value="E" 
													onclick="cambiar_prod_comp('<?php echo $resdetalle['IDT_DETALLES']; ?>','<?php echo $resdetalle['DET_FK_IDPROD']; ?>',
													'<?php echo $resdetalle['PR_DETALLE'].' '.$resdetalle['PR_PRESENTACION']; ?>','<?php echo $resdetalle['DET_CANTIDAD']; ?>',
													'<?php echo $resdetalle['DET_VAL_UNIT']; ?>','<?php echo $resdetalle['DET_VAL_TOT']; ?>');">
												</td>
												<?php 
											}else{
												?>
												<td align="right">
													<input type="button" name="" id="" value="E" disabled/>
												</td>
												<?php 
											}
											 ?>
											
										</tr>							
										<?php 
									}
									 ?>
									 <tr>
									 	<td colspan="3" rowspan="5">
									 		<p style="font-size:12px;">

									 		<?php echo $onser_gener; ?>
									 		</p>
									 	</td>
									 	<td><strong>SUBTOTAL</strong></td>
									 	<td colspan="1" align="right">
									 		<input type="number" step="0.01" class="cl_txt2" name="c_subt_comp" id="id_subt_comp" value="<?php echo $val_subto; ?>" onkeyup="sumnew_compras();"; onblur="sumnew_compras();" readonly/>
									 	</td>
									 	<td align="right"><input type="button" value="E" disabled/></td>
									 </tr>
									 <tr>
									 	<td><strong>BASE 0%</strong></td>
									 	<td colspan="1" align="right">
									 		<input type="number" step="0.01" class="cl_txt2" name="c_base0_comp" id="id_base0_comp" value="<?php echo $val_base0; ?>" onkeyup="sumnew_compras();"; onblur="sumnew_compras();" readonly/>
									 	</td>
									 	<td align="right"><input type="button" value="E" disabled/></td>
									 </tr>
									 <tr>
									 	<td><strong>BASE 12%</strong></td>
									 	<td colspan="1" align="right">
									 		<input type="number" step="0.01" class="cl_txt2" name="c_base12_comp" id="id_base12_comp" value="<?php echo $val_base12; ?>" onkeyup="sumnew_compras();"; onblur="sumnew_compras();" readonly/>
									 	</td>
									 	<td align="right"><input type="button" value="E" disabled/></td>
									 </tr>
									 <tr>
									 	<td><strong>I.V.A.</strong></td>
									 	<td colspan="1" align="right">
									 		<input type="number" step="0.01" class="cl_txt2" name="c_iva_comp" id="id_iva_comp" value="<?php echo $iva_comprob; ?>" onkeyup="sumnew_compras();"; onblur="sumnew_compras();" readonly/>
									 	</td>
									 	<td align="right"><input type="button" value="E" disabled/></td>
									 </tr>
									 <tr>
									 	<td><strong>TOTAL.</strong></td>
									 	<td colspan="1" align="right">
									 		<input type="number" step="0.01" class="cl_txt2" name="c_total_comp" id="id_total_comp" value="<?php echo $val_total; ?>" readonly/>
									 	</td>
									 	<td align="right"><input type="button" value="E" disabled/></td>
									 </tr>
									</table>
								</div>						
							</td>
						</tr>
						<tr>
							<td colspan="5">
								<div class="cl_div_cambiar_prod" id="id_cambiar_prod" style="background:#BBC28F;display:none">	
									<table style="width:100%;" style="background:#BBC28F;">
										<tr>
											<td><h4>Cambie su prodcuto</h4></td>
										</tr>
										<tr>
											<td>Descripción</td>
											<td>Codigo</td>
											<td>Cantidad</td>									
											<td>V. Unit</td>
											<td>V. Tot</td>
											<td></td>
										</tr>
										<tr>
											<td>
												<input type="text" class="cl_txt" name="c_product" id="id_product" onkeyup="buscarprod(this.value,10,'<?php echo $_SESSION['empresa'] ?>');"  style="width:480px"><br>
												<input type="hidden" name="c_idt_detalles" id="id_hd_idt_Detalles" style="width:100px;">
												
												<div class="cl_div_clientes" id="id_div_filtroprod">
										
												</div>
											</td>
											<td><input type="text" class="cl_txt" name="c_codprod" id="id_codprod" style="width:100px" readonlY/></td>
											<td><input type="text" class="cl_txt" name="c_cantpro" id="id_cantpro" style="width:75px"></td>									
											<td><input type="text" class="cl_txt" name="c_v_unit" id="id_v_unit" style="width:75px"></td>	
											<td><input type="text" class="cl_txt" name="c_c_tot" id="id_c_tot" style="width:75px"></td>	
											<td><input type="button" onclick="cambiar_prod_bd();" value="G"></td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<div class="cl_div_resultcambio" id="id_div_resultcambio" style="display:inline-block;">
									<img src="img/cargar.gif" alt="" id="id_gif_cargar" style="display:none;">
								</div>
								<input type="hidden" id="id_hdn_id_cliente_ret" value="<?php echo $id_client ; ?>">
								<input type="hidden" id="id_hdn_numfactura_ret" value="<?php echo $COM_NUM_COMPROB ; ?>">
								<input type="hidden" id="id_hdn_letra" name="c_hdn_letra" value="<?php echo $tipotrans; ?>" readonly/>
								<input type="text" id="alerta_ret" value="" style="width:500px;border-style:none;font-size:12px;" readonly/>	
							</td>
							<td colspan="2" align="right">						
								<input type="button" value="Agregar val. ret." onclick="ocultar_mostar_nuevoval_ret('1');" style="padding:5px;">
								<?php 
								if ($formadepago == 1) {
								?>
								<input type="button" value="A Credito" onclick="cambiarfactura('<?php echo $IDT_COMPROBANTE; ?>','<?php echo $COM_NUM_COMPROB; ?>','<?php echo $tipotrans ; ?>',2);" style="padding:5px;">
								<?php
								} else{
								?>
								<input type="button" value="A Efectivo" onclick="cambiarfactura('<?php echo $IDT_COMPROBANTE; ?>','<?php echo $COM_NUM_COMPROB; ?>','<?php echo $tipotrans ; ?>',1);" style="padding:5px;">
								<?php
								}						
								 ?>	
							</td>							
						</tr>
						<tr>
							<td colspan="5">
								<div class="cl_civ_retenciones_admin" id="id__civ_retenciones_admin" style="width:100%;">
									<?php 
									$enlace = conectar_buscadores();
									$cad_verficar_retencion ="SELECT COM_NUM_COMPROB,IDT_COMPROBANTE FROM t_comprobante where 
									COM_EPRESA=".$_SESSION['empresa']." and COM_ESTADO_SIS = 1 and COM_FKID_CLI_PROV = ".$id_client." 
									AND COM_DOCAFECTADO = '".$COM_NUM_COMPROB."' AND COM_FKID_DOCAFECT = ".$IDT_COMPROBANTE;
									//echo $cad_verficar_retencion;
									$ejec_cad_verific_retencion = mysql_query($cad_verficar_retencion);	
									//mysql_close($enlace);

									if (mysql_num_rows($ejec_cad_verific_retencion)==0) {
										$msn = '<h4 style="background:#999896;margin:3px 0 3px 0;text-align:center;color:#000;">NO HAY UNA RETENCION ENVIADA CON ESTOS VALORES</h4>';
									} else {
										$resultado_comp_ret = mysql_fetch_row($ejec_cad_verific_retencion);
										$num_retencion = $resultado_comp_ret[0];
										$idt_comp_rete = $resultado_comp_ret[1];
										$msn = '<h4 style="background:#999896;margin:3px 0 3px 0;text-align:center;color:#000;">LA RETENCION <a href="http://181.113.67.126:2015/bddfacturacion_agromundosc/lib/phpimprimir_retencion.php?nunodc='.$num_retencion.'&id_doc='.$idt_comp_rete.'"> <strong>'.$num_retencion .'</strong> </a> YA HA SIDO ENVIADA..!</h4>';
									}
									?>	
									<?php 
										$enlace = conectar_buscadores();
										$cad_query_val_ret ="SELECT * FROM t_val_retenciones WHERE VALR_ESTADO=1 AND VALR_EMPRESA=".$_SESSION['empresa']." AND 
										 VALR_FK_IDCLIPROV=".$id_client." AND VALR_NUMFACT= '".$COM_NUM_COMPROB."' order by VALR_COD_SUST asc ";
										//echo $cad_query_val_ret;
										$ejc_cad_val_ret =mysql_query($cad_query_val_ret);
										//mysql_close($enlace);
										if (mysql_num_rows($ejc_cad_val_ret)==0) {
											echo "<h4 style='background:#EBDE48;text-align:center'>NO SE HA ENCONTADO VALORES DE RETENCION..!</h4>";
										} else {
											//########################################################################################
											
											?>								
											<table  class="cl_tabresultados" style="width:100%">
												<tr>
													<td colspan="6">
														<?php 
														echo $msn;
														 ?>
													</td>
												</tr>
												<tr>
													<td><strong>COD</strong></td>
													<td><strong>COD RET(312-344..).</strong></td>
													<td><strong>BASE IMP.</strong></td>									
													<td><strong>PORCENTAJE %</strong></td>
													<td><strong>VAL RET</strong></td>
													<td><strong></strong></td>
												</tr>
												<?php 
												//IDT_VAL_RETENCIONES, VALR_COD_RET, VALR_BASE_IMP, VALR_PORCENT, VALR_VAL_RET, VALR_COD_SUST, 
												//VALR_NUMFACT, VALR_FK_IDCLIPROV, VALR_EMPRESA, VALR_OFICINA, VALR_TIPO, VALR_ESTADO, VALR_FECHA_ENV, IDT_VAL_RETENCIONES, id
												$i=1;
												while ($res_val_ret = mysql_fetch_array($ejc_cad_val_ret)) {
													?>
												<tr>
													<td>
														<input type="text" class="cl_txt_comp" name="<?php echo "c_codsus_ret".$i; ?>" id="<?php echo "id_codsus_ret".$i; ?>" value="<?php echo $res_val_ret['VALR_COD_SUST']; ?>" style="width:80px;" readonly/>
														<input type="hidden" class="cl_txt_comp" name="<?php echo "c_hdn_idt_val_retenciones".$i; ?>" id="<?php echo "id_dt_val_retenciones".$i; ?>" value="<?php echo $res_val_ret['IDT_VAL_RETENCIONES']; ?>" readonly/>
													</td>
													<td><input type="text" class="cl_txt_comp" name="<?php echo "c_codisg_ret".$i; ?>" id="<?php echo "id_codisg_ret".$i; ?>" value="<?php echo $res_val_ret['VALR_COD_RET']; ?>" readonly/></td>
													<td><input type="text" class="cl_txt_comp" name="<?php echo "c_baseim_ret".$i; ?>" id="<?php echo "id_baseim_ret".$i; ?>" value="<?php echo $res_val_ret['VALR_BASE_IMP']; ?>" onkeyup="calcularnuevova_ret('<?php echo $i; ?>')" onblur="calcularnuevova_ret('<?php echo $i; ?>')" readonly/></td>
													<td><input type="text" class="cl_txt_comp" name="<?php echo "c_porcen_ret".$i; ?>" id="<?php echo "id_porcen_ret".$i; ?>" value="<?php echo $res_val_ret['VALR_PORCENT']; ?>" onkeyup="calcularnuevova_ret('<?php echo $i; ?>')" onblur="calcularnuevova_ret('<?php echo $i; ?>')" readonly/></td>
													<td><input type="text" class="cl_txt_comp" name="<?php echo "c_valora_ret".$i; ?>" id="<?php echo "id_valora_ret".$i; ?>" value="<?php echo $res_val_ret['VALR_VAL_RET']; ?>" readonly/></td>
													<td>
														<input type="button" value="e" name="<?php echo "c_btn_editar".$i; ?>" id="<?php echo "id_btn_editar".$i; ?>" onclick="editar_Val_ret('<?php echo $i; ?>');" title="Editar valor">
														<input type="button" value="x" name="<?php echo "c_btn_anular".$i; ?>" id="<?php echo "id_btn_anular".$i; ?>" onclick="guarda_val_ret('<?php echo $i; ?>',2);" title="Eliminar valor">
														<input type="button" value="g" name="<?php echo "c_btn_guarda".$i; ?>" id="<?php echo "id_btn_guarda".$i; ?>" onclick="guarda_val_ret('<?php echo $i; ?>',1);" title="Guardar valores" style="display:none;">
														<input type="button" value="c" name="<?php echo "c_btn_cancel".$i; ?>" id="<?php echo "id_btn_cancel".$i; ?>" onclick="cancelar_edico('<?php echo $i; ?>');" title="Cancelar edición" style="display:none;">
													</td>
												</tr>
													<?php 
													$i++;
												}
												 ?>
												 <tr>
												 	<td colspan="6" align="right">
												 		<input type="button" value="Regresar" onclick="">
												 		<input type="button" value="Generar XML y enviar al SRI" onclick="javascript:window.location='lib/new_retencion.php?numfct=<?php echo $COM_NUM_COMPROB; ?>&id_cli=<?php echo $id_client; ?>&idt_numcomp=<?php echo $IDT_COMPROBANTE; ?>'">
												 		<?php 

												 		$enlace = conectar_buscadores();
														$cad_verficar_retencion1 ="SELECT COM_NUM_COMPROB,IDT_COMPROBANTE FROM t_comprobante where 
														COM_EPRESA=".$_SESSION['empresa']." and COM_ESTADO_SIS = 1 and COM_FKID_CLI_PROV = ".$id_client." 
														AND COM_DOCAFECTADO = '".$COM_NUM_COMPROB."' AND COM_FKID_DOCAFECT = ".$IDT_COMPROBANTE;
														//echo $cad_verficar_retencion1;
														$ejec_cad_verific_retencion = mysql_query($cad_verficar_retencion1);	
														//mysql_close($enlace);

												 		if (mysql_num_rows($ejec_cad_verific_retencion)!=0) 
												 		{
															$resultado_comp_ret1 = mysql_fetch_row($ejec_cad_verific_retencion);
															$num_retencion1 = $resultado_comp_ret1[0];
															$idt_comp_rete1 = $resultado_comp_ret1[1];
														?>
														<input type="button" value="Reenviar XML al SRI" 
														onclick="javascript:window.location='lib/new_xml_retencion.php?numfct=<?php echo $COM_NUM_COMPROB;
														?>&id_cli=<?php echo $id_client; ?>&idt_numcomp=<?php echo $IDT_COMPROBANTE; ?>&idt_ret=<?php echo $idt_comp_rete1 ; ?>&numret=<?php echo $num_retencion1; ?>'">
														<?php
														}
														?>
												 	</td>
												 </tr>									 					 
											</table>
											<?php
											//########################################################################################
										}								
									 ?>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="5">
								<div class="cl_div_nuevovalor_ret" id="id_div_nuevo_valor_ret" style="display:none;border solid:1px;;">
						 			<table>
						 				<tr>
										 	<td colspan="3">
										 		<h4 style="background:#999896;margin:3px 0 3px 0;text-align:center;color:#000;"> NUEVOS VALORES DE RETENCÓN</h4>
										 	</td>
										 	<td colspan="3">
										 		<hr>
										 	</td>
						 				<tr>
						 					<td><strong>COD</strong></td>
											<td><strong>COD RET(312-344..).</strong></td>
											<td><strong>BASE IMP.</strong></td>									
											<td><strong>PORCENTAJE %</strong></td>
											<td><strong>VAL RET</strong></td>
											<td><strong></strong></td>
						 				</tr>
						 				<tr>
											<td>
												<input type="text" class="cl_txt_comp" name="c_codsus_ret99" id="id_codsus_ret99"  style="width:80px;">
												<input type="hidden" class="cl_txt_comp" name="c_hdn_idt_val_retenciones99" id="id_dt_val_retenciones99" value="0">
											</td>
											<td><input type="text" class="cl_txt_comp" name="c_codisg_ret99" id="id_codisg_ret99"></td>
											<td><input type="text" class="cl_txt_comp" name="c_baseim_ret99" id="id_baseim_ret99" onkeyup="calcularnuevova_ret('99')" onblur="calcularnuevova_ret('99')"></td>
											<td><input type="text" class="cl_txt_comp" name="c_porcen_ret99" id="id_porcen_ret99" onkeyup="calcularnuevova_ret('99')" onblur="calcularnuevova_ret('99')"></td>
											<td><input type="text" class="cl_txt_comp" name="c_valora_ret99" id="id_valora_ret99"></td>
											<td>
												<input type="button" value="g" name="c_btn_guarda99" id="id_btn_guarda99" onclick="guarda_val_ret('99',3);" title="Guardar valores">
												<input type="button" value="Cancelar" name="c_btn_cancel99" id="id_btn_cancel99" onclick="ocultar_mostar_nuevoval_ret('0');" title="Cancelar edición">
											</td>
										</tr>
						 			</table>
						 		</div>
							</td>
						</tr>
						<tr>
						 	<td colspan="5">
						 		<div class="cl_div_res_updateret" id="id_div_res_updateret">
						 		
						 		</div>
						 	</td>
						 </tr>	
					</table>
				</div>
				<?php 
			} else if ($tipotrans=='R') {
				echo "<script>			
					window.open('lib/phpimprimir_retencion.php?nunodc=".$COM_NUM_COMPROB."&id_doc=".$IDT_COMPROBANTE."','_blank');
					history.back();
				</script>";
			}else if ($tipotrans=='I' or $tipotrans=='J' or $tipotrans=='A' ) {
				/*$resultado = mysql_fetch_row($ejec_query_ejec_comrpbante);
				$tipotrans = $resultado[0]; //COM_TIPO_COMPR
				$razonsoci = $resultado[1].' '.$resultado[2]; //CP_NOMBRE
				$ruc_cedul = $resultado[3]; //CP_CEDULA
				$fech_crea = $resultado[4]; //COM_FEC_CREA
				$user_crea = $resultado[5]; //USU_LOGER
				$tipo_pago = $resultado[6]; //TP_DESCRIPCION
				$autorizac = $resultado[7]; //COM_AUTORIZACION_SRI
				$id_client = $resultado[8]; //COM_FKID_CLI_PROV
				$val_subto = $resultado[9]; //COM_VAL_SUBT
				$val_base0 = $resultado[10]; //COM_VAL_BASE0
				$val_base12 = $resultado[11]; //COM_VAL_BASE12
				$val_total = $resultado[12]; //COM_TOT
				//---otros datos para ventas
				$ambiente = $resultado[13]; //COM_AMBIENTE
				$estado_sri = $resultado[14]; //COM_ESTADO_SRI
				$calveacceso = $resultado[15]; //COM_CLAVEACESO_SRI
				$iva_comprob =$resultado[16]; //COM_IVA
				$obsert_trans = $resultado[17]; //COM_OBSERV_TIPOTRANSAC
				$formadepago = $resultado[18]; //COM_FKID_FORMAPAGO
				$onser_gener = $resultado[19]; //COM_OBSERV_GENRL
				$doc_afectad = $resultado[20]; //COM_DOCAFECTADO
				$fecha_autor = $resultado[21]; //COM_FEC_LLEGADA
				//daros boleanos o FK
				$estado_sis = $resultado[22];//COM_ESTADO_SIS
				$estado_pag = $resultado[23];//COM_ESTADO_PAGO
				$abono_sis = $resultado[24];//COM_ABONO
				$saldo_sis = $resultado[25];//COM_SALDO
				$msn_sis_sri = $resultado[26];//COM_MSN_SRI*/
				if ($tipotrans=='I') {
					$etiq='<h4>COMPROBANTE DE INGRESO</h4>';
					$etiq2 = "RECIBI DE :";
				} else if ($tipotrans=='J') {
					$etiq='<h4>COMPROBANTE DE EGRESO</h4>';
					$etiq2 = "ENTRGUE A :";
				}	else if ($tipotrans=='A') {
					$etiq='<h4>COMPROBANTE DE EGRESO</h4>';
					$etiq2 = "RECIBO DE COBRO:";
					echo "<script>						
						window.open('lib/php_imp_pago_cobro.php?id_comprob=".$IDT_COMPROBANTE ."&num_comprob=".$COM_NUM_COMPROB."','_blanck');						
						</script>";
				}
				?>
				<div class="cl_div_ingre_egre" id="id_div_ingre_egre" style="min-height:auto;max-height:300px;overflow:auto;width:700px;margin: 0 auto;">
					<?php
					if ($tipotrans <> 'A') {
					
						for ($i=0; $i <2 ; $i++) { 
							?>
							<table border="0">
							<tr>
								<td><br></td>
							</tr>
							<tr>
								<td colspan="3"><img src="img/logo.png" alt=""></td>					
								<td align="right">
									<?php echo $etiq; ?> <br>
									<h3 style="margin:0;padding:0;"><?php echo 'N° '. $COM_NUM_COMPROB; ?></h3>
								</td>
							</tr>				
							<tr>
								<td style="width:200px;"><?php echo $etiq2; ?></td>
								<td colspan="3" align="right"><input type="text" class="cl_txt" value="<?php echo $razonsoci ; ?>" style="width:450px;" readonly/></td>
							</tr>
							<tr>
								<td>LA CANTIDAD DE  :</td>
								<td colspan="3" align="right"><input type="text" class="cl_txt" value="<?php echo $val_total ; ?>" style="width:450px;" readonly/>	</td>
							</tr>
							<tr>
								<td>POR CONCEPTO DE:</td>
								<td colspan="2"><input type="text" class="cl_txt" value="<?php echo $obsert_trans ; ?>" style="width:220px;" readonly/>	</td>
								
								<td  align="right">EL DIA : <input type="text" class="cl_txt" value="<?php echo $fech_crea ; ?>" style="width:100px;" readonly/>	</td>
							</tr>
							<tr>
								<td><br><br><br></td>
								<td><br><br><br></td>
							</tr>
							<tr>
								<td COLSPAN="2">--------------------------------------</td>
								<td align="right" COLSPAN="2">--------------------------------------</td>
							</tr>
							<tr>
								<td COLSPAN="2">RECIBI CONFORME.</td>
								<td align="right" COLSPAN="2">ENTREGUE CONFORM</td>
							</tr>				
							<tr>
								<td><br><br><br><br><br><br><br><br><br><br></td>
							</tr>
						</table>
							<?php 
						}
					?>			
				</div>
				<div style="min-height:auto;max-height:300px;overflow:auto;width:600px;margin: 0 auto;" align="right">
					<br><br>
					<input type="button" class="btn_vh" value="Regresar" onclick="javascript:window.location='inicio.php?id=frm_egresos.php';" style="padding:5px;">
					<input type="button" class="btn_vh" value="Imprimir recibo" style="padding:5px;" onclick="printDiv('id_div_ingre_egre');" /> 
					<br><br>
				</div>
				<?php  
				}
				?>				
				<!-- -------------------------------------------------------------------------------------------------------------------- -->
				<script>
					function imprimir(data){
				  /*var objeto=document.getElementById('id_atn');  //obtenemos el objeto a imprimir
				  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
				  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
				  ventana.document.close();  //cerramos el documento
				  ventana.print();  //imprimimos la ventana
				  ventana.close();  //cerramos la ventana*/
					var mywindow = window.open('', 'new div', 'height=400,width=600');
					mywindow.document.write('<html>');
					mywindow.document.write('<link rel="stylesheet" href="css/midday_receipt.css" type="text/css" />');
					mywindow.document.write('<body style="margin-top:0px;">');
					mywindow.document.write(data);
					mywindow.document.write('</body></html>');

					mywindow.print();
					mywindow.close();

					return true;
					}

							function printDiv(divName) {
					     var printContents = document.getElementById(divName).innerHTML;
					     var originalContents = document.body.innerHTML;

					     document.body.innerHTML = printContents;

					     window.print();

					     document.body.innerHTML = originalContents;
					}
					</script>
					<!-- ----------------------------------------------------------------------------------------------------------------- -->
				<?php 
			}else if ($tipotrans=='A'){
				echo "<script>			
					window.open('lib/php_imp_pago_cobro.php?id_comprob=".$IDT_COMPROBANTE."&num_comprob=".$COM_NUM_COMPROB."','_blank');
				</script>";
			}else if ($tipotrans=='B'){
				echo "<script>				
					window.open('lib/php_imp_pago_provee.php?id_comprob=".$IDT_COMPROBANTE ."&num_comprob=".$COM_NUM_COMPROB."','_blank');			
				</script>";
				
				echo "<script>	
					window.open('lib/php_imp_cheque.php?id_comprobrob=".$IDT_COMPROBANTE ."','_blank');
				</script>";
			}

			$enlace = conectar_buscadores();
			$cad_asiento= "SELECT PCU_DESCRIPCION, PCU_CUENTA,ASI_DEBE, ASI_HABER,ITD_ASIENTO FROM  t_asiento, t_plancuentas WHERE
			AS_ESTADO = 1 AND  ASI_CUENTA = PCU_CUENTA AND ASI_FK_IDCOMPROB=".$IDT_COMPROBANTE;
			$jeca_asiento = mysql_query($cad_asiento);
			//mysql_close($enlace);
			?>
		</div>
		<div class="cl_doc_Relacionados" id="id_doc_Relacionados" style="width:820px;margin:0 auto;">
	 		<table style="width:100%;" class="cl_tabresultados">
	 			<tr>
	 				<td colspan="6">
	 					<h4 style="background:#999896;margin:3px 0 3px 0;color:#000;">Docs. Relacionados</h4>
	 				</td>
	 			</tr>
	 			<tr>
	 				<td>Num doc.</td>
	 				<td>Tipo de doc</td>
	 				<td>Fecha comprob</td>
	 				<td>Valor</td>
	 				<td>Creado por</td>
	 				<td>Estado</td>
	 			</tr>
	 		<?php 
	 		$enlace = conectar_buscadores();
	 		$cad_dos_rel = "SELECT IDT_COMPROBANTE, COM_NUM_COMPROB, COM_TIPO_COMPR, COM_FEC_CREA, COM_TOT, USU_LOGER,COM_ESTADO_SIS  
				FROM t_pagos_factu_comp, t_comprobante , t_usuario where 
				 PAG_FK_ID_COM_PAGO= IDT_COMPROBANTE and  PAG_NUM_COMPR_PAGO= COM_NUM_COMPROB and 
				 COM_FKID_USER_CREA = IDT_USUARIO and 
				 PAG_NUM_FAC_AFECTADO='".$COM_NUM_COMPROB ."' and PAG_TIPO_FACT_COMP = '".$tipotrans."'";
			//echo$cad_dos_rel;
			$ejec_cad_rel = mysql_query($cad_dos_rel);
			while ($res_docs_rel = mysql_fetch_array($ejec_cad_rel)) {
				if ($res_docs_rel['COM_ESTADO_SIS'] == 1) {
					$etiqEstadDocRel ="<p style='font-size:15px;margin:0;padding:0.1px;border-radius:3px;text-align:center;background:green;'>ACTIVO</p>";
				}else{
					$etiqEstadDocRel ="<p style='font-size:15px;margin:0;padding:0.1px;border-radius:3px;text-align:center;background:red;'>ANULADO</p>";
				}
				?>
			<tr>
				<td><a href="inicio.php?id=frm_administrar_comprobante.php&idcomprobante=<?php echo $res_docs_rel['IDT_COMPROBANTE']; ?>&num_comprob_Fac=<?php echo $res_docs_rel['COM_NUM_COMPROB']; ?>" 
					target="_blank"><?php echo $res_docs_rel['COM_NUM_COMPROB']; ?></a></td>
				<td><p style="font-size:15px;margin:0;padding:0;"><?php echo $res_docs_rel['COM_TIPO_COMPR']; ?></p></td>
				<td><p style="font-size:15px;margin:0;padding:0;"><?php echo $res_docs_rel['COM_FEC_CREA']; ?></p></td>
				<td><p style="font-size:15px;margin:0;padding:0;"><?php echo $res_docs_rel['COM_TOT']; ?></p></td>
				<td><p style="font-size:15px;margin:0;padding:0;"><?php echo $res_docs_rel['USU_LOGER']; ?></p></td>
				<td><?php echo $etiqEstadDocRel; ?></td>
			</tr>
				<?php 
			}
	 		 ?>	 		
	 		</table>
	 	</div>
	 	<br>
		<div class="cl_div_asiento" id="id_div_asiento" style="margin:0 auto;width:820px;">
			<table CLASS="cl_tabresultados" style="width:100%;">
				<tr>
					<td colspan="5">
						<h4 style="background:#999896;margin:3px 0 3px 0;color:#000;">Asiento contable</h4>
					</td>
				</tr>
				<tr>
					<td><p style="font-size:13px;margin :0 ; padding:0;"><strong>CUENTA.</strong></p></td>
					<td><p style="font-size:13px;margin :0 ; padding:0;"><strong>CODIGO.</strong></p></td>
					<td><p style="font-size:13px;margin :0 ; padding:0;"><strong>DEBE/ING.</strong></p></td>
					<td><p style="font-size:13px;margin :0 ; padding:0;"><strong>HABER/EGR.</strong></p></td>
					<td><p style="font-size:13px;margin :0 ; padding:0;"><strong></strong></p></td>
				</tr>
			<?php 

			$i=1;
			while ($res_asien = mysql_fetch_array($jeca_asiento)) {
			?>
			<tr>
				<td>
					<input type="text" class="cl_txt" name="" id="<?php echo "id_descr".$i; ?>" value="<?php echo $res_asien['PCU_DESCRIPCION']; ?>" style="width:450px;font-size:13px;" readonly/>
					<input type="hidden" class="cl_txt" name="" id="<?php echo "id_idt_asi".$i; ?>" value="<?php echo $res_asien['ITD_ASIENTO']; ?>" readonly/>
				</td>
				<td><input type="text" class="cl_txt" name="" id="<?php echo "id_cod_cue_asi".$i; ?>" value="<?php echo $res_asien['PCU_CUENTA']; ?>"  style="width:100px;font-size:13px;text-align:right;" readonly/></td>
				<td><input type="number" class="cl_txt2" name="" id="<?php echo "id_deb".$i; ?>" value="<?php echo $res_asien['ASI_DEBE']; ?>" readonly/></td>
				<td><input type="number" class="cl_txt2" name="" id="<?php echo "id_hab".$i; ?>" value="<?php echo $res_asien['ASI_HABER']; ?>" readonly/></td>
				<?php 
				if ($_SESSION['cargo'] ==1){
					?>
					<td><input type="button" value="E" title="Edtar" onclick="cambiar_cuenta('<?php echo $res_asien['ITD_ASIENTO']; ?>','<?php echo $res_asien['PCU_DESCRIPCION']; ?>',
					'<?php echo $res_asien['PCU_CUENTA']; ?>','<?php echo $res_asien['ASI_DEBE']; ?>','<?php echo $res_asien['ASI_HABER']; ?>')"></td>
					<?php
				}else{
					?>
					<td><input type="button" value="E" title="Edtar" disabled/></td>
					<?php
				}
				 ?>
			</tr>
			<?php 
			}
			if ($_SESSION['cargo'] ==1) {
				?>
				<tr>
					<td colspan="5" align="center">
					<input type="button" name="btn_gen_new_asiento" id="id_gen_new_asiento" onclick="mostrar_new_asi_admin_coprob('1')" value="Nuevo asiento">
					</td>
				</tr>
				<?php 
			} 
			 ?>
			</table>
		</div>
		<div class="cl_div_new_cuenta" id="id_div_new_cuenta" style="display:none;">
				<table class="cl_tabresultados">
					<tr>
						<td align="center" colspan="4">
							<h4>Cambio de cuenta </h4>
						</td>
					</tr>
					<tr>
						<td align="left">SELECCIONE NUEVA CUENTA</td>
						<td>CODIGO</td>
						<td>DEBE</td>
						<td>HABER</td>
						<td></td>
					</tr>
					<tr>
						<td>
							<input type="text" id="id_desc_nu_as" class="cl_txt" style="width:380px;font-size:13px;" onkeyup="buscarcuentas(this.value,'3');">
							<input type="hidden" id="id_idt_nu_as" class="cl_txt" style="width:30px;">
							<div class="cl_div_clientes" id="id_div_cuentas">
												
							</div>
						</td>
						<td><input type="text" id="id_codcu_nu_as" class="cl_txt" style="width:150px;font-size:13px;" readonly/></td>
						<td><input type="text" id="id_debe_nu_as" class="cl_txt2" style="width:100PX;font-size:13px;" readonly/></td>
						<td><input type="text" id="id_habe_nu_as" class="cl_txt2" style="width:100PX;font-size:13px;" readonly/></td>
						<td><input type="button" id="id_btn_update_as" value="G" onclick="update_cuenta_asiento();"></td>
					</tr>
					<tr>
						<td colspan="5">
							<br><br><br>
						</td>
					</tr>
					<tr>
						<td colspan="5" align="center">
						<div class="cl_res_update_asiento" id="id_res_update_asiento">
							<br><br><br><br><br><br><br>
						</div>
						</td>
					</tr>
				</table>
		</div>
		<div class="cl_div_new_asiento" id="id_div_new_asiento" style="display:none;">
			<form action="lib/new_asiento_editado.php" method="post" name="frm_new_asiento" id="id_frm_new_asiento" autocomplete="off">
				<table class="cl_tabresultados">
					<tr>
						<td>CUENTAS</td>
						<td align="right">CÓDIGO</td>
						<td align="right">DEBE</td>
						<td align="right">HABER</td>	
						<td align="right"></td>				
					</tr>
					<tr>
						<td>
							<input type="text" class="cl_txt" name="c_cuenta" id="id_movcuentaingresar2" style="width:600px" onkeyup="buscarcuentas2(this.value,'4');">
							<div class="cl_div_clientes" id="id_div_cuentas2">
								
							</div>
						</td>
						<td align="right"><input type="text" class="cl_txt" name="c_codigo_cuent" id="id_movcodcuenta2" style="width:80px;"></td>
						<td align="right" align="right"><input type="number" step="0.01" class="cl_txt2" name="c_debe_cuent" id="id_recreciingreso2" style="width:110px;"></td>
						<td align="right" align="right"><input type="number" step="0.01" class="cl_txt2" name="c_haber_cuent" id="id_recreciegreso2" style="width:110px;"></td>
						<td align="right"><input type="button" value="+" onclick="generartablacuentas2();"></input></td>
					</tr>
					<tr>
						<td colspan="5">
							<div class="cl_div_asiento2" id="id_div_asiento2">
								
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="5" align="right">
							<input type="number" step="0.01" name="c_total_debe" id="id_total_debe2" value="0" class="cl_txt2" readonly/>
							<input type="number" step="0.01" name="c_total_haber" id="id_total_haber2" value="0" class="cl_txt2" readonly/>
						</td>
					</tr>
					<tr>
						<td colspan="5" align="center">
							<input type="hidden" name="c_idt_comprob" id="id_idt_comprob" value="<?php echo $IDT_COMPROBANTE; ?>" readonly/>
							<input type="hidden" name="c_num_comprob" id="id_num_comprob" value="<?php echo $COM_NUM_COMPROB; ?>" readonly/>
							<input type="hidden" name="c_tipo_comp" id="id_tipo_comp" value="<?php echo $tipotrans; ?>" readonly/>
							<input type="submit" name="c_btn_guardar_new_Asi" id="id_btn_guardar_new_asi" value="Guardar">
						</td>
					</tr>
					<tr>
						<td colspan="5" align="center">
						<br><br><br><br><br><br><br><br><br><br><br><br><hr>
					</tr>
				</table>
			</form>
		</div>
	</fieldset>
	<?php
	//--------------------------------------------------------------------------------------------------------------------------------------------------
}else{
	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}
 ?>