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

function EditarFormulario(id_subrrogacion, iddepartamento, jefeinmediato, cedula_subrrogante, fecha_inicio, fecha_fin, comentario_jefe)
{	
	//alert("EditarFormulario="+id_subrrogacion+","+iddepartamento+","+jefeinmediato+","+cedula_subrrogante+","+fecha_inicio+","+fecha_fin+","+comentario_jefe);
	if(validarObligatorio(iddepartamento, jefeinmediato, cedula_subrrogante, fecha_inicio, fecha_fin, comentario_jefe))
	{
		var ajax=nuevoAjax();
		ajax.open("GET", "./clases/Subrrogaciones.php?id_subrrogacion="+id_subrrogacion+"&iddepartamento="+iddepartamento+"&jefeinmediato="+jefeinmediato+"&cedula_subrrogante="+cedula_subrrogante+"&fecha_inicio="+fecha_inicio+"&fecha_fin="+fecha_fin+"&comentario_jefe="+comentario_jefe+"&accion=edit",true);
		
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivSubrrogaciones").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivSubrrogaciones").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
	}
}


function IngresaFormulario(iddepartamento, jefeinmediato, cedula_subrrogante, fecha_inicio, fecha_fin, comentario_jefe)
{	
	//alert(iddepartamento+","+jefeinmediato+","+cedula_subrrogante+","+fecha_inicio+","+fecha_fin+","+comentario_jefe);
	if(validarObligatorio(iddepartamento, jefeinmediato, cedula_subrrogante, fecha_inicio, fecha_fin, comentario_jefe))
	{
		var ajax=nuevoAjax();
		ajax.open("GET", "./clases/Subrrogaciones.php?iddepartamento="+iddepartamento+"&jefeinmediato="+jefeinmediato+"&cedula_subrrogante="+cedula_subrrogante+"&fecha_inicio="+fecha_inicio+"&fecha_fin="+fecha_fin+"&comentario_jefe="+comentario_jefe+"&accion=input",true);
		
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivSubrrogaciones").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivSubrrogaciones").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
	}
}

function getJefeInmediato(idDepartamento, action)
{
	//alert ("getJefeInmediato="+idDepartamento+" , "+action);
	var ajax=nuevoAjax();
		ajax.open("GET", "./clases/Subrrogaciones.php?idDepartamento="+idDepartamento+"&action="+action+"&accion=jefeinmediato",true);
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
				document.getElementById("Div_JefeInmediato").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("Div_JefeInmediato").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
}

function getNombreSubrrogante(cedula_subrrogante)
{
	var ajax=nuevoAjax();
		ajax.open("GET", "./clases/Subrrogaciones.php?cedula_subrrogante="+cedula_subrrogante+"&accion=nombresubrrogante",true);
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("Div_NombreSubrrogante").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("Div_NombreSubrrogante").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
}

function validarObligatorio(iddepartamento, jefeinmediato, cedula_subrrogante, fecha_inicio, fecha_fin, comentario_jefe)
{
	//alert("validarObligatorio="+dependencia+","+area+","+cod_usuario+","+nombre_usuario+","+user_name+","+password+","+cod_tipo_usuario+","+tipo);
	boolExit = true;

	if(iddepartamento=="")
	{
		alert("Departamento es obligatorio.");
		boolExit = false;
		return;
	}

	if(jefeinmediato=="")
	{
		alert("Jefe subrrogado es obligatorio.");
		boolExit = false;
		return;
	}

	if(cedula_subrrogante=="")
	{
		alert("Jefe Subrrogante es obligatorio.");
		boolExit = false;
		return;
	}


	if(fecha_inicio=="")
	{
		alert("Fecha de inicio es obligatorio.");
		boolExit = false;
		return;
	}
	if(fecha_fin=="")
	{
		alert("Fecha de fin es obligario.");
		boolExit = false;
		return;
	}
	
	if(comentario_jefe=="")
	{
		alert("Comentario es obligatorio.");
		boolExit = false;
		return;
	}	
	
	return boolExit;
}
