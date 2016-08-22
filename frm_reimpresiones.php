<?php 
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
include("lib/phpconex.php");
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>frm_reimpresiones</title>
</head>
<body>
	<div class="cl_div_retenciones" id="id_div_retenciones">
		<form action="" name="frm_cosultas">
			<table>
				<tr>
					<td colspan="8"><h4>Reimpresión de documentos</h4><hr></td>
				</tr>
				<tr>
					<td colspan="5" rowspan="2">
						<fieldset>
							<legend>
								<strong>Qué estas buscando ..?</strong>
							</legend>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">V .<input type="radio" value="V" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob1" checked/> </p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">W .<input type="radio" value="W" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob1" required/> </p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">X .<input type="radio" value="X" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob1" required/> </p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">P .<input type="radio" value="P" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob2" required/> </p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">Guia Remisión.<input type="radio" value="G" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob3" required/> </p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">Guia Ingreso.<input type="radio" value="H" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob3" required/> </p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">N crédito.<input type="radio" value="N" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob4" required/> </p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">Retención<input type="radio" value="R" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob5" required/></p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">C.<input type="radio" value="C" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob5" required/></p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">M.<input type="radio" value="M" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob5" required/></p>
							<br>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">(F). <input type="radio" value="F" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob5" required/></p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">Egre. (J). <input type="radio" value="J" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob5" required/></p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">Ingre. (I). <input type="radio" value="I" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob5" required/></p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">D.<input type="radio" value="D" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob5" required/></p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">R. Cob. (A) <input type="radio" value="A" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob5" required/></p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">Not-Cont (L) <input type="radio" value="L" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob5" required/></p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">Not-Ven<input type="radio" value="E" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob5" required/></p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">B.<input type="radio" value="B" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob5" required/></p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">K.<input type="radio" value="K" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob5" required/></p>
							<p style="display:inline-block;margin:0;padding:0;font-size:12px;">Z.<input type="radio" value="Z" class="cl_radio"  name="c_tipoconprob" id="id_tipoconprob5" required/></p>
						</fieldset>						
					</td>
					<td colspan="2" rowspan="2">
						<fieldset>
							<legend> 
								<strong>Buscar por:</strong>
								<input type="button" onclick="mostar_fielset('id_div_fechas',1)" value="Fechas" style="font-size:14px;">
								<input type="button" onclick="mostar_fielset('id_div_documento',2)" value="Documentos" style="font-size:14px;">
								<input type="button" onclick="mostar_fielset('id_cliente_prov',3)" value="Cliente / Proveedor" style="font-size:14px;">
							</legend>
							<div class="cl_div_fechas" id="id_div_fechas">
								<table>																		
									<tr>
										<td><input type="date" class="cl_dat" name="c_fecha1" id="id_fecha1" required/></td>
										<td><input type="date" class="cl_dat" name="c_fecha2" id="id_fecha2" required/></td>
									</tr>
								</table>
							</div>							
							<div class="cl_div_documento" id="id_div_documento" style="display:none;">
								<table>
									<tr>
										<td><input type="text" class="cl_txt" name="c_numdoc_se1" id="id_numdoc_se1" style="width:50px;" value="001" maxlength="3"/></td>
										<td><input type="text" class="cl_txt" name="c_numdoc_se2" id="id_numdoc_se2" style="width:50px;" value="001" maxlength="3"/></td>
										<td><input type="text" class="cl_txt" name="c_numdoc_se3" id="id_numdoc_se3" style="width:150px;" placeholder="123456789" maxlength="9"/></td>
									</tr>
								</table>
							</div>
							<div class="cl_cliente_prov" id="id_cliente_prov" style="display:none;">
								<table>
									<tr>
										<td>
											<input type="text" class="cl_txt" name="c_clienteprovee_glo"  onkeyup="buscaracli('6','<?php echo $_SESSION['empresa']; ?>');" style="width:390px;" id="id_clienteprovee_glo" placeholder="Ingrese un Razon Social/Ruc/cedula" required/>
											<input type="hidden" class="cl_txt" name="c_idt_cliente_prov" style="width:20px;" id="id_idt_cliente_prov" readonly/>
											<div class="cl_div_clientes" id="id_div_clientes">
						
											</div>
										</td>
									</tr>
								</table>
							</div>
						</fieldset>
					</td>
					<td>
						<input type="hidden" id="id_verfic" value="1" style="width:50px;">
						<input type="button" value="Limpiar" onclick="javascript:location.reload();">
					</td>
				</tr>
				<tr>					
					<td><input type="button" value="Buscar" onclick="consultarcomprobantes();"></td>
				</tr>
				<tr>
					<td colspan="8">
						<div class="cl_div_resultados_reimpresiones" id="id_div_resultados_reimpresiones" style="min-height:auto;max-height:520px;overflow:auto;">
							
						</div>
					</td>
				</tr>
			</table>	
		</form>
	</div>
</body>
</html>
<?php 
}else{
		echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
	}
 ?>