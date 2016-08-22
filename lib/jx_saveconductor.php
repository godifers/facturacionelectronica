<?php 
session_start();
if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
	require("phpconex.php");
	$identificador =$_POST['identificador_con'] ;
	$conductor =$_POST['conductor_con'] ;
	$ruc_id =$_POST['ruc_id_con'] ;
	$placas =$_POST['placas_con'] ;
	$color =$_POST['color_con'] ;
	$marca =$_POST['marca_con'] ;
	$id_conductor= $_POST['id_idcon']; 
	$descript =$_POST['descript_con'] ;
	$chasis_con = $_POST['chasis_con'];
	$modelo_con = $_POST['modelo_con'];
	//print_r($_POST);
	//echo $identificador;
	//IDT_CONDUCTORES, CON_NOMBRE_RZ, CON_ID_RUC, CON_PLACAS, CON_CHASIS, CON_COLOR, CON_MARCA, CON_DESCRIPCION, CON_FK_USER, CON_ESTADO,CON_MODELO, IDT_CONDUCTORES, id
	switch ($identificador) {
	    case 0:
	    	$enlace = conectarbd();	
	        $cadcerificarplaca ="SELECT * FROM t_conductores WHERE CON_PLACAS='".$placas."'";
			//echo $cadcerificarplaca;
			$ejerverific  = mysql_query($cadcerificarplaca) or die(mysql_error());
			mysql_close($enlace);
			//echo 'FILAS AFECT'.mysql_num_rows($ejerverific);

			if(mysql_num_rows($ejerverific)==0){
				$enlace = conectarbd();	
				$queriinserserv="INSERT INTO t_conductores VALUES(null, '".strtoupper($conductor)."', '".strtoupper($ruc_id)."', '".strtoupper($placas)."',
				 '".strtoupper($chasis_con)."','".strtoupper($color)."','".strtoupper($marca)."', '".strtoupper($descript)."', ".$_SESSION['id_user'].", 1,'".$modelo_con ."')";
				//echo $queriinserserv;
				$ejec_queryisert  = mysql_query($queriinserserv);
				mysql_close($enlace);
			}else{
				?>
				<p style="background:red;">
					LA PLACA <P><?php echo $placas; ?></P>ERROR.. YA ESTA REGISTRADA ANTERIORMENTE , UNICAMENTE PUEDE EDITAR EL CONDUCTOR
				</p>
				<?php 
			}

	        break;
	    case 1:
	    	$enlace = conectarbd();	
	       	$query_update ="UPDATE t_conductores SET  CON_NOMBRE_RZ='".strtoupper($conductor)."',  CON_ID_RUC='".strtoupper($ruc_id)."'
			, CON_COLOR='".strtoupper($color)."', CON_MARCA='".strtoupper($marca)."', CON_DESCRIPCION='".strtoupper($descript)."', CON_FK_USER=".$user."
			, CON_ESTADO=1, CON_MODELO='".$modelo_con."' WHERE IDT_CONDUCTORES=".$id_conductor;
			//echo $query_update;
			$ejec_queryisert  = mysql_query($query_update);
			mysql_close($enlace);
	        break;
	}


}else{
	echo "<script>
				alert('USTED NO HA INICIADO SESION');
				window.location='../index.php';
			</script>";

}
 ?>