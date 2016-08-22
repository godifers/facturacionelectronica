<?php 
session_start();
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])){
include("phpconexcion.php");
$enlace = conectar_buscadores();

$texto =$_POST['texto'];
$identific =$_POST['identific'];
$texto = str_replace(" ", "%", $texto);
$cad_doc ="SELECT * from t_comprobante, t_client_provee where COM_ESTADO_SIS= 1 and COM_ESTADO_PAGO=1 and COM_TIPO_COMPR<>'V'  and  COM_FKID_CLI_PROV= IDT_CLIENT_PROVEE 
			and (COM_NUM_COMPROB like'".$texto."%' or CP_CEDULA like'".$texto."%' 
			or concat(CP_NOMBRE,' ', CP_APELLIDO) like '%".$texto."%' 
			or concat(CP_APELLIDO,' ',CP_NOMBRE) like'%".$texto."%') and COM_TIPO_COMPR <>'Z'";
/*IDT_COMPROBANTE, COM_TIPO_COMPR, COM_SUBTIPO_COMP, COM_SECUEN_TIPO, COM_NUM_COMPROB, COM_VAL_SUBT, COM_VAL_BASE0, COM_VAL_BASE12, COM_IVA, COM_TOT, COM_TOT_SIN_RET, COM_TOT_PAGO_COBR, COM_PARTEREL, COM_SUSTENTO_TRIB, COM_FKID_FORMAPAGO, COM_ABONO, COM_SALDO, COM_DOCAFECTADO, COM_FKID_DOCAFECT, COM_CLAVEACESO_SRI, COM_AUTORIZACION_SRI, COM_ESTADO_SIS, COM_ESTADO_CONTAB, COM_ESTADO_ATS_SRI, COM_ESTADO_PAGO, COM_ESTADO_SRI, COM_ESTADO_NULL, COM_MSN_SRI, COM_AMBIENTE, COM_OBSERV_TIPOTRANSAC, COM_OBSERV_GENRL, COM_FKID_CLI_PROV, COM_FKID_USER_CREA, COM_FKID_USER_EDIT, COM_FKID_USER_ANULA, COM_FEC_CREA, COM_FEC_EDIT, COM_FEC_ANULA, COM_FEC_ENVIO, COM_FEC_LLEGADA, COM_FEC_CORTE, COM_FEC_PAGO, COM_PLAZO, COM_EPRESA, COM_OFCINA, IDT_CLIENT_PROVEE, CP_NOMBRE, CP_APELLIDO, CP_CEDULA, CP_DIRECCION, CP_TELEFONO, CP_MAIL, CP_CIUDAD, CP_TIPO_CONTRIB, CP_ESTADO, CP_VAL_CREDIT, CP_TIPO_ID, CP_EMPRESA, CP_OFFI, CP_TIPO_CLI_PROV, CP_PLAZO_PAG, id*/
$ejec_cad_docs = mysql_query($cad_doc);

if (mysql_num_rows($ejec_cad_docs)==0) {
		echo "<h4 style='background:red;'>NO SE HA ENCONTRADO RESULTADOS</h4>";
	} else {
	
		echo "<h4>Resultados Encontrados</h4>";
		echo "<table class='cl_tabresultados' style='width:100%;'>";
		while ($resdoc = mysql_fetch_array($ejec_cad_docs)) {						
			?>
		   	<tr>
		   		<td style="width:5%">
		   			<a href="#" onclick="mostrar_doc_af('<?php echo $resdoc['IDT_COMPROBANTE']; ?>','<?php echo $resdoc['COM_TIPO_COMPR']; ?>','<?php echo $resdoc['COM_NUM_COMPROB']; ?>','<?php echo $resdoc['COM_FEC_CREA']; ?>','<?php echo $resdoc['COM_VAL_SUBT']; ?>','<?php echo $resdoc['COM_VAL_BASE0']; ?>','<?php echo $resdoc['COM_VAL_BASE12']; ?>','<?php echo $resdoc['COM_IVA']; ?>','<?php echo $resdoc['COM_TOT']; ?>','<?php echo $resdoc['COM_SALDO']; ?>','<?php echo $resdoc['COM_ABONO']; ?>','<?php echo $resdoc['COM_FKID_CLI_PROV']; ?>','<?php echo $resdoc['COM_ESTADO_PAGO']; ?>','<?php echo $resdoc['COM_ESTADO_SIS']; ?>','<?php echo $identific; ?>');">
		   				<?php echo $resdoc['COM_TIPO_COMPR']; ?>
		   			</a>
		   		</td>
		   		<td style="width:30%">
		   			<a href="#" onclick="mostrar_doc_af('<?php echo $resdoc['IDT_COMPROBANTE']; ?>','<?php echo $resdoc['COM_TIPO_COMPR']; ?>','<?php echo $resdoc['COM_NUM_COMPROB']; ?>','<?php echo $resdoc['COM_FEC_CREA']; ?>','<?php echo $resdoc['COM_VAL_SUBT']; ?>','<?php echo $resdoc['COM_VAL_BASE0']; ?>','<?php echo $resdoc['COM_VAL_BASE12']; ?>','<?php echo $resdoc['COM_IVA']; ?>','<?php echo $resdoc['COM_TOT']; ?>','<?php echo $resdoc['COM_SALDO']; ?>','<?php echo $resdoc['COM_ABONO']; ?>','<?php echo $resdoc['COM_FKID_CLI_PROV']; ?>','<?php echo $resdoc['COM_ESTADO_PAGO']; ?>','<?php echo $resdoc['COM_ESTADO_SIS']; ?>','<?php echo $identific; ?>');">
		   			<?php echo $resdoc['COM_NUM_COMPROB']; ?>
		   			</a>
		   		</td>
		   		<td style="width:50%">
		   			<a href="#" onclick="mostrar_doc_af('<?php echo $resdoc['IDT_COMPROBANTE']; ?>','<?php echo $resdoc['COM_TIPO_COMPR']; ?>','<?php echo $resdoc['COM_NUM_COMPROB']; ?>','<?php echo $resdoc['COM_FEC_CREA']; ?>','<?php echo $resdoc['COM_VAL_SUBT']; ?>','<?php echo $resdoc['COM_VAL_BASE0']; ?>','<?php echo $resdoc['COM_VAL_BASE12']; ?>','<?php echo $resdoc['COM_IVA']; ?>','<?php echo $resdoc['COM_TOT']; ?>','<?php echo $resdoc['COM_SALDO']; ?>','<?php echo $resdoc['COM_ABONO']; ?>','<?php echo $resdoc['COM_FKID_CLI_PROV']; ?>','<?php echo $resdoc['COM_ESTADO_PAGO']; ?>','<?php echo $resdoc['COM_ESTADO_SIS']; ?>','<?php echo $identific; ?>');" style="font-size:12px;">
		   				<?php echo utf8_encode($resdoc['CP_NOMBRE'].' '.$resdoc['CP_APELLIDO']); ?>
		   			</a>
		   		</td>
		   		<td  style="width:5%">
		   			<p style="font-size:12px;margin:0;"><?php echo $resdoc['COM_TOT']; ?></p>
		   		</td>
		   		<td  style="width:%">
		   			<p style="font-size:12px;margin:0;"><?php echo $resdoc['COM_FEC_CREA']; ?></p>
		   		</td>
		   	</tr>
		   <?php 
		}
		echo "</table>";	
	}	

}else{
	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}