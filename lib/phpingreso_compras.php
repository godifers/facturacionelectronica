<?php 
session_start();
if ( isset($_SESSION['empresa'])  and isset($_SESSION['id_user'])) {
  require_once('phpconex.php');
  $enlace = conectarbd();
  $c_identificador =$_POST['c_ingreso']; //identificador de transacciones  factura, nota de venta , gia
  $c_formapago =$_POST['c_formapago'];
  $c_fechcompra =$_POST['c_fechcompra'];
  $c_plazo =$_POST['c_plazo'];
  $c_fechpago =$_POST['c_fechpago'];
  $c_datosprov =$_POST['c_datosprov'];
  $c_ruc_ced =$_POST['c_ruc_ced'];
  $c_id_prov_cli =$_POST['c_id_prov_cli'];
  $c_numserie =$_POST['c_numserie'];
  $c_numserie2 =$_POST['c_numserie2'];
  $c_num =$_POST['c_num'];
  $c_autorizacion =$_POST['c_autorizacion'];
  $c_contribuyente =$_POST['c_contribuyente'];
  $c_obervacion =$_POST['c_obervacion'];
  $c_sustributario =$_POST['c_sustributario'];
  $c_parterel =$_POST['c_parterel'];
  $c_subt= $_POST['c_subt_inv'];
  $c_base12= $_POST['c_base12_inv'];
  $c_base0= $_POST['c_base0_inv'];
  $c_iva= $_POST['c_iva_inv'];
  $c_tot= $_POST['c_tot_inv'];
  $c_ident_escondido =$_POST['c_identificador']; // C factira de inventario =C//D factura de gasto= D

  $user =$_SESSION['id_user'];
  $emp =$_SESSION['empresa'];
  $off = $_SESSION['empresa'];

  $numfacturacomp =$c_numserie.$c_numserie2.$c_num;
  //echo $numfacturacomp;
  $newfechapag = date('Y/m/d', strtotime(str_replace('/', '-', $c_fechpago)));
  //echo $newfechapag;

  $enlace = conectarbd();     
  $cad_verificadora ="SELECT * FROM t_comprobante  WHERE  COM_ESTADO_SIS=1  AND  COM_FKID_CLI_PROV = ".$c_id_prov_cli." AND COM_TIPO_COMPR = '".$c_ident_escondido."' 
  AND COM_NUM_COMPROB=  '".$numfacturacomp."' ";
  //echo $cad_verificadora;
  //echo $cad_verificadora;
  $ejc_cad_verifica = mysql_query($cad_verificadora);
  mysql_close($enlace);

  if (mysql_num_rows($ejc_cad_verifica)==0) { // en caso de que no exista la factura ya guardada
    # ####################################################################################################################################
    $enlace = conectarbd();
    $cad_functioncompras ="CALL bd_facelectronica.SP_GUARDAR_COMPRAS('".$numfacturacomp."',  ".$c_subt.",  ".$c_base0.",  ".$c_base12.",  
    ".$c_iva.", ".$c_tot.",  '".$c_parterel."',  '".$c_sustributario."', ".$c_formapago.", '".$c_autorizacion."',".$c_id_prov_cli.",".$user.", 
    '".$c_fechcompra."',  '".$newfechapag."',  ".$c_plazo.", ".$emp ." , ".$off.", '".$c_obervacion."',".$c_identificador.",'".$c_ident_escondido."')";
    //echo $cad_functioncompras;
    $ejeccadcompras =mysql_query($cad_functioncompras);
    mysql_close($enlace);
    $resnumcomprob = mysql_fetch_row($ejeccadcompras);
    $verficador= $resnumcomprob[0]; // es el id_comrrobante de la ultima fila insertada 
    $identifica= $resnumcomprob[1]; // VALOR DEL COMBOBOX DE TIPO DE DOC QUE REGRESA DEÑ PRPCEDURE 
    $tipo_comprob = $resnumcomprob[2];

    //echo $verficador;
    //echo $identifica;
    //echo $tipo_comprob;

    if ( $c_ident_escondido=='C' ) {
        //if (($verficador >0 and $identifica == 1) or ($verficador >0 and $identifica == 2) or ($verficador >0 and $identifica == 4)){
            //echo "si ingresa detalle";
            if(is_array($_POST['c_cod'])){
                  //echo "sieeeeeeeeee ingresa detalle";
                 while(list($key,$codprod) = each($_POST['c_cod']) and list($key,$cant) = each($_POST['c_cant']) 
                  and list($key,$vcomp) = each($_POST['c_vcompra']) and list($key,$vmin) = each($_POST['c_valmin'])
                  and list($key,$vmen) = each($_POST['c_valmed']) and list($key,$vmax) = each($_POST['c_valmax'])
                  and list($key,$vpvp) = each($_POST['c_valpvp']) and list($key,$vtot) = each($_POST['c_total']) ) 
                  {   
                    $enlace = conectarbd();     
                    $iser_detall ="CALL bd_facelectronica.SP_GUARDAR_PRROD('".$codprod."', ".$cant.", ".$vcomp.", ".$vtot.", '".$tipo_comprob."' ,
                        ".$emp.", ".$off.",".$verficador." , '".$numfacturacomp."',".$vmin.",".$vmen.",".$vmax." , ".$vpvp.",".$c_id_prov_cli." )";
                    //echo $iser_detall.'<br>';
                    $res_inser_serv=mysql_query($iser_detall);
                    mysql_close($enlace);
                  }
            }
       // }
    }elseif ($c_ident_escondido=='D') {
      // ----------------------------------------ingreso de  detalle de gastos--------------------------------------------------
      if (($verficador >0 and $identifica == 1) or ($verficador >0 and $identifica == 2) or ($verficador >0 and $identifica == 4)){
            //echo "si ingresa detalle de gatos";
            if(is_array($_POST['c_descripcion_gast1'])){
                  //echo "sieeeeeeeeee ingresa detalle";
                 while(list($key,$descrop_gas) = each($_POST['c_descripcion_gast1']) and list($key,$cant_gast) = each($_POST['c_cant_gast1']) 
                  and list($key,$valunit_gat) = each($_POST['c_val_unit_gast1']) and list($key,$valtot_gast) = each($_POST['c_val_tota_gast1']) ) 
                  {   
                    $enlace = conectarbd(); 
                    $insert_det_gasto = "INSERT INTO t_detalle_gasto VALUES (NULL, '".strtoupper($descrop_gas)."', ".$cant_gast.", ".$valunit_gat.", 
                      ".$valtot_gast.", 'D', ".$verficador.", '".$numfacturacomp."', ".$c_id_prov_cli.", 1, ".$_SESSION['empresa'].",
                       ".$_SESSION['empresa'].")";
                    //echo $insert_det_gasto.'<br>';
                    $ejec_insert_det_gasto= mysql_query($insert_det_gasto) ;                    
                    mysql_close($enlace);
                  }
            }
      }
      //-----------------------------------------ingreso de asiento--------------------------------------------------------------
      //if (($verficador >0 and $identifica == 1) or ($verficador >0 and $identifica == 2)){
            //echo "si ingresa detalle de gatos";
            if(is_array($_POST['c_cuenta1'])){
                  //echo "sieeeeeeeeee ingresa detalle";
                 while(list($key,$nom_cuneta) = each($_POST['c_cuenta1']) and list($key,$cod_cuenta) = each($_POST['c_condigo_cu1']) 
                  and list($key,$debe) = each($_POST['c_debe_cu1']) and list($key,$haber) = each($_POST['c_haber_cu1']) ) 
                  {   
                    $enlace = conectarbd();     
                    $cad_insert_asiento = "INSERT INTO t_asiento VALUES (NULL, '".$verficador."', '".$cod_cuenta."', ".$debe.", ".$haber.", 1)";
                    //echo $cad_insert_asiento.'<br>';
                    $res_inser_serv=mysql_query($cad_insert_asiento);
                    mysql_close($enlace);
                  }
            }
      //}
    }else if ($c_ident_escondido=='M' and $c_identificador==3 and $verficador >0){
      
            //echo "si ingresa detalle de cota decredtoooooooo";
          if(is_array($_POST['c_num_comp'])) {
             while(list($key,$num_fact) = each($_POST['c_num_comp']) and list($key,$idt_coprob) = each($_POST['c_idt_comp']) 
              and list($key,$estado_clave) = each($_POST['c_estado_nc']) and list($key,$saldo ) = each($_POST['c_vsaldo']) 
              and list($key,$abono_comprob ) = each($_POST['c_vabono'])) 
              {           
                $enlace = conectarbd();
                  if ($estado_clave==1) {
                    //$new_saldo = $saldo - $c_tot;
                    $inser_detalle_pago_fact="CALL SP_GUARDAR_DETALLE_PAGO(".$abono_comprob.", '".$num_fact."',".$idt_coprob.", ".$c_id_prov_cli.",
                    ".$saldo .", 'C',".$_SESSION['empresa'].", ".$_SESSION['empresa']." ,".$_SESSION['id_user'].",".$verficador.",
                    '".$numfacturacomp."','M')";
                    //echo $inser_detalle_pago_fact.'<br>';
                    $res_inser_serv=mysql_query($inser_detalle_pago_fact) or die(mysql_error());
                    mysql_close($enlace);
                  }   
              }      
          }

          if(is_array($_POST['c_cuenta1'])){
                  //echo "sieeeeeeeeee ingresa detalle";
               while(list($key,$nom_cuneta) = each($_POST['c_cuenta1']) and list($key,$cod_cuenta) = each($_POST['c_condigo_cu1']) 
                and list($key,$debe) = each($_POST['c_debe_cu1']) and list($key,$haber) = each($_POST['c_haber_cu1']) ) 
                {   
                  $enlace = conectarbd();     
                  $cad_insert_asiento = "INSERT INTO t_asiento VALUES (NULL, '".$verficador."', '".$cod_cuenta."', ".$debe.", ".$haber.", 1)";
                  //echo $cad_insert_asiento.'<br>';
                  $res_inser_serv=mysql_query($cad_insert_asiento);
                  mysql_close($enlace);
                }
          }

          if (isset($_POST['c_codidet_l_ingre'])) {
              if(is_array($_POST['c_codidet_l_ingre'])) {
                //echo SI ENTRA ;
                 while(list($key,$codprod) = each($_POST['c_codidet_l_ingre']) and list($key,$cant) = each($_POST['c_cant_l_ingre']) 
                  and list($key,$vunit) = each($_POST['c_vuni_l_ingre']) and list($key,$vtot) = each($_POST['c_vtot_l_ingre']) ) 
                {           
                  $enlace = conectarbd();       
                  $iser_detall_venta="CALL SP_GUARDAR_PRROD('".$codprod."', ".$cant.", ".$vunit.", ".$vtot.", 
                                      'M' ,".$_SESSION['empresa'].", ".$_SESSION['empresa'].",".$verficador." , 
                                      '".$numfacturacomp."',0 ,0 ,0 , 0,".$c_id_prov_cli.")";
                  //echo $iser_detall_venta;
                  $res_inser_serv=mysql_query($iser_detall_venta) or die(mysql_error());
                  mysql_close($enlace);
                 }
              }
          }


        
    }
    # ####################################################################################################################################
    echo "<script>alert('DATOS GUARDADOS EXITOSAMENTE..!');window.location='../inicio.php?id=frm_compras.php'</script>";
  } else { // en caso de que la factyra ya esta guardada correctamente---------------------------------------------
     echo "<script>alert('FACTURA INGRESADA ANTERIORMENTE..!');window.location='../inicio.php?id=frm_compras.php'</script>";
  }

}else{
  echo "<script>
      alert('USTED NO HA INICIADO SESION');
      window.location='index.php';
    </script>";
}
?>