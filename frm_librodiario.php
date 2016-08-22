<?php 
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
	if ($_SESSION['cargo']==1) {
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
			<td>LIBRO DIARIO DE:</td>
			<td><input type="date" name="c_fehcaLibDiar" id="id_fehcaLibDiar"></td>
			<td>HASTA:</td>
			<td><input type="date" name="c_fehcaLibDiar2" id="id_fehcaLibDiar2"></td>
			<td><input type="button" value="Generar Libro" onclick="genLibDiar();"></td>
		</tr>
		<tr>
			<td colspan="5"><hr></td>
		</tr>
		<tr>
			<td colspan="5">
				<div class="clLibDiario" id="id_LibDiario" style="width:100%;margin:0 auto; height:450px;overflow:auto;">
					
				</div>
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