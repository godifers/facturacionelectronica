var pocentIVAglobal = document.getElementById('id_globIVA').value;
function mostarcliente(id_cli,ced,ape,nom,dir,telf,ciudda,mail,estado,ruc_ced_pas,val_cred,tipocontrib,identificador,saldo,new_saldo,tipo_cli_prove,plazo){	
	if (identificador==1){ //llenar los datos para las vetas 
		document.getElementById('id_clienteprovee_glo').value= nom+' '+ape;
		document.getElementById('id_ruc_ced').value= ced;
		document.getElementById('id_hdidcliente').value=id_cli;
		if (ruc_ced_pas==1){
			tipodeid='Cedula';
			check_cedula_ventas(ced);
		}else if(ruc_ced_pas==2){
			tipodeid='RUC';
			validarRuc_ventas(ced);
		}else if (ruc_ced_pas==4){ 
			tipodeid='Extranjero';
		}else if (ruc_ced_pas==3){ 
			tipodeid='CONSUMIDOR FINAL';
		};

		document.getElementById('id_creddipo').value=val_cred;
		document.getElementById('id_saldo_cli').value = saldo;
		document.getElementById('id_new_cupo').value=new_saldo;
		document.getElementById('id_tipoide').value=tipodeid;
	}else if(identificador==2){
		document.getElementById('id_clienteprovee_glo').value= nom+' '+ape;
		document.getElementById('id_ruc_ced').value= ced;
		if (tipocontrib==1) { // llenar los datos de compras 
			var textocontrib= 'Público';
			var coloralerta='green';
		}else if (tipocontrib==2) {
			var textocontrib='Especial';
			var coloralerta='green';
		}else if (tipocontrib==3) {
			var textocontrib='Obligado Contabilidad';
			var coloralerta='green';	
		}else if (tipocontrib==4) {
			var textocontrib='No obligado';
			var coloralerta='green';
		}else if (tipocontrib==5) {
			var textocontrib='Rise';
			var coloralerta='green';
		}else{
			var textocontrib='Verificar';
			var coloralerta='red';
		};
		document.getElementById('id_contribuyente').value=textocontrib;		
		document.getElementById('id_prov_cli').value=id_cli;	
		document.getElementById('id_contribuyente').style.background=coloralerta;
		//-----------------------------------------
	}else if(identificador==3){ //llenar los datos para  la ediciond clientes 
		document.getElementById('id_adccliente').value=nom;
		document.getElementById('id_adcapellido').value=ape;
		document.getElementById('id_adccontribuyente').value=tipocontrib;
		document.getElementById('id_adctelf').value=telf;
		document.getElementById('id_adcdumento').value=ruc_ced_pas;
		document.getElementById('id_adcnumdoc').value=ced;
		document.getElementById('id_adcdirecc').value=dir;
		document.getElementById('id_adcciudad').value=ciudda;
		document.getElementById('id_adcmail').value=mail;
		document.getElementById('id_adccredito').value=val_cred;
		document.getElementById('id_adcestado').value=estado;
		document.getElementById('id_plazo').value=plazo;
		document.getElementById('id_texto_cli').value='EDITANDO..';
		document.getElementById('id_texto_cli').style.background='red';
		document.getElementById('id_identificador').value=id_cli;
		document.getElementById('id_tipo').value=tipo_cli_prove;
		
	}else if(identificador==4){	
		document.getElementById('id_clienteprovee_glo').value=nom+' '+ape;
		document.getElementById('id_reccedul').value= ced;
		document.getElementById('id_hdn_cli_prov').value=id_cli;	
	}else if(identificador==5){		
		document.getElementById('id_clienteprovee_glo').value=nom+' '+ape;
		document.getElementById('id_cobcedula').value=ced;	
		document.getElementById('id_cidtcliente').value=id_cli;	
				//document.getElementById('id_adcplazo').value=;	
	}else if(identificador==6){		
		document.getElementById('id_clienteprovee_glo').value=nom+' '+ape;
		document.getElementById('id_idt_cliente_prov').value=id_cli;	
	}else if(identificador==7){		
		document.getElementById('id_clienteprovee_glo').value=nom+' '+ape;
		document.getElementById('id_nombrepago_ch').value=nom+' '+ape;
		document.getElementById('id_cobcedula').value=ced;	
		document.getElementById('id_cidtcliente').value=id_cli;	
				//document.getElementById('id_adcplazo').value=;	
	}else if(identificador==8){		
		document.getElementById('id_clienteprovee_glo').value=nom+' '+ape;
		document.getElementById('id_id_provee_comp').value=id_cli;	
		document.getElementById('id_ruc_provee_comp').value=ced;	
				//document.getElementById('id_adcplazo').value=;	
	};
	document.getElementById("id_div_clientes").style.display="none";
}
//******************************************VALIDADOR DE CEDULAS AL MOMENTO DE FACTURAR******************************************************
function check_cedula_ventas(ced) {
    var cedula = ced;
    array = cedula.split("");
    num = array.length;

    if (num == 10) {
        total = 0;
        digito = (array[9] * 1);
        for (i = 0; i < (num - 1) ; i++) {
            mult = 0;
            if ((i % 2) != 0) {
                total = total + (array[i] * 1);
            }
            else {
                mult = array[i] * 2;
                if (mult > 9)
                    total = total + (mult - 9);
                else
                    total = total + mult;
            }
        }
        decena = total / 10;
        decena = Math.floor(decena);
        decena = (decena + 1) * 10;
        final = (decena - total);
        if ((final == 10 && digito == 0) || (final == digito)) {
            //alert("La c\xe9dula ES v\xe1lida!!!" );
            return true;
        }
        else {
        	alert("LA CEDULA NO ES CORRECTA...!");
            document.getElementById("id_aviso_factura").innerHTML='<p style="background:red;padding:5px;border-radius:4px;">LA CEDULA NO ES CORRECTA...!</p>';
            //return false;
        }
    }
    else {
    	alert("LA CEDULA NO TIENE 10 DIGITOS");
        document.getElementById("id_aviso_factura").innerHTML='<p style="background:red;padding:5px;border-radius:4px;">LA CEDULA NO TIENE 10 DIGITOS</p>';
        //return false;
    }
}
/////////////FUNCION VALIDAR RUC
function validarRuc_ventas(ruc) {
    var number = ruc;
    var dto = number.length;
    var valor;
    var acu = 0;

    if (number == "") {
        alert('No has ingresado ningún dato, porfavor ingresar los datos correspondientes.');
        document.getElementById("id_aviso_factura").innerHTML='<p style="background:red;padding:5px;border-radius:4px;">No has ingresado ningún dato, porfavor ingresar los datos correspondientes.</p>';
    }
    else {

        if (dto != 13) {
            alert('EL RUC DEBE TENER 13 DIGITOS');
            document.getElementById("id_aviso_factura").innerHTML='<p style="background:red;padding:5px;border-radius:4px;">EL RUC DEBE TENER 13 DIGITOS</p>';
        }

        else {
            for (var i = 0; i < dto; i++) {
                valor = number.substring(i, i + 1);
                if (valor == 0 || valor == 1 || valor == 2 || valor == 3 || valor == 4 || valor == 5 || valor == 6 || valor == 7 || valor == 8 || valor == 9) {
                    acu = acu + 1;
                }
            }
            if (acu == dto) {
                while (number.substring(10, 13) != 001) {                    
                    document.getElementById("id_aviso_factura").innerHTML='<p style="background:yellow;padding:5px;border-radius:4px;">Los tres últimos dígitos no tienen el código del RUC 001.</p>';
                    return;
                }
                while (number.substring(0, 2) > 24) {
                     document.getElementById("id_aviso_factura").innerHTML='<p style="background:red;padding:5px;border-radius:4px;">Los dos primeros dígitos no pueden ser mayores a 24.</p>';
                    return;
                }
                //alert('El RUC está escrito correctamente');
                //alert('Se procederá a analizar el respectivo RUC.');
                var porcion1 = number.substring(2, 3);
                if (porcion1 < 6) {
                    document.getElementById("id_aviso_factura").innerHTML='<p style="background:yellow;padding:5px;border-radius:4px;">Persona natural.</p>';
                }
                else {
                    if (porcion1 == 6) {
                        document.getElementById("id_aviso_factura").innerHTML='<p style="background:yellow;padding:5px;border-radius:4px;">Entidad pública.</p>';
                    }
                    else {
                        if (porcion1 == 9) {
                            document.getElementById("id_aviso_factura").innerHTML='<p style="background:yellow;padding:5px;border-radius:4px;">Sociedad privada.</p>';
                        }
                    }
                }
            }

            else {
                alert("ERROR: Por favor no ingrese texto");
            }
        }
    }
}
//*****************************************FIN DE VALIDADOR DE CEDULAS AL MOMENTO DE FACTURAR**********************************************
function mostrarprodcutos(idpro,detpr,presenpro,iva,estadopro,tipopro,stock,valcompra,vmin,vmed,vmax,codbarras,pvp,prov,identificador, val_ini){
	if(identificador==1){ // ventas
		document.getElementById('id_codprod').value = idpro;
		document.getElementById('id_product').value = detpr+' '+presenpro;		
		document.getElementById('id_vmin').value = vmin;
		document.getElementById('id_vmed').value= vmed;
		document.getElementById('id_vmax').value =vmax;
		document.getElementById('id_stockact').value= stock; 
		document.getElementById('id_hdivapr').value= iva; 
		document.getElementById('id_vacompra').value=valcompra;
		if (stock <=20){
			color='red';
		}else if(stock>20 && stock <=30){
			color='yellow';
		}else if(stock>30){
			color ='green'
		}
		document.getElementById('id_stockact').style.background =color;
		document.getElementById('id_cantpro').focus();

		//document.getElementById('id_ruc_ced').value= ced;
		//document.getElementById('id_hdidcliente').value=id_cli;
		document.getElementById("id_div_filtroprod").style.display="none";
	}else if (identificador==2) { // compras
		document.getElementById('id_descripcion').value=detpr+' '+presenpro;
		document.getElementById('id_inivacompra').value=iva;
		document.getElementById('id_cod').value=idpro;
		document.getElementById('id_vcompra').value=valcompra;
		document.getElementById('id_valmin').value=vmin;
		document.getElementById('id_valmed').value=vmed;
		document.getElementById('id_valmax').value=vmax;
		document.getElementById('id_valpvp').value=pvp;	
		document.getElementById('id_cant').focus();	
		document.getElementById("id_div_filtroprod").style.display="none";
	}else if (identificador==3) { // edicion de producto
		document.getElementById('id_product').value=detpr;		
		document.getElementById('id_regpcod').value=idpro;
		document.getElementById('id_regpcodbarras').value=codbarras;
		document.getElementById('id_regpdetalle').value=detpr;
		document.getElementById('id_regppresent').value=presenpro;
		document.getElementById('id_regpvmin').value=vmin;
		document.getElementById('id_regpvmed').value=vmed;
		document.getElementById('id_regpvmax').value=vmax;
		document.getElementById('id_regppvp').value=pvp;
		document.getElementById('id_regpprovee').value=prov;
		document.getElementById('id_regpestado').value=estadopro;
		document.getElementById('id_regpimo').value=iva;
		document.getElementById('id_regpgrupo').value=tipopro;
		document.getElementById('idValCompr').value= valcompra;
		document.getElementById('id_accion').value='EDITANDO...';
		document.getElementById('id_regpident').value='1';
		document.getElementById('id_accion').style.background='red';	
		document.getElementById("id_div_filtroprod").style.display="none";
	}else if (identificador==4) {
		document.getElementById('id_product').value=detpr+' '+presenpro;
		document.getElementById('id_cod').value=idpro;
		document.getElementById("id_div_filtroprod").style.display="none";
	}else if(identificador==5){
		document.getElementById('id_product_egre_l').value=detpr+' '+presenpro;
		document.getElementById('id_codprod_egre_l').value= idpro ;
	 	document.getElementById('id_cantpro_egre_l').value='0';
	 	document.getElementById('id_valprod_egre_l').value=valcompra;
	 	document.getElementById('id_valtotp_egre_l').value='';
	 	document.getElementById('id_cantpro_egre_l').focus();
	 	document.getElementById("id_div_filtroprod").style.display="none";
	}else if(identificador==6){
		document.getElementById('id_product_ingr_l').value=detpr+' '+presenpro;
		document.getElementById('id_codprod_ingr_l').value= idpro ;
	 	document.getElementById('id_cantpro_ingr_l').value='0';
	 	document.getElementById('id_valprod_ingr_l').value=valcompra;
	 	document.getElementById('id_valtotp_ingr_l').value='';
	 	document.getElementById('id_cantpro_ingr_l').focus();
	 	document.getElementById("id_div_filtroprod2").style.display="none";
	 	document.getElementById("id_div_filtroprod").style.display="none";
	}else if(identificador==7){
		document.getElementById('id_producto_inv_ini').value=detpr+' '+presenpro;
	 	document.getElementById('id_cod_inv_ini').value=idpro;
	 	document.getElementById('id_canini_inv_ini').value=val_ini;
	 	document.getElementById("id_div_filtroprod").style.display="none";
	}else if(identificador==10){
		document.getElementById('id_codprod').value = idpro;
		document.getElementById('id_product').value = detpr+' '+presenpro;	
		document.getElementById("id_div_filtroprod").style.display="none";
	}else if(identificador==11){
		document.getElementById('id_product_ingr_l').value=detpr+' '+presenpro;
		document.getElementById('id_codprod_ingr_l').value= idpro ;
	 	document.getElementById('id_cantpro_ingr_l').value='0';
	 	document.getElementById('id_valprod_ingr_l').value=valcompra;
	 	document.getElementById('id_valtotp_ingr_l').value='';
	 	document.getElementById('id_cantpro_ingr_l').focus();
	 	document.getElementById("id_div_filtroprod2").style.display="none";
	};
	
}
//--------------------------funciones para las l contables prodcuto de salida -------------------------------------------------
function sacarvaltot_prod_l (identificador) {
	if (identificador==1) {
		var cant = document.getElementById('id_cantpro_egre_l').value;
		var vunit = document.getElementById('id_valprod_egre_l').value;
		if (cant==0 || cant=='0' || cant=='' || vunit <= 0) {
			if (cant==0 || cant=='0' || cant=='') {
				document.getElementById('id_cantpro_egre_l').style.border="red solid 1px";
			} else{
				document.getElementById('id_cantpro_egre_l').style.border="green solid 1px";
			};
			if (vunit<=0) {
				document.getElementById('id_valprod_egre_l').style.border="red solid 1px";
			} else{
				document.getElementById('id_valprod_egre_l').style.border="green solid 1px";
			};
		} else{
			document.getElementById('id_cantpro_egre_l').style.border="green solid 1px";
			document.getElementById('id_valprod_egre_l').style.border="green solid 1px";
			document.getElementById('id_valtotp_egre_l').style.border="green solid 1px";

			var tot_prod = parseFloat(cant) * parseFloat(vunit);
			tot_prod = tot_prod.toFixed(2);
			document.getElementById('id_valtotp_egre_l').value=tot_prod;
		};
	}else{
		var cant = document.getElementById('id_cantpro_ingr_l').value;
		var vunit = document.getElementById('id_valprod_ingr_l').value;
		if (cant==0 || cant=='0' || cant=='' || vunit <= 0) {
			if (cant==0 || cant=='0' || cant=='') {
				document.getElementById('id_cantpro_ingr_l').style.border="red solid 1px";
			} else{
				document.getElementById('id_cantpro_ingr_l').style.border="green solid 1px";
			};
			if (vunit<=0) {
				document.getElementById('id_valprod_ingr_l').style.border="red solid 1px";
			} else{
				document.getElementById('id_valprod_ingr_l').style.border="green solid 1px";
			};
		} else{
			document.getElementById('id_cantpro_ingr_l').style.border="green solid 1px";
			document.getElementById('id_valprod_ingr_l').style.border="green solid 1px";
			document.getElementById('id_valtotp_ingr_l').style.border="green solid 1px";

			var tot_prod = parseFloat(cant) * parseFloat(vunit);
			tot_prod = tot_prod.toFixed(2);
			document.getElementById('id_valtotp_ingr_l').value=tot_prod;
		};
	}
}
var array_prod_l_egre = [];
var array_codi_l_egre = [];
var array_cant_l_agre = [];
var array_valu_l_egre = [];
var array_valt_l_egre = [];
var array_esta_l_egre = [];
function datalle_l_egreso() {
	var var_prod_l_egre = document.getElementById('id_product_egre_l').value;
	var var_codi_l_egre = document.getElementById('id_codprod_egre_l').value;
	var var_cant_l_agre = document.getElementById('id_cantpro_egre_l').value;
	var var_valu_l_egre = document.getElementById('id_valprod_egre_l').value;
	var var_valt_l_egre = document.getElementById('id_valtotp_egre_l').value;

	if (var_prod_l_egre=='' || var_codi_l_egre == '' || var_cant_l_agre=='' || var_valu_l_egre=='' || var_valt_l_egre=='' ||var_cant_l_agre=='0' || var_valu_l_egre=='0' || var_valt_l_egre=='0') {
		if (var_prod_l_egre=='') {
			document.getElementById('id_product_egre_l').style.border='red solid 1px';
		} else{
			document.getElementById('id_product_egre_l').style.border='green solid 1px';
		};
		if (var_codi_l_egre=='') {
			document.getElementById('id_codprod_egre_l').style.border='red solid 1px';
		} else{
			document.getElementById('id_codprod_egre_l').style.border='green solid 1px';
		};
		if (var_cant_l_agre=='' || var_cant_l_agre=='0' || var_cant_l_agre==0) {
			document.getElementById('id_cantpro_egre_l').style.border='red solid 1px';
		} else{
			document.getElementById('id_cantpro_egre_l').style.border='green solid 1px';
		};
		if (var_valu_l_egre=='' || var_valu_l_egre=='0' || var_valu_l_egre==0) {
			document.getElementById('id_valprod_egre_l').style.border='red solid 1px';
		} else{
			document.getElementById('id_valprod_egre_l').style.border='green solid 1px';
		};
		if (var_valt_l_egre=='' || var_valt_l_egre=='0' || var_valt_l_egre==0) {
			document.getElementById('id_valtotp_egre_l').style.border='red solid 1px';
		} else{
			document.getElementById('id_valtotp_egre_l').style.border='green solid 1px';
		};
	} else{
		document.getElementById('id_product_egre_l').style.border='green solid 1px';
		document.getElementById('id_codprod_egre_l').style.border='green solid 1px';
		document.getElementById('id_cantpro_egre_l').style.border='green solid 1px';
		document.getElementById('id_valprod_egre_l').style.border='green solid 1px';
		document.getElementById('id_valtotp_egre_l').style.border='green solid 1px';

		array_prod_l_egre.push(var_prod_l_egre);
		array_codi_l_egre.push(var_codi_l_egre);
		array_cant_l_agre.push(var_cant_l_agre);
		array_valu_l_egre.push(var_valu_l_egre);
		array_valt_l_egre.push(var_valt_l_egre);
		array_esta_l_egre.push(1);
		llenar_det_l_egre();
	};
}

