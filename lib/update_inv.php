<?php 
session_start();
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	include('phpconex.php');
	
	if(is_array($_POST['c_cod_prod_upi'])) {
		 while(list($key,$cod_prod) = each($_POST['c_cod_prod_upi']) and list($key,$can_stock_ini) = each($_POST['c_val_newstock_upi']) 
		 	and list($key,$identific) = each($_POST['c_val_emp_upi']) ) 
		{  	    		
			//$enlace = conectarbd();
			//if ($identific==1) {
				//$enlace = conectarbd();
				$update_upi="INSERT INTO t_invetario_inicial VALUES(NULL, '".$cod_prod."', ".$can_stock_ini.", '2015-12-03', ".$_SESSION['empresa'].", 1, 1);";
				echo $update_upi.'<br>';
				//$res_inser_serv=mysql_query($update_upi) or die(mysql_error());
				//mysql_close($enlace);*/

				/*$query = sprintf("INSERT INTO t_invetario_inicial " .
		         " (IDT_INVETARIO_INICIAL, INI_FK_COD_PROD, INI_STOK_INI, INI_FECHA, INI_EMPRESA, INI_ESTADO, INI_VIGENTE, ) " .
		         " VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
		         mysql_real_escape_string($cod_prod),
		         mysql_real_escape_string($can_stock_ini),
		         mysql_real_escape_string($fecha_trab),
		         mysql_real_escape_string($_SESSION['empresa']),
		         mysql_real_escape_string(1));*/
			//}			
		}
	}

	/*echo "<script>
	alert('EL PAGO SE HA GENERADO CORRECATAMENTE..!');
	window.open('php_imp_pago_cobro.php?id_comprob=".$idt_comprob ."&num_comprob=".$numero_comprob_pago."','_blanck');
	window.location='inicio.php';
	</script>";*/

	
}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}
 ?>