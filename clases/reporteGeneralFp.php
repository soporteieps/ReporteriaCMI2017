<?php
include("../lib/dbconfig.php");
include("funcionesReportesGeneral.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Detalle Reporte General</title>
	<link rel="stylesheet" href="../css/estilos.css">
	<script src="../js/jquery.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
	$(window).load(function(){
		$('#cargando').hide();
	});
	//detalle.php?indicador=1&mes=1&zona=8&anio=2017	
	function exportarExcell(datos) {
		//alert("*************************function exportarExcell******************************");
		//if (com == 'Exportar') {


		     $.ajax({  
                 type: "GET", 
                 url: "detalleExcelFomentoReporteGeneral.php",
				 //data:'idIndicador='+$('#cmbIndicador').val()+'&idMes='+$('#cmbMeses').val()+'&idZona='+$('#cmbZona').val(),
				 data: datos,	 	
                 success: function(html){  
                 		$('#grafica').html('');
					    $("#datos_a_enviar").val(html);
     				 $("#FormularioExportacion").submit();	 
               }  
             });  
		//} 
	}

	function findGetParameter() {
		var urlRetrive = window.location.search.substr(1);
		console.log(urlRetrive);
		$('#grafica').html('<p><img src="../images/ajax-loader.gif"/></p>');
	   exportarExcell(urlRetrive);
	    
	    //return result;
	}
	</script> 
</head>
<body>
	<div class='botonReporte' id="botonReporte" onclick="findGetParameter()">Exportar a excel</div>
		<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
			<div id="grafica"></div>
			<input type="hidden"  id="datos_a_enviar" name="datos_a_enviar" />
		</form>
	</div>
	<table>		
		<thead>
		<?php
			$reporteGeneral = getReporteIndice();
			$head = GetHeadReporte($reporteGeneral);
			echo $head;
		?>			
		</thead>
		<tbody>
			<?php
			$reporteGeneral = getReporteIndice();
			if($reporteGeneral == 1)
			{
				$tablaResultante = ReporteBaseOepsUeps();
			}
			else if($reporteGeneral == 2)
			{
				$tablaResultante = ReporteSociosGeneral();
			}
			echo $tablaResultante;
			?>
		</tbody>
	</table>
		
</body>
</html>



