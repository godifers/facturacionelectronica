//---------------------funcion para buscar clientes---------------------------
function buscaracli(identificador,emp)
{
	//alert ('sii');
var xmlhttp;

var n=document.getElementById("id_clienteprovee_glo").value;
if (identificador==1){
	document.getElementById('id_ruc_ced').value= '';
	document.getElementById('id_hdidcliente').value='';
	document.getElementById('id_tipoide').value='';
	document.getElementById("id_aviso_factura").innerHTML='';
}else if (identificador==2) {
	document.getElementById('id_ruc_ced').value='';

}else if (identificador==3){
	document.getElementById('id_adcnumdoc').value='';	
	document.getElementById('id_adccliente').value='';	
	document.getElementById('id_adcapellido').value='';	
	document.getElementById('id_adccontribuyente').value='0';	
	document.getElementById('id_adctelf').value='';	
	document.getElementById('id_adcdumento').value='0';	
	document.getElementById('id_adcnumdoc').value='';	
	document.getElementById('id_adcdirecc').value='';	
	document.getElementById('id_adcciudad').value='';	
	document.getElementById('id_adcmail').value='';	
	document.getElementById('id_adccredito').value='';	
	document.getElementById('id_adcestado').value='0';	
	document.getElementById('id_adcplazo').value='';

	document.getElementById('id_texto_cli').value='NUEVO';
	document.getElementById('id_texto_cli').style.background='green';
	document.getElementById('id_identificador').value='';	
}else if (identificador==5){
	document.getElementById('id_cobcedula').value='';	
}else if (identificador==6){	
	document.getElementById('id_idt_cliente_prov').value='';
}else if (identificador==7){
	document.getElementById('id_nombrepago_ch').value='';
	document.getElementById('id_cobcedula').value='';
	document.getElementById('id_cidtcliente').value='';
}else if (identificador==8){
	document.getElementById('id_id_provee_comp').value='';
	document.getElementById('id_ruc_provee_comp').value='';
};

//var tip=tip_busq;

if(n==''){
	document.getElementById("id_div_clientes").style.display="none";
	return;
}else
{
	document.getElementById("id_div_clientes").style.display="block";
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
//alert(n);
xmlhttp.onreadystatechange=function(){
	if (xmlhttp.readyState==4 && xmlhttp.status==200){
		document.getElementById("id_div_clientes").innerHTML=xmlhttp.responseText;
	}
}
xmlhttp.open("POST","lib/jx_clientes.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n+
			"&empres="+emp+
			"&ident="+identificador);
}
//----------------------funcion que busca los prodcutos-------------------------------------
function buscarprod(texto,identificador_ventas,emp)
{
	//alert ('sii');
var xmlhttp;
var n=texto;
var iden =identificador_ventas;
 if (iden==1){
 	document.getElementById('id_codprod').value='';
	document.getElementById('id_cantpro').value='';
	document.getElementById('id_valprod').value='';
	document.getElementById('id_valtotp').value='';
	document.getElementById('id_hdivapr').value='';
	document.getElementById('id_vacompra').value='';
 }else if(iden==2){
 	//aqui van los id de los inputs de compras
 	//document.getElementById('id_descripcion').value='';
	//document.getElementById('id_invcompra').value='';
	document.getElementById('id_cod').value='';
	document.getElementById('id_cant').value='';
	document.getElementById('id_vcompra').value='';
	document.getElementById('id_valmin').value='';
	document.getElementById('id_valmed').value='';
	document.getElementById('id_valmax').value='';
	document.getElementById('id_valpvp').value='';
	document.getElementById('id_valtotp').value='';
 }else if (iden==3) {
 	document.getElementById('id_regpcod').value='';
	document.getElementById('id_regpcodbarras').value='';
	document.getElementById('id_regpdetalle').value='';
	document.getElementById('id_regppresent').value='';
  	document.getElementById('id_regpvmin').value='';
	document.getElementById('id_regpvmed').value='';
	document.getElementById('id_regpvmax').value='';
	document.getElementById('id_regppvp').value='';
	document.getElementById('idValCompr').value='';
	document.getElementById('id_accion').value='NUEVO';
	document.getElementById('id_regpident').value='0';
	document.getElementById('id_accion').style.background='green';	
 }else if (iden==4) {
 	document.getElementById('id_cod').value='';
 }else if (iden==5) {
 	document.getElementById('id_codprod_egre_l').value='';
 	document.getElementById('id_cantpro_egre_l').value='';
 	document.getElementById('id_valprod_egre_l').value='';
 	document.getElementById('id_valtotp_egre_l').value='';
 }else if (iden==7) {
 	document.getElementById('id_cod_inv_ini').value='';
 	document.getElementById('id_canini_inv_ini').value='0.00';
 };
//var tip=tip_busq;

	if(n==''){
	document.getElementById("id_div_filtroprod").style.display="none";
	return;
	}else
	{
		document.getElementById("id_div_filtroprod").style.display="block";
	}

	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
	document.getElementById("id_div_filtroprod").innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","lib/jx_prodcutos.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("q="+n+
				"&empre="+emp+
				"&ident="+iden);
}
//---------------------funcion para crear tramites ---------------------------
function busctramites(identificador){
var xmlhttp;

/*var varid_cli = document.getElementById('id_hdd_idt_cliente').value;
var varruccli = document.getElementById('id_ruc_ced').value;*/

var varidenti = identificador;
if (varidenti==1 || varidenti==2) {

	document.getElementById('id_tramites').style.display='none';
	document.getElementById('id_newopciones').style.display='none';
	document.getElementById('id_tramites_act').style.display='none';
	texto = document.getElementById('id_textobusque').value;	
	document.getElementById("id_tramites").style.display='block';
	/*if (varidenti==1) {
	document.getElementById("id_tramites_act").style.display='none';
	document.getElementById("id_tramites").style.display='block';
	}else if(varidenti==2 && texto <>''){
		document.getElementById("id_tramites_act").style.display='none';
		document.getElementById("id_tramites").style.display='block';
	}else if(varidenti==2 && texto ==''){
		document.getElementById("id_tramites_act").style.display='block';
		document.getElementById("id_tramites").style.display='none';
	}*/

	{
	//document.getElementById("id_cliente").style.border="solid 1px #0A7823";
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
	document.getElementById("id_tramites").innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","lib/jx_tramite.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("identi="+varidenti+
				 "&textobuscar="+texto);
	}
} else if(varidenti==3){
	document.getElementById("id_tramites_act").style.display='block';
	document.getElementById("id_tramites").style.display='none';
};
}
//---------------------funcion para uscar tramites ---------------------------
function tramites(){
var xmlhttp;
var varid_cli = document.getElementById('id_hdd_idt_cliente').value;
var varruccli = document.getElementById('id_ruc_ced').value;
var texto_tram= document.getElementById('id_tram').value;
if(texto_tram == ''){	
	document.getElementById("id_tramites").style.display="none";
	return;
}else
{
	document.getElementById("id_tramites").style.display="block";	
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
	document.getElementById("id_tramites").innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","lib/jx_buscartramite.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("id_cli="+varid_cli+
				 "&ruccli="+varruccli+
				 "&texto="+texto_tram);
	}
}
//-----------funcion que carga los servicios por clientes para despues seleccionar---------
function mostarserviciostram(id_esconder){
	//alert('funsio si reconoce');
	var xmlhttp;
	if(id_esconder == 1){
		document.getElementById('id_seccionsevicios').style.display='none';	
		document.getElementById('id_estadostramite').style.display='block';
		return;
	}else{
		//alert('serv');
		document.getElementById('id_estadostramite').style.display='none';
		document.getElementById('id_seccionsevicios').style.display='block';
		var id_cli = document.getElementById('id_idclient').value;
		//alert('1');
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		//alert('2');
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("id_seccionsevicios").innerHTML=xmlhttp.responseText;
		//alert('3');
		}
		}
		xmlhttp.open("POST","lib/jx_cargarservicios.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id_cli="+id_cli);

	}
}
//----------------------------------------------------------------------------------------
function reportetablas()
{	
	document.getElementById("id_resultadoreport").innerHTML='<img src="img/cargar.gif" alt="" />';
var xmlhttp;
var finicial=document.getElementById('id_rvdesde').value;
var ffinal=document.getElementById('id_rvhasta').value;

var cad="SELECT * FROM t_comprobante, t_client_provee where IDT_CLIENT_PROVEE = COM_FKID_CLI_PROV and (COM_FEC_CREA BETWEEN '"+ finicial +"' and '"+ ffinal +"')";
var cad_aux='';

	if (document.getElementById('id_rvcompras').checked==true) {
		cad_aux=cad_aux + " or COM_TIPO_COMPR='C'";
	}
	if (document.getElementById('id_rvnotasc').checked==true) {
		cad_aux=cad_aux + " or COM_TIPO_COMPR='M'";
	}
	if (document.getElementById('id_rvgastos').checked==true) {
		cad_aux=cad_aux + " or COM_TIPO_COMPR='D'";

	}if (document.getElementById('id_rvventas').checked==true) {
		cad_aux=cad_aux + " or COM_TIPO_COMPR='V'";

	}if (document.getElementById('id_rvnotasv').checked==true) {
		cad_aux=cad_aux + " or COM_TIPO_COMPR='N'";

	}if (document.getElementById('id_rvingreso').checked==true) {
		cad_aux=cad_aux + " or COM_TIPO_COMPR='I'";
	}
	if (document.getElementById('id_rvegreso').checked==true) {
		cad_aux=cad_aux + " or COM_TIPO_COMPR='J'";
	}
	if (document.getElementById('id_rvrecibosc').checked==true) {
		cad_aux=cad_aux + " or COM_TIPO_COMPR='A'";
	}
	if (document.getElementById('id_rvpagoprov').checked==true) {
		cad_aux=cad_aux + " or COM_TIPO_COMPR='C'";
	}
	if (document.getElementById('idt_guias').checked==true) {
		cad_aux=cad_aux + " or COM_TIPO_COMPR='G'";
	}
	if (document.getElementById('id_rvnotcont').checked==true) {
		cad_aux=cad_aux + " or COM_TIPO_COMPR='L'";
	}
	if (document.getElementById('id_rvnotaventas').checked==true) {
		cad_aux=cad_aux + " or COM_TIPO_COMPR='E'";
	}
	var cadtipodoc= " and (COM_TIPO_COMPR='' "+cad_aux+")"
	//alert(cad);
	cad = cad + ' ' + cadtipodoc;
	//alert(cadtipodoc);
	//alert(cad);
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
		//alert('respot chino');
	document.getElementById("id_resultadoreport").innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","lib/jx_reportesdoc.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("cad1="+cad);
}
// -----------------------04/11/2015 --- funsión para administar compras---------------
function admincompras(){
var xmlhttp;
var idcliprov = document.getElementById('id_codprov').value;
if(idcliprov == ''){	
	document.getElementById("id_codprov").style.border="solid 1px red";
	document.getElementById("id_nomproveedor").style.border="solid 1px red";
}else
{	
	document.getElementById("id_codprov").style.border="solid 1px green";
	document.getElementById("id_nomproveedor").style.border="solid 1px green";
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
	document.getElementById("id_cjadmincompras").innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","lib/jx_buscarcompras.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("id_cliprov="+idcliprov);
	}
}
// ----------------------------------------------- funcion para buscar cunetas del plan de cuentas 
function buscarcuentas(nomcuenta,ident)
{
var xmlhttp;
var n=nomcuenta;
var identificador=ident;
	if (ident==1) {
		document.getElementById('id_movcodcuenta').value='';
	}if (ident==5) {
		document.getElementById('id_identific').value=0;
		document.getElementById('id_cuenta').value=''; 
		document.getElementById('id_nom_cuentas').value=''; 
		document.getElementById('id_cuenta_pad').value=''; 
		document.getElementById('id_mov').value=''; 
		document.getElementById('id_saldo1').value=''; 
		document.getElementById('id_idt1').value=0;
		document.getElementById('id_saldo2').value='';
		document.getElementById('id_idt2').value=0; 
		document.getElementById('id_cuenta').readOnly = false;
		document.getElementById('id_identificador_txt').value='NUEVO..';
		document.getElementById('id_identificador_txt').style.background='green';
		document.getElementById('id_cuenta_pad').disabled = false;
	}if (ident==7) {
		//document.getElementById('id_newNomCuent').value=0;
		document.getElementById('id_newCodCuent').value=''; 		
	};
	if (nomcuenta=='') {
		document.getElementById('id_div_cuentas').style.display="none";
	}else {
		document.getElementById('id_div_cuentas').style.display="block";
	};

	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
	document.getElementById("id_div_cuentas").innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","lib/jx_buscarcuentas.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("q="+n+
				"&ident="+identificador);
}
//---------------------------------------------------------------
function reportemovcuentas()
{	
var xmlhttp;
var finicial=document.getElementById('id_movdesde').value;
var ffinal=document.getElementById('id_movhasta').value;
var codcuenta = document.getElementById('id_movcodcuenta').value;

if (finicial =='' || ffinal =='' || codcuenta =='') {
	if (finicial=='') {
		document.getElementById('id_movdesde').style.border ='solid 1px red';
	} else{
		document.getElementById('id_movdesde').style.border ='solid 1px green';
	};
	if (ffinal=='') {
		document.getElementById('id_movhasta').style.border ='solid 1px red';
	} else{
		document.getElementById('id_movhasta').style.border ='solid 1px green';
	};
	if (codcuenta=='') {
		document.getElementById('id_movcodcuenta').style.border ='solid 1px red';
	} else{
		document.getElementById('id_movcodcuenta').style.border ='solid 1px green';
	};
} else{
		document.getElementById('id_movdesde').style.border ='solid 1px green';
		document.getElementById('id_movhasta').style.border ='solid 1px green';
		document.getElementById('id_movcodcuenta').style.border ='solid 1px green';

		document.getElementById('id_resultadoreport').innerHTML = '<img src="img/cargar.gif" alt="" />';
		var cad="SELECT CP_NOMBRE,CP_APELLIDO,CP_CEDULA, COM_NUM_COMPROB, COM_TIPO_COMPR, COM_FEC_CREA, ASI_DEBE,ASI_HABER, COM_EPRESA FROM t_client_provee, t_comprobante, t_asiento where ASI_CUENTA = '" + codcuenta + "' and ASI_FK_IDCOMPROB = IDT_COMPROBANTE and COM_FKID_CLI_PROV = IDT_CLIENT_PROVEE and(COM_FEC_CREA BETWEEN '"+ finicial +"' and '"+ ffinal +"')";

		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		//alert(n);
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			
		document.getElementById("id_resultadoreport").innerHTML=xmlhttp.responseText;
		}
		}
		xmlhttp.open("POST","lib/jx_rptmovcuentas.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("cad1="+cad+
					"&cuenta="+codcuenta+
					"&fecha_ini="+finicial);
	};
}
//---------------------------------13112015 --------------------------------------------------
function consultarcomprobantes () {
	for (var i = 0; i < document.frm_cosultas.c_tipoconprob.length; i++) {
		if (document.frm_cosultas.c_tipoconprob[i].checked) {
			var tipo = "AND COM_TIPO_COMPR='"+document.frm_cosultas.c_tipoconprob[i].value+"'";
			break;
		};
	};

	var verific = document.getElementById('id_verfic').value;
	var cad2='';
	if (verific==1) { // en caso de seleccionar fechas 
		var fech1 =document.getElementById('id_fecha1').value;
		var fech2 =document.getElementById('id_fecha2').value;
		if (fech1=='' || fech2=='') {
			var hoy = new Date();
			var f = new Date(); 
			f = (f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate());
			cad2 ="AND ( COM_FEC_CREA BETWEEN '" + f + "' AND '" + f + "')";
		} else{
			document.getElementById('id_fecha1').style.border="solid 1px green";
			document.getElementById('id_fecha2').style.border="solid 1px green";
			cad2 ="AND ( COM_FEC_CREA BETWEEN '" + fech1 + "' AND '" + fech2 + "')";
		};
	} else if(verific==2){ // en caso de seleccionar documento

		var var_numdoc_se1 = document.getElementById('id_numdoc_se1').value;
		var var_numdoc_se2 = document.getElementById('id_numdoc_se2').value;
		var var_numdoc_se3 = document.getElementById('id_numdoc_se3').value;

		if (var_numdoc_se1=='' || var_numdoc_se2==''|| var_numdoc_se3=='') {
			if (var_numdoc_se1=='') {
				document.getElementById('id_numdoc_se1').style.border="solid 1px red";
			} else{
				document.getElementById('id_numdoc_se1').style.border="solid 1px green";
			};
			if (var_numdoc_se2=='') {
				document.getElementById('id_numdoc_se2').style.border="solid 1px red";
			} else{
				document.getElementById('id_numdoc_se2').style.border="solid 1px green";
			};
			if (var_numdoc_se3=='') {
				document.getElementById('id_numdoc_se3').style.border="solid 1px red";
			} else{
				document.getElementById('id_numdoc_se3').style.border="solid 1px green";
			};
		}else {
			document.getElementById('id_numdoc_se1').style.border="solid 1px green";
			document.getElementById('id_numdoc_se2').style.border="solid 1px green";
			document.getElementById('id_numdoc_se3').style.border="solid 1px green";

			for (var i1 = var_numdoc_se1.length; i1 < 3; i1++) {
		 		var_numdoc_se1 = '0'+var_numdoc_se1;
		 	};
		 	for (var i2 = var_numdoc_se2.length; i2 < 3; i2++) {
		 		var_numdoc_se2 = '0'+var_numdoc_se2;
		 	};
		 	for (var i = var_numdoc_se3.length; i < 9; i++) {
		 		var_numdoc_se3 = '0'+var_numdoc_se3;
		 	};
		 	document.getElementById('id_numdoc_se1').value=var_numdoc_se1;
			document.getElementById('id_numdoc_se2').value=var_numdoc_se2;
			document.getElementById('id_numdoc_se3').value=var_numdoc_se3;
		 	var num_final = var_numdoc_se1+var_numdoc_se2+var_numdoc_se3;

			cad2 ="AND COM_NUM_COMPROB= '" + num_final + "'";
		};
	}else if(verific==3){
		var id_cliente = document.getElementById('id_idt_cliente_prov').value;
		if (id_cliente=='') {
			document.getElementById('id_clienteprovee_glo').style.border="solid 1px red";
			document.getElementById('id_idt_cliente_prov').style.border="solid 1px red";
		}else{
			cad2 ="AND COM_FKID_CLI_PROV= " + id_cliente ;
		};
	};
	if (tipo=='' || cad2=='') {
		alert('FALTA ALGUNOS CAMPOS');
	} else{
		var cadaenviar ="SELECT * from t_comprobante , t_client_provee, t_formas_pago, t_usuario where IDT_USUARIO= COM_FKID_USER_CREA and  IDT_CLIENT_PROVEE = COM_FKID_CLI_PROV "+tipo+" "+cad2;
		cargar_consultas(cadaenviar);
	};
		
}
//--------------------- FUNCION QUE CARGA LA CONSULTA PARA EL FRM_REIMPRESIONES---------------
function cargar_consultas (cadena){
	document.getElementById("id_div_resultados_reimpresiones").innerHTML='<img src="img/cargar.gif">';
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
		
	document.getElementById("id_div_resultados_reimpresiones").innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","lib/jx_cargarconsulta_reimpresiones.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("canema_reimp="+cadena);
}
//-------------------------------------------fincion para mostra los creditos por cobrar--
function rptpendientespagos(){
	document.getElementById("id_resultadoreport").innerHTML='<img src="img/cargar.gif" alt="" />';
	var xmlhttp;
	var cliente = document.getElementById('id_clienteprovee_glo').value;
	var id=document.getElementById('id_cidtcliente').value;
	var cedula_cli = document.getElementById('id_cobcedula').value;
	var estpago=document.getElementById('id_cpestado').value;
	var id_emp = document.getElementById('id_emp_for_cobros').value;
	if (cliente=='' || id=='' || cedula_cli=='') {
		document.getElementById('id_clienteprovee_glo').style.border='solid 1px red';
		document.getElementById('id_cobcedula').style.border="solid 1px red";
	} else{
		document.getElementById('id_clienteprovee_glo').style.border='solid 1px green';
		document.getElementById('id_cobcedula').style.border="solid 1px green";
		var cad = "SELECT * FROM t_comprobante, t_client_provee , t_asiento where ASI_FK_IDCOMPROB = IDT_COMPROBANTE and (ASI_CUENTA= '2.3.1.01' or ASI_CUENTA='1.1.2.01.01')  and  COM_ESTADO_SIS=1 AND COM_FKID_CLI_PROV=IDT_CLIENT_PROVEE and COM_FKID_CLI_PROV="+id;

		if (document.getElementById('id_cpestado').value==[1]) {
			cad=cad + " and COM_ESTADO_PAGO="+estpago;
		}
		if (document.getElementById('id_cpestado').value==[2]) {
			cad=cad + " and COM_ESTADO_PAGO="+estpago;
		}
		cad = cad +" order by COM_NUM_COMPROB asc ";
		
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		//alert(n);
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{			
			document.getElementById("id_resultadoreport").innerHTML=xmlhttp.responseText;
		}
		}
		xmlhttp.open("POST","lib/jx_rptcreditosactivos.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("query_creditos="+cad);
	};
}
// funcion para buscar a conductor ----------------------------------------------20 11 2015 ----------------------------------
function buscar_conduct(texto,identificador)
{
var xmlhttp;

var n=texto;
var iden=identificador;
if (identificador==1) {
document.getElementById('id_palca_fact').value='';
document.getElementById('id_descrip_fac').value='';
document.getElementById('id_cod_cond_fac').value='0';
document.getElementById('id_ruc_cond_fact').value ='';
}else if(identificador==2){
document.getElementById('id_ruc_id_con').value='';
document.getElementById('id_placas_con').value='';
document.getElementById('id_color_con').value='';
document.getElementById('id_modelo_con').value='';
document.getElementById('id_idconductor').value='';
document.getElementById('id_identificador_con').value='0';
document.getElementById('id_chasis_con').value='';
document.getElementById('id_marca_con').value='';
document.getElementById('id_conductor_con').value='';
document.getElementById('id_descript_con').value='';
document.getElementById('id_aletra_con').value='NUEVO..';
document.getElementById('id_aletra_con').style.background='green';
}
else if(identificador==3){
document.getElementById('id_placa_vehic_gia').value='';
document.getElementById('id_ruc_conduc_gia').value='';
document.getElementById('id_ih_vehiculo').value='0';
};


if(n==''){
document.getElementById("id_buscadorconductores").style.display="none";
return;
}else
{
	document.getElementById("id_buscadorconductores").style.display="block";
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
//alert(n);
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("id_buscadorconductores").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","lib/jx_searchconductor.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n+					 
			 "&i="+iden);
}
//------------------------------------fincion para guardar conductor -------------20 11 2015-----------------------------------
function saveconductor()
{
var xmlhttp;

var var_id_identificador_con=document.getElementById('id_identificador_con').value;
var var_id_conductor_con=document.getElementById('id_conductor_con').value;
var var_id_ruc_id_con=document.getElementById('id_ruc_id_con').value;
var var_id_placas_con=document.getElementById('id_placas_con').value;
var var_id_color_con=document.getElementById('id_color_con').value;
var var_id_marca_con=document.getElementById('id_marca_con').value;
var var_idcondcut = document.getElementById('id_idconductor').value;
var var_id_descript_con=document.getElementById('id_descript_con').value;
var var_id_chasis_con =  document.getElementById('id_chasis_con').value;
var var_id_modelo_con =  document.getElementById('id_modelo_con').value;


if(var_id_modelo_con=='' || var_id_chasis_con=='' || var_id_conductor_con=='' || var_id_ruc_id_con=='' || var_id_placas_con=='' || var_id_color_con=='' || var_id_marca_con=='' || var_id_descript_con==''){
	if (var_id_identificador_con='') {
		alert('Ha ocurrido un error favor recarge la pagina si persiste comuniquese con el administrador');
	};
	if (var_id_conductor_con=='') {
		document.getElementById('id_conductor_con').style.border='solid 1px red';
	} else{
		document.getElementById('id_conductor_con').style.border='solid 1px green';
	};
	if (var_id_ruc_id_con=='') {
		document.getElementById('id_ruc_id_con').style.border='solid 1px red';
	} else{
		document.getElementById('id_ruc_id_con').style.border='solid 1px green';
	};
	if (var_id_placas_con=='') {
		document.getElementById('id_placas_con').style.border='solid 1px red';
	} else{
		document.getElementById('id_placas_con').style.border='solid 1px green';
	};
	if (var_id_color_con=='') {
		document.getElementById('id_color_con').style.border='solid 1px red';
	} else{
		document.getElementById('id_color_con').style.border='solid 1px green';
	};
	if (var_id_marca_con=='') {
		document.getElementById('id_marca_con').style.border='solid 1px red';
	} else{
		document.getElementById('id_marca_con').style.border='solid 1px green';
	};
	if (var_id_descript_con=='') {
		document.getElementById('id_descript_con').style.border='solid 1px red';
	} else{
		document.getElementById('id_descript_con').style.border='solid 1px green';
	};
	if (var_id_chasis_con=='') {
		document.getElementById('id_chasis_con').style.border='solid 1px red';
	} else{
		document.getElementById('id_chasis_con').style.border='solid 1px green';
	};
	if (var_id_modelo_con=='') {
		document.getElementById('id_modelo_con').style.border='solid 1px red';
	} else{
		document.getElementById('id_modelo_con').style.border='solid 1px green';
	};
return;
}else
{	
	alert('va a empezar a guardar');
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
		document.getElementById("id_cjconductores").innerHTML=xmlhttp.responseText;
		//mostarconductores(1);
	}
	}
	xmlhttp.open("POST","lib/jx_saveconductor.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("identificador_con="+var_id_identificador_con+
				 "&conductor_con="+var_id_conductor_con+
				 "&ruc_id_con="+var_id_ruc_id_con+
				 "&placas_con="+var_id_placas_con+
				 "&color_con="+var_id_color_con+
				 "&marca_con="+var_id_marca_con+
				 "&id_idcon="+var_idcondcut+
				 "&descript_con="+var_id_descript_con+
				 "&chasis_con="+var_id_chasis_con+
				 "&modelo_con="+var_id_modelo_con);
}
}
//------------------------------------------------------------------------------------------
function mostarconductores(val_vh)
{
var xmlhttp;
var n = val_vh;
if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
//alert(n);
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("id_cjconductores").innerHTML=xmlhttp.responseText;
}
}
xmlhttp.open("POST","lib/jx_cargar_conductores.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);
}
//---------------------------------------------funcion para aceptar  la guia de remision------------------------------------
function actualizar_guia_rem(idt_guia_rem)
{
	//alert('act guia');
var xmlhttp;
var n = idt_guia_rem;
if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
//alert(n);
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
document.getElementById("id_res_update_guia").innerHTML=xmlhttp.responseText;
alert('GUIA INGRESADA CORRECTAMENTE');
location.reload();
}
}
xmlhttp.open("POST","lib/jx_actualizar_guia_off.php",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("q="+n);
}
//-------------------------------------------------------------------
function fachatra (emp) {
	//alert('fecha');
	var xmlhttp;
	var n = emp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
	document.getElementById("id_fecha_tra").innerHTML=xmlhttp.responseText;
	//alert('GUIA INGRESADA CORRECTAMENTE');
	//location.reload();
	}
	}
	xmlhttp.open("POST","lib/jax_queryfecha_tra.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("q="+n);
}
function reportehistorial(){
var xmlhttp;
document.getElementById("id_resultadoreport").innerHTML='<img src="img/cargar.gif" alt="" />';
var finicial=document.getElementById('id_hisdesde').value;
var ffinal=document.getElementById('id_hishasta').value;
var producto=document.getElementById('id_product').value;
var cod=document.getElementById('id_cod').value;
var idemp=document.getElementById('id_empresa').value;
//var cad="SELECT PR_DETALLE, DET_FK_IDPROD,CP_NOMBRE,CP_APELLIDO, COM_TIPO_COMPR, COM_NUM_COMPROB, COM_FEC_CREA, DET_VAL_UNIT,DET_VAL_TOT, DET_CANTIDAD, PR_COD_PROD, PR_EMPRESA, PR_PRESENTACION FROM t_comprobante,t_client_provee,t_detalles,t_prodcutos WHERE DET_FK_IDCLIPROV=IDT_CLIENT_PROVEE AND IDT_COMPROBANTE=DET_FK_IDCOMPROB AND COM_NUM_COMPROB=DET_NUM_FACTU AND DET_FK_IDCLIPROV=IDT_CLIENT_PROVEE AND PR_COD_PROD='"+ cod +"' AND DET_FK_IDPROD=PR_COD_PROD AND PR_EMPRESA="+ idemp +" AND COM_EPRESA= "+ idemp +" order by IDT_COMPROBANTE";
//var cad="SELECT PR_DETALLE, DET_FK_IDPROD,CP_NOMBRE,CP_APELLIDO, COM_TIPO_COMPR, COM_NUM_COMPROB, COM_FEC_CREA, DET_VAL_UNIT,DET_VAL_TOT, DET_CANTIDAD, PR_COD_PROD, PR_EMPRESA FROM t_comprobante,t_client_provee,t_detalles,t_prodcutos WHERE COM_EPRESA= '"+ cod +"' and DET_FK_IDCLIPROV=IDT_CLIENT_PROVEE AND IDT_COMPROBANTE=DET_FK_IDCOMPROB AND COM_NUM_COMPROB=DET_NUM_FACTU AND DET_FK_IDCLIPROV=IDT_CLIENT_PROVEE AND PR_COD_PROD='"+ cod +"' AND DET_FK_IDPROD=PR_COD_PROD AND PR_EMPRESA="+ idemp +" order by IDT_COMPROBANTE";
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
		
	document.getElementById("id_resultadoreport").innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","lib/jx_rpthistorial.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("cod_pro="+cod);	
}

