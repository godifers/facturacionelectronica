<?php 
session_start();
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])){
include("phpconex.php");
$enlace = conectarbd();
$idt_comp =$_POST['idt_comp'];
$num_compr =$_POST['num_compr'];
$tipocomp= $_POST['tipocomp'];
$identificador = $_POST['identificador'];


$query_cambiar_compr = "CALL SP_CAMBIAR_COPROBANTE(".$idt_comp.", '".$num_compr."' , ".$_SESSION['empresa']." , '".$tipocomp."',".$identificador.",
						".$_SESSION['id_user'].")";
$ejec_query_cambiar = mysql_query($query_cambiar_compr);
//echo $query_cambiar_compr;
mysql_close($enlace);
$res_cambio = mysql_fetch_row($ejec_query_cambiar);
$res = $res_cambio[0];
//echo "<br>".$res;
if ($res==1) {
	$msn ='<span style="font-size:16px;background:green;"> FACTURA A CEDITO ..OK..! </span>';
} elseif($res==2) {
	$msn ='<span style="font-size:16px;background:green;"> COMPRA A CEDITO ..OK..! </span>';
} elseif($res==3){
	$msn ='<span style="font-size:16px;background:green;"> COMPRA A EFECTIVO ..OK..! </span>';
} elseif($res==0){
	$msn ='<span style="font-size:16px;background:red;"> HA TENIDO UN ERROR..! </span>';
}
echo $msn;

}else{
	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}