<?php 
include("phpconexcion.php");
$enlace = conectar_buscadores();
$ident =$_POST['ident'];
$fecha_bal = $_POST['fecha_bal'];

$gen_balance = "CALL SP_GEN_BALANCE('".$fecha_bal."');";
$ejec_gen_balance = mysql_query($gen_balance);
$re_balance = mysql_fetch_row($ejec_gen_balance);
$res = $re_balance[0];
//echo "<br>".$res;
if ($res==1) {
	$msn ='<span style="font-size:16px;background:green;padding:5px;"> BALANCE GENERADO EXITOSAMENTE  ..OK..! </span>';
} else{
	$msn ='<span style="font-size:16px;background:red;padding:5px;"> HA TENIDO UN ERROR..! </span>';
}
echo $msn;
