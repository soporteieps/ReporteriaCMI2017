var numClicks = 0;
var respuesta = "";
$(document).on('ready', inicio);



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

function reporte(indicador, mes, zona, anio)
{
	
	// se debe revisar si el reporte es anterior al mes y año actual
	var fecha = document.getElementById('fechaServer');
	var arrayDate = new Array(0, 0, 0);
	if(!fecha)
	{
		console.log('fecha es null');	
	}
	else
	{
		var dateDiff = fecha.innerHTML;
		arrayDate = dateDiff.split('-');
		console.log(arrayDate[0] + " " + arrayDate[1] + " " + arrayDate[2]);
	}

	arrayDate[0] = parseInt(arrayDate[0]);
	arrayDate[1] = parseInt(arrayDate[1]);
	arrayDate[2] = parseInt(arrayDate[2]);	


	var perfil = 7;
	var ajax=crearAjax();
	if(arrayDate[0] == anio && arrayDate[1] == mes)
	{
		ajax.open("GET", "../../clases/index.php?indicador="+indicador+"&mes="+mes+"&zona="+zona+"&anio="+anio+"&perfil=" + perfil + "&tipoReporte=normal&accion=consultar",true);
	}
	else
	{
		ajax.open("GET", "../../clases/index.php?indicador="+indicador+"&mes="+mes+"&zona="+zona+"&anio="+anio+"&perfil=" + perfil + "&tipoReporte=antiguo&accion=consultar",true);
	}
		
		ajax.onreadystatechange=function() 
		{
			
			document.getElementById('DivIndex').innerHTML = '<img src="../../images/cargando.gif"x/>';
			 ajax.onreadystatechange=function() 
			{ 
				if (ajax.readyState==4)
				{
					document.getElementById("DivIndex").parentNode.innerHTML=ajax.responseText;
					vu=true;
				}
			}
		}
		ajax.send(null);
	
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

function GuardarIndicadores(departamento, anio, mes, zona)
{
	
	console.log('ejecutado la funcion');
	
	var idZona = zona;
	var idMes = mes;
	var idAnio = anio;
	var idDepartamento = departamento;
	var request = crearAjax();
	

	var fdata = new FormData();
	var lengthIndicador = document.getElementById('cmbIndicador').length;
	var valoresIndicadores = [];
	console.log(lengthIndicador);

	for(var i = 1; i < lengthIndicador; i++)
	{
		var idText = idZona + "-" + idMes + "-" + i;
		
		if(document.getElementById(idText) == null)
		{
			alert('Por favor, pulse el botón de "Buscar" para calcular los indicadores que desea guardar. (La ZONA, MES o AÑO NO CONCUERDAN CON LOS DATOS MOSTRADOS EN PATALLA).');
			return false;
		}
		else
		{
			var textoTd = document.getElementById(idText).innerHTML;
			valoresIndicadores.push(textoTd);
		}
	}

	console.log(valoresIndicadores);
	
	fdata.append('idZona', idZona);
	fdata.append('idMes', idMes);
	fdata.append('idAnio', idAnio);
	fdata.append('idDepartamento', idDepartamento);
	fdata.append('valoresIndicadores', valoresIndicadores);
	fdata.append('accion', 'procesar');

	request.open('POST', '../../clases/grabarIndicadoresCMI.php', true);
	request.onload = function(e)
	{
		if(request.status == 200)
		{
			console.log(request.responseText);
			// alert('Datos guardados satisfactoriamente');
			document.getElementById('botonGrabar').disabled = false;
			alert('Indicadores guardados correctamente');
		}
		else
		{
			console.log('no se logro la conexion');
			document.getElementById('botonGrabar').disabled = false;
		}
	};

	request.send(fdata);
 

	console.log(idZona + " - " + idMes + " - " + idAnio);
}

function VerificarDatos()
{
	var consulta = crearAjax();
	document.getElementById('botonGrabar').disabled = true;
	var idIndicador = $('#cmbIndicador').prop('selected', true).val();
	var idZona = $('#cmbZona').prop('selected', true).val();
	var idMes = $('#cmbMeses').prop('selected', true).val();
	var idAnio = $('#cmbAnios').prop('selected', true).val();
	var idDepartamento = 'FA';

	if(idZona == -1)
	{
		document.getElementById('botonGrabar').disabled = false;
		alert('Por favor, eliga una zona');
		return false;
	}
	if(idMes == -1)
	{
		document.getElementById('botonGrabar').disabled = false;
		alert('Por favor, eliga una mes');
		return false;
	}
	if(idAnio == -1)
	{
		document.getElementById('botonGrabar').disabled = false;
		alert('Por favor, eliga una año');
		return false;
	}
	if(idIndicador > 0)
	{
		document.getElementById('botonGrabar').disabled = false;
		alert('Por favor, elija "TODOS" en el INDICADOR');
		return false;
	}

	var fdata = new FormData();
	fdata.append('idDepartamento', idDepartamento);
	fdata.append('idAnio', idAnio);
	fdata.append('idMes', idMes);
	fdata.append('idZona', idZona);
	fdata.append('accion', 'verificar');


	
	consulta.onreadystatechange = function()
	{
		if(consulta.status == 200 && consulta.readyState == 4)
		{
			respuesta = consulta.responseText;
			var confirmar = confirm(respuesta);
			if(confirmar)
			{
				GuardarIndicadores(idDepartamento, idAnio, idMes, idZona);
			}
			else
			{
				message('Se cancelo la grabación de los indicadores');
			}		
		}
	}
	consulta.open('POST', '../../clases/grabarIndicadoresCMI.php', true);
	consulta.send(fdata);
	
}

