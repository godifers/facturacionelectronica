<?php
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
	if ($_SESSION['cargo']==1) {//-----------------------------------------------------------------------------
		include("lib/phpconexcion.php");
		$enlace = conectar_buscadores();
		$cad = "SELECT LMY_CUENTA,PCU_DESCRIPCION,LMY_FEHA,LMY_SAL_INI,LMY_TOT_DEBE,LMY_TOT_HABER, LMY_SALDO_FIN 
		FROM t_libromayor, t_plancuentas where LMY_CUENTA= PCU_CUENTA order by PCU_CUENTA;";
		$ejeCadLibMay = mysql_query($cad);
?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>frm_libro diario</title>
		</head>
		<body>
			<table style="width:90%;margin:0 auto;">
				<tr>
					<td>LIBRO MAYOR A:</td>
					<td><input type="date" name="c_fehcaLibMayor" id="id_fehcaLibMayor"></td>
					<td><input type="button" value="Generar Mayor" onclick="genLibMayor();"></td>
				</tr>
				<tr>
					<td colspan="3"><hr></td>
				</tr>
				<tr>
					<td colspan="3">
						<div class="cl_divLibMayor" id="id_divLibMayor" style="width:100%;margin:0 auto;min-height:0;max-height:450px;overflow:auto;">
							
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<h4>ULTIMO LIBRO MAYOR GENERADO</h4>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<div class="cl_LibMayorActual" id="id_LibMayorActual" style="width:100%;margin:0 auto;height:450px;overflow:auto;">
							<table width="100%;"  class='cl_tabresultados' >
								<tr>
									<td><p style="margin:0;padding:0;dont-size:15px;"><strong>CUENTA</strong></p></td>
									<td><p style="margin:0;padding:0;dont-size:15px;"><strong>DESCRIP</strong></p></td>
									<td><p style="margin:0;padding:0;dont-size:15px;"><strong>ULTIMA FECH.</strong></p></td>
									<td><p style="margin:0;padding:0;dont-size:15px;"><strong>SALDO INI.</strong></p></td>
									<td><p style="margin:0;padding:0;dont-size:15px;"><strong>TOTAL DEBE.</strong></p></td>
									<td><p style="margin:0;padding:0;dont-size:15px;"><strong>TOTAL HABER.</strong></p></td>
									<td><p style="margin:0;padding:0;dont-size:15px;"><strong>SALDO FIN</strong></p></td>
								</tr>
								
									<?php 
									/*LMY_CUENTA, PCU_DESCRIPCION, LMY_FEHA, LMY_SAL_INI, LMY_TOT_DEBE, LMY_TOT_HABER, LMY_SALDO_FIN*/
									while ($res = mysql_fetch_array($ejeCadLibMay)) {
										?>
										<tr>
											<td><p style="margin:0;padding:0;dont-size:15px;"><?php echo $res['LMY_CUENTA']; ?></p></td>
											<td><p style="margin:0;padding:0;dont-size:15px;"><?php echo $res['PCU_DESCRIPCION']; ?></p></td>
											<td><p style="margin:0;padding:0;dont-size:15px;"><?php echo $res['LMY_FEHA']; ?></p></td>
											<td align="right"><p style="margin:0;padding:0;dont-size:15px;"><?php echo $res['LMY_SAL_INI']; ?></p></td>
											<td align="right"><p style="margin:0;padding:0;dont-size:15px;"><?php echo $res['LMY_TOT_DEBE']; ?></p></td>
											<td align="right"><p style="margin:0;padding:0;dont-size:15px;"><?php echo $res['LMY_TOT_HABER']; ?></p></td>
											<td align="right"><p style="margin:0;padding:0;dont-size:15px;"><?php echo $res['LMY_SALDO_FIN']; ?></p></td>
										</tr>
										<?php
									}
									?>
								
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<br>
						<?php 
						echo "<a href='rptLibMayor.php' target='_clanck'>EXPORTAR A EXEL</a>";
						?>
					</td>
				</tr>
			</table>
		</body>
		</html>
	<?php 
	}else{
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