<?php 
require_once('phpconex.php');
$n = $_POST['q'] ;
	
	//IDT_CONDUCTORES, CON_NOMBRE_RZ, CON_ID_RUC, CON_PLACAS, CON_CHASIS, CON_COLOR, CON_TIPO_VEHI, CON_MODELO, 
	//CON_FK_USER, CON_ESTADO, IDT_CONDUCTORES, id
	$buscarconduct = "SELECT IDT_CONDUCTORES, CON_NOMBRE_RZ, CON_ID_RUC, CON_PLACAS,CON_CHASIS ,CON_COLOR, 
	CON_MARCA, CON_DESCRIPCION, CON_FK_USER, CON_ESTADO FROM t_conductores ORDER BY IDT_CONDUCTORES DESC";
		//echo $buscarconduct;
		$enlace = conectarbd();			
		$res_cad= mysql_query($buscarconduct);
		mysql_close($enlace);		
		if(mysql_num_rows($res_cad)==0){
			echo '<h4>No se ha encontrado ningun resultado ..!</h4><hr>';
		}else{
			echo "<table style='width:100%;'><tr><td colspan='6'><h4>Lista de conductores y vehiculos de la empresa</h4></td></tr>";
			while($fila1=mysql_fetch_array($res_cad)) 
			  {
			  	?>	
			  	<tr>
			  		<td><input type="text" name="" class="cl_txt_vh cl_txt" style="width:350px;" value="<?php echo $fila1['CON_NOMBRE_RZ']; ?>" readonly/></td>
			  		<td><input type="text" name="" class="cl_txt_vh cl_txt" style="width:100px;" value="<?php echo $fila1['CON_ID_RUC']; ?>" readonly/></td>
			  		<td><input type="text" name="" class="cl_txt_vh cl_txt2" value="<?php echo $fila1['CON_PLACAS']; ?>" readonly/></td>
			  		<td><input type="text" name="" class="cl_txt_vh cl_txt2" value="<?php echo $fila1['CON_COLOR']; ?>" readonly/></td>
			  		<td><input type="text" name="" class="cl_txt_vh cl_txt2" value="<?php echo $fila1['CON_MARCA']; ?>" readonly/></td>
			  		<td><input type="text" name="" class="cl_txt_vh cl_txt" style="width:200px;" value="<?php echo $fila1['CON_DESCRIPCION']; ?>" readonly/></td>			 	  
 	             </tr>	
 	             <?php 
 	                    
			  }
			 echo "</table>";
		}
	
 ?>