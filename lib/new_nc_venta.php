<?php 
session_start();
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	include('phpconex.php');
	$enlace = conectarbd();
	$c_subtota_nc=$_POST['c_subtota_nc'];
	$c_base12_nc=$_POST['c_base12_nc'];
	$c_base0_nc=$_POST['c_base0_nc'];
	$c_iva_nc=$_POST['c_iva_nc'];
	$c_total_nc_nc=$_POST['c_total_nc_nc'];
	$c_idt_comprobante=$_POST['c_idt_comprobante'];
	$c_num_comprobante=$_POST['c_num_comprobante'];
	$c_idt_cliente_nc = $_POST['c_idt_cliente_nc'];

	$cad_nueva_nc_venta = "CALL SP_GUARDAR_NC_VENTA (".$c_idt_cliente_nc." , '".$c_num_comprobante."', ".$c_idt_comprobante." ,".$c_subtota_nc.",
	".$c_base12_nc.", ".$c_base0_nc.", ".$c_iva_nc.",".$c_total_nc_nc.", ".$_SESSION['empresa'].", ".$_SESSION['empresa'].",1, ".$_SESSION['id_user'].")";
	$ejec_sp_nc = mysql_query($cad_nueva_nc_venta);
	//echo $cad_nueva_nc_venta;
	mysql_close($enlace);
	$resultados_nc = mysql_fetch_row($ejec_sp_nc);
	$num_nc = $resultados_nc[0];
	//echo "<br>".$num_nc;
	$new_idt_comprobante = $resultados_nc[1];
	//echo "<br>".$new_idt_comprobante;
	//echo "<BR>";

	if (is_array($_POST['c_cod_nc'])) {
		# ##########################################################################################	
		while(list($key,$codprod) = each($_POST['c_cod_nc']) and list($key,$cant) = each($_POST['c_cant_nc']) 
	   		 	and list($key,$vunit) = each($_POST['c_vuni_nc']) and list($key,$vtot) = each($_POST['c_ctot_nc']) 
	   		 	and list($key,$verif) = each($_POST['c_verificador_nc'])) 
	    	{  	    		
				$enlace = conectarbd();	
				if ($verif ==1) {
					$iser_detall_venta="CALL SP_GUARDAR_PRROD('".$codprod."', ".$cant.", ".$vunit.", ".$vtot.",'N' ,".$_SESSION['empresa'].",
						".$_SESSION['empresa'].",".$new_idt_comprobante." , '".$num_nc."',0 ,0 ,0 , 0,".$c_idt_cliente_nc.")";
					//echo $iser_detall_venta;
					//echo "<br>";
		    		$res_inser_serv=mysql_query($iser_detall_venta) or die(mysql_error());
		    		mysql_close($enlace);
		    		//mysql_free_result($res_inser_serv);
		    		//echo "<br>";
		    		//mysql_close($conex);
	    		}
	   	 	}   	
		# ##########################################################################################
	}
	// ############################################### INICIO DE LA FUNCION #########################
	function generarXML_nc_venta($num_nc_venta, $id_comprobante, $id_client, $factura_afectad, $idet_factura_afect)
	{
		//echo ('SI ESTA ENRANDO A LA function');
		$enlace = conectarbd();
		$cad_query_emp ="SELECT EMP_RUC, EMP_RAZON_SOCIAL,EMP_AMBIENTE,EMP_NOMBRE, EMP_DIRECCION_MATRIZ , EMP_NUMERO_CONTRIB, 
		EMP_OBLIGADO_LLEVAR_CONTAB , EMP_DIR_LOCAL
		FROM t_empresa where  IDT_EMPRESA=".$_SESSION['empresa'];
		//echo $cad_query_emp;
		$ejec_cad_emp = mysql_query($cad_query_emp);
		mysql_close($enlace);
		$resultados_emp = mysql_fetch_row($ejec_cad_emp);
		$ruc_emp = $resultados_emp[0];
		$razon_social_emp= $resultados_emp[1];
		$ambiente_emp = $resultados_emp[2];
		$nombre_emp = $resultados_emp[3];
		$direci_matriz_emp = $resultados_emp[4];
		$num_contrib = $resultados_emp[5];
		$obligado_llev =$resultados_emp[6];
		$dir_local_emp = $resultados_emp[7];

		/*IDT_COMPROBANTE, COM_TIPO_COMPR, COM_SUBTIPO_COMP, COM_SECUEN_TIPO, COM_NUM_COMPROB, COM_VAL_SUBT, COM_VAL_BASE0, COM_VAL_BASE12, COM_IVA, COM_TOT, COM_TOT_SIN_RET, COM_TOT_PAGO_COBR, COM_PARTEREL, COM_SUSTENTO_TRIB, COM_FKID_FORMAPAGO, COM_ABONO, COM_SALDO, COM_DOCAFECTADO, COM_FKID_DOCAFECT, COM_CLAVEACESO_SRI, COM_AUTORIZACION_SRI, COM_ESTADO_SIS, COM_ESTADO_CONTAB, COM_ESTADO_ATS_SRI, COM_ESTADO_PAGO, COM_ESTADO_SRI, COM_ESTADO_NULL, COM_MSN_SRI, COM_AMBIENTE, COM_OBSERV_TIPOTRANSAC, COM_OBSERV_GENRL, COM_FKID_CLI_PROV, COM_FKID_USER_CREA, COM_FKID_USER_EDIT, COM_FKID_USER_ANULA, COM_FEC_CREA, COM_FEC_EDIT, COM_FEC_ANULA, COM_FEC_ENVIO, COM_FEC_LLEGADA, COM_FEC_CORTE, COM_FEC_PAGO, COM_PLAZO, COM_EPRESA, COM_OFCINA, IDT_COMPROBANTE, id*/

		$enlace = conectarbd();
		$cadenaquery_nc_venta ="SELECT COM_FEC_CREA , CP_NOMBRE, CP_APELLIDO ,CP_TIPO_ID, CP_CEDULA,CP_DIRECCION , CP_MAIL, CP_TELEFONO, COM_VAL_SUBT,COM_VAL_BASE12, COM_VAL_BASE0, COM_TOT
		FROM t_comprobante ,t_client_provee where IDT_CLIENT_PROVEE= COM_FKID_CLI_PROV 
		AND COM_NUM_COMPROB='".$num_nc_venta."' and IDT_COMPROBANTE=".$id_comprobante;
		//echo $cadenaquery_nc_venta;
		$ejec_cadquery_nc_venta = mysql_query($cadenaquery_nc_venta);
		mysql_close($enlace);
		$resultado_nc_venta = mysql_fetch_row($ejec_cadquery_nc_venta);
		$fecha_envio = $resultado_nc_venta[0];
		$nombre_cli_provee = $resultado_nc_venta[1].' '.$resultado_nc_venta[2];
		$tipo_ruc_cli_provee = $resultado_nc_venta[3];
		$ruc_client_provee = $resultado_nc_venta[4];
		$direccion_cli_provee = $resultado_nc_venta[5];
		$mail_cli_provee = $resultado_nc_venta[6];
		$telf_cli_procee = $resultado_nc_venta[7];

		$val_subtot_nc = $resultado_nc_venta[8];
		$val_base12_nc = $resultado_nc_venta[9];
		$val_base0_nc = $resultado_nc_venta[10];
		$val_total_nc = $resultado_nc_venta[11];

		$fecha_envio1 = date('d/m/Y',strtotime(str_replace('/', '-', $fecha_envio)));
		$fech_cadena = str_replace('/', '', $fecha_envio1);
		//$periodofic = substr($fecha_envio1,3,7);
		$cadena49 = $fech_cadena.'04'.$ruc_emp.$ambiente_emp.$num_nc_venta.'12345678'.'1';
		//echo $cadena49;

		/*1	Fecha de Emisión	        dd/mm/aaaa          	8	
		  2	Tipo de Comprobante		    Tabla 4	                2		  01 factura
		  3	Número de RUC		        1234567890001	        13		
		  4	Tipo de Ambiente		    Tabla 5	                1		 1 pruebas / 2 produccion
		  5	Serie		                001001	                6		
		  6	Núm del Compr (secuencial)	000000001           	9		
		  7	Código Numérico		        Numérico	            8		
		  8	Tipo de Emisión		        Tabla 2	                1		1 emision normal / 2 Emisión por Indisponibilidad del Sistema/ 3 Emisión Baja Conectividad 
		  9	Dígito Verifi (módulo 11 )	Numérico	            1	*/

		//$longnum = intval(cadena49.LongCount());
		//10112015 01 0491507268001 1 001001 000000009 12345678 1 8
		$longnum = strlen ($cadena49);
		//echo "numero de cARACTERES ".$longnum."<br>";
		$cont = $longnum - 1;
		$suma = 0;
		$cont7 = 2;

		for ( $x = 0; $x < $longnum; $x++)
		{
		    $suma = $suma + ($cont7 * (substr($cadena49,$cont,1)));
		    $cont7 = $cont7 + 1;
		    if ($cont7 > 7)
		    {
		        $cont7 = 2;
		    }
		    $cont = $cont - 1;
		}

		$resmod = $suma % 11;
		$resmod = 11 - $resmod;

		if ($resmod == 11)
		{
		    $resmod = 0;
		}
		else if ($resmod == 10)
		{
		    $resmod = 1;
		}
		$cadena49=$cadena49.$resmod;

		$enlace = conectarbd();
		$cad_update_clave_acceso = "UPDATE t_comprobante SET COM_CLAVEACESO_SRI = '".$cadena49."' 
		WHERE IDT_COMPROBANTE= ".$id_comprobante."  AND  COM_NUM_COMPROB='".$num_nc_venta."'";
		$ejec_cad_update = mysql_query($cad_update_clave_acceso);
		mysql_close($enlace);

		$xml = new DomDocument('1.0', 'UTF-8');

		$notaCredito = $xml->createElement('notaCredito');
		$notaCredito = $xml->appendChild($notaCredito);
		$notaCredito ->setAttribute('id', 'comprobante');
		$notaCredito ->setAttribute('version', '1.0.0');

			$infoTributaria = $xml->createElement('infoTributaria');
			$infoTributaria = $notaCredito->appendChild($infoTributaria);

			$ambiente = $xml->createElement('ambiente',$ambiente_emp);
			$ambiente = $infoTributaria->appendChild($ambiente);

			$tipoEmision = $xml->createElement('tipoEmision','1');
			$tipoEmision = $infoTributaria->appendChild($tipoEmision);

			$razonSocial = $xml->createElement('razonSocial',$razon_social_emp);
			$razonSocial = $infoTributaria->appendChild($razonSocial);

			$nombreComercial = $xml->createElement('nombreComercial',$nombre_emp);
			$nombreComercial = $infoTributaria->appendChild($nombreComercial);

			$ruc = $xml->createElement('ruc',$ruc_emp);
			$ruc = $infoTributaria->appendChild($ruc);

			$claveAcceso = $xml->createElement('claveAcceso',$cadena49);
			$claveAcceso = $infoTributaria->appendChild($claveAcceso);

			$codDoc = $xml->createElement('codDoc','04');
			$codDoc = $infoTributaria->appendChild($codDoc);

			$n1=substr($num_nc_venta,0,3);
			$n2=substr($num_nc_venta,3,3);
			$n3=substr($num_nc_venta,6,9);

			$estab = $xml->createElement('estab',$n1);
			$estab = $infoTributaria->appendChild($estab);

			$ptoEmi = $xml->createElement('ptoEmi',$n2);
			$ptoEmi = $infoTributaria->appendChild($ptoEmi);

			$secuencial = $xml->createElement('secuencial',$n3);
			$secuencial = $infoTributaria->appendChild($secuencial);

			$dirMatriz = $xml->createElement('dirMatriz',$direci_matriz_emp);
			$dirMatriz = $infoTributaria->appendChild($dirMatriz);

		$infoNotaCredito = $xml->createElement('infoNotaCredito');
		$infoNotaCredito = $notaCredito->appendChild($infoNotaCredito);

			$fechaEmision = $xml->createElement('fechaEmision',$fecha_envio1);
			$fechaEmision = $infoNotaCredito->appendChild($fechaEmision);

			$dirEstablecimiento = $xml->createElement('dirEstablecimiento',$dir_local_emp);
			$dirEstablecimiento = $infoNotaCredito->appendChild($dirEstablecimiento);			

			if ($tipo_ruc_cli_provee==1) {
				$tipoid_cli_prov='05';
			} else if($tipo_ruc_cli_provee==2){
				$tipoid_cli_prov='04';
			} else if($tipo_ruc_cli_provee==3){
				$tipoid_cli_prov='07';
			} else if($tipo_ruc_cli_provee==4){
				$tipoid_cli_prov='06';
			}	

			$tipoIdentificacionComprador = $xml->createElement('tipoIdentificacionComprador',$tipoid_cli_prov);
			$tipoIdentificacionComprador = $infoNotaCredito->appendChild($tipoIdentificacionComprador);

			$razonSocialComprador = $xml->createElement('razonSocialComprador',$nombre_cli_provee);
			$razonSocialComprador = $infoNotaCredito->appendChild($razonSocialComprador);

			$identificacionComprador = $xml->createElement('identificacionComprador',$ruc_client_provee);
			$identificacionComprador = $infoNotaCredito->appendChild($identificacionComprador);

			/*$contribuyenteEspecial = $xml->createElement('contribuyenteEspecial',$num_contrib);
			$contribuyenteEspecial = $infoNotaCredito->appendChild($contribuyenteEspecial);*/

			$obligadoContabilidad = $xml->createElement('obligadoContabilidad',$obligado_llev);
			$obligadoContabilidad = $infoNotaCredito->appendChild($obligadoContabilidad);

			$codDocModificado = $xml->createElement('codDocModificado','01');
			$codDocModificado = $infoNotaCredito->appendChild($codDocModificado);

			$n1_fac_afect=substr($factura_afectad,0,3);
			$n2_fac_afect=substr($factura_afectad,3,3);
			$n3_fac_afect=substr($factura_afectad,6,9);

			$new_doc_afectado = $n1_fac_afect.'-'.$n2_fac_afect.'-'.$n3_fac_afect;

			$numDocModificado = $xml->createElement('numDocModificado',$new_doc_afectado );
			$numDocModificado = $infoNotaCredito->appendChild($numDocModificado);

			$enlace = conectarbd();
			$cad_query_doc_afectado ="SELECT COM_FEC_CREA FROM t_comprobante where IDT_COMPROBANTE= ".$idet_factura_afect." and  COM_NUM_COMPROB ='".$factura_afectad."' and COM_FKID_CLI_PROV =".$id_client;

			$ejec_query_doc_afectado =mysql_query($cad_query_doc_afectado);
			mysql_close($enlace);
			$resultados_doc_afe = mysql_fetch_row($ejec_query_doc_afectado);
			$fecha_envio_doc_afec = $resultados_doc_afe[0];

			$fecha_envio_fact = date('d/m/Y',strtotime(str_replace('/', '-', $fecha_envio_doc_afec)));
			
			$fechaEmisionDocSustento = $xml->createElement('fechaEmisionDocSustento',$fecha_envio_fact );
			$fechaEmisionDocSustento = $infoNotaCredito->appendChild($fechaEmisionDocSustento);

			$totalSinImpuestos = $xml->createElement('totalSinImpuestos',$val_total_nc );
			$totalSinImpuestos = $infoNotaCredito->appendChild($totalSinImpuestos);

			$valorModificacion = $xml->createElement('valorModificacion',$val_total_nc );
			$valorModificacion = $infoNotaCredito->appendChild($valorModificacion);

			$moneda = $xml->createElement('moneda','DOLAR');
			$moneda = $infoNotaCredito->appendChild($moneda);

		$totalConImpuestos = $xml->createElement('totalConImpuestos');
		$totalConImpuestos = $infoNotaCredito->appendChild($totalConImpuestos);

			$totalImpuesto = $xml->createElement('totalImpuesto');
			$totalImpuesto = $totalConImpuestos->appendChild($totalImpuesto);

				$codigo = $xml->createElement('codigo','2');
				$codigo = $totalImpuesto->appendChild($codigo);

				$suma_bases_nc =$val_base0_nc + $val_base12_nc;

				$codigoPorcentaje = $xml->createElement('codigoPorcentaje','0');
				$codigoPorcentaje = $totalImpuesto->appendChild($codigoPorcentaje);

				$baseImponible = $xml->createElement('baseImponible',$suma_bases_nc);
				$baseImponible = $totalImpuesto->appendChild($baseImponible);

				$valor = $xml->createElement('valor','0.00');
				$valor = $totalImpuesto->appendChild($valor);

		$motivo = $xml->createElement('motivo','Devolucion');
		$motivo = $infoNotaCredito->appendChild($motivo);

		$detalles = $xml->createElement('detalles');
		$detalles = $notaCredito->appendChild($detalles);

			$enlace =conectarbd();
			$cad_detalle_nc_vent ="SELECT DET_FK_IDPROD, PR_DETALLE, PR_PRESENTACION, DET_CANTIDAD, DET_VAL_UNIT, DET_VAL_TOT , PR_IMPUESTO
			FROM t_detalles, t_prodcutos
			where DET_FK_IDCOMPROB=".$id_comprobante." AND DET_NUM_FACTU=".$num_nc_venta." AND DET_FK_IDPROD= PR_COD_PROD and DET_TIPO_TRNS='N' and PR_EMPRESA =".$_SESSION['empresa'];
			$eje_caddetalleventa_nc_vent = mysql_query($cad_detalle_nc_vent);
			mysql_close($enlace);

			while ($resrul_det_nc_ven= mysql_fetch_array($eje_caddetalleventa_nc_vent)) {

			$detalle = $xml->createElement('detalle');
			$detalle = $detalles->appendChild($detalle);

				$codigoInterno = $xml->createElement('codigoInterno',$resrul_det_nc_ven['DET_FK_IDPROD']);
				$codigoInterno = $detalle->appendChild($codigoInterno);

				$codigoAdicional = $xml->createElement('codigoAdicional',$resrul_det_nc_ven['DET_FK_IDPROD']);
				$codigoAdicional = $detalle->appendChild($codigoAdicional);

				$detalleandpresen = $resrul_det_nc_ven['PR_DETALLE'].' '.$resrul_det_nc_ven['PR_PRESENTACION'];

				$descripcion = $xml->createElement('descripcion',$detalleandpresen);
				$descripcion = $detalle->appendChild($descripcion);

				$cantidad = $xml->createElement('cantidad',$resrul_det_nc_ven['DET_CANTIDAD']);
				$cantidad = $detalle->appendChild($cantidad);

				$precioUnitario = $xml->createElement('precioUnitario',$resrul_det_nc_ven['DET_VAL_UNIT']);
				$precioUnitario = $detalle->appendChild($precioUnitario);

				$descuento = $xml->createElement('descuento','0.00');
				$descuento = $detalle->appendChild($descuento);

				$precioTotalSinImpuesto = $xml->createElement('precioTotalSinImpuesto',$resrul_det_nc_ven['DET_VAL_TOT']);
				$precioTotalSinImpuesto = $detalle->appendChild($precioTotalSinImpuesto);

					$impuestos = $xml->createElement('impuestos');
					$impuestos = $detalle->appendChild($impuestos);

						$impuesto = $xml->createElement('impuesto');
						$impuesto = $impuestos->appendChild($impuesto);

							$codigo = $xml->createElement('codigo','2');
							$codigo = $impuesto->appendChild($codigo);

							$codigoPorcentaje = $xml->createElement('codigoPorcentaje','0');
							$codigoPorcentaje = $impuesto->appendChild($codigoPorcentaje);
							
							$tarifa = $xml->createElement('tarifa','0.00');
							$tarifa = $impuesto->appendChild($tarifa);
							
							$baseImponible = $xml->createElement('baseImponible',$resrul_det_nc_ven['DET_VAL_TOT']);
							$baseImponible = $impuesto->appendChild($baseImponible);
							
							$valor = $xml->createElement('valor','0.00');
							$valor = $impuesto->appendChild($valor);
			}

		$infoAdicional = $xml->createElement('infoAdicional');
		$infoAdicional = $notaCredito->appendChild($infoAdicional);

			$campoAdicional = $xml->createElement('campoAdicional',$direccion_cli_provee);
			$campoAdicional = $infoAdicional->appendChild($campoAdicional);
			$campoAdicional ->setAttribute('nombre', 'Dirección');		

			$campoAdicional = $xml->createElement('campoAdicional',$mail_cli_provee);
			$campoAdicional = $infoAdicional->appendChild($campoAdicional);
			$campoAdicional ->setAttribute('nombre', 'Email');		

			$campoAdicional = $xml->createElement('campoAdicional',$telf_cli_procee);
			$campoAdicional = $infoAdicional->appendChild($campoAdicional);
			$campoAdicional ->setAttribute('nombre', 'Telf');

		$xml->formatOutput = true;
	    $el_xml = $xml->saveXML();
	    $xml->save("C:/xml/02_NOTAS_CREDITO_VENTAS/".$num_nc_venta.".xml");   
	    $xml->save("C:/xml/02_NOTAS_CREDITO_VENTAS/RESPALDOS/".$num_nc_venta.".xml");  

	     $file=fopen("C:/xml/firmap12/proceso.bat","w") or die("Problemas");
		//vamos añadiendo el contenido
		fputs($file,"start C:/xml/firmap12/firmap12.exe c:/xml/02_NOTAS_CREDITO_VENTAS/".$num_nc_venta.".xml c:/xml/02_NOTAS_CREDITO_VENTAS/FIRMADOS/".$num_nc_venta.".xml c:/xml/luis_gerardo_tipaz_piarpuezan.p12 Carolina2000");
		fclose($file);
		exec('C:\xml\firmap12\proceso.bat');
		
	}
	//  ################################################################################ FIN DE LA FUNCION#########################
	
	generarXML_nc_venta($num_nc, $new_idt_comprobante, $c_idt_cliente_nc, $c_num_comprobante, $c_idt_comprobante);
	echo '<script>
		window.location="xmlenviados/02_NOTAS_CREDITO_VENTAS/srienvioxml.php?nunf='.$num_nc.'&idcomprobante='.$new_idt_comprobante.'&direc=02_NOTAS_CREDITO_VENTAS/FIRMADOS";			
	 </script>';
}else{
	echo "<script>
				alert('USTED NO HA INICIADO SESION');
				window.location='../index.php';
			</script>";
	}
 ?>