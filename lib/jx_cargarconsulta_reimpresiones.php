<?php 
session_start();
include("phpconex.php");
$enlace = conectarbd();
$cadena = $_POST['canema_reimp'];
if (isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	$cadena = $cadena. ' and IDT_FORMAS_PAG0 = COM_FKID_FORMAPAGO and COM_EPRESA = '.$_SESSION['empresa'].' ORDER BY COM_FEC_CREA ASC';
	//echo $cadena;
	$ejeccadena_reimpresiones=mysql_query($cadena);
	mysql_close($enlace);
	if (mysql_num_rows($ejeccadena_reimpresiones)==0) {
		echo "<h4 style='background:red;'>No se han encontrado resultados..!!</h4>";
	} else {

		echo "<table style='width:100%;' class='cl_tabresultados'>
		<tr>	
			<td><strong>NUM FACTURA</strong></td>
			<td><strong>TIPO</strong></td>
			<td><strong>NOMBRE / RAZON SOC.</strong></td>
			<td><strong>RUC / C.I.</strong></td>
			<td><strong>GEN. POR.</strong></td>
			<td><strong>FECHA.</strong></td>
			<td><strong>FORMA PAGO</strong></td>
			<td><strong>ESTADO PAGO</strong></td>
			<td align='right'><strong>VALOR.</strong></td>
			<td></td>
		</tr>";
		while ($res_consuta_resimpresione =mysql_fetch_array($ejeccadena_reimpresiones)) {
			//echo $res_consuta_resimpresione['TP_DESCRIPCION'];
			if ($res_consuta_resimpresione['TP_DESCRIPCION']=='EFECTIVO') {
				$etid_pago = "<p style='padding:1px;border-radius:4px;margin:0;width:100px;text-align:center;background:#568A55;'>".$res_consuta_resimpresione['TP_DESCRIPCION']."</p>";
			} else if ($res_consuta_resimpresione['TP_DESCRIPCION']=='CREDITO'){
				$etid_pago = "<p style='padding:1px;border-radius:4px;margin:0;width:100px;text-align:center;background:#D88853;'>".$res_consuta_resimpresione['TP_DESCRIPCION']."</p>";
			}else if ($res_consuta_resimpresione['TP_DESCRIPCION']=='NINGUNA') {
				$etid_pago = "<p style='padding:1px;border-radius:4px;margin:0;width:100px;text-align:center;background:yellow;'>".$res_consuta_resimpresione['TP_DESCRIPCION']."</p>";
			}else{
				$etid_pago = "<p style='padding:1px;border-radius:4px;margin:0;width:100px;text-align:center;background:yellow;'>".$res_consuta_resimpresione['TP_DESCRIPCION']."</p>";
			}			
			
			if ($res_consuta_resimpresione['COM_ESTADO_PAGO']==0) {
				$etiq_pag2 ="<p style='padding:1px;border-radius:4px;margin:0;width:100px;text-align:center;background:#568A55;'>PAGADO</p>";
			} else if ($res_consuta_resimpresione['COM_ESTADO_PAGO']==1) {
				$etiq_pag2 ="<p style='padding:1px;border-radius:4px;margin:0;width:100px;text-align:center;background:#D88853;'>PENDIENTE</p>";
			}
			
			?>
				<tr>
					<td>
						<a href="inicio.php?id=frm_administrar_comprobante.php&
						idcomprobante=<?php echo $res_consuta_resimpresione['IDT_COMPROBANTE']; ?>&
						num_comprob_Fac=<?php echo $res_consuta_resimpresione['COM_NUM_COMPROB']; ?>">
						<?php echo $res_consuta_resimpresione['COM_NUM_COMPROB']; ?></a>
					</td>
					<td><?php echo $res_consuta_resimpresione['COM_TIPO_COMPR']; ?></td>
					<td><?php echo utf8_encode($res_consuta_resimpresione['CP_NOMBRE'].' '.$res_consuta_resimpresione['CP_APELLIDO']); ?></td>
					<td><?php echo $res_consuta_resimpresione['CP_CEDULA']; ?></td>
					<td><?php echo $res_consuta_resimpresione['USU_LOGER']; ?></td>
					<td><?php echo $res_consuta_resimpresione['COM_FEC_CREA']; ?></td>
					<td><?php echo $etid_pago; ?></td>
					<td><?php echo $etiq_pag2; ?></td>
					<td align="right"><?php echo $res_consuta_resimpresione['COM_TOT']; ?></td>
					<td align="right">
						<?php 
							if ($res_consuta_resimpresione['COM_ESTADO_SIS']==0) {
								?>
								<p style="background:red;border-radius:4px; width:70px; padding:2px; text-align:center;margin:0;">Anulado</p>
								<?php 
							} else if ($res_consuta_resimpresione['COM_ESTADO_SIS']==1 AND $_SESSION['cargo'] ==1  ){
								?>
								<input type="button" value="Eliminar" onclick="eliminar_comp('<?php echo $res_consuta_resimpresione['IDT_COMPROBANTE'] ?>');">
								<?php 
							}
						 ?>						
					</td>
				</tr>
			<?php
		}
		?>
		<tr>
			<td colspan='11' align='right'>
				<a href="rtpReimpresiones.php?cad=<?php echo $cadena; ?>" target='_blanck'>Reporte Excel</a>
			</td>
		</tr>
		<?php
		echo "
		<tr>
		<td colspan='11'>
		<div class='cl_div_res_aunlacio' id='id_dov_res_anulacio'>
		</div>
		</td></tr>
		</table>";
	}
}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
}
 ?>