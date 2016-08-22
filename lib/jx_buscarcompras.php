<?php 
session_start();
require_once('phpconex.php');
$id_cliprov = $_POST['id_cliprov'];
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {

	$enlace = conectarbd();
	$id_cliprov = $_POST['id_cliprov'];
	$cad_compras ="SELECT * FROM t_comprobante where COM_TIPO_COMPR='C' AND COM_FKID_CLI_PROV =".$id_cliprov;
	$ejeccadcomp = mysql_query($cad_compras);
	mysql_close($enlace);
	if (mysql_num_rows($ejeccadcomp )==0) {
		echo "<h4 style='background:red;'>NO SE HA ENCONTRADO RESULTADOS</h4>";
	} else {
		echo '<table class="cl_tabresultados" style="width:100%; border:solid 1px #000;" ><tr><td><h4>Resultado encontados</h4><br></td></tr>';
		echo "<tr>
				<td>Numero de Factura</td>
				<td>Fecha.</td>
				<td>Subtot.</td>
				<td>Base 0%</td>
				<td>Base 12%</td>
				<td>I.V.A</td>
				<td>Tot.</td>
				<td>Tot sin Reten.</td>
				<td>Forma Pago</td>
				<td>Estado de pago</td>
				<td></td>
				</tr>";
		while ($rescompras = mysql_fetch_array($ejeccadcomp)) {
			/* IDT_COMPROBANTE, COM_TIPO_COMPR, COM_SUBTIPO_COMP, COM_SECUEN_TIPO, COM_NUM_COMPROB, COM_VAL_SUBT, COM_VAL_BASE0, 
			COM_VAL_BASE12, COM_IVA, COM_TOT, COM_TOT_SIN_RET, COM_TOT_PAGO_COBR, COM_PARTEREL, COM_SUSTENTO_TRIB, COM_FKID_FORMAPAGO,
			COM_ABONO, COM_SALDO, COM_DOCAFECTADO, COM_FKID_DOCAFECT, COM_CLAVEACESO_SRI, COM_AUTORIZACION_SRI, COM_ESTADO_SIS,
			COM_ESTADO_CONTAB, COM_ESTADO_ATS_SRI, COM_ESTADO_PAGO, COM_ESTADO_SRI, COM_ESTADO_NULL, COM_MSN_SRI, COM_AMBIENTE, 
			COM_OBSERV_TIPOTRANSAC, COM_OBSERV_GENRL, COM_FKID_CLI_PROV, COM_FKID_USER_CREA, COM_FKID_USER_EDIT, COM_FKID_USER_ANULA,
			COM_FEC_CREA, COM_FEC_EDIT, COM_FEC_ANULA, COM_FEC_ENVIO, COM_FEC_LLEGADA, COM_FEC_CORTE, COM_FEC_PAGO, COM_PLAZO, 
			COM_EPRESA, COM_OFCINA*/
			if ($rescompras['COM_FKID_FORMAPAGO']==1) {
				$tippago = '<p style="background:#257CBE;">Efecetivo</p>';
			} else {
				$tippago = '<p style="background:#257CBE;">Efecetivo</p>';
			}

			if ($rescompras['COM_ESTADO_SIS']==1) {
				$estadopag = '<p style="background:red;">POR PAGAR</p>';
			} else if($rescompras['COM_ESTADO_SIS']==2) {
				$estadopag = '<p style="background:gren;">PAGADO</p>';
			}
			
			?>
			<tr>
				<td>
					<a href="#"><?php echo $rescompras['COM_NUM_COMPROB']; ?></a>
				</td>
				<td>
					<p class="cl_ptab"><?php echo $rescompras['COM_FEC_CREA']; ?></p>
				</td>			
				<td>
					<p class="cl_ptab"><?php echo $rescompras['COM_VAL_SUBT']; ?></p>
				</td>
				<td>
					<p class="cl_ptab"><?php echo $rescompras['COM_VAL_BASE0']; ?></p>
				</td>
				<td>
					<p class="cl_ptab"><?php echo $rescompras['COM_VAL_BASE12']; ?></p>
				</td>			
				<td>
					<p class="cl_ptab"><?php echo $rescompras['COM_IVA']; ?></p>
				</td>
				<td>
					<p class="cl_ptab"><?php echo $rescompras['COM_TOT']; ?></p>
				</td>
				<td>
					<p class="cl_ptab"><?php echo $rescompras['COM_TOT_SIN_RET']; ?></p>
				</td>			
				<td>
					<p class="cl_ptab"><?php echo $tippago; ?></p>
				</td>
				<td>
					<p class="cl_ptab"><?php echo $estadopag; ?></p>
				</td>
				<td>
					<a href="inicio.php?id=frm_vercompra.php&idcomp=<?php echo $rescompras['IDT_COMPROBANTE']; ?>">ver</a>
				</td>		
			</tr>
			<?php
		}
		echo "</table>";
	}

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
}





 ?>