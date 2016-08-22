<?php 
require_once('lib/phpconex.php');
$idcomp= $_GET['idcomp'];
//echo $idcomp;

$enlace = conectarbd();
$cadcompra ="SELECT * FROM bd_facelectronica.t_comprobante, bd_facelectronica.t_client_provee 
			where IDT_CLIENT_PROVEE= COM_FKID_CLI_PROV AND IDT_COMPROBANTE=".$idcomp;
$ejeccodcomp = mysql_query($cadcompra);
mysql_close($enlace);
while ($rescompra= mysql_fetch_array($ejeccodcomp)) {
	/* IDT_COMPROBANTE, COM_TIPO_COMPR, COM_SUBTIPO_COMP, COM_SECUEN_TIPO, COM_NUM_COMPROB, COM_VAL_SUBT, COM_VAL_BASE0, 
		COM_VAL_BASE12, COM_IVA, COM_TOT, COM_TOT_SIN_RET, COM_TOT_PAGO_COBR, COM_PARTEREL, COM_SUSTENTO_TRIB, COM_FKID_FORMAPAGO,
		COM_ABONO, COM_SALDO, COM_DOCAFECTADO, COM_FKID_DOCAFECT, COM_CLAVEACESO_SRI, COM_AUTORIZACION_SRI, COM_ESTADO_SIS,
		COM_ESTADO_CONTAB, COM_ESTADO_ATS_SRI, COM_ESTADO_PAGO, COM_ESTADO_SRI, COM_ESTADO_NULL, COM_MSN_SRI, COM_AMBIENTE, 
		COM_OBSERV_TIPOTRANSAC, COM_OBSERV_GENRL, COM_FKID_CLI_PROV, COM_FKID_USER_CREA, COM_FKID_USER_EDIT, COM_FKID_USER_ANULA,
		COM_FEC_CREA, COM_FEC_EDIT, COM_FEC_ANULA, COM_FEC_ENVIO, COM_FEC_LLEGADA, COM_FEC_CORTE, COM_FEC_PAGO, COM_PLAZO, 
		COM_EPRESA, COM_OFCINA*/
	if ($rescompra['COM_FKID_FORMAPAGO']==1) {
			$tippago = '<p style="background:#257CBE;">Efecetivo</p>';
	} else {
		$tippago = '<p style="background:#257CBE;">Efecetivo</p>';
	}

	if ($rescompra['COM_ESTADO_SIS']==1) {
		$estadopag = '<p style="background:red;">POR PAGAR</p>';
	} else if($rescompra['COM_ESTADO_SIS']==2) {
		$estadopag = '<p style="background:gren;">PAGADO</p>';
	}
	?>
	<div class="cl_cjcompra" id="id_cjcompra">
		<table>
			<tr>
				<td colspan="7">
					<div class="cl_datcompra" id="id_datcompra">
						<table>
							<tr>
								<td>Número de factura</td>
								<td>Fecha de ingreso</td>
								<td>Povedor</td>
								<td>Observacion</td>
								<td>Forma de pago</td>
								<td>Tipo Doc.</td>
							</tr>
							<tr>
								<td><input type="text" name="c_" class="cl_txt" id="id_" value="<?php echo $rescompra['COM_NUM_COMPROB']; ?>" readonly/></td>
								<td><input type="text" name="c_" class="cl_txt" id="id_" value="<?php echo $rescompra['COM_FEC_CREA']; ?>" readonly/></td>
								<td><input type="text" name="c_" class="cl_txt" id="id_" value="<?php echo $rescompra['CP_NOMBRE'].' '. $rescompra['CP_APELLIDO']; ?>" readonly/></td>
								<td><input type="text" name="c_" class="cl_txt" id="id_" value="<?php echo $rescompra['COM_OBSERV_GENRL']; ?>" readonly/></td>
								<td><?php echo $tippago; ?></td>
								<td><?php echo $estadopag; ?></td>
							</tr>
							<tr>
								<td><p class="cl_ptab">Autorización</p></td>
								<td colspan="4" align="right"><input type="text" name="c_" class="cl_txt" id="id_" value="<?php echo $rescompra['COM_AUTORIZACION_SRI']; ?>" style="width:95%;" readonly/></td>
								<td align="right"><input type="button" class="cl_btn" value="Editar" onclick="edtarcompra('id_edicioncompra');"></td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="7">
					<div class="cl_edicioncompra" id="id_edicioncompra" style="display:none;">
						<table>
							<tr>
								<td><h4>Edicion de factura</h4></td>
							</tr>
							<tr>
								<td>Número de factura</td>
								<td>Fecha de ingreso</td>
								<td>Povedor</td>
								<td>Observacion</td>
								<td>Forma de pago</td>
								<td>Tipo Doc.</td>
							</tr>
							<tr>
								<td><input type="text" name="c_" class="cl_txt" id="id_" style="width:150px;" maxlength="15" value="<?php echo $rescompra['COM_NUM_COMPROB']; ?>" ></td>
								<td><input type="text" name="c_" class="cl_txt" id="id_" style="width:100px;" value="<?php echo $rescompra['COM_FEC_CREA']; ?>" ></td>
								<td><input type="text" name="c_" class="cl_txt" id="id_" style="width:350px;" value="<?php echo $rescompra['CP_NOMBRE'].' '. $rescompra['CP_APELLIDO']; ?>" ></td>
								<td><input type="text" name="c_" class="cl_txt" id="id_" style="width:200px;" value="<?php echo $rescompra['COM_OBSERV_GENRL']; ?>" ></td>
								<td><?php echo $tippago; ?></td>
								<td>
									<select name="c_ingreso" id="id_cingreso" class="cl_cmb" style="width:134px;">
										<option value="0">SELECCIONAR..</option>
										<option value="1">FACTURA</option>
										<option value="2">NOTAS DE VENTA</option>
										<option value="3">NOTAS DE CREDITO</option>
										<option value="4">LIQ. DE COM. BIENES Y SERV.</option>
										<option value="5">NOTAS DE DEBITO</option>
										<option value="0">----------------OTROS----------------</option>
										<option value="6">NOTA PEDIDO</option>
										<option value="7">TRASPASO</option>	
									</select>
								</td>
							</tr>
							<tr>
								<td>Autorización</td>
								<td colspan="3" ><input type="text" style="width:100%;" class="cl_txt" name="c_" id="id_" value="<?php echo $rescompra['COM_AUTORIZACION_SRI']; ?>"></td>
								<td align="right"><input type="button" class="cl_btn" value="Cancelar" onclick="edtarcompra('id_datcompra');"></td>
								<td align="right"><input type="button" class="cl_btn" value="Actualizar" ></td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<?php 
}
 ?>