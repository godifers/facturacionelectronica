<?php 
session_start();
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	include('phpconex.php');
	
	$c_hdidcliente = $_POST['c_hdidcliente'];
	$c_ratiotipo = $_POST['c_ratiotipo'];
	$c_num_fact = $_POST['c_num_fact'];
	$formapago = $_POST['c_formapago'];
	$c_creddipo = $_POST['c_creddipo'];
	$fechaventa = $_POST['c_fechcventa'];
	$plazo = $_POST['c_plazo'];
	$fechapag = $_POST['c_fechpago'];
	$observa = $_POST['c_observa'];
	$relacional = $_POST['c_relacional'];
	$subtotal= $_POST['c_subtotal'];
	$base0= $_POST['c_base0'];
	$base12= $_POST['c_base12'];
	$iva= $_POST['c_iva'];
	$totfactura= $_POST['c_totfactura'];
	//------
	$c_cod_cond_fac = $_POST['c_cod_cond_fac'];
	$c_direc_partida = $_POST['c_direc_partida'];
	$c_direc_llegada = $_POST['c_direc_llegada'];
	$c_ruc_cond_fact = $_POST['c_ruc_cond_fact'];
	$c_fecha_llegada_guia = $_POST['c_fecha_llegada_guia'];
	$c_nombr_cond_fac=$_POST['c_nombr_cond_fac'];
	$c_palca_fact=$_POST['c_palca_fact'];
	$c_descrip_fac=$_POST['c_descrip_fac'];

	$c_sumcompra0 = $_POST['c_sumcompra0'];
	$c_sumcompra12 = $_POST['c_sumcompra12'];
	//print_r($_POST);
	//echo 'id cliente : ->'.$c_hdidcliente;

	$newfechapag = date('Y/m/d', strtotime(str_replace('/', '-', $fechapag)));
	$fechaventa1 = date('d/m/Y',strtotime(str_replace('/', '-', $fechaventa)));
	$fech = str_replace('/', '', $fechaventa1);
	//echo $fech."<br>";
	//echo 'tipo de venta es ->'.$c_ratiotipo.'<br>';
	$enlace = conectarbd();
	$call_sp_guardarventa ="CALL bd_facelectronica.SP_GUARDAR_VENTA(".$c_hdidcliente.", ".$subtotal.",".$base0.",".$base12." ,".$iva.",".$totfactura.",
	'". $relacional."', ".$formapago." ,".$_SESSION['id_user'].", '".$fechaventa."', ".$plazo.", ".$_SESSION['empresa'].", ".$_SESSION['empresa'].",
	 '".$observa."', '".$newfechapag."','".$c_ratiotipo ."',".$c_sumcompra0.",".$c_sumcompra12.")";

	//echo $call_sp_guardarventa."<br>";
	$query =mysql_query($call_sp_guardarventa);		
	mysql_close($enlace);
	$respuestaventa = mysql_fetch_row($query);
	$idt_comprob= $respuestaventa[0]; //id_comprobante de la nueva fila 
	$res_num_fact_gui= $respuestaventa[1]; //numero de ultima factura creada
	$identificador = $respuestaventa[2]; // 1 es factura ,2 es guia
	$resp_ambiente  = $respuestaventa[3];

	//echo 'id coomprobante->'.$idt_comprob.'<br>';
	//echo 'numero de factura o guia ->'.$res_num_fact_gui.'<br>';
	//echo 'identificador ->'.$identificador.'<br>';
	$cantida_prodcutos =0;
	if(is_array($_POST['c_codidet'])) {
		 while(list($key,$codprod) = each($_POST['c_codidet']) and list($key,$cant) = each($_POST['c_cant']) 
		 	and list($key,$vunit) = each($_POST['c_vuni']) and list($key,$vtot) = each($_POST['c_vtot']) ) 
		{  	    		
			$enlace = conectarbd();	    		
			$iser_detall_venta="CALL SP_GUARDAR_PRROD('".$codprod."', ".$cant.", ".$vunit.", ".$vtot.", 
				'".$c_ratiotipo."' ,".$_SESSION['empresa'].", ".$_SESSION['empresa'].",".$idt_comprob." , 
				'".$res_num_fact_gui."',0 ,0 ,0 , 0,".$c_hdidcliente.")";
			//echo $iser_detall_venta;
			$res_inser_serv=mysql_query($iser_detall_venta) or die(mysql_error());
			mysql_close($enlace);

			$cantida_prodcutos=$cantida_prodcutos+1;
		 }
	}
	

	function crearxmlventa($numfact, $idt_comprob, $fechcadena, $fechaventa1 ,$subtotal_fact ,$base0_fact, $base12_fact, $iva_fact, $totfactura_fact, $tipo_doc , $amb){	
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

		$enlace = conectarbd();
		$cad_update_clave_acceso = "UPDATE t_comprobante SET COM_CLAVEACESO_SRI = '".$cadena49."' 
		WHERE IDT_COMPROBANTE= ".$idt_comprob."  AND  COM_NUM_COMPROB='".$numfact."'";
		$ejec_cad_update = mysql_query($cad_update_clave_acceso);
		mysql_close($enlace);
		//echo '<br>cadena49:::'.$cadena49;

		$xml = new DomDocument('1.0', 'UTF-8');

		$factura = $xml->createElement('factura');
		$factura = $xml->appendChild($factura);
		$factura ->setAttribute('id', 'comprobante');
		$factura ->setAttribute('version', '1.0.0');

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

			$enlace = conectarbd();
			$cadventa ="SELECT CP_TIPO_ID,CP_NOMBRE,CP_APELLIDO,CP_CEDULA,COM_VAL_SUBT ,CP_DIRECCION,CP_MAIL,CP_TELEFONO,COM_FKID_FORMAPAGO
			FROM t_comprobante ,t_client_provee where COM_EPRESA=".$_SESSION['empresa']." AND CP_EMPRESA=".$_SESSION['empresa']." AND COM_FKID_CLI_PROV=IDT_CLIENT_PROVEE 
			and IDT_COMPROBANTE=".$idt_comprob." AND COM_TIPO_COMPR='V'";
			//echo $cadventa;
			$ejc_cadventa =mysql_query($cadventa);
			mysql_close($enlace);

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

				$totalImpuesto = $xml->createElement('totalImpuesto');
				$totalImpuesto = $totalConImpuestos->appendChild($totalImpuesto);

					$codigo = $xml->createElement('codigo','2');
					$codigo = $totalImpuesto->appendChild($codigo);

					//echo $iva_fact;
					if ($iva_fact==0) {
						$porcen_iva = 0;
						$tarifaiva= 0;
					} else {
						$porcen_iva = 2;
						$tarifaiva= 12;
					}		

					$suma_bases_fact = $base12_fact + $base0_fact ;

					$codigoPorcentaje = $xml->createElement('codigoPorcentaje',$porcen_iva);
					$codigoPorcentaje = $totalImpuesto->appendChild($codigoPorcentaje);

					$baseImponible = $xml->createElement('baseImponible',$suma_bases_fact);
					$baseImponible = $totalImpuesto->appendChild($baseImponible);

					$tarifa = $xml->createElement('tarifa',$tarifaiva);
					$tarifa = $totalImpuesto->appendChild($tarifa);

					$valor = $xml->createElement('valor',$iva_fact);
					$valor = $totalImpuesto->appendChild($valor);

			$propina = $xml->createElement('propina','0.00');
			$propina = $infoFactura->appendChild($propina);

			$iporte = $suma_bases_fact + $iva_fact;

			$importeTotal = $xml->createElement('importeTotal',$iporte);
			$importeTotal = $infoFactura->appendChild($importeTotal);

			$moneda = $xml->createElement('moneda','DOLAR');
			$moneda = $infoFactura->appendChild($moneda);

		$detalles = $xml->createElement('detalles');
		$detalles = $factura->appendChild($detalles);

		$enlace = conectarbd();
		$caddetalleventa ="SELECT DET_FK_IDPROD,PR_DETALLE,PR_PRESENTACION,DET_CANTIDAD,DET_VAL_UNIT,DET_VAL_TOT ,PR_IMPUESTO
		FROM t_detalles, t_prodcutos
		where DET_EMP = ".$_SESSION['empresa']." AND DET_FK_IDCOMPROB=".$idt_comprob." AND 
		DET_NUM_FACTU='".$numfact."' AND DET_FK_IDPROD= PR_COD_PROD and DET_TIPO_TRNS='V'  AND PR_EMPRESA = ".$_SESSION['empresa'];
		$eje_caddetalleventa = mysql_query($caddetalleventa);
		mysql_close($enlace);

		while($resdetalles=mysql_fetch_array($eje_caddetalleventa)) 
		{
		//-----------------------------------------------------------------------------------------
			

			$detalle = $xml->createElement('detalle');
			$detalle = $detalles->appendChild($detalle);

				$codigoPrincipal = $xml->createElement('codigoPrincipal',$resdetalles['DET_FK_IDPROD']);
				$codigoPrincipal = $detalle->appendChild($codigoPrincipal);

				$codigoAuxiliar = $xml->createElement('codigoAuxiliar',$resdetalles['DET_FK_IDPROD']);
				$codigoAuxiliar = $detalle->appendChild($codigoAuxiliar);

				$descripcion = $xml->createElement('descripcion',$resdetalles['PR_DETALLE'].$resdetalles['PR_PRESENTACION']);
				$descripcion = $detalle->appendChild($descripcion);

				$cantidad = $xml->createElement('cantidad',$resdetalles['DET_CANTIDAD']);
				$cantidad = $detalle->appendChild($cantidad);

				if ($resdetalles['PR_IMPUESTO']==1) {
					$imp =2;
					$tar ='12.00';

					$v_unit =  $resdetalles['DET_VAL_UNIT'] / 1.12 ;
					$v_tota =  $resdetalles['DET_VAL_TOT'] / 1.12 ;
					
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

				$precioUnitario = $xml->createElement('precioUnitario',$v_unit);
				$precioUnitario = $detalle->appendChild($precioUnitario);

				$descuento = $xml->createElement('descuento','0.00');
				$descuento = $detalle->appendChild($descuento);

				$precioTotalSinImpuesto = $xml->createElement('precioTotalSinImpuesto',$v_tota);
				$precioTotalSinImpuesto = $detalle->appendChild($precioTotalSinImpuesto);

				$impuestos = $xml->createElement('impuestos');
				$impuestos = $detalle->appendChild($impuestos);

					$impuesto = $xml->createElement('impuesto');
					$impuesto = $impuestos->appendChild($impuesto);

						$codigo = $xml->createElement('codigo','2');
						$codigo = $impuesto->appendChild($codigo);				

						$codigoPorcentaje = $xml->createElement('codigoPorcentaje',$imp);
						$codigoPorcentaje = $impuesto->appendChild($codigoPorcentaje);
						
						$tarifa = $xml->createElement('tarifa',$tar);
						$tarifa = $impuesto->appendChild($tarifa);
						
						$baseImponible = $xml->createElement('baseImponible',$v_tota);
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
	/// ############################################## fin de crear el xml #################################################################################
	// *****************************************************************************************************************************************************
	// ***************************************************** funcion que genera el xml dgia de remision*****************************************************
	function  generarXMLguiarem ($num_gia_rem, $numcomprb1, $fechcadena, $fechaventa1 , $tipo_doc , $amb, $id_conduc, $dir_envi, $dir_llega,$fecha_llegada, $ruc_conduc, $nom_condu, $placa_vh, $descrp_vh,$idt_clie_a_eviar,$cant_prod_env){
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

			$dirPartida = $xml->createElement('dirPartida',$dir_envi);
			$dirPartida = $infoGuiaRemision->appendChild($dirPartida);

			$razonSocialTransportista = $xml->createElement('razonSocialTransportista',$nom_condu);
			$razonSocialTransportista = $infoGuiaRemision->appendChild($razonSocialTransportista);

			$lon_ruc_cond = strlen($ruc_conduc);
			if ($lon_ruc_cond==13){
				$tipo_ruc_id = '04';
			}elseif ($lon_ruc_cond==10) {
				$tipo_ruc_id = '05';
			}

			$tipoIdentificacionTransportista = $xml->createElement('tipoIdentificacionTransportista',$tipo_ruc_id);
			$tipoIdentificacionTransportista = $infoGuiaRemision->appendChild($tipoIdentificacionTransportista);

			$rucTransportista = $xml->createElement('rucTransportista',$ruc_conduc);
			$rucTransportista = $infoGuiaRemision->appendChild($rucTransportista);

			$fecha_llegada1 = date('d/m/Y',strtotime(str_replace('/', '-', $fecha_llegada)));

			$fechaIniTransporte = $xml->createElement('fechaIniTransporte',$fechaventa1);
			$fechaIniTransporte = $infoGuiaRemision->appendChild($fechaIniTransporte);

			$fechaFinTransporte = $xml->createElement('fechaFinTransporte',$fecha_llegada1);
			$fechaFinTransporte = $infoGuiaRemision->appendChild($fechaFinTransporte);

			$placa = $xml->createElement('placa',$placa_vh);
			$placa = $infoGuiaRemision->appendChild($placa);

		$enlace = conectarbd();
		$cad_destinatario ="SELECT CP_NOMBRE,CP_APELLIDO,CP_CEDULA,CP_TELEFONO,CP_MAIL, CP_DIRECCION FROM t_client_provee WHERE CP_EMPRESA=".$_SESSION['empresa']." AND   IDT_CLIENT_PROVEE =".$idt_clie_a_eviar;
		$ejec_cad_destinatario = mysql_query($cad_destinatario);
		mysql_close($enlace);
		$res_desninat = mysql_fetch_row($ejec_cad_destinatario);
		$nombres_destinata = $res_desninat[0].' '.$res_desninat[1];
		$ruc_ced_destinata = $res_desninat[2];
		$telefon_destinata = $res_desninat[3];
		$mail_detaniatario = $res_desninat[4];
		$direcio_destinata = $res_desninat[5];

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

				$codEstabDestino = $xml->createElement('codEstabDestino','002');
				$codEstabDestino = $destinatario->appendChild($codEstabDestino);

				$ruta = $xml->createElement('ruta',$dir_envi.'-'.$dir_llega);
				$ruta = $destinatario->appendChild($ruta);

				$detalles = $xml->createElement('detalles');
				$detalles = $destinatario->appendChild($detalles);

					$detalle = $xml->createElement('detalle');
					$detalle = $detalles->appendChild($detalle);

						$codigoInterno = $xml->createElement('codigoInterno','125BJC-02');
						$codigoInterno = $detalle->appendChild($codigoInterno);

						$descripcion = $xml->createElement('descripcion',$descrp_vh);
						$descripcion = $detalle->appendChild($descripcion);

						$cantidad = $xml->createElement('cantidad',$cant_prod_env);
						$cantidad = $detalle->appendChild($cantidad);

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
	// /**************************************************FIN DE funcion que genera el xml dgia de remision******************************************************

	//---------------------------------------------------------firma de XML-----------------------------------------------------------
	function frimar_xml($res_num_fact_gui){
		$file=fopen("C:/xml/firmap12/proceso.bat","w") or die("Problemas");
		//vamos añadiendo el contenido
		fputs($file,"start C:/xml/firmap12/firmap12.exe c:/xml/01_FACTURAS/".$res_num_fact_gui.".xml c:/xml/01_FACTURAS/FIRMADOS/".$res_num_fact_gui.".xml c:/xml/luis_gerardo_tipaz_piarpuezan.p12 Carolina2000");
		fclose($file);
		exec('C:\xml\firmap12\proceso.bat');
	}

	function frimar_xml_guia($res_num_fact_gui){
		$file=fopen("C:/xml/firmap12/proceso.bat","w") or die("Problemas");
		//vamos añadiendo el contenido
		fputs($file,"start C:/xml/firmap12/firmap12.exe c:/xml/04_GUIAS_DE_REM/".$res_num_fact_gui.".xml c:/xml/04_GUIAS_DE_REM/FIRMADOS/".$res_num_fact_gui.".xml c:/xml/luis_gerardo_tipaz_piarpuezan.p12 Carolina2000");
		fclose($file);
		exec('C:\xml\firmap12\proceso.bat');
	}

	
	if ($c_ratiotipo=='V'){
		crearxmlventa($res_num_fact_gui, $idt_comprob , $fech, $fechaventa ,$subtotal ,$base0, $base12, $iva, $totfactura, $c_ratiotipo, $resp_ambiente );
		frimar_xml($res_num_fact_gui);
		echo '<script>
			window.location="xmlenviados/01_FACTURAS/srienvioxml.php?nunf='.$res_num_fact_gui.'&idcomprobante='.$idt_comprob.'&direc=01_FACTURAS/FIRMADOS";				
		 </script>';
		 //window.location="../inicio.php?id=frm_impresion.php&idcomp='.$idt_comprob.'&numf='.$res_num_fact_gui.'";
		 //window.open("xmlenviados/01_FACTURAS/srienvioxml.php?nunf='.$res_num_fact_gui.'&idcomprobante='.$idt_comprob.'&direc=01_FACTURAS/FIRMADOS","_blank");
	}elseif ($c_ratiotipo=='G'){
		generarXMLguiarem($res_num_fact_gui, $idt_comprob, $fech, $fechaventa1 , $c_ratiotipo , $resp_ambiente, $c_cod_cond_fac, 
			$c_direc_partida, $c_direc_llegada,$c_fecha_llegada_guia, $c_ruc_cond_fact, $c_nombr_cond_fac, $c_palca_fact, 
			$c_descrip_fac,$c_hdidcliente,$cantida_prodcutos);
		frimar_xml_guia($res_num_fact_gui);
		echo '<script>
			window.location="xmlenviados/04_GUIAS_DE_REM/srienvioxml.php?nunf='.$res_num_fact_gui.'&idcomprobante='.$idt_comprob.'&direc=04_GUIAS_DE_REM/FIRMADOS";			
		 </script>';
		 //	window.location="../inicio.php?id=frm_impresion.php&idcomp='.$idt_comprob.'&numf='.$res_num_fact_gui.'";
		 //window.open("xmlenviados/04_GUIAS_DE_REM/srienvioxml.php?nunf='.$res_num_fact_gui.'&idcomprobante='.$idt_comprob.'&direc=04_GUIAS_DE_REM/FIRMADOS","_blank");
	}


	//--------------------------------------------------------------------------------------------------------------------------------

	
}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
}	
?>
