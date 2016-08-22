<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="lib/new_cobro_fact.php" method ="post" autocomplete="off" name="c_frm_cobros_facturas">
		<div class="cl_datoscobro" id="id_datoscobro">
			<table>
				<tr>
					<td colspan="5" align="center"><h3 style="margin:20px auto; border-bottom: solid 2px #e89980;">REALICE SU COBRO Y/O RECIBO</h3></td>										
				</tr>
				<tr>
					<td colspan="3">
						Cliente: <br><input type="text" class="cl_txt" name="c_datosprov" id="id_clienteprovee_glo" onkeyup="buscaracli('5','<?php echo $_SESSION['empresa']; ?>')" placeholder="Nombres del cliente" style="width:550px;">
						<div class="cl_div_clientes" id="id_div_clientes">
							
						</div>
					</td>
					<td>
						Cédula: <br><input type="text" name="c_cobcedula" class="cl_txt" id="id_cobcedula" placeholder="Cédula" style="width:250px;" readonly/>
						<input type="hidden" class="cl_txt" name="c_cidtcliente" id="id_cidtcliente" style="width:50px;" readonly/>
					</td>
					<td>Esta buscando ? <br>
						<select name="c_cpestado" id="id_cpestado" class="cl_cmb" style="width:150px;">	
							<option value="1">CREDITO</option>
							<option value="0">PAGADO</option>
						</select>							
					</td>
				</tr>				
				<tr>
					<td>
						Desde: <br> <input type="date" name="c_cpdesde" id="id_cpdesde" class="cl_dat">
					</td>
					<td>
						Hasta: <br><input type="date" name="c_cphasta" id="id_cphasta" class="cl_dat">
					</td>
					<td align="right" colspan="3">
						<br>
						<input type="hidden" value="<?php echo  $_SESSION['empresa']; ?>" id= "id_emp_for_cobros">
						<input type="button" class="cl_btn" value="Buscar Créditos" onclick="rptpendientespagos();"> 
					</td>
				</tr>
				<tr>
					<td colspan="11">
						<div id="id_resultadoreport" class="cl_resultadoreport">
							
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="11" align="right">
						<input type="submit" value="Generar pago" id="id_generar_pago" style="display:none;">
					</td>
				</tr>
			</table>
		</div>
	</form>
	
</body>
</html>