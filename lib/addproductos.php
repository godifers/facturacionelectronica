<?php 
session_start();
require_once('phpconex.php');
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {

$c_regpcod=$_POST['c_regpcod'];
$c_regpcodbarras=$_POST['c_regpcodbarras'];
$c_regpdetalle=$_POST['c_regpdetalle'];
$c_regppresent=$_POST['c_regppresent'];
$c_regpestado=$_POST['c_regpestado'];
$c_regpgrupo=$_POST['c_regpgrupo'];
$c_regpimp=$_POST['c_regpimp'];
$c_regpprovee=$_POST['c_regpprovee'];
$c_regpvmin=$_POST['c_regpvmin'];
$c_regpvmed=$_POST['c_regpvmed'];
$c_regpvmax=$_POST['c_regpvmax'];
$c_regppvp=$_POST['c_regppvp'];
$c_ident=$_POST['c_regpident'];
$stockini=0;

//$c_plazo = $POST ['c_adcplazo']

if (($c_ident == 0  and $_SESSION['empresa']==2)) {
	echo "<script>alert('Usted no puede crear un producto ..solicite a la matriz ..!')</script>";
} else {
	$enlace = conectarbd();
	$call_SP_GUARDARPROD = "CALL SP_GUARDARPRODUCT_EN_INV('".$c_regpcod."', '".$c_regpdetalle."', '".$c_regppresent."', 
	'".$c_regpimp."', '".$c_regpestado."', '".$c_regpgrupo."', ".$stockini.", 0.00, '".$c_regpvmin."', '".$c_regpvmed."', '".$c_regpvmax."', 
	'".$c_regppvp."', ".$_SESSION['empresa'].", ".$_SESSION['empresa'].",'".$c_regpcodbarras."', ".$c_regpprovee.",".$c_ident.")";
	//echo $call_SP_GUARDARPROD;
	$cadcall=mysql_query($call_SP_GUARDARPROD);
	mysql_close($enlace);
}

$res_crear_prod = mysql_fetch_row($cadcall);
$resulta_verificed = $res_crear_prod[0];

if ($resulta_verificed ==1) {
	$msn="EL PRODCUTO DE HA GENERADO EN TODAS LAS EMPRESAS";
} else if ($resulta_verificed ==2) {
	$msn="EL PRODCUTO SE HA  ACTUALIZADO CON EXTITO ";
}else{
	$msn="HA OCURRIDO UN ERROR";
}

echo "<script>alert('".$msn."'); 
	window.location='../inicio.php?id=frm_productos.php'; </script>";

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
}
?>