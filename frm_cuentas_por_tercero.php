<?php 
	if ($_SESSION['cargo']==2) {
		include("lib/phpconexcion.php");
		$enlace = conectar_buscadores();
		?>
		
		
		<?php 
	}else{
		?>
		<div class="" style="width:550px;height:550px;margin: 0 auto ;background:none;text-align:center;">
			<p>USTED NO PUEDE INGRESAR A ESTE MODULO ..(NO ESTA ASIGANDO CON PRIVILEGIOS)</p>
			<img src="img/error.png" alt="" style="width:520x;">
		</div>
		<?php
	}	
?>