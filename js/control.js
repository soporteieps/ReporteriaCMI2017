$(document).on('ready', inicio);
var numClicks = 0;

function inicio()
{
	$('#btnBuscar').on('click', BuscarIndicador);
	$('#btnBuscarInt').on('click', BucarIndicadorIM);
	$('#botonMuestra').on('click', ShowReportes);
}

function crearAjax()
{
	var res;

	if(window.XMLHttpRequest)
		res = new XMLHttpRequest();
	else
		res = new ActiveXObject("Microsoft.XMLHTTP");

	return res;
}

function BuscarIndicador()
{
	//se toma los valores requeridos
	var idIndicador = $('#cmbIndicador').prop('selected', true).val();
	var idZona = $('#cmbZona').prop('selected', true).val();
	var idMes = $('#cmbMeses').prop('selected', true).val();
	var idAnio = $('#cmbAnios').prop('selected', true).val();

	//variable que llevara los datos al archivo php
	var fdata = new FormData();

	fdata.append('idIndicador', idIndicador);
	fdata.append('idZona', idZona);
	fdata.append('idMes', idMes);
	fdata.append('idAnio', idAnio);

	//variable ajax
	var request = crearAjax();

	request.open('POST', '../../clases/indicadoresFomento.php', true);
	$('#resultadoIndicadores').html('<img src="../../images/cargando.gif"/>');

	request.onload = function(e)
	{
		if(request.status == 200)
		{
			$('#resultadoIndicadores').html(request.responseText);
		}
		else
			console.log('no se logro la conexion');
	};

	request.send(fdata);


}

function BucarIndicadorIM()
{
	//se toma los valores requeridos
	var idIndicador = $('#cmbIndicador').prop('selected', true).val();
	var idZona = $('#cmbZona').prop('selected', true).val();
	var idMes = $('#cmbMeses').prop('selected', true).val();
	var idAnio = $('#cmbAnios').prop('selected', true).val();

	var zonaUsr = $('#zonaUsr').html();
	console.log(zonaUsr);

	//variable que llevara los datos al archivo php
	var fdata = new FormData();

	fdata.append('idIndicador', idIndicador);
	fdata.append('idZona', idZona);
	fdata.append('idMes', idMes);
	fdata.append('idAnio', idAnio);

	//variable ajax
	var request = crearAjax();

	request.open('POST', '../../clases/indicadoresIntercambio.php', true);
	$('#resultadoIndicadores').html('<img src="../../images/cargando.gif"/>');

	request.onload = function(e)
	{
		if(request.status == 200)
		{
			$('#resultadoIndicadores').html(request.responseText);
			document.getElementById("reporteGeneral").href = "../../clases/detalleIntercambio.php?anio=" + idAnio +"&indicador=0&mes=" + idMes + "&zona=" + idZona;
			document.getElementById("reporteMontoPublicoBoton").href = "../../clases/detalleIntercambio.php?anio=" + idAnio +"&indicador=1&mes=" + idMes + "&zona=" + idZona;
			document.getElementById("reporteMontoPrivadoBoton").href = "../../clases/detalleIntercambio.php?anio=" + idAnio +"&indicador=2&mes=" + idMes + "&zona=" + idZona;
			document.getElementById("reporteGeneral").target = "_blank";
			document.getElementById("reporteMontoPublicoBoton").target = "_blank";
			document.getElementById("reporteMontoPrivadoBoton").target = "_blank";
		}
		else
			console.log('no se logro la conexion');
	};

	request.send(fdata);
}

function LinkReporteGeneral()
{
	//se toma los valores requeridos
	var idIndicador = 0;
	var idZona = $('#cmbZona').prop('selected', true).val();
	var idMes = $('#cmbMeses').prop('selected', true).val();
	var idAnio = $('#cmbAnios').prop('selected', true).val();

	document.getElementById("reporteGeneral").href = "../../clases/detalleIntercambio.php?anio=" + idAnio +"&indicador=0&mes=" + idMes + "&zona=" + idZona;	

}

function ShowReportes()
{
	numClicks++;
	var fechaCon = new Date();
	var anio = $('#cmbAnios').prop('selected', true).val();
	var idMes = $('#cmbMeses').prop('selected', true).val();
	if(numClicks == 1)
	{
		if(idMes <= 0)
		{
			alert("Por favor, seleccione un mes de consulta");	
			numClicks = 0;		
		}
		else
		{
			document.getElementById('linksReportes').style.width = 'auto';
			document.getElementById('linksReportes').style.height = 'auto';
			document.getElementById('botonMuestra').classList.remove('fa-angle-down');
			document.getElementById('botonMuestra').classList.add('fa-angle-up');
			document.getElementById("reporteGeneralFp").href = "../../clases/reporteGeneralFp.php?anio=" + anio +"&reporte=1&mes=" + idMes;
			document.getElementById("reporteGeneralSociosFp").href = "../../clases/reporteGeneralFp.php?anio=" + anio +"&reporte=2&mes=" + idMes;
		}
			
	}
	else
	{
		numClicks = 0; //reseteo el control de clics
		document.getElementById('linksReportes').style.width = '0';
		document.getElementById('linksReportes').style.height = '0';
		document.getElementById('botonMuestra').classList.remove('fa-angle-up');
		document.getElementById('botonMuestra').classList.add('fa-angle-down');		
	}


}

