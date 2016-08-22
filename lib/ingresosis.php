<?php 
session_start(); 
include('phpconex.php');
$c_usuario=$_POST['c_user'];
$c_password=$_POST['c_pass'];
$c_empresa=$_POST['c_empresa'];
$enlace = conectarbd();
$cadconsulta="SELECT USU_NOMBRE, USU_APELLIDO, USU_LOGER, USU_EMPRESA, USU_CARGO, IDT_USUARIO , EMP_NOMBRE, EMP_IMPUESTO FROM t_usuario , t_empresa
WHERE IDT_EMPRESA = USU_EMPRESA  and  USU_LOGER = '".$c_usuario."' and USU_PASSWORD = '".$c_password."' and USU_EMPRESA = '".$c_empresa."'";
$ejecad=mysql_query($cadconsulta);
mysql_close($enlace);

if (mysql_num_rows($ejecad)==0) {
	echo "<script>
		alert('USUARIO NO ENCONTRADO');
		window.location='../index.php';
	</script>";

}else if (mysql_num_rows($ejecad)==1) {
	$resultuser=mysql_fetch_row($ejecad);
	$_SESSION['nombres']= $resultuser[0]." ".$resultuser[1];
	$_SESSION['user']=$resultuser[2];
	$_SESSION['empresa']=$resultuser[3];
	$_SESSION['cargo']=$resultuser[4];
	$_SESSION['id_user']= $resultuser[5];
	$_SESSION['nom_emp']= $resultuser[6];
	$_SESSION['porcenIVA']= $resultuser[7];

	echo "<script>
		alert('BIENVENIDO');
		window.location='../inicio.php';
	</script>";	
}

 ?>