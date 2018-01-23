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

function reporte(indicador, mes, zona, anio)
{
	
	// se debe revisar si el reporte es anterior al mes y año actual
	var fecha = <?php = time(); ?>;
	console.log(fecha);


	var perfil = 7;
	var ajax=nuevoAjax();
		ajax.open("GET", "../../clases/index.php?indicador="+indicador+"&mes="+mes+"&zona="+zona+"&anio="+anio+"&perfil=" + perfil + "&accion=consultar",true);
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