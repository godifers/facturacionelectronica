<?php
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
	
	include("lib/phpconexcion.php");
	$enlace = conectar_buscadores();
	$cadNoAutori = "SELECT * FROM t_comprobante, t_client_provee where IDT_CLIENT_PROVEE= COM_FKID_CLI_PROV and  
	(COM_TIPO_COMPR='V' or COM_TIPO_COMPR='G' or COM_TIPO_COMPR='R' or COM_TIPO_COMPR='N') AND COM_ESTADO_SIS = 1 and COM_ESTADO_SRI <> 'AUTORIZADO' 
	and COM_EPRESA=".$_SESSION['empresa']." ORDER BY COM_TIPO_COMPR ASC, COM_FEC_CREA DESC";
	//echo $cadNoAutori;
	$ejCadNoAuto = mysql_query($cadNoAutori);
	echo "<table class='cl_tabresultados' style='width:1024px;margin-top:10px;'>
	<tr>
		<td colspan='7'>
			<p  style='width:300px;background:#F7B375;margin:0;padding:0;border-radius:4px;'>DOCUMENTOS NO AUTORIZADOS</p><hr>
		</td>
	</tr>";
	while ($rNoA = mysql_fetch_array($ejCadNoAuto)) {
		if ($rNoA['COM_ESTADO_SIS']== 0) {
			$etiq = "<p style='text-align:center;width:120px;background:red;margin:0;padding:0;border-radius:4px;'>ANULADO</p>";
		}else{
			$etiq = "<p style='text-align:center;width:120px;background:green;margin:0;padding:0;border-radius:4px;'>ACTIVO</p>";
		}
		?>
		<tr>
			<td style="width:200px;"><p style='margin:2px;padding:0;'><?php echo $rNoA['CP_NOMBRE'].' '.$rNoA['CP_APELLIDO']; ?></p></td>
			<td><p style='margin:2px;padding:0;'><?php echo $rNoA['COM_TIPO_COMPR']; ?></p></td>
			<td><p style='margin:2px;padding:0;'><?php echo $rNoA['COM_NUM_COMPROB']; ?></p></td>
			<td><p style='margin:2px;padding:0;'><?php echo $rNoA['COM_FEC_CREA']; ?></p></td>
			<td><?php echo $etiq; ?></td>
			<td><p style='margin:2px;padding:0;'><?php echo $rNoA['COM_ESTADO_SRI']; ?></p></td>
			<td><p style='margin:2px;padding:0;'><?php echo $rNoA['COM_MSN_SRI']; ?></p></td>
		</tr>
		<?php
	}
	echo "</table>";
	
}else{
	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}
?>