<?php 
include("../lib/dbconfig.php");
include("funcionesDetalleFomento.php");

$anioExcel = getAnioSeleccionado();
$indicadorExcel = getIndicador();
$mesExcel = getMes();
$zonaExcel = getZona();

//echo $anioExcel . " - " . $indicadorExcel . " - " . $mesExcel . " - " . $zonaExcel;

$tablaExcel = "<table>";
$tablaExcel .= CrearDetalleIndicador();
$tablaExcel .= "</table>";

echo $tablaExcel;



?>