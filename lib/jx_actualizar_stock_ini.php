<?php 
session_start();
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])){
include("phpconex.php");
$enlace = conectarbd();
$new_val =$_POST['new_val'];
$emp =$_POST['emp'];
$cod_prod= $_POST['cod_prod'];


$update_val_ini = "CALL SP_ACTUALIZAR_INV_INI('".$cod_prod."', ".$new_val.",".$_SESSION['empresa']." , ".$_SESSION['id_user'].")";
$ejec_update_ini = mysql_query($update_val_ini);
//echo $update_val_ini;
mysql_close($enlace);
$res_cambio = mysql_fetch_row($ejec_update_ini);
$res = $res_cambio[0];
//echo "<br>".$res;
if ($res==1) {
	$msn ='<span style="font-size:16px;background:green;padding:5px;"> EL VALOR HA SIDO ACTUALIZADO  ..OK..! </span>';
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