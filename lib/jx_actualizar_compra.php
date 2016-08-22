<?php 
session_start();
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])){
include("phpconexcion.php");
$enlace = conectar_buscadores();

$num_factu =$_POST['num_factu'];
$fech_comp =$_POST['fech_comp'];
$num_auuto= $_POST['num_auuto'];
$idt_compr =$_POST['idt_compr'];
$id_clp_pr= $_POST['id_clp_pr'];

$subt_comp = $_POST['subt_comp'];
$base0_comp = $_POST['base0_comp'];
$base12_comp = $_POST['base12_comp'];
$iva_comp = $_POST['iva_comp'];
$total_comp = $_POST['total_comp'];

$tipo_comprob = $_POST['tipo_comprob'];

//echo $fech_comp;
$update_compra = "CALL SP_ACTUALIZAR_COMP('".$num_factu ."', '".$fech_comp."', '".$num_auuto."', ".$idt_compr .", 
".$id_clp_pr.", ".$subt_comp .", ".$base0_comp .", ".$base12_comp.", ".$iva_comp.",
".$total_comp .", ".$_SESSION['empresa']." , ".$_SESSION['id_user'].", '".$tipo_comprob ."')";
$ejec_update_compra = mysql_query($update_compra);
//echo $update_compra;
//mysql_close($enlace);
$res_cambio = mysql_fetch_row($ejec_update_compra);
$res = $res_cambio[0];
//echo "<br>".$res;

// 1 actualiza valores y numero de factura  2 actualiza sin numero de factura  y proveedor  0  ya existe una compra con ese numero de ese proveedor

if ($res==1) {
	$msn ='<span style="font-size:16px;background:green;padding:5px;"> ACTUALIZACION  1..OK..! </span>';
} elseif($res==2){
	$msn ='<span style="font-size:16px;background:green;padding:5px;"> ACTUALIZACION  2..OK..! </span>';
} elseif($res==0){
	$msn ='<span style="font-size:16px;background:red;padding:5px;"> EL COMPROBANTE NO SE HA ACTUALIZADO ..! </span>';
}
echo $msn;

}else{
	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}