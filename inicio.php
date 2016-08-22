<?php  
session_start();
if (isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	
	if (isset($_SESSION['porcenIVA'])) {
		$porcentIVA = $_SESSION['porcenIVA']; 
	} else {
		$porcentIVA = '1.12';
	}
	/*include("lib/phpconexcion.php");
	$enlace = conectar_buscadores();
	$cadDatEmp= "SELECT EMP_IMPUESTO FROM t_empresa WHERE IDT_EMPRESA=".$_SESSION['empresa'];
	$ejeCadDatEmp = mysql_query($cadDatEmp);*/

	if (isset($_GET['id'])) {
		$tag=$_GET['id'];
	} 
	else{
		$tag="home.php";
	}

	?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<link type="image/x-icon" href="img/favicon.png" rel="shortcut icon"/>
	<title><?php echo $_SESSION['nom_emp']; ?></title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/inicio.css">
</head>
<body onload="fachatra('<?php echo $_SESSION['empresa']; ?>');">
	<header>
		<img src="img/logo.png" alt="" style="width:250px;margin:1px 0 1px 30px;">
		<div class="cl_fechatra" style="display:inline-block;margin:0 0 0 10px; width:600px; height:66px;position:absolute;">
			<h2 style="color:#FFF">
				<?php echo $_SESSION['nom_emp']; ?>
			</h2>
		</div>
		<div class="cl_fechatra" id="id_fecha_tra" style="display:inline-block;margin:0 30px 0 0;float:right;color:#FFF; width:200px; height:66px;">
		</div>
	</header>
	<nav class="cl_cj_menu cl_cjalinear">
		<ul class="cl_menu">
			<li ><a href="inicio.php">INICIO</a></li>
			<li>% IVA. <input type="text" class="cl_txt2" value="<?php echo  $porcentIVA; ?>" name="c_globIVA" id="id_globIVA" readonly/></li>
			<li >
				<a href="#">DOCUMENTOS
					<ul class="cl_optionsmenu">
						<li><a href="inicio.php?id=frm_facturacion.php">Ventas</a></li>
						<li><a href="inicio.php?id=frm_compras.php">Compras</a></li>
						<li><a href="inicio.php?id=frm_recibosc.php">Recibos</a></li>
						<li><a href="inicio.php?id=frm_cobros.php">Cobros</a></li>
						<li><a href="inicio.php?id=frm_egresos.php">Egresos</a></li>
						<li><a href="inicio.php?id=frm_pagosprov.php">Pago a Proveedores</a></li>
						<li><a href="inicio.php?id=frm_notascont.php">Notas Contables</a></li>	
						<li><a href="inicio.php?id=frm_reimpresiones.php">Reimpresiones</a></li>
						<li><a href="inicio.php?id=frm_revision_cheques.php">Revisión de cheques</a></li>	
						<li><a href="inicio.php?id=frm_cierrecaja.php">Cierre Diario</a></li>				
						<li><a href="inicio.php?id=frm_noAutorizados.php">NO AUTORIZADOS</a></li>
					</ul>
				</a>			
			</li>
			<li >
				<a href="#">CONTABILIDAD
					<ul class="cl_optionsmenu"> 
						<li><a href="inicio.php?id=frm_adminplancuentas.php">Administrar Plan de Cuentas</a></li>
						<li><a href="inicio.php?id=frm_reportes.php">Reportes</a></li>						
						<li><a href="inicio.php?id=frm_balancegeneral.php">Balance general</a></li>
						<li><a href="inicio.php?id=frm_libroretenciones.php">Libro de retenciones</a></li>					
						<!--<li><a href="inicio.php?id=frm_atsanexo.php">ATS Anexo Transaccional</a></li>
						<li><a href="inicio.php?id=frm_asientoscont.php">Asientos Contables</a></li>-->
						<li><a href="inicio.php?id=frm_perfilcont.php">Perfil Contable</a></li>
						<li><a href="inicio.php?id=frm_librodiario.php">LIBRO DIARIO</a></li>
						<li><a href="inicio.php?id=frm_libroMayor.php">LIBRO MAYOR</a></li>
						<li><a href="inicio.php?id=frm_movporcta.php">MAYOR por cuenta</a></li>	
						<li><a href="inicio.php?id=frm_mo_cuenta_gen.php">MAYOR general por cuenta</a></li>	
						<li><a href="inicio.php?id=frm_mayorpor_cli.php">Aux.X Clie Credit.</a></li>
						<li><a href="inicio.php?id=frm_mayorpor_provee.php">Aux Provee.</a></li>
					</ul>
				</a>
			</li>
			<li>
				<a href="#">INVENTARIOS
					<ul class="cl_optionsmenu">
						<li><a href="inicio.php?id=frm_productos.php">Productos</a></li>
						<li><a href="inicio.php?id=frm_historial.php">Historial</a></li>
						<li><a href="inicio.php?id=frm_inventario.php">Administrar inventario</a></li>
						<li><a href="inicio.php?id=frm_up_inventario.php">Subir inventario</a></li>
						<li><a href="inicio.php?id=frm_prod_mes.php"></a></li>
					</ul>
				</a>
			</li>
			<li>
				<a href="#">CARTERA
					<ul>
						<li><a href="inicio.php?id=frm_cartera_his.php">Cartera Clientes</a></li>
						<li><a href="inicio.php?id=frm_cartera_prov.php">Cartera proveedores</a></li>
					</ul>
				</a>
			</li>
			<li>
				<a href="#">CLIENTES
					<ul>
						<li><a href="inicio.php?id=frm_clientes.php"> Adminitracion Clientes / Proveedores</a></li>
						<li><a href="inicio.php?id=frm_Allclient.php"> Rporte de clientes</a></li>
						<li><a href="inicio.php?id=frm_conductores.php">Conductores</a></li>
						<li><a href="inicio.php?id=frm_usuario.php">Usuarios</a></li>
					</ul>
				</a>
			</li>
			<li>
				<a href="#">ADMINISTRADOR
					<ul class="cl_optionsmenu">
						
						<li><a href="inicio.php?id=frm_regempresa.php">Empresa</a></li>
						<li><a href="inicio.php?id=frm_oficinas.php">Oficinas</a></li>
						<li><a href="inicio.php?id=frm_cambiarstock_ini.php">Cambiar stock ini</a></li>
						<li><a href="inicio.php?id=frm_excepciones.php">Tabla excepciones</a></li>
						<li><a href="inicio.php?id=frm_conf_bancos.php">Conf.bancos</a></li>
						<li><a href="inicio.php?id=frm_archivosxml.php">Archivos XML</a></li>
					</ul>
				</a>
			</li>
			<!--<li>
				<a href="#">CONFIGURACIóN
					<ul>
						<li><a href="inicio.php?id=frm_cuentas_por_tercero.php">Cuentas por tercero</a></li>
					</ul>
				</a>
			</li>-->
			<li><a href="lib/salir.php">Salir</a></li>
		</ul>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<p style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>A : RECIBOS DE COBRO</strong></p>
		<p style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>B : PAGOS PROB</strong></p>
		<p style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>C : COMPRAS</strong></p>
		<p style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>D : INGRESO DE GASTOS</strong></p>
		<p style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>E : INGRESO NOTA DE VENTA </strong></p>
		<p style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>F : LIQUIDACIÓN DE COMPRA </strong></p>
		<p style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>G : GUIAS</strong></p>
		<p style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>H : GUIAS DE ENTRADA</strong></p>
		<p style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>I : INGRESOS.(I)</strong></p>
		<p style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>J : EGRESOS.(J)</strong></p>
		<p style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>k : DOC DIEZ.(J)</strong></p>
		<p style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>L : NOTAS CONTABLES</strong></p>
		<p style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>M : NOTAS DE CREDITO COMPRA</strong></p>
		<P style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>N : NOTAS DE CREDITO VENTA </strong></P>
		<P style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>P : PROFORMAS </strong></P>
		<P style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>R : RETENCIONES</strong></P>
		<P style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>V : VENTAS ELECT. (FACT. ELECT.)</strong></P>
		<P style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>W : VENTAS MANUAL. (FACT. MAN.)</strong></P>
		<P style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>X : OTROS TIPO DOC. (X)</strong></P>
		<P style="font-size:11px;margin:0 0 0 10px;padding:0;"><strong>Z : DESCARGUE DE MERC </strong></P>
		<!--jx_rptinventarioprod.php **** rpt_inventarioprod.php *** jxprodcutos.php *** jx_rpthistorial.php *** rpt_historial.php *** -->
	</nav>
	<section class="cl_cjloader cl_cjalinear" id="idcj_loader">
		<?php 
		require_once ($tag);
		?>
	</section>
	<script src="js/ajax.js"></script>
	<script src="js/funciones_retenciones.js"></script>
	<script src="js/funciones.js"></script>
</body>
</html>
<?php 
}else{
echo "<script>
	alert('USTED NO HA INICIADO SESION');
	window.location='index.php';
</script>";
}


?>
