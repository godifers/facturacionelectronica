<?php 
require_once('lib/phpconex.php')
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registrar Empresa</title>
</head>
<body>
	<form action="lib/jx_updatefechtrabajo.php" method="post" enctype="multipart/form-data" autocomplete="off">
		<table>
			<tr>
				<td colspan="6" align="center"><h3 style="margin:20px auto; border-bottom: solid 1px #e89980;"> ACTUALICE FECHA DE TRABAJO</h3></td>
			</tr>
			<tr>
				<td>Ambiente: </td>
				<td colspan="2"><select name="c_empambiente" id="id_ambiente" style="width:200px;height:50px;font-size:25px;text-align:center;">
					<option value="2">PRODUCCIÓN</option>
					<option value="1">PRUEBAS</option>
				</select></td>
				<td>Fecha de trabajo: </td>
				<td colspan="2"><input type="date" class="cl_txt" name="c_empfechtrabajo" id="id_fechtrabajo" style="width:250px;height:50px;font-size:30px;text-align:center;"></td>
			</tr>
			<tr>
				<td colspan="6" align="right"><input type="Submit" class="cl_btn" value="Actualizar"></td>
			</tr>
		</table>
	</form>
	<form action="lib/addempresas.php" method="post" enctype="multipart/form-data" autocomplete="off">
		<div>
			<table>
				<tr>
					<td colspan="6" align="center"><h3 style="margin:20px auto; border-bottom: solid 2px #e89980;">REGISTRAR / ACTUALIZAR EMPRESA</h3></td>
				</tr>				
				<tr>
					<td align="right" colspan="6">
						<input type="hidden" name="c_idt_empr" id="id_idt_emp" value="0">
						<input type="text" value="NUEVO.." id="id_etiqueta" style="background:green;border-style:none;">
					</td>
				</tr>				
				<tr>
					<td>Seleccione Empresa: </td>
					<td><select name="c_emprazonsoc" id="id_emprazonsoc" style="width:198px;" onchange="mostrardatosempresa(this.value);">
						<option value="0">Seleccione..</option>
						<?php 				
								$enlace = conectarbd();		
								$cadempresa="SELECT * FROM t_empresa";
								$ejecadempresa=mysql_query($cadempresa);
								mysql_close($enlace);
								while ($resultempresa=mysql_fetch_array($ejecadempresa)) {
									//IDT_EMPRESA, EMP_RAZON_SOCIAL, EMP_RUC, EMP_DIRECCION, EMP_TELEFONO, EMP_IMPUESTO, EMP_PRIMER_FACT, EMP_FECH_CREA, EMP_COTIZACION, 
									//EMP_MAX_ITEMS, EMP_VALMIN_CF, EMP_NOMBRE, EMP_CODIGO, EMP_ESTADO, EMP_AMBIENTE, EMP_FECHA_TRABAJO
									//EMP_SERIE1, EMP_SERIE2, EMP_SERIE3_INICIO_FACTU, EMP_SERIE4_INICIO_RETEN, EMP_NUMERO_CONTRIB, EMP_OBLIGADO_LLEVAR_CONTAB, 
									//EMP_SERIE5_INICIO_NC_VENTA, EMP_SERIE6_INICIO_GIAS, EMP_DIR_LOCAL, EMP_SERIE7_INCIO_COBRO_FAC, 
									//EMP_SERIE8_INICIO_PAGO_COMP, EMP_SERIE9_INICIO_NOTA_CONT, EMP_SERIE10_INICIO_INGRES, EMP_SERIE11_INICIO_EGRESO, 
									//EMP_SERIE12_INICIO_L, EMP_SERIE13_INICIO_CAMBIO_INVE,
									?>
									<option value="<?php echo $resultempresa['IDT_EMPRESA'];?>|<?php echo $resultempresa['EMP_RAZON_SOCIAL'];?>
										|<?php echo $resultempresa['EMP_RUC'];?>|<?php echo $resultempresa['EMP_DIRECCION_MATRIZ'];?>|<?php echo $resultempresa['EMP_TELEFONO'];?>
										|<?php echo $resultempresa['EMP_IMPUESTO'];?>|<?php echo $resultempresa['EMP_PRIMER_FACT'];?>|<?php echo $resultempresa['EMP_FECH_CREA'];?>
										|<?php echo $resultempresa['EMP_COTIZACION'];?>|<?php echo $resultempresa['EMP_MAX_ITEMS'];?>|<?php echo $resultempresa['EMP_VALMIN_CF'];?>
										|<?php echo $resultempresa['EMP_NOMBRE'];?>|<?php echo $resultempresa['EMP_CODIGO'];?>|<?php echo $resultempresa['EMP_ESTADO'];?>
										|<?php echo $resultempresa['EMP_AMBIENTE'];?>|<?php echo $resultempresa['EMP_FECHA_TRABAJO'];?>
										|<?php echo $resultempresa['EMP_SERIE1'];?>|<?php echo $resultempresa['EMP_SERIE2'];?>|<?php echo $resultempresa['EMP_SERIE3_INICIO_FACTU'];?>|<?php echo $resultempresa['EMP_SERIE4_INICIO_RETEN'];?>
										|<?php echo $resultempresa['EMP_NUMERO_CONTRIB'];?>|<?php echo $resultempresa['EMP_OBLIGADO_LLEVAR_CONTAB'];?>|<?php echo $resultempresa['EMP_SERIE5_INICIO_NC_VENTA'];?>|<?php echo $resultempresa['EMP_SERIE6_INICIO_GIAS'];?>
										|<?php echo $resultempresa['EMP_DIR_LOCAL'];?>|<?php echo $resultempresa['EMP_SERIE7_INCIO_COBRO_FAC'];?>|<?php echo $resultempresa['EMP_SERIE8_INICIO_PAGO_COMP'];?>|<?php echo $resultempresa['EMP_SERIE9_INICIO_NOTA_CONT'];?>
										|<?php echo $resultempresa['EMP_SERIE10_INICIO_INGRES'];?>|<?php echo $resultempresa['EMP_SERIE11_INICIO_EGRESO'];?>|<?php echo $resultempresa['EMP_SERIE12_INICIO_L'];?>|<?php echo $resultempresa['EMP_SERIE13_INICIO_CAMBIO_INVE'];?>"
										><?php echo $resultempresa['EMP_NOMBRE'];?></option>	
									<?php 
									}
							?>
					</select></td>
					<td>RUC: </td>
					<td><input type="text" class="cl_txt" name="c_empruc" id="id_ruc" placeholder="Ingrese RUC"></td>
					<td>Razon social</td>
					<td><input type="text" id="id_rz" name="c_rz"></td>
				</tr>	
				<tr>
					<td>Dirección: </td>
					<td><input type="text" class="cl_txt" name="c_empdirec" id="id_empdirec" placeholder="Ingrese Dirección"></td>
					<td>Teléfono: </td>
					<td><input type="text" class="cl_txt" name="c_emptelf" id="id_emptelf" placeholder="Teléfono"></td>
					<td>Impuesto: </td>
					<td><input type="text" class="cl_txt" name="c_empimpuesto" id="id_empimpuesto" placeholder="0.12"></td>
				</tr>
				<tr>
					<td>Primer Factura: </td>
					<td><input type="text" class="cl_txt" name="c_empprimerfact" id="id_empprimerfact" placeholder="001001000000001"></td>
					<td>Fecha Creación: </td>
					<td><input type="text" class="cl_txt" name="c_empfechacrea" id="id_empfechacrea" style="height:18px;"></td>
					<td>Cotización: </td>
					<td><input type="text" class="cl_txt" name="c_empcotizacion" id="id_cotizacion" placeholder="Cotización del día"></td>
				</tr>
				<tr>
					<td>Valor Mínimo: </td>
					<td><input type="text" class="cl_txt" name="c_empvalmin" id="id_empvalmin"></td>
					<td>Items: </td>
					<td><input type="text" class="cl_txt" name="c_empitems" id="id_empitems"></td>
					<td>Nombre Empresa: </td>
					<td><input type="text" class="cl_txt" name="c_empnombre" id="id_empnombre"></td>
				</tr>
				<tr>					
					<td>Código: </td>
					<td><input type="text" class="cl_txt" name="c_empcodigo" id="id_empcodigo"></td>
					<td>Oicina: </td>
					<td><select name="c_empestado" id="id_empestado" cl="cl_cmb">
						<option value="1">ACTIVO</option>
						<option value="0">ANULADO</option>
					</select></td>
					<td>Serie 1: </td>
					<td><input type="text" class="cl_txt" name="c_regempser1" id="id_regempser1" placeholder="001"></td>
				</tr>								
				<tr>				
					<td>Serie 2:</td>
					<td><input type="text" class="cl_txt" name="c_regempser2" id="id_regempser2" placeholder="001"></td>
					<td>Inicio Fact.</td>
					<td><input type="text" class="cl_txt" name="c_regempinifact" id="id_regempinifact" placeholder="000000001"></td>
					<td>Inicio Reten.</td>
					<td><input type="text" class="cl_txt" name="c_regempinreten" id="id_regempinreten" placeholder="000000001"></td>
				</tr>				
				<tr>
					<td>N° Contrib.</td>
					<td><input type="text" class="cl_txt" name="c_regempnumcontrib" id="id_regempnumcontrib" placeholder="000"></td>
					<td>Lleva Cont.</td>
					<td><input type="text" class="cl_txt" name="c_regempoblcont" id="id_regempoblcont" placeholder="SI / NO"></td>
					<td>NC Venta</td>
					<td><input type="text" class="cl_txt" name="c_regempncventas" id="id_regempncventas" placeholder="000000001"></td>
				</tr>
				<tr>					
					<td>Guias</td>
					<td><input type="text" class="cl_txt" name="c_regempgias" id="id_regempgias" placeholder="000000001"></td>
					<td>Dir. Local</td>
					<td><input type="text" class="cl_txt" name="c_regempdirlocal" id="id_regempdirlocal" placeholder="Ingrese Direccion Local"></td>
					<td>Cobro fact.</td>
					<td><input type="text" class="cl_txt" name="c_regempcobrofact" id="id_regempcobrofact" placeholder="000000001"></td>
				</tr>	
				<tr>
					<td>Pago Comp.</td>
					<td><input type="text" class="cl_txt" name="c_regempcomp" id="id_regempcomp" placeholder="000000001" required/></td>
					<td>Nota Cont</td>
					<td><input type="text" class="cl_txt" name="c_regempnotacont" id="id_regempnotacont" placeholder="000000001" required/></td>
					<td>Ingreso</td>
					<td><input type="text" class="cl_txt" name="c_regempingreso" id="id_regempingreso"></td>
				</tr>
				<tr>					
					<td>Egreso</td>
					<td><input type="text" class="cl_txt" name="c_regempegreso" id="id_regempegreso" required/></td>
					<td>Inicio L</td>
					<td><input type="text" class="cl_txt" name="c_regempinil" id="id_regempinil" required/></td>
					<td>Cambio Inve.</td>
					<td><input type="text" class="cl_txt" name="c_regempcambinve" id="id_regempcambinve" required/></td>
				</tr>				
				<tr>
					<td colspan="6" align="right">
						<input type="button" value="Limpiar" onclick="javascript:location.reload();">
						<input type="submit" class="cl_btn" value="Guardar">
					</td>
				</tr>
			
			</table>
		</div>
	</form>
	
	
</body>
</html>