function eliminar_comp(idt_comprobante){
	//alert('elinimando comp');
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{		
	document.getElementById("id_dov_res_anulacio").innerHTML=xmlhttp.responseText;
	consultarcomprobantes ();
	}
	}
	xmlhttp.open("POST","lib/jx_elim_comprob.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("idt_comprob="+idt_comprobante);	
}
function cambiarfactura (idt_comp, num_compr,tipocomp,identificador) {
	//document.getElementById("id_div_resultcambio").innerHTML ='<span style="background:green;font-size:16px;">CAMBIANDO ESPERE..!</span>';
	document.getElementById("id_gif_cargar").style.display='block';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{		
	document.getElementById("id_div_resultcambio").innerHTML=xmlhttp.responseText;
	location.reload();
	}
	}
	xmlhttp.open("POST","lib/jx_cambiaracredito.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("idt_comp="+idt_comp+
				 "&num_compr="+num_compr+
				 "&tipocomp="+tipocomp+
				 "&identificador="+identificador);	
}
function reportinventarioprod(){
var xmlhttp;
document.getElementById("id_resultadoreport").innerHTML='<img src="img/cargar.gif" alt="" />';
var cad="SELECT * FROM t_prodcutos";
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
		
	document.getElementById("id_resultadoreport").innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","lib/jx_rptinventarioprod.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("cad1="+cad);	

}
function actualizarval_ini (empresa) {
	var emp = empresa;
	var cor_proc = document.getElementById('id_cod_inv_ini').value;
	var new_val = document.getElementById('id_new_canini_inv_ini').value;
	var xmlhttp;
	if (cor_proc =='' || new_val =='') {
		if (cor_proc=='') {
			document.getElementById('id_cod_inv_ini').style.border="solid 1px red";
		} else{
			document.getElementById('id_cod_inv_ini').style.border="solid 1px green";
		};
		if (new_val=='') {
			document.getElementById('id_new_canini_inv_ini').style.border="solid 1px red";
		} else{
			document.getElementById('id_new_canini_inv_ini').style.border="solid 1px green";
		};
	} else{
		document.getElementById('id_cod_inv_ini').style.border="solid 1px green";
		document.getElementById('id_new_canini_inv_ini').style.border="solid 1px green";
		document.getElementById("id_res_actualizacion").innerHTML='<img src="img/cargar.gif" alt="" />';
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		//alert(n);
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			
		document.getElementById("id_res_actualizacion").innerHTML=xmlhttp.responseText;
		//location.reload();
		}
		}
		xmlhttp.open("POST","lib/jx_actualizar_stock_ini.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("new_val="+new_val+
					"&emp="+emp+
					"&cod_prod="+cor_proc);	
	};
}
//funcion para buscar prodcutos comutilixada como funcion auxiliar ------------
function buscarprod2(texto,identificador_ventas,emp)
{
	var xmlhttp;
	var n=texto;
	var iden =identificador_ventas;
	 if (iden==6) {
	 	document.getElementById('id_codprod_ingr_l').value='';
	 	document.getElementById('id_cantpro_ingr_l').value='';
	 	document.getElementById('id_valprod_ingr_l').value='';
	 	document.getElementById('id_valtotp_ingr_l').value='';
	 }else if(iden==11){
	 	document.getElementById('id_codprod_ingr_l').value='';
	 	document.getElementById('id_cantpro_ingr_l').value='';
	 	document.getElementById('id_valprod_ingr_l').value='';
	 	document.getElementById('id_valtotp_ingr_l').value='';
	 };

	if(n==''){
	document.getElementById("id_div_filtroprod2").style.display="none";
	return;
	}else
	{
		document.getElementById("id_div_filtroprod2").style.display="block";
	}

	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
	document.getElementById("id_div_filtroprod2").innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","lib/jx_prodcutos.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("q="+n+
				"&empre="+emp+
				"&ident="+iden);
}
//-------------------------------------------06122015--------------------------------------------------------
function actualizar_compra()
{
	var xmlhttp;
	var num_factu = document.getElementById('id_num_fac_comp').value;
	var fech_comp = document.getElementById('id_new_date_comp').value;
	var num_auuto = document.getElementById('id_aut_comp').value;
	var idt_compr = document.getElementById('id_idt_comprob_comp').value;
	var id_clp_pr = document.getElementById('id_id_provee_comp').value;

	var subt_comp = document.getElementById('id_subt_comp').value;
	var base0_comp = document.getElementById('id_base0_comp').value;
	var base12_comp = document.getElementById('id_base12_comp').value;
	var iva_comp = document.getElementById('id_iva_comp').value;
	var total_comp = document.getElementById('id_total_comp').value;
	var tipo_comprob = document.getElementById('id_tipo_trans').value;

	if (num_factu=='' || fech_comp=='' || num_auuto=='' || idt_compr=='' || id_clp_pr=='') {
		if (num_factu=='') {
			document.getElementById('id_num_fac_comp').style.border='solid 1px red';
		} else{
			document.getElementById('id_num_fac_comp').style.border='solid 1px green';
		};
		if (fech_comp=='') {
			document.getElementById('id_new_date_comp').style.border='solid 1px red';
		} else{
			document.getElementById('id_new_date_comp').style.border='solid 1px green';
		};
		if (num_auuto=='') {
			document.getElementById('id_aut_comp').style.border='solid 1px red';
		} else{
			document.getElementById('id_aut_comp').style.border='solid 1px green';
		};
		if (idt_compr=='' || tipo_comprob=='') {
			alert('Algo va mal recarge y vuelva a intentar');
		};
		if (id_clp_pr=='') {
			document.getElementById('id_clienteprovee_glo').style.border='solid 1px red';
			document.getElementById('id_ruc_provee_comp').style.border='solid 1px red';
		} else{
			document.getElementById('id_clienteprovee_glo').style.border='solid 1px green';
			document.getElementById('id_ruc_provee_comp').style.border='solid 1px green';
		};

		if (subt_comp=='') {
			document.getElementById('id_subt_comp').style.border='solid 1px red';
		} else{
			document.getElementById('id_subt_comp').style.border='solid 1px green';
		};
		if (base0_comp=='') {
			document.getElementById('id_base0_comp').style.border='solid 1px red';
		} else{
			document.getElementById('id_base0_comp').style.border='solid 1px green';
		};
		if (base12_comp=='') {
			document.getElementById('id_base12_comp').style.border='solid 1px red';
		} else{
			document.getElementById('id_base12_comp').style.border='solid 1px green';
		};
		if (iva_comp=='') {
			document.getElementById('id_iva_comp').style.border='solid 1px red';			
		} else{
			document.getElementById('id_iva_comp').style.border='solid 1px green';			
		};
		if (total_comp=='') {
			document.getElementById('id_total_comp').style.border='solid 1px red';			
		} else{
			document.getElementById('id_total_comp').style.border='solid 1px green';			
		};

	} else{
		document.getElementById('id_num_fac_comp').style.border='solid 1px green';
		document.getElementById('id_new_date_comp').style.border='solid 1px green';
		document.getElementById('id_aut_comp').style.border='solid 1px green';
		document.getElementById('id_clienteprovee_glo').style.border='solid 1px green';
		document.getElementById('id_ruc_provee_comp').style.border='solid 1px green';
		document.getElementById('id_subt_comp').style.border='solid 1px green';
		document.getElementById('id_base0_comp').style.border='solid 1px green';
		document.getElementById('id_base12_comp').style.border='solid 1px green';
		document.getElementById('id_iva_comp').style.border='solid 1px green';		
		document.getElementById('id_total_comp').style.border='solid 1px green';
		document.getElementById("id_div_admin_compras").innerHTML= '<img src="img/cargar.gif" alt="" />';

		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		//alert(n);
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("id_div_admin_compras").innerHTML = xmlhttp.responseText;
		location.reload();
		}
		}
		xmlhttp.open("POST","lib/jx_actualizar_compra.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("num_factu="+num_factu+
					"&fech_comp="+fech_comp+
					"&num_auuto="+num_auuto+
					"&idt_compr="+idt_compr+
					"&id_clp_pr="+id_clp_pr+
					"&subt_comp="+subt_comp+
					"&base0_comp="+base0_comp+
					"&base12_comp="+base12_comp+
					"&iva_comp="+iva_comp+
					"&total_comp="+total_comp+
					"&tipo_comprob="+tipo_comprob);
	};
}
//------------------------------------07012015----------------------------------------------------
function pagos_provedor(){
	
	var xmlhttp;
	var cliente = document.getElementById('id_clienteprovee_glo').value;
	var id=document.getElementById('id_cidtcliente').value;
	var cedula_cli = document.getElementById('id_cobcedula').value;
	var forma_pag=document.getElementById('id_forma_pag').value;
	if (cliente=='' || id=='' || cedula_cli=='' || forma_pag ==0) {
		if (cliente=='') {
			document.getElementById('id_clienteprovee_glo').style.border='solid 1px red';
			document.getElementById('id_cobcedula').style.border='solid 1px red';
		} else{
			document.getElementById('id_clienteprovee_glo').style.border='solid 1px green';
			document.getElementById('id_cobcedula').style.border='solid 1px green';
		};
		if (forma_pag==0) {
			document.getElementById('id_forma_pag').style.border='solid 1px red';
		} else{
			document.getElementById('id_forma_pag').style.border='solid 1px green';
		};
		if (id=='') {
			alert('Algo va mal ..con el cliente..! Recarge la pagina y vuelva a intentar');
		};
	} else{
		document.getElementById("id_resultadoreport").innerHTML='<img src="img/cargar.gif" alt="" />';
		document.getElementById('id_clienteprovee_glo').style.border='solid 1px green';
		document.getElementById('id_cobcedula').style.border="solid 1px green";
		document.getElementById('id_forma_pag').style.border='solid 1px green';
		var cad = "SELECT * FROM t_comprobante, t_client_provee where COM_TIPO_COMPR<>'M' AND COM_ESTADO_SIS=1 AND COM_FKID_CLI_PROV=IDT_CLIENT_PROVEE and COM_FKID_CLI_PROV="+id;
		cad = cad + "  and COM_ESTADO_PAGO= 1";
		cad = cad +" order by COM_NUM_COMPROB asc ";
		
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		//alert(n);
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{			
			document.getElementById("id_resultadoreport").innerHTML=xmlhttp.responseText;
			//document.getElementById("id_div_generador_asiento").innerHTML='';
		}
		}
		xmlhttp.open("POST","lib/jx_pagos_proveedores.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("cad1="+cad);
	};
}
// ------------------------------------------------------------20-01-2016------------------------------------------------------
function guradarexcepciones () {
	var var_cuenta = document.getElementById('id_movcodcuenta').value;
	var var_tipo = document.getElementById('id_tipo_trans').value;
	if (var_cuenta =='' || var_tipo == 0 || var_tipo == '0') {
		if (var_cuenta =='' ) {
			document.getElementById('id_movcodcuenta').style.border = 'solid 1px red';
		} else{
			document.getElementById('id_movcodcuenta').style.border = 'solid 1px green';
		};
		if (var_tipo == 0 || var_tipo == '0') {
			document.getElementById('id_tipo_trans').style.border = 'solid 1px red';
		} else{
			document.getElementById('id_tipo_trans').style.border = 'solid 1px green';
		};
	} else{

		var idt_excp = '0';
		var identificadoe_accion = 1;

		document.getElementById('id_movcodcuenta').style.border = 'solid 1px green';
		document.getElementById('id_tipo_trans').style.border = 'solid 1px green';
		document.getElementById('id_res_excepcion').innerHTML ='<img src="img/cargar.gif" alt="" />';
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		//alert(n);
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{			
			document.getElementById('id_res_excepcion').innerHTML = xmlhttp.responseText;
			location.reload();
		}
		}
		xmlhttp.open("POST","lib/jx_save_excepcion.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("var_cuenta="+var_cuenta+
					"&var_tipo="+var_tipo+
					"&idt_excp="+idt_excp+
					"&identificadoe_accion="+identificadoe_accion);

	};
}
function eliminar_exc (id_excp) {
	document.getElementById('id_res_excepcion').innerHTML ='<img src="img/cargar.gif" alt="" />';
	var var_cuenta='0.0.0.0';
	var var_tipo ='0';
	var idt_excp = id_excp;
	var identificadoe_accion = 2;
	if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		//alert(n);
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{			
			document.getElementById('id_res_excepcion').innerHTML = xmlhttp.responseText;
			location.reload();
		}
		}
		xmlhttp.open("POST","lib/jx_save_excepcion.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("var_cuenta="+var_cuenta+
					"&var_tipo="+var_tipo+
					"&idt_excp="+idt_excp+
					"&identificadoe_accion="+identificadoe_accion);
}
function generarnewbal() {
	var xmlhttp;
	var ident =1;
	var fecha_bal = document.getElementById('id_fecha_bal').value;
	if (fecha_bal == ''){
		document.getElementById('id_fecha_bal').style.background='red';
	}else{
		document.getElementById('id_div_res_bala').innerHTML = '<img src="img/cargar.gif" alt="" />';
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}else{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			//alert(n);
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{			
					document.getElementById('id_div_res_bala').innerHTML = xmlhttp.responseText;
					location.reload();
				}
			}
			xmlhttp.open("POST","lib/jx_gen_balance.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("ident="+ident+
						"&fecha_bal="+fecha_bal);
	}
}
function guardar_banco() {
	var xmlhttp;
	var var_cuenta = document.getElementById('id_movcodcuenta').value;
	var var_nom_ba = document.getElementById('id_nom_banco').value;
	if (var_cuenta =='' || var_nom_ba == '' ) {
		if (var_cuenta =='' ) {
			document.getElementById('id_movcodcuenta').style.border = 'solid 1px red';
		} else{
			document.getElementById('id_movcodcuenta').style.border = 'solid 1px green';
		};
		if (var_nom_ba == '') {
			document.getElementById('id_nom_banco').style.border = 'solid 1px red';
		} else{
			document.getElementById('id_nom_banco').style.border = 'solid 1px green';
		};
	} else{
		document.getElementById('id_movcodcuenta').style.border = 'solid 1px green';
		document.getElementById('id_nom_banco').style.border = 'solid 1px green';
		document.getElementById('id_res_excepcion').innerHTML ='<img src="img/cargar.gif" alt="" />';

		var id_bancos= 0;
		var estad = 0;
		var identificador = 1 ; // envio uno para guardar banco
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		//alert(n);
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{			
			document.getElementById('id_res_excepcion').innerHTML = xmlhttp.responseText;
			location.reload();
		}
		}
		xmlhttp.open("POST","lib/jx_save_bancos.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("var_cuenta="+var_cuenta+
					"&var_nom_ba="+var_nom_ba+
					"&id_bancos="+id_bancos+
					"&estad="+estad+
					"&identificador="+identificador);

	};
}
function eliminar_activar_banc (id_banco, estado) {
	var xmlhttp;
	var id_bancos =id_banco;
	var estad = estado;
	var var_cuenta = '0.00.0.0';
	var var_nom_ba = 'SIN BANCO';
	var identificador = 2 ; //para actualizar el banco

	document.getElementById('id_res_excepcion').innerHTML ='<img src="img/cargar.gif" alt="" />';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{			
		document.getElementById('id_res_excepcion').innerHTML = xmlhttp.responseText;
		location.reload();
	}
	}
	xmlhttp.open("POST","lib/jx_save_bancos.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("var_cuenta="+var_cuenta+
				"&var_nom_ba="+var_nom_ba+
				"&id_bancos="+id_bancos+
				"&estad="+estad+
				"&identificador="+identificador);
}
function ver_chque (num_chequeandbanco) {
	//alert(num_cheque);
	var cadena=num_chequeandbanco;
	var elemt= cadena.split('|');
	var num_cheque=elemt[0];
	var banco=elemt[1];
	var cuenta = elemt[2];	
	document.getElementById('id_numchque_ch').value=num_cheque;
	document.getElementById('id_banco').value=banco;

	document.getElementById('id_div_saldo').innerHTML ='<img src="img/cargar1.gif" alt="" style="width:50px;" />';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{			
		document.getElementById('id_div_saldo').innerHTML = xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","lib/jx_saldos_bancos.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("cuenta="+cuenta);
}
function reportemovcuentas_gen()
{	
var xmlhttp;

var finicial=document.getElementById('id_movdesde').value;
var ffinal=document.getElementById('id_movhasta').value;
var codcuenta = document.getElementById('id_movcodcuenta').value;

if (finicial =='' || ffinal =='' || codcuenta =='') {
	if (finicial=='') {
		document.getElementById('id_movdesde').style.border ='solid 1px red';
	} else{
		document.getElementById('id_movdesde').style.border ='solid 1px green';
	};
	if (ffinal=='') {
		document.getElementById('id_movhasta').style.border ='solid 1px red';
	} else{
		document.getElementById('id_movhasta').style.border ='solid 1px green';
	};
	if (codcuenta=='') {
		document.getElementById('id_movcodcuenta').style.border ='solid 1px red';
	} else{
		document.getElementById('id_movcodcuenta').style.border ='solid 1px green';
	};
} else{
		document.getElementById('id_movdesde').style.border ='solid 1px green';
		document.getElementById('id_movhasta').style.border ='solid 1px green';
		document.getElementById('id_movcodcuenta').style.border ='solid 1px green';
		var cad="SELECT CP_NOMBRE,CP_APELLIDO,CP_CEDULA, COM_NUM_COMPROB, COM_TIPO_COMPR, COM_FEC_CREA, ASI_DEBE, ASI_HABER , COM_EPRESA FROM t_client_provee, ";
		cad = cad + " t_comprobante, t_asiento where COM_ESTADO_SIS= 1 AND ASI_CUENTA = '" + codcuenta + "' and ASI_FK_IDCOMPROB = IDT_COMPROBANTE ";
		cad = cad + " and COM_FKID_CLI_PROV = IDT_CLIENT_PROVEE and(COM_FEC_CREA BETWEEN '"+ finicial +"' and '"+ ffinal +"')";

		document.getElementById('id_resultadoreport').innerHTML = '<img src="img/cargar.gif" alt="" />';
		

		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		//alert(n);
		xmlhttp.onreadystatechange=function()
		{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			
		document.getElementById("id_resultadoreport").innerHTML=xmlhttp.responseText;
		}
		}
		xmlhttp.open("POST","lib/jx_rptmovcuentas_gen.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("cad1="+cad+
					"&cuenta="+codcuenta+
					"&fecha_ini="+finicial);
	};
};
// funcion que actulliza la el prodcuto de una cmpra en la border
function cambiar_prod_bd () {
	document.getElementById('id_div_res_updateret').innerHTML='<img src="img/cargar.gif" alt="" />';
	var IDT_DETALLES= document.getElementById('id_hd_idt_Detalles').value ;
	var DET_FK_IDPROD= document.getElementById('id_codprod').value;
	var DET_CANTIDAD= document.getElementById('id_cantpro').value;
	var V_UNIT= document.getElementById('id_v_unit').value;
	var V_TOT= document.getElementById('id_c_tot').value

	if (IDT_DETALLES =='' || DET_FK_IDPROD =='' || DET_CANTIDAD=='') {
		if (IDT_DETALLES =='') {
			alert('ALGO ANDA MAL CON EL PRODCUTO..RECARGE E INTENTE NUEVAMENTE.. SI EL ERROR PERSISTE COMUNIQUESE CON EL ADMINISTRADOR DEL SISTEMA');
		};
		if (DET_FK_IDPROD =='') {
			document.getElementById('id_codprod').style.border='solid 1px red';
		} else{
			document.getElementById('id_codprod').style.border='solid 1px green';
		};
		if (DET_CANTIDAD =='') {
			document.getElementById('id_cantpro').style.border='solid 1px red';
		} else{
			document.getElementById('id_cantpro').style.border='solid 1px green';
		};
	} else{
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		//alert(n);
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{				
				document.getElementById("id_div_res_updateret").innerHTML=xmlhttp.responseText;
				location.reload();
			}
		}
		xmlhttp.open("POST","lib/jx_update_prod_decompras.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("idt_prod="+IDT_DETALLES+
					"&cod_prod="+DET_FK_IDPROD+
					"&cant_prod="+DET_CANTIDAD+
					"&v_unit="+V_UNIT+
					"&v_tot="+V_TOT);
	};
}
function update_cuenta_asiento () {
	document.getElementById('id_res_update_asiento').innerHTML='<img src="img/cargar.gif" alt="" />';
	var desc_cuen = document.getElementById('id_desc_nu_as').value;
	var idt_asi = document.getElementById('id_idt_nu_as').value;
	var cod_cu = document.getElementById('id_codcu_nu_as').value;
	var debe_ = document.getElementById('id_debe_nu_as').value;
	var haber_ = document.getElementById('id_habe_nu_as').value;

	if (desc_cuen =='' || idt_asi=='' || cod_cu=='' || debe_=='' || haber_=='') {
		if (desc_cuen=='') {
			document.getElementById('id_desc_nu_as').style.border='solid 1px red';
		} else{
			document.getElementById('id_desc_nu_as').style.border='solid 1px green';
		};
		if (idt_asi=='') {
			document.getElementById('id_idt_nu_as').style.border='solid 1px red';
		} else{
			document.getElementById('id_idt_nu_as').style.border='solid 1px green';
		};
		if (cod_cu=='') {
			document.getElementById('id_codcu_nu_as').style.border='solid 1px red';
		} else{
			document.getElementById('id_codcu_nu_as').style.border='solid 1px green';
		};
		if (debe_=='') {
			document.getElementById('id_debe_nu_as').style.border='solid 1px red';
		} else{
			document.getElementById('id_debe_nu_as').style.border='solid 1px green';
		};
		if (haber_=='') {
			document.getElementById('id_habe_nu_as').style.border='solid 1px red';
		} else{
			document.getElementById('id_habe_nu_as').style.border='solid 1px green';
		};
	} else{
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		};
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("id_res_update_asiento").innerHTML=xmlhttp.responseText;
				//location.reload();
			}
		}
		xmlhttp.open("POST","lib/jx_update_asiento.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("desc_cuen="+desc_cuen+
					"&idt_asi="+idt_asi+
					"&cod_cu="+cod_cu+
					"&debe_="+debe_+
					"&haber_="+haber_);
	};
}
function mayorPorCLient () {
	

	var id_cli = document.getElementById('id_idt_cliente_prov').value

	if (id_cli=='') {
		document.getElementById('id_clienteprovee_glo').style.border= 'solid 1px red';
		document.getElementById("result_mayor").innerHTML= '<p style="background:red;text-align:center;font-size:20pz;">FALTAN DATOS</p>';
	} else{
		document.getElementById("result_mayor").innerHTML= '<img src="img/cargar.gif" alt="" />';
		document.getElementById('id_clienteprovee_glo').style.border= 'solid 1px green';
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		};
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("result_mayor").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("POST","lib/jx_mayoresPorCLi.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id_cli="+id_cli);

	};
}
function resporte_ret() {
	var var_fech_ini  =document.getElementById('id_lr_fech_desde').value;
	var var_fech_fin  =document.getElementById('id_lr_fech_hasta').value;
	if (var_fech_ini == '' || var_fech_fin=='') {
		if (var_fech_ini=='') {
			document.getElementById('id_lr_fech_desde').style.border= 'solid 1px red';
		}else{
			document.getElementById('id_lr_fech_desde').style.border= 'solid 1px green';
		};
		if (var_fech_fin=='') {
			document.getElementById('id_lr_fech_hasta').style.border= 'solid 1px red';
		}else{
			document.getElementById('id_lr_fech_hasta').style.border= 'solid 1px green';
		};
	}else{

		document.getElementById('id_lr_fech_desde').style.border= 'solid 1px green';
		document.getElementById('id_lr_fech_hasta').style.border= 'solid 1px green';

		for (var i = 0; i < document.frm_cosultas_ret.tipobusc.length; i++) {
			if (document.frm_cosultas_ret.tipobusc[i].checked) {
				var identific = document.frm_cosultas_ret.tipobusc[i].value ; 
				//alert(identific);
				break;
			};
		};		

		document.getElementById('id_res_rep_ret').innerHTML = '<img src="img/cargar.gif" alt="" />';
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		};
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById('id_res_rep_ret').innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("POST","lib/jx_libro_ret.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("identific1="+identific+
					"&var_fech_ini1="+var_fech_ini+
					"&var_fech_fin1="+var_fech_fin);
	};
	
}
function guardar_cuent_sald () {
	var identific = document.getElementById('id_identific').value;
	var cod_cuenta = document.getElementById('id_cuenta').value; 
	var nom_cuenta = document.getElementById('id_nom_cuentas').value; 
	var cod_cuenta_pad = document.getElementById('id_cuenta_pad').value; 
	var mov_cuenta = document.getElementById('id_mov').value; 
	var saldo1 = document.getElementById('id_saldo1').value; 
	var idt1= document.getElementById('id_idt1').value;
	var saldo2 = document.getElementById('id_saldo2').value;
	var idt2 = document.getElementById('id_idt2').value; 
	if (identific=='') {
		document.getElementById('id_Res_cuentas').innerHTML='<p style="background:red;">ERROR FATAL</p>';
	} else{
		if (cod_cuenta=='' || nom_cuenta=='' || cod_cuenta_pad=='' || mov_cuenta=='' || saldo1=='' || saldo2=='') {
			if (cod_cuenta=='') {
				document.getElementById('id_cuenta').style.border="solid 1px red";
			} else{
				document.getElementById('id_cuenta').style.border="solid 1px green";
			};
			if (nom_cuenta=='') {
				document.getElementById('id_nom_cuentas').style.border="solid 1px red";
			} else{
				document.getElementById('id_nom_cuentas').style.border="solid 1px green";
			};
			if (cod_cuenta_pad=='') {
				document.getElementById('id_cuenta_pad').style.border="solid 1px red";
			} else{
				document.getElementById('id_cuenta_pad').style.border="solid 1px green";
			};
			if (mov_cuenta=='') {
				document.getElementById('id_mov').style.border="solid 1px red";
			} else{
				document.getElementById('id_mov').style.border="solid 1px green";
			};
			if (saldo1=='') {
				document.getElementById('id_saldo1').style.border="solid 1px red";
			} else{
				document.getElementById('id_saldo1').style.border="solid 1px green";
			};
			if (saldo2=='') {
				document.getElementById('id_saldo2').style.border="solid 1px red";
			} else{
				document.getElementById('id_saldo2').style.border="solid 1px green";
			};
			document.getElementById('id_Res_cuentas').innerHTML='<p style="text-align:center;background:red;width:300px;padding:5px;border-radius:3px;margin:0 auto;">FALTA UN DATO</p>';
		} else{
			document.getElementById('id_cuenta').style.border="solid 1px green";
			document.getElementById('id_nom_cuentas').style.border="solid 1px green";
			document.getElementById('id_cuenta_pad').style.border="solid 1px green";
			document.getElementById('id_mov').style.border="solid 1px green";
			document.getElementById('id_saldo1').style.border="solid 1px green";
			document.getElementById('id_saldo2').style.border="solid 1px green";
			document.getElementById('id_Res_cuentas').innerHTML='<img src="img/cargar.gif" alt="" />';
			if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}else{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			};
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById('id_Res_cuentas').innerHTML=xmlhttp.responseText;
				}
			}
			xmlhttp.open("POST","lib/jx_inser_upd_cuentas.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("identific="+identific+
						"&cod_cuenta="+cod_cuenta+
						"&nom_cuenta="+nom_cuenta+
						"&cod_cuenta_pad="+cod_cuenta_pad+
						"&mov_cuenta="+mov_cuenta+
						"&saldo1="+saldo1+
						"&idt1="+idt1+
						"&saldo2="+saldo2+
						"&idt2="+idt2);
		};
	};
}
function sacar_cuenta (cupadre) {
	document.getElementById('id_cuenta').value= cupadre;
	document.getElementById('id_cuenta').focus();
	document.getElementById('id_Res_cuentas').innerHTML='<img src="img/cargar.gif" alt="" /><br><h4>BUSCANDO ULTIMA CUENTA...!</h4>';
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	};
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			//document.getElementById('id_Res_cuentas').innerHTML=xmlhttp.responseText;
			document.getElementById('id_cuenta').value =xmlhttp.responseText;
			
			var nueva_cuenta =  xmlhttp.responseText;
			var longi = nueva_cuenta.length ;
			if (longi == 1) {
				longi1= longi-1;
			} else{
				longi1= longi -2;
			};
			var nuevo_itm = nueva_cuenta.substring(longi1, longi);
			nuevo_itm= nuevo_itm.replace(".", "");
			if (isNaN(nuevo_itm) || nuevo_itm =='') {
				nuevo_itm = 0;
			};
			var num = parseFloat(nuevo_itm) +1;
			var cad ='<p style="font-size:20px;margin:0;;background:green;">LA UTLIMA CUENTA ES :<strong>'+ xmlhttp.responseText +' </strong></p>';
			cad= cad +'<p style="font-size:20px;margin:0;;background:green;">SIGUIENTE RECOMENDADO ES <strong>'+cupadre+'.0'+num+'</strong> </p>';
			document.getElementById('id_Res_cuentas').innerHTML = cad;
			document.getElementById('id_cuenta').value= cupadre+'.'+num;
			document.getElementById('id_cuenta').style.background="#FEFC93";
			//document.getElementById('id_Res_cuentas').innerHTML='';
		}
	}
	xmlhttp.open("POST","lib/jx_sig_cunetahija.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("cupadre="+cupadre);
}
function searchdocs (texto, identific) {
	var xmlhttp;
	if (identific == '1') {
		//document.getElementById('id_busc_doc_af').value='';
		document.getElementById('id_idt_doc_af').value='';
		document.getElementById('id_tip_doc_af').value='';
		document.getElementById('id_num_doc_af').value='';
		document.getElementById('id_fec_doc_af').value='';
		document.getElementById('id_esp_doc_af').value='';
		document.getElementById('id_ess_doc_af').value='';
		document.getElementById('id_subt_doc_af').value='';
		document.getElementById('id_bas0_doc_af').value='';
		document.getElementById('id_ba12_doc_af').value='';
		document.getElementById('id_tota_doc_af').value='';
		document.getElementById('id_sald_doc_af').value='';
		document.getElementById('id_abon_doc_af').value='';
	};

	if (texto=='') {
	 	document.getElementById('id_div_search_docs').style.display='none';
	}else{
		document.getElementById('id_div_search_docs').style.display='block';
		document.getElementById('id_div_search_docs').innerHTML='<img src="img/cargar.gif" alt="" style="width:100px;"/>'
	 	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("id_div_search_docs").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("POST","lib/jx_search_docs.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("texto="+texto+
					"&identific="+identific);
	};	
}
function mostar_comp_avanz (IDT_COMPROBANTE,COM_TIPO_COMPR) {
	var xmlhttp;
	document.getElementById("id_cl_div_res_det_avan").innerHTML='<img src="img/cargar.gif" alt="" />';
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("id_cl_div_res_det_avan").innerHTML=xmlhttp.responseText;			
		}
	}
	xmlhttp.open("POST","lib/jx_det_avanzado.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("idt_comp="+IDT_COMPROBANTE+
				"&tipo_comp="+COM_TIPO_COMPR);
}
function agrega_al_pag () {
	var val_pago = prompt("INGRESE EL VALOR QUE VA EN EL ABONO", "0.00");
	var id_total_ed = document.getElementById('id_total_ed').value;
	if (parseFloat(val_pago) <= 0  ) {
	    document.getElementById("id_cl_div_res_det_avan").innerHTML = '<p style="font-size:20px;background:red;border-radius:5px;">El valor es menor o se sale de los limites del pago</p>';
	}else{
		var tipo_doc_sup = document.getElementById('id_tip_doc_ed').value; // tipo de comprobabte superio
		var nume_doc_sup = document.getElementById('id_num_doc_ed').value; //15 dig del comprobate suoperir
		var idt_doc_sup = document.getElementById('id_idt_doc_ed').value; //id del doc superior
		var tipo_doc_hij = document.getElementById('id_tip_doc_af').value;
		var nume_doc_hij = document.getElementById('id_num_doc_af').value;
		var idt_doc_hij = document.getElementById('id_idt_doc_af').value;
		var id_fec_doc_af = document.getElementById('id_fec_doc_af').value;
		var id_esp_doc_af = document.getElementById('id_esp_doc_af').value;
		var id_ess_doc_af = document.getElementById('id_ess_doc_af').value;
		var id_subt_doc_af = document.getElementById('id_subt_doc_af').value;
		var id_bas0_doc_af = document.getElementById('id_bas0_doc_af').value;
		var id_ba12_doc_af = document.getElementById('id_ba12_doc_af').value;
		var id_iva_doc_af = document.getElementById('id_iva_doc_af').value;
		var id_tota_doc_af = document.getElementById('id_tota_doc_af').value;
		var id_sald_doc_af = document.getElementById('id_sald_doc_af').value;
		var id_abon_doc_af = document.getElementById('id_abon_doc_af').value;
		if (tipo_doc_sup=='' || nume_doc_sup=='' || idt_doc_sup=='' || tipo_doc_hij=='' || nume_doc_hij=='' || idt_doc_hij=='' || id_fec_doc_af=='' || id_esp_doc_af=='' || id_ess_doc_af=='' || id_subt_doc_af=='' || id_bas0_doc_af=='' || id_ba12_doc_af=='' || id_iva_doc_af=='' || id_tota_doc_af=='' || id_sald_doc_af=='' || id_abon_doc_af=='') {
			if (tipo_doc_sup=='') {
				alert('HA OCURRIDO UN ERROR RECARGE Y VUELVA A INTENTAR');
			};
			if (nume_doc_sup=='') {
				alert('HA OCURRIDO UN ERROR RECARGE Y VUELVA A INTENTAR');
			};
			if (idt_doc_sup=='') {
				alert('HA OCURRIDO UN ERROR RECARGE Y VUELVA A INTENTAR');
			};
			if (tipo_doc_hij=='') {
				alert('HA OCURRIDO UN ERROR RECARGE Y VUELVA A INTENTAR');
			};
			if (nume_doc_hij=='') {
				alert('HA OCURRIDO UN ERROR RECARGE Y VUELVA A INTENTAR');
			};
			if (idt_doc_hij=='') {
				alert('HA OCURRIDO UN ERROR RECARGE Y VUELVA A INTENTAR');
			};
			if (id_fec_doc_af=='') {
				document.getElementById('id_fec_doc_af').style.border='solid 1px red';
			} else{
				document.getElementById('id_fec_doc_af').style.border='solid 1px green';
			};
			if (id_esp_doc_af=='') {
				document.getElementById('id_esp_doc_af').style.border='solid 1px red';
			} else{
				document.getElementById('id_esp_doc_af').style.border='solid 1px green';
			};
			if (id_ess_doc_af=='') {
				document.getElementById('id_ess_doc_af').style.border='solid 1px red';
			} else{
				document.getElementById('id_ess_doc_af').style.border='solid 1px green';
			};
			if (id_subt_doc_af=='') {
				document.getElementById('id_subt_doc_af').style.border='solid 1px red';
			} else{
				document.getElementById('id_subt_doc_af').style.border='solid 1px green';
			};
			if (id_bas0_doc_af=='') {
				document.getElementById('id_bas0_doc_af').style.border='solid 1px red';
			} else{
				document.getElementById('id_bas0_doc_af').style.border='solid 1px green';
			};
			if (id_ba12_doc_af=='') {
				document.getElementById('id_ba12_doc_af').style.border='solid 1px red';
			} else{
				document.getElementById('id_ba12_doc_af').style.border='solid 1px green';
			};
			if (id_iva_doc_af=='') {
				document.getElementById('id_iva_doc_af').style.border='solid 1px red';
			} else{
				document.getElementById('id_iva_doc_af').style.border='solid 1px green';
			};
			if (id_tota_doc_af=='') {
				document.getElementById('id_tota_doc_af').style.border='solid 1px red';
			} else{
				document.getElementById('id_tota_doc_af').style.border='solid 1px green';
			};
			if (id_sald_doc_af=='') {
				document.getElementById('id_sald_doc_af').style.border='solid 1px red';
			} else{
				document.getElementById('id_sald_doc_af').style.border='solid 1px green';
			};
			if (id_abon_doc_af=='') {
				document.getElementById('id_abon_doc_af').style.border='solid 1px red';
			} else{
				document.getElementById('id_abon_doc_af').style.border='solid 1px green';
			};

		} else{
			document.getElementById('id_fec_doc_af').style.border='solid 1px green';
			document.getElementById('id_esp_doc_af').style.border='solid 1px green';
			document.getElementById('id_ess_doc_af').style.border='solid 1px green';
			document.getElementById('id_subt_doc_af').style.border='solid 1px green';
			document.getElementById('id_bas0_doc_af').style.border='solid 1px green';
			document.getElementById('id_ba12_doc_af').style.border='solid 1px green';
			document.getElementById('id_iva_doc_af').style.border='solid 1px green';
			document.getElementById('id_tota_doc_af').style.border='solid 1px green';
			document.getElementById('id_sald_doc_af').style.border='solid 1px green';
			document.getElementById('id_abon_doc_af').style.border='solid 1px green';

			var xmlhttp;
			document.getElementById("id_cl_div_res_det_avan").innerHTML='<img src="img/cargar.gif" alt="" />';
			if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
			}else{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("id_cl_div_res_det_avan").innerHTML=xmlhttp.responseText;			
				}
			}
			xmlhttp.open("POST","lib/jx_agrg_pag.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("tipo_doc_sup="+tipo_doc_sup+
						"&nume_doc_sup="+nume_doc_sup+
						"&idt_doc_sup="+idt_doc_sup+
						"&tipo_doc_hij="+tipo_doc_hij+
						"&nume_doc_hij="+nume_doc_hij+
						"&idt_doc_hij="+idt_doc_hij+
						"&id_fec_doc_af="+id_fec_doc_af+
						"&id_esp_doc_af="+id_esp_doc_af+
						"&id_ess_doc_af="+id_ess_doc_af+
						"&id_subt_doc_af="+id_subt_doc_af+
						"&id_bas0_doc_af="+id_bas0_doc_af+
						"&id_ba12_doc_af="+id_ba12_doc_af+
						"&id_iva_doc_af="+id_iva_doc_af+
						"&id_tota_doc_af="+id_tota_doc_af+
						"&id_sald_doc_af="+id_sald_doc_af+
						"&id_abon_doc_af="+id_abon_doc_af+
						"&val_pago="+val_pago);
		};
	}
}
function agregar_prod_avnz () {
	var var_prod_l_ingre = document.getElementById('id_product_ingr_l').value;
	var var_codi_l_ingre = document.getElementById('id_codprod_ingr_l').value;
	var var_cant_l_ingre = document.getElementById('id_cantpro_ingr_l').value;
	var var_valu_l_ingre = document.getElementById('id_valprod_ingr_l').value;
	var var_valt_l_ingre = document.getElementById('id_valtotp_ingr_l').value;
	var var_id_tip_doc_ed = document.getElementById('id_tip_doc_ed').value;
	var var_id_num_doc_ed = document.getElementById('id_num_doc_ed').value;
	var var_id_idt_doc_ed = document.getElementById('id_idt_doc_ed') .value;

	if (var_prod_l_ingre=='' || var_codi_l_ingre == '' || var_cant_l_ingre=='' || var_valu_l_ingre=='' || var_valt_l_ingre=='' ||var_cant_l_ingre=='0' || var_valu_l_ingre=='0' || var_valt_l_ingre=='0') {
		if (var_prod_l_ingre=='') {
			document.getElementById('id_product_ingr_l').style.border='red solid 1px';
		} else{
			document.getElementById('id_product_ingr_l').style.border='green solid 1px';
		};
		if (var_codi_l_ingre=='') {
			document.getElementById('id_codprod_ingr_l').style.border='red solid 1px';
		} else{
			document.getElementById('id_codprod_ingr_l').style.border='green solid 1px';
		};
		if (var_cant_l_ingre=='' || var_cant_l_ingre=='0' || var_cant_l_ingre==0) {
			document.getElementById('id_cantpro_ingr_l').style.border='red solid 1px';
		} else{
			document.getElementById('id_cantpro_ingr_l').style.border='green solid 1px';
		};
		if (var_valu_l_ingre=='' || var_valu_l_ingre=='0' || var_valu_l_ingre==0) {
			document.getElementById('id_valprod_ingr_l').style.border='red solid 1px';
		} else{
			document.getElementById('id_valprod_ingr_l').style.border='green solid 1px';
		};
		if (var_valt_l_ingre=='' || var_valt_l_ingre=='0' || var_valt_l_ingre==0) {
			document.getElementById('id_valtotp_ingr_l').style.border='red solid 1px';
		} else{
			document.getElementById('id_valtotp_ingr_l').style.border='green solid 1px';
		};
	} else{
		document.getElementById('id_product_ingr_l').style.border='green solid 1px';
		document.getElementById('id_codprod_ingr_l').style.border='green solid 1px';
		document.getElementById('id_cantpro_ingr_l').style.border='green solid 1px';
		document.getElementById('id_valprod_ingr_l').style.border='green solid 1px';
		document.getElementById('id_valtotp_ingr_l').style.border='green solid 1px';

		var xmlhttp;
		document.getElementById("id_cl_div_res_det_avan").innerHTML='<img src="img/cargar.gif" alt="" />';
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
		}else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("id_cl_div_res_det_avan").innerHTML=xmlhttp.responseText;			
			}
		}
		xmlhttp.open("POST","lib/jx_agrg_prod_avnz.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("var_prod_l_ingre="+var_prod_l_ingre+
					"&var_codi_l_ingre="+var_codi_l_ingre+
					"&var_cant_l_ingre="+var_cant_l_ingre+
					"&var_valu_l_ingre="+var_valu_l_ingre+
					"&var_valt_l_ingre="+var_valt_l_ingre+
					"&var_id_tip_doc_ed="+var_id_tip_doc_ed+
					"&var_id_num_doc_ed="+var_id_num_doc_ed+
					"&var_id_idt_doc_ed="+var_id_idt_doc_ed);
	};
}
function buscar_xmls () {
	var carp = document.getElementById('id_carpeta').value; 
	var empr = document.getElementById('id_empresa').value; 
	var maxf = document.getElementById('id_max_fact').value;
	if (carp=='' || empr=='' || maxf=='') {
		if (carp=='') {
			document.getElementById('id_carpeta').style.border="solid 1px red"; 
		} else{
			document.getElementById('id_carpeta').style.border="solid 1px green"; 
		};
		if (empr=='') {
			document.getElementById('id_empresa').style.border="solid 1px red"; 
		} else{
			document.getElementById('id_empresa').style.border="solid 1px green"; 
		};
		if (maxf=='') {
			document.getElementById('id_max_fact').style.border="solid 1px red";
		} else{
			document.getElementById('id_max_fact').style.border="solid 1px green";
		};
	} else{
		document.getElementById('id_carpeta').style.border="solid 1px green"; 
		document.getElementById('id_empresa').style.border="solid 1px green"; 
		document.getElementById('id_max_fact').style.border="solid 1px green";

		var xmlhttp;
		document.getElementById("id_res_arch").innerHTML='<img src="img/cargar.gif" alt="" />';
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
		}else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("id_res_arch").innerHTML=xmlhttp.responseText;			
			}
		}
		xmlhttp.open("POST","lib/jx_lectura_xml.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("carp="+carp+
					"&empr="+empr+
					"&maxf="+maxf);
	};
}
function cargar_Detalleperfil () {
	var tipo_trans = document.getElementById('id_tipoTrans').value; 
	var forma_pago = document.getElementById('id_formaPag').value; 
	var tipo_contr = document.getElementById('id_TipoContrib').value; 
	if (tipo_trans == '' || forma_pago =='' || tipo_contr=='') {
		if (tipo_trans=='') {
			document.getElementById('id_tipoTrans').style.border = "solid 1px red";
		} else{
			document.getElementById('id_tipoTrans').style.border = "solid 1px green";
		};
		if (forma_pago=='') {
			document.getElementById('id_formaPag').style.border = "solid 1px red";
		} else{
			document.getElementById('id_formaPag').style.border = "solid 1px green";
		};
		if (tipo_contr=='') {
			document.getElementById('id_TipoContrib').style.border = "solid 1px red";
		} else{
			document.getElementById('id_TipoContrib').style.border = "solid 1px green";
		};
	} else{
		document.getElementById('id_tipoTrans').style.border = "solid 1px green";
		document.getElementById('id_formaPag').style.border = "solid 1px green";
		document.getElementById('id_TipoContrib').style.border = "solid 1px green";

		var xmlhttp;
		document.getElementById("id_divRespDetPerf").innerHTML='<img src="img/cargar.gif" alt="" />';
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
		}else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("id_divRespDetPerf").innerHTML=xmlhttp.responseText;			
			}
		}
		xmlhttp.open("POST","lib/jx_cargarDEtPerf.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("tipo_trans="+tipo_trans+
					"&forma_pago="+forma_pago+
					"&tipo_contr="+tipo_contr);

	};
}
function limpiarDetP () {
	document.getElementById("id_divRespDetPerf").innerHTML="";
	cargar_Detalleperfil ();
}
function mostraFormCuen (PCU_DESCRIPCION,IDT_DETALLE_PERFIL, PCU_CUENTA,DETP_TIPO,DETP_PORCENTAJE ) {
	document.getElementById('id_newNomCuent').value = "";
	document.getElementById('id_idt_detperf').value = "";
	document.getElementById('id_newCodCuent').value = "";
	document.getElementById('id_newTipoHab').value = "";
	document.getElementById('id_newPorcent').value = "";
	document.getElementById('id_div_formNewCuent').style.display="block";
	document.getElementById('id_newNomCuent').value = PCU_DESCRIPCION;
	document.getElementById('id_idt_detperf').value = IDT_DETALLE_PERFIL;
	document.getElementById('id_newCodCuent').value = PCU_CUENTA;
	document.getElementById('id_newTipoHab').value = DETP_TIPO;
	document.getElementById('id_newPorcent').value = DETP_PORCENTAJE;
}function ActCuentaDetPerf() {
	var PCU_DESCRIPCION = document.getElementById('id_newNomCuent').value;
	var IDT_DETALLE_PERFIL = document.getElementById('id_idt_detperf').value;
	var PCU_CUENTA = document.getElementById('id_newCodCuent').value;
	var DETP_TIPO = document.getElementById('id_newTipoHab').value;
	var DETP_PORCENTAJE = document.getElementById('id_newPorcent').value;
	if (PCU_DESCRIPCION =='' || IDT_DETALLE_PERFIL =='' || PCU_CUENTA=='' || DETP_TIPO=='' || DETP_PORCENTAJE == '') {
		if (PCU_DESCRIPCION=='') {
			document.getElementById('id_newNomCuent').style.border="solid 1px red";
		} else{
			document.getElementById('id_newNomCuent').style.border="solid 1px green";
		};
		if (IDT_DETALLE_PERFIL=='') {
			alert('Tiene un Error Grave vuelva a cargar el formulario he intente nuevamente');
		} 
		if (PCU_CUENTA=='') {
			document.getElementById('id_newCodCuent').style.border="solid 1px red";
		} else{
			document.getElementById('id_newCodCuent').style.border="solid 1px green";
		};
		if (DETP_TIPO=='') {
			document.getElementById('id_newTipoHab').style.border="solid 1px red";
		} else{
			document.getElementById('id_newTipoHab').style.border="solid 1px green";
		};
		if (DETP_PORCENTAJE=='') {
			document.getElementById('id_newPorcent').style.border="solid 1px red";
		} else{
			document.getElementById('id_newPorcent').style.border="solid 1px green";
		};
	} else{
		document.getElementById('id_newNomCuent').style.border="solid 1px green";
		document.getElementById('id_newCodCuent').style.border="solid 1px green";
		document.getElementById('id_newTipoHab').style.border="solid 1px green";
		document.getElementById('id_newPorcent').style.border="solid 1px green";

		var xmlhttp;
		document.getElementById("id_divRespDetPerf").innerHTML='<img src="img/cargar.gif" alt="" />';
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
		}else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("id_divRespDetPerf").innerHTML=xmlhttp.responseText;
				setTimeout ('espere', 5000); 
				cargar_Detalleperfil ();			
			}
		}
		xmlhttp.open("POST","lib/jx_editCuenDetPerf.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("PCU_DESCRIPCION="+PCU_DESCRIPCION+
					"&IDT_DETALLE_PERFIL="+IDT_DETALLE_PERFIL+
					"&PCU_CUENTA="+PCU_CUENTA+
					"&DETP_TIPO="+DETP_TIPO+
					"&DETP_PORCENTAJE="+DETP_PORCENTAJE);

	};
}
function genLibDiar () {
	var fecha = document.getElementById('id_fehcaLibDiar').value;
	var fecha2 = document.getElementById('id_fehcaLibDiar2').value;
	if (fecha =='' || fecha2 =='') {
		if (fecha=='') {
			document.getElementById('id_fehcaLibDiar').style.border='solid 1px red';
		} else{
			document.getElementById('id_fehcaLibDiar').style.border='solid 1px green';
		};
		if (fecha2=='') {
			document.getElementById('id_fehcaLibDiar2').style.border='solid 1px red';
		} else{			
			document.getElementById('id_fehcaLibDiar2').style.border='solid 1px green';
		};
	} else{
		document.getElementById('id_fehcaLibDiar').style.border='solid 1px green';
		document.getElementById('id_fehcaLibDiar2').style.border='solid 1px green';
		var xmlhttp;
		document.getElementById("id_LibDiario").innerHTML='<img src="img/cargar.gif" alt="" />';
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
		}else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("id_LibDiario").innerHTML=xmlhttp.responseText;			
			}
		}
		xmlhttp.open("POST","lib/jx_libDiario.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("fecha="+fecha+
					"&fecha2="+fecha2);
	};
}
function genLibMayor () {
	var fecha = document.getElementById('id_fehcaLibMayor').value;
	var xmlhttp;
	document.getElementById("id_divLibMayor").innerHTML='<img src="img/cargar.gif" alt="" />';
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("id_divLibMayor").innerHTML=xmlhttp.responseText;	
			location.reload();		
		}
	}
	xmlhttp.open("POST","lib/jx_libMayor.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("fecha="+fecha);
}
function mayorPorFecha () {
	var fech1 = document.getElementById('id_facha1').value
	var fech2 = document.getElementById('id_facha2').value
	if (fech1=='' || fech2=='') {
		if (fech1=='') {
			document.getElementById('id_facha1').style.border='solid 1px red';
		} else{
			document.getElementById('id_facha1').style.border='solid 1px green';
		};
		if (fech2=='') {
			document.getElementById('id_facha2').style.border='solid 1px red';
		} else{
			document.getElementById('id_facha2').style.border='solid 1px green';
		};
		document.getElementById("result_mayor").innerHTML= '<p style="background:red;text-align:center;font-size:20pz;">FALTAN DATOS</p>';
	} else{
		document.getElementById("result_mayor").innerHTML= '<img src="img/cargar.gif" alt="" />';
		document.getElementById('id_facha1').style.border= 'solid 1px green';
		document.getElementById('id_facha2').style.border= 'solid 1px green';
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		};
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("result_mayor").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("POST","lib/jx_mayoresPorFech.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("fech1="+fech1+
					"&fech2="+fech2);

	};
}
function mayorPorProveedor() {
	var id_cli = document.getElementById('id_idt_cliente_prov').value

	if (id_cli=='') {
		document.getElementById('id_clienteprovee_glo').style.border= 'solid 1px red';
		document.getElementById("result_mayor").innerHTML= '<p style="background:red;text-align:center;font-size:20pz;">FALTAN DATOS</p>';
	} else{
		document.getElementById("result_mayor").innerHTML= '<img src="img/cargar.gif" alt="" />';
		document.getElementById('id_clienteprovee_glo').style.border= 'solid 1px green';
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		};
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("result_mayor").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("POST","lib/jx_mayoresPorProvee.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id_cli="+id_cli);

	};
}
function actvalcompProd () {
	var xmlhttp;
	var idProd = document.getElementById('id_regpcod').value 
	var valCom = document.getElementById('idValCompr').value 
	if (idProd=='' || valCom=='') {
		if (idProd=='') {
			document.getElementById('id_regpcod').style.border='solid 1px red';
		} else{
			document.getElementById('id_regpcod').style.border='solid 1px green';
		};
		if (valCom=='') {
			document.getElementById('idValCompr').style.border='solid 1px red';
		} else{
			document.getElementById('idValCompr').style.border='solid 1px green';
		};
		document.getElementById("idDivAnuncioProd").innerHTML= '<p style="background:red;text-align:center;font-size:20pz;">FALTAN DATOS</p>';
	} else{
		document.getElementById("idDivAnuncioProd").innerHTML= '<img src="img/cargar.gif" alt="" />';
		document.getElementById('id_regpcod').style.border='solid 1px green';
		document.getElementById('idValCompr').style.border='solid 1px green';
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}else{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		};
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("idDivAnuncioProd").innerHTML=xmlhttp.responseText;
				location.reload();
			}
		}
		xmlhttp.open("POST","lib/jxCambiarValCompraPRod.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("idProd="+idProd+
					"&valCom="+valCom);
	}
}