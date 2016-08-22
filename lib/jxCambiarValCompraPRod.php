<?php 
	include("phpconexcion.php");

	$idProd=$_POST['idProd'];
	$valCom=$_POST['valCom'];

 	$enlace = conectar_buscadores();
 	$cosultaActu="UPDATE t_prodcutos set PR_VAL_COMPRA= ".$valCom." where PR_COD_PROD ='".$idProd."' "; 
	//echo $cosultaActu;
	$eje_SP=mysql_query($cosultaActu);	

	
	$msn = "<p style='width:100%;font-size:20px;text-align:center;background:green;'>CAOMBIA CORRECTO OK </p>";	
	echo $msn;

?>
