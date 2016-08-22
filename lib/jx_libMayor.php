<?php 
include("phpconexcion.php");
$enlace = conectar_buscadores();
$fecha = $_POST['fecha'];
$ejecSPMayor = "call SP_LIBMAYOR('".$fecha."')";
//echo $ejecSPMayor;
$ejeCadena = mysql_query($ejecSPMayor);
set_time_limit(0);
echo '<p> LIBRO GENERADO CORRENTAMENET</p>';

?>