<?php 
session_start();
if (isset($_SESSION['empresa']) and isset($_SESSION['id_user'])){
include("phpconexcion.php");
$enlace = conectar_buscadores();
$idt_comp =$_POST['idt_comp'];
$tipo_comp =$_POST['tipo_comp'];
if ($tipo_comp=='B') {
	?>
	<table  class='cl_tabresultados' style='width:100%;'>
		<?php 
		$caddetpag = "SELECT * FROM t_pagos_factu_comp where PAG_FK_ID_COM_PAGO= ".$idt_comp." and PAG_TIPO_COMP_PAGO='".$tipo_comp."'";
		$ejec_cadpag = mysql_query($caddetpag);
		//echo $caddetpag;
		if (mysql_num_rows($ejec_cadpag)==0) {
			echo "<tr><td><p style='background:red;'>NO SE HA ENCONTRADO RESULTADOS</p></td></tr>";
		} else {
			while ( $res_det = mysql_fetch_array($ejec_cadpag)) {
				?>
				<tr>
					<td><?php echo $res_det['PAG_NUM_FAC_AFECTADO']; ?></td>
					<td><?php echo $res_det['PAG_VALOR']; ?></td>
					<td><?php echo $res_det['PAG_TIPO_FACT_COMP']; ?></td>
				</tr>
				<?php
			}
		}
		
		?>
	</table>
	<?php
} 

}else{
	echo "<script>
		alert('USTED NO HA INICIADO SESION');
		window.location='index.php';
	</script>";
}