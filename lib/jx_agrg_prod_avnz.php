<?php 
session_start();
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])){
include("phpconexcion.php");
$enlace = conectar_buscadores();

$var_prod_l_ingre =$_POST['var_prod_l_ingre'];
$var_codi_l_ingre =$_POST['var_codi_l_ingre'];
$var_cant_l_ingre =$_POST['var_cant_l_ingre'];
$var_valu_l_ingre =$_POST['var_valu_l_ingre'];
$var_valt_l_ingre =$_POST['var_valt_l_ingre'];
$var_id_tip_doc_ed =$_POST['var_id_tip_doc_ed'];
$var_id_num_doc_ed =$_POST['var_id_num_doc_ed'];
$var_id_idt_doc_ed =$_POST['var_id_idt_doc_ed'];


//echo print_r($_POST);
$cad_agregaa_pag = "CALL AGR_PROD_AVNZ('".$var_prod_l_ingre."' , '".$var_codi_l_ingre."' , ".$var_cant_l_ingre." ,
	".$var_valu_l_ingre." , ".$var_valt_l_ingre." ,'".$var_id_tip_doc_ed."' , '".$var_id_num_doc_ed."' ,
	".$var_id_idt_doc_ed." ,".$_SESSION['empresa'].",".$_SESSION['id_user']." )";
$ejec_sp_agreg_pag = mysql_query($cad_agregaa_pag);
echo $cad_agregaa_pag;
$res_sp = mysql_fetch_row($ejec_sp_agreg_pag);
$res = $res_sp['0'];
	if ($res== 1) {
		$msn = '<p style="background:green;">EL PRODUCTO HA INGRESADO INGRESASO CORRECTAMENTE ..!</p>';
	}else if($res == 2){
		$msn = '<p style="background:green;">EL PRODUCTO HA ACYIVADO CORRECTAMENTE ..!</p>';
	}else{
		$msn = '<p style="background:red;">Error ..!</p>';
	}
}else{
	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}