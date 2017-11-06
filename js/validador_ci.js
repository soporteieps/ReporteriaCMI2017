function numerico()
{
	var key=window.event.keyCode;
	if (key < 48 || key > 57)
		{
		window.event.keyCode=0;
		document.form1.cod_usuario.value="";
		alert("Debe ingresar valores numéricos.");
		}
}

function check_cedula( cod_usuario )
{
	  var cedula = cod_usuario;
	  array = cedula.split( "" );
	  num = array.length;
	  if ( num == 10 )
	  {
		total = 0;
		digito = (array[9]*1);
		for( i=0; i < (num-1); i++ )
		{
		  mult = 0;
		  if ( ( i%2 ) != 0 ) {
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
		if ( ( final == 10 && digito == 0 ) || ( final == digito ) ) {
		  		  return true;
		}
		else
		{
		  alert( "La c\xe9dula NO es v\xe1lida!!!" );
		  document.form1.cod_usuario.focus();
		  document.form1.cod_usuario.value="";
		  return false;
		}
	  }
	  else
	  {
	  	document.form1.cod_usuario.value="";
		document.form1.cod_usuario.focus();
		alert("La c\xe9dula no puede tener menos de 10 d\xedgitos");
		return false;
	  }
}
