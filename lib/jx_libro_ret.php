<?php 
session_start();
if ( isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
	
	require_once('phpconexcion.php');
	$identific = $_POST['identific1'];
	$var_fech_ini = $_POST['var_fech_ini1'];
	$var_fech_fin = $_POST['var_fech_fin1'];
	$enlace = conectar_buscadores();

	if ($identific==1) {
		$cad_ret = "SELECT VALR_COD_RET AS codRet,'CUENTA' AS descCuenta,  VALR_BASE_IMP as baseImp, VALR_PORCENT as porcent, VALR_VAL_RET as valRet, 
		VALR_NUM_RET as numReten, VALR_NUMFACT as numFact, CP_NOMBRE as nomProve , CP_APELLIDO as apeProvee, 
		COM_AUTORIZACION_SRI as autoriRet, CP_CEDULA as cedula , COM_FEC_CREA as fechaCrea
		from t_val_retenciones, t_comprobante, t_client_provee 
		where IDT_COMPROBANTE = VALR_IDT_RETENCION and VALR_ESTADO = 1 and COM_ESTADO_SIS =1 
		and VALR_FK_IDCLIPROV = IDT_CLIENT_PROVEE and (VALR_FECHA_ENV BETWEEN '".$var_fech_ini."' and '".$var_fech_fin."') 
		union all 
		SELECT '332' AS codRet, PCU_DESCRIPCION AS descCuenta, COM_VAL_SUBT as baseImp, 0 as porcent, 0 as valRet,
		'SIN/RET' as numReten, COM_NUM_COMPROB as numFact, CP_APELLIDO as nomProve, CP_NOMBRE as apeProvee,'SIN/AUTORIZA' as autoriRet ,
		CP_CEDULA as cedula, COM_FEC_CREA as fechaCrea
		FROM t_client_provee, t_comprobante, t_asiento,t_plancuentas where COM_ESTADO_SIS= 1 and ASI_CUENTA='2.1.3.01.24' and IDT_COMPROBANTE= ASI_FK_IDCOMPROB 
		and COM_FKID_CLI_PROV= IDT_CLIENT_PROVEE and ASI_CUENTA= PCU_CUENTA 
		and PCU_EMPRESA =1 and (COM_FEC_CREA BETWEEN '".$var_fech_ini."' and '".$var_fech_fin."') order by codRet";//COM_FEC_CREA
		 //echo $cad_ret;
		 $ejec_cad_ret = mysql_query($cad_ret);
		 echo "<table><tr>
		 	<td><p style='margin:0;font-size:13px;'><strong>CUENTA.</strong></p></td>		 	
		 	<td align='center'><p style='margin:0;font-size:13px;'><strong>COD RET.</strong></p></td>
		 	<td align='right'><p style='margin:0;font-size:13px;'><strong>BASE IMP.</strong></p></td>
		 	<td align='right'><p style='margin:0;font-size:13px;'><strong>%.</strong></p></td>
		 	<td align='right'><p style='margin:0;font-size:13px;'><strong>VAL. RET.</strong></p></td>
		 	<td align='center'><p style='margin:0;font-size:13px;'><strong>No. RETENCION.</strong></p></td>
		 	<td align='center'><p style='margin:0;font-size:13px;'><strong>No. FACTURA.</strong></p></td>
		 	<td><p style='margin:0;font-size:13px;'><strong>Tercero.</strong></p></td>
		 	<td><p style='margin:0;font-size:13px;'><strong>AUtorizacion.</strong></p></td>
		 </tr>";
		 while ($res_ret = mysql_fetch_array($ejec_cad_ret)) {
		 	?>
		 	<tr>
		 		<td style="width:300px;"><p style="margin:0;font-size:13px;"><?php echo $res_ret['descCuenta']; ?></p></td>
			 	<td style="width:120px;" align="center"><p style="margin:0;font-size:13px;"><?php echo $res_ret['codRet']; ?></p></td>
			 	<td style="width:120px;" align="right"><p style="margin:0;font-size:13px;"><?php echo $res_ret['baseImp']; ?></p></td>
			 	<td style="width:120px;" align="right"><p style="margin:0;font-size:13px;"><?php echo $res_ret['porcent']; ?></p></td>
			 	<td style="width:120px;" align="right"><p style="margin:0;font-size:13px;"><?php echo $res_ret['valRet']; ?></p></td>
			 	<td style="width:200px;" align="center"><p style="margin:0;font-size:13px;"><?php echo $res_ret['numReten']; ?></p></td>
			 	<td style="width:200px;" align="center"><p style="margin:0;font-size:13px;"><?php echo $res_ret['numFact']; ?></p></td>
			 	<td style="width:250px;"><p style="margin:0;font-size:13px;"><?php echo $res_ret['nomProve'].' '.$res_ret['apeProvee']; ?></p></td>
			 	<td style="width:250px;"><p style="margin:0;font-size:13px;"><?php echo $res_ret['autoriRet']; ?></p></td>
			</tr>
		 	<?php 
		 }
		 echo '
		 <tr>
		 	<td colspan="8" align="center">
				<a href="rpt_lib_retenciones.php?f1='.$var_fech_ini.'&f2='.$var_fech_fin.'&indent='.$identific.'" targert="blank" 
				style="text-decoration:none;color:#fff;background:green;paddign:5px;border-radius:3px;padding:5px;">Reporte Excel</a>
		 	</td>
		 </tr>
		 </table>';

	} else {
		$cad_ret = "SELECT VALR_COD_RET AS codRet,'CUENTA' AS descCuenta,  sum(VALR_BASE_IMP) as baseImp, VALR_PORCENT as porcent, sum(VALR_VAL_RET) as valRet, count(VALR_NUMFACT) as numFact
		from t_val_retenciones, t_comprobante, t_client_provee 
		where IDT_COMPROBANTE = VALR_IDT_RETENCION and VALR_ESTADO = 1 and COM_ESTADO_SIS =1 
		and VALR_FK_IDCLIPROV = IDT_CLIENT_PROVEE and (VALR_FECHA_ENV BETWEEN '".$var_fech_ini."' and '".$var_fech_fin."') group by  codRet
		union all 
		SELECT '332' AS codRet, PCU_DESCRIPCION AS descCuenta, sum(COM_VAL_SUBT) as baseImp, 0 as porcent, Sum(0) as valRet, count(COM_NUM_COMPROB) as numFact
		FROM t_client_provee, t_comprobante, t_asiento,t_plancuentas where COM_ESTADO_SIS= 1 and ASI_CUENTA='2.1.3.01.24' and IDT_COMPROBANTE= ASI_FK_IDCOMPROB 
		and COM_FKID_CLI_PROV= IDT_CLIENT_PROVEE and ASI_CUENTA= PCU_CUENTA 
		and PCU_EMPRESA =1 and (COM_FEC_CREA between '".$var_fech_ini."' and '".$var_fech_fin."') group by  codRet";
		//echo $cad_ret;
		$ejec_cad_ret = mysql_query($cad_ret);
		echo "<table><tr>
		 	<td><p style='margin:0;font-size:13px;'><strong>CUENTA.</strong></p></td>		 	
		 	<td align='center'><p style='margin:0;font-size:13px;'><strong>COD RET.</strong></p></td>
		 	<td align='right'><p style='margin:0;font-size:13px;'><strong>BASE IMP.</strong></p></td>
		 	<td align='right'><p style='margin:0;font-size:13px;'><strong>%.</strong></p></td>
		 	<td align='right'><p style='margin:0;font-size:13px;'><strong>VAL. RET.</strong></p></td>
		 </tr>";
		while ($res_ret = mysql_fetch_array($ejec_cad_ret)) {
		 	?>
		 	<tr>
		 		<td style="width:300px;"><p style="margin:0;font-size:13px;"><?php echo $res_ret['descCuenta']; ?></p></td>
			 	<td style="width:120px;" align="center"><p style="margin:0;font-size:13px;"><?php echo $res_ret['codRet']; ?></p></td>
			 	<td style="width:120px;" align="right"><p style="margin:0;font-size:13px;"><?php echo $res_ret['baseImp']; ?></p></td>
			 	<td style="width:120px;" align="right"><p style="margin:0;font-size:13px;"><?php echo $res_ret['porcent']; ?></p></td>
			 	<td style="width:120px;" align="right"><p style="margin:0;font-size:13px;"><?php echo $res_ret['valRet']; ?></p></td>
			 	<td style="width:120px;" align="right"><p style="margin:0;font-size:13px;"><?php echo $res_ret['numFact']; ?></p></td>
			</tr>
		 	<?php 
		 }
		 echo '
		 <tr>
		 	<td colspan="5" align="center">
		 		<br>
				<a href="rpt_lib_retenciones.php?f1='.$var_fech_ini.'&f2='.$var_fech_fin.'&indent='.$identific.'" targert="blank" 
				style="text-decoration:none;color:#fff;background:green;paddign:5px;border-radius:3px;padding:5px;">Reporte Excel</a>
		 	</td>
		 </tr>
		 </table>';
	}

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
}	

?>