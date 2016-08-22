<?php 
session_start();
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
include("phpconexcion.php");
////$enlace = conectarbd();
$enlace = conectar_buscadores();
$enlace = conectar_buscadores();
$num_comp = $_GET['numfa'];
$id_compt = $_GET['idcomprobante'];
$tipo_com = $_GET['tipocomp'];
//echo $_SESSION['porcenIVA'];

/*IDT_COMPROBANTE, COM_TIPO_COMPR, COM_SUBTIPO_COMP, COM_SECUEN_TIPO, COM_NUM_COMPROB, COM_VAL_SUBT, COM_VAL_BASE0, COM_VAL_BASE12, 
COM_IVA, COM_TOT, COM_TOT_SIN_RET, COM_TOT_PAGO_COBR, COM_PARTEREL, COM_SUSTENTO_TRIB, COM_FKID_FORMAPAGO, COM_ABONO, COM_SALDO, 
COM_DOCAFECTADO, COM_FKID_DOCAFECT, COM_CLAVEACESO_SRI, COM_AUTORIZACION_SRI, COM_ESTADO_SIS, COM_ESTADO_CONTAB, COM_ESTADO_ATS_SRI, 
COM_ESTADO_PAGO, COM_ESTADO_SRI, COM_ESTADO_NULL, COM_MSN_SRI, COM_AMBIENTE, COM_OBSERV_TIPOTRANSAC, COM_OBSERV_GENRL, COM_FKID_CLI_PROV, 
COM_FKID_USER_CREA, COM_FKID_USER_EDIT, COM_FKID_USER_ANULA, COM_FEC_CREA, COM_FEC_EDIT, COM_FEC_ANULA, COM_FEC_ENVIO, COM_FEC_LLEGADA, 
COM_FEC_CORTE, COM_FEC_PAGO, COM_PLAZO, COM_EPRESA, COM_OFCINA,*/
$cad_coprobante = "SELECT COM_FEC_CREA,COM_VAL_SUBT,COM_VAL_BASE0,COM_VAL_BASE12,COM_IVA,COM_TOT,COM_AMBIENTE 
FROM t_comprobante where IDT_COMPROBANTE= ".$id_compt." AND COM_NUM_COMPROB='".$num_comp."' ";
$ejec_cad_comp = mysql_query($cad_coprobante);
//mysql_close($enlace);
$res_comprob = mysql_fetch_row($ejec_cad_comp);

$fechaventa= $res_comprob[0];;
$subtotal = $res_comprob[1];
$base0 = $res_comprob[2];
$base12 = $res_comprob[3];
$iva = $res_comprob[4];
$totfactura = $res_comprob[5];
$resp_ambiente = $res_comprob[6];
$c_ratiotipo = $tipo_com;

$fechaventa1 = date('d/m/Y',strtotime(str_replace('/', '-', $fechaventa)));
$fech = str_replace('/', '', $fechaventa1);

/*echo $fechaventa1;
echo $fech;*/

//crearxmlventa($num_comp, $id_compt , $fech, $fechaventa1 ,$subtotal ,$base0, $base12, $iva, $totfactura, $c_ratiotipo, $resp_ambiente );

