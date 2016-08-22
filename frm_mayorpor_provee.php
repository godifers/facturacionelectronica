<?php 
include("lib/phpconex.php");
if (isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
	if ($_SESSION['cargo']==1) {
	?>
	<form name="frm_mayor_Cli">
		<div  style="width:1000px;margin:0 auto;">
			<table style="width:100%;">
				<tr>
					<td colspan="3">AUXILIAR DE PROVEEDORES EN CUENTAS CREDITO PROVEEDORES Y ANTICIPO PROVEEDORES <hr></td>
				</tr>
				<tr>
					<td align="left">Buscador de Clientes</td>
					<td>
						<input type="text" class="cl_txt" name="c_clienteprovee_glo"  onkeyup="buscaracli('6','<?php echo $_SESSION['empresa']; ?>');" style="width:500px;height:18px;" id="id_clienteprovee_glo" placeholder="Ingrese un Razon Social/Ruc/cedula" required/>
						<input type="hidden" class="cl_txt" name="c_idt_cliente_prov" style="width:20px;" id="id_idt_cliente_prov" readonly/>
						<div class="cl_div_clientes" id="id_div_clientes" style="text-align:left;">

						</div>
					</td>
					<td align="right"><input type="button" value="Buscar" onclick="mayorPorProveedor();"></td>
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