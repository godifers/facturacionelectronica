<?php 
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
	if ($_SESSION['cargo']==1) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="" name="frm_cosultas_ret">
		<div class="cl_libroreten" id="id_libroreten" style="width:1024px;margin: 0 auto;">
			<table clas="cl_tabresultados" style="width:100%;">
				<tr>
					<td colspan="4" align="center"><h4>LIBRO DE RETENCIONES</h4><hr></td>
				</tr>
				<tr>
					<td>
						<fieldset style="height:40px;">
							<legend>
								Que buscas. ?
							</legend>
							<input type="radio" value="1" name="tipobusc" checked/>Rep. resumen
							<input type="radio" value="2" name="tipobusc">REP. Detall
						</fieldset>
					</td>
					<td>
						<fieldset>
							<legend>
								Desde.
							</legend>
							<input type="date" cl="cl_txt" id="id_lr_fech_desde" name="c_lrdesde" id="id_f_ini" style="width:300px;height:20px;">
						</fieldset>						
					</td>
					<td>
						<fieldset>
							<legend>
								Hasta. 
							</legend>
							<input type="date" cl="cl_txt" id="id_lr_fech_hasta" name="c_lrhasta" id="id_f_fin" style="width:300px;height:20px;">
						</fieldset>
					</td>					
					<td><input type="button" name="c_lrbuscar" id="id_button" value="Buscar" onclick="resporte_ret();"></td>
				</tr>
				<tr>
					<td colspan="4">
						<div class="cl_res_rep_ret" id="id_res_rep_ret" style="width:100%;minheight:auto;max-height:580px;overflow:auto;">
							
						</div>
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