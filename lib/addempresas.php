<?php 
session_start();
require_once('phpconex.php');

if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {

$c_emprazonsoc = $_POST['c_rz'];
$c_empruc = $_POST['c_empruc'];
$c_empdirec = $_POST['c_empdirec'];
$c_emptelf = $_POST['c_emptelf'];
$c_empimpuesto = $_POST['c_empimpuesto'];
$c_empprimerfact = $_POST['c_empprimerfact'];
$c_empfechacrea = $_POST['c_empfechacrea'];
$c_empcotizacion = $_POST['c_empcotizacion'];
$c_empvalmin = $_POST['c_empvalmin'];
$c_empitems = $_POST['c_empitems'];
$c_empnombre = $_POST['c_empnombre'];
$c_empcodigo = $_POST['c_empcodigo'];
$c_empestado = 1;
$c_empambiente = 2;
$c_empfechtrabajo = '';
$c_regempser1 = $_POST['c_regempser1'];
$c_regempser2 = $_POST['c_regempser2'];
$c_regempinifact = $_POST['c_regempinifact'];
$c_regempinreten = $_POST['c_regempinreten'];
$c_regempnumcontrib = $_POST['c_regempnumcontrib'];
$c_regempoblcont = $_POST['c_regempoblcont'];
$c_regempncventas = $_POST['c_regempncventas'];
$c_regempgias = $_POST['c_regempgias'];
$c_regempdirlocal = $_POST['c_regempdirlocal'];
$c_regempcobrofact = $_POST['c_regempcobrofact'];
$c_regempcomp = $_POST['c_regempcomp'];
$c_regempnotacont = $_POST['c_regempnotacont'];
$c_regempingreso = $_POST['c_regempingreso'];
$c_regempegreso = $_POST['c_regempegreso'];
$c_regempinil = $_POST['c_regempinil'];
$c_regempcambinve = $_POST['c_regempcambinve'];
$c_identificador =$_POST['c_idt_empr'];
//$c_plazo = $POST ['c_adcplazo']
$enlace = conectarbd();
$F_REGISTROEMPRESA = "SELECT F_REGISTROEMPRESA('".$c_emprazonsoc."', '".$c_empruc."', '".$c_empdirec."', 
	'".$c_emptelf."', ".$c_empimpuesto.", '".$c_empprimerfact."', '".$c_empfechacrea."', ".$c_empcotizacion.", ".$c_empitems.", 
	".$c_empvalmin.", '".$c_empnombre."', ".$c_empcodigo.", ".$c_empestado.",".$c_empambiente.",
	'".$c_regempser1."','".$c_regempser2."','".$c_regempinifact."','".$c_regempinreten."',".$c_regempnumcontrib.",
	'".$c_regempoblcont."','".$c_regempncventas."','".$c_regempgias."','".$c_regempdirlocal."','".$c_regempcobrofact."',
	'".$c_regempcomp."', '".$c_regempnotacont."','".$c_regempingreso."', '".$c_regempegreso."','".$c_regempinil."',
	'".$c_regempcambinve."',".$c_identificador.")";
$cadcall=mysql_query($F_REGISTROEMPRESA);
//echo $F_REGISTROEMPRESA;
mysql_close($enlace);
$result_query_emp = mysql_fetch_row($cadcall);
$ident = $result_query_emp[0];

if ($ident==1) {
	$msn='EMPRESA CREADA';
} else if ($ident==2){
	$msn='DATOS ACTUALIZADOS';
}else{
	$msn = 'HA TENIDO UN ERROR';
}


echo "<script>alert('".$msn."'); 
	window.location='../inicio.php?id=frm_regempresa.php'; </script>";

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
}

?>