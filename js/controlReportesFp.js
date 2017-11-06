// variables
var botonMes = document.getElementById('cmbMeses');
botonMes.addEventListener('change', CambiarEnlaceReporte);

function CambiarEnlaceReporte()
{
	var valorMes = botonMes.value;
	var fechaCon = new Date();
	var anio = fechaCon.getFullYear();	

	if(valorMes <= 0)
	{
		document.getElementById('linksReportes').style.width = '0';
		document.getElementById('linksReportes').style.height = '0';
		document.getElementById('botonMuestra').classList.remove('fa-angle-up');
		document.getElementById('botonMuestra').classList.add('fa-angle-down');
		numClicks = 0;	// variable viene del archivo control.js
	}
	else
	{
		document.getElementById("reporteGeneralFp").href = "../../clases/reporteGeneralFp.php?anio=" + anio +"&reporte=1&mes=" + valorMes;
		document.getElementById("reporteGeneralSociosFp").href = "../../clases/reporteGeneralFp.php?anio=" + anio +"&reporte=2&mes=" + valorMes;
	}
	
}