var array_prod_l_ingre = [];
var array_codi_l_ingre = [];
var array_cant_l_ingre = [];
var array_valu_l_ingre = [];
var array_valt_l_ingre = [];
var array_esta_l_ingre = [];
function datalle_l_ingre() {
	var var_prod_l_ingre = document.getElementById('id_product_ingr_l').value;
	var var_codi_l_ingre = document.getElementById('id_codprod_ingr_l').value;
	var var_cant_l_ingre = document.getElementById('id_cantpro_ingr_l').value;
	var var_valu_l_ingre = document.getElementById('id_valprod_ingr_l').value;
	var var_valt_l_ingre = document.getElementById('id_valtotp_ingr_l').value;

	if (var_prod_l_egre=='' || var_codi_l_egre == '' || var_cant_l_agre=='' || var_valu_l_egre=='' || var_valt_l_egre=='' ||var_cant_l_agre=='0' || var_valu_l_egre=='0' || var_valt_l_egre=='0') {
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
		if (var_valt_l_ingre=='' || var_valt_l_egre=='0' || var_valt_l_egre==0) {
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

		array_prod_l_ingre.push(var_prod_l_ingre);
		array_codi_l_ingre.push(var_codi_l_ingre);
		array_cant_l_ingre.push(var_cant_l_ingre);
		array_valu_l_ingre.push(var_valu_l_ingre);
		array_valt_l_ingre.push(var_valt_l_ingre);
		array_esta_l_ingre.push(1);
		llenar_det_l_ingre();
	};
} 

function calcular_valores_l_ingre(num_identificador) {
	var var_cant_l_ingre = document.getElementById('id_cant_l_ingre'+num_identificador).value;
	var var_valu_l_ingre = document.getElementById('id_vuni_l_ingre'+num_identificador).value;
	var new_tot_l_ingre = parseFloat(var_cant_l_ingre)*parseFloat(var_valu_l_ingre);
	new_tot_l_ingre = new_tot_l_ingre.toFixed(2);	

	array_cant_l_ingre[num_identificador]=var_cant_l_ingre;
	array_valu_l_ingre[num_identificador]=var_valu_l_ingre;
	array_valt_l_ingre[num_identificador]=new_tot_l_ingre;	

	llenar_det_l_ingre();
}

function calcular_valores_l_egre (num_identificador) {
	var var_cant_l_egre = document.getElementById('id_cant_l_egre'+num_identificador).value;
	var var_valu_l_egre = document.getElementById('id_vuni_l_egre'+num_identificador).value;
	var new_tot_l_egre = parseFloat(var_cant_l_egre)*parseFloat(var_valu_l_egre);
	new_tot_l_egre = new_tot_l_egre.toFixed(2);	

	array_cant_l_agre[num_identificador]=var_cant_l_egre;
	array_valu_l_egre[num_identificador]=var_valu_l_egre;
	array_valt_l_egre[num_identificador]=new_tot_l_egre;	

	llenar_det_l_egre();
}
function llenar_det_l_egre () {
	var conti =0;
	var sum_tot_l_egre =0;

	out='<table border="0" style="margin:0; width:100%;">';
	out	= out + '<tr>';
	out = out + '<td><h4>Item</h4></td>';
	out = out + '<td><h4>Descripción.</h4></td>';
	out = out + '<td><h4>Codigo.</h4></td>';
	out = out + '<td><h4>Cant.</h4></td>';
	out = out + '<td><h4>V. Unit.</h4></td>';
	out = out + '<td><h4>V. Tot.</h4></td>';
	out = out + '<td></td>';
	out = out + '</tr>';

	for (var i = 0 ; i < array_codi_l_egre.length; i++) {
		if (array_esta_l_egre[i]==1) { //##################################### solo me ingresa los campos que estan en 1
			conti= parseInt(conti)+1;
			out	= out + '<tr>';
			out = out + '<td>'+conti+'</td>';
			out = out + '<td><input type="text" class="cl_txt" name="c_proddet_l_egre[]" id="id_proddet_l_egre" value="'+array_prod_l_egre[i]+'" style="width:420px;" readonly/></td>';
			out = out + '<td><input type="text" class="cl_txt" name="c_codidet_l_egre[]" id="id_codidet_l_egre" value="'+array_codi_l_egre[i]+'" style="width:150px;" readonly/></td>';
			out = out + '<td><input type="number" step="1" class="cl_txt2" name="c_cant_l_egre[]" id="id_cant_l_egre'+i+'" onblur="calcular_valores_l_egre('+i+');" value="'+array_cant_l_agre[i]+'" style="width:75px;" required/></td>';
			out = out + '<td><input type="number" step="0.01" class="cl_txt2" name="c_vuni_l_egre[]" id="id_vuni_l_egre'+i+'" onblur="calcular_valores_l_egre('+i+');" value="'+array_valu_l_egre[i]+'" style="width:75px;" required/></td>';
			out = out + '<td><input type="number" step="0.01" class="cl_txt2" name="c_vtot_l_egre[]" id="id_vtot_l_egre'+i+'" onblur="calcular_valores_l_egre('+i+');" value="'+array_valt_l_egre[i]+'" style="width:75px;" required/></td>';
			out = out + '<td><input type="button" value="X" style="background:red;" onclick=eliminaritem_l_egre('+i+'); /></td>';
			out = out + '</tr>';
			sum_tot_l_egre = parseFloat(sum_tot_l_egre) + parseFloat(array_valt_l_egre[i]);
		}; //############################ solo me ingrea los campos que estan en 1#########################################
	};		
	out=out+"</table>";	
	sum_tot_l_egre = sum_tot_l_egre.toFixed(2);
	document.getElementById('id_cj_datelle_egre_l').innerHTML=out;
	document.getElementById('id_product_egre_l').style.border='#1679C9 solid 1px';
	document.getElementById('id_codprod_egre_l').style.border='#1679C9 solid 1px';
	document.getElementById('id_cantpro_egre_l').style.border='#1679C9 solid 1px';
	document.getElementById('id_valprod_egre_l').style.border='#1679C9 solid 1px';
	document.getElementById('id_valtotp_egre_l').style.border='#1679C9 solid 1px';

	document.getElementById('id_tot_egre_l').value=sum_tot_l_egre;
	document.getElementById('id_product_egre_l').value='';
	document.getElementById('id_codprod_egre_l').value='';
	document.getElementById('id_cantpro_egre_l').value='';
	document.getElementById('id_valprod_egre_l').value='';
	document.getElementById('id_valtotp_egre_l').value='';

}

function llenar_det_l_ingre () {
	var conti =0;
	var sum_tot_l_ingre =0;

	out='<table border="0" style="margin:0; width:100%;">';
	out	= out + '<tr>';
	out = out + '<td><h4>Item</h4></td>';
	out = out + '<td><h4>Descripción.</h4></td>';
	out = out + '<td><h4>Codigo.</h4></td>';
	out = out + '<td><h4>Cant.</h4></td>';
	out = out + '<td><h4>V. Unit.</h4></td>';
	out = out + '<td><h4>V. Tot.</h4></td>';
	out = out + '<td></td>';
	out = out + '</tr>';

	for (var i = 0 ; i < array_codi_l_ingre.length; i++) {
		if (array_esta_l_ingre[i]==1) { //##################################### solo me ingresa los campos que estan en 1
			conti= parseInt(conti)+1;
			out	= out + '<tr>';
			out = out + '<td>'+conti+'</td>';
			out = out + '<td><input type="text" class="cl_txt" name="c_proddet_l_ingre[]" id="id_proddet_l_ingre" value="'+array_prod_l_ingre[i]+'" style="width:420px;" readonly/></td>';
			out = out + '<td><input type="text" class="cl_txt" name="c_codidet_l_ingre[]" id="id_codidet_l_ingre" value="'+array_codi_l_ingre[i]+'" style="width:150px;" readonly/></td>';
			out = out + '<td><input type="number" step="1" class="cl_txt2" name="c_cant_l_ingre[]" id="id_cant_l_ingre'+i+'" onblur="calcular_valores_l_ingre('+i+');" value="'+array_cant_l_ingre[i]+'" style="width:75px;" required/></td>';
			out = out + '<td><input type="number" step="0.01" class="cl_txt2" name="c_vuni_l_ingre[]" id="id_vuni_l_ingre'+i+'" onblur="calcular_valores_l_ingre('+i+');" value="'+array_valu_l_ingre[i]+'" style="width:75px;" required/></td>';
			out = out + '<td><input type="number" step="0.01" class="cl_txt2" name="c_vtot_l_ingre[]" id="id_vtot_l_ingre'+i+'" onblur="calcular_valores_l_ingre('+i+');" value="'+array_valt_l_ingre[i]+'" style="width:75px;" required/></td>';
			out = out + '<td><input type="button" value="X" style="background:red;" onclick=eliminaritem_l_ingre('+i+'); /></td>';
			out = out + '</tr>';
			sum_tot_l_ingre = parseFloat(sum_tot_l_ingre) + parseFloat(array_valt_l_ingre[i]);
		}; //############################ solo me ingrea los campos que estan en 1#########################################
	};		
	out=out+"</table>";	
	sum_tot_l_ingre = sum_tot_l_ingre.toFixed(2);
	document.getElementById('id_cj_datelle_ing_l').innerHTML=out;
	document.getElementById('id_product_ingr_l').style.border='#1679C9 solid 1px';
	document.getElementById('id_codprod_ingr_l').style.border='#1679C9 solid 1px';
	document.getElementById('id_cantpro_ingr_l').style.border='#1679C9 solid 1px';
	document.getElementById('id_valprod_ingr_l').style.border='#1679C9 solid 1px';
	document.getElementById('id_valtotp_ingr_l').style.border='#1679C9 solid 1px';

	document.getElementById('id_tot_ingr_l').value=sum_tot_l_ingre;
	document.getElementById('id_product_ingr_l').value='';
	document.getElementById('id_codprod_ingr_l').value='';
	document.getElementById('id_cantpro_ingr_l').value='';
	document.getElementById('id_valprod_ingr_l').value='';
	document.getElementById('id_valtotp_ingr_l').value='';

}
function eliminaritem_l_egre (num_identificador) {
	array_esta_l_egre[num_identificador]=0;	
	llenar_det_l_egre();
}
function eliminaritem_l_ingre (num_identificador) {
	array_esta_l_ingre[num_identificador]=0;	
	llenar_det_l_ingre();
}
//########################################################################## l contables productos que entran  al invetario 
var array_prod_l_ingre = [];
var array_codi_l_ingre = [];
var array_cant_l_agre = [];
var array_valu_l_ingre = [];
var array_valt_l_ingre = [];
var array_esta_l_ingre = [];
function datalle_l_ingreso() {
	var var_prod_l_ingre = document.getElementById('id_product_ingr_l').value;
	var var_codi_l_ingre = document.getElementById('id_codprod_ingr_l').value;
	var var_cant_l_ingre = document.getElementById('id_cantpro_ingr_l').value;
	var var_valu_l_ingre = document.getElementById('id_valprod_ingr_l').value;
	var var_valt_l_ingre = document.getElementById('id_valtotp_ingr_l').value;

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

		array_prod_l_ingre.push(var_prod_l_ingre);
		array_codi_l_ingre.push(var_codi_l_ingre);
		array_cant_l_ingre.push(var_cant_l_ingre);
		array_valu_l_ingre.push(var_valu_l_ingre);
		array_valt_l_ingre.push(var_valt_l_ingre);
		array_esta_l_ingre.push(1);
		llenar_det_l_ingre();
	};
}
function calcular_valores_l_egre (num_identificador) {
	var var_cant_l_egre = document.getElementById('id_cant_l_egre'+num_identificador).value;
	var var_valu_l_egre = document.getElementById('id_vuni_l_egre'+num_identificador).value;
	var new_tot_l_egre = parseFloat(var_cant_l_egre)*parseFloat(var_valu_l_egre);
	new_tot_l_egre = new_tot_l_egre.toFixed(2);	

	array_cant_l_agre[num_identificador]=var_cant_l_egre;
	array_valu_l_egre[num_identificador]=var_valu_l_egre;
	array_valt_l_egre[num_identificador]=new_tot_l_egre;	

	llenar_det_l_egre();
}

