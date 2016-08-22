<?php 
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
	if ($_SESSION['cargo']==1) {

	include("lib/phpconexcion.php");
	$enlace = conectar_buscadores();
	$cad_bal_dis = "SELECT BALA_EMP, BALA_CUENTA, PCU_DESCRIPCION, BALA_SALDO_INI , BALA_SALDO_FIN ,BALA_CUENTA_AUX
	FROM t_balance_aux, t_plancuentas where BALA_CUENTA= PCU_CUENTA order by BALA_EMP asc,BALA_CUENTA asc ";
	

	$cad_bal_gen ="SELECT BALAG_EMP, BALAG_CUENTA, PCU_DESCRIPCION, BALAG_SALDO_INI , BALAG_SALDO_FIN , BALAG_CUENTA_AUX
	FROM t_balance_gen_aux, t_plancuentas where BALAG_CUENTA= PCU_CUENTA order by BALAG_EMP asc, BALAG_CUENTA asc ";
		//echo $cad_bal_gen;
	$ejec_cad_bal = mysql_query($cad_bal_gen);
?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Document</title>
	</head>
	<body>
		<form action="">
			<div class="cl_balancegen" id="id_balancegen">
				<table>
					<tr>
						<td colspan="2"><p style="font-size:20px"><strong>GENERER BALANCE A:</strong></p></td>	
						<td>
							<input type="date" name="c_fecha_bal" id="id_fecha_bal">
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<hr>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<div class="cl_div_res_bala" id="id_div_res_bala" style="width:1000px;background:none;min-height:auto;max-height:600px;overflow:auto;" >
							<?php
							if (mysql_num_rows($ejec_cad_bal)==0) {
								echo "<h4 style='width:100%';text-align:center;background:red;>NO SE HAN GENERADO BALANCES</h4>";
							} else {
								echo "<table style='width:100%;'><tr>
								<td><strong>EMPRESA</strong></td>
								<td><strong>CUENTA</strong></td>
								<td><strong>DESCRIPCION</strong></td>
								<td><strong>SALDO INI</strong></td>
								<td><strong>SALDO FIN</strong></td>						
								</tr>";
								while ($res_bala = mysql_fetch_array($ejec_cad_bal)) {
									?>
									<tr>
									<td><input type="text" class="cl_txt" value="<?php echo $res_bala['BALAG_EMP']; ?>" style="width:100px;" readonly/></td>
									<td><input type="text" class="cl_txt" value="<?php echo $res_bala['BALAG_CUENTA']; ?>" style="width:120px;" readonly/></td>
									<td><input type="text" class="cl_txt" value="<?php echo $res_bala['PCU_DESCRIPCION']; ?>" style="width:400px;" readonly/></td>
									<td><input type="number" class="cl_txt2" value="<?php echo $res_bala['BALAG_SALDO_INI']; ?>" style="width:100px;" readonly/></td>
									<td><input type="number" class="cl_txt2" value="<?php echo $res_bala['BALAG_SALDO_FIN']; ?>" style="width:100px;" readonly/></td>
									</tr>
									<?php
								}
								echo "</table>";
							}
							
							?>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="5" align="center">
							<br>
							<?php 
							echo '<a href="javascript:#"  onclick="generarnewbal();" style="text-decoration:none;color:#FFF;margin:10px;padding:5px;background:green;border-radius:3px;">GENERAR BALANCE</a>';
							echo '<a href="rpt_balance.php?cadena=1" target="_blank"  style="text-decoration:none;color:#FFF;margin:10px;padding:5px;background:green;border-radius:3px;">EXPORTAR BALANCE POR EMPRESA</a>';			
							echo '<a href="rpt_balance_gen.php?cadena1=2" target="_blank"  style="text-decoration:none;color:#FFF;margin:10px;padding:5px;background:green;border-radius:3px;">EXPORTAR BALANCE GENERAL</a>';	
							 ?>
						</td>
					</tr>
					<tr>
						<td>
							<br><br><br><br><br><br>
						</td>
					</tr>
				</table>
			</div>
		</form>
		
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