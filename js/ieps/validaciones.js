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

function validarT(e) { 
tecla = (document.all) ? e.keyCode : e.which; 
if(tecla != 0){
	if (tecla==8) return true; 
	patron =/[A-Z-a-z\s]/; 
	te = String.fromCharCode(tecla); 
	return patron.test(te); 
	} 
}

// NÚMEROS Y COMAS
function validarNC(e) { 
	tecla = (document.all) ? e.keyCode : e.which; 
	if(tecla != 0){
		if (tecla==8) return true; 
		patron = /[1234567890.]/; 
		te = String.fromCharCode(tecla); 	
		return patron.test(te); 
	}
} 

// NÚMEROS 
function validarN(e) { 
	tecla = (document.all) ? e.keyCode : e.which; 
	if(tecla != 0){
		//alert("tecla="+tecla);
		if (tecla==8) return true; 
		patron = /\d/; 
		te = String.fromCharCode(tecla); 	
		return patron.test(te); 
	}
} 

//VALIDAR QUE NUMERO ESTE ENTRE UN RANGO
function entre(element,num_mi,num_ma){
	
	Numer=parseInt(element.value);
	if (!isNaN(Numer)){
		if(Numer <num_mi || Numer > num_ma){ 
			alert("Debe ingresar valor num\u00E9rico entre "+num_mi+ " y "+ num_ma);
			element.value="";
			document.getElementById(element.name).focus();	

		}
	}
}
//VALIDAR CEDULA
function check_cedula(form,element)
{
	//alert("check_cedula_lllego al js");
	//alert("chkEncargado_transportes="+document.getElementById("chkEncargado_transportes").checked);
	var cedula = element.value;
	if(cedula != ""){
	  //alert("cedula.substring="+cedula.substring(0, 2));
	  array = cedula.split("");
	  num = array.length;
	  if ( num == 10 )
	  {
		total = 0;
		digito = (array[9]*1);
		//valida si los 2 primeros digitos pertenecen alguna provincia del Ecuador
		//alert("array[0]="+array[0]);
		if (array[0] >0 )
			dosprimerosdigitos = parseInt(cedula.substring(0, 2));
		else
			dosprimerosdigitos = parseInt(array[1]);
	  
	  //alert("dosprimerosdigitos="+dosprimerosdigitos);
	  if(dosprimerosdigitos>=1 && dosprimerosdigitos<=24)
		{// compruebo a que region pertenece esta cedula//		
			for( i=0; i < (num-1); i++ )
			{
				mult = 0;
				if ( ( i%2 ) != 0 ) 
				{
					total = total + ( array[i] * 1 );
				}
				else
				{
					mult = array[i] * 2;
					if ( mult > 9 )
						total = total + ( mult - 9 );
					else
						total = total + mult;
				}
			}
			decena = total / 10;
			decena = Math.floor( decena );
			decena = ( decena + 1 ) * 10;
			final = ( decena - total );
			if ( ( final == 10 && digito == 0 ) || ( final == digito ) ) 
			{
				
				if(form == 0){
					//alert("check_cedula = "+form+",cedula="+cedula);
					document.getElementById("txtUser_name").value=cedula;
					checkNombresporCedula(cedula);
					checkTipoUsuarioporCedula(cedula);
				}
				else{cedulaRepetida(cedula, 0);}
				return true;	  
			}
			else
			{
			  element.value="";
			  alert( "La c\xe9dula NO es v\xe1lida!!!" );
			  if(form == 0){
					document.getElementById("txtNombres_usuario").value="";
					document.getElementById("txtUser_name").value="";
				}
			  document.getElementById(element.name).focus();
			  return false;
			}
		  }
		 else
		 {
			 element.value="";
			 alert("La c\xe9dula NO corresponde a ninguna provincia del Ecuador.!!!");
			 if(form == 0){
					document.getElementById("txtNombres_usuario").value="";
					document.getElementById("txtUser_name").value="";
				}
			 document.getElementById(element.name).focus();
			 return false;
		  }
		}
	 else
	 {
		element.value="";
		alert("La c\xe9dula no puede tener menos de 10 d\xedgitos");
		if(form == 0){
			document.getElementById("txtNombres_usuario").value="";
			document.getElementById("txtUser_name").value="";
		}
		document.getElementById(element.name).focus();
		return false;
	}
	}else{
	//alert("Ingrese numero de c\xe9dula");
	document.getElementById(element.name).focus();
	if(form == 0){
		document.getElementById("txtNombres_usuario").value="";
		document.getElementById("txtUser_name").value="";
	}
	return false;
	}
}