function eliminaritem_l_egre (num_identificador) {
	array_esta_l_egre[num_identificador]=0;	
	llenar_det_l_egre();
}
// ------------------------fin de funciones para las l contables --------------------------------------------
function ponervalores(valor){
	document.getElementById('id_valprod').value= valor;
	document.getElementById('id_valprod').focus();
}
function sacarvaltot (sumtotal) {
	if (sumtotal==1) {
		var cant = document.getElementById('id_cantpro').value;
		var vunit = document.getElementById('id_valprod').value;
	}else if (sumtotal==2) {
		var cant = document.getElementById('id_cant').value;
		var vunit = document.getElementById('id_vcompra').value;
	};	
	var valtot = parseFloat(cant)*parseFloat(vunit);
	valtot = valtot.toFixed(2);	
	if (valtot=='' || valtot=='NaN' || valtot==NaN || valtot=='undefined'){
		document.getElementById('id_valtotp').value='';		
	}else{
		document.getElementById('id_valtotp').value=valtot;
	}	
	
}
var array_produ = [];
var array_codpr = [];
var array_canti = [];
var array_vauni = [];
var array_vatot = [];
var array_ivapr = [];
var array_vcomp = [];
var array_anula = [];
function detalleventa(){
	var var_prod = document.getElementById('id_product').value;
	var var_codi = document.getElementById('id_codprod').value;
	var var_cant = document.getElementById('id_cantpro').value;
	var var_valu = document.getElementById('id_valprod').value;
	var var_valt = document.getElementById('id_valtotp').value;
	var var_ivap = document.getElementById('id_hdivapr').value;
	var var_vcom = document.getElementById('id_vacompra').value;

	//if ( parseFloat(var_valu) > parseFloat(var_vcom)) {
	
		if (var_prod=='' || var_codi=='' || var_cant=='' || var_valu=='' || var_valt=='' || var_ivap==''){

			if(var_prod==""){
				document.getElementById('id_product').style.border='solid 1px #C92121';
			}else {
				document.getElementById('id_product').style.border='solid 1px #0A7823';
			};
			if (var_codi==""){
				document.getElementById('id_codprod').style.border='solid 1px #C92121';
			}else {
				document.getElementById('id_codprod').style.border='solid 1px #0A7823';
			};
			if(var_cant==""){
				document.getElementById('id_cantpro').style.border='solid 1px #C92121';
			}else{
				document.getElementById('id_cantpro').style.border='solid 1px #0A7823';
			};
			if (var_valu==""){
				document.getElementById('id_valprod').style.border='solid 1px #C92121';
			}else {
				document.getElementById('id_valprod').style.border='solid 1px #0A7823';
			};
			if(var_valt==""){
				document.getElementById('id_valtotp').style.border='solid 1px #C92121';
			}else{
				document.getElementById('id_valtotp').style.border='solid 1px #0A7823';
			};
			if(var_ivap==""){
				alert('Por favor revise el prodcuto algo anda mal con este prodcuto');
			};

		}else{
			/*var cupo_act  = document.getElementById('id_creddipo').value;
			var saldo_pendi = document.getElementById('id_saldo_cli').value;
			var forma_pag = document.getElementById('id_formapago').value;
			saldo_pendi = saldo_pendi + var_valt;*/

			
			array_produ.push(var_prod);
			array_codpr.push(var_codi);
			array_canti.push(var_cant);	
			array_vauni.push(var_valu);
			array_vatot.push(var_valt);
			array_ivapr.push(var_ivap);
			array_vcomp.push(var_vcom);
			array_anula.push(1);
			generardetalleventa();
		
		}
	/*} else{
		document.getElementById('id_valprod').style.background="yellow";
	};*/
	
}
//-------------------------------------funcion que anula en item del la factura para crear ------------------------
function eliminaritemventa (item_factura) {
	array_anula[item_factura]= 0;
	generardetalleventa();
}
function generardetalleventa(){
	var sum0 = 0;
	var sum12 = 0;
	var sumiva = 0;
	var totfactura = 0;
	var comp0 = 0;
	var comp12 = 0;
	var conti =0;

	out='<table border="0" style="margin:0; width:100%;">';
	out	= out + '<tr>';
	out = out + '<td><h4>Item</h4></td>';
	out = out + '<td><h4>Descripción.</h4></td>';
	out = out + '<td><h4>Codigo.</h4></td>';
	out = out + '<td><h4>Cant.</h4></td>';
	out = out + '<td><h4>V. Unit.</h4></td>';
	out = out + '<td><h4>V. Tot.</h4></td>';
	out = out + '<td></td>';
	out = out + '</tr>';

	for (var i = 0 ; i < array_produ.length; i++) {
		if (array_anula[i]==1) { //##################################### solo me ingresa los campos que estan en 1
			conti= parseInt(conti)+1;
			out	= out + '<tr>';
			out = out + '<td>'+conti+'</td>';
			out = out + '<td><input type="text" class="cl_txt" name="c_proddet[]" id="id_proddet" value="'+array_produ[i]+'" style="width:420px;" readonly/></td>';
			out = out + '<td><input type="text" class="cl_txt" name="c_codidet[]" id="id_codidet" value="'+array_codpr[i]+'" style="width:150px;" readonly/></td>';
			out = out + '<td><input type="text" class="cl_txt" name="c_cant[]" id="id_cant'+i+'" onblur="calculardetalleventa('+i+');" value="'+array_canti[i]+'" style="width:75px;" required/></td>';
			out = out + '<td><input type="text" class="cl_txt" name="c_vuni[]" id="id_vuni'+i+'" onblur="calculardetalleventa('+i+');" value="'+array_vauni[i]+'" style="width:75px;" required/></td>';
			out = out + '<td><input type="text" class="cl_txt" name="c_vtot[]" id="id_vtot'+i+'" onblur="calculardetalleventa('+i+');" value="'+array_vatot[i]+'" style="width:75px;" required/></td>';
			out = out + '<td><input type="button" value="X" style="background:red;" onclick=eliminaritemventa('+i+'); /></td>';
			out = out + '</tr>';
			
			//alert('val de compra es '+array_vcomp[i] );
			if (array_ivapr[i]==1){
				sum12 = parseFloat(sum12) + parseFloat(array_vatot[i]);
				comp12 = parseFloat(comp12) + (parseFloat(array_vcomp[i])*parseFloat(array_canti[i]));
			}else{
				sum0 = parseFloat(sum0) + parseFloat(array_vatot[i]);
				comp0 = parseFloat(comp0) + (parseFloat(array_vcomp[i])*parseFloat(array_canti[i]));
			};
		}; //############################ solo me ingrea los campos que estan en 1
	};	

	out=out+"</table>";	

	//alert('suma12 '+comp12);
	//alert('suma0 '+comp0);
	//alert(pocentIVAglobal);
	var suma12_sin_iva = sum12 / pocentIVAglobal;
	suma12_sin_iva= suma12_sin_iva.toFixed(2);

	var iva = parseFloat(sum12) - parseFloat(suma12_sin_iva);
	iva = iva.toFixed(2);

	var subtotal = parseFloat(suma12_sin_iva) + parseFloat(sum0);
	subtotal =subtotal.toFixed(2);

	var tota_factura = parseFloat(subtotal) + parseFloat(iva);
	tota_factura = tota_factura.toFixed(2);

	var cupo_act  = document.getElementById('id_creddipo').value;
	var saldo_pendi = document.getElementById('id_saldo_cli').value;
	var forma_pag = document.getElementById('id_formapago').value;
	//alert(saldo_pendi);
	if (saldo_pendi =='' || saldo_pendi =='undefined' || saldo_pendi =='UNDEFINED') {
		saldo_pendi = 0;
	};
	saldo_pendi = parseFloat(saldo_pendi) + parseFloat(tota_factura);
	saldo_pendi = saldo_pendi.toFixed(2);
	cupo_act = parseFloat(cupo_act);
	//alert(cupo_act);
	//alert(saldo_pendi);
	//alert(forma_pag);*/
	if ((saldo_pendi > cupo_act) ) {
		if (forma_pag == 2) {
			//alert('si');
			alert('HA SOBREPASADO EL CUPO DE CREDITO');
			document.getElementById('bt_guardar_fact').style.display='none';
		} else{
			document.getElementById('bt_guardar_fact').style.display='inline-block';
		};
	} else{
		//alert('no');
		document.getElementById('bt_guardar_fact').style.display='inline-block';
	};

	document.getElementById('id_subtotal').value=subtotal;
	document.getElementById('id_base0').value=sum0.toFixed(2);
	document.getElementById('id_base12').value=suma12_sin_iva;
	document.getElementById('id_iva').value=iva;
	document.getElementById('id_totfactura').value = tota_factura;

	document.getElementById('id_sumcompra0').value=comp0;
	document.getElementById('id_sumcompra12').value =comp12	

	document.getElementById('id_product').value='';
	document.getElementById('id_codprod').value='';
	document.getElementById('id_cantpro').value='';
	document.getElementById('id_valprod').value='';
	document.getElementById('id_valtotp').value='';
	document.getElementById('id_hdivapr').value='';
	document.getElementById('id_vacompra').value='';
	document.getElementById("id_cj_datellefact").innerHTML = out;

	document.getElementById('id_product').style.border='solid 1px #518DB5';
	document.getElementById('id_codprod').style.border='solid 1px #518DB5';
	document.getElementById('id_cantpro').style.border='solid 1px #518DB5';
	document.getElementById('id_valprod').style.border='solid 1px #518DB5';
	document.getElementById('id_valtotp').style.border='solid 1px #518DB5';
}
function calculardetalleventa(identificador){
	//alert('si entro en el blur');
	var var_cant = document.getElementById('id_cant'+identificador).value;
	var var_valu = document.getElementById('id_vuni'+identificador).value;
	var new_tot = parseFloat(var_cant)*parseFloat(var_valu);
	new_tot = new_tot.toFixed(2);	

	array_canti[identificador]=var_cant;
	array_vauni[identificador]=var_valu;
	array_vatot[identificador]=new_tot;	

	generardetalleventa();
}

