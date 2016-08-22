<?php 
session_start();
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])) {
	require_once('phpconex.php');
	$enlace = conectarbd();
	$fecha_ed = $_POST['fecha_ed'];
	$esta_pag = $_POST['esta_pag'];
	$esta_sis = $_POST['esta_sis'];
	$subt_edi = $_POST['subt_edi'];
	$bas0_edi = $_POST['bas0_edi'];
	$bas12edi = $_POST['bas12edi'];
	$tota_edi = $_POST['tota_edi'];
	$sald_edi = $_POST['sald_edi'];
	$abon_edi = $_POST['abon_edi'];
	$obser_edi = $_POST['obser_edi'];
	$idt_com = $_POST['idt_com'];
	$id_iva_ed = $_POST['id_iva_ed'];

	$cad_edi_evanz = "CALL SP_EDIC_AVNZ('".$fecha_ed."',".$esta_pag.",".$esta_sis.",".$subt_edi.",".$bas0_edi.",".$bas12edi.",".$tota_edi.",
		".$sald_edi.",".$abon_edi.",'".$obser_edi."',".$idt_com.",".$_SESSION['id_user'].",".$id_iva_ed.")";
	//echo $cad_edi_evanz;
	$ejec_sp_ed_avan = mysql_query($cad_edi_evanz);

}else{
echo "<script>
      alert('USTED NO HA INICIADO SESION');
      window.location='index.php';
    </script>";
}
?>