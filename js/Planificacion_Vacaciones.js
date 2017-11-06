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

function IngresaFormulario(idpersona,idpersonajefe,cedula,nombres,apellidos,unidadoperativa,fecha_1_salida,fecha_1_retorno,fecha_2_salida,fecha_2_retorno,fecha_3_salida,fecha_3_retorno,fecha_4_salida,fecha_4_retorno,fecha_5_salida,fecha_5_retorno,fecha_6_salida,fecha_6_retorno,reemplazo)
{	
	//alert(cedula+","+nombres+","+apellidos+","+iddepartamento);
	if(validarObligatorio(fecha_1_salida,fecha_1_retorno,reemplazo))
	{
		var ajax=nuevoAjax();
		ajax.open("GET", "./clases/Planificacion_Vacaciones.php?idpersona="+idpersona+"&idpersonajefe="+idpersonajefe+"&cedula="+cedula+"&nombres="+nombres+"&apellidos="+apellidos+"&unidadoperativa="+unidadoperativa+"&fecha_1_salida="+fecha_1_salida+"&fecha_1_retorno="+fecha_1_retorno+"&fecha_2_salida="+fecha_2_salida+"&fecha_2_retorno="+fecha_2_retorno+"&fecha_3_salida="+fecha_3_salida+"&fecha_3_retorno="+fecha_3_retorno+"&fecha_4_salida="+fecha_4_salida+"&fecha_4_retorno="+fecha_4_retorno+"&fecha_5_salida="+fecha_5_salida+"&fecha_5_retorno="+fecha_5_retorno+"&fecha_6_salida="+fecha_6_salida+"&fecha_6_retorno="+fecha_6_retorno+"&reemplazo="+reemplazo+"&accion=input",true);
		
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivPlanificacion_Vacaciones").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivPlanificacion_Vacaciones").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
	}
	
}

function ProcesarSolicitud(idplan_vacaciones,autorizacion,comentario)
//function ProcesarSolicitud()
{
	//alert ("hasta aqui");
	if(validarProcesar(autorizacion,comentario))
		
	{
	var ajax=nuevoAjax();
		ajax.open("GET", "./clases/Planificacion_Vacaciones.php?idplan_vacaciones="+idplan_vacaciones+"&autorizacion="+autorizacion+"&comentario="+comentario+"&accion=procesar",true);
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivPlanificacion_Vacaciones").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivPlanificacion_Vacaciones").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
	}
}

function validarObligatorio(fecha_1_salida,fecha_1_retorno,reemplazo)
{
	//alert("validarObligatorio="+dependencia+","+area+","+cod_usuario+","+nombre_usuario+","+user_name+","+password+","+cod_tipo_usuario+","+tipo);
	boolExit = true;

	if(fecha_1_salida=="")
	{
		alert("Fecha 1 Salida es obligatorio.");
		boolExit = false;
		return;
	}
	if(fecha_1_retorno=="")
	{
		alert("Fecha 1 Retorno es obligario.");
		boolExit = false;
		return;
	}
		
	if(reemplazo=="")
	{
		alert("el Nombre del Reemplazo es obligario.");
		boolExit = false;
		return;
	}
	
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
