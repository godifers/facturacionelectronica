<?php 
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	include("lib/phpconex.php");
	?>
	<div class="cl_div_home" id="id_div_home" style="width:820px;margin: 0 auto;height:350px; background:none;">
		<h4 style="align:center;width:100%;">MENU DE INICIO</h4><hr>
		<input type="button" onclick="ir_botonera('inicio.php?id=frm_facturacion.php');" value="FACTURACIÓN." style="display:inline-block;width:200px;height:100px;">
		<input type="button" onclick="ir_botonera('inicio.php?id=frm_egresos.php');" value="EGRESOS." style="display:inline-block;width:200px;height:100px;">
		<input type="button" onclick="ir_botonera('inicio.php?id=frm_cobros.php');" value="COBROS." style="display:inline-block;width:200px;height:100px;">
		<input type="button" onclick="ir_botonera('inicio.php?id=frm_historial.php');" value="HIS. INVENTARIO." style="display:inline-block;width:200px;height:100px;">
		<input type="button" onclick="ir_botonera('inicio.php?id=frm_productos.php');" value="ADMIN. PROD" style="display:inline-block;width:200px;height:100px;">
		<input type="button" onclick="ir_botonera('inicio.php?id=frm_reimpresiones.php');" value="REIMPRESIONES." style="display:inline-block;width:200px;height:100px;">
		<input type="button" onclick="ir_botonera('inicio.php?id=frm_cierrecaja.php');" value="CIERRE DE CAJA." style="display:inline-block;width:200px;height:100px;">
		<input type="button" onclick="ir_botonera('inicio.php?id=frm_compras.php');" value="COMPRAS" style="display:inline-block;width:200px;height:100px;">
		<input type="button" onclick="ir_botonera('inicio.php?id=');" value="DOCS. NO AUTO." style="display:inline-block;width:200px;height:100px;">
		<input type="button" onclick="ir_botonera('inicio.php?id=frm_clientes.php');" value="NUEVO. CLIENTE." style="display:inline-block;width:200px;height:100px;">
		<input type="button" onclick="ir_botonera('inicio.php?id=frm_notascont.php');" value="NOTAS CONTABLES." style="display:inline-block;width:200px;height:100px;">
		<input type="button" onclick="ir_botonera('inicio.php?id=frm_regempresa.php');" value="FECHA DE TRABAJO." style="display:inline-block;width:200px;height:100px;">		
	</div>
	<div class="cl_div_pendientes" id="id:div_pendientes" style="width:820px;margin: 0 auto;max-height:300px; background:none;overflow:auto;">
		<hr>
		<?php 
			$enlace = conectarbd();
			$cad_pendientes= "SELECT IDT_COMPROBANTE,COM_NUM_COMPROB, COM_TIPO_COMPR, COM_FEC_CREA,COM_FEC_ENVIO,USU_LOGER from  t_comprobante,t_usuario
 					where COM_ESTADO_SIS=3 and COM_FKID_USER_CREA= IDT_USUARIO AND COM_TIPO_COMPR='H' AND COM_EPRESA=".$_SESSION['empresa'];
			$ejec_cad_pendientes = mysql_query($cad_pendientes);
			mysql_close($enlace);
			if (mysql_num_rows($ejec_cad_pendientes)==0) {
				echo "<h4>HOY NO TIENE PENDIENTES</h4>";
			} else {
				?>
				<div class="cl_div_res_pendientes" id="id_div_res_pendientes" style="width:100%;min-height:auto;max-heinght:350px;overflow:auto;">
				<table class='cl_tabresultados' style="width:100%;">	
					<tr>
						<td colspan="6">
							<h4 style="align:center;width:100%;background:red;" >PENDIENTES</h4>
						</td>
					</tr>
					<tr>
						<td>NUM DE GUIA.</td>
						<td>TIPO DE COMPROB.</td>
						<td>FECHA</td>
						<td>FECHA ENV.</td>
						<td>ENVIADO POR.</td>
						<td></td>
					</tr>				
					<?php 
					while ($res_pendientes = mysql_fetch_array($ejec_cad_pendientes)) {
						?>
						<tr>
							<td><a href="lib/imp_guia.php?idt_comp=<?php echo $res_pendientes['IDT_COMPROBANTE']; ?>&nun_comp=<?php echo $res_pendientes['COM_NUM_COMPROB']; ?>"
							 target="_blank"><?php echo $res_pendientes['COM_NUM_COMPROB']; ?></a></td>
							<td><?php echo $res_pendientes['COM_TIPO_COMPR']; ?></td>
							<td><?php echo $res_pendientes['COM_FEC_CREA']; ?></td>
							<td><?php echo $res_pendientes['COM_FEC_ENVIO']; ?></td>
							<td><?php echo $res_pendientes['USU_LOGER']; ?></td>
							<td><input type="button" value="Aceptar guia." onclick="actualizar_guia_rem('<?php echo $res_pendientes['IDT_COMPROBANTE']; ?>');"></p></td>
						</tr>
						<?php 
					}
					 ?>	
					 <tr>
					 	<td colspan="6">
					 		<div class="cl_res_upadte_guia" id="id_res_update_guia">
					 			
					 		</div>
					 	</td>
					 </tr>				
				</table>
				</div>
				<?php
			}
			
		 ?>
	</div>
	<?php 
}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}
 ?>