function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}

function reporte(indicador, mes, zona)
{
	//alert ("reporte = "+indicador+" - "+mes+" - "+zona);
	/*if(mes == '-1')
	{
		alert("Seleccione el mes");
	}
	else
	{*/
		var ajax=nuevoAjax();
			ajax.open("GET", "../../clases/index.php?indicador="+indicador+"&mes="+mes+"&zona="+zona+"&accion=consultar",true);
			ajax.onreadystatechange=function() 
			{ 
				if (ajax.readyState==1)
				{
				document.getElementById("DivIndex").innerHTML="cargando..";
				}
				if (ajax.readyState==4)
				{
					document.getElementById("DivIndex").parentNode.innerHTML=ajax.responseText;
					vu=true;
				} 
			}
			ajax.send(null);
	//}
}

/*
function exportarExcell()
{
	alert("exportarExcell");
	var ajax=nuevoAjax();
			ajax.open("GET", "../../clases/BusquedaGeneralExcel.php?indicador="+indicador+"&mes="+mes+"&zona="+zona+"&accion=consultar",true);
			ajax.onreadystatechange=function() 
			{ 
				if (ajax.readyState==1)
				{
				document.getElementById("DivIndex").innerHTML="cargando..";
				}
				if (ajax.readyState==4)
				{
					document.getElementById("DivIndex").parentNode.innerHTML=ajax.responseText;
					vu=true;
				} 
			}
			ajax.send(null);
}*/
/*function ListaCarpeta()
{
		var ajax=nuevoAjax();
		ajax.open("GET", "./clases/ingreso_carpeta.php?accion=listar",true);

		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivListaResultado").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivListaResultado").parentNode.innerHTML=ajax.responseText;
				vu=true;
			} 
		}
		ajax.send(null);
}

function IngresaCarpeta(provincia, area, documento, archivo, periodo, secuencia, nombre,dependencia)
{
		var ajax=nuevoAjax();
		ajax.open("GET", "./clases/ingreso_carpeta.php?provincia="+provincia+"&area="+area+"&documento="+documento+"&archivo="+archivo+"&periodo="+periodo+"&secuencia="+secuencia+"&nombre="+nombre+"&dependencia="+dependencia+"&accion=input",true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivIngresaCarpeta").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivIngresaCarpeta").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
	
}

function EliminaCaja(id)
{
	if(id=="")
	{
		alert("No se puede eliminar");
		return false;
	}
		// Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen	
		var ajax=nuevoAjax();
		ajax.open("GET", "./clases/ingreso_carpeta.php",true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
				document.getElementById("DivListaCarpeta").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivListaCarpeta").parentNode.innerHTML=ajax.responseText;
			} 
		}
		ajax.send(null);
}


function areas_por_dependencia(dependencia)
{
	//alert("Areas_por_Dependencia="+dependencia);
	var ajax=nuevoAjax();
	ajax.open("GET", "./clases/ingreso_carpeta.php?dependencia="+dependencia+"&accion=areas",true);
	ajax.onreadystatechange=function() 
	{ 
		if (ajax.readyState==1)
		{
			document.getElementById("DivAreas").innerHTML="cargando..";
		}
		if (ajax.readyState==4)
		{
			document.getElementById("DivAreas").parentNode.innerHTML=ajax.responseText;
		} 
	}
	ajax.send(null);
	
}*/