<?php 
require_once('phpconex.php');
$n = $_POST['q'] ;
$i = $_POST['i'];
//echo $i;
switch ($i) {
    case 1:        
		$cadwerw = "CON_ESTADO=1 AND (CON_PLACAS like '".strtoupper($n)."%' or CON_NOMBRE_RZ like '%".strtoupper($n)."%')";
        break;
    case 2:       
		$cadwerw = " (CON_PLACAS like '".strtoupper($n)."%')";
        break;
     case 3:       
		$cadwerw = "CON_ESTADO=1 AND (CON_PLACAS like '".strtoupper($n)."%' or CON_NOMBRE_RZ like '%".strtoupper($n)."%')";
        break;
}

//echo $cadwerw;
/*/IDT_CONDUCTORES, CON_NOMBRE_RZ, CON_ID_RUC, CON_PLACAS, CON_CHASIS, CON_COLOR, CON_MARCA, CON_DESCRIPCION, 
CON_FK_USER, CON_ESTADO,CON_MODELO, IDT_CONDUCTORES, id*/
	$buscarconduct = "SELECT IDT_CONDUCTORES, CON_NOMBRE_RZ, CON_ID_RUC, CON_PLACAS, CON_CHASIS, CON_COLOR, 
	CON_MARCA, CON_DESCRIPCION, CON_FK_USER, CON_ESTADO, CON_MODELO FROM t_conductores where $cadwerw ";
		//echo $buscarconduct;
		$enlace = conectarbd();	
		$res_cad= mysql_query($buscarconduct);
		mysql_close($enlace);

		if(mysql_num_rows($res_cad)==0){
			echo '<h4>No se ha encontrado ningun resultado ..!</h4><hr>';
		}else{
			echo "<table style='width:100%;' border='1' class='cl_tabresultados'>";
			/*echo "<tr><td><p><strong>CONDCUTOR</strong></p></td>
			<td><p><strong>PLACA</strong></p></td>
			<td><p><strong>RUC./ID/CEDULA</strong></p></td></tr>";*/
			while($fila1=mysql_fetch_array($res_cad)) 
			  {
				//idconduc,nombrecond,ruc_cond,placa,color,tipo,marca,descript,identificador,chasis,modelo	  	
			  	?>	
			  	<tr>
			  		<td>
			  			<a href="#" onclick="mostarconductor('<?php echo $fila1['IDT_CONDUCTORES']; ?>','<?php echo $fila1['CON_NOMBRE_RZ']; ?>',
			  				'<?php echo $fila1['CON_ID_RUC']; ?>','<?php echo $fila1['CON_PLACAS']; ?>','<?php echo $fila1['CON_COLOR']; ?>',
			  				'<?php echo $fila1['CON_MARCA']; ?>','<?php echo $fila1['CON_DESCRIPCION']; ?>','<?php echo $i; ?>' ,
			  				'<?php echo $fila1['CON_CHASIS']; ?>','<?php echo $fila1['CON_MODELO']; ?>');" 
			  				style="color:#000;"><?php echo $fila1['CON_NOMBRE_RZ']; ?></a>
			  		</td>
			  		<td><?php echo $fila1['CON_PLACAS']; ?></td>
			  		<td><?php echo $fila1['CON_ID_RUC']; ?></td>
			  	</tr>		  
			  	<?php                
			  }
			echo "</table>";
		}
	
 ?>