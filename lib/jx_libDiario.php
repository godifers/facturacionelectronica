<?php 
include("phpconexcion.php");
$enlace = conectar_buscadores();
$fecha = $_POST['fecha'];
$fecha2 = $_POST['fecha2'];
$cadComp= "SELECT * FROM t_comprobante WHERE (COM_TIPO_COMPR<>'H' and  COM_TIPO_COMPR<>'R' and  COM_TIPO_COMPR<>'G') and COM_ESTADO_SIS= 1 and   COM_FEC_CREA BETWEEN '".$fecha."' and '".$fecha2."'";
$ejeCad = mysql_query($cadComp);
//echo $cadComp;
/*IDT_COMPROBANTE, COM_TIPO_COMPR, COM_SUBTIPO_COMP, COM_SECUEN_TIPO, COM_NUM_COMPROB, COM_VAL_SUBT, COM_VAL_BASE0, COM_VAL_BASE12, COM_IVA, COM_TOT, COM_TOT_SIN_RET, COM_TOT_PAGO_COBR, COM_PARTEREL, COM_SUSTENTO_TRIB, COM_FKID_FORMAPAGO, COM_ABONO, COM_SALDO, COM_DOCAFECTADO, COM_FKID_DOCAFECT, COM_CLAVEACESO_SRI, COM_AUTORIZACION_SRI, COM_ESTADO_SIS, COM_ESTADO_CONTAB, COM_ESTADO_ATS_SRI, COM_ESTADO_PAGO, COM_ESTADO_SRI, COM_ESTADO_NULL, COM_MSN_SRI, COM_AMBIENTE, COM_OBSERV_TIPOTRANSAC, COM_OBSERV_GENRL, COM_FKID_CLI_PROV, COM_FKID_USER_CREA, COM_FKID_USER_EDIT, COM_FKID_USER_ANULA, COM_FEC_CREA, COM_FEC_EDIT, COM_FEC_ANULA, COM_FEC_ENVIO, COM_FEC_LLEGADA, COM_FEC_CORTE, COM_FEC_PAGO, COM_PLAZO, COM_EPRESA, COM_OFCINA, IDT_COMPROBANTE, id*/
$sumtotales = 0.00;
$totdebe = 0.00;
$tothabe = 0.00;
$v1 = 0;

if (mysql_num_rows($ejeCad)==0) {
	echo "NO SE HAN ECNONTRADO RESULTADOS";
} else {
	echo "<table style='width:100%' class='cl_tabresultados'>";
	while ($res= mysql_fetch_array($ejeCad)) {//---------------------------------------------------------------------
		$sumtotales = $sumtotales + $res['COM_TOT'];
		$v1 = $res['COM_TOT'];
		?>
		<tr>
			<td align="center"><?php echo $res['COM_TIPO_COMPR']; ?></td>
			<td><?php echo $res['COM_NUM_COMPROB']; ?></td>
			<td align="right"><?php echo $res['COM_TOT']; ?></td>
			<td></td>
			<td></td>
		</tr>
		<?php 
			$cadAsie = "SELECT * from t_asiento, t_plancuentas where PCU_CUENTA = ASI_CUENTA  and ASI_FK_IDCOMPROB = ".$res['IDT_COMPROBANTE'];
			//echo $cadAsie;
			$ejecCadAsiento = mysql_query($cadAsie); 
			set_time_limit(0);
			if (mysql_num_rows($ejecCadAsiento)==0) {
				?>
				<tr>
					<td colspan="5" align="left">
						NO HAY ASIENTO	
					</td>
				</tr>
				<?php
			} else {
				$v2 = 0;
				$v3 = 0;
				while ($resA = mysql_fetch_array($ejecCadAsiento)) {
					$totdebe = $totdebe + $resA['ASI_DEBE'];
					$tothabe = $tothabe + $resA['ASI_HABER'];
					$v2 = $v2 + $resA['ASI_DEBE'];
					$v3 = $v3 + $resA['ASI_HABER'];
					?>
					<tr>
						<td colspan="2" align="right">
							<?php echo $resA['PCU_DESCRIPCION']; ?>
						</td>	
						<td></td>
						<td align="right"><?php echo $resA['ASI_DEBE']; ?></td>
						<td align="right"><?php echo $resA['ASI_HABER']; ?></td>					
					</tr>
					<?php
				}
			}
		?>
		<tr>
			<td colspan="5" align="right">
				<?php 
				$v1= number_format($v1,2);
				$v2= number_format($v2,2);
				$v3= number_format($v3,2);
				$cad =  $v1." - ".$v2." - ".$v3."      ";

				/*$sumtotales = $sumtotales + $v1;
				$totdebe = $totdebe + $v2;
				$tothabe = $tothabe + $v3;*/

				if ($v2 == $v3) {
					if ($v3 == $v1) {
						echo "<p style='text-align:center;width:400px;margin:0;padding:0;background:green;border-radius:4px;font-size:12px;' title='ok'>".$cad." ok</p>";
					} else {
						echo "<p style='text-align:center;width:400px;margin:0;padding:0;background:red;border-radius:4px;font-size:12px;' title='Diferencia de valor y asiento'>".$cad." E2</p>";
					}					
				} else {
					echo "<p style='text-align:center;width:400px;margin:0;padding:0;background:red;border-radius:4px;font-size:12px;' title='Error de asiento'>".$cad." E1</p>";
				}
				
				?>
			</td>
		</tr>	
		<?php
	}//------------------------------------------------------------------------
	?>
	<tr>
		<td colspan="2"><hr></td>
		<td align="right"><?php echo $sumtotales; ?></td>
		<td align="right"><?php echo $totdebe; ?></td>
		<td align="right"><?php echo $tothabe; ?></td>
	</tr>
	<tr>
		<td colspan="5" align="center">
			<?php echo '<a href="rptLibroDiario.php?cadena='.$cadComp.'" targert="blank">Exportar Excel</a>'; ?>
		</td>
	</tr>
	<?php 
	echo "</table>";
}

?>