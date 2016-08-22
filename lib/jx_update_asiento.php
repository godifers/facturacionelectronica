<?php 
session_start();
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])){
include("phpconex.php");
$enlace = conectarbd();

$desc_cuen =$_POST['desc_cuen'];
$idt_asi =$_POST['idt_asi'];
$cod_cu= $_POST['cod_cu'];
$debe_ =$_POST['debe_'];
$haber_= $_POST['haber_'];

$cad_update_aiento = "CALL SP_UPDATE_ASIENTO('".utf8_decode($desc_cuen)."', ".$idt_asi.",'".$cod_cu."', ".$debe_.",".$haber_.", 
	".$_SESSION['empresa']." , ".$_SESSION['id_user'].")";
$ejec_update_asiento = mysql_query($cad_update_aiento);
//echo $cad_update_aiento;
mysql_close($enlace);
$res_cambio = mysql_fetch_row($ejec_update_asiento);
$res = $res_cambio[0];
//echo "<br>".$res;
if ($res==1) {
	$msn ='<span style="font-size:16px;background:green;padding:5px;"> EL ASIENTO SE HA MODIFICADO CORRECTAMENTE  ..OK..! </span>';
} elseif($res==0){
	$msn ='<span style="font-size:16px;background:red;padding:5px;"> HA TENIDO UN ERROR..! </span>';
}
echo $msn;

}else{
	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}