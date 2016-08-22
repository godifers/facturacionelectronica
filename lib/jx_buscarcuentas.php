<?php 
//session_start();
include("phpconexcion.php");
$n=$_POST['q'];
$identificador =$_POST['ident'];
$n=strtoupper($n);

$enlace = conectar_buscadores();
if ($identificador == 5 OR $identificador == 6 ) {
	$consultcuentas="SELECT * FROM t_plancuentas where PCU_DESCRIPCION 
	like '%".str_replace(" ", "%", $n)."%' OR PCU_CUENTA like '%".str_replace(" ", "%", $n)."%' limit 30";
} else {
	$consultcuentas="SELECT * FROM t_plancuentas where PCU_MOVIMIENTO= 1 and PCU_DESCRIPCION 
	like '%".str_replace(" ", "%", $n)."%' OR PCU_CUENTA like '%".str_replace(" ", "%", $n)."%' limit 30";
}


//echo $consultcuentas;
$resconsulta=mysql_query($consultcuentas);
//mysql_close($enlace);

echo "<h4>Resultados Encontrados</h4>";
echo "<table class='cl_tabresultados' style='width:100%;'>";
	while ($rescuenta = mysql_fetch_array($resconsulta)) {
		$cad_saldo1  = "SELECT BAL_SALDO, IDT_BALANCE FROM t_balance where BAL_CUENTA='".$rescuenta['PCU_CUENTA']."' and BAL_ESTADO= 1 and BAL_EMPRESA= 1 
		order by BAL_EMPRESA asc";
		$ejec_Cad_Saldo1 = mysql_query($cad_saldo1);
		$res_saldo1 = mysql_fetch_row($ejec_Cad_Saldo1);
		$saldo1 = $res_saldo1['0'];
		$idt_saldo1 = $res_saldo1['1'];
		//echo $cad_saldo1;

		$cad_saldo2  = "SELECT BAL_SALDO, IDT_BALANCE FROM t_balance where BAL_CUENTA='".$rescuenta['PCU_CUENTA']."' and BAL_ESTADO= 1 and BAL_EMPRESA= 2 
		order by BAL_EMPRESA asc";
		$ejec_Cad_Saldo2 = mysql_query($cad_saldo2);
		$res_saldo2 = mysql_fetch_row($ejec_Cad_Saldo2);
		$saldo2 = $res_saldo2['0'];
		$idt_saldo2 = $res_saldo2['1'];		
		//echo $cad_saldo2;

	  ?>
	   <tr class="cl_tr_res">
		   	<td class="cl_td_res">
			   <a href="#" onclick="mostrarcuenta('<?php echo $rescuenta['IDT_PLANCUENTAS']; ?>','<?php echo $rescuenta['PCU_CUENTA']; ?>',
			   	'<?php echo $rescuenta['PCU_CUENTA_PADRE']; ?>','<?php echo $rescuenta['PCU_DESCRIPCION']; ?>',
			   	'<?php echo $rescuenta['PCU_ESTADO']; ?>','<?php echo $rescuenta['PCU_MOVIMIENTO']; ?>','<?php echo $rescuenta['PCU_FK_USER']; ?>',
			   	'<?php echo $rescuenta['PCU_FECHA']; ?>','<?php echo $rescuenta['PCU_EMPRESA']; ?>','<?php echo $rescuenta['PCU_OFFI']; ?>',
			   	'<?php echo $identificador; ?>','<?php echo $saldo1; ?>','<?php echo $idt_saldo1; ?>',
			   	'<?php echo $saldo2; ?>','<?php echo $idt_saldo2; ?>');" >
			   	 <?php echo  utf8_encode($rescuenta['PCU_CUENTA']);?>
			   </a>
		   </td>	   
		   <td>
			   	<a href="#" onclick="mostrarcuenta('<?php echo $rescuenta['IDT_PLANCUENTAS']; ?>','<?php echo $rescuenta['PCU_CUENTA']; ?>',
			   	'<?php echo $rescuenta['PCU_CUENTA_PADRE']; ?>','<?php echo $rescuenta['PCU_DESCRIPCION']; ?>',
			   	'<?php echo $rescuenta['PCU_ESTADO']; ?>','<?php echo $rescuenta['PCU_MOVIMIENTO']; ?>','<?php echo $rescuenta['PCU_FK_USER']; ?>',
			   	'<?php echo $rescuenta['PCU_FECHA']; ?>','<?php echo $rescuenta['PCU_EMPRESA']; ?>','<?php echo $rescuenta['PCU_OFFI']; ?>',
			   	'<?php echo $identificador; ?>','<?php echo $saldo1; ?>','<?php echo $idt_saldo1; ?>',
			   	'<?php echo $saldo2; ?>','<?php echo $idt_saldo2; ?>');" >
			   	 <?php echo  utf8_encode($rescuenta['PCU_DESCRIPCION']);?>
			   </a>
		   </td>
	   </tr>	   	
	   <?php 
	}
echo "</table>";
?>