<?php 
require_once('phpconex.php');
$emp=$_POST['q'];
$enlace = conectarbd();		
$cad_fach_tra = "SELECT EMP_FECHA_TRABAJO from t_empresa where IDT_EMPRESA=".$emp;
$ejec_emp = mysql_query($cad_fach_tra);
mysql_close($enlace);
$res_fecha_trab = mysql_fetch_row($ejec_emp);
$fecha = $res_fecha_trab[0];
echo "<p style='margin:10px 0 1px 0;font-size:14px;'>FECHA DE TRABAJO : </p><h1 style='display:inline-block;margin:0;'>".$fecha."</h1>";
 ?>