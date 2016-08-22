function editar_Val_ret (numerodeid) {
	//alert('INGRESO A A EDITAR VALORES DE RETENCION');
	document.getElementById('id_codsus_ret'+numerodeid).readOnly = false;
	document.getElementById('id_codisg_ret'+numerodeid).readOnly = false;
	document.getElementById('id_baseim_ret'+numerodeid).readOnly = false;
	document.getElementById('id_porcen_ret'+numerodeid).readOnly = false;
	//document.getElementById('id_valora_ret'+numerodeid).readOnly = false;
	document.getElementById('id_btn_editar'+numerodeid).style.display = 'none';
	document.getElementById('id_btn_guarda'+numerodeid).style.display = 'inline-block';
	document.getElementById('id_btn_cancel'+numerodeid).style.display = 'inline-block';
}
function calcularnuevova_ret (numerodeid) {
	//alert('canbia valores der et');
	var val_baseimp =document.getElementById('id_baseim_ret'+numerodeid).value;
	var val_porcent =document.getElementById('id_porcen_ret'+numerodeid).value;
	if (val_baseimp=='' || val_porcent=='') {
		if (val_baseimp=='') {
			document.getElementById('id_baseim_ret'+numerodeid).style.border='solid 1px red';
		} else{
			document.getElementById('id_baseim_ret'+numerodeid).style.border='solid 1px green';
		};
		if (val_porcent=='') {
			document.getElementById('id_porcen_ret'+numerodeid).style.border='solid 1px red';
		} else{
			document.getElementById('id_porcen_ret'+numerodeid).style.border='solid 1px green';
		};
		document.getElementById('id_valora_ret'+numerodeid).style.border='solid 1px red';
		//document.getElementById('id_valora_ret'+numerodeid).style.background=' #FFA79F';
		document.getElementById('id_valora_ret'+numerodeid).value='';
	} else{
		document.getElementById('id_baseim_ret'+numerodeid).style.border='solid 1px green';
		document.getElementById('id_porcen_ret'+numerodeid).style.border='solid 1px green';
		document.getElementById('id_valora_ret'+numerodeid).style.border='solid 1px green';
		//document.getElementById('id_valora_ret'+numerodeid).style.background='#9FFFAA';
		var var_new_val_ret = parseFloat(parseFloat(val_baseimp) * parseFloat(val_porcent)/100);
		var_new_val_ret =var_new_val_ret.toFixed(2); 
		document.getElementById('id_valora_ret'+numerodeid).value=var_new_val_ret
	};
	
}
function cancelar_edico (numerodeid) {
	
	var var_codsust =document.getElementById('id_codsus_ret'+numerodeid).value;
	var var_cod_ret =document.getElementById('id_codisg_ret'+numerodeid).value;
	var var_baseret =document.getElementById('id_baseim_ret'+numerodeid).value;
	var var_porcret =document.getElementById('id_porcen_ret'+numerodeid).value;
	var var_val_ret =document.getElementById('id_valora_ret'+numerodeid).value;
	var var_hdn_id_cliente_ret = document.getElementById('id_hdn_id_cliente_ret').value;
	var var_hdn_numfactura_ret = document.getElementById('id_hdn_numfactura_ret').value;
	 if (var_codsust=='' || var_cod_ret=='' || var_baseret=='' || var_porcret=='' || var_val_ret=='' || var_hdn_id_cliente_ret=='' || var_hdn_numfactura_ret=='') {
	 	if (var_codsust=='') {
	 		document.getElementById('id_codsus_ret'+numerodeid).style.border='solid 1px red';
	 	} else{
	 		document.getElementById('id_codsus_ret'+numerodeid).style.border='solid 1px green';
	 	};
	 	if (var_cod_ret=='') {
	 		document.getElementById('id_codisg_ret'+numerodeid).style.border='solid 1px red';
	 	} else{
	 		document.getElementById('id_codisg_ret'+numerodeid).style.border='solid 1px green';
	 	};
	 	if (var_baseret=='') {
	 		document.getElementById('id_baseim_ret'+numerodeid).style.border='solid 1px red';
	 	} else{
	 		document.getElementById('id_baseim_ret'+numerodeid).style.border='solid 1px green';
	 	};
	 	if (var_porcret=='') {
	 		document.getElementById('id_porcen_ret'+numerodeid).style.border='solid 1px red';
	 	} else{
	 		document.getElementById('id_porcen_ret'+numerodeid).style.border='solid 1px green';
	 	};
	 	if (var_val_ret=='') {
	 		document.getElementById('id_valora_ret'+numerodeid).style.border='solid 1px red';
	 	} else{
	 		document.getElementById('id_valora_ret'+numerodeid).style.border='solid 1px green';
	 	};
	 	document.getElementById('alerta_ret').value='TENEMOS UN ERROR CON LOS DATOS (FALTA ALGUN DATO)';
	 	document.getElementById('alerta_ret').style.background='RED';
	 } else{
	 	document.getElementById('alerta_ret').value='';
	 	document.getElementById('alerta_ret').style.background='#fff';
	 	document.getElementById('id_codsus_ret'+numerodeid).readOnly = true;
		document.getElementById('id_codisg_ret'+numerodeid).readOnly = true;
		document.getElementById('id_baseim_ret'+numerodeid).readOnly = true;
		document.getElementById('id_porcen_ret'+numerodeid).readOnly = true;
		document.getElementById('id_btn_editar'+numerodeid).style.display = 'inline-block';
		document.getElementById('id_btn_guarda'+numerodeid).style.display = 'none';
		document.getElementById('id_btn_cancel'+numerodeid).style.display = 'none';
		var_baseret=parseFloat(var_baseret).toFixed(2);
	 	var_porcret=parseFloat(var_porcret).toFixed(2);
	 	document.getElementById('id_baseim_ret'+numerodeid).value=var_baseret;	 	
		document.getElementById('id_porcen_ret'+numerodeid).value=var_porcret;
	 };
}
function ocultar_mostar_nuevoval_ret (identificador) {
	if (identificador==0) {
		document.getElementById('id_div_nuevo_valor_ret').style.display='none'
	} else if(identificador==1){
		document.getElementById('id_div_nuevo_valor_ret').style.display='block'
	};	
}
function guarda_val_ret (numerodeid,identificador) {
	var xmlhttp;
	var identific1 = identificador;
	var var_codsust =document.getElementById('id_codsus_ret'+numerodeid).value;
	var var_cod_ret =document.getElementById('id_codisg_ret'+numerodeid).value;
	var var_baseret =document.getElementById('id_baseim_ret'+numerodeid).value;
	var var_porcret =document.getElementById('id_porcen_ret'+numerodeid).value;
	var var_val_ret =document.getElementById('id_valora_ret'+numerodeid).value;
	var var_idt_val_ret = document.getElementById('id_dt_val_retenciones'+numerodeid).value;
	var var_hdn_id_cliente_ret = document.getElementById('id_hdn_id_cliente_ret').value;
	var var_hdn_numfactura_ret = document.getElementById('id_hdn_numfactura_ret').value;
	var var_letra_compr = document.getElementById('id_hdn_letra').value;
	 if (var_codsust=='' || var_cod_ret=='' || var_baseret=='' || var_porcret=='' || var_val_ret=='' || var_hdn_id_cliente_ret=='' || var_hdn_numfactura_ret=='') {
	 	if (var_codsust=='') {
	 		document.getElementById('id_codsus_ret'+numerodeid).style.border='solid 1px red';
	 	} else{
	 		document.getElementById('id_codsus_ret'+numerodeid).style.border='solid 1px green';
	 	};
	 	if (var_cod_ret=='') {
	 		document.getElementById('id_codisg_ret'+numerodeid).style.border='solid 1px red';
	 	} else{
	 		document.getElementById('id_codisg_ret'+numerodeid).style.border='solid 1px green';
	 	};
	 	if (var_baseret=='') {
	 		document.getElementById('id_baseim_ret'+numerodeid).style.border='solid 1px red';
	 	} else{
	 		document.getElementById('id_baseim_ret'+numerodeid).style.border='solid 1px green';
	 	};
	 	if (var_porcret=='') {
	 		document.getElementById('id_porcen_ret'+numerodeid).style.border='solid 1px red';
	 	} else{
	 		document.getElementById('id_porcen_ret'+numerodeid).style.border='solid 1px green';
	 	};
	 	if (var_val_ret=='') {
	 		document.getElementById('id_valora_ret'+numerodeid).style.border='solid 1px red';
	 	} else{
	 		document.getElementById('id_valora_ret'+numerodeid).style.border='solid 1px green';
	 	};
	 	if (var_hdn_id_cliente_ret=='') {
	 		alert('Tenemos un ERROR MUY GRAVE comuniquese con el ADMINITRADOR del sistema');
	 	};
	 	if (var_hdn_numfactura_ret=='') {
	 		alert('Tenemos un ERROR MUY GRAVE comuniquese con el ADMINITRADOR del sistema');
	 	} ;
	 	document.getElementById('alerta_ret').value='TENEMOS UN ERROR CON LOS DATOS (FALTA ALGUN DATO)';
	 	document.getElementById('alerta_ret').style.background='RED';
	 } else{
	 	var_baseret=parseFloat(var_baseret).toFixed(2);
	 	var_porcret=parseFloat(var_porcret).toFixed(2);
	 	document.getElementById('id_baseim_ret'+numerodeid).value=var_baseret;	 	
		document.getElementById('id_porcen_ret'+numerodeid).value=var_porcret;

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
			
		document.getElementById("id_div_res_updateret").innerHTML=xmlhttp.responseText;
		location.reload();
		}
		}
		xmlhttp.open("POST","lib/jx_update_valores_ret.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("id_cli="+var_hdn_id_cliente_ret+
				 "&nunfact="+var_hdn_numfactura_ret+
				 "&idt_val_ret="+var_idt_val_ret+
				 "&codsust="+var_codsust+
				 "&cod_ret="+var_cod_ret+
				 "&baseret="+var_baseret+
				 "&val_ret="+var_val_ret+
				 "&porcret="+var_porcret+
				 "&letra="+var_letra_compr+
				 "&identific="+identific1);
	 };
}
function buscarcuentas2(nomcuenta,ident)
{
var xmlhttp;
var n=nomcuenta;
var identificador=ident;
	if (ident==1) {
		document.getElementById('id_movcodcuenta2').value=''
	};
	if (nomcuenta=='') {
		document.getElementById('id_div_cuentas2').style.display="none";
	}else {
		document.getElementById('id_div_cuentas2').style.display="block";
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
	document.getElementById("id_div_cuentas2").innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","lib/jx_buscarcuentas.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("q="+n+
				"&ident="+identificador);
}
//--------------------------------------------------------------------------------------------------------------------------
//Funcion para GENERAR TABLA DE CUENTAS EN RECIBOS
var array_nom_cuenta2=[];
var array_cod_cuenta2=[];
var array_valor_debe2=[];
var array_valor_haber2=[];
var array_estado_ite2 = [];

function elimiitem_asieto2(item_asi) {
	array_estado_ite2[item_asi]= 0;
	contsruir_asiento2();
}

function generartablacuentas2(){
	var var_genprod = document.getElementById('id_movcuentaingresar2').value;
	var var_gencod = document.getElementById('id_movcodcuenta2').value;
	var var_geningreso = document.getElementById('id_recreciingreso2').value;
	var var_genegreso = document.getElementById('id_recreciegreso2').value;	

	if (var_genprod=='' || var_gencod=='' || var_geningreso=='' || var_genegreso==''){

		if(var_genprod==''){
			document.getElementById('id_movcuentaingresar2').style.border='solid 1px #C92121';
		}else {
			document.getElementById('id_movcuentaingresar2').style.border='solid 1px #0A7823';
		};
		if (var_gencod==''){
			document.getElementById('id_movcodcuenta2').style.border='solid 1px #C92121';
		}else {
			document.getElementById('id_movcodcuenta2').style.border='solid 1px #0A7823';
		};
		if(var_geningreso==''){
			document.getElementById('id_recreciingreso2').style.border='solid 1px #C92121';
		}else{
			document.getElementById('id_recreciingreso2').style.border='solid 1px #0A7823';
		};
		if (var_genegreso==''){
			document.getElementById('id_recreciegreso2').style.border='solid 1px #C92121';
		}else {
			document.getElementById('id_recreciegreso2').style.border='solid 1px #0A7823';
		};
		
	}else{
		array_nom_cuenta2.push(var_genprod);
		array_cod_cuenta2.push(var_gencod);
		array_valor_debe2.push(var_geningreso);	
		array_valor_haber2.push(var_genegreso);	
		array_estado_ite2.push(1);	
		contsruir_asiento2();
	};
}

function contsruir_asiento2() {
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
	for (var i = 0 ; i < array_nom_cuenta2.length; i++) {
		if (array_estado_ite2[i]==1){
			out = out + '<tr>';
			out = out + '<td style="width:60%;"><input type="text" class="cl_txt" name="c_cuenta1[]" value="'+array_nom_cuenta2[i]+'" style="width:100%" readonly/></td>';
			out = out + '<td><input type="text" class="cl_txt" name="c_condigo_cu1[]" value="'+array_cod_cuenta2[i]+'" readonly/></td>';
			out = out + '<td align="right"><input type="number" step="0.01" class="cl_txt2" name="c_debe_cu1[]" value="'+array_valor_debe2[i]+'" required/></td>';
			out = out + '<td align="right"><input type="number" step="0.01" class="cl_txt2" name="c_haber_cu1[]" value="'+array_valor_haber2[i]+'" required/></td>';
			out = out + '<td align="right"><input type="button" value="X" onclick="elimiitem_asieto2('+i+');" style="background:red;"></td>';
			out = out + '</tr>';

			ingreso= parseFloat(ingreso) + parseFloat(array_valor_debe2[i]);
			ingreso= ingreso.toFixed(2)	;
			egreso= parseFloat(egreso) + parseFloat(array_valor_haber2[i]);
			egreso= egreso.toFixed(2)	;
		}
	};
	out=out+'</table>';
	if (ingreso==egreso) {
		document.getElementById('id_btn_guardar_new_asi').style.display='inline-block';
	} else{
		document.getElementById('id_btn_guardar_new_asi').style.display='none';
	};
	document.getElementById('id_total_debe2').value=ingreso;
	document.getElementById('id_total_haber2').value=egreso;
	document.getElementById('id_movcuentaingresar2').value='';
	document.getElementById('id_movcodcuenta2').value='';
	document.getElementById('id_recreciingreso2').value='';
	document.getElementById('id_recreciegreso2').value='';	
	document.getElementById("id_div_asiento2").innerHTML = out;	
}
function actualizar_datos () {
	var fecha_ed = document.getElementById('id_fecha_sis_ed').value;
	var esta_pag = document.getElementById('id_Estado_pag_ed').value;
	var esta_sis = document.getElementById('id_Estado_sis_ed').value;
	var subt_edi = document.getElementById('id_subto_ed').value;
	var bas0_edi = document.getElementById('id_base0_ed').value;
	var bas12edi = document.getElementById('id_bas12_ed').value;
	var tota_edi = document.getElementById('id_total_ed').value;
	var sald_edi = document.getElementById('id_saldo_ed').value;
	var abon_edi = document.getElementById('id_abono_ed').value;
	var obser_edi = document.getElementById('id_observacion_ed').value;
	var idt_com = document.getElementById('id_idt_doc_ed').value;
	var id_iva_ed = document.getElementById('id_iva_ed').value

	if (fecha_ed==''|| esta_pag==''|| esta_sis==''|| subt_edi==''|| bas0_edi==''|| bas12edi==''||tota_edi==''|| sald_edi==''||abon_edi=='' || obser_edi=='' || idt_com=='' || id_iva_ed=='') {
		if (fecha_ed=='') {
			document.getElementById('id_fecha_sis_ed').style.border='solid 1px red';
		}else{
			document.getElementById('id_fecha_sis_ed').style.border='solid 1px green';
		};
		if (esta_pag=='') {
			document.getElementById('id_Estado_pag_ed').style.border='solid 1px red';
		}else{
			document.getElementById('id_Estado_pag_ed').style.border='solid 1px green';
		};
		if (esta_sis=='') {
			document.getElementById('id_Estado_sis_ed').style.border='solid 1px red';
		}else{
			document.getElementById('id_Estado_sis_ed').style.border='solid 1px green';
		};
		if (subt_edi=='') {
			document.getElementById('id_subto_ed').style.border='solid 1px red';
		}else{
			document.getElementById('id_subto_ed').style.border='solid 1px green';
		};
		if (bas0_edi=='') {
			document.getElementById('id_base0_ed').style.border='solid 1px red';
		}else{
			document.getElementById('id_base0_ed').style.border='solid 1px green';
		};
		if (bas12edi=='') {
			document.getElementById('id_bas12_ed').style.border='solid 1px red';
		}else{
			document.getElementById('id_bas12_ed').style.border='solid 1px green';
		};
		if (tota_edi=='') {
			document.getElementById('id_total_ed').style.border='solid 1px red';
		}else{
			document.getElementById('id_total_ed').style.border='solid 1px green';
		};
		if (sald_edi=='') {
			document.getElementById('id_saldo_ed').style.border='solid 1px red';
		}else{
			document.getElementById('id_saldo_ed').style.border='solid 1px green';
		};
		if (abon_edi=='') {
			document.getElementById('id_abono_ed').style.border='solid 1px red';
		}else{
			document.getElementById('id_abono_ed').style.border='solid 1px green';
		};
		if (obser_edi=='') {
			document.getElementById('id_observacion_ed').style.border='solid 1px red';
		}else{
			document.getElementById('id_observacion_ed').style.border='solid 1px green';
		};
		if (id_iva_ed=='') {
			document.getElementById('id_iva_ed').style.border='solid 1px red';
		}else{
			document.getElementById('id_iva_ed').style.border='solid 1px green';
		};
		if (idt_com=='') {
			alert('HAY UN ERROR CON EL DOC.. VUELVA ACARGAR LA PAG.');
		};
	}else{
		document.getElementById('id_fecha_sis_ed').style.border='solid 1px green';
		document.getElementById('id_Estado_pag_ed').style.border='solid 1px green';
		document.getElementById('id_Estado_sis_ed').style.border='solid 1px green';
		document.getElementById('id_subto_ed').style.border='solid 1px green';
		document.getElementById('id_base0_ed').style.border='solid 1px green';
		document.getElementById('id_bas12_ed').style.border='solid 1px green';
		document.getElementById('id_total_ed').style.border='solid 1px green';
		document.getElementById('id_saldo_ed').style.border='solid 1px green';
		document.getElementById('id_abono_ed').style.border='solid 1px green';
		document.getElementById('id_observacion_ed').style.border='solid 1px green';
		document.getElementById('id_iva_ed').style.border='solid 1px green';

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
				location.reload();
			}
		}
		xmlhttp.open("POST","lib/jx_actualizar_Val_comp.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("fecha_ed="+fecha_ed+
					"&esta_pag="+esta_pag+
					"&esta_sis="+esta_sis+
					"&subt_edi="+subt_edi+
					"&bas0_edi="+bas0_edi+
					"&bas12edi="+bas12edi+
					"&tota_edi="+tota_edi+
					"&sald_edi="+sald_edi+
					"&abon_edi="+abon_edi+
					"&obser_edi="+obser_edi+
					"&idt_com="+idt_com+
					"&id_iva_ed="+id_iva_ed);
	};
}