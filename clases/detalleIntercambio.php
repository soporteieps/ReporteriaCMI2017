<!DOCTYPE html>
<?php 
include("../lib/dbconfig.php");
include("funcionesDetalleIntercambio.php");
?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>DETALLE INDICADOR</title>
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
                 url: "detalleExcelIntercambio.php",
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
	<div id="cargando">Cargando...</div>
	<div class='botonReporte' id="botonReporte" onclick="findGetParameter()">Exportar a excel</div>
	<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
		<div id="grafica"></div>
		<input type="hidden"  id="datos_a_enviar" name="datos_a_enviar" />
	</form>	
	<div>
	<?php

	// $tabla ="<table>";
	CrearDetalleIndicador();
	// $tabla .= "</table>";
	
	// echo $tabla;
	?>
	</div>

	
</body>
</html>

