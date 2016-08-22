<?php 
 function conectarbd(){
 	if (!($enlace = mysql_connect("localhost", "root", "Toshiba.-#") or die("No se pudo realizar la conexion"))) {
 		echo "<script>alert('HA OCURRIDO CON EL SERVIDOR');</script>";
 		exit();
 	}
 	if (!mysql_select_db("bd_facelectronica",$enlace)){
 		echo "<script>alert('HA OCURRIDO UN ERROR CON LA BD');</script>";
 		exit();
 	}
 	return $enlace;
 }
 ?>