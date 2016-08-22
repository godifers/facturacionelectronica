<?php 
include("lib/phpconex.php");
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
	?>
	<form name="frm_mayor_Cli">
		<div  style="width:1000px;margin:0 auto;">
			<table style="width:100%;">
				<tr>
					<td colspan="3">Movimiento de creditos<hr></td>
				</tr>
				<tr>
					<td align="left">Seleccione  fechas</td>
					<td>
						<input type="date" name="c_facha1" id="id_facha1">
					</td>
					<td>
						<input type="date" name="c_facha2" id="id_facha2">
					</td>
					<td align="right"><input type="button" value="Buscar" onclick="mayorPorFecha();"></td>
				</tr>
				<tr>
					<td colspan="5">
						<div class="cl_result_mayor" id="result_mayor" style="width:100%;min-heigt:auto;height:500px;overflow:auto;">
							
						</div>
					</td>
				</tr>
			</table>
		</div>	
	</form>	
	<?php
}else{
echo "<script>
	alert('USTED NO HA INICIADO SESION');
	window.location='index.php';
</script>";
}
 ?>