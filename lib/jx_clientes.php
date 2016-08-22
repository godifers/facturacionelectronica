<?php 
//session_start();
//if (isset($_SESSION ['nombres']) and isset($_SESSION['user']) and isset($_SESSION['empresa']) and isset($_SESSION['cargo']) and isset($_SESSION['id_user'])) {
include("phpconexcion.php");
//require("phpconexcion.php");
$identificador =$_POST['ident'];
$empresa = $_POST['empres'];
$n=$_POST['q'];
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>jx_clientes.php</title>
</head>
<body>
	<?php 
	$enlace = conectar_buscadores();
	switch ($identificador) {
    case 1: 
    case 4:        
		$cad="SELECT IDT_CLIENT_PROVEE,CP_CEDULA,CP_APELLIDO,CP_NOMBRE,CP_DIRECCION,CP_TELEFONO,CP_CIUDAD,CP_MAIL,CP_ESTADO,
		CP_TIPO_ID,CP_VAL_CREDIT,CP_TIPO_CONTRIB, CP_TIPO_CLI_PROV , CP_PLAZO_PAG		FROM t_client_provee 
			where CP_ESTADO = 1 AND CP_EMPRESA=1 and (CP_CEDULA like '$n%' or CONCAT(CP_NOMBRE ,' ' ,CP_APELLIDO) like '".str_replace(" ","%",strtoupper($n))."%' 
			or CONCAT(CP_APELLIDO ,' ' ,CP_NOMBRE) like '".str_replace(" ","%",strtoupper($n))."%') limit 30";
        break;
    case 2:        
		$cad="SELECT IDT_CLIENT_PROVEE, CP_CEDULA, CP_APELLIDO, CP_NOMBRE, CP_DIRECCION, CP_TELEFONO, CP_CIUDAD, CP_MAIL, CP_ESTADO, 
		CP_TIPO_ID, CP_VAL_CREDIT, CP_TIPO_CONTRIB, CP_TIPO_CLI_PROV , CP_PLAZO_PAG		FROM t_client_provee 
			where CP_EMPRESA=1 and (CP_CEDULA like '$n%' or CONCAT(CP_NOMBRE ,' ' ,CP_APELLIDO) like '".str_replace(" ","%",strtoupper($n))."%' 
			or CONCAT(CP_APELLIDO ,' ' ,CP_NOMBRE) like '%".str_replace(" ","%",strtoupper($n))."%') and CP_ESTADO = 1  and (CP_TIPO_CLI_PROV = 2 or CP_TIPO_CLI_PROV=3) limit 30";
        break;
    case 3:    
		$cad="SELECT IDT_CLIENT_PROVEE,CP_CEDULA,CP_APELLIDO,CP_NOMBRE,CP_DIRECCION,CP_TELEFONO,CP_CIUDAD,CP_MAIL,CP_ESTADO,
		CP_TIPO_ID,CP_VAL_CREDIT,CP_TIPO_CONTRIB, CP_TIPO_CLI_PROV , CP_PLAZO_PAG		FROM t_client_provee 
			where CP_EMPRESA=1 and (CP_CEDULA like '$n%' or CONCAT(CP_NOMBRE ,' ' ,CP_APELLIDO) like '".str_replace(" ","%",strtoupper($n))."%' 
			or CONCAT(CP_APELLIDO ,' ' ,CP_NOMBRE) like '".str_replace(" ","%",strtoupper($n))."%')  limit 30";	
        break;
    case 5: //COBROS
    	$cad="SELECT IDT_CLIENT_PROVEE,CP_CEDULA,CP_APELLIDO,CP_NOMBRE,CP_DIRECCION,CP_TELEFONO,CP_CIUDAD,CP_MAIL,CP_ESTADO,
		CP_TIPO_ID,CP_VAL_CREDIT,CP_TIPO_CONTRIB, CP_TIPO_CLI_PROV , CP_PLAZO_PAG		FROM t_client_provee 
			where CP_EMPRESA=1 and (CP_CEDULA like '$n%' or CONCAT(CP_NOMBRE ,' ' ,CP_APELLIDO) like '".str_replace(" ","%",strtoupper($n))."%' 
			or CONCAT(CP_APELLIDO ,' ' ,CP_NOMBRE) like '".str_replace(" ","%",strtoupper($n))."%') and (CP_TIPO_CLI_PROV = 1 or CP_TIPO_CLI_PROV=2 or CP_TIPO_CLI_PROV=3) limit 30";
		break; 
    case 8:
    	$cad="SELECT IDT_CLIENT_PROVEE,CP_CEDULA,CP_APELLIDO,CP_NOMBRE,CP_DIRECCION,CP_TELEFONO,CP_CIUDAD,CP_MAIL,CP_ESTADO,
		CP_TIPO_ID,CP_VAL_CREDIT,CP_TIPO_CONTRIB, CP_TIPO_CLI_PROV , CP_PLAZO_PAG		FROM t_client_provee 
			where CP_EMPRESA=1 and (CP_CEDULA like '$n%' or CONCAT(CP_NOMBRE ,' ' ,CP_APELLIDO) like '".str_replace(" ","%",strtoupper($n))."%' 
			or CONCAT(CP_APELLIDO ,' ' ,CP_NOMBRE) like '".str_replace(" ","%",strtoupper($n))."%') and CP_ESTADO = 1   and (CP_TIPO_CLI_PROV = 1 or CP_TIPO_CLI_PROV=2 or CP_TIPO_CLI_PROV=3) limit 30";
		break;
    case 6:     
		$cad="SELECT IDT_CLIENT_PROVEE,CP_CEDULA,CP_APELLIDO,CP_NOMBRE,CP_DIRECCION,CP_TELEFONO,CP_CIUDAD,CP_MAIL,CP_ESTADO,
		CP_TIPO_ID,CP_VAL_CREDIT,CP_TIPO_CONTRIB, CP_TIPO_CLI_PROV , CP_PLAZO_PAG		FROM t_client_provee 
			where CP_EMPRESA=1 and (CP_CEDULA like '$n%' or CONCAT(CP_NOMBRE ,' ' ,CP_APELLIDO) like '".str_replace(" ","%",strtoupper($n))."%' 
			or CONCAT(CP_APELLIDO ,' ' ,CP_NOMBRE) like '".str_replace(" ","%",strtoupper($n))."%')  and CP_ESTADO = 1   limit 30";	
        break;
    case 7:     
		$cad="SELECT IDT_CLIENT_PROVEE,CP_CEDULA,CP_APELLIDO,CP_NOMBRE,CP_DIRECCION,CP_TELEFONO,CP_CIUDAD,CP_MAIL,CP_ESTADO,
		CP_TIPO_ID,CP_VAL_CREDIT,CP_TIPO_CONTRIB, CP_TIPO_CLI_PROV , CP_PLAZO_PAG		FROM t_client_provee 
			where CP_EMPRESA=1 and (CP_CEDULA like '$n%' or CONCAT(CP_NOMBRE ,' ' ,CP_APELLIDO) like '".str_replace(" ","%",strtoupper($n))."%' 
			or CONCAT(CP_APELLIDO ,' ' ,CP_NOMBRE) like '".str_replace(" ","%",strtoupper($n))."%') and CP_ESTADO = 1  and CP_TIPO_CLI_PROV > 1 limit 30";
		break;
	}
	$stid = mysql_query($cad);
	//$stid = mysql_query($cad, $conex);
	//mysql_close($enlace);
			
	if (mysql_num_rows($stid)==0) {
		echo "<h4 style='background:red;'>NO SE HA ENCONTRADO RESULTADOS</h4>";
	} else {
	
		echo "<h4>Resultados Encontrados</h4>";
		echo "<table class='cl_tabresultados' style='width:100%;'>";
		while ($rescliente = mysql_fetch_array($stid)) {
			
			$enlace = conectar_buscadores();
			$query_saldoc_li = "SELECT sum(COM_SALDO) from t_comprobante where COM_ESTADO_SIS=1 AND  COM_ESTADO_PAGO=1 and COM_FKID_CLI_PROV=".$rescliente['IDT_CLIENT_PROVEE'] ;

			/*$query_saldoc_li = "SELECT sum(COM_SALDO) from t_comprobante where COM_ESTADO_SIS=1 AND COM_EPRESA = ".$empresa." 
			AND  COM_ESTADO_PAGO=1 and COM_TIPO_COMPR='V' and COM_FKID_CLI_PROV=".$rescliente['IDT_CLIENT_PROVEE'] ;*/
			$ejec_query_Saldo = mysql_query($query_saldoc_li);
			//mysql_close($enlace);
			$respuesta_saldo = mysql_fetch_row($ejec_query_Saldo);
			$sado=$respuesta_saldo[0];
			$cupo=$rescliente['CP_VAL_CREDIT'];
			$new_cupo = $cupo -$sado;
		   ?>
		   <tr class="cl_tr_res">
		   	<td class="cl_td_res">
		   <a href="#" onclick="mostarcliente('<?php echo $rescliente['IDT_CLIENT_PROVEE']; ?>','<?php echo $rescliente['CP_CEDULA']; ?>',
		   	'<?php echo utf8_encode($rescliente['CP_APELLIDO']); ?>','<?php echo utf8_encode($rescliente['CP_NOMBRE']); ?>',
		   	'<?php echo $rescliente['CP_DIRECCION']; ?>','<?php echo $rescliente['CP_TELEFONO']; ?>','<?php echo $rescliente['CP_CIUDAD']; ?>',
		   	'<?php echo $rescliente['CP_MAIL']; ?>','<?php echo $rescliente['CP_ESTADO']; ?>','<?php echo $rescliente['CP_TIPO_ID']; ?>',
		   	'<?php echo $rescliente['CP_VAL_CREDIT']; ?>','<?php echo $rescliente['CP_TIPO_CONTRIB']; ?>','<?php echo $identificador; ?>',
		   	'<?php echo $sado; ?>','<?php echo $new_cupo; ?>','<?php echo $rescliente['CP_TIPO_CLI_PROV']; ?>',
		   	'<?php echo $rescliente['CP_PLAZO_PAG']; ?>');" >
		   	<?php echo  utf8_encode($rescliente['CP_NOMBRE']).' '.utf8_encode($rescliente['CP_APELLIDO']);?>
		   </a>
		   </td>
		   <td>
		   		 <a href="#"><?php echo  $rescliente['CP_CEDULA']; ?>
		   </td>
		   </tr>
		   	
		   <?php 
		}
		echo "</table>";	
	}	           
	/*$cad= 'SELECT idt_clientes, cl_nombres, cl_apellidos, cl_cedula_ruc, cl_direccion, cl_telf from t_clientes 
			where cl_nombres like "%'.strtoupper($n).'%"';*/		
	 ?>
</body>
</html>
