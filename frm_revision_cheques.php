<?php 
if ($_SESSION['cargo']==1) {
	include("lib/phpconexcion.php");
	$enlace = conectar_buscadores();
	$cad_bancos = "SELECT * FROM t_bancos;";
	$eje_cad_bancos = mysql_query($cad_bancos);
	echo "<h4>RESULTADO DE CHEQUES EMITIDOS</h4><hr>	";
	while ($resbancos = mysql_fetch_array($eje_cad_bancos)) {
		?>
		<p><?php echo $resbancos['BAN_BANCCO']; ?></p>
		<div style="width:1024px;min-height:auto;max-height:300px;overflow:auto; margin:0 auto;">			
			<?php 
			$cad_cheqs_emit  = "SELECT CHE_NUM_CHUQUE, CHE_FECHA_COBRO, CHE_EMITIDO_A, COM_NUM_COMPROB, COM_TIPO_COMPR, COM_FEC_CREA, COM_ESTADO_SIS , 					CHE_FK_ID_COMPROBANTE FROM t_chques_emitidos, t_comprobante where CHE_FK_ID_COMPROBANTE= IDT_COMPROBANTE and 
							CHE_FK_ID_BANCO =".$resbancos['IDT_BANCO']."  order by IDT_CHQUES_EMITIDOS desc";
			$ejec_cheqs_amit = mysql_query($cad_cheqs_emit);
			 ?>
			<table class="cl_tabresultados" width="100%">
				<?php 
				while ($res_cheq_em = mysql_fetch_array($ejec_cheqs_amit)) {
					if ($res_cheq_em['COM_ESTADO_SIS']==1) {
						$etiq_estado  = "<p style='background:green;margin:0px;text:align:center;'>Activo</p>";
					} else {
						$etiq_estado  = "<p style='background:red;margin:0px;text:align:center;'>Anulado</p>";
					}
					
					?>
					<tr>
						<td style="width:5%;"><?php echo $res_cheq_em['CHE_NUM_CHUQUE']; ?></td>
						<td style="width:15%"><?php echo $res_cheq_em['CHE_FECHA_COBRO']; ?></td>
						<td style="width:15%"><?php echo $res_cheq_em['COM_FEC_CREA']; ?></td>
						<td style="width:50%"><?php echo $res_cheq_em['CHE_EMITIDO_A']; ?></td>
						<td style="width:50%"><?php echo $res_cheq_em['COM_TIPO_COMPR']; ?></td>
						<td><a href="inicio.php?id=frm_administrar_comprobante.php&idcomprobante=<?php echo $res_cheq_em['CHE_FK_ID_COMPROBANTE']; ?>&num_comprob_Fac=<?php echo $res_cheq_em['COM_NUM_COMPROB']; ?>" 
						target="_blank"><?php echo $res_cheq_em['COM_NUM_COMPROB']; ?></a></td>
						<td><?php echo $etiq_estado; ?></td>
					</tr>
					<?php 
				}
				 ?>
				 <tr>
				 	<td colspan="6"><hr></td>
				 	<td>FIN</td>
				 </tr>
			</table>
			
		</div>
		<?php 
	}
}else{
	?>
	<div class="" style="width:550px;height:550px;margin: 0 auto ;background:none;text-align:center;">
		<p>USTED NO PUEDE INGRESAR A ESTE MODULO ..(NO ESTA ASIGANDO CON PRIVILEGIOS)</p>
		<img src="img/error.png" alt="" style="width:520x;">
	</div>
	<?php
}	
?>