<?php 
require_once"PHPExcel.php";
require_once"PHPExcel/IOFactory.php";

$obj_php_exel = PHPExcel_IOFactory::load('C:\xampp\htdocs\bddfacturacion_agromundosc\repositorio_xls_inventario\CAR.xlsx');
$objHoja = $obj_php_exel->getActiveSheet()->toArray(null,true,true,true);
$cont =1;
echo "<form action='lib/update_car.php' method='post' style='text-align:center;'><h4>VISTA PREVIA DEL NUEVO INVENTARIO</h4>";
echo "<div style='width:1024px;height:540px;overflow:auto;margin:0 auto;'>
<table class='cl_tabresultados' style='width:1000px;'>
<tr><td>N°</td><td>CEDULA </td><td>NOMBRE</td><td>FACTURA</td><td>FECHA</td><td>VALOR</td></tr>";
foreach ($objHoja as $Indice => $objCelda) {
	//echo  $obj_php_exel->getActiveSheet()->getCell('A'.$cont)->getFormattedValue();  
	//echo "insert into t_invetario_inicial  VALUES   (NULL, '".$obj_php_exel->getActiveSheet()->getCell('B'.$cont)->getFormattedValue()."', ".$obj_php_exel->getActiveSheet()->getCell('E'.$cont)->getFormattedValue().", '2015-12-03', 1, 1, 1);";
	/*echo "update t_prodcutos set PR_STOK_INI = ".$obj_php_exel->getActiveSheet()->getCell('E'.$cont)->getFormattedValue()." where 
	PR_COD_PROD ='".$obj_php_exel->getActiveSheet()->getCell('B'.$cont)->getFormattedValue()."' and  PR_EMPRESA =1;";*/
	//echo "<br>";

	
	echo "<tr>
	<td>".$cont."</td>
	<td><input type='text' name='c_cedula[]' value='".$obj_php_exel->getActiveSheet()->getCell('A'.$cont)->getFormattedValue()."' class='cl_txt2' style='width:120px;'></td>
	<td><input type='text' name='c_nombres[]' value='".$obj_php_exel->getActiveSheet()->getCell('B'.$cont)->getFormattedValue()."' readonly/></td>
	<td><input type='text' name='c_factura[]' value='0010010000".$obj_php_exel->getActiveSheet()->getCell('C'.$cont)->getFormattedValue()."'></td>
	<td><input type='text' name='c_fecha[]' value='".$obj_php_exel->getActiveSheet()->getCell('D'.$cont)->getFormattedValue()."'></td>
	<td><input type='text' name='valor[]' value='".$obj_php_exel->getActiveSheet()->getCell('E'.$cont)->getFormattedValue()."' class='cl_txt2' style='width:100px;' ></td>
	</tr>";
	$cont ++;
}
echo "</table>
</div>
<br>
<input type='submit' value='SUBIR INVENTARIO' style='padding:5px; color:red;'>
<br><hr>
</form>";
?>