//---------------------------------------------------------------------------Funcion para ingresar inventario
var array_inproducto=[];
var array_incod=[];
var array_incat=[];
var array_invcom=[];
var array_invalmin=[];
var array_invalmed=[];
var array_invalmax=[];
var array_invalPVP=[];
var array_intotal=[];
var array_inivacom=[];
function ingresoinventario(){
	var var_inprod = document.getElementById('id_descripcion').value;
	var var_incod = document.getElementById('id_cod').value;
	var var_incant = document.getElementById('id_cant').value;
	var var_invcom = document.getElementById('id_vcompra').value;
	var var_invalmin = document.getElementById('id_valmin').value;
	var var_invalmed = document.getElementById('id_valmed').value;
	var var_invalmax = document.getElementById('id_valmax').value;
	var var_invalPVP = document.getElementById('id_valpvp').value;
	var var_intotal = document.getElementById('id_valtotp').value;
	var var_inivacom = document.getElementById('id_inivacompra').value;

	if (var_inprod=='' || var_incod=='' || var_incant=='' || var_invcom=='' || var_invalmin=='' || var_invalmed=='' || var_invalmax=='' || var_invalPVP=='' || var_intotal=='' ){

		if(var_inprod==""){
			document.getElementById('id_descripcion').style.border='solid 1px #C92121';
		}else {
			document.getElementById('id_descripcion').style.border='solid 1px #0A7823';
		};
		if (var_incod==""){
			document.getElementById('id_cod').style.border='solid 1px #C92121';
		}else {
			document.getElementById('id_cod').style.border='solid 1px #0A7823';
		};
		if(var_incant==""){
			document.getElementById('id_cant').style.border='solid 1px #C92121';
		}else{
			document.getElementById('id_cant').style.border='solid 1px #0A7823';
		};
		if (var_invcom==""){
			document.getElementById('id_vcompra').style.border='solid 1px #C92121';
		}else {
			document.getElementById('id_vcompra').style.border='solid 1px #0A7823';
		};
		if(var_invalmin==""){
			document.getElementById('id_valmin').style.border='solid 1px #C92121';
		}else{
			document.getElementById('id_valmin').style.border='solid 1px #0A7823';
		};
		if(var_invalmed==""){
			document.getElementById('id_valmed').style.border='solid 1px #C92121';
		}else{
			document.getElementById('id_valmed').style.border='solid 1px #0A7823';
		};
		if (var_invalmax==""){
			document.getElementById('id_valmax').style.border='solid 1px #C92121';
		}else {
			document.getElementById('id_valmax').style.border='solid 1px #0A7823';
		};
		if(var_invalPVP==""){
			document.getElementById('id_valpvp').style.border='solid 1px #C92121';
		}else{
			document.getElementById('id_valpvp').style.border='solid 1px #0A7823';
		};
		if(var_intotal==""){
			document.getElementById('id_valtotp').style.border='solid 1px #C92121';
		}else{
			document.getElementById('id_valtotp').style.border='solid 1px #0A7823';
		};
		if (var_inivacom=="") {
			alert('Por favor revise el prodcuto algo anda mal');
		};

	}else{
		array_inproducto.push(var_inprod);
		array_incod.push(var_incod);
		array_incat.push(var_incant);	
		array_invcom.push(var_invcom);
		array_invalmin.push(var_invalmin);
		array_invalmed.push(var_invalmed);
		array_invalmax.push(var_invalmax);
		array_invalPVP.push(var_invalPVP);
		array_intotal.push(var_intotal);
		array_inivacom.push(var_inivacom);
		generaringresoinvetario();
	}
}
function generaringresoinvetario(){
	var insum12 = 0;
	var insum0 = 0;
	var iniva12 = 0;
	var intotal = 0;
	var incomp0 = 0;
	var incomp12 = 0;

	out='<table border="0" style="margin:0; width:100%;">';
	out	= out + '<tr>';
	out = out + '<td>Descripción</td>';
	out = out + '<td>Cod.</td>';
	out = out + '<td>Cant.</td>';
	out = out + '<td>V. Com</td>';
	out = out + '<td>Val. Min</td>';
	out = out + '<td>Val. Med</td>';
	out = out + '<td>Val. Max</td>';
	out = out + '<td>Val. PVP</td>';
	out = out + '<td>Total</td>';
	out = out + '<td></td>';
	out = out + '</tr>';

	for (var i = 0 ; i < array_inproducto.length; i++) {
		out	= out + '<tr>';
		out = out + '<td><input type="text" class="cl_txt" name="c_descripcion[]" id="id_descripcion" value="'+array_inproducto[i]+'" style="width:350px;" readonly/></td>';
		out = out + '<td><input type="text" class="cl_txt" name="c_cod[]" id="id_cod" value="'+array_incod[i]+'" style="width:65px" readonly/></td>';
		out = out + '<td><input type="text" class="cl_txt" name="c_cant[]"id="id_cant'+i+'" onblur="calculardetalleingreso('+i+');" value="'+array_incat[i]+'" style="width:65px"></td>';
		out = out + '<td><input type="number" step="0.0001" class="cl_txt" name="c_vcompra[]" id="id_vcompra'+i+'" onblur="calculardetalleingreso('+i+');" value="'+array_invcom[i]+'" style="width:65px"></td>';
		out = out + '<td><input type="number" step="0.01" class="cl_txt" name="c_valmin[]" id="id_valmin" value="'+array_invalmin[i]+'" style="width:65px"></td>';
		out = out + '<td><input type="number" step="0.01" class="cl_txt" name="c_valmed[]" id="id_valmed" value="'+array_invalmed[i]+'" style="width:65px"></td>';
		out = out + '<td><input type="number" step="0.01" class="cl_txt" name="c_valmax[]" id="id_valmax" value="'+array_invalmax[i]+'" style="width:65px"></td>';
		out = out + '<td><input type="number" step="0.01" class="cl_txt" name="c_valpvp[]" id="id_valpvp" value="'+array_invalPVP[i]+'" style="width:65px"></td>';
		out = out + '<td><input type="number" step="0.01" class="cl_txt" name="c_total[]" id="id_valtotp'+i+'" onblur="calculardetalleingreso('+i+');" value="'+array_intotal[i]+'" style="width:65px"></td>';
		out = out + '<td><a href="#" onclick="eliminaritem('+i+');" style="text-decoration:none;background:red;border-radius:4px;padding:0.2em;">X</a></td>';
		out = out + '</tr>';
		
		//alert('val de compra es '+array_vcomp[i] );
		if (array_inivacom[i]==1){
			insum12 = parseFloat(insum12) + parseFloat(array_intotal[i]);
			incomp12 = parseFloat(incomp12) + (parseFloat(array_vcomp[i])*parseFloat(array_incat[i]));
		}else{
			insum0 = parseFloat(insum0) + parseFloat(array_intotal[i]);
			incomp0 = parseFloat(incomp0) + (parseFloat(array_vcomp[i])*parseFloat(array_incat[i]));
		};
	};	

	out=out+"</table>";	
	var iniva12 = parseFloat(insum12) -parseFloat(insum12/ pocentIVAglobal);
	iniva12 =iniva12.toFixed(2);

	var insubtotal = parseFloat(insum0) + parseFloat(insum12)- parseFloat(iniva12);
	insubtotal =insubtotal.toFixed(2);

	var insum12 =parseFloat(insum12)- parseFloat(iniva12);
	insum12 = insum12.toFixed(2);
	insum0 = insum0.toFixed(2);

	incomp0 = incomp0.toFixed(2);
	incomp12 = incomp12.toFixed(2);

	intotal = parseFloat(iniva12) + parseFloat(insubtotal);	
	intotal = intotal.toFixed(2);

	document.getElementById('btn_guardar_compras').style.display='inline-block';	
	
	document.getElementById('id_subt_inv').value=insubtotal;
	document.getElementById('id_base0_inv').value=insum0;
	document.getElementById('id_base12_inv').value=insum12;
	document.getElementById('id_iva_inv').value=iniva12;
	document.getElementById('id_tot_inv').value = intotal;
	
	document.getElementById('id_descripcion').value='';	
	document.getElementById('id_inivacompra').value='';
	document.getElementById('id_cod').value='';
	document.getElementById('id_cant').value='';
	document.getElementById('id_vcompra').value='';
	document.getElementById('id_valmin').value='';
	document.getElementById('id_valmed').value='';
	document.getElementById('id_valmax').value='';
	document.getElementById('id_valpvp').value='';
	document.getElementById('id_valtotp').value='';
	document.getElementById("id_detalleinventario").innerHTML = out;

	document.getElementById('id_descripcion').style.border='solid 1px #518DB5';
	document.getElementById('id_cod').style.border='solid 1px #518DB5';
	document.getElementById('id_cant').style.border='solid 1px #518DB5';
	document.getElementById('id_vcompra').style.border='solid 1px #518DB5';
	document.getElementById('id_valmin').style.border='solid 1px #518DB5';
	document.getElementById('id_valmed').style.border='solid 1px #518DB5';
	document.getElementById('id_valmax').style.border='solid 1px #518DB5';
	document.getElementById('id_valpvp').style.border='solid 1px #518DB5';
	document.getElementById('id_valtotp').style.border='solid 1px #518DB5';
} 
function calculardetalleingreso(identificador){
	//alert('si entro en el blur');
	var var_incant = document.getElementById('id_cant'+identificador).value;
	var var_invcom = document.getElementById('id_vcompra'+identificador).value;
	var new_total = parseFloat(var_incant)*parseFloat(var_invcom);
	new_total = new_total.toFixed(2);	

	array_incat[identificador]=var_incant;
	array_invcom[identificador]=var_invcom;
	array_intotal[identificador]=new_total;	

	generaringresoinvetario();
}
//validacion de campos
 function validacioncampos(validar){ 
 	var cingreso = document.getElementById('id_cingreso').value;
 	var cformapago = document.getElementById('id_cformapago').value;
 	var cfechcompra = document.getElementById('id_cfechcompra').value;
 	var cplazo = document.getElementById('cid_plazo').value;
 	var cfechpago = document.getElementById('id_cfechpago').value;
 	var cclienteprovee_glo = document.getElementById('id_clienteprovee_glo').value;
 	var cruc_ced = document.getElementById('id_ruc_ced').value;
 	var cnumserie = document.getElementById('id_numserie').value;
 	var cnumserie2 = document.getElementById('id_numserie2').value;
 	var cnum = document.getElementById('id_num').value;
 	var cautorizacion = document.getElementById('id_autorizacion').value;
 	var ccontribuyente = document.getElementById('id_contribuyente').value;
 	var cobservacion = document.getElementById('id_observacion').value;
 	var csustributario = document.getElementById('id_sustributario').value; 	
 	longitudnum =cnum.length 

 	for (var i1 = cnumserie.length; i1 < 3; i1++) {
 		cnumserie = '0'+cnumserie;
 	};
 	for (var i2 = cnumserie2.length; i2 < 3; i2++) {
 		cnumserie2 = '0'+cnumserie2;
 	};

 	for (var i = longitudnum; i < 9; i++) {
 		cnum = '0'+cnum;
 	};
 	document.getElementById('id_numserie').value = cnumserie;
 	document.getElementById('id_numserie2').value = cnumserie2;
 	document.getElementById('id_num').value =cnum;
 	if (cingreso=='0' || cformapago=='0' || cfechcompra=='' || cclienteprovee_glo==''|| cruc_ced=='' || cnumserie=='' || cnumserie2=='' || cnumserie=='000' || cnumserie2=='000' || cnum=='' || cnum=='000000000' || cautorizacion=='' || ccontribuyente=='' || csustributario=='0') {
			
		if (cingreso=='0') {
			document.getElementById('id_cingreso').style.border='solid 1px red';
		}else{
			document.getElementById('id_cingreso').style.border='solid 1px green';
		};			
		if (cformapago=='0') {
			document.getElementById('id_cformapago').style.border='solid 1px red';
		}else{
			document.getElementById('id_cformapago').style.border='solid 1px green';
		};
		if (cfechcompra=='') {
			document.getElementById('id_cfechcompra').style.border='solid 1px red';
		}else{
			document.getElementById('id_cfechcompra').style.border='solid 1px green';
		};		
		if (cclienteprovee_glo=='') {
			document.getElementById('id_clienteprovee_glo').style.border='solid 1px red';
		}else{
			document.getElementById('id_clienteprovee_glo').style.border='solid 1px green';
		};
		if (cruc_ced=='') {
			document.getElementById('id_ruc_ced').style.border='solid 1px red';
		}else{
			document.getElementById('id_ruc_ced').style.border='solid 1px green';
		};
		if (cnumserie=='' || cnumserie=='000') {
			document.getElementById('id_numserie').style.border='solid 1px red';
		}else{
			document.getElementById('id_numserie').style.border='solid 1px green';
		};
		if (cnumserie2=='' || cnumserie2=='000') {
			document.getElementById('id_numserie2').style.border='solid 1px red';
		}else{
			document.getElementById('id_numserie2').style.border='solid 1px green';
		};
		if (cnum=='' || cnum=='000000000') {
			document.getElementById('id_num').style.border='solid 1px red';
		}else{
			document.getElementById('id_num').style.border='solid 1px green';
		};
		if (cautorizacion=='') {
			document.getElementById('id_autorizacion').style.border='solid 1px red';
		}else{
			document.getElementById('id_autorizacion').style.border='solid 1px green';
		};
		if (ccontribuyente=='') {
			document.getElementById('id_contribuyente').style.border='solid 1px red';
		}else{
			document.getElementById('id_contribuyente').style.border='solid 1px green';
		};
		if (csustributario=='0') {
			document.getElementById('id_sustributario').style.border='solid 1px red';
		}else{
			document.getElementById('id_sustributario').style.border='solid 1px green';
		};
	}else{
		document.getElementById('id_cingreso').style.border='solid 1px green';
		document.getElementById('id_cformapago').style.border='solid 1px green';
		document.getElementById('id_cfechcompra').style.border='solid 1px green';
		document.getElementById('id_clienteprovee_glo').style.border='solid 1px green';
		document.getElementById('id_ruc_ced').style.border='solid 1px green';
		document.getElementById('id_numserie').style.border='solid 1px green';
		document.getElementById('id_numserie2').style.border='solid 1px green';
		document.getElementById('id_num').style.border='solid 1px green';
		document.getElementById('id_autorizacion').style.border='solid 1px green';
		document.getElementById('id_contribuyente').style.border='solid 1px green';
		document.getElementById('id_sustributario').style.border='solid 1px green';
		ocultarfrm_compras(validar);
	};			
 }
//ocultar y mostrar formularios en compras----------------------------------------------------------------------------------------------------
function ocultarfrm_compras( iden){
	if (iden==1){
		document.getElementById('id_div_notas_cred').style.display='none';
		document.getElementById('id_gastos').style.display='none';
		document.getElementById('id_invent').style.display='block';
		document.getElementById('id_identificador').value='C';
	}else if(iden==2){
		document.getElementById('id_div_notas_cred').style.display='none';
		document.getElementById('id_invent').style.display='none';
		document.getElementById('id_gastos').style.display='block';
		document.getElementById('id_identificador').value='D';
		document.getElementById('id_div_asiento_comp').style.display='block';
	}else if (iden==3){
		var id_cli_prove = document.getElementById('id_prov_cli').value;
		document.getElementById('id_invent').style.display='none';
		document.getElementById('id_gastos').style.display='none';
		document.getElementById('id_div_notas_cred').style.display='block';
		document.getElementById('id_identificador').value='M';
		document.getElementById('id_div_asiento_comp').style.display='block';
		document.getElementById('id_div_otros_prod').style.display='block';
		buscar_compra_notas_cred(id_cli_prove);
	};
		
}
//------------------------------------------------------------------------------------------------------------------------------
function buscar_compra_notas_cred(id_cli_provee){
	var xmlhttp;
	document.getElementById("id_div_notas_cred").innerHTML='<img src="img/cargar.gif" alt="" />';
	var n = id_cli_provee;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	//alert(n);
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("id_div_notas_cred").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST","lib/jx_cargar_compras_nc.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("q="+n);
}
/*function mostrardivsencompras(id){
	ocultarfrm_compras();
	document.getElementById(id).style.display='block';
}
function ocultarfrm_notascont(){
	document.getElementById('id_ncxcuentas').style.display='none';
	document.getElementById('id_ncinventario').style.display='none';
}
function mostrardivsennc(id){
	ocultarfrm_notascont();
	document.getElementById(id).style.display='block';
}*/
function plazodepago(){
	var fecha = document.getElementById('id_cfechcompra').value;
	var plazo = document.getElementById('cid_plazo').value;
	

	if (plazo <= 30) {
        var fec = new Date(fecha);
        var dia = parseInt(parseInt(fec.getDate()) + 1) + parseInt(plazo);
        var mes = parseInt(fec.getMonth() + 1);
        var anio = fec.getFullYear();        

        
    } else if (plazo > 30 && plazo <= 45)
    {
        //alert(plazo);
        var fec = new Date(fecha);
        var dia = parseInt(parseInt(fec.getDate()) + 1) + parseInt(15);
        var mes = parseInt(fec.getMonth() + 2);
        var anio = fec.getFullYear();
        
    } else if (plazo > 46 && plazo <= 60)
    {
        //alert(plazo);
        var fec = new Date(fecha);
        var dia = parseInt(parseInt(fec.getDate()) + 1) + parseInt(0);
        var mes = parseInt(fec.getMonth() + 3);
        var anio = fec.getFullYear();
    } else {
        //alert(plazo);
        var fec = new Date(fecha);
        var dia = parseInt(parseInt(fec.getDate()) + 1) + parseInt(0);
        var mes = parseInt(fec.getMonth() + 4);
        var anio = fec.getFullYear();
    };
   

    if (dia > 30) {
        mes = mes + 1;
        dia = dia - 30;
        
    };
    if (mes > 12) {
        mes = mes - 12;
        anio = anio + 1;
    };
    if (mes == 2 & dia > 28) {
        mes = mes + 1;
        dia = dia - 28;
       

    }
    if ((mes == 2 || mes == 4 || mes == 6 || mes == 9 || mes == 11) & dia == 31) {
        mes = mes + 1;
        dia = dia - 30;
        

    };
    nuevafecha = dia + "/" + mes + "/" + anio
    //alert(nuevafecha);
    document.getElementById('id_cfechpago').value = nuevafecha;
    document.getElementById('id_cfechpago').style.background = '#DCDC10';//'#FA9A9A';

}
function mostraradmincompras (){
	document.getElementById('id_datoscompra').style.display='none';
	document.getElementById('id_admincompras').style.display='block'
}
function edtarcompra(id_div){	
	document.getElementById(id_div).style.display='block';
}

