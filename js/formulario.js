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

function IngresaFormulario(idpersona,idpersonajefe,cedula,nombres,apellidos,unidadoperativa,fechainicio,fechafin,horainicio,horafin,motivo,archivo,observaciones)
{	
	//alert(cedula+","+nombres+","+apellidos+","+iddepartamento);
	if(validarObligatorio(fechainicio,fechafin,horainicio,horafin,motivo,archivo,observaciones))
	{
		var ajax=nuevoAjax();
		ajax.open("GET", "./clases/formulario.php?idpersona="+idpersona+"&idpersonajefe="+idpersonajefe+"&cedula="+cedula+"&nombres="+nombres+"&apellidos="+apellidos+"&unidadoperativa="+unidadoperativa+"&fechainicio="+fechainicio+"&fechafin="+fechafin+"&horainicio="+horainicio+"&horafin="+horafin+"&motivo="+motivo+"&archivo="+archivo+"&observaciones="+observaciones+"&accion=input",true);
		
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivFormulario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivFormulario").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
	}
	
}

function ProcesarSolicitud(iddatopersonal,autorizacion,comentario)
{
	if(validarProcesar(autorizacion,comentario))
	{
	var ajax=nuevoAjax();
		ajax.open("GET", "./clases/formulario.php?iddatopersonal="+iddatopersonal+"&autorizacion="+autorizacion+"&comentario="+comentario+"&accion=procesar",true);
		
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivFormulario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivFormulario").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
	}
}

function validarObligatorio(fechainicio,fechafin,horainicio,horafin,motivo,archivo,observaciones)
{
	//alert("validarObligatorio="+dependencia+","+area+","+cod_usuario+","+nombre_usuario+","+user_name+","+password+","+cod_tipo_usuario+","+tipo);
//	alert("validarObligatorio="+fechainicio+","+fechafin+","+horainicio+","+horafin+","+motivo+","+archivo+","+observaciones);
	boolExit = true;

	if(fechainicio=="")
	{
		alert("Fecha inicio es obligatorio.");
		boolExit = false;
		return;
	}
	if(fechafin=="")
	{
		alert("Fecha fin es obligario.");
		boolExit = false;
		return;
	}
	
	if(fechafin<fechainicio)
	{
		alert("Fecha fin es menor que Fecha inicio.");
		boolExit = false;
		return;
	}
	
	if(horainicio=="")
	{
		alert("Hora inicio es obligario.");
		boolExit = false;
		return;
	}
	if(horafin=="")
	{
		alert("Hora fin es obligario.");
		boolExit = false;
		return;
	}
	
	if(horafin<horainicio)
	{
		alert("Hora fin es menor que Hora Inicio");
		boolExit = false;
		return;
	}
	
	if(motivo=="" || motivo=="---Seleccione Motivo---" )
	{
		alert("Motivo es obligario.");
		boolExit = false;
		return;
	}
	
	if(motivo==2 && (fechafin>fechainicio))
		//	if(archivo=="")
		{
			
			alert("La Fecha Fin no puede ser mayor a la Fecha Inicio en este tipo de permiso.");
			boolExit = false;
			return;
		}
	
	if(archivo=="" && (motivo=='3' || motivo=='4' || motivo=='5' || motivo=='6' || motivo=='7' || motivo=='8' ))
	//	if(archivo=="")
	{
		
		alert("Archivo es obligario.");
		boolExit = false;
		return;
	}
	
/*	if(observaciones=="")
	{
		alert("Observaciones es obligario.");
		boolExit = false;
		return;
	}
*/	
	return boolExit;
}


function validarProcesar(autorizacion,comentario)
{
	//alert("validarObligatorio="+dependencia+","+area+","+cod_usuario+","+nombre_usuario+","+user_name+","+password+","+cod_tipo_usuario+","+tipo);
	boolExit = true;

	if(autorizacion=="")
	{
		alert("Debe Autorizar o rechazar.");
		boolExit = false;
		return;
	}
	if(comentario=="")
	{
		alert("Comentario es obligatorio.");
		boolExit = false;
		return;
	}
	
	return boolExit;
}