function fn(form,field,e)
{
	var key=e.keyCode || e.which;
	var next=0;
	var found=false;
	var f=form;
	if(key!=13) return;	
	for(var i=0;i<f.length;i++)	{
		if(field.name==f.elements[i].name){
			if(field.type == "radio")
				next=i+2;
			else
				next=i+1;
			
			found=true;
			break;
			return;
		}
	}
	while(found){
		if( f.elements[next].disabled==false &&  f.elements[next].type!='hidden'){
			f.elements[next].focus();
			break;
		}
		else{
			if(next<f.length-1)
				next=next+1;
			else
				break;
		}
	}
}

function regresar()
{
	//window.location.href="../../menu/mainMenu.php";
	window.location.href="index.php";
}

function cerrarVentana()
{ 
	opener.location.reload();
	window.close();
} 


function checkTipoUsuarioporCedula(cedula)
{
	//alert("checkNombresByCedula="+cedula);
	var ajax=nuevoAjax();
	ajax.open("GET", "../../clases/checkNombresByCedula.php?cedula="+cedula+"&type=checkTipoUsuarioporCedula",true);	
	ajax.onreadystatechange=function() 
	{ 
		if (ajax.readyState==1)
		{			
			document.getElementById("Div_TipoUsuario").innerHTML = '<img src="../images/cargando.gif">';
		}
		if (ajax.readyState==4)
		{
			document.getElementById("Div_TipoUsuario").parentNode.innerHTML=ajax.responseText;
		} 
	}
	ajax.send(null);
}

function checkNombresporCedula(cedula)
{
	//alert("checkNombresByCedula="+cedula);
	var ajax=nuevoAjax();
	ajax.open("GET", "../../clases/checkNombresByCedula.php?cedula="+cedula+"&type=checkNombresByCedula",true);	
	ajax.onreadystatechange=function() 
	{ 
		if (ajax.readyState==1)
		{			
			document.getElementById("Div_Nombre").innerHTML = '<img src="../images/cargando.gif">';
		}
		if (ajax.readyState==4)
		{
			document.getElementById("Div_Nombre").parentNode.innerHTML=ajax.responseText;
		} 
	}
	ajax.send(null);
}

function cedulaRepetida(cedula,responsable, type)
{
	//alert("observaciones="+$("#txtObservaciones").val());
	var ajax=nuevoAjax();
	ajax.open("GET", "../../clases/ExisteCedula.php?cedula="+cedula+"&caducidad_licencia="+$("#txtCaducidad_licencia").val()+"&puntos_licencia="+$("#txtPuntos_licencia").val()+"&fecha_vacaciones="+$("#txtFecha_vacaciones").val()+"&observaciones="+$("#txtObservaciones").val()+"&responsable="+responsable+"&type="+type,true);	
	ajax.onreadystatechange=function() 
	{ 
		if (ajax.readyState==1)
		{			
			document.getElementById("Div_Informacion").innerHTML = '<img src="../images/cargando.gif">';
		}
		if (ajax.readyState==4)
		{
			document.getElementById("Div_Informacion").parentNode.innerHTML=ajax.responseText;
			txtFecha_vacaciones();
			txtCaducidad_licencia();
			
			//alert("type="+type);
			if(type == 1)//para editar
			{
				document.getElementById("txtCi_funcionario").disabled="disabled";
				document.getElementById("txtValidate").value = "true";
			}
			else//para insertar
			{
				document.getElementById("txtCi_funcionario").disabled="";
				document.getElementById("txtValidate").value = "false";
				document.getElementById("txtCaducidad_licencia").value= "";
				document.getElementById("txtPuntos_licencia").value= "";
				document.getElementById("txtFecha_vacaciones").value= "";
				document.getElementById("txtObservaciones").value= "";
			}
		
		} 
	}
	ajax.send(null);

}

//formato fecha
function txtCaducidad_licencia()
{
	return $( "#txtCaducidad_licencia" ).datepicker({ appendText: '(aaaa-mm-dd)', 
											dateFormat: 'yy-mm-dd',
											changeMonth: true,
											changeYear: true,
											yearRange: '2000:2050',
											dayNamesMin :['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
											monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
											monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'] });
}

//formato fecha
function txtFecha_vacaciones()
{
	return $( "#txtFecha_vacaciones" ).datepicker({ appendText: '(aaaa-mm-dd)', 
											dateFormat: 'yy-mm-dd',
											changeMonth: true,
											changeYear: true,
											yearRange: '2000:2050',
											dayNamesMin :['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
											monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
											monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'] });
}


function validarKilometrajeFinal()
{
	//alert("validarKilometrajeFinal");
	var kilom_inicial;
	var kilom_final;
	kilom_inicial = document.getElementById("txtKilometraje_Final").value;
	kilom_final = document.getElementById("txtKilometraje").value;
	//alert(kilom_inicial+ " , "+kilom_final);
	if (parseInt(kilom_final) <= parseInt(kilom_inicial))
	{
		document.getElementById("txtKilometraje").focus();
		alert("El kilometraje final debe ser mayor al kilomentraje inicial");
		document.getElementById("txtKilometraje").value = "";
		return false;
		
	}else{return true;}
}