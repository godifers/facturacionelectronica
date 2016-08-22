<?php 
session_start();
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	include("phpconex.php");
	$enlace = conectarbd();
	$COM_NUM_COMPROB = $_GET['numfct'];
	$id_client = $_GET['id_cli'];
	$idt_comprob = $_GET['idt_numcomp'];
	//echo $COM_NUM_COMPROB ;
	//echo "<br>";
	//echo $id_client;
	//echo "<br>";
	$cad_insert_nuevaret ="CALL SP_CREAR_RETENCION(".$idt_comprob.",'".$COM_NUM_COMPROB."', ".$id_client.",".$_SESSION['id_user'].", ".$_SESSION['empresa'].",".$_SESSION['empresa'].")";
	//echo $cad_insert_nuevaret;
	$ejc_cad_inset_val_ret =mysql_query($cad_insert_nuevaret);
	mysql_close($enlace);
	$resultados = mysql_fetch_row($ejc_cad_inset_val_ret);
	$verificad_recibido = $resultados[0];
	$id_num_comprob_ret= $resultados[1];
	$numeroderetencion = $resultados[2];
	//echo "<br>".$verificad_recibido;
	//echo "<br>".$id_num_comprob_ret;
	//echo "<br>".$numeroderetencion;
	//echo "<br>";

	if ($verificad_recibido==0) { // en caso de que este realizada me debe mostar la retencion realizada
		echo "<script>
			alert('Laretencion ya se ha generado anteriormete con el numero ".$numeroderetencion."');
			window.open('phpimprimir_retencion.php?nunodc=".$numeroderetencion."&id_doc=".$id_num_comprob_ret."','_blank');
			history.back();
		</script>";

	} else if($verificad_recibido==1) { // en eset caso em genera un xml de retencion   y la envia al sri 
		// de aquie en adentalte ---------------------------------------------------------------------------------------------------------------------

		function crearxmlretencion( $idt_coprobante, $num_retencion, $id_client, $factura_de_compra ){//---------------inicio de funcion que creo un xml
			$enlace = conectarbd();
			$cad_query_emp ="SELECT EMP_RUC, EMP_RAZON_SOCIAL, EMP_AMBIENTE, EMP_NOMBRE, EMP_DIRECCION_MATRIZ , EMP_NUMERO_CONTRIB, 
			EMP_OBLIGADO_LLEVAR_CONTAB ,EMP_DIR_LOCAL
			FROM t_empresa where  IDT_EMPRESA=".$_SESSION['empresa'];
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
			$dir_loca_emp = $resultados_emp[7];

			$enlace = conectarbd();
			$cadenaquery_ret ="SELECT COM_FEC_ENVIO , CP_NOMBRE, CP_APELLIDO ,CP_TIPO_ID, CP_CEDULA,CP_DIRECCION , CP_MAIL, CP_TELEFONO, 
			COM_FEC_CREA,COM_AMBIENTE
			FROM t_comprobante ,t_client_provee where IDT_CLIENT_PROVEE= COM_FKID_CLI_PROV 
			AND COM_NUM_COMPROB='".$num_retencion."' and IDT_COMPROBANTE=".$idt_coprobante;
			//echo $cadenaquery_ret;
			$ejec_cadquery_ret = mysql_query($cadenaquery_ret);
			mysql_close($enlace);
			$resultado_retencion = mysql_fetch_row($ejec_cadquery_ret);
			$fecha_envio = $resultado_retencion[0];
			$nombre_cli_provee = $resultado_retencion[1].' '.$resultado_retencion[2];
			$tipo_ruc_cli_provee = $resultado_retencion[3];
			$ruc_client_provee = $resultado_retencion[4];
			$direccion_cli_provee = $resultado_retencion[5];
			$mail_cli_provee = $resultado_retencion[6];
			$telf_cli_procee = $resultado_retencion[7];
			$fech_crea = $resultado_retencion[8];
			$amb_comprob = $resultado_retencion[9];

			$fecha_envio1 = date('d/m/Y',strtotime(str_replace('/', '-', $fecha_envio)));
			$fecha_envio2 = date('d/m/Y',strtotime(str_replace('/', '-', $fech_crea)));
			$fech_cadena = str_replace('/', '', $fecha_envio2);
			$periodofic = substr($fecha_envio1,3,7);
			$cadena49 = $fech_cadena.'07'.$ruc_emp.$ambiente_emp.$num_retencion.'12345678'.'1';
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
			WHERE IDT_COMPROBANTE= ".$idt_coprobante."  AND  COM_NUM_COMPROB='".$num_retencion."'";
			$ejec_cad_update = mysql_query($cad_update_clave_acceso);
			mysql_close($enlace);

			$xml = new DomDocument('1.0', 'UTF-8');

			$comprobanteRetencion = $xml->createElement('comprobanteRetencion');
			$comprobanteRetencion = $xml->appendChild($comprobanteRetencion);
			$comprobanteRetencion ->setAttribute('id', 'comprobante');
			$comprobanteRetencion ->setAttribute('version', '1.0.0');

			$infoTributaria = $xml->createElement('infoTributaria');
			$infoTributaria = $comprobanteRetencion->appendChild($infoTributaria);

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

				$codDoc = $xml->createElement('codDoc','07');
				$codDoc = $infoTributaria->appendChild($codDoc);

				$n1=substr($num_retencion,0,3);
				$n2=substr($num_retencion,3,3);
				$n3=substr($num_retencion,6,9);

				$estab = $xml->createElement('estab',$n1);
				$estab = $infoTributaria->appendChild($estab);

				$ptoEmi = $xml->createElement('ptoEmi',$n2);
				$ptoEmi = $infoTributaria->appendChild($ptoEmi);

				$secuencial = $xml->createElement('secuencial',$n3);
				$secuencial = $infoTributaria->appendChild($secuencial);

				$dirMatriz = $xml->createElement('dirMatriz',$direci_matriz_emp);
				$dirMatriz = $infoTributaria->appendChild($dirMatriz);

			$infoCompRetencion = $xml->createElement('infoCompRetencion');
			$infoCompRetencion = $comprobanteRetencion->appendChild($infoCompRetencion);

				$fechaEmision = $xml->createElement('fechaEmision',$fecha_envio2);
				$fechaEmision = $infoCompRetencion->appendChild($fechaEmision);

				$dirEstablecimiento = $xml->createElement('dirEstablecimiento',$dir_loca_emp);
				$dirEstablecimiento = $infoCompRetencion->appendChild($dirEstablecimiento);

				/*$contribuyenteEspecial = $xml->createElement('contribuyenteEspecial',$num_contrib);
				$contribuyenteEspecial = $infoCompRetencion->appendChild($contribuyenteEspecial);*/

				$obligadoContabilidad = $xml->createElement('obligadoContabilidad',$obligado_llev);
				$obligadoContabilidad = $infoCompRetencion->appendChild($obligadoContabilidad);

				if ($tipo_ruc_cli_provee==1) {
					$tipoid_cli_prov='05';
				} else if($tipo_ruc_cli_provee==2){
					$tipoid_cli_prov='04';
				} else if($tipo_ruc_cli_provee==3){
					$tipoid_cli_prov='07';
				} else if($tipo_ruc_cli_provee==4){
					$tipoid_cli_prov='06';
				}	

				$tipoIdentificacionSujetoRetenido = $xml->createElement('tipoIdentificacionSujetoRetenido',$tipoid_cli_prov);
				$tipoIdentificacionSujetoRetenido = $infoCompRetencion->appendChild($tipoIdentificacionSujetoRetenido);

				$razonSocialSujetoRetenido = $xml->createElement('razonSocialSujetoRetenido',utf8_encode($nombre_cli_provee));
				$razonSocialSujetoRetenido = $infoCompRetencion->appendChild($razonSocialSujetoRetenido);

				$identificacionSujetoRetenido = $xml->createElement('identificacionSujetoRetenido',$ruc_client_provee);
				$identificacionSujetoRetenido = $infoCompRetencion->appendChild($identificacionSujetoRetenido);

				$periodoFiscal = $xml->createElement('periodoFiscal',$periodofic);
				$periodoFiscal = $infoCompRetencion->appendChild($periodoFiscal);

			$impuestos = $xml->createElement('impuestos');
			$impuestos = $comprobanteRetencion->appendChild($impuestos);

				$enlace =conectarbd();
				$cad_query_val_retenidos ="SELECT VALR_COD_SUST, VALR_COD_RET, VALR_BASE_IMP, VALR_PORCENT, VALR_VAL_RET,VALR_NUMFACT 
				FROM t_val_retenciones , t_comprobante
				WHERE VALR_ESTADO=1 AND VALR_FK_IDCLIPROV=".$id_client." AND VALR_NUMFACT= '".$factura_de_compra."' and  COM_NUM_COMPROB= VALR_NUMFACT AND COM_FKID_CLI_PROV= VALR_FK_IDCLIPROV AND COM_ESTADO_SIS =1 order by VALR_COD_SUST asc ";
				//echo $cad_query_val_retenidos;
				$ejc_cad_val_ret =mysql_query($cad_query_val_retenidos);
				mysql_close($enlace);

				while ($res_Valor_ret = mysql_fetch_array($ejc_cad_val_ret)) {

					$impuesto = $xml->createElement('impuesto');
					$impuesto = $impuestos->appendChild($impuesto);

						$codigo = $xml->createElement('codigo',$res_Valor_ret['VALR_COD_SUST']);
						$codigo = $impuesto->appendChild($codigo);

						$codigoRetencion = $xml->createElement('codigoRetencion',$res_Valor_ret['VALR_COD_RET']);
						$codigoRetencion = $impuesto->appendChild($codigoRetencion);

						$baseImponible = $xml->createElement('baseImponible',$res_Valor_ret['VALR_BASE_IMP']);
						$baseImponible = $impuesto->appendChild($baseImponible);

						$porcentajeRetener = $xml->createElement('porcentajeRetener',$res_Valor_ret['VALR_PORCENT']);
						$porcentajeRetener = $impuesto->appendChild($porcentajeRetener);

						$valorRetenido = $xml->createElement('valorRetenido',$res_Valor_ret['VALR_VAL_RET']);
						$valorRetenido = $impuesto->appendChild($valorRetenido);

						$codDocSustento = $xml->createElement('codDocSustento','01');
						$codDocSustento = $impuesto->appendChild($codDocSustento);

						$numDocSustento = $xml->createElement('numDocSustento',$res_Valor_ret['VALR_NUMFACT']);
						$numDocSustento = $impuesto->appendChild($numDocSustento);

						$fechaEmisionDocSustento = $xml->createElement('fechaEmisionDocSustento',$fecha_envio1);
						$fechaEmisionDocSustento = $impuesto->appendChild($fechaEmisionDocSustento);

				}

			if (is_null($mail_cli_provee) or $mail_cli_provee=='' ) {
				$mail_cli_provee='agromundotulcan.sc@gmail.com';
			}
		
			if (is_null($telf_cli_procee) or $telf_cli_procee== 0 or $telf_cli_procee=='0' ) {
				$telf_cli_procee ='062987027';
			}

			$infoAdicional = $xml->createElement('infoAdicional');
			$infoAdicional = $comprobanteRetencion->appendChild($infoAdicional);

				$campoAdicional = $xml->createElement('campoAdicional',utf8_encode($direccion_cli_provee));
				$campoAdicional = $infoAdicional->appendChild($campoAdicional);
				$campoAdicional ->setAttribute('nombre', 'Dirección');		

				$campoAdicional = $xml->createElement('campoAdicional',$mail_cli_provee);
				$campoAdicional = $infoAdicional->appendChild($campoAdicional);
				$campoAdicional ->setAttribute('nombre', 'Email');		

				$campoAdicional = $xml->createElement('campoAdicional',$telf_cli_procee);
				$campoAdicional = $infoAdicional->appendChild($campoAdicional);
				$campoAdicional ->setAttribute('nombre', 'Telf');
		set_time_limit(0);
		$xml->formatOutput = true;
	    $el_xml = $xml->saveXML();
	    $xml->save("C:/xml/07_RETENCIONES/".$num_retencion.".xml");   
	    $xml->save("C:/xml/07_RETENCIONES/RESPALDOS/".$num_retencion.".xml");  

	    $file=fopen("C:/xml/firmap12/proceso.bat","w") or die("Problemas");
		//vamos añadiendo el contenido
		fputs($file,"start C:/xml/firmap12/firmap12.exe c:/xml/07_RETENCIONES/".$num_retencion.".xml c:/xml/07_RETENCIONES/FIRMADOS/".$num_retencion.".xml c:/xml/luis_gerardo_tipaz_piarpuezan.p12 Carolina2000");
		fclose($file);
		exec('C:\xml\firmap12\proceso.bat');

		$file1=fopen("C:/xml/proceso.bat","w") or die("Problemas");
		fputs($file1,"C:/xml/WebServices123.jar C:/xml/07_RETENCIONES/FIRMADOS/".$num_retencion.".xml");
		fclose($file1);
		exec('C:\xml\proceso.bat');

		} ///------------------------------------------------------ fin  de funcion que creo el xml , lo frima y lo envia
	crearxmlretencion($id_num_comprob_ret,$numeroderetencion,$id_client, $COM_NUM_COMPROB);
	echo '<script>
			window.open("xmlenviados/07_RETENCIONES/srienvioxml.php?nunf='.$numeroderetencion.'&idcomprobante='.$id_num_comprob_ret.'&direc=07_RETENCIONES/FIRMADOS","_blank");							
			history.back();
		 </script>';
	} // fin de la creacio y envio de XML
}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}

?>
