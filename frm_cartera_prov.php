<?php 
include("lib/phpconex.php");
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
	$enlace = conectarbd();

	/*$cad = "SELECT * FROM t_comprobante, t_client_provee where IDT_CLIENT_PROVEE = COM_FKID_CLI_PROV 
	and (COM_TIPO_COMPR='C' OR COM_TIPO_COMPR='D'  OR COM_TIPO_COMPR='E' OR COM_TIPO_COMPR='F'  OR COM_TIPO_COMPR='J' OR COM_TIPO_COMPR='I' )
	AND COM_ESTADO_SIS = 1 
	AND COM_ESTADO_PAGO=1 and (CP_TIPO_CLI_PROV=3 OR CP_TIPO_CLI_PROV =2) 
	AND COM_EPRESA=".$_SESSION['empresa']." ORDER BY CP_APELLIDO asc , CP_NOMBRE asc, COM_NUM_COMPROB asc";*/

	$cad = "SELECT * FROM t_comprobante, t_client_provee,t_asiento where IDT_CLIENT_PROVEE = COM_FKID_CLI_PROV and ASI_FK_IDCOMPROB= IDT_COMPROBANTE
	AND COM_ESTADO_SIS = 1 	AND COM_ESTADO_PAGO=1 and ASI_CUENTA = '2.1.1.01.01'
	ORDER BY CP_APELLIDO asc , CP_NOMBRE asc, COM_NUM_COMPROB asc";
	//echo $cad;	
	$ejec_cad_carte = mysql_query($cad);
	mysql_close($enlace);
	/*IDT_COMPROBANTE, COM_TIPO_COMPR, COM_SUBTIPO_COMP, COM_SECUEN_TIPO, COM_NUM_COMPROB, COM_VAL_SUBT, COM_VAL_BASE0, COM_VAL_BASE12, COM_IVA, COM_TOT, COM_TOT_SIN_RET, COM_TOT_PAGO_COBR, COM_PARTEREL, COM_SUSTENTO_TRIB, COM_FKID_FORMAPAGO, COM_ABONO, COM_SALDO, COM_DOCAFECTADO, COM_FKID_DOCAFECT, COM_CLAVEACESO_SRI, COM_AUTORIZACION_SRI, COM_ESTADO_SIS, COM_ESTADO_CONTAB, COM_ESTADO_ATS_SRI, COM_ESTADO_PAGO, COM_ESTADO_SRI, COM_ESTADO_NULL, COM_MSN_SRI, COM_AMBIENTE, COM_OBSERV_TIPOTRANSAC, COM_OBSERV_GENRL, COM_FKID_CLI_PROV_ced, COM_FKID_USER_CREA, COM_FKID_USER_EDIT, COM_FKID_USER_ANULA, COM_FEC_CREA, COM_FEC_EDIT, COM_FEC_ANULA, COM_FEC_ENVIO, COM_FEC_LLEGADA, COM_FEC_CORTE, COM_FEC_PAGO, COM_PLAZO, COM_EPRESA, COM_OFCINA, IDT_COMPROBANTE, id*/

	?>
	<div  style="width:1000px;text-align:center;margin:0 auto;">
		<h4>CARTERA PROVEEDORES</h4>
	</div>
	<div style="width:1000px;min-height:auto;max-height:500px;overflow:auto;margin:0 auto">
		
		<table class="cl_tabresultados" style="width:100%;">
			<tr>
				<td>#</td>
				<td>CLIENTE</td>
				<td>TIPO</td>
				<td>NUMERO FACT</td>
				<td>FECHA</td>
				<td>DEBE</td>
				<td>HABER</td>
				<td>SALDO</td>
			</tr>
			<?php 
			$i =1;
				while ($res_reporte = mysql_fetch_array($ejec_cad_carte)) {
					?>
					<tr>
						<td><?php echo $i ?></td>
						<td style="width:250px;"><?php echo utf8_encode($res_reporte['CP_NOMBRE'].' '.$res_reporte['CP_APELLIDO']); ?></td>
						<td><?php echo $res_reporte['COM_TIPO_COMPR']; ?></td>
						<td><?php echo $res_reporte['COM_NUM_COMPROB']; ?></td>
						<td><?php echo $res_reporte['COM_FEC_CREA']; ?></td>
						<td style="width:80px;" align="right"><?php echo $res_reporte['ASI_DEBE']; ?></td>
						<td style="width:80px;" align="right"><?php echo $res_reporte['ASI_HABER']; ?></td>
						<td style="width:80px;" align="right"><?php echo $res_reporte['COM_SALDO']; ?></td>						
					</tr>
					<?php 	
					$i++;				
				}
			 ?>
			 <tr>
			 	<td>
			 		<?php 
			 		echo '<tr>
						<td colspan="13" align="right">
							<a href="rpt_cartera_prov.php?cadena='.$cad.'" targert="blank">Exportar</a>
						</td>			
					</tr>';
			 		 ?>
			 	</td>
			 </tr>
		</table>
	</div>
	
	<?php
}else{
echo "<script>
	alert('USTED NO HA INICIADO SESION');
	window.location='index.php';
</script>";
}
 ?>