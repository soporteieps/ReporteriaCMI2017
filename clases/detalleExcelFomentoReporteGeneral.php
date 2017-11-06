<?php 
include("../lib/dbconfig.php");
include("funcionesReportesGeneral.php");

//echo $anioExcel . " - " . $indicadorExcel . " - " . $mesExcel . " - " . $zonaExcel;


$reporteGeneral = getReporteIndice();
$head = GetHeadReporte($reporteGeneral);
$tablaExcel = "<table><thead>" . $head . "</thead><tbody>";
$reporteGeneral = getReporteIndice();
if($reporteGeneral == 1)
{
	$tablaExcel .= ReporteBaseOepsUeps();
}
elseif($reporteGeneral == 2)
{
	$tablaExcel .= ReporteSociosGeneral();
}
$tablaExcel .= "</tbody></table>";

echo $tablaExcel;



?>