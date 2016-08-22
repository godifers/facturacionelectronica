<?php 
session_start();
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
	require_once('phpconex.php');
	$enlace = conectarbd();
	$idt_comprobante = $_POST['idt_comprob'];
	//$up_elimin_comp ="UPDATE t_comprobante SET COM_ESTADO_SIS = 0  WHERE IDT_COMPROBANTE=".$idt_comprobante;
	$up_elimin_comp = "CALL SP_DELETE_COMPROBAN(".$idt_comprobante." , ".$_SESSION['empresa']." , ".$_SESSION['empresa'].", ".$_SESSION['id_user'].", 0)";
	//echo $up_elimin_comp;
	$ejc_elimi_compr = mysql_query($up_elimin_comp);
	mysql_close($enlace);
	echo "<h4 style='background:green;'>OK.. Comprobante eliminado scon exito..!</h4>";
}else{
echo "<script>
      alert('USTED NO HA INICIADO SESION');
      window.location='index.php';
    </script>";
}
?>