function crearxmlventa($numfact, $idt_comprob, $fechcadena, $fechaventa1 ,$subtotal_fact ,$base0_fact, $base12_fact, $iva_fact, $totfactura_fact, $tipo_doc , $amb){	
		//$enlace = conectarbd();
		if (isset($_SESSION['porcenIVA'])) {
			if ($_SESSION['porcenIVA'] == 1.12) {
				$porcentIVA = 1.12;
				echo "12";
			} else {
				$porcentIVA = 1.14;
				echo "14";
			}
			
		} else {
			$porcentIVA = 1.12;
			echo "mooo";
		}

		$enlace = conectar_buscadores();
		$queryemp ='SELECT EMP_RAZON_SOCIAL, EMP_RUC, EMP_DIRECCION_MATRIZ, EMP_TELEFONO, EMP_NOMBRE,EMP_PRIMER_FACT, 
					EMP_NUMERO_CONTRIB, EMP_OBLIGADO_LLEVAR_CONTAB, EMP_DIR_LOCAL
					FROM t_empresa WHERE IDT_EMPRESA='.$_SESSION['empresa'].' limit 1';
		//echo $queryemp;
		$ejeccademp =mysql_query($queryemp);
		//mysql_close($enlace);
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


		$cadena49 = $fechcadena.'01'.$ruc_emp.$amb.$numfact.'12345678'.'1';
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

		//$enlace = conectarbd();
		$enlace = conectar_buscadores();
		$cad_update_clave_acceso = "UPDATE t_comprobante SET COM_CLAVEACESO_SRI = '".$cadena49."' 
		WHERE IDT_COMPROBANTE= ".$idt_comprob."  AND  COM_NUM_COMPROB='".$numfact."'";
		$ejec_cad_update = mysql_query($cad_update_clave_acceso);
		//mysql_close($enlace);
		//echo '<br>cadena49:::'.$cadena49;

		$xml = new DomDocument('1.0', 'UTF-8');

		$factura = $xml->createElement('factura');
		$factura = $xml->appendChild($factura);
		$factura ->setAttribute('id', 'comprobante');
		$factura ->setAttribute('version', '1.1.0');

		$infoTributaria = $xml->createElement('infoTributaria');
		$infoTributaria = $factura->appendChild($infoTributaria);

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

			$codDoc = $xml->createElement('codDoc','01');
			$codDoc = $infoTributaria->appendChild($codDoc);

			$n1=substr($numfact,0,3);
			$n2=substr($numfact,3,3);
			$n3=substr($numfact,6,9);

			$estab = $xml->createElement('estab',$n1);
			$estab = $infoTributaria->appendChild($estab);

			$ptoEmi = $xml->createElement('ptoEmi',$n2);
			$ptoEmi = $infoTributaria->appendChild($ptoEmi);

			$secuencial = $xml->createElement('secuencial',$n3);
			$secuencial = $infoTributaria->appendChild($secuencial);

			$dirMatriz = $xml->createElement('dirMatriz',$dir_matriz_emp);
			$dirMatriz = $infoTributaria->appendChild($dirMatriz);

		$infoFactura = $xml->createElement('infoFactura');
		$infoFactura = $factura->appendChild($infoFactura);

			$fechxml = date('d/m/Y', strtotime(str_replace('-', '/', $fechaventa1)));
			$fechaEmision = $xml->createElement('fechaEmision',$fechxml);
			$fechaEmision = $infoFactura->appendChild($fechaEmision);

			$dirEstablecimiento = $xml->createElement('dirEstablecimiento',$dir_local_emp);
			$dirEstablecimiento = $infoFactura->appendChild($dirEstablecimiento);

			/*$contribuyenteEspecial = $xml->createElement('contribuyenteEspecial',$num_contib);
			$contribuyenteEspecial = $infoFactura->appendChild($contribuyenteEspecial);*/

			$obligadoContabilidad = $xml->createElement('obligadoContabilidad',$obligadoContab);
			$obligadoContabilidad = $infoFactura->appendChild($obligadoContabilidad);

			//$enlace = conectarbd();
			$enlace = conectar_buscadores();
			$cadventa ="SELECT CP_TIPO_ID,CP_NOMBRE,CP_APELLIDO,CP_CEDULA,COM_VAL_SUBT ,CP_DIRECCION,CP_MAIL,CP_TELEFONO,COM_FKID_FORMAPAGO
			FROM t_comprobante ,t_client_provee where COM_EPRESA=".$_SESSION['empresa']."  AND COM_FKID_CLI_PROV=IDT_CLIENT_PROVEE 
			and IDT_COMPROBANTE=".$idt_comprob." AND COM_TIPO_COMPR='V'";
			//echo $cadventa;
			$ejc_cadventa =mysql_query($cadventa);
			//mysql_close($enlace);

			$resventa = mysql_fetch_row($ejc_cadventa);
			$tipoidencompra= $resventa[0];
			$nomcomprador= $resventa[1];
			$apecomprador= $resventa[2];
			$ruc_ced= $resventa[3];
			$subtota= $resventa[4];
			$dir_cli= $resventa[5];
			$mail_cli= $resventa[6];
			$telf_cli= $resventa[7];
			$formpago_fact= $resventa[8];

			/*echo $tipoidencompra.'<br>';
			echo $nomcomprador.'<br>';
			echo $apecomprador.'<br>';
			echo $ruc_ced.'<br>';
			echo $subtota.'<br>';
			echo $dir_cli.'<br>';
			echo $mail_cli.'<br>';
			echo $telf_cli.'<br>';*/
			
			if ($tipoidencompra==1) {
				$topoidcomprador='05';
			} else if($tipoidencompra==2){
				$topoidcomprador='04';
			} else if($tipoidencompra==3){
				$topoidcomprador='07';
			} else if($tipoidencompra==4){
				$topoidcomprador='06';
			}		

			$tipoIdentificacionComprador = $xml->createElement('tipoIdentificacionComprador',$topoidcomprador);
			$tipoIdentificacionComprador = $infoFactura->appendChild($tipoIdentificacionComprador);

			$razonSocialComprador = $xml->createElement('razonSocialComprador',utf8_decode($nomcomprador.' '.$apecomprador));
			$razonSocialComprador = $infoFactura->appendChild($razonSocialComprador);

			$identificacionComprador = $xml->createElement('identificacionComprador',$ruc_ced);
			$identificacionComprador = $infoFactura->appendChild($identificacionComprador);

			$totalSinImpuestos = $xml->createElement('totalSinImpuestos',$subtota);
			$totalSinImpuestos = $infoFactura->appendChild($totalSinImpuestos);

			$totalDescuento = $xml->createElement('totalDescuento','0.00');
			$totalDescuento = $infoFactura->appendChild($totalDescuento);

			/*$secuencial = $xml->createElement('secuencial','000072063');
			$secuencial = $infoFactura->appendChild($secuencial);*/

			$totalConImpuestos = $xml->createElement('totalConImpuestos');
			$totalConImpuestos = $infoFactura->appendChild($totalConImpuestos);

			if ($base12_fact > 0) {

				$totalImpuesto = $xml->createElement('totalImpuesto');
				$totalImpuesto = $totalConImpuestos->appendChild($totalImpuesto);

					$codigo = $xml->createElement('codigo','2');
					$codigo = $totalImpuesto->appendChild($codigo);					

					if ($_SESSION['porcenIVA'] == 1.12) {
						$porcen_iva = '2';
						$tarifaiva= '12';
					} else if ($_SESSION['porcenIVA'] == 1.14) {
						$porcen_iva = '3';
						$tarifaiva= '14';
					}					

					$codigoPorcentaje = $xml->createElement('codigoPorcentaje',$porcen_iva);
					$codigoPorcentaje = $totalImpuesto->appendChild($codigoPorcentaje);

					$descuentoAdicional = $xml->createElement('descuentoAdicional','0.00');
					$descuentoAdicional = $totalImpuesto->appendChild($descuentoAdicional);

					$baseImponible = $xml->createElement('baseImponible',$base12_fact);
					$baseImponible = $totalImpuesto->appendChild($baseImponible);

					/*$tarifa = $xml->createElement('tarifa',$tarifaiva);
					$tarifa = $totalImpuesto->appendChild($tarifa);*/

					$valor = $xml->createElement('valor',$iva_fact);
					$valor = $totalImpuesto->appendChild($valor);

			} 
			if( $base0_fact > 0) {

				$totalImpuesto = $xml->createElement('totalImpuesto');
				$totalImpuesto = $totalConImpuestos->appendChild($totalImpuesto);

					$codigo = $xml->createElement('codigo','2');
					$codigo = $totalImpuesto->appendChild($codigo);
				
					$porcen_iva = '0';
					$tarifaiva= '0';					

					$codigoPorcentaje = $xml->createElement('codigoPorcentaje',$porcen_iva);
					$codigoPorcentaje = $totalImpuesto->appendChild($codigoPorcentaje);

					$descuentoAdicional = $xml->createElement('descuentoAdicional','0.00');
					$descuentoAdicional = $totalImpuesto->appendChild($descuentoAdicional);

					$baseImponible = $xml->createElement('baseImponible',$base0_fact);
					$baseImponible = $totalImpuesto->appendChild($baseImponible);

					/*$tarifa = $xml->createElement('tarifa',$tarifaiva);
					$tarifa = $totalImpuesto->appendChild($tarifa);*/

					$valor = $xml->createElement('valor','0.00');
					$valor = $totalImpuesto->appendChild($valor);
			}
			
			$suma_bases_fact = $base12_fact + $base0_fact ;

			$propina = $xml->createElement('propina','0.00');
			$propina = $infoFactura->appendChild($propina);

			$iporte = $base12_fact + $base0_fact + $iva_fact;

			$importeTotal = $xml->createElement('importeTotal',str_replace(",", "", $iporte));
			$importeTotal = $infoFactura->appendChild($importeTotal);

			$moneda = $xml->createElement('moneda','DOLAR');
			$moneda = $infoFactura->appendChild($moneda);

		$detalles = $xml->createElement('detalles');
		$detalles = $factura->appendChild($detalles);

		//$enlace = conectarbd();
		$enlace = conectar_buscadores();
		$caddetalleventa ="SELECT DET_FK_IDPROD,PR_DETALLE,PR_PRESENTACION,DET_CANTIDAD,DET_VAL_UNIT,DET_VAL_TOT ,PR_IMPUESTO
		FROM t_detalles, t_prodcutos
		where DET_EMP = ".$_SESSION['empresa']." AND DET_FK_IDCOMPROB=".$idt_comprob." AND 
		DET_NUM_FACTU='".$numfact."' AND DET_FK_IDPROD= PR_COD_PROD and DET_TIPO_TRNS='V'  AND PR_EMPRESA = ".$_SESSION['empresa'];
		$eje_caddetalleventa = mysql_query($caddetalleventa);
		//mysql_close($enlace);

		while($resdetalles=mysql_fetch_array($eje_caddetalleventa)) 
		  {
		 //-----------------------------------------------------------------------------------------
			

			$detalle = $xml->createElement('detalle');
			$detalle = $detalles->appendChild($detalle);

				$codigoPrincipal = $xml->createElement('codigoPrincipal',$resdetalles['DET_FK_IDPROD']);
				$codigoPrincipal = $detalle->appendChild($codigoPrincipal);

				$codigoAuxiliar = $xml->createElement('codigoAuxiliar',$resdetalles['DET_FK_IDPROD']);
				$codigoAuxiliar = $detalle->appendChild($codigoAuxiliar);

				$descripcion = $xml->createElement('descripcion',utf8_encode($resdetalles['PR_DETALLE'].$resdetalles['PR_PRESENTACION']));
				$descripcion = $detalle->appendChild($descripcion);

				$cantidad = $xml->createElement('cantidad',$resdetalles['DET_CANTIDAD']);
				$cantidad = $detalle->appendChild($cantidad);

				if ($resdetalles['PR_IMPUESTO']==1) {
					
					if ($_SESSION['porcenIVA'] == 1.12) {
						$imp ='2';
						$tar ='12.00';
					} else if ($_SESSION['porcenIVA'] == 1.14) {
						$imp ='3';
						$tar ='14.00';
					}
					
					$v_unit =  $resdetalles['DET_VAL_UNIT'] / $porcentIVA;
					$v_tota =  $resdetalles['DET_VAL_TOT'] / $porcentIVA;
					
					$v_unit= number_format($v_unit,2);
					$v_tota= number_format($v_tota,2);

					//echo 'tci '.$resdetalles['DET_VAL_TOT'].'<br>';
					//echo "tsi ".$v_tota.'<br>';
				
					$ivaprod = number_format($resdetalles['DET_VAL_TOT'],2)-($v_tota);
					//echo "ivp ".$ivaprod.'<br>';
					$ivaprod = number_format($ivaprod,2);
				} else if($resdetalles['PR_IMPUESTO']==0) {
					$imp =0;
					$tar = '0.00';

					$v_unit =  $resdetalles['DET_VAL_UNIT'];
					$v_tota =  $resdetalles['DET_VAL_TOT'];

					$v_unit= number_format($v_unit,2);
					$v_tota= number_format($v_tota,2);

					$basimp = number_format($resdetalles['DET_VAL_TOT'],2);
					$ivaprod = 0.00;
				}	

				$precioUnitario = $xml->createElement('precioUnitario',str_replace(",", "", $v_unit));
				$precioUnitario = $detalle->appendChild($precioUnitario);

				$descuento = $xml->createElement('descuento','0.00');
				$descuento = $detalle->appendChild($descuento);

				$precioTotalSinImpuesto = $xml->createElement('precioTotalSinImpuesto',str_replace(",", "", $v_tota));
				$precioTotalSinImpuesto = $detalle->appendChild($precioTotalSinImpuesto);

				$impuestos = $xml->createElement('impuestos');
				$impuestos = $detalle->appendChild($impuestos);

					$impuesto = $xml->createElement('impuesto');
					$impuesto = $impuestos->appendChild($impuesto);

						$codigo = $xml->createElement('codigo','2');
						$codigo = $impuesto->appendChild($codigo);				

						$codigoPorcentaje = $xml->createElement('codigoPorcentaje',str_replace(",", "", $imp));
						$codigoPorcentaje = $impuesto->appendChild($codigoPorcentaje);
						
						$tarifa = $xml->createElement('tarifa',$tar);
						$tarifa = $impuesto->appendChild($tarifa);
						
						$baseImponible = $xml->createElement('baseImponible',str_replace(",", "", $v_tota));
						$baseImponible = $impuesto->appendChild($baseImponible);
						
						$valor = $xml->createElement('valor',$ivaprod);
						$valor = $impuesto->appendChild($valor);
		 //------------------------------------------------------------------------------------------            
		  }

		$infoAdicional = $xml->createElement('infoAdicional');
		$infoAdicional = $factura->appendChild($infoAdicional);	

			$campoAdicional = $xml->createElement('campoAdicional',utf8_decode($dir_cli));
			$campoAdicional = $infoAdicional->appendChild($campoAdicional);
			$campoAdicional ->setAttribute('nombre', 'Dirección');		

			if ($mail_cli=='' or is_null($mail_cli)) {
				$mail_cli='agromundotulcan.sc@yahoo.com';
			} 
			
			$campoAdicional = $xml->createElement('campoAdicional',$mail_cli);
			$campoAdicional = $infoAdicional->appendChild($campoAdicional);
			$campoAdicional ->setAttribute('nombre', 'Email');	

			if ($telf_cli=='') {
				$telf_cli='000000000';
			}	

			$campoAdicional = $xml->createElement('campoAdicional',$telf_cli);
			$campoAdicional = $infoAdicional->appendChild($campoAdicional);
			$campoAdicional ->setAttribute('nombre', 'Telf');		

			if ($formpago_fact==1) {
				$formpago1 ='Efectivo';
			} else if ($formpago_fact==2) {
				$formpago1 ='Credito';
			}
			
			$campoAdicional = $xml->createElement('campoAdicional',$formpago1 );
			$campoAdicional = $infoAdicional->appendChild($campoAdicional);
			$campoAdicional ->setAttribute('nombre', 'Forma de Pago');		

		$xml->formatOutput = true;
	    $el_xml = $xml->saveXML();
	    $xml->save("C:/xml/01_FACTURAS/".$numfact.".xml");   
	    $xml->save("C:/xml/01_FACTURAS/RESPALDOS/".$numfact.".xml");   
	}
	/// ############################################## fin de crear el xml #####################################################################

	function frimar_xml($res_num_fact_gui){
		$file=fopen("C:/xml/firmap12/proceso.bat","w") or die("Problemas");
		//vamos añadiendo el contenido
		fputs($file,"start C:/xml/firmap12/firmap12.exe c:/xml/01_FACTURAS/".$res_num_fact_gui.".xml c:/xml/01_FACTURAS/FIRMADOS/".$res_num_fact_gui.".xml c:/xml/luis_gerardo_tipaz_piarpuezan.p12 Carolina2000");
		fclose($file);
		exec('C:\xml\firmap12\proceso.bat');
	}

	if ($tipo_com=='V'){
		crearxmlventa($num_comp, $id_compt , $fech, $fechaventa ,$subtotal ,$base0, $base12, $iva, $totfactura, $tipo_com, $resp_ambiente );
		frimar_xml($num_comp);
		echo '<script>
			window.location="xmlenviados/01_FACTURAS/srienvioxml.php?nunf='.$num_comp.'&idcomprobante='.$id_compt.'&direc=01_FACTURAS/FIRMADOS";				
		 </script>';
	}elseif ($tipo_com=='G'){
		//generarXMLguiarem($num_comp, $id_compt, $fech, $fechaventa1 , $tipo_com , $resp_ambiente, $c_cod_cond_fac, 
		/*	$c_direc_partida, $c_direc_llegada,$c_fecha_llegada_guia, $c_ruc_cond_fact, $c_nombr_cond_fac, $c_palca_fact, 
			$c_descrip_fac,$c_hdidcliente,$cantida_prodcutos);
		frimar_xml_guia($res_num_fact_gui);
		echo '<script>
			window.location="xmlenviados/04_GUIAS_DE_REM/srienvioxml.php?nunf='.$res_num_fact_gui.'&idcomprobante='.$idt_comprob.'&direc=04_GUIAS_DE_REM/FIRMADOS";			
		 </script>';*/
		 echo '<script>
			window.location="../inicio.php?id=frm_impresion.php&idcomp='.$id_compt.'&numf='.$num_comp.'";
		 </script>';
		 	
		 //window.open("xmlenviados/04_GUIAS_DE_REM/srienvioxml.php?nunf='.$res_num_fact_gui.'&idcomprobante='.$idt_comprob.'&direc=04_GUIAS_DE_REM/FIRMADOS","_blank");
	}

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='../index.php';
		</script>";
}	
?>
