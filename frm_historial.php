<?php 
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	?>
	<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="" style="width:1100px;margin:0 auto;">
		<div style="width:1100px;margin: 0 auto;">
			<table style="width:100%;">
				<tr>
					<td colspan="10" align="center"><h3 style="margin:5px auto; border-bottom: solid 2px #e89980;">HISTORIAL</h3></td>					
				</tr>
				<tr>
					<td><h4 style="margin:0 0 5px 0;">Obtenga un historial de cada producto:</h4></td>
				</tr>
				<tr>					
					<td><input type="text" class="cl_txt" name="c_product" id="id_product" onkeyup="buscarprod(this.value,4,'<?php echo $_SESSION['empresa'] ?>');" style="width:700px;padding:3px;" placeholder="ingrese un prodcuto">
							<input type="hidden" class="cl_txt" name="c_cod" id="id_cod" style="width:130px;">
							<input type="hidden" class="cl_txt" id="id_empresa" value="<?php echo $_SESSION['empresa']; ?>">

						<div class="cl_div_clientes" id="id_div_filtroprod">
						
						</div>
					</td>
					<td><input type="date" class="cl_dat" name="c_hisdesde" id="id_hisdesde" style="width:150px;"></td>
					<td><input type="date" class="cl_dat" name="c_hishasta" id="id_hishasta" style="width:150px;"></td>
					<td align="right;"><input type="button" class="cl_btn" id="id_" value="Buscar" onclick="reportehistorial();"></td>
				</tr>				
				<tr>
					
				</tr>
				<tr>
					<td colspan="4">
						<div id="id_resultadoreport" class="cl_resultadoreport" style="overflow:auto;height:auto;max-height:500px;">
						</div>
					</td>					
				</tr>				
			</table>
		</div>
	</form>	
</body>
</html>
<?php
} else {

	
}

 ?>