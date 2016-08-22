<?php 
session_start();
if (isset($_SESSION['empresa'])){
include("phpconexcion.php");
$enlace = conectar_buscadores();
$PCU_DESCRIPCION =$_POST['PCU_DESCRIPCION'];
$IDT_DETALLE_PERFIL =$_POST['IDT_DETALLE_PERFIL'];
$PCU_CUENTA =$_POST['PCU_CUENTA'];
$DETP_TIPO =$_POST['DETP_TIPO'];
$DETP_PORCENTAJE =$_POST['DETP_PORCENTAJE'];
$cadSPActCuentDetPERf = "CALL SP_UPDATE_CUENTA_DET_PERF('".$PCU_DESCRIPCION."',".$IDT_DETALLE_PERFIL.",'".$PCU_CUENTA."',
	'".$DETP_TIPO."', ".$DETP_PORCENTAJE.");";
$ejecCacUpdate  = mysql_query($cadSPActCuentDetPERf);
$respEjeSP = mysql_fetch_row($ejecCacUpdate);
$res = $respEjeSP['0'];
if ($res == 1) {
	$msn = "<p style='font-size:20px;background:green;text-align:center;'>Cambio correcto</p>";
} else {
	$msn = "<p style='font-size:20px;background:green;text-align:center;'>Error grave</p>";
}
echo $msn;
}else{
	echo "INGRESE COMO ADMINISTRADOR";
}