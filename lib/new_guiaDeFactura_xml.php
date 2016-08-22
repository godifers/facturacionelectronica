<?php 
session_start();
if ( isset($_SESSION['empresa'])) {
	include('phpconex.php');	
	include("phpconexcion.php");

	$idtFact=$_GET['idtFact'];
	$idtCond=$_GET['idtCond'];
	$DirPar=$_GET['DirPar'];
	$DirLleg=$_GET['DirLleg'];
	$fehLleg=$_GET['fehLleg'];
	$ident_us = $_GET['ident_us'];

	//print_r($_GET);
	//**************************inserta datos en la tabla de detalle de la guia ****************************
	$enlace =conectarbd();
	$cad_sp_inser_det_gia = "CALL SP_GENERAR_GUIA_DEFACT(".$idtCond.",'".utf8_decode(strtoupper($DirPar))."',
		'".utf8_decode(strtoupper($DirLleg))."', ".$idtFact.",'V','".$fehLleg."',".$_SESSION['empresa'].", ".$_SESSION['empresa'].",".$ident_us.")";
	$ejec_sp_inser_guia = mysql_query($cad_sp_inser_det_gia);
	echo $cad_sp_inser_det_gia;
	mysql_close($enlace);
	$res_sp_guias = mysql_fetch_row($ejec_sp_inser_guia);
	$num_guia = $res_sp_guias[0];
	$idt_comp_newGuia = $res_sp_guias[1];
	$cant_pro_newGuia  = $res_sp_guias[2];
	//***********************************************fin de insertar datos en la tabla detalle guia********

	// ******************************************** funcion que genera el xml dgia de remision************************************
	function  generarXMLguiarem ($num_gia_rem, $numcomprb1 , $cant_prod_env){

		$enlace = conectarbd();
		$cad_detalle_guia = "SELECT CON_NOMBRE_RZ , CON_ID_RUC, CON_PLACAS, CON_CHASIS, CON_MARCA, CON_DESCRIPCION , CON_MODELO ,
			DETG_LUGAR_PARTIDA, DETG_LUGAR_DESTINO, DETG_TIPO_GUA, DETG_FECHA_SALIDA, DETG_FECHA_LLEGADA
			from t_detalle_guias, t_conductores where IDT_CONDUCTORES = DETG_FK_IDT_CONDUCTOR AND DETG_FK_IDT_COMPROBANTE=".$numcomprb1;
		$ejec_Cad_detalle_guia = mysql_query($cad_detalle_guia);
		//echo $cad_detalle_guia.'<br>';
		mysql_close($enlace);
		$res_detalle_guai = mysql_fetch_row($ejec_Cad_detalle_guia);		
		$CON_NOMBRE_RZ= $res_detalle_guai[0];// CON_NOMBRE_RZ
		$CON_ID_RUC= $res_detalle_guai[1];// CON_ID_RUC
		$CON_PLACAS= $res_detalle_guai[2];// CON_PLACAS
		$CON_CHASIS= $res_detalle_guai[3];// CON_CHASIS
		$CON_MARCA= $res_detalle_guai[4];// CON_MARCA
		$CON_DESCRIPCION= $res_detalle_guai[5];// CON_DESCRIPCION
		$CON_MODELO= $res_detalle_guai[6];// CON_MODELO
		$DETG_LUGAR_PARTIDA= utf8_encode($res_detalle_guai[7]);// DETG_LUGAR_PARTIDA
		$DETG_LUGAR_DESTINO= utf8_encode($res_detalle_guai[8]);// DETG_LUGAR_DESTINO
		$DETG_TIPO_GUA= $res_detalle_guai[9];// DETG_TIPO_GUA
		$DETG_FECHA_SALIDA= $res_detalle_guai[10];// DETG_FECHA_SALIDA
		$DETG_FECHA_LLEGADA= $res_detalle_guai[11];// DETG_FECHA_LLEGADA
		

		$enlace = conectarbd();
		$cad_destinatario ="SELECT CP_NOMBRE,CP_APELLIDO,CP_CEDULA,CP_TELEFONO,CP_MAIL, CP_DIRECCION ,COM_AMBIENTE
		from t_comprobante , t_client_provee where COM_FKID_CLI_PROV= IDT_CLIENT_PROVEE and IDT_COMPROBANTE= ".$numcomprb1;
		$ejec_cad_destinatario = mysql_query($cad_destinatario);
		mysql_close($enlace);
		$res_desninat = mysql_fetch_row($ejec_cad_destinatario);
		$nombres_destinata = $res_desninat[0].' '.$res_desninat[1];
		$ruc_ced_destinata = $res_desninat[2];
		$telefon_destinata = $res_desninat[3];
		$mail_detaniatario = $res_desninat[4];
		$direcio_destinata = $res_desninat[5];
		$amb = $res_desninat[6];
		//echo $amb.' ambiente<br>';
		$enlace = conectarbd();
		$queryemp ='SELECT EMP_RAZON_SOCIAL, EMP_RUC, EMP_DIRECCION_MATRIZ, EMP_TELEFONO, EMP_NOMBRE,EMP_PRIMER_FACT, 
					EMP_NUMERO_CONTRIB, EMP_OBLIGADO_LLEVAR_CONTAB, EMP_DIR_LOCAL
					FROM t_empresa WHERE IDT_EMPRESA='.$_SESSION['empresa'].' limit 1';
		//echo $queryemp;
		$ejeccademp =mysql_query($queryemp);
		mysql_close($enlace);
		$resemp = mysql_fetch_row($ejeccademp);

		$razsoc_emp= $resemp[0];
		$ruc_emp= $resemp[1];
		$dir_matriz_emp= $resemp[2];
		$tel_emp= $resemp[3];
		$nom_emp= $resemp[4];
		$prf_emp= $resemp[5];
		$num_contib = $resemp[6];
		$obligadoContab = $resemp[7];
		$dir_local_emp = $resemp[8];
		//echo $DETG_FECHA_SALIDA.'<br>';
 		$fecha_env= date('d/m/Y',strtotime(str_replace('/', '-', $DETG_FECHA_SALIDA)));
		$fechcadena = str_replace('/', '',$fecha_env);
		//echo $fechcadena.'<br>';
		$cadena49 = $fechcadena.'06'.$ruc_emp.$amb.$num_gia_rem.'12345678'.'1';
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
		WHERE IDT_COMPROBANTE= ".$numcomprb1."  AND  COM_NUM_COMPROB='".$num_gia_rem."'";
		$ejec_cad_update = mysql_query($cad_update_clave_acceso);
		mysql_close($enlace);
		//echo '<br>cadena49:::'.$cadena49;


		$xml = new DomDocument('1.0', 'UTF-8');

		$guiaRemision = $xml->createElement('guiaRemision');
		$guiaRemision = $xml->appendChild($guiaRemision);
		$guiaRemision ->setAttribute('id', 'comprobante');
		$guiaRemision ->setAttribute('version', '1.0.0');

		$infoTributaria = $xml->createElement('infoTributaria');
		$infoTributaria = $guiaRemision->appendChild($infoTributaria);

			$ambiente = $xml->createElement('ambiente',$amb);
			$ambiente = $infoTributaria->appendChild($ambiente);

			$tipoEmision = $xml->createElement('tipoEmision','1');
			$tipoEmision = $infoTributaria->appendChild($tipoEmision);

			$razonSocial = $xml->createElement('razonSocial',$razsoc_emp);
			$razonSocial = $infoTributaria->appendChild($razonSocial);

			$nombreComercial = $xml->createElement('nombreComercial',$nom_emp);
			$nombreComercial = $infoTributaria->appendChild($nombreComercial);

			$ruc = $xml->createElement('ruc',$ruc_emp);
			$ruc = $infoTributaria->appendChild($ruc);

			$claveAcceso = $xml->createElement('claveAcceso',$cadena49);
			$claveAcceso = $infoTributaria->appendChild($claveAcceso);

			$codDoc = $xml->createElement('codDoc','06');
			$codDoc = $infoTributaria->appendChild($codDoc);

			$n1=substr($num_gia_rem,0,3);
			$n2=substr($num_gia_rem,3,3);
			$n3=substr($num_gia_rem,6,9);

			$estab = $xml->createElement('estab',$n1);
			$estab = $infoTributaria->appendChild($estab);

			$ptoEmi = $xml->createElement('ptoEmi',$n2);
			$ptoEmi = $infoTributaria->appendChild($ptoEmi);

			$secuencial = $xml->createElement('secuencial',$n3);
			$secuencial = $infoTributaria->appendChild($secuencial);

			$dirMatriz = $xml->createElement('dirMatriz',$dir_matriz_emp);
			$dirMatriz = $infoTributaria->appendChild($dirMatriz);

		$infoGuiaRemision = $xml->createElement('infoGuiaRemision');
		$infoGuiaRemision = $guiaRemision->appendChild($infoGuiaRemision);

			$dirEstablecimiento = $xml->createElement('dirEstablecimiento',$dir_local_emp);
			$dirEstablecimiento = $infoGuiaRemision->appendChild($dirEstablecimiento);

			$dirPartida = $xml->createElement('dirPartida',$DETG_LUGAR_PARTIDA);
			$dirPartida = $infoGuiaRemision->appendChild($dirPartida);

			$razonSocialTransportista = $xml->createElement('razonSocialTransportista',$CON_NOMBRE_RZ);
			$razonSocialTransportista = $infoGuiaRemision->appendChild($razonSocialTransportista);

			$lon_ruc_cond = strlen($CON_ID_RUC);
			if ($lon_ruc_cond==13){
				$tipo_ruc_id = '04';
			}elseif ($lon_ruc_cond==10) {
				$tipo_ruc_id = '05';
			}else{
				$tipo_ruc_id = '05';
			}

			$tipoIdentificacionTransportista = $xml->createElement('tipoIdentificacionTransportista',$tipo_ruc_id);
			$tipoIdentificacionTransportista = $infoGuiaRemision->appendChild($tipoIdentificacionTransportista);

			$rucTransportista = $xml->createElement('rucTransportista',$CON_ID_RUC);
			$rucTransportista = $infoGuiaRemision->appendChild($rucTransportista);

			$fecha_llegada1 = date('d/m/Y',strtotime(str_replace('/', '-', $DETG_FECHA_LLEGADA)));
			$fecha_envio1 = date('d/m/Y',strtotime(str_replace('/', '-', $DETG_FECHA_SALIDA)));

			$fechaIniTransporte = $xml->createElement('fechaIniTransporte',$fecha_envio1);
			$fechaIniTransporte = $infoGuiaRemision->appendChild($fechaIniTransporte);

			$fechaFinTransporte = $xml->createElement('fechaFinTransporte',$fecha_llegada1);
			$fechaFinTransporte = $infoGuiaRemision->appendChild($fechaFinTransporte);

			$placa = $xml->createElement('placa',$CON_PLACAS);
			$placa = $infoGuiaRemision->appendChild($placa);

		$destinatarios = $xml->createElement('destinatarios');
		$destinatarios = $guiaRemision->appendChild($destinatarios);

			$destinatario = $xml->createElement('destinatario');
			$destinatario = $destinatarios->appendChild($destinatario);

				$identificacionDestinatario = $xml->createElement('identificacionDestinatario',$ruc_ced_destinata);
				$identificacionDestinatario = $destinatario->appendChild($identificacionDestinatario);

				$razonSocialDestinatario = $xml->createElement('razonSocialDestinatario',$nombres_destinata);
				$razonSocialDestinatario = $destinatario->appendChild($razonSocialDestinatario);

				$dirDestinatario = $xml->createElement('dirDestinatario',$direcio_destinata);
				$dirDestinatario = $destinatario->appendChild($dirDestinatario);

				$motivoTraslado = $xml->createElement('motivoTraslado','TRASPASO');
				$motivoTraslado = $destinatario->appendChild($motivoTraslado);

				/* // en caso de gias de remision sin definir  por dicumento del sri
				$codEstabDestino = $xml->createElement('codEstabDestino','002');
				$codEstabDestino = $destinatario->appendChild($codEstabDestino);*/

				$ruta = $xml->createElement('ruta',$DETG_LUGAR_PARTIDA.'-'.$DETG_LUGAR_DESTINO);
				$ruta = $destinatario->appendChild($ruta);

				$detalles = $xml->createElement('detalles');
				$detalles = $destinatario->appendChild($detalles);

					$detalle = $xml->createElement('detalle');
					$detalle = $detalles->appendChild($detalle);

						/*$codigoInterno = $xml->createElement('codigoInterno','125BJC-02');// opcional
						$codigoInterno = $detalle->appendChild($codigoInterno);*/

						$descripcion = $xml->createElement('descripcion',$CON_DESCRIPCION);
						$descripcion = $detalle->appendChild($descripcion);

						$cantidad = $xml->createElement('cantidad',$cant_prod_env);
						$cantidad = $detalle->appendChild($cantidad);

						$detallesAdicionales = $xml->createElement('detallesAdicionales');
						$detallesAdicionales = $detalle->appendChild($detallesAdicionales);

							$detAdicional = $xml->createElement('detAdicional');
							$detAdicional = $detallesAdicionales->appendChild($detAdicional);
							$detAdicional ->setAttribute('nombre','Marca');
							$detAdicional ->setAttribute('valor', $CON_MARCA);

							$detAdicional = $xml->createElement('detAdicional');
							$detAdicional = $detallesAdicionales->appendChild($detAdicional);
							$detAdicional ->setAttribute('nombre','Modelo');
							$detAdicional ->setAttribute('valor', $CON_MODELO);

							$detAdicional = $xml->createElement('detAdicional');
							$detAdicional = $detallesAdicionales->appendChild($detAdicional);
							$detAdicional ->setAttribute('nombre','Chasis');
							$detAdicional ->setAttribute('valor', $CON_CHASIS);

		$infoAdicional = $xml->createElement('infoAdicional');
		$infoAdicional = $guiaRemision->appendChild($infoAdicional);

			$campoAdicional = $xml->createElement('campoAdicional',$telefon_destinata);
			$campoAdicional = $infoAdicional->appendChild($campoAdicional);
			$campoAdicional ->setAttribute('nombre', 'TELEFONO');		

			$campoAdicional = $xml->createElement('campoAdicional',$mail_detaniatario);
			$campoAdicional = $infoAdicional->appendChild($campoAdicional);
			$campoAdicional ->setAttribute('nombre', 'Email');

		$xml->formatOutput = true;
	    $el_xml = $xml->saveXML();
	    $xml->save("C:/xml/04_GUIAS_DE_REM/".$num_gia_rem.".xml");   
	    $xml->save("C:/xml/04_GUIAS_DE_REM/RESPALDOS/".$num_gia_rem.".xml");

	}
	// /**************************************************FIN DE funcion que genera el xml dgia de remision************

	//---------------------------------------------------------firma de XML-----------------------------------------------------------
	function frimar_xml_guia($num_guia){
		$file=fopen("C:/xml/firmap12/proceso.bat","w") or die("Problemas");
		//vamos añadiendo el contenido
		fputs($file,"start C:/xml/firmap12/firmap12.exe c:/xml/04_GUIAS_DE_REM/".$num_guia.".xml c:/xml/04_GUIAS_DE_REM/FIRMADOS/".$num_guia.".xml c:/xml/luis_gerardo_tipaz_piarpuezan.p12 Carolina2000");
		fclose($file);
		exec('C:\xml\firmap12\proceso.bat');
	}
	//----------------------------------------------------fin de firma de XML de gias de remision--------------------------------------------	
	
	generarXMLguiarem($num_guia, $idt_comp_newGuia, $cant_pro_newGuia );
	frimar_xml_guia($num_guia);
	echo '<script>
		window.location="xmlenviados/04_GUIAS_DE_REM/srienvioxml.php?nunf='.$num_guia.'&idcomprobante='.$idt_comp_newGuia.'&direc=04_GUIAS_DE_REM/FIRMADOS";			
	 </script>';	
}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location=../'index.php';
		</script>";
}	
?>
