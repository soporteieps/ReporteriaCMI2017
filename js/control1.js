$(document).on('ready', inicio);

function inicio()
{
	$('#btnBuscar').on('click', BuscarIndicador);
	$('#btnBuscarInt').on('click', BucarIndicadorIM);
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

	//variable que llevara los datos al archivo php
	var fdata = new FormData();

	fdata.append('idIndicador', idIndicador);
	fdata.append('idZona', idZona);
	fdata.append('idMes', idMes);
	fdata.append('idAnio', idAnio);

	//variable ajax
	var request = crearAjax();

	request.open('POST', '../../clases/indicadoresIntercambio1.php', true);
	$('#resultadoIndicadores').html('<img src="../../images/cargando.gif"/>');

	request.onload = function(e)
	{
		if(request.status == 200)
		{
			$('#resultadoIndicadores').html(request.responseText);
			document.getElementById("reporteGeneral").href = "../../clases/detalleIntercambio.php?anio=" + idAnio +"&indicador=0&mes=" + idMes + "&zona=" + idZona;
			document.getElementById("reporteGeneral").target = "_blank";
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