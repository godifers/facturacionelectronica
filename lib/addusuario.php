<?php 
session_start();
require_once('phpconexcion.php');
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {

	$c_aduslogin =$_POST['c_aduslogin'];
	$c_adusnombre =$_POST['c_adusnombre'];
	$c_adusapellido =$_POST['c_adusapellido'];
	$c_aduspass =$_POST['c_aduspass'];
	$c_adusconfirmepass =$_POST['c_adusconfirmepass'];
	$c_adusempresa =$_POST['c_adusempresa'];
	$c_adusestado =$_POST['c_adusestado'];
	$c_aduscargo =$_POST['c_aduscargo'];

	$enlace = conectarbd();
	$call_F_GUARDARUSUARIO = "select bd_facelectronica.F_GUARDARUSUARIO('".$c_adusnombre."', '".$c_adusapellido."', '".$c_aduslogin."', '".$c_aduspass."', '".$c_adusconfirmepass."', ".$c_aduscargo.", ".$c_adusestado.", ".$c_adusempresa.")";

	echo $call_F_GUARDARUSUARIO;

	$cadcall=mysql_query($call_F_GUARDARUSUARIO);
	mysql_close($enlace);
	echo "<script>alert('Los datos se guardaron correctamente'); 
	window.location='../inicio.php?id=frm_usuario.php'; </script>";

}else{
	echo "<script>
			alert('USTED NO HA INICIADO SESION');
			window.location='index.php';
		</script>";
}

?>