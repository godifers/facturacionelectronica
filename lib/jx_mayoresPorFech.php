<?php 
session_start();
if (isset($_SESSION['empresa']) ) {
  require_once('phpconexcion.php');
	$fech1 = $_POST['fech1'];
	$fech2 = $_POST['fech2'];
	$enlace = conectar_buscadores();
		$cad_mayor = "SELECT CP_APELLIDO, CP_NOMBRE, COM_TIPO_COMPR, COM_NUM_COMPROB,COM_FEC_CREA, PCU_DESCRIPCION , ASI_DEBE, ASI_HABER, 
		COM_ESTADO_PAGO, IDT_COMPROBANTE
		from t_client_provee, t_comprobante, t_asiento, t_plancuentas where COM_ESTADO_SIS= 1 and ASI_FK_IDCOMPROB = IDT_COMPROBANTE 
		and COM_FKID_CLI_PROV = IDT_CLIENT_PROVEE and ASI_CUENTA = PCU_CUENTA 	and (COM_FEC_CREA between '".$fech1 ."' and '".$fech2."')
		AND (ASI_CUENTA='1.1.2.01.01' OR ASI_CUENTA='2.3.1.01'  OR ASI_CUENTA='1.1.2.05.01') order by COM_FEC_CREA asc";
		//echo $cad_mayor;
		$saldo = 0.00;
		$ejec_cad_mayor = mysql_query($cad_mayor);
		echo "<table style='width:100%;margin:0;' class='cl_tabresultados'>
		<td><p style='font-size:15px;margin:0;padding:0;'><strong>Cliente o Proveedor</strong></p></td>
		<td><p style='font-size:15px;margin:0;padding:0;'><strong>Tipo.</strong></p></td>
		<td><p style='font-size:15px;margin:0;padding:0;'><strong>Número de comprob.</strong></p></td>
		<td><p style='font-size:15px;margin:0;padding:0;'><strong>Fecha Crea</strong></p></td>
		<td><p style='font-size:15px;margin:0;padding:0;'><strong>Estado Pag.</strong></p></td>
		<td><p style='font-size:15px;margin:0;padding:0;'><strong>Cuenta</strong></p></td>
		<td align='right'><p style='font-size:15px;margin:0;padding:0;'><strong>Debe</strong></p></td>
		<td align='right'><p style='font-size:15px;margin:0;padding:0;'><strong>Haber</strong></p></td>
		<td align='right'><p style='font-size:15px;margin:0;padding:0;'><strong>Saldo</strong></p></td>";	
		while ($resMay =mysql_fetch_array($ejec_cad_mayor)) {
			$saldo = $saldo + $resMay['ASI_DEBE'] - $resMay['ASI_HABER'];
			if ($resMay['COM_ESTADO_PAGO'] == 1) {
				$etiqPag = "<p style='font-size:15px;margin:0;padding:0;text-align:center;border-radius:4px;background:#DEA857;'>Pendi.</p>";
			} else {
				$etiqPag = "<p style='font-size:15px;margin:0;padding:0;text-align:center;border-radius:4px;background:green;'>Paga.</p>";
			}
			
			?>
			<tr>
				<td><p style='font-size:15px;margin:0;padding:0;'><?php echo utf8_encode($resMay['CP_APELLIDO'].' '.$resMay['CP_NOMBRE']); ?></p></td>
				<td><p style='font-size:15px;margin:0;padding:0;'><?php echo $resMay['COM_TIPO_COMPR']; ?></p></td>
				<td><p style='font-size:15px;margin:0;padding:0;'><?php echo $resMay['COM_NUM_COMPROB']; ?></p></td>
				<td><p style='font-size:15px;margin:0;padding:0;'><?php echo $resMay['COM_FEC_CREA']; ?></p></td>
				<td><?php echo $etiqPag; ?></td>
				<td><p style='font-size:15px;margin:0;padding:0;'><?php echo $resMay['PCU_DESCRIPCION']; ?></p></td>
				<td align="right"><p style='font-size:15px;margin:0;padding:0;'><?php echo $resMay['ASI_DEBE']; ?></p></td>
				<td align="right"><p style='font-size:15px;margin:0;padding:0;'><?php echo $resMay['ASI_HABER']; ?></p></td>
				<td align="right"><p style='font-size:15px;margin:0;padding:0;'><?php echo $saldo; ?></p></td>
			</tr>
			<?php
			if ($resMay['COM_TIPO_COMPR']=='V') {/// en caso de que el comprobante sea V
				$docsRel_V ="SELECT * FROM t_pagos_factu_comp where  PAG_NUM_FAC_AFECTADO='".$resMay['COM_NUM_COMPROB']."' 
				and PAG_FK_ID_COMPRO_AFECTADO = ".$resMay['IDT_COMPROBANTE'];
				$ejeCadDocRel_V = mysql_query($docsRel_V);
				$tot_A = 0.00;
				if (mysql_num_rows($ejeCadDocRel_V) > 0) {// ------solo escribe en pantalla en caso de que se existe un pago relacionado--------
					while ($reDoRel = mysql_fetch_array($ejeCadDocRel_V)) {//**************************************
						$tot_A  = $tot_A + $reDoRel['PAG_VALOR'];
						?>
						<tr>
							<td colspan="9" align="left">
								<p style='font-size:11px;margin:0;padding:0 2px 0 2px;background:#A1C8DC;border-radius:4px;width:250px;'>
								<?php echo $reDoRel['PAG_TIPO_COMP_PAGO'].'->'.$reDoRel['PAG_NUM_COMPR_PAGO'].' de '.$reDoRel['PAG_VALOR'].' = '.$tot_A; ?>
								</p>
							</td>
						</tr>
						<?php
					}//**************************************
				}else{
					if ($resMay['COM_TIPO_COMPR'] == 'V' AND $etiqPag =='Paga.') {
						?>
						<tr>
							<td colspan="9" align="left">
								<p style='font-size:11px;margin:0;padding:0 2px 0 2px;background:red;border-radius:4px;width:250px;'>
									SIN PAGO
								</p>
							</td>
						</tr>
						<?php
						/*if ($tot_A != ($resMay['ASI_DEBE'] +  $resMay['ASI_HABER'])) {
						?>
						<tr>
							<td colspan="9" align="left">
								<p style='font-size:11px;margin:0;padding:0 2px 0 2px;background:red;border-radius:4px;width:250px;'>
									diferenete
								</p>
							</td>
						</tr>
						<?php
						}*/
					}
				} // --------------------------------------
			} else {// en caso que deje des ser V y pase a ser otro  A o N
				$docsRel_A ="SELECT * FROM t_pagos_factu_comp where PAG_NUM_COMPR_PAGO='".$resMay['COM_NUM_COMPROB']."' 
				and PAG_FK_ID_COM_PAGO= ".$resMay['IDT_COMPROBANTE'];
				$ejeCadDocRel_A = mysql_query($docsRel_A);
				$tot_B = 0.00;
				if (mysql_num_rows($ejeCadDocRel_A) > 0) {// ------solo escribe en pantalla en caso de que se existe un pago relacionado--------
					while ($reDoRel = mysql_fetch_array($ejeCadDocRel_A)) {//**************************************
						$tot_B  = $tot_B + $reDoRel['PAG_VALOR'];
						?>
						<tr>
							<td colspan="9" align="left">
								<p style='font-size:11px;margin:0;padding:0 2px 0 2px;background:#E2BFA8;border-radius:4px;width:250px;'>
								<?php echo $reDoRel['PAG_TIPO_FACT_COMP'].'->'.$reDoRel['PAG_NUM_FAC_AFECTADO'].' de '.$reDoRel['PAG_VALOR']. ' = ' .$tot_B; ?>
								</p>
							</td>
						</tr>
						<?php
					}//**************************************
				} // --------------------------------------
			}
			
		}
		echo "</table>";

	
}else{
echo "<script>
      alert('USTED NO HA INICIADO SESION');
      window.location='index.php';
    </script>";
}
?>