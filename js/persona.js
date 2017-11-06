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

function IngresaFormulario(idpersona,idpersonajefe,cedula,nombre,apellido,iddepartamento,grupo_ocupacional,modalidad_contratocion,lugar_trabajo,cod_biometrico,correo, fecha_ingreso_ieps,fecha_salida_ieps)
{	
	//alert(cedula+","+nombres+","+apellidos+","+iddepartamento);
	if(validarObligatorio(idpersona,idpersonajefe,cedula,nombre,apellido,iddepartamento,grupo_ocupacional,modalidad_contratocion,lugar_trabajo,cod_biometrico,correo, fecha_ingreso_ieps))
	{
		var ajax=nuevoAjax();
		ajax.open("GET", "./clases/persona.php?idpersona="+idpersona+"&idpersonajefe="+idpersonajefe+"&cedula="+cedula+"&nombre="+nombre+"&apellido="+apellido+"&iddepartamento="+iddepartamento+"&grupo_ocupacional="+grupo_ocupacional+"&modalidad_contratocion="+modalidad_contratocion+"&lugar_trabajo="+lugar_trabajo+"&cod_biometrico="+cod_biometrico+"&correo="+correo+"&fecha_ingreso_ieps="+fecha_ingreso_ieps+"&fecha_salida_ieps="+fecha_salida_ieps+"&accion=input",true);
		
		
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
	ajax.open("GET", "./clases/persona.php?idpersona="+idpersona+"&idpersonajefe="+idpersonajefe+"&cedula="+cedula+"&nombre="+nombre+"&apellido="+apellido+"&iddepartamento="+iddepartamento+"&grupo_ocupacional="+grupo_ocupacional+"&modalidad_contratocion="+modalidad_contratocion+"&lugar_trabajo="+lugar_trabajo+"&cod_biometrico="+cod_biometrico+"&correo="+correo+"&fecha_ingreso_ieps="+fecha_ingreso_ieps+"&fecha_salida_ieps="+fecha_salida_ieps+"&accion=procesar",true);
		
		
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

function validarObligatorio(idpersona,idpersonajefe,cedula,nombre,apellido,iddepartamento,grupo_ocupacional,modalidad_contratocion,lugar_trabajo,cod_biometrico,correo, fecha_ingreso_ieps)
{
	//alert("validarObligatorio="+dependencia+","+area+","+cod_usuario+","+nombre_usuario+","+user_name+","+password+","+cod_tipo_usuario+","+tipo);
//	alert("validarObligatorio="+fechainicio+","+fechafin+","+horainicio+","+horafin+","+motivo+","+archivo+","+observaciones);
	boolExit = true;

	if(idpersona=="")
	{
		alert("Codigo es obligatorio.");
		boolExit = false;
		return;
	}
	if(cedula=="")
	{
		alert("Cedula es obligario.");
		boolExit = false;
		return;
	}
	
	if(nombres="")
	{
		alert("Nombre es obligario.");
		boolExit = false;
		return;
	}
	
	if(apellido=="")
	{
		alert("Apellido es obligario.");
		boolExit = false;
		return;
	}
	if(cod_biometrico=="")
	{
		alert("Codigo de Biométrico es obligario.");
		boolExit = false;
		return;
	}
	
	if(iddepartamento=="" || iddepartamento=="---Seleccione Direccion---" )
	{
		alert("Direccion es obligario.");
		boolExit = false;
		return;
	}
	
	if(grupo_ocupacional=="" || grupo_ocupacional=="---Seleccione Grupo Ocupacional---" )
	{
		alert("Grupo ocupacional es obligario.");
		boolExit = false;
		return;
	}
	
	if(modalidad_contratocion=="" || modalidad_contratocion=="---Seleccione Modalidad---" )
	{
		alert("Modalidad es obligario.");
		boolExit = false;
		return;
	}
	
	if(lugar_trabajo=="" || lugar_trabajo=="---Seleccione Lugar de Trabajo---" )
	{
		alert("Lugar es obligario.");
		boolExit = false;
		return;
	}
	
	if(fecha_ingreso_ieps=="")
	{
		alert("Fecha de Ingreso es obligario.");
		boolExit = false;
		return;
	}
	
	
	if(activo=="")
	{
		alert("Debe Seleccionar Activo "SI" o "NO".");
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

/*
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
*/