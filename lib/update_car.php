<?php 
include("phpconexcion.php");
//$enlace = conectarbd();
$cont = 1;
if (is_array($_POST['c_cedula'])) {
		# ##########################################################################################	
		while(list($key,$decula) = each($_POST['c_cedula']) and list($key,$nombres) = each($_POST['c_nombres']) 
	   		 	and list($key,$numfact) = each($_POST['c_factura']) and list($key,$fecha) = each($_POST['c_fecha']) 
	   		 	and list($key,$val) = each($_POST['valor'])) 
	    	{  	   
	    		$val = str_replace("$", "", $val);
	    		
	    		$y = substr($fecha,6,2);
	    		$m = substr($fecha,0,2);
	    		$d = substr($fecha,3,2);
	    		$newfecha = '20'.$y.'-'.$m.'-'.$d;

				$enlace = conectar_buscadores();
				$cad_verificadora = "SELECT IDT_COMPROBANTE FROM t_comprobante_aux where COM_NUM_COMPROB='".$numfact."'";
				$ejec = mysql_query($cad_verificadora);
				//mysql_close($enlace);
				$res_query = mysql_fetch_row($ejec);
				$rs = $res_query[0];
				//echo $cont.' - ';
				$cont = $cont+1;
				if (is_null($rs) or $rs=='') {
					echo "INSERT INTO t_comprobante_aux values (null, 'V', 'V', 1, '".$numfact."', ".$val.", ".$val.", 0, 0, ".$val.", ".$val.", ".$val.", 'NO', NULL,
								2, 0, ".$val.", NULL, NULL, NULL, NULL, 1, 1, 1, 1, 'AUTORIZADO', 0, NULL, 2, '".$nombres."', 'CAR', '".$decula."', 1, 
							NULL, NULL, '".$newfecha."', NULL, NULL, NULL, NULL, '2015-06-02', NULL, 0, 1, 1);";
				}else if (isset($rs)) {
					echo "UPDATE t_comprobante_aux SET COM_OBSERV_GENRL='CAR', COM_SALDO=".$val."WHERE IDT_COMPROBANTE=".$rs ." AND  COM_NUM_COMPROB ='".$numfact."';";
				}else{
					echo "error";
				}
				echo "<br>";
					
	    		
	   	 	}   	
		# ##########################################################################################
	}

 ?>