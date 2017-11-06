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

function IngresaFormulario(usuario, contrasena, correo, iddepartamento, activo, cedula)
{	
	//alert(cedula+","+nombres+","+apellidos+","+iddepartamento);
	if(validarObligatorio(usuario,contrasena,activo,cedula))
	{
		var ajax=nuevoAjax();
		ajax.open("GET", "./clases/Usuario.php?usuario="+usuario+"&contrasena="+contrasena+"&correo="+correo+"&iddepartamento="+iddepartamento+"&activo="+activo+"&cedula="+cedula+"&accion=input",true);
		
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivUsuario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivUsuario").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
	}
	
}

function ProcesarSolicitud(idusuario,activo)
//function ProcesarSolicitud()
{
	//alert ("hasta aqui");
	if(validarProcesar(activo))
		
	{
	var ajax=nuevoAjax();
		ajax.open("GET", "./clases/Usuario.php?idusuario="+idusuario+"&activo="+activo+"&accion=procesar",true);
		
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivUsuario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivUsuario").parentNode.innerHTML=ajax.responseText;
			
			} 
		}
		ajax.send(null);
	}
}
*/
function validarObligatorio(usuario,contrasena,actvio, cedula)
{
	//alert("validarObligatorio="+dependencia+","+area+","+cod_usuario+","+nombre_usuario+","+user_name+","+password+","+cod_tipo_usuario+","+tipo);
	boolExit = true;

	if(fecha_inicio=="")
	{
		alert("Usuario es obligatorio.");
		boolExit = false;
		return;
	}
	if(fecha_fin=="")
	{
		alert("Contraseña es obligario.");
		boolExit = false;
		return;
	}
		
	if(reemplazo=="")
	{
		alert("El campo Activo es obligario.");
		boolExit = false;
		return;
	}
	
	if(reemplazo=="")
	{
		alert("Cédula es obligario.");
		boolExit = false;
		return;
	}
	
	return boolExit;
}


function validarProcesar(usuario,contrasena,activo,cedula)
{
	//alert("validarObligatorio="+dependencia+","+area+","+cod_usuario+","+nombre_usuario+","+user_name+","+password+","+cod_tipo_usuario+","+tipo);
	boolExit = true;

	if(activo=="")
	{
		alert("Debe indicar si el usuario esta activo");
		boolExit = false;
		return;
	}
	
	return boolExit;
}
