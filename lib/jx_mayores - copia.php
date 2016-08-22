<?php 
session_start();
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
  require_once('phpconexcion.php');
	$fi = $_POST['fi'];
	$ff = $_POST['ff'];
	$id_cli = $_POST['id_cli'];
	$enlace = conectar_buscadores();
	
		/*$cad_mayor  = "SELECT sum(COM_SALDO) FROM t_comprobante, t_client_provee where COM_ESTADO_PAGO = 1 and COM_FKID_CLI_PROV = IDT_CLIENT_PROVEE and 
		 			COM_FEC_CREA < '2016-01-01' and IDT_CLIENT_PROVEE=".$id_cli." order by  COM_FEC_CREA asc";*/
		$cad_mayor = "SELECT COM_TIPO_COMPR, COM_NUM_COMPROB, PCU_DESCRIPCION,ASI_DEBE, ASI_HABER, COM_FEC_CREA FROM t_asiento, t_comprobante, t_plancuentas 
		WHERE COM_ESTADO_SIS= 1 AND ASI_CUENTA= PCU_CUENTA AND ASI_FK_IDCOMPROB = IDT_COMPROBANTE 
		AND (ASI_CUENTA='1.1.4.1.03' OR ASI_CUENTA='2.1.1.01.01' OR ASI_CUENTA='1.1.2.01.01' OR ASI_CUENTA='2.3.1.01')
		AND COM_FKID_CLI_PROV =".$id_cli;
		//echo $cad_mayor;
		$ejec_cad_mayor = mysql_query($cad_mayor);
		//echo $saldo;
		echo "<table style='width:100%;'>";
		while ($res_doc_cuentas =mysql_fetch_array($ejec_cad_mayor)) {
			//$saldo = $saldo + $res_doc_cuentas['ASI_DEBE'] -$res_doc_cuentas['ASI_HABER'];
			?>
			<tr>
				<td><?php echo $res_doc_cuentas['COM_TIPO_COMPR']; ?></td>
				<td><?php echo $res_doc_cuentas['COM_NUM_COMPROB']; ?></td>
				<td><?php echo $res_doc_cuentas['PCU_DESCRIPCION']; ?></td>
				<td><?php echo $res_doc_cuentas['COM_FEC_CREA']; ?></td>
				<td><?php echo $res_doc_cuentas['ASI_DEBE']; ?></td>
				<td><?php echo $res_doc_cuentas['ASI_HABER']; ?></td>
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