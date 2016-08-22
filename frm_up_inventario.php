<?php 
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$obj_php_exel = PHPExcel_IOFactory::load('C:\xampp\htdocs\bddfacturacion_agromundosc\repositorio_xls_inventario\UPI.xls');
$objHoja = $obj_php_exel->getActiveSheet()->toArray(null,true,true,true);
$cont =1;
/*echo "<form action='lib/update_inv.php' method='post' style='text-align:center;'><h4>VISTA PREVIA DEL NUEVO INVENTARIO</h4>";
echo "<div style='width:1024px;height:540px;overflow:auto;margin:0 auto;'>
<table class='cl_tabresultados' style='width:1000px;'>
<tr><td>N°</td><td>COD. PROD.</td><td>PRODCUTO.</td><td>DESCRIP PRO.</td><td>NUEVO STROCK</td><td>Empresa</td></tr>";*/
foreach ($objHoja as $Indice => $objCelda) {
//	echo  $obj_php_exel->getActiveSheet()->getCell('A'.$cont)->getFormattedValue().'<br>';  
	echo "insert into t_invetario_inicial  VALUES   (NULL, '".$obj_php_exel->getActiveSheet()->getCell('B'.$cont)->getFormattedValue()."', ".$obj_php_exel->getActiveSheet()->getCell('E'.$cont)->getFormattedValue().", '2015-12-03', 1, 1, 1);";
	/*echo "update t_prodcutos set PR_STOK_INI = ".$obj_php_exel->getActiveSheet()->getCell('E'.$cont)->getFormattedValue()." where 
	PR_COD_PROD ='".$obj_php_exel->getActiveSheet()->getCell('B'.$cont)->getFormattedValue()."' and  PR_EMPRESA =1;";*/
	echo "<br>";

	/*
	echo "<tr>
	<td>".$obj_php_exel->getActiveSheet()->getCell('A'.$cont)->getFormattedValue()."</td>
	<td><input type='text' name='c_cod_prod_upi[]' value='".$obj_php_exel->getActiveSheet()->getCell('B'.$cont)->getFormattedValue()."' class='cl_txt2' style='width:120px;' readonly/></td>
	<td>".$obj_php_exel->getActiveSheet()->getCell('C'.$cont)->getFormattedValue()."</td>
	<td>".$obj_php_exel->getActiveSheet()->getCell('D'.$cont)->getFormattedValue()."</td>
	<td><input type='number' name='c_val_newstock_upi[]' value='".$obj_php_exel->getActiveSheet()->getCell('E'.$cont)->getFormattedValue()."' class='cl_txt2' style='width:100px;' ></td>
	<td><input type='number' name='c_val_emp_upi[]' value='".$obj_php_exel->getActiveSheet()->getCell('F'.$cont)->getFormattedValue()."' class='cl_txt2' style='width:30px;' readonly></td>
	</tr>";*/
	$cont ++;
}
/*echo "</table>
</div>
<br>
<input type='submit' value='SUBIR INVENTARIO' style='padding:5px; color:red;'>
<br><hr>
</form>";*/
?>