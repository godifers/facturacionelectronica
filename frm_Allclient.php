<?php
if (isset($_SESSION['empresa']) ) {
	if ($_SESSION['cargo']==1) {
		include("lib/phpconexcion.php");
		$enlace = conectar_buscadores();
		$cad_clientes ="SELECT * FROM t_client_provee where CP_EMPRESA = 1 and (CP_TIPO_CLI_PROV=1 or CP_TIPO_CLI_PROV=3) order by  CP_APELLIDO asc ";
		$cont= 1;
		$ejec_cad_clientes = mysql_query($cad_clientes);
		echo "
		<h4 style='margin: 0 auto;width: 600px;' >INFORMACION DE LOS CLIENTES </h4><hr>
		<a href='rpt_All_cli.php' target='blank'>Exportar a EXCEL</a>
		<div style='width:1100px;min-height:auto;max-height:550px;overflow:auto;margin:0 auto;'>
			<table class='cl_tabresultados' width='100%'>
				<tr>
					<td><strong>#</strong></td>
					<td><strong>APELLIDOS.</strong></td>
					<td><strong>NOMBRES.</strong></td>
					<td><strong>CEDULA/RUC.</strong></td>
					<td><strong>DIRECCION.</strong></td>
					<td><strong>TELÉFONO.</strong></td>
					<td><strong>TIPO.</strong></td>
					<td><strong>CUPO CREDI.</strong></td>
					<td><strong>CREDITO.</strong></td>
					<td><strong>SALDO.</strong></td>
				</tr>";
		while ($resCli = mysql_fetch_array($ejec_cad_clientes)) {
			if ( $resCli['CP_TIPO_ID']==1) {
				$eti_tipo_doc ='<p style="background:#67A76F;margin:0;text-align:center;border-radius:3px;">Cédula</p>';
			} else if ( $resCli['CP_TIPO_ID']==2){
				$eti_tipo_doc ='<p style="background:#83BADF;margin:0;text-align:center;border-radius:3px;">RUC</p>';
			}else if( $resCli['CP_TIPO_ID']==4){
				$eti_tipo_doc ='<p style="background:#F3C07D;margin:0;text-align:center;border-radius:3px;">Extranjero</p>';
			}

			$enlace = conectar_buscadores();
			$query_saldoc_li = "SELECT sum(COM_SALDO) from t_comprobante where COM_ESTADO_SIS=1 AND  
			COM_ESTADO_PAGO=1 and COM_FKID_CLI_PROV=".$resCli['IDT_CLIENT_PROVEE'] ;

			/*$query_saldoc_li = "SELECT sum(COM_SALDO) from t_comprobante where COM_ESTADO_SIS=1 AND COM_EPRESA = ".$empresa." 
			AND  COM_ESTADO_PAGO=1 and COM_TIPO_COMPR='V' and COM_FKID_CLI_PROV=".$rescliente['IDT_CLIENT_PROVEE'] ;*/
			set_time_limit(0);
			$ejec_query_Saldo = mysql_query($query_saldoc_li);
			$respuesta_saldo = mysql_fetch_row($ejec_query_Saldo);
			$sado=$respuesta_saldo[0];
			$cupo=$resCli['CP_VAL_CREDIT'];
			$new_cupo = $cupo -$sado;
			
			?>			
				<tr>
					<td style="background:#BCBBB9;" width="15px"><p style="font-size:13px;margin:0;"><?php echo $cont; ?></p></td>
					<td><p style="font-size:13px;margin:0;"><?php echo utf8_encode($resCli['CP_APELLIDO']); ?></p></td>
					<td><p style="font-size:13px;margin:0;"><?php echo utf8_encode($resCli['CP_NOMBRE']); ?></p></td>
					<td><p style="font-size:13px;margin:0;"><?php echo $resCli['CP_CEDULA']; ?></p></td>
					<td><p style="font-size:13px;margin:0;"><?php echo utf8_encode($resCli['CP_DIRECCION']); ?></p></td>
					<td><p style="font-size:13px;margin:0;"><?php echo $resCli['CP_TELEFONO']; ?></p></td>
					<td><?php echo $eti_tipo_doc; ?></td>
					<td align="right" style="background:#BCBBB9;" width="15px"><p style="font-size:13px;margin:0;"><?php echo $resCli['CP_VAL_CREDIT']; ?></p></td>
					<td align="right" style="background:#9D9D9D;" width="15px"><p style="font-size:13px;margin:0;"><?php echo $sado ; ?></p></td>
					<td align="right" style="background:#7F7E7E;" width="15px"><p style="font-size:13px;margin:0;"><?php echo $new_cupo ; ?></p></td>					
				</tr>
			<?php
			$cont++;
		}
		echo 
		'</table>
		</div>';
	} else {
		?>
		<div class="" style="width:550px;height:550px;margin: 0 auto ;background:none;text-align:center;">
			<p>USTED NO PUEDE INGRESAR A ESTE MODULO ..(NO ESTA ASIGANDO CON PRIVILEGIOS)</p>
			<img src="img/error.png" alt="" style="width:520x;">
		</div>
		<?php
	}
}else{
	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}
?>