function mostrarcuenta(idcuenta,codcta,codctapadre,nom,est,mov,fkuse,fecha,empresa,offi,identificador,s1,idt1, s2, idt2){
	if (identificador==1) {
		document.getElementById('id_movcuentaingresar').value=nom;
		document.getElementById('id_movcodcuenta').value=codcta;
		document.getElementById("id_div_cuentas").style.display="none";
	} else if (identificador==2){
		document.getElementById('id_movcuentaingresar').value=nom;
		document.getElementById('id_movcodcuenta').value=codcta;
		document.getElementById("id_div_cuentas").style.display="none";
	}else if (identificador==3){
		document.getElementById('id_desc_nu_as').value=nom;
		document.getElementById('id_codcu_nu_as').value=codcta;
		document.getElementById("id_div_cuentas").style.display="none";
	}else if (identificador==4){
		document.getElementById('id_movcuentaingresar2').value=nom;
		document.getElementById('id_movcodcuenta2').value=codcta;
		document.getElementById("id_div_cuentas2").style.display="none";
	}else if (identificador==5){
		document.getElementById('id_cuenta').value=codcta;
		document.getElementById('id_nom_cuentas').value=nom;
		document.getElementById('id_cuenta_pad').value=codctapadre;
		document.getElementById('id_mov').value= mov;
		document.getElementById('id_saldo1').value= s1;
		document.getElementById('id_idt1').value= idt1;
		document.getElementById('id_saldo2').value= s2;
		document.getElementById('id_idt2').value= idt2;
		document.getElementById('id_identific').value=1;
		document.getElementById('id_identificador_txt').value='EDITANDO..';
		document.getElementById('id_identificador_txt').style.background='red';
		document.getElementById('id_div_cuentas').style.display="none";
		document.getElementById('id_cuenta').readOnly = true;
		document.getElementById('id_cuenta_pad').disabled = true;
	}else if (identificador==6) {
		document.getElementById('id_movcuentaingresar').value=nom;
		document.getElementById('id_movcodcuenta').value=codcta;
		document.getElementById("id_div_cuentas").style.display="none";
	}else if (identificador==7) {
		document.getElementById('id_newNomCuent').value= nom;
		document.getElementById('id_newCodCuent').value= codcta; 
		document.getElementById("id_div_cuentas").style.display="none";
	};	
}
//Funcion para GENERAR TABLA DE CUENTAS EN RECIBOS
var array_nom_cuenta=[];
var array_cod_cuenta=[];
var array_valor_debe=[];
var array_valor_haber=[];
var array_estado_ite = [];

function elimiitem_asieto(item_asi) {
	array_estado_ite[item_asi]= 0;
	contsruir_asiento();
}

function generartablacuentas(){
	var var_genprod = document.getElementById('id_movcuentaingresar').value;
	var var_gencod = document.getElementById('id_movcodcuenta').value;
	var var_geningreso = document.getElementById('id_recreciingreso').value;
	var var_genegreso = document.getElementById('id_recreciegreso').value;	

	if (var_genprod=='' || var_gencod=='' || var_geningreso=='' || var_genegreso==''){

		if(var_genprod==''){
			document.getElementById('id_movcuentaingresar').style.border='solid 1px #C92121';
		}else {
			document.getElementById('id_movcuentaingresar').style.border='solid 1px #0A7823';
		};
		if (var_gencod==''){
			document.getElementById('id_movcodcuenta').style.border='solid 1px #C92121';
		}else {
			document.getElementById('id_movcodcuenta').style.border='solid 1px #0A7823';
		};
		if(var_geningreso==''){
			document.getElementById('id_recreciingreso').style.border='solid 1px #C92121';
		}else{
			document.getElementById('id_recreciingreso').style.border='solid 1px #0A7823';
		};
		if (var_genegreso==''){
			document.getElementById('id_recreciegreso').style.border='solid 1px #C92121';
		}else {
			document.getElementById('id_recreciegreso').style.border='solid 1px #0A7823';
		};
		
	}else{
		array_nom_cuenta.push(var_genprod);
		array_cod_cuenta.push(var_gencod);
		array_valor_debe.push(var_geningreso);	
		array_valor_haber.push(var_genegreso);	
		array_estado_ite.push(1);	
		if (document.getElementById('id_valchque_ch')) {
			if (var_gencod=='1.1.1.02.01' || var_gencod == '1.1.1.02.02' || var_gencod=='1.1.1.02.3') {
				if (parseFloat(var_geningreso) > parseFloat(var_genegreso)) {
					document.getElementById('id_valchque_ch').value=var_geningreso;
				}else{
					document.getElementById('id_valchque_ch').value=var_genegreso;
				};
				
			};
		};
		contsruir_asiento();
	};
}

function contsruir_asiento () {
	var ingreso = 0;
	var egreso = 0;
	var out ='';
	out = out + '<table style="width:100%;">';	
	out = out + '<tr>';
	out = out + '<td><strong>CUENTA.</strong></td>';
	out = out + '<td><strong>CODIGO.</strong></td>';
	out = out + '<td><strong>DEBE.</strong></td>';
	out = out + '<td><strong>HABER.</strong></td>';
	out = out + '<td><strong></strong></td>';
	out = out + '</tr>';
	for (var i = 0 ; i < array_nom_cuenta.length; i++) {
		if (array_estado_ite[i]==1){
			out = out + '<tr>';
			out = out + '<td style="width:60%;"><input type="text" class="cl_txt" name="c_cuenta1[]" value="'+array_nom_cuenta[i]+'" style="width:100%" readonly/></td>';
			out = out + '<td><input type="text" class="cl_txt" name="c_condigo_cu1[]" value="'+array_cod_cuenta[i]+'" readonly/></td>';
			out = out + '<td align="right"><input type="number" step="0.01" class="cl_txt2" name="c_debe_cu1[]" value="'+array_valor_debe[i]+'" required/></td>';
			out = out + '<td align="right"><input type="number" step="0.01" class="cl_txt2" name="c_haber_cu1[]" value="'+array_valor_haber[i]+'" required/></td>';
			out = out + '<td align="right"><input type="button" value="X" onclick="elimiitem_asieto('+i+');" style="background:red;"></td>';
			out = out + '</tr>';

			ingreso= parseFloat(ingreso) + parseFloat(array_valor_debe[i]);
			ingreso= ingreso.toFixed(2)	;
			egreso= parseFloat(egreso) + parseFloat(array_valor_haber[i]);
			egreso= egreso.toFixed(2)	;
		}
	};
	out=out+'</table>';
	if (ingreso==egreso) {
		document.getElementById('btn_guardar_compras').style.display='inline-block';
	} else{
		document.getElementById('btn_guardar_compras').style.display='none';
	};
	document.getElementById('id_total_debe').value=ingreso;
	document.getElementById('id_total_haber').value=egreso;
	document.getElementById('id_movcuentaingresar').value='';
	document.getElementById('id_movcodcuenta').value='';
	document.getElementById('id_recreciingreso').value='';
	document.getElementById('id_recreciegreso').value='';	
	document.getElementById("id_div_asiento").innerHTML = out;	
}
//------------------------------------------------------------------------------------------------------------
//------------------------23/11/2015 FUNCION ACTUALIZADA-------------------------------------------------------------------------
function mostrardatosempresa(val)
{
	//alert(val);
	var cadena=val;
	var elemt= cadena.split('|');
	var idt=elemt[0];
	var rz=elemt[1];
	var ruc=elemt[2];
	var empdirec = elemt[3];
	var emptelf = elemt[4];
	var empimpuesto = elemt[5];
	var empprimerfact = elemt[6];
	var empfechacrea = elemt[7];
	var cotizacion = elemt[8];
	var empvalmin = elemt[9];
	var empitems = elemt[10];
	var empnombre = elemt[11];
	var empcodigo = elemt[12];
	var empestado = elemt[13];
	var ambiente = elemt[14];
	var fechtrabajo = elemt[15];
	var regempser1 = elemt [16];
	var regempser2 = elemt [17];
	var regempinifact = elemt [18];
	var regempinreten = elemt [19];
	var regempnumcontrib = elemt [20];
	var regempoblcont = elemt [21];
	var regempncventas = elemt [22];
	var regempgias = elemt [23];
	var regempdirlocal = elemt [24];
	var regempcobrofact = elemt [25];
	var regempcomp = elemt [26];
	var regempnotacont = elemt [27];
	var regempingreso = elemt [28];
	var regempegreso = elemt [29];
	var regempinil = elemt [30];
	var regempcambinve = elemt [31];
	/*//IDT_EMPRESA, EMP_RAZON_SOCIAL, EMP_RUC, EMP_DIRECCION, EMP_TELEFONO, EMP_IMPUESTO, 
	EMP_PRIMER_FACT, EMP_FECH_CREA, EMP_COTIZACION, EMP_MAX_ITEMS, EMP_VALMIN_CF, 
	EMP_NOMBRE, EMP_CODIGO, EMP_ESTADO, EMP_AMBIENTE, EMP_FECHA_TRABAJO,*/

	document.getElementById('id_emprazonsoc').value=idt;
	document.getElementById('id_idt_emp').value=idt;
	document.getElementById('id_rz').value=rz;
	document.getElementById('id_ruc').value=ruc;
	document.getElementById('id_empdirec').value=empdirec;
	document.getElementById('id_emptelf').value=emptelf;
	document.getElementById('id_empimpuesto').value=empimpuesto;
	document.getElementById('id_empprimerfact').value=empprimerfact;
	document.getElementById('id_empfechacrea').value=empfechacrea;
	document.getElementById('id_cotizacion').value=cotizacion;
	document.getElementById('id_empvalmin').value=empvalmin;
	document.getElementById('id_empitems').value=empitems;
	document.getElementById('id_empnombre').value=empnombre;
	document.getElementById('id_empcodigo').value=empcodigo;
	document.getElementById('id_empestado').value=empestado;
	document.getElementById('id_ambiente').value=ambiente;
	document.getElementById('id_regempser1').value=regempser1;
	document.getElementById('id_regempser2').value=regempser2;
	document.getElementById('id_regempinifact').value=regempinifact;
	document.getElementById('id_regempinreten').value=regempinreten;
	document.getElementById('id_regempnumcontrib').value=regempnumcontrib;
	document.getElementById('id_regempoblcont').value=regempoblcont;
	document.getElementById('id_regempncventas').value=regempncventas;
	document.getElementById('id_regempgias').value=regempgias;
	document.getElementById('id_regempdirlocal').value=regempdirlocal;
	document.getElementById('id_regempcobrofact').value=regempcobrofact;
	document.getElementById('id_regempcomp').value=regempcomp;
	document.getElementById('id_regempnotacont').value=regempnotacont;
	document.getElementById('id_regempingreso').value=regempingreso;
	document.getElementById('id_regempegreso').value=regempegreso;
	document.getElementById('id_regempinil').value=regempinil;
	document.getElementById('id_regempcambinve').value=regempcambinve;
	if (idt=='0') {
		document.getElementById('id_etiqueta').value='NUEVO..';		
		document.getElementById('id_etiqueta').style.background='green';		
	} else{
		document.getElementById('id_etiqueta').value='EDITANDO..';			
		document.getElementById('id_etiqueta').style.background='red';
	};
}

//------------------------------------------13112015  go10------
function mostar_fielset(id_div,val_verificador){
	document.getElementById('id_div_fechas').style.display='none';
	document.getElementById('id_cliente_prov').style.display='none';
	document.getElementById('id_div_documento').style.display='none';
	document.getElementById(id_div).style.display='block';
	document.getElementById('id_verfic').value=val_verificador;
	document.getElementById('id_div_resultados_reimpresiones').innerHTML='';
}
//------------------------------17112015-------------------------------
function activar_cajas_para_nc (identificador) {
	if (document.getElementById('id_chk_nc'+identificador).checked == true){

		document.getElementById('id_cant_nc'+identificador).readOnly=false;
		document.getElementById('id_vuni_nc'+identificador).readOnly=false;
		//document.getElementById('id_vtot_nc'+identificador).readOnly=false;

		document.getElementById('id_cod_nc'+identificador).style.background='green';
		document.getElementById('id_descr_nc'+identificador).style.background='green';
		document.getElementById('id_cant_nc'+identificador).style.background='green';
		document.getElementById('id_vuni_nc'+identificador).style.background='green';
		document.getElementById('id_vtot_nc'+identificador).style.background='green';
		document.getElementById('id_verificador_nc'+identificador).value='1';

	}else{
		document.getElementById('id_cant_nc'+identificador).readOnly=true;
		document.getElementById('id_vuni_nc'+identificador).readOnly=true;
		//document.getElementById('id_vtot_nc'+identificador).readOnly=true;

		document.getElementById('id_cod_nc'+identificador).style.background='#fff';
		document.getElementById('id_descr_nc'+identificador).style.background='#fff';
		document.getElementById('id_cant_nc'+identificador).style.background='#fff';
		document.getElementById('id_vuni_nc'+identificador).style.background='#fff';
		document.getElementById('id_vtot_nc'+identificador).style.background='#fff';
		document.getElementById('id_verificador_nc'+identificador).value='0';
	}
	sumar_checks();
}
function sumar_checks() {

	var tot_aray_chk = document.c_frm_fact_nc.c_chk_nc.length;
	//alert('este es .'+tot_aray_chk);
	if (tot_aray_chk== undefined || tot_aray_chk==''|| tot_aray_chk=='NaN' || tot_aray_chk=='undefined' || tot_aray_chk=='UNDEFINED') {
		tot_aray_chk= 1;
		//alert('mal');
	} else{
		//alert('siii');
		tot_aray_chk = document.c_frm_fact_nc.c_chk_nc.length;
	};

	var suma12_nc =0;
	var suma0_nc = 0;

	for (var i = 0; i < tot_aray_chk; i++) {
		if (document.getElementById('id_chk_nc'+i).checked) {
			if (document.getElementById('id_imp_nc'+i).value==1) {
				suma12_nc =parseFloat(suma12_nc) +parseFloat(document.getElementById('id_vtot_nc'+i).value);
			} else{
				suma0_nc =parseFloat(suma0_nc) +parseFloat(document.getElementById('id_vtot_nc'+i).value);
			};
		};
	};
	//alert('esta es la base de 12: '+suma12_nc);
	//alert('esta es la base de 0: '+suma0_nc);
	suma12_sin_iva_nc =  suma12_nc /1.12;
	suma12_sin_iva_nc = suma12_sin_iva_nc.toFixed(2);
	var iva_nc =  parseFloat(suma12_nc) -  parseFloat(suma12_sin_iva_nc);
	iva_nc= iva_nc.toFixed(2);
	var subtotal_nc = parseFloat(suma12_sin_iva_nc) + parseFloat(suma0_nc);
	subtotal_nc = subtotal_nc.toFixed(2);
	var total_nc = parseFloat(suma12_sin_iva_nc) + parseFloat(suma0_nc) + parseFloat(iva_nc);
	if( total_nc >0 ) {
		document.getElementById('id_btn_gen_nc').disabled =false;
	}else{
		document.getElementById('id_btn_gen_nc').disabled =true;
	}

	document.getElementById('id_subtota_nc').value=subtotal_nc;
	document.getElementById('id_desc_nc').value='0.00';
	document.getElementById('id_base12_nc').value=suma12_sin_iva_nc;
	document.getElementById('id_base0_nc').value=suma0_nc;
	document.getElementById('id_iva_nc').value=iva_nc;
	document.getElementById('id_total_nc_nc').value=total_nc.toFixed(2);
	
	document.getElementById('id_subtota_nc').style.background='green';
	document.getElementById('id_desc_nc').style.background='green';
	document.getElementById('id_base12_nc').style.background='green';
	document.getElementById('id_base0_nc').style.background='green';
	document.getElementById('id_iva_nc').style.background='green';
	document.getElementById('id_total_nc_nc').style.background='green';

}
//fincion que calcula nuevos valores para las nc------------------
function calcular_val_nc (ident) {
	var cant = document.getElementById('id_cant_nc'+ident).value;
	var valu = document.getElementById('id_vuni_nc'+ident).value;
	if (cant=='' || valu =='') {
		if (cant=='') {
			document.getElementById('id_cant_nc'+ident).style.background='red';
		} else{
			document.getElementById('id_cant_nc'+ident).style.background='green';
		};
		if (valu=='') {
			document.getElementById('id_vuni_nc'+ident).style.background='red';
		} else{
			document.getElementById('id_vuni_nc'+ident).style.background='green';
		};
		document.getElementById('id_vtot_nc'+ident).style.background='red';
		document.getElementById('id_subtota_nc').style.background='red';
		document.getElementById('id_desc_nc').style.background='red';
		document.getElementById('id_base12_nc').style.background='red';
		document.getElementById('id_base0_nc').style.background='red';
		document.getElementById('id_iva_nc').style.background='red';
		document.getElementById('id_total_nc_nc').style.background='red';

		document.getElementById('id_vtot_nc'+ident).value='';
		document.getElementById('id_subtota_nc').value='';
		document.getElementById('id_desc_nc').value='';
		document.getElementById('id_base12_nc').value='';
		document.getElementById('id_base0_nc').value='';
		document.getElementById('id_iva_nc').value='';
		document.getElementById('id_total_nc_nc').value='';
	} else{
		document.getElementById('id_cant_nc'+ident).style.background='green';
		document.getElementById('id_vuni_nc'+ident).style.background='green';
		document.getElementById('id_vtot_nc'+ident).style.background='green';
		new_val_tot_nc = parseFloat(cant) * parseFloat(valu);
		document.getElementById('id_vtot_nc'+ident).value= new_val_tot_nc.toFixed(2);
		sumar_checks();
	};
}
//--------------------------------20 11 2015---------
function mostarconductor(idconduc,nombrecond,ruc_cond,placa,color,marca,descript,identificador,chasis,modelo){
	//alert('los conductores');
	if (identificador==1){
		document.getElementById('id_nombr_cond_fac').value=nombrecond;
		document.getElementById('id_palca_fact').value=placa;
		document.getElementById('id_descrip_fac').value=descript;
		document.getElementById('id_cod_cond_fac').value=idconduc;
		document.getElementById('id_ruc_cond_fact').value =ruc_cond;
		//document.getElementById('id_modelo').value=modelo;
	}else if(identificador==2){
		document.getElementById('id_conductor_con').value=nombrecond;
		document.getElementById('id_ruc_id_con').value=ruc_cond;
		document.getElementById('id_placas_con').value=placa;
		document.getElementById('id_color_con').value=color;
		document.getElementById('id_chasis_con').value=chasis;
		document.getElementById('id_marca_con').value=marca;
		document.getElementById('id_descript_con').value=descript;
		document.getElementById('id_modelo_con').value=modelo;
		document.getElementById('id_idconductor').value=idconduc;
		document.getElementById('id_identificador_con').value='1';
		document.getElementById('id_aletra_con').value='EDITANDO..';
		document.getElementById('id_aletra_con').style.background='RED';
	}else if(identificador==3){
		document.getElementById('id_ih_vehiculo').value=idconduc;
		document.getElementById('id_nom_conduc_gia').value=nombrecond;
		document.getElementById('id_placa_vehic_gia').value=placa;
		document.getElementById('id_ruc_conduc_gia').value=ruc_cond;
	}
	document.getElementById("id_buscadorconductores").style.display="none";
}
//----------------------------frunciom que permite mostar el cuadro de conductor -----------------
function mostrarconductor (tipo_transacc) {
	//alert(tipo_transacc);
	if (tipo_transacc=='G') {
		document.getElementById('id_div_Conductor_fact').style.display='block';
		document.getElementById('id_nombr_cond_fac').setAttribute('required', 'required');
		document.getElementById('id_direc_partida').setAttribute('required', 'required');
		document.getElementById('id_direc_llegada').setAttribute('required', 'required');
		document.getElementById('id_fecha_llegada_guia').setAttribute('required', 'required');

		document.getElementById('id_nombr_cond_fac').readOnly = false;
		document.getElementById('id_direc_partida').readOnly = false;
		document.getElementById('id_direc_llegada').readOnly = false;
		document.getElementById('id_fecha_llegada_guia').readOnly = false;

	} else if (tipo_transacc =='V' || tipo_transacc =='W'){
		document.getElementById('id_div_Conductor_fact').style.display='none';
		document.getElementById('id_nombr_cond_fac').removeAttribute('required', 'required');
		document.getElementById('id_direc_partida').removeAttribute('required', 'required');
		document.getElementById('id_direc_llegada').removeAttribute('required', 'required');
		document.getElementById('id_fecha_llegada_guia').removeAttribute('required', 'required');

		document.getElementById('id_nombr_cond_fac').readOnly = true;
		document.getElementById('id_direc_partida').readOnly = true;
		document.getElementById('id_direc_llegada').readOnly = true;
		document.getElementById('id_fecha_llegada_guia').readOnly = true;
	};
}
//------------------------funcion que calcula el pago de facturas de cleintes--------------------
function calcularpago (numero_identificador) {
	if (document.getElementById('id_chk_pago'+numero_identificador).checked == true){

		document.getElementById('id_new_abono'+numero_identificador).readOnly=false;	
		document.getElementById('id_new_abono'+numero_identificador).style.background='green';

		var new_saldo = document.getElementById('id_new_saldo'+numero_identificador).value;
		var new_abono = document.getElementById('id_new_abono'+numero_identificador).value;

		new_saldo =  new_saldo - new_abono;
		document.getElementById('id_new_saldo'+numero_identificador).value = new_saldo.toFixed(2);
		document.getElementById('id_identificador_pago'+numero_identificador).value='1';

	}else{
		document.getElementById('id_new_abono'+numero_identificador).readOnly=true;
		document.getElementById('id_new_abono'+numero_identificador).style.background='#fff';
		document.getElementById('id_new_saldo'+numero_identificador).style.background='#fff';
		document.getElementById('id_new_abono'+numero_identificador).value =  document.getElementById('id_ant_saldo'+numero_identificador).value;
		document.getElementById('id_new_saldo'+numero_identificador).value =  document.getElementById('id_ant_saldo'+numero_identificador).value;
		document.getElementById('id_identificador_pago'+numero_identificador).value='0';
	}
	sumar_checks_pagos();
}
//fincion que calcula nuevos valores para las nc------------------
function calcular_nuevo_abono_saldo (numero_identificador) {
	var new_abono = document.getElementById('id_new_abono'+numero_identificador).value;
	//var new_saldo = document.getElementById('id_new_saldo'+numero_identificador).value;
	var ant_abono = document.getElementById('id_ant_abono'+numero_identificador).value;
	var tot_factu = document.getElementById('id_tot_factu'+numero_identificador).value;

	if (new_abono=='' || ant_abono =='' ||tot_factu=='') {
		if (new_abono=='') {
			document.getElementById('id_new_abono'+numero_identificador).style.background='red';
		} else{
			document.getElementById('id_new_abono'+numero_identificador).style.background='green';
		};
		if (tot_factu=='') {
			document.getElementById('id_tot_factu'+numero_identificador).style.background='red';
		} else{
			document.getElementById('id_tot_factu'+numero_identificador).style.background='green';
		};
		document.getElementById('id_new_saldo'+numero_identificador).style.background='red';
		document.getElementById('id_new_saldo'+numero_identificador).value='';
	} else{
		document.getElementById('id_new_abono'+numero_identificador).style.background='green';
		document.getElementById('id_new_saldo'+numero_identificador).style.background='green';
		new_saldo = parseFloat(tot_factu)-(parseFloat(new_abono) + parseFloat(ant_abono));
		document.getElementById('id_new_saldo'+numero_identificador).value= new_saldo.toFixed(2);
		sumar_checks_pagos();
	};
}
//----------------------------------------sumar valores pagos frm_cobros---------
function sumar_checks_pagos() {
	//alert();
	var tot_aray_chk = document.c_frm_cobros_facturas.c_chk_pago.length;
	//alert('este es .'+tot_aray_chk);
	if (tot_aray_chk== undefined || tot_aray_chk==''|| tot_aray_chk=='NaN' || tot_aray_chk=='undefined' || tot_aray_chk=='UNDEFINED') {
		tot_aray_chk= 1;
		//alert('mal');
	} else{
		//alert('siii');
		tot_aray_chk = document.c_frm_cobros_facturas.c_chk_pago.length;
	};
	//alert(tot_aray_chk);

	var suma_total_pago = 0;
	var suma_total_saldo = 0;
	var contCkecksActivos = 0;
	for (var i = 0; i < tot_aray_chk; i++) {
		//alert('si suma');
		if (document.getElementById('id_chk_pago'+i).checked) {
			contCkecksActivos = contCkecksActivos + 1;
			//alert(contCkecksActivos);
			if (document.getElementById('id_identificador_pago'+i).value==1) {
				suma_total_pago =parseFloat(suma_total_pago) +parseFloat(document.getElementById('id_new_abono'+i).value);
			};
		};
	};
	var tot_saldo_actual = document.getElementById('id_tot_saldo_act').value;
	new_saldo = parseFloat(tot_saldo_actual) - parseFloat(suma_total_pago);
	if (contCkecksActivos > 0) {
		document.getElementById('id_generar_pago').style.display="inline-block";
	} else{
		document.getElementById('id_generar_pago').style.display="none";
	};
	/*if (suma_total_pago > 0) {
		document.getElementById('id_generar_pago').style.display="inline-block";
	} else{
		document.getElementById('id_generar_pago').style.display="none";
	};*/
	document.getElementById('id_tot_new_abon').value=suma_total_pago.toFixed(2);
	document.getElementById('id_tot_new_saldo').value=new_saldo.toFixed(2);

	document.getElementById('id_tot_new_abon').style.background='#A4A4A4';
	document.getElementById('id_tot_new_saldo').style.background='#A4A4A4';
}
//-------------------------funcion para contsruir gasto -------------------
var array_descripcion_gast =[];
var array_cant_gast =[];
var array_val_unit_gast =[];
var array_val_tota_gast =[];
function construirgasto () {
	var var_descripcion_gast = document.getElementById('id_descripcion_gast').value;
	var var_cant_gast = document.getElementById('id_cant_gast').value;
	var var_val_unit_gast = document.getElementById('id_val_unit_gast').value;
	var var_val_tota_gast = document.getElementById('id_val_tota_gast').value; 
	if (var_descripcion_gast =='' || var_cant_gast =='' || var_val_unit_gast=='' || var_val_tota_gast=='') {
		if (var_descripcion_gast=='') {
			document.getElementById('id_descripcion_gast').style.border='solid 1px red';
		} else{
			document.getElementById('id_descripcion_gast').style.border='solid 1px green';
		};
		if (var_cant_gast=='') {
			document.getElementById('id_cant_gast').style.border='solid 1px red';
		} else{
			document.getElementById('id_cant_gast').style.border='solid 1px green';
		};
		if (var_val_unit_gast=='') {
			document.getElementById('id_val_unit_gast').style.border='solid 1px red';
		} else{
			document.getElementById('id_val_unit_gast').style.border='solid 1px green';
		};
		if (var_val_tota_gast=='') {
			document.getElementById('id_val_tota_gast').style.border='solid 1px red';
		} else{
			document.getElementById('id_val_tota_gast').style.border='solid 1px green';
		};
	} else{
		array_descripcion_gast.push(var_descripcion_gast);
		array_cant_gast.push(var_cant_gast);
		array_val_unit_gast.push(var_val_unit_gast);
		array_val_tota_gast.push(var_val_tota_gast);
		var out ='';
		out = out + '<table style="width:100%;">';	
		out = out + '<tr>';
		out = out + '<td><strong>DESCRIPCION</strong></td>';
		out = out + '<td><strong>CANTIDAD</strong></td>';
		out = out + '<td><strong>V. UNITARIO.</strong></td>';
		out = out + '<td><strong>V. TOTAL.</strong></td>';
		out = out + '<td><strong></strong></td>';
		out = out + '</tr>';
		for (var i = 0 ; i < array_descripcion_gast.length; i++) {
			out = out + '<tr>';
			out = out + '<td><input type="text" class="cl_txt" name="c_descripcion_gast1[]" value="'+array_descripcion_gast[i]+'" required/></td>';
			out = out + '<td><input type="number" class="cl_txt2" name="c_cant_gast1[]" value="'+array_cant_gast[i]+'" required/></td>';
			out = out + '<td><input type="number" class="cl_txt2" name="c_val_unit_gast1[]" value="'+array_val_unit_gast[i]+'" required/></td>';
			out = out + '<td><input type="number" class="cl_txt2" name="c_val_tota_gast1[]" value="'+array_val_tota_gast[i]+'" required/></td>';
			out = out + '<td align="right"><a href="#">x</a></td>';
			out = out + '</tr>';
		};
		out=out+'</table>';	

		document.getElementById('id_detalle_gasto').innerHTML= out ;
		document.getElementById('id_descripcion_gast').value='';
		document.getElementById('id_cant_gast').value='';
		document.getElementById('id_val_unit_gast').value='';
		document.getElementById('id_val_tota_gast').value=''; 

	};
}
//-------------------------------------funcion que me selecciona la compra l¿para la nc de compras---------------
function seleccionar_from_nc_com(numero) {

	if (document.getElementById('id_chk_nc_com'+numero).checked == true){
		document.getElementById('id_estado_nc_txt'+numero).value='1';
		document.getElementById('nc'+numero).style.background='green';
		document.getElementById('sub'+numero).style.background='green';
		document.getElementById('b12'+numero).style.background='green';
		document.getElementById('b0'+numero).style.background='green';
		document.getElementById('iv'+numero).style.background='green';
		document.getElementById('t1'+numero).style.background='green';
		document.getElementById('t2'+numero).style.background='green';
		document.getElementById('ab'+numero).style.background='green';
		document.getElementById('sa'+numero).style.background='green';
		document.getElementById('sa'+numero).value='0.00';

		document.getElementById('ab'+numero).readOnly=false;
		document.getElementById('btn_guardar_compras').style.display='inline-block'

	}else{
		document.getElementById('id_estado_nc_txt'+numero).value='0';
		document.getElementById('nc'+numero).style.background='#fff';
		document.getElementById('sub'+numero).style.background='#fff';
		document.getElementById('b12'+numero).style.background='#fff';
		document.getElementById('b0'+numero).style.background='#fff';
		document.getElementById('iv'+numero).style.background='#fff';
		document.getElementById('t1'+numero).style.background='#fff';
		document.getElementById('t2'+numero).style.background='#fff';
		document.getElementById('ab'+numero).style.background='#fff';
		document.getElementById('sa'+numero).style.background='#fff';
		
	}
}


//----------------------------------------------------------06-01-2015------------------------------------------------------
function edit_compra () {
	document.getElementById('id_clienteprovee_glo').readOnly = false;
	document.getElementById('id_num_fac_comp').readOnly = false;
	document.getElementById('id_aut_comp').readOnly = false;
	document.getElementById('id_fecha_ing_comp').style.display='none';
	document.getElementById('id_new_date_comp').style.display='inline-block';

	document.getElementById('id_clienteprovee_glo').style.background='green';
	document.getElementById('id_num_fac_comp').style.background='green';
	document.getElementById('id_aut_comp').style.background='green';
	document.getElementById('id_new_date_comp').style.background='green';
	document.getElementById('id_fecha_ing_comp').style.background='green';

	document.getElementById('id_btn_edi_compra').style.display='none';
	document.getElementById('id_btn_can_edit_compra').style.display='inline-block';
	document.getElementById('id_btn_save_new_compra').style.display='inline-block';

	var tipocomp = document.getElementById('id_tipo_trans').value;

	if (tipocomp=='D' || tipocomp == 'C') {
		document.getElementById('id_subt_comp').readOnly = false;
		document.getElementById('id_base0_comp').readOnly = false;
		document.getElementById('id_base12_comp').readOnly = false;
		document.getElementById('id_iva_comp').readOnly = false;
		document.getElementById('id_total_comp').readOnly = false;

		document.getElementById('id_subt_comp').style.background='green';
		document.getElementById('id_base0_comp').style.background='green';
		document.getElementById('id_base12_comp').style.background='green';
		document.getElementById('id_iva_comp').style.background='green';
		document.getElementById('id_total_comp').style.background='green';
	};
}
// funcion para mostar el asiento  en pfrm pago a proveedores---------------------------------------
function consulta_pagos (identificador) {
	//alert(identificador);
	//document.getElementById('id_div_generador_asiento').style.display='none';
	document.getElementById('id_div_cheque').style.display='none';
	document.getElementById('btn_guardar_compras').style.display="none";
	document.getElementById('id_txt_idetificador').value=identificador;
	document.getElementById('id_nombrepago_ch').value=document.getElementById('id_clienteprovee_glo').value;
	if (identificador== 1){
		document.getElementById('id_div_cheque').style.display='none';

		document.getElementById('id_numchque_ch').removeAttribute('required', 'required');
		document.getElementById('id_valchque_ch').removeAttribute('required', 'required');
		document.getElementById('id_fechacob_ch').removeAttribute('required', 'required');

		if (document.getElementById('id_tot_new_abon').value > 0) {
			document.getElementById('id_div_generador_asiento').style.display='block';
		} else{
			document.getElementById('id_div_generador_asiento').style.display='none';
		};
	}else if(identificador==3){
		document.getElementById('id_div_cheque').style.display='block';

		document.getElementById('id_numchque_ch').setAttribute('required', 'required');
		document.getElementById('id_valchque_ch').setAttribute('required', 'required');
		document.getElementById('id_fechacob_ch').setAttribute('required', 'required');
		if(document.getElementById('id_tot_new_abon')){
			if (document.getElementById('id_tot_new_abon').value > 0) {
				document.getElementById('id_div_generador_asiento').style.display='block';
			} else{
				document.getElementById('id_div_generador_asiento').style.display='none';
			};
		};
	};
	
}
//funcion para pagos a proveedores 
function calcularpago_proveedor (numero_identificador) {

	if (document.getElementById('id_chk_pago'+numero_identificador).checked == true){
		document.getElementById('id_new_abono'+numero_identificador).readOnly=false;	
		document.getElementById('id_new_abono'+numero_identificador).style.background='green';
		var new_saldo = document.getElementById('id_new_saldo'+numero_identificador).value;
		var new_abono = document.getElementById('id_new_abono'+numero_identificador).value;
		new_saldo =  new_saldo - new_abono;
		document.getElementById('id_new_saldo'+numero_identificador).value = new_saldo.toFixed(2);
		document.getElementById('id_identificador_pago'+numero_identificador).value='1';

	}else{
		document.getElementById('id_new_abono'+numero_identificador).readOnly=true;
		document.getElementById('id_new_abono'+numero_identificador).style.background='#fff';
		document.getElementById('id_new_saldo'+numero_identificador).style.background='#fff';
		document.getElementById('id_new_abono'+numero_identificador).value =  document.getElementById('id_ant_saldo'+numero_identificador).value;
		document.getElementById('id_new_saldo'+numero_identificador).value =  document.getElementById('id_ant_saldo'+numero_identificador).value;
		document.getElementById('id_identificador_pago'+numero_identificador).value='0';
	}
	//sumar_checks_pago_proveedor();


	/*var tipo  = document.getElementById('id_tipo_comp'+numero_identificador).value;
	var cont_tipo  = document.getElementById('id_cont_verif'+numero_identificador).value;
	if (document.getElementById('id_verficadto_tipo').value == '0') {
		document.getElementById('id_verficadto_tipo').value=tipo;
	} else{
		if (tipo != document.getElementById('id_verficadto_tipo').value) {
			document.getElementById('id_verficadto_tipo').value=tipo;
			generartablacuentas();
		};
	};*/

	sumar_checks_pago_proveedor();

}

function calcular_nuevo_abono_saldo_prov (numero_identificador) {
	var new_abono = document.getElementById('id_new_abono'+numero_identificador).value;
	//var new_saldo = document.getElementById('id_new_saldo'+numero_identificador).value;
	var ant_abono = document.getElementById('id_ant_abono'+numero_identificador).value;
	var tot_saldo = document.getElementById('id_ant_saldo'+numero_identificador).value;

	if (new_abono=='' || ant_abono =='' ||tot_saldo=='') {
		if (new_abono=='') {
			document.getElementById('id_new_abono'+numero_identificador).style.background='red';
		} else{
			document.getElementById('id_new_abono'+numero_identificador).style.background='green';
		};
		if (tot_saldo=='') {
			document.getElementById('id_ant_saldo'+numero_identificador).style.background='red';
		} else{
			document.getElementById('id_ant_saldo'+numero_identificador).style.background='#fff';
		};
		document.getElementById('id_new_saldo'+numero_identificador).style.background='red';
		document.getElementById('id_new_saldo'+numero_identificador).value='';
	} else{
		document.getElementById('id_new_abono'+numero_identificador).style.background='green';
		document.getElementById('id_new_saldo'+numero_identificador).style.background='green';
		new_saldo = parseFloat(tot_saldo)-(parseFloat(new_abono));
		document.getElementById('id_new_saldo'+numero_identificador).value= new_saldo.toFixed(2);
		sumar_checks_pago_proveedor();	
	};
}

function sumar_checks_pago_proveedor() {
	var tot_aray_chk = document.c_frm_cobros_facturas.c_chk_pago.length;
	if (tot_aray_chk== undefined || tot_aray_chk==''|| tot_aray_chk=='NaN' || tot_aray_chk=='undefined' || tot_aray_chk=='UNDEFINED') {
		tot_aray_chk= 1;
	} else{
		tot_aray_chk = document.c_frm_cobros_facturas.c_chk_pago.length;
	};

	var suma_total_pago = 0;
	var suma_total_saldo = 0;
	for (var i = 0; i < tot_aray_chk; i++) {
		//alert('si suma');
		if (document.getElementById('id_chk_pago'+i).checked) {
			if (document.getElementById('id_identificador_pago'+i).value==1) {
				if (document.getElementById('id_tipo_comp'+i).value ==  'J' || document.getElementById('id_tipo_comp'+i).value ==  'I') {
					valasum = parseFloat(document.getElementById('id_new_abono'+i).value )* (-1);
				} else{
					valasum = parseFloat(document.getElementById('id_new_abono'+i).value) * (1);
				};
				suma_total_pago =parseFloat(suma_total_pago) + valasum;
			};
		};
	};
	var tot_saldo_actual = document.getElementById('id_tot_saldo_act').value;
	new_saldo = parseFloat(tot_saldo_actual) - parseFloat(suma_total_pago);
	//if (suma_total_pago > 0) {
		document.getElementById('id_div_generador_asiento').style.display='block';	
		document.getElementById('id_agregar_cuenta').style.display="inline-block";
		document.getElementById('id_recreciingreso').value = suma_total_pago.toFixed(2);		
	//} else{
	//	document.getElementById('id_div_generador_asiento').style.display='none';			
	//	document.getElementById('id_agregar_cuenta').style.display="none";
	//};
	document.getElementById('id_tot_new_abon').value=suma_total_pago.toFixed(2);
	document.getElementById('id_tot_new_saldo').value=new_saldo.toFixed(2);
	document.getElementById('id_tot_new_abon').style.background='#A4A4A4';
	document.getElementById('id_tot_new_saldo').style.background='#A4A4A4';
}
function sumnew_compras () {
	var var_subt = document.getElementById('id_subt_comp').value;
	var var_bas0 = document.getElementById('id_base0_comp').value;
	var var_ba12 = document.getElementById('id_base12_comp').value;
	var var_iva = document.getElementById('id_iva_comp').value;
	var sumtotal = 0.00;
	if (var_subt == '' || var_bas0 == '' || var_ba12 == '' || var_iva=='') {
		if (var_subt =='') {
			document.getElementById('id_subt_comp').style.border='solid 1px red';
		} else{
			document.getElementById('id_subt_comp').style.border='solid 1px green';
		};
		if (var_bas0 =='') {
			document.getElementById('id_base0_comp').style.border='solid 1px red';
		} else{
			document.getElementById('id_base0_comp').style.border='solid 1px green';
		};
		if (var_ba12 =='') {
			document.getElementById('id_base12_comp').style.border='solid 1px red';
		} else{
			document.getElementById('id_base12_comp').style.border='solid 1px green';
		};
		if (var_iva=='') {
			document.getElementById('id_iva_comp').style.border='solid 1px red';
		} else{
			document.getElementById('id_iva_comp').style.border='solid 1px green';
		};
	} else{
		document.getElementById('id_subt_comp').style.border='solid 1px green';
		document.getElementById('id_base0_comp').style.border='solid 1px green';
		document.getElementById('id_base12_comp').style.border='solid 1px green';
		document.getElementById('id_iva_comp').style.border='solid 1px green';
		
		sumtotal =  parseFloat(sumtotal) + parseFloat(var_bas0) + parseFloat(var_ba12) + parseFloat(var_iva) ;	
		sumtotal = sumtotal.toFixed(2);
		document.getElementById('id_total_comp').value= sumtotal;
	};
}
//-----------------------------------------------------------------------------------------------------------------------
function val_tipo_doc() {
	var tipo = document.getElementById('id_adcdumento').value;
	var numerodoc = document.getElementById('id_adcnumdoc').value;
   if (tipo =='0' || tipo==0 || numerodoc =='') {
   		if (tipo=='0' || tipo==0 ) {
   			document.getElementById('id_adcdumento').style.border='solid 1px red';
   		} else{
   			document.getElementById('id_adcdumento').style.border='solid 1px green';
   		};
   		if ( numerodoc =='') {
   			document.getElementById('id_adcnumdoc').style.border='solid 1px red';
   		} else{
   			document.getElementById('id_adcnumdoc').style.border='solid 1px green';
   		};
   } else{
   		val_tipo = parseInt(tipo);
	    if (val_tipo == 1) {
	        check_cedula(numerodoc);
	    }
	    if (val_tipo == 2 || val_tipo==3) {
	        validarRuc(numerodoc);
	    }
	    document.getElementById('id_adcdumento').style.border='solid 1px green';
		document.getElementById('id_adcnumdoc').style.border='solid 1px green';
   };
    
}

function check_cedula(ced) {
    var cedula = ced;
    array = cedula.split("");
    num = array.length;

    if (num == 10) {
        total = 0;
        digito = (array[9] * 1);
        for (i = 0; i < (num - 1) ; i++) {
            mult = 0;
            if ((i % 2) != 0) {
                total = total + (array[i] * 1);
            }
            else {
                mult = array[i] * 2;
                if (mult > 9)
                    total = total + (mult - 9);
                else
                    total = total + mult;
            }
        }
        decena = total / 10;
        decena = Math.floor(decena);
        decena = (decena + 1) * 10;
        final = (decena - total);
        if ((final == 10 && digito == 0) || (final == digito)) {
            //alert("La c\xe9dula ES v\xe1lida!!!" );
            return true;
        }
        else {
            alert("LA CEDULA NO ES CORRECTA...!");
            document.getElementById("id_adcnumdoc").value='';
            //return false;
        }
    }
    else {
        alert("LA CEDULA NO TIENE 10 DIGITOS");
        document.getElementById('ContentPlaceHolder1_txtdocumento').value="";
        document.getElementById("id_adcnumdoc").value='';
        //return false;
    }
}
/////////////FUNCION VALIDAR RUC
function validarRuc(ruc) {
    var number = ruc;
    var dto = number.length;
    var valor;
    var acu = 0;

    if (number == "") {
        alert('No has ingresado ningún dato, porfavor ingresar los datos correspondientes.');

    }
    else {

        if (dto != 13) {
            alert('el ruc debe tener 13 digitos');
        }

        else {
            for (var i = 0; i < dto; i++) {
                valor = number.substring(i, i + 1);
                if (valor == 0 || valor == 1 || valor == 2 || valor == 3 || valor == 4 || valor == 5 || valor == 6 || valor == 7 || valor == 8 || valor == 9) {
                    acu = acu + 1;
                }
            }
            if (acu == dto) {
                while (number.substring(10, 13) != 001) {
                    alert('Los tres últimos dígitos no tienen el código del RUC 001.');
                    return;
                }
                while (number.substring(0, 2) > 24) {
                    alert('Los dos primeros dígitos no pueden ser mayores a 24.');
                    return;
                }
                //alert('El RUC está escrito correctamente');
                //alert('Se procederá a analizar el respectivo RUC.');
                var porcion1 = number.substring(2, 3);
                if (porcion1 < 6) {
                    alert('El tercer dígito es menor a 6, por lo \ntanto el usuario es una persona natural.\n');
                }
                else {
                    if (porcion1 == 6) {
                        alert('El tercer dígito es igual a 6, por lo \ntanto el usuario es una entidad pública.\n');
                    }
                    else {
                        if (porcion1 == 9) {
                            alert('El tercer dígito es igual a 9, por lo \ntanto el usuario es una sociedad privada.\n');
                        }
                    }
                }
            }

            else {
                alert("ERROR: Por favor no ingrese texto");
            }
        }
    }
}
// ------------------------------------funcion para editar un producto de la compra
function cambiar_prod_comp (IDT_DETALLES, DET_FK_IDPROD, PR_DETALLEyPRSENTACION , DET_CANTIDAD,V_UNIT, V_TOT) {
	document.getElementById('id_cambiar_prod').style.display='inline-block';
	document.getElementById('id_product').value= PR_DETALLEyPRSENTACION;
	document.getElementById('id_hd_idt_Detalles').value = IDT_DETALLES;
	document.getElementById('id_codprod').value=DET_FK_IDPROD;
	document.getElementById('id_cantpro').value= DET_CANTIDAD;
	document.getElementById('id_v_unit').value=V_UNIT;
	document.getElementById('id_c_tot').value= V_TOT;
}
function cambiar_cuenta (ITD_ASIENTO, PCU_DESCRIPCION, PCU_CUENTA, ASI_DEBE ,ASI_HABER) {
	document.getElementById('id_div_new_cuenta').style.display='block';
	document.getElementById('id_desc_nu_as').value=PCU_DESCRIPCION;
	document.getElementById('id_idt_nu_as').value=ITD_ASIENTO;
	document.getElementById('id_codcu_nu_as').value=PCU_CUENTA;
	document.getElementById('id_debe_nu_as').value=ASI_DEBE;
	document.getElementById('id_habe_nu_as').value=ASI_HABER;
}
function mostrar_new_asi_admin_coprob (identificador) {
	if (identificador==1) {
		document.getElementById('id_div_new_asiento').style.display='block';
		document.getElementById('did_iv_admin_venta').style.display='none';
	} else{
		document.getElementById('id_div_new_asiento').style.display='none';
	};
};
function calcular_Saldo_nc (numero) {
	var saldo_Act = document.getElementById('sact'+numero).value;
	var nuevo_abono = document.getElementById('ab'+numero).value;
	var nuevo_saldo = saldo_Act - nuevo_abono;
	document.getElementById('sa'+numero).value = nuevo_saldo.toFixed(2);
}
function sacarvaltot_prod_l_costear () {
	
		var cant = document.getElementById('id_cantpro_ingr_l').value;
		var vunitot = document.getElementById('id_valtotp_ingr_l').value;
		if (cant==0 || cant=='0' || cant=='' || vunitot <= 0) {
			if (cant==0 || cant=='0' || cant=='') {
				document.getElementById('id_cantpro_ingr_l').style.border="red solid 1px";
			} else{
				document.getElementById('id_cantpro_ingr_l').style.border="green solid 1px";
			};
			if (vunitot<=0) {
				document.getElementById('id_valtotp_ingr_l').style.border="red solid 1px";
			} else{
				document.getElementById('id_valtotp_ingr_l').style.border="green solid 1px";
			};
		} else{
			document.getElementById('id_cantpro_ingr_l').style.border="green solid 1px";
			document.getElementById('id_valprod_ingr_l').style.border="green solid 1px";
			document.getElementById('id_valtotp_ingr_l').style.border="green solid 1px";

			var tot_prod = parseFloat(vunitot) / parseFloat(cant);
			tot_prod = tot_prod.toFixed(2);
			document.getElementById('id_valprod_ingr_l').value=tot_prod;
		};

}
function calcular_valo_nc_gast () {
	var var_subt = document.getElementById('id_subt_inv').value;
	var var_ba12 =  document.getElementById('id_base12_inv').value;
	var var_bas0 =  document.getElementById('id_base0_inv').value;
	var var_iva =  document.getElementById('id_iva_inv').value;
	var sum_tot = 0 ;
	if (var_subt=='' || var_ba12 =='' || var_bas0 =='' || var_iva=='') {
		if (var_subt=='') {
			document.getElementById('id_subt_inv').style.border='solid 1px red';
		} else{
			document.getElementById('id_subt_inv').style.border='solid 1px green';
		};
		if (var_ba12=='') {
			document.getElementById('id_base12_inv').style.border='solid 1px red';
		} else{
			document.getElementById('id_base12_inv').style.border='solid 1px green';
		};
		if (var_bas0=='') {
			document.getElementById('id_base0_inv').style.border='solid 1px red';
		} else{
			document.getElementById('id_base0_inv').style.border='solid 1px green';
		};
		if (var_iva=='') {
			document.getElementById('id_iva_inv').style.border='solid 1px red';
		} else{
			document.getElementById('id_iva_inv').style.border='solid 1px green';
		};
	} else{
		document.getElementById('id_subt_inv').style.border='solid 1px green';
		document.getElementById('id_base12_inv').style.border='solid 1px green';
		document.getElementById('id_base0_inv').style.border='solid 1px green';
		document.getElementById('id_iva_inv').style.border='solid 1px green';
		sum_tot = parseFloat(var_ba12)+parseFloat(var_bas0)+parseFloat(var_iva);
		document.getElementById('id_tot_inv').value=sum_tot.toFixed(2);
	};
}
/*
function validar_decimal (numero) {

	if (isNaN(numero)){
        alert (numero + " no es un número.");
    }else{

		if (numero % 1 != 0) {
			document.getElementById('id_cantpro').style.background='red';
		}else{
			document.getElementById('id_cantpro').style.background='#db8f5c';
		} 
	}
}*/
function mostar_Admin(div) {
	document.getElementById('id_div_admin_avanzado').style.display='none';
	document.getElementById('id_div_admin_comp').style.display='none';
	document.getElementById(div).style.display='block';
}
function mostrar_doc_af(IDT_COMPROBANTE,COM_TIPO_COMPR,COM_NUM_COMPROB,COM_FEC_CREA,COM_VAL_SUBT,COM_VAL_BASE0,COM_VAL_BASE12,COM_IVA, COM_TOT, COM_SALDO, COM_ABONO, COM_FKID_CLI_PROV, COM_ESTADO_PAGO, COM_ESTADO_SIS, ident) {
	//alert('lal');
	if (ident==1) {
		document.getElementById('id_idt_doc_af').value=IDT_COMPROBANTE;
		document.getElementById('id_tip_doc_af').value=COM_TIPO_COMPR;
		document.getElementById('id_num_doc_af').value=COM_NUM_COMPROB;
		document.getElementById('id_fec_doc_af').value=COM_FEC_CREA;
		document.getElementById('id_esp_doc_af').value=COM_ESTADO_PAGO;
		document.getElementById('id_ess_doc_af').value=COM_ESTADO_SIS;
		document.getElementById('id_subt_doc_af').value=COM_VAL_SUBT;
		document.getElementById('id_bas0_doc_af').value=COM_VAL_BASE0;
		document.getElementById('id_ba12_doc_af').value=COM_VAL_BASE12;
		document.getElementById('id_iva_doc_af').value=COM_IVA;
		document.getElementById('id_tota_doc_af').value=COM_TOT;
		document.getElementById('id_sald_doc_af').value=COM_SALDO;
		document.getElementById('id_abon_doc_af').value=COM_ABONO;
		document.getElementById('id_div_search_docs').style.display='none';

		var id_idt_doc_ed = document.getElementById('id_idt_doc_ed').value;
		var id_tip_doc_ed = document.getElementById('id_tip_doc_ed').value;

		if (id_idt_doc_ed== IDT_COMPROBANTE) {
			alert('NO SE PUEDE HACER REFERENCIA A EL MISMO DOCUMENTO');
			document.getElementById('id_btn_actu_dat_avanz').style.display='none';
		}else{
			document.getElementById('id_btn_actu_dat_avanz').style.display='block';
			document.getElementById('id_btn_agreg_pag').disabled =false;
		};
		mostar_comp_avanz(IDT_COMPROBANTE,COM_TIPO_COMPR);
	};
}
function cal_saldo_avan (valor, ident) {
	var tot = document.getElementById('id_total_ed').value;
	 if (ident ==1 ) {
	 	tot = parseFloat(tot) - parseFloat(valor) ;
	 	saldo = tot.toFixed(2);
	 	if (isNaN(saldo)){
	 		document.getElementById('id_btn_actu_dat_avanz').style.display="none";
	 		document.getElementById('id_abono_ed').style.background='red';
	 	}else{
	 		document.getElementById('id_btn_actu_dat_avanz').style.display="block";
	 		document.getElementById('id_abono_ed').style.background='green';
	 	}
	 	document.getElementById('id_abono_ed').value=saldo;
	 } else if (ident ==2 ) {
	 	tot = parseFloat(tot) - parseFloat(valor) ;
	 	abono = tot.toFixed(2);
	 	if (isNaN(abono)){
	 		document.getElementById('id_btn_actu_dat_avanz').style.display="none";
	 		document.getElementById('id_saldo_ed').style.background='red';
	 	}else{
	 		document.getElementById('id_btn_actu_dat_avanz').style.display="block";
	 		document.getElementById('id_saldo_ed').style.background='green';
	 	}
	 	document.getElementById('id_saldo_ed').value=abono;
	 };
}
function fun_facturar_v() {
	var nom_cli = document.getElementById('id_clienteprovee_glo').value;
	var ced_cli = document.getElementById('id_ruc_ced').value;
	for (var i = 0; i < document.frm_factura.c_ratiotipo.length; i++) {
		if (document.frm_factura.c_ratiotipo[i].checked) {
			var tipo_doc_fac = document.frm_factura.c_ratiotipo[i].value;
			break;
		};
	};

	//alert(tipo_doc_fac);

	if (nom_cli=='' || ced_cli=='' ) {
		if (nom_cli=='') {
			document.getElementById('id_clienteprovee_glo').style.background='red';
		} else{
			document.getElementById('id_clienteprovee_glo').style.background='#fff'
		};
		if (ced_cli=='') {
			document.getElementById('id_ruc_ced').style.background='red';
		} else{
			document.getElementById('id_ruc_ced').style.background='#fff'
		};
	} else{    				
		document.getElementById('id_clienteprovee_glo').style.background='#fff'
		document.getElementById('id_ruc_ced').style.background='#fff'
		var cod_usuario = prompt("INGRESE EL CODIGO DE USUARIO", "");
		if (cod_usuario=='') {
			document.getElementById('id_aviso_factura').innerHTML="<p style='font-size:18px;background:red;'>INGESE UN CODIGO</p>"
		} else{
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
				//document.getElementById('id_aviso_factura').innerHTML = xmlhttp.responseText;
				var cad_res= xmlhttp.responseText;
    			var split_cad_res = cad_res.split("|");
    			var idt_user = split_cad_res[0];
    			var loger_us = split_cad_res[1];
    			var clave_us = split_cad_res[2];
    			var ident_us = split_cad_res[3];

    			document.getElementById('id_idt_user').value= idt_user;
    			if (ident_us==1) {
    				//***********************************************************************************************************************************
    				var num_fact_m = document.getElementById('id_num_fact').value;
					if (tipo_doc_fac=='W') {
						if (num_fact_m =='') {
							document.getElementById('id_aviso_factura').innerHTML = '<p style="font-size:18px;text-align:center;background:#red;padding:5px;border-radius:4px;">FALTAN DATOS</p>';
							document.getElementById('id_num_fact').style.background='red';
						} else{
							document.getElementById('id_aviso_factura').innerHTML = '<p style="font-size:18px;text-align:center;background:#db8f5c;padding:5px;border-radius:4px;">'+loger_us +' ESTA <strong>FACTURANDO</strong> ESPERA POR FAVOR </p><img src="img/cargar.gif" alt="" />';
							document.getElementById("id_frm_Factura").submit();
						};
					} else{
						document.getElementById('id_aviso_factura').innerHTML = '<p style="font-size:18px;text-align:center;background:#db8f5c;padding:5px;border-radius:4px;">'+loger_us +' ESTA <strong>FACTURANDO</strong> ESPERA POR FAVOR </p><img src="img/cargar.gif" alt="" />';
						document.getElementById("id_frm_Factura").submit();
					};
    				//document.getElementById('id_aviso_factura').innerHTML = '<p style="font-size:18px;text-align:center;background:#db8f5c;padding:5px;border-radius:4px;">'+loger_us +' ESTA <strong>FACTURANDO</strong> ESPERA POR FAVOR </p><img src="img/cargar.gif" alt="" />';
    				//document.getElementById("id_frm_Factura").submit();
    				//***********************************************************************************************************************************
    			} else{
    				document.getElementById('id_aviso_factura').innerHTML = '<p style="font-size:18px;text-align:center;background:red;padding:5px;border-radius:4px;"> EL USUARIO NO EXISTE VULEVA A INTENTAR ..!</p>';
    			};
			}
			}
			xmlhttp.open("POST","lib/jx_verificar_cod_user.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("cod_usuario="+cod_usuario);
		};		
	};
	
}
function ir_botonera (url_ir) {
	window.location = url_ir ;
}
function gen_guia(idt_factura) {
	document.getElementById('id_cod_num_fact').value= idt_factura;
	document.getElementById('id_div_Conductor_fact').style.display= "block";
}
function enviar_guia () {
	var idtFact = document.getElementById('id_cod_num_fact').value;
	var idtCond = document.getElementById('id_cod_cond_fac').value;
	var DirPar = document.getElementById('id_direc_partida').value; 
	var DirLleg = document.getElementById('id_direc_llegada').value; 
	var fechLleg = document.getElementById('id_fecha_llegada_guia').value; 
	if (idtFact =='' || idtCond=='' || idtCond =='0' || DirPar=='' || DirLleg=='' || fechLleg =='') {
		if (idtFact=='') {
			alert('Error fatal recare la pagina y vulva a intentar si el error persiste comuniquese con el adminitrador del sistema');
		} 
		if (idtCond=='' || idtCond =='0') {
			document.getElementById('id_cod_cond_fac').style.border='solid 1px red';
			document.getElementById('id_nombr_cond_fac').style.border='solid 1px red';
			document.getElementById('id_palca_fact').style.border='solid 1px red';
			document.getElementById('id_descrip_fac').style.border='solid 1px red';
		} else{
			document.getElementById('id_cod_cond_fac').style.border='solid 1px green';
			document.getElementById('id_nombr_cond_fac').style.border='solid 1px green';
			document.getElementById('id_palca_fact').style.border='solid 1px green';
			document.getElementById('id_descrip_fac').style.border='solid 1px green';
		};
		if (DirPar=='') {
			document.getElementById('id_direc_partida').style.border='solid 1px red';
		} else{
			document.getElementById('id_direc_partida').style.border='solid 1px green';
		};
		if (DirLleg=='') {
			document.getElementById('id_direc_llegada').style.border='solid 1px red';
		} else{
			document.getElementById('id_direc_llegada').style.border='solid 1px green';
		};
		if (fechLleg=='') {
			document.getElementById('id_fecha_llegada_guia').style.border='solid 1px red';
		} else{
			document.getElementById('id_fecha_llegada_guia').style.border='solid 1px green';
		};
		
	} else{
		document.getElementById('id_cod_cond_fac').style.border='solid 1px green';
		document.getElementById('id_direc_partida').style.border='solid 1px green';
		document.getElementById('id_direc_llegada').style.border='solid 1px green';
		document.getElementById('id_fecha_llegada_guia').style.border='solid 1px green';
		document.getElementById('id_nombr_cond_fac').style.border='solid 1px green';
		document.getElementById('id_palca_fact').style.border='solid 1px green';
		document.getElementById('id_descrip_fac').style.border='solid 1px green';
		var cod_usuario = prompt("INGRESE EL CODIGO DE USUARIO", "");
		if (cod_usuario=='') {
			document.getElementById('id_resGuiasDeFact').innerHTML = '<p style="font-size:18px;text-align:center;background:red;padding:5px;border-radius:4px;">INGRESE UN CODIGO</p><img src="img/cargar.gif" alt="" />';
		} else{
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
				//document.getElementById('id_aviso_factura').innerHTML = xmlhttp.responseText;
				var cad_res= xmlhttp.responseText;
    			var split_cad_res = cad_res.split("|");
    			var idt_user = split_cad_res[0];
    			var loger_us = split_cad_res[1];
    			var clave_us = split_cad_res[2];
    			var ident_us = split_cad_res[3];
    			if (ident_us==1) {
    				//***********************************************************************************************************************************
    				document.getElementById('id_resGuiasDeFact').innerHTML = '<p style="font-size:18px;text-align:center;background:#db8f5c;padding:5px;border-radius:4px;">'+loger_us +' ESTA <strong>FACTURANDO</strong> ESPERA POR FAVOR </p><img src="img/cargar.gif" alt="" />';
    				window.location= "lib/new_guiaDeFactura_xml.php?idtFact="+idtFact+"&idtCond="+idtCond+"&DirPar="+DirPar+"&DirLleg="+DirLleg+"&fehLleg="+fechLleg+"&ident_us="+ident_us;					
    				//***********************************************************************************************************************************
    			} else{
    				document.getElementById('id_resGuiasDeFact').innerHTML = '<p style="font-size:18px;text-align:center;background:red;padding:5px;border-radius:4px;"> EL USUARIO NO EXISTE VULEVA A INTENTAR ..!</p>';
    			};
			}
			}
			xmlhttp.open("POST","lib/jx_verificar_cod_user.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("cod_usuario="+cod_usuario);
		};
	};
}