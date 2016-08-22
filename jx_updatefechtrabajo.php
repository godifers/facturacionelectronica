<?php 
session_start();
require_once('phpconex.php');

if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {

$c_empambiente = $_POST['c_empambiente'];
$c_empfechtrabajo = $_POST['c_empfechtrabajo'];

//$c_plazo = $POST ['c_adcplazo']
$enlace = conectarbd();

$UPDATEFECHA_TRABAJO = "UPDATE t_empresa set EMP_AMBIENTE='".$c_empambiente."', EMP_FECHA_TRABAJO='".$c_empfechtrabajo."' WHERE IDT_EMPRESA=".$_SESSION['empresa'];

$cadcall=mysql_query($UPDATEFECHA_TRABAJO);
echo $UPDATEFECHA_TRABAJO;
mysql_close($enlace);
echo "<script>alert('Los datos se guardaron correctamente'); 
	window.location='../inicio.php?id=frm_regempresa.php'; </script>";

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
}

?>