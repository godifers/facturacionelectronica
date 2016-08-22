<?php 
if (isset($_SESSION['empresa']) ) {
	require_once('lib/phpconexcion.php');
	$idcomp=$_GET['idcomp'];
	$numfa =$_GET['numf'];
	$enlace = conectar_buscadores();
	$cadventa ="SELECT CP_TIPO_ID,CP_NOMBRE,CP_APELLIDO,CP_CEDULA,COM_VAL_SUBT ,CP_DIRECCION,CP_MAIL,CP_TELEFONO,COM_FKID_FORMAPAGO
			,COM_NUM_COMPROB,COM_FEC_CREA,COM_CLAVEACESO_SRI, COM_VAL_BASE0, COM_VAL_BASE12,COM_IVA,COM_TOT,COM_AMBIENTE
			,COM_AUTORIZACION_SRI, COM_ESTADO_SRI, COM_TIPO_COMPR,TP_DESCRIPCION, COM_DOCAFECTADO, COM_FEC_LLEGADA
			FROM t_comprobante ,t_client_provee , t_formas_pago where IDT_FORMAS_PAG0= COM_FKID_FORMAPAGO and  COM_EPRESA=".$_SESSION['empresa']." 
			AND COM_FKID_CLI_PROV=IDT_CLIENT_PROVEE 
			and IDT_COMPROBANTE=".$idcomp." and  COM_NUM_COMPROB = '".$numfa."'";
			//echo $cadventa;
	$ejc_cadventa =mysql_query($cadventa);
	//mysql_close($enlace);
	$resventa = mysql_fetch_row($ejc_cadventa);
	$tipoidencompra= $resventa[0];
	$nomcomprador= $resventa[1];
	$apecomprador= $resventa[2];
	$ruc_ced= $resventa[3];
	$subtota= $resventa[4];
	$dir_cli= $resventa[5];
	$mail_cli= $resventa[6];
	$telf_cli= $resventa[7];
	$formpago_fact= $resventa[8];
	$numcomp = $resventa[9];
	$fecha_fact =$resventa[10];
	$calveacceso = $resventa[11];
	$base0 = $resventa[12];
	$base12= $resventa[13];
	$ivafact =$resventa[14];
	$total = $resventa[15];
	$amb = $resventa[16];
	$autorizacion_sri =  $resventa[17];
	$estado_sri = $resventa[18];
	$tipo_comprobante = $resventa[19];
	$formpago_fact_1 = $resventa[20];
	$doc_afect = $resventa[21];
	$fec_autori = $resventa[22];

	if (is_null($fec_autori)) {
		$fec_autori = $fecha_fact.'.';
	}else{
		$fec_autori = $fec_autori;
	}

	//echo $amb;
	if ($amb==1) {
		$etiqamb ='Pruebas';
	} else if ($amb==2) {
		$etiqamb ='Produccion';
	}else{
		$etiqamb='error';
	}

	$enlace = conectar_buscadores();
	$cademp ="SELECT EMP_RAZON_SOCIAL, EMP_RUC, EMP_DIRECCION_MATRIZ, EMP_TELEFONO, EMP_NOMBRE,EMP_AMBIENTE,EMP_PRIMER_FACT,EMP_DIR_LOCAL 
	FROM t_empresa where IDT_EMPRESA =".$_SESSION['empresa'];
	//echo $cademp;
	$ejeccademp =mysql_query($cademp);
	//mysql_close($enlace);
	$resemp = mysql_fetch_row($ejeccademp);
	$razsoc_emp= $resemp[0];
	$ruc_emp= $resemp[1];
	$dir_matriz_emp= $resemp[2];
	$tel_emp= $resemp[3];
	$nom_emp= $resemp[4];
	$amb_emp= $resemp[5];
	$prf_emp= $resemp[6];
	$dir_local_emp = $resemp[7];

	$enlace = conectar_buscadores();
	$caddetalleventa ="SELECT DET_FK_IDPROD,PR_DETALLE,PR_PRESENTACION,DET_CANTIDAD,DET_VAL_UNIT,DET_VAL_TOT ,PR_IMPUESTO
	FROM t_detalles, t_prodcutos
	where DET_EMP =".$_SESSION['empresa']." AND  DET_FK_IDCOMPROB=".$idcomp." AND DET_NUM_FACTU='".$numcomp."' 
	AND DET_FK_IDPROD= PR_COD_PROD  AND PR_EMPRESA =".$_SESSION['empresa']." and DET_TIPO_TRNS='".$tipo_comprobante."' ORDER BY IDT_DETALLES ASC";
	//echo $caddetalleventa;
	$eje_caddetalleventa = mysql_query($caddetalleventa);
	//mysql_close($enlace);

	if (mysql_num_rows($eje_caddetalleventa)==0 and $tipo_comprobante =='G') {
		$enlace = conectar_buscadores();
		$caddetalleventa ="SELECT DET_FK_IDPROD,PR_DETALLE,PR_PRESENTACION,DET_CANTIDAD,DET_VAL_UNIT,DET_VAL_TOT ,PR_IMPUESTO 
		from t_detalles, t_detalle_guias, t_prodcutos where PR_COD_PROD= DET_FK_IDPROD and DET_FK_IDCOMPROB=DETG_FK_ID_DOC_FACT_REL 
		and DETG_FK_IDT_COMPROBANTE=".$idcomp." AND PR_EMPRESA= ".$_SESSION['empresa']." ORDER BY IDT_DETALLES ASC";
		//echo $caddetalleventa;
		$eje_caddetalleventa = mysql_query($caddetalleventa);
		//mysql_close($enlace);
	}

	$enlace = conectar_buscadores();
	$caddetalleventa1 ="SELECT DET_FK_IDPROD,PR_DETALLE,PR_PRESENTACION,DET_CANTIDAD,DET_VAL_UNIT,DET_VAL_TOT ,PR_IMPUESTO
	FROM t_detalles, t_prodcutos
	where DET_EMP =".$_SESSION['empresa']." AND DET_FK_IDCOMPROB=".$idcomp." AND DET_NUM_FACTU='".$numcomp."' 
	AND DET_FK_IDPROD= PR_COD_PROD AND PR_EMPRESA =".$_SESSION['empresa']."  and DET_TIPO_TRNS='".$tipo_comprobante."' ORDER BY IDT_DETALLES ASC";
	$eje_caddetalleventa1 = mysql_query($caddetalleventa1);

	if (mysql_num_rows($eje_caddetalleventa1)==0 and $tipo_comprobante =='G') {
		$enlace = conectar_buscadores();
		$caddetalleventa1 ="SELECT DET_FK_IDPROD,PR_DETALLE,PR_PRESENTACION,DET_CANTIDAD,DET_VAL_UNIT,DET_VAL_TOT ,PR_IMPUESTO 
		from t_detalles, t_detalle_guias, t_prodcutos where PR_COD_PROD= DET_FK_IDPROD and DET_FK_IDCOMPROB=DETG_FK_ID_DOC_FACT_REL 
		and DETG_FK_IDT_COMPROBANTE=".$idcomp." AND PR_EMPRESA= ".$_SESSION['empresa']." ORDER BY IDT_DETALLES ASC";
		//echo $caddetalleventa1;
		$eje_caddetalleventa1 = mysql_query($caddetalleventa1);
		//mysql_close($enlace);
	}
	//mysql_close($enlace);

	$enlace = conectar_buscadores();
	$cad_conductor = "SELECT CON_NOMBRE_RZ,CON_ID_RUC, CON_PLACAS, CON_DESCRIPCION FROM  t_conductores, t_detalle_guias
		WHERE DETG_FK_IDT_CONDUCTOR= IDT_CONDUCTORES and DETG_FK_IDT_COMPROBANTE=". $idcomp;
	$ejec_cad_conduct = mysql_query($cad_conductor);
	//echo $cad_conductor;
	//mysql_close($enlace);
	$res_conduct = mysql_fetch_row($ejec_cad_conduct);


	 ?>
	 <!DOCTYPE html>
	 <html lang="en">
	 <head>
	 	<meta charset="UTF-8">
	 	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	 	<title>frm_impresion</title>
	 </head>
	 <body>
	 	<div class="cl_cjimpresion" id="id_cjimpresion">
	 		<br>
	 		<table>
	 			<tr>
	 				<td style="border:solid 1px #000;">
	 					<table border="0" class="t_impres">
	 						<tr>
	 							<td colspan="4" align="center">
	 								<img src="img/logo.png" alt="Logo" style="height:40px;width:150px;">
	 							</td>
	 							<td colspan="2">	 								
	 								<?php 
	 								if ($tipo_comprobante=='V') {
	 									?>
	 									<h5>FACTURA N°</h5>
	 									<?php
	 								} else if ($tipo_comprobante == 'N'){
	 									?>
	 									<h5>NOTA DE CREDITO N°</h5>
	 									<?php
	 								} else if ($tipo_comprobante == 'G'){
	 									?>
	 									<h5>GUIA DE REMISIÓN </h5>
	 									<?php
	 								}else if ($tipo_comprobante == 'H'){
	 									?>
	 									<h5>GUIA DE REMISIÓN INGRESADA </h5>
	 									<?php
	 								}else if ($tipo_comprobante == 'W'){
	 									?>
	 									<h5>COPIA FACTRURA MANUAL</h5>
	 									<?php
	 								}else {
	 									?>
	 									<h5>DOCUMENTO SIN TITULO </h5>
	 									<?php
	 								}	 								
	 								?>
	 								<p style="margin:0;"><strong></strong><?php echo $numcomp; ?></p>
	 							</td>
	 						</tr> 						
	 						<tr>
	 							<td colspan="6">
	 								<table border="0">
	 									<tr>
				 							<td style="width:60%;" align="center"><p class="cl_pimp cl_etiq" style="sont-size:7px;"><?php echo $razsoc_emp; ?></p></td>
				 							<td style="width:40%;"><p class="cl_pimp cl_etiq"><strong>NÚMERO DE AUTORIZACIÓN</strong> <br><?php echo $autorizacion_sri ; ?></p></td>
				 						</tr>
				 						<tr>
				 							<td><p class="cl_pimp cl_etiq"><strong>R.U.C. </strong><?php echo $ruc_emp; ?></p></td>
				 							<td><p class="cl_pimp cl_etiq"><strong>Fecha de autorizacion</strong> <?php echo $fec_autori; ?></p></td>
				 						</tr>
				 						<tr>
				 							<td><p class="cl_pimp cl_etiq"><strong>Dir. Matriz</strong> <?php echo $dir_matriz_emp; ?></p></td>
				 							<td><p class="cl_pimp cl_etiq"><strong>Ambiente: </strong><?php echo $etiqamb.'  -  '; ?> <strong>Estado: </strong><?php echo $estado_sri; ?></p></td>
				 						</tr>
				 						<tr>
				 							<td colspna="2"><p class="cl_pimp cl_etiq"><strong></strong></p></td>
				 							<td rowspan="2"><p class="cl_pimp cl_etiq" style="margin:0;"><strong>CLAVE DE ACCESO </strong></p><p style="font-size:9px;" style="margin:0;"><?php echo $calveacceso; ?></p></td>
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
	 										<td colspan="5">
	 											<table style="width:100%;" >
	 												<tr>
				 										<td colspan="3"><p class="cl_pimp"><strong>Cliente:</strong> <?php echo utf8_encode($apecomprador).' '.utf8_encode($nomcomprador); ?></p></td>
				 										<td colspan="2" align="right"><p class="cl_pimp"><strong>Identificacion:</strong> <?php echo $ruc_ced; ?></p></td>
				 									</tr>
				 									<tr>
				 										<td colspan="3"><p class="cl_pimp"><strong>Fecha Emisión:</strong> <?php echo $fecha_fact; ?></p></td>
				 										<td colspan="2" align="right">
				 											<?php 
				 											if ($tipo_comprobante=='N'){
				 												?>
				 											<p class="cl_pimp"><strong>Doc. afect:</strong> <?php echo $doc_afect; ?></p>
				 												<?php
				 											}
				 											 ?>
				 										</td>
				 									</tr>
	 											</table>
	 										</td>
	 									</tr>
	 									<tr>
	 										<td><p class="cl_pimp cl_etiq" style="font-size:8px;"><strong>CODIGO</strong></p></td>
	 										<td style="width:60%;"><p class="cl_pimp cl_etiq" style="font-size:8px;"><strong>DESCRIPCIÓN</strong></p></td>
	 										<td align="right"><p class="cl_pimp cl_etiq" style="font-size:8px;"><strong>CANTIDAD</strong></p></td>
	 										<td align="right"><p class="cl_pimp cl_etiq" style="font-size:8px;"><strong>V. UNIT.</strong></p></td>
	 										<td align="right"><p class="cl_pimp cl_etiq" style="font-size:8px;"><strong>V. TOT.</strong></p></td>
	 									</tr>	
										<?php 
										while($resdetalles=mysql_fetch_array($eje_caddetalleventa)) 
										  {
										  	?>
										  	<tr>
										  	<td><p class="cl_pimp"><?php echo $resdetalles['DET_FK_IDPROD']; ?></p></td>
										  	<td><p class="cl_pimp"><?php echo $resdetalles['PR_DETALLE'].' '.$resdetalles['PR_PRESENTACION']; ?></p></td>
										  	<td align="right"><p class="cl_pimp"><?php echo $resdetalles['DET_CANTIDAD']; ?></p></td>
										  	<td align="right"><p class="cl_pimp"><?php echo $resdetalles['DET_VAL_UNIT']; ?></p></td>
										  	<td align="right"><p class="cl_pimp"><?php echo $resdetalles['DET_VAL_TOT']; ?></p></td>
										  	</tr>
										  	<?php 
										  }
										?>	
										<tr>
											<td colspan="2" rowspan="6">												
												<table>
													<tr>
														<td colspan="2"><p class="cl_pimp"><strong>INFORMAICÓN ADICIONAL</strong></p></td>
													</tr>
													<tr>
														<td><p class="cl_pimp">Dirección</p></td>
														<td colspan=<td colspan="3"><p class="cl_pimp"><?php echo utf8_encode($dir_cli); ?></p></td>
													</tr>
													<tr>
														<td><p class="cl_pimp">F. pago</p></td>
														<td><p class="cl_pimp"><?php echo $formpago_fact_1; ?></p></td>
													</tr>
													<tr>
														<td><p class="cl_pimp">E-mail</p></td>
														<td><p class="cl_pimp"><?php echo $mail_cli; ?></p></td>
													</tr>
													<tr>
														<td><p class="cl_pimp">Teléfono</p></td>
														<td><p class="cl_pimp"><?php echo $telf_cli ; ?></p></td>
													</tr>
													<?php 
													if ($tipo_comprobante=='G' or $tipo_comprobante=='H') {											

													?>

													<tr>
														<td><p class="cl_pimp"><strong>Factura N: </strong></p></td>
														<td><p class="cl_pimp"><?php echo $doc_afect; ?></p></td>
														<td><p class="cl_pimp"><strong>Fecha : </strong></p></td>
														<td><p class="cl_pimp">S/N</p></td>
													</tr>
													<tr>
														<td><p class="cl_pimp"><strong>Conductor</strong></p></td>
														<td><p class="cl_pimp"><?php echo $res_conduct[0]; ?></p></td>
														<td><p class="cl_pimp"><strong>RUC.</strong></p></td>
														<td><p class="cl_pimp"><?php echo $res_conduct[1]; ?></p></td>
													</tr>
													<tr>
														<td><p class="cl_pimp"><strong>Vehiculo</strong></p></td>
														<td><p class="cl_pimp"><?php echo $res_conduct[3]; ?></p></td>
														<td><p class="cl_pimp"><strong>Placa</strong></p></td>
														<td><p class="cl_pimp"><?php echo $res_conduct[2]; ?></p></td>
													</tr>
													<?php
													}
													 ?>
												</table>
											</td>
											</td>
											
											<td colspan="2" align="right"><p class="cl_pimp">SUBTOTAL</p></td>
											<td><p class="cl_pimp"  align="right"><?php echo $subtota; ?></p></td>
											
										</tr>
										
										<tr>
											<td colspan="2" align="right"><p class="cl_pimp">DESCUENTO</p></td>
											<td class="cl_pimp" align="right"><p class="cl_pimp">0.00</p></td>
										</tr>
										<tr>
											<td colspan="2" align="right">
												<p class="cl_pimp">
													<?php
													if ($_SESSION['porcenIVA'] == 1.12) {
														echo "BASE 12%:";
													} else if ($_SESSION['porcenIVA'] == 1.14){
														echo "BASE 14%:";
													}											
													?>
												</p>
											</td>
											<td><p class="cl_pimp"  align="right"><?php echo $base12; ?></p></td>
										</tr>
										<tr>
											<td colspan="2" align="right"><p class="cl_pimp">BASE 0%:</p></td>
											<td><p class="cl_pimp"  align="right"><?php echo $base0; ?></p></td>
										</tr>
										<tr>
											<td colspan="2" align="right"><p class="cl_pimp">
												<?php
												if ($_SESSION['porcenIVA'] == 1.12) {
													echo "I.V.A 12%:";
												} else if ($_SESSION['porcenIVA'] == 1.14){
													echo "I.V.A 14%:";
												}
												
												?>
												</p></td>
											<td><p class="cl_pimp"  align="right"><?php echo $ivafact; ?></p></td>
										</tr>
										<tr>
											<td colspan="2" align="right"><p class="cl_pimp">TOTAL:</p></td>
											<td><p class="cl_pimp"  align="right"><?php echo $total; ?></p></td>
										</tr>
										<tr>
											<td colspan="2" align="center">
												<br>--------------------------------
												<p class="cl_pimp">Recibí conforme</p>
											</td>
											<td colspan="4" align="center">
												<br>---------------
												<p class="cl_pimp">Entregue confrome</p>
											</td>
										</tr>							
	 								</table>
	 							</td>
	 						</tr>
	 					</table>
	 				</td>
	 				<td style="border-right:solid 1px red;"></td>
	 				<td style="border-left:solid 1px red;"></td>
	 				<td style="border:solid 1px #000;">
	 					<table border="0" class="t_impres">
	 						<tr>
	 							<td colspan="4" align="center">
	 								<img src="img/logo.png" alt="Logo" style="height:40px;width:150px;">
	 							</td>
	 							<td colspan="2">	 								
	 								<?php 
	 								if ($tipo_comprobante=='V') {
	 									?>
	 									<h5>FACTURA N°</h5>
	 									<?php
	 								} else if ($tipo_comprobante == 'N'){
	 									?>
	 									<h5>NOTA DE CREDITO N°</h5>
	 									<?php
	 								} else if ($tipo_comprobante == 'G'){
	 									?>
	 									<h5>GUIA DE REMISIÓN </h5>
	 									<?php
	 								}else if ($tipo_comprobante == 'H'){
	 									?>
	 									<h5>GUIA DE REMISIÓN INGRESADA </h5>
	 									<?php
	 								}else if ($tipo_comprobante == 'W'){
	 									?>
	 									<h5>COPIA FACTRURA MANUAL</h5>
	 									<?php
	 								}else {
	 									?>
	 									<h5>DOCUMENTO SIN TITULO </h5>
	 									<?php
	 								}	 								
	 								?>
	 								<p style="margin:0;"><strong></strong><?php echo $numcomp; ?></p>
	 							</td>
	 						</tr> 	
	 						<tr>
	 							<td colspan="6">
	 								<table border="0">
	 									<tr>
				 							<td style="width:60%;" align="center"><p class="cl_pimp" style="sont-size:7px;"><?php echo $razsoc_emp; ?></p></td>
				 							<td style="width:40%;"><p class="cl_pimp"><strong>NÚMERO DE AUTORIZACIÓN</strong> <br><?php echo $autorizacion_sri ; ?></p></td>
				 						</tr>
				 						<tr>
				 							<td><p class="cl_pimp"><strong>R.U.C. </strong><?php echo $ruc_emp; ?></p></td>
				 							<td><p class="cl_pimp"><strong>Fecha de autorizacion</strong> <?php echo $fec_autori; ?></p></td>
				 						</tr>
				 						<tr>
				 							<td><p class="cl_pimp"><strong>Dir. Matriz</strong> <?php echo $dir_matriz_emp; ?></p></td>
				 							<td><p class="cl_pimp"><strong>Ambiente: </strong> <?php echo $etiqamb.'  -  ';?>  <strong>Estado: </strong><?php echo $estado_sri; ?></p></td>
				 						</tr>
				 						<tr>
				 							<td colspna="2"><p class="cl_pimp"><strong></strong></p></td>
				 							<td rowspan="2"><p class="cl_pimp cl_etiq" style="margin:0;"><strong>CLAVE DE ACCESO </strong></p><p style="font-size:9px;" style="margin:0;"><?php echo $calveacceso; ?></p></td>
				 						</tr>
				 						<tr>
				 							<td><p class="cl_pimp" style="font-size:10px;"><strong>OBLIGADO A LLEVAR CONTABILIDAD: SI</strong></p></td>
				 						</tr>
	 								</table>
	 							</td>
	 						</tr> 				
	 						<tr>
	 							<td colspan="6">
	 								<table border="1" style="width:100%;" class="cl_tabresultados">
	 									<tr>
	 										<td colspan="5">
	 											<table style="width:100%;" >
	 												<tr>
				 										<td colspan="3"><p class="cl_pimp"><strong>Cliente:</strong> <?php echo utf8_encode($apecomprador).' '.utf8_encode($nomcomprador); ?></p></td>
				 										<td colspan="2" align="right"><p class="cl_pimp"><strong>Identificacion</strong>: <?php echo $ruc_ced; ?></p></td>
				 									</tr>
				 									<tr>
				 										<td colspan="3"><p class="cl_pimp"><strong>Fecha Emisión</strong>: <?php echo $fecha_fact; ?></p></td>
				 										<td colspan="2" align="right">
				 											<?php 
				 											if ($tipo_comprobante=='N'){
				 												?>
				 											<p class="cl_pimp"><strong>Doc. afect:</strong> <?php echo $doc_afect; ?></p>
				 												<?php
				 											}
				 											 ?>
				 										</td>
				 									</tr>
	 											</table>
	 										</td>
	 									</tr>
	 									<tr>
	 										<td><p class="cl_pimp cl_etiq" style="font-size:8px;"><strong>CODIGO</strong></p></td>
	 										<td style="width:60%;"><p class="cl_pimp cl_etiq" style="font-size:8px;"><strong>DESCRIPCIÓN</strong></p></td>
	 										<td align="right"><p class="cl_pimp cl_etiq" style="font-size:8px;"><strong>CANTIDAD</strong></p></td>
	 										<td align="right"><p class="cl_pimp cl_etiq" style="font-size:8px;"><strong>UNIT.</strong></p></td>
	 										<td align="right"><p class="cl_pimp cl_etiq" style="font-size:8px;"><strong>TOT.</strong></p></td>
	 									</tr>	
										<?php 
										while($resdetalles1=mysql_fetch_array($eje_caddetalleventa1)) 
										  {
										  	?>
										  	<tr>
										  	<td><p class="cl_pimp"><?php echo $resdetalles1['DET_FK_IDPROD']; ?></p></td>
										  	<td><p class="cl_pimp"><?php echo $resdetalles1['PR_DETALLE'].' '.$resdetalles1['PR_PRESENTACION']; ?></p></td>
										  	<td align="right"><p class="cl_pimp"><?php echo $resdetalles1['DET_CANTIDAD']; ?></p></td>
										  	<td align="right"><p class="cl_pimp"><?php echo $resdetalles1['DET_VAL_UNIT']; ?></p></td>
										  	<td align="right"><p class="cl_pimp"><?php echo $resdetalles1['DET_VAL_TOT']; ?></p></td>
										  	</tr>
										  	<?php 
										  }
										?>	
										<tr>
											<td colspan="2" rowspan="6">
												<table>
													<tr>
														<td colspan="2"><p class="cl_pimp"><strong>INFORMAICÓN ADICIONAL</strong></p></td>
													</tr>
													<tr>
														<td><p class="cl_pimp">Dirección</p></td>
														<td colspan="3"><p class="cl_pimp"><?php echo utf8_encode($dir_cli); ?></p></td>
													</tr>
													<tr>
														<td><p class="cl_pimp">F. pago</p></td>
														<td><p class="cl_pimp"><?php echo $formpago_fact_1; ?></p></td>
													</tr>
													<tr>
														<td><p class="cl_pimp">E-mail</p></td>
														<td><p class="cl_pimp"><?php echo $mail_cli; ?></p></td>
													</tr>
													<tr>
														<td><p class="cl_pimp">Teléfono</p></td>
														<td><p class="cl_pimp"><?php echo $telf_cli ; ?></p></td>
													</tr>													

													<?php 
													if ($tipo_comprobante=='G' or $tipo_comprobante=='H') {												
													
													 ?>
													<tr>
														<td><p class="cl_pimp"><strong>Factura N : </strong></p></td>
														<td><p class="cl_pimp"><?php echo $doc_afect ?></p></td>
														<td><p class="cl_pimp"><strong>Fecha : </strong></p></td>
														<td><p class="cl_pimp">S/N</p></td>
													</tr>
													<tr>
														<td><p class="cl_pimp"><strong>Conductor</strong></p></td>
														<td><p class="cl_pimp"><?php echo $res_conduct[0]; ?></p></td>
														<td><p class="cl_pimp"><strong>RUC.</strong></p></td>
														<td><p class="cl_pimp"><?php echo $res_conduct[1]; ?></p></td>
													</tr>
													<tr>
														<td><p class="cl_pimp"><strong>Vehiculo</strong></p></td>
														<td><p class="cl_pimp"><?php echo $res_conduct[3]; ?></p></td>
														<td><p class="cl_pimp"><strong>Placa</strong></p></td>
														<td><p class="cl_pimp"><?php echo $res_conduct[2]; ?></p></td>
													</tr>	
													<?php
													}
													 ?>												
												</table>
											</td>											
											<td colspan="2" align="right"><p class="cl_pimp">SUBTOTAL</p></td>
											<td><p class="cl_pimp"  align="right"><?php echo $subtota; ?></p></td>
											
										</tr>									
										
										<tr>
											<td colspan="2" align="right"><p class="cl_pimp">DESCUENTO</p></td>
											<td class="cl_pimp" align="right"><p class="cl_pimp">0.00</p></td>
										</tr>
										<tr>
											<td colspan="2" align="right">
												<p class="cl_pimp">
													<?php
													if ($_SESSION['porcenIVA'] == 1.12) {
														echo "BASE 12%:";
													} else if ($_SESSION['porcenIVA'] == 1.14){
														echo "BASE 14%:";
													}											
													?>
												</p>
											</td>
											<td><p class="cl_pimp"  align="right"><?php echo $base12; ?></p></td>
										</tr>
										<tr>
											<td colspan="2" align="right"><p class="cl_pimp">BASE 0%:</p></td>
											<td><p class="cl_pimp"  align="right"><?php echo $base0; ?></p></td>
										</tr>
										<tr>
											<td colspan="2" align="right"><p class="cl_pimp">
											<?php
											if ($_SESSION['porcenIVA'] == 1.12) {
												echo "I.V.A 12%:";
											} else if ($_SESSION['porcenIVA'] == 1.14){
												echo "I.V.A 14%:";
											}											
											?>
											</p></td>
											<td><p class="cl_pimp"  align="right"><?php echo $ivafact; ?></p></td>
										</tr>
										<tr>
											<td colspan="2" align="right"><p class="cl_pimp">TOTAL:</p></td>
											<td><p class="cl_pimp"  align="right"><?php echo $total; ?></p></td>
										</tr>	
										
										<tr>
											<td colspan="2" align="center">
												<br>--------------------------------
												<p class="cl_pimp">Recibí conforme</p>
											</td>
											<td colspan="4" align="center">
												<br>---------------
												<p class="cl_pimp">Entregue confrome</p>
											</td>
										</tr>							
	 								</table>
	 							</td>
	 						</tr> 						
	 					</table>
	 				</td>
	 			</tr>
	 			<tr>
	 				
	 			</tr>
	 		</table>
	 	</div>
	 	<br>
	 	<div class="cl_btnsvh" id="id_btnsvh"> 		
	 		<input type="button" class="btn_vh" value="Regresar" onclick="goBack();" style="margin-left:400px">
	 		<input type="button" class="btn_vh" value="Imprimir" onclick="printDiv('id_cjimpresion');" />
	 		<input type="button" class="btn_vh" value="Renviar al SRI" style="display:none;" onclick="envioxml('<?php echo $numfa; ?>',<?php echo $idcomp; ?>,'<?php echo $tipo_comprobante; ?>');">
	 		<input type="button" class="btn_vh" value="Nueva Factura" onclick="nuevafactura();">
	 		<?php 
			if ($tipo_comprobante=='V') {
			?>
			<input type="button" class="btn_vh" value="Generar XML y reenviar SRI" onclick="generarxml('<?php echo $numfa; ?>',<?php echo $idcomp; ?>,'<?php echo $tipo_comprobante; ?>');">
			<?php
			}else if ($tipo_comprobante=='N'){
			?>
			<input type="button" class="btn_vh" value="Generar XML y reenviar SRI" onclick="generarxml_nc('<?php echo $numfa; ?>',<?php echo $idcomp; ?>,'<?php echo $tipo_comprobante; ?>');">
			<?php
			}else if ($tipo_comprobante=='G'){
			?>
			<input type="button" class="btn_vh" value="Generar XML y reenviar SRI" onclick="generarxml_guia('<?php echo $numfa; ?>',<?php echo $idcomp; ?>,'<?php echo $tipo_comprobante; ?>');">
			<?php
			}
			?>
	 	</div>
	 	<script type="text/javascript">
	 	function envioxml(numfact, idcomprobante,tipo_compro){
	 		if (tipo_compro=='V') {
	 			window.open("lib/xmlenviados/01_FACTURAS/srienvioxml.php?nunf="+numfact+"&idcomprobante="+idcomprobante+"&direc=01_FACTURAS/FIRMADOS");
	 		} else{
	 			window.open("lib/xmlenviados/02_NOTAS_CREDITO_VENTAS/srienvioxml.php?nunf="+numfact+"&idcomprobante="+idcomprobante+"&direc=02_NOTAS_CREDITO_VENTAS/FIRMADOS");
	 		};
	 		
	 		//window.open("xmlenviados/srienvioxml.php?nunf='.$num_retencion.'&idcomprobante='.$idt_coprobante.'&direc=RETENCIONES","_blank");
	 	}
	 	function generarxml (numfact, idcomprobante,tipo_compro) {
	 		window.open("lib/new_xml_facturaventa.php?numfa="+numfact+"&idcomprobante="+idcomprobante+"&tipocomp="+tipo_compro);
	 	}
	 	function generarxml_nc (numfact, idcomprobante,tipo_compro) {
	 		window.open("lib/new_xml_nc.php?num_comp_nc="+numfact+"&idt_comp_nc="+idcomprobante+"&tipocomp="+tipo_compro);
	 	}
	 	function generarxml_guia (numfact, idcomprobante,tipo_compro) {
	 		window.open("lib/new_xml_guia.php?num_comp_guias="+numfact+"&idt_comp_guias="+idcomprobante);
	 		//alert(idcomprobante);
	 	}
		function nuevafactura(){
			window.location='inicio.php?id=frm_facturacion.php';
		}
		function goBack() {
		    window.history.back();
		}

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
	 </body>
	 </html>
<?php 
}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
}
 ?>