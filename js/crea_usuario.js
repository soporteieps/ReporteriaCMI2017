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


function CreaUsuario(idpersona,iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado)
{
	//alert("CreaUsuario="+idpersona+","+iddepartamento+","+idpersonajefe+","+cedula+","+nombre+","+apellido+","+grupo_ocupacional+","+modalidad_contratacion+","+correo+","+lugar_trabajo+","+fecha_ingreso_ieps+","+fecha_salida_ieps+","+perfil+","+estado);
	if(validarObligatorio(iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado))
	{
		var ajax=nuevoAjax();
		ajax.open("GET", "crea_usuario.php?idpersona_aux="+idpersona+"&iddepartamento_aux="+iddepartamento+"&idpersonajefe_aux="+idpersonajefe+"&cedula_aux="+cedula+"&nombre_aux="+nombre+"&apellido_aux="+apellido+"&grupo_ocupacional_aux="+grupo_ocupacional+"&modalidad_contratacion_aux="+modalidad_contratacion+"&correo_aux="+correo+"&lugar_trabajo_aux="+lugar_trabajo+"&fecha_ingreso_ieps_aux="+fecha_ingreso_ieps+"&fecha_salida_ieps_aux="+fecha_salida_ieps+"&perfil_aux="+perfil+"&estado_aux="+estado+"&accion=crea",true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivUsuario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivUsuario").parentNode.innerHTML=ajax.responseText;
				vu=true;
			} 
		}
		ajax.send(null);
	}
}




function EditarUsuario(idpersona,iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado)
{
	//alert("EditarUsuario="+idpersona+","+iddepartamento+","+idpersonajefe+","+cedula+","+nombre+","+apellido+","+grupo_ocupacional+","+modalidad_contratacion+","+correo+","+lugar_trabajo+","+fecha_ingreso_ieps+","+fecha_salida_ieps+","+perfil+","+estado);
	
if(validarObligatorio(iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado))
	{
		var ajax=nuevoAjax();
		
		ajax.open("GET","crea_usuario.php?idpersona_aux="+idpersona+"&iddepartamento_aux="+iddepartamento+"&idpersonajefe_aux="+idpersonajefe+"&cedula_aux="+cedula+"&nombre_aux="+nombre+"&apellido_aux="+apellido+"&grupo_ocupacional_aux="+grupo_ocupacional+"&modalidad_contratacion_aux="+modalidad_contratacion+"&correo_aux="+correo+"&lugar_trabajo_aux="+lugar_trabajo+"&fecha_ingreso_ieps_aux="+fecha_ingreso_ieps+"&fecha_salida_ieps_aux="+fecha_salida_ieps+"&perfil_aux="+perfil+"&estado_aux="+estado+"&accion=update",true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivUsuario").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivUsuario").parentNode.innerHTML=ajax.responseText;
				vu=true;
			} 
		}
		ajax.send(null);
	}
}

function EliminaUsuario(idpersona)
{
	//alert("EliminaUsuario="+idpersona);
	var txt;
	var r = confirm("Esta seguro de eliminar el usuario con CI "+idpersona+"..!");
	if (r == true) {
			var ajax=nuevoAjax();
			ajax.open("GET", "crea_usuario.php?idpersona="+idpersona+"&accion=elimina",true);
			ajax.onreadystatechange=function() 
			{ 
				if (ajax.readyState==1)
				{
				document.getElementById("DivUsuario").innerHTML="cargando..";
				}
				if (ajax.readyState==4)
				{
					document.getElementById("DivUsuario").parentNode.innerHTML=ajax.responseText;
					vu=true;
				} 
			}
			ajax.send(null);
	} 	
}

function area_por_departamento(iddepartamento)
{
	//alert("area_por_departamento="+iddepartamento);
	var ajax=nuevoAjax();
		ajax.open("GET", "crea_usuario.php?iddepartamento="+iddepartamento+"&accion=departamento",true);
        ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
			document.getElementById("DivJefeporDepartamento").innerHTML="cargando..";
			}
			if (ajax.readyState==4)
			{
				document.getElementById("DivJefeporDepartamento").parentNode.innerHTML=ajax.responseText;
				vu=true;
			} 
		}
		ajax.send(null);
}

function regresar()
		{
 	        window.location.href="../Forms/usuarios/index.php";
		}

function validarObligatorio(iddepartamento,idpersonajefe,cedula,nombre,apellido,grupo_ocupacional,modalidad_contratacion,correo,lugar_trabajo,fecha_ingreso_ieps,fecha_salida_ieps,perfil,estado)
{
	//alert("validarObligatorio="+dependencia+","+area+","+cod_usuario+","+nombre_usuario+","+user_name+","+password+","+cod_tipo_usuario+","+tipo);
	//alert("validarObligatorio="+idpersonajefe);
	boolExit = true;
	if(iddepartamento=="--Seleccione un Departamento--")
	{
		alert("Departamento es obligatorio.");
		boolExit = false;
		return;
	}
	if(idpersonajefe=="--Seleccione Jefe Inmediato--")
	{
		alert("Jefe Inmediato es obligatorio.");
		boolExit = false;
		return;
	}
	if(cedula=="")
	{
		alert("CI es obligatorio.");
		boolExit = false;
		return;
	}
	if(nombre=="")
	{
		alert("Nombres del usuario es obligario.");
		boolExit = false;
		return;
	}
	if(apellido=="")
	{
		alert("Apellidos del usuario es obligario.");
		boolExit = false;
		return;
	}
	if(grupo_ocupacional=="--Seleccione Grupo Ocupacional--")
	{
		alert("Grupo Ocupacional es obligario.");
		boolExit = false;
		return;
	}
	if(modalidad_contratacion=="--Seleccione Modalidad--")
	{
		alert("Modalidad de Contratación es obligario.");
		boolExit = false;
		return;
	}
	
	if(correo=="correo")
	{
		alert("Correo Institucional es obligario.");
		boolExit = false;
		return;
	}
	
	if(lugar_trabajo=="--Seleccione Lugar Trabajo--")
	{
		alert("Lugar Trabajo es obligario.");
		boolExit = false;
		return;
	}
	
	if(fecha_ingreso_ieps=="")
	{
		alert("Fecha de Ingreso es obligario.");
		boolExit = false;
		return;
	}
	
	if(fecha_salida_ieps=="")
	{
		alert("Fecha de Salida es obligario.");
		boolExit = false;
		return;
	}
	
	if(perfil=="--Seleccione Perfil--")
	{
		alert("Perfil de Usuario es obligario.");
		boolExit = false;
		return;
	}
	
	if(estado=="--Seleccione Estado--")
	{
		alert("Estado es obligario.");
		boolExit = false;
		return;
	}
	
	
	return boolExit;
}

