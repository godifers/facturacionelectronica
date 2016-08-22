<?php 
 function conectar_buscadores(){
 	$conex = mysql_connect("localhost", "root", "Toshiba.-#")
		or die("No se pudo realizar la conexion");
		mysql_select_db("bd_facelectronica",$conex)
		;
 }
 ?>