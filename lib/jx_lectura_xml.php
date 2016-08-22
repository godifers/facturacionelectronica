<?php 
$carpeta =$_POST['carp'];
$emp =$_POST['empr'];
$fin_fac =$_POST['maxf'];

$cont_auto=0;
$cont_no_au=0;
$cont_err =0;
if ($carpeta==01) {
	$strin_carp = "01_FACTURAS";
} else if($carpeta==02) {
	$strin_carp = "02_NOTAS_CREDITO_VENTAS";
} else if($carpeta==04) {
	$strin_carp = "04_GUIAS_DE_REM";
} else if($carpeta==07) {
	$strin_carp = "07_RETENCIONES";
}

?>
<div style="width:1100px;min-height:20px;max-height:600px;overflow:auto;margin:0 auto;">
<table class="cl_tabresultados">
<?php
for ($cont= 1; $cont <= $fin_fac ; $cont++) { 
	$c_num_fact= $cont;
	for ($cont_f_man= strlen($c_num_fact); $cont_f_man < 9 ; $cont_f_man++) { 
		$c_num_fact = '0'.$c_num_fact;
	}
	//echo $c_num_fact.'<br>';
	if (file_exists("xmlenviados/".$strin_carp."/requestSRI/Autorizado_".$emp."001".$c_num_fact.".xml")) {
		$xml = simplexml_load_file("xmlenviados/".$strin_carp."/requestSRI/Autorizado_".$emp."001".$c_num_fact.".xml");
		?>
		<tr>
			<td><p style="font-size:14px;margin:0;"><?php echo $emp."001".$c_num_fact."-"; ?></p></td>
			<td><p style="font-size:12px;margin:0;"><?php echo $esatdo = $xml->estado.'-';	 ?></p></td>
			<td><p style="font-size:14px;margin:0;"><?php echo $identificador = $xml->mensajes->mensaje->identificador; ?></p></td>		
			<td><p style="font-size:14px;margin:0;"><?php echo $mensaje = $xml->mensajes->mensaje->mensaje; ?></p></td>		
			<td><p style="font-size:14px;margin:0;"><?php echo $informacionAdicional = $xml->mensajes->mensaje->informacionAdicional; ?></p></td>
			<td><p style="font-size:14px;margin:0;"><?php echo $tipo = $xml->mensajes->mensaje->tipo; ?></p></td>
		</tr>
		<?php
		//echo $c_num_fact.'<br>';
		$cont_auto = $cont_auto +1;
	}
	if (file_exists("xmlenviados/".$strin_carp."/requestSRI/NOAutorizado_".$emp."001".$c_num_fact.".xml")) {
		$xml = simplexml_load_file("xmlenviados/".$strin_carp."/requestSRI/NOAutorizado_".$emp."001".$c_num_fact.".xml");
		?>
		<tr>
			<td><p style="font-size:14px;margin:0;"><?php echo $emp."001".$c_num_fact."-"; ?></p></td>
			<td><p style="font-size:12px;margin:0;"><?php echo $esatdo = $xml->estado.'-';	 ?></p></td>
			<td><p style="font-size:14px;margin:0;"><?php echo $identificador = $xml->mensajes->mensaje->identificador; ?></p></td>		
			<td><p style="font-size:14px;margin:0;"><?php echo $mensaje = $xml->mensajes->mensaje->mensaje; ?></p></td>		
			<td><p style="font-size:14px;margin:0;"><?php echo $informacionAdicional = $xml->mensajes->mensaje->informacionAdicional; ?></p></td>
			<td><p style="font-size:14px;margin:0;"><?php echo $tipo = $xml->mensajes->mensaje->tipo; ?></p></td>
		</tr>
		<?php
		//echo $c_num_fact.'<br>';
		$cont_no_au = $cont_no_au +1;
	}
	if (file_exists("xmlenviados/".$strin_carp."/requestSRI/Error_".$emp."001".$c_num_fact.".xml")) {
		$xml = simplexml_load_file("xmlenviados/".$strin_carp."/requestSRI/Error_".$emp."001".$c_num_fact.".xml");
		?>
		<tr>
			<td><p style="font-size:14px;margin:0;"><?php echo $emp."001".$c_num_fact."-"; ?></p></td>
			<td><p style="font-size:12px;margin:0;"><?php echo $esatdo = $xml->estado.'-';	 ?></p></td>
			<td><p style="font-size:14px;margin:0;"><?php echo $identificador =$xml->comprobantes->comprobante->mensajes->mensaje->identificador; ?></p></td>		
			<td><p style="font-size:14px;margin:0;"><?php echo $mensaje =$xml->comprobantes->comprobante->mensajes->mensaje->mensaje; ?></p></td>		
			<td><p style="font-size:14px;margin:0;"><?php echo $informacionAdicional =$xml->comprobantes->comprobante->mensajes->mensaje->informacionAdicional; ?></p></td>
			<td><p style="font-size:14px;margin:0;"><?php echo $tipo = $xml->comprobantes->comprobante->mensajes->mensaje->tipo; ?></p></td>
		</tr>
		<?php
		//echo $c_num_fact.'<br>';
		$cont_err = $cont_err +1;
	}
}
?>
</table>
</div>
<?php
echo 'Archvivos Autorizados'.$cont_auto.'<br>';
echo 'Archvivos NO AUTORIZADO'.$cont_no_au.'<br>';
echo 'Archvivos ERROR '.$cont_err.'<br>';
?>