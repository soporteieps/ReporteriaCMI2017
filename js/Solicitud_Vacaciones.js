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

function IngresaFormulario(idpersona,idpersonajefe,cedula,nombres,apellidos,unidadoperativa,fecha_inicio,fecha_fin,reemplazo)
{	
	//alert(cedula+","+nombres+","+apellidos+","+iddepartamento);
	if(validarObligatorio(fecha_inicio,fecha_fin,reemplazo))
	{
		var ajax=nuevoAjax();
		ajax.open("GET", "./clases/Solicitud_Vacaciones.php?idpersona="+idpersona+"&idpersonajefe="+idpersonajefe+"&cedula="+cedula+"&nombres="+nombres+"&apellidos="+apellidos+"&unidadoperativa="+unidadoperativa+"&fecha_inicio="+fecha_inicio+"&fecha_fin="+fecha_fin+"&reemplazo="+reemplazo+"&accion=input",true);
		
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivSolicitud_Vacaciones").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivSolicitud_Vacaciones").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
	}
	
}

function ProcesarSolicitud(idsolicitud,autorizacion,comentario)
//function ProcesarSolicitud()
{
//	alert ("hasta aqui");
	if(validarProcesar(autorizacion,comentario))
		
	{
	var ajax=nuevoAjax();
		ajax.open("GET", "./clases/Solicitud_Vacaciones.php?idsolicitud="+idsolicitud+"&autorizacion="+autorizacion+"&comentario_jefe="+comentario+"&accion=procesar",true);
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivSolicitud_Vacaciones").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivSolicitud_Vacaciones").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
	}
}

function validarObligatorio(fecha_inicio,fecha_fin,reemplazo)
{
	//alert("validarObligatorio="+dependencia+","+area+","+cod_usuario+","+nombre_usuario+","+user_name+","+password+","+cod_tipo_usuario+","+tipo);
	boolExit = true;

	if(fecha_inicio=="")
	{
		alert("Fecha Inicio es obligatorio.");
		boolExit = false;
		return;
	}
	if(fecha_fin=="")
	{
		alert("Fecha Fin es obligario.");
		boolExit = false;
		return;
	}
		
	if(reemplazo=="")
	{
		alert("El Nombre del Reemplazo es obligario.");
		boolExit = false;
		return;
	}
	
	return boolExit;
}


function validarProcesar(autorizacion,comentario)
{
//	alert("validarObligatorio="+dependencia+","+area+","+cod_usuario+","+nombre_usuario+","+user_name+","+password+","+cod_tipo_usuario+","+tipo);
	boolExit = true;

	if(autorizacion=="")
	{
		alert("Debe Autorizar o Rechazar.");
		boolExit = false;
		return;
	}
	if(comentario=="")
	{
		alert("Comentario es Obligatorio.");
		boolExit = false;
		return;
	}
	
	return boolExit;
}
