<?php 
session_start();
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])){
include("phpconexcion.php");
$enlace = conectar_buscadores();
$tipo_doc_sup =$_POST['tipo_doc_sup'];
$nume_doc_sup =$_POST['nume_doc_sup'];
$idt_doc_sup =$_POST['idt_doc_sup'];
$tipo_doc_hij =$_POST['tipo_doc_hij'];
$nume_doc_hij =$_POST['nume_doc_hij'];
$idt_doc_hij =$_POST['idt_doc_hij'];
$id_fec_doc_af =$_POST['id_fec_doc_af'];
$id_esp_doc_af =$_POST['id_esp_doc_af'];
$id_ess_doc_af =$_POST['id_ess_doc_af'];
$id_subt_doc_af =$_POST['id_subt_doc_af'];
$id_bas0_doc_af =$_POST['id_bas0_doc_af'];
$id_ba12_doc_af =$_POST['id_ba12_doc_af'];
$id_iva_doc_af =$_POST['id_iva_doc_af'];
$id_tota_doc_af =$_POST['id_tota_doc_af'];
$id_sald_doc_af =$_POST['id_sald_doc_af'];
$id_abon_doc_af = $_POST['id_abon_doc_af'];
$val_pago = $_POST['val_pago'];

//echo print_r($_POST);
$cad_agregaa_pag = "CALL SP_AGRG_PAG ('".$tipo_doc_sup."' , '".$nume_doc_sup."' , ".$idt_doc_sup." , '".$tipo_doc_hij."' , '".$nume_doc_hij."' , ".$idt_doc_hij." , '".$id_fec_doc_af."' , ".$id_esp_doc_af." , ".$id_ess_doc_af." , ".$id_subt_doc_af." , ".$id_bas0_doc_af." , ".$id_ba12_doc_af." , ".$id_iva_doc_af."
	, ".$id_tota_doc_af." , ".$id_sald_doc_af." , ".$id_abon_doc_af.",".$val_pago.",".$_SESSION['empresa'].",".$_SESSION['id_user']." )";
$ejec_sp_agreg_pag = mysql_query($cad_agregaa_pag);
//echo $cad_agregaa_pag;
$res_sp = mysql_fetch_row($ejec_sp_agreg_pag);
$res = $res_sp['0'];
	if ($res== 0) {
		$msn = '<p style="background:red;">LA FACTURA YA CONSTA DENTRO DEL PAGO ..!</p>';
	}else if($res == 1){
		$msn = '<p style="background:green;">LA FACTURA SE HA AGREGADO CORECTAMENTE ..!</p>';
	}

}else{
	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}