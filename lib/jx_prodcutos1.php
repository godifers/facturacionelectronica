<?php 
//session_start();
include("phpconexcion.php");
$n=$_POST['q'];
$empres = $_POST['empre'];
$i=$_POST['ident'];
//if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>jx_prodcutos.php</title>
</head>
<body>
	<?php 
	//echo "siiiii";
	//bx, PR_COD_PROD, PR_DETALLE, PR_PRESENTACION, PR_IMPUESTO, PR_ESTADO, PR_TIPO, PR_STOK_INI,
	// PR_VAL_COMPRA, PR_VAL_MIN, PR_VAL_MED, PR_VAL_MAX, PR_VAL_PVP, PR_OFFI, PR_EMPRESA, PR_BARRAS, PR_FK_PROVEEDOR
	$enlace = conectar_buscadores();
	$cad="SELECT * FROM t_prodcutos ,t_invetario_inicial
		where INI_FK_COD_PROD=PR_COD_PROD and INI_EMPRESA =".$empres."  and  PR_EMPRESA= ".$empres." 
			and PR_DETALLE like '".str_replace(" ","%",strtoupper($n))."%'
			or PR_PRESENTACION like '".str_replace(" ","%",strtoupper($n))."%' 
			or PR_DETALLE ||' '|| PR_PRESENTACION like '".str_replace(" ","%",strtoupper($n))."%'
			or PR_BARRAS  like '".str_replace(" ","%",strtoupper($n))."%' LIMIT 30";
		//echo $cad;

			$ajecqueryprod = mysql_query($cad);
			//mysql_close($enlace);
			//oci_execute($ajecqueryprod);


			echo "<h4>Resultados Encontrados</h4>";
			echo "<table class='cl_tabresultados' style='width:100%;'>";
			while (($resproductod = mysql_fetch_array($ajecqueryprod))) {
				//$cliente =;
				$enlace = conectar_buscadores();
				$cad_stoc_actual = "SELECT DET_CANTIDAD, DET_TIPO_TRNS, COM_TIPO_COMPR FROM t_detalles, t_comprobante 
				WHERE DET_NUM_FACTU= COM_NUM_COMPROB
				and DET_FK_IDCLIPROV = COM_FKID_CLI_PROV and DET_FK_IDCOMPROB= IDT_COMPROBANTE and COM_ESTADO_SIS=1 
				and DET_EMP= COM_EPRESA  AND DET_EMP=".$empres." AND DET_FK_IDPROD='".$resproductod['PR_COD_PROD']."'";
				//echo $cad_stoc_actual;
				$ejec_cad_stock  = mysql_query($cad_stoc_actual);
				$can_act= $resproductod['INI_STOK_INI'];
				while ( $res_cal_detalle = mysql_fetch_array($ejec_cad_stock)) {
					if ($res_cal_detalle['COM_TIPO_COMPR']=='V' or $res_cal_detalle['COM_TIPO_COMPR']=='G' or $res_cal_detalle['COM_TIPO_COMPR']=='M' ) {
						$can_act = $can_act -  $res_cal_detalle['DET_CANTIDAD'];
					} else {
						$can_act = $can_act +  $res_cal_detalle['DET_CANTIDAD'];
					} 
				}
			   ?>
			   <tr class="cl_tr_res">
			   	<td class="cl_td_res">
			   <a href="#" onclick="mostrarprodcutos('<?php echo $resproductod['PR_COD_PROD']; ?>','<?php echo $resproductod['PR_DETALLE']; ?>',
			   	'<?php echo $resproductod['PR_PRESENTACION']; ?>','<?php echo $resproductod['PR_IMPUESTO']; ?>',
			   	'<?php echo $resproductod['PR_ESTADO']; ?>','<?php echo $resproductod['PR_TIPO']; ?>','<?php echo $can_act; ?>',
			   	'<?php echo $resproductod['PR_VAL_COMPRA']; ?>','<?php echo $resproductod['PR_VAL_MIN']; ?>','<?php echo $resproductod['PR_VAL_MED']; ?>',
			   	'<?php echo $resproductod['PR_VAL_MAX']; ?>',
			   	'<?php echo $resproductod['PR_BARRAS']; ?>','<?php echo $resproductod['PR_VAL_PVP']; ?>','<?php echo $resproductod['PR_FK_PROVEEDOR']; ?>','<?php echo $i; ?>');" >
			   	<?php echo  $resproductod['PR_DETALLE'].' '.$resproductod['PR_PRESENTACION'].' |'.$resproductod['PR_VAL_MIN'].'|'.$resproductod['PR_VAL_MED']
			   	.'|'.$resproductod['PR_VAL_MAX'].'|'.$resproductod['PR_VAL_PVP'].'|'.$resproductod['PR_VAL_COMPRA'].'|'.$can_act;?>
			   </a>
			   </td>			   
			   </tr>
			   	
			   <?php 
			}
			echo "</table>";	

	           
		/*$cad= 'SELECT idt_clientes, cl_nombres, cl_apellidos, cl_cedula_ruc, cl_direccion, cl_telf from t_clientes 
				where cl_nombres like "%'.strtoupper($n).'%"';*/
		
	 ?>
</body>
</html>