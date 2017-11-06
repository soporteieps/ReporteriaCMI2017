<?php
	 include("../lib/dbconfig.php");
	 include("consulta_indicadores.php");
	 
	 $cod_indicador = $_GET['cod_indicador'];
	 $cod_mes = $_GET['cod_mes'];
	 $cod_zona = $_GET['cod_zona'];
	 
	$consulta="select iz.cod_zona,i.cod_indicador,i.indicador from indicador i 
	inner join indicador_zona iz on(i.cod_indicador = iz.cod_indicador and i.departamento = 'FA')";
	//FILTRO POR ZONA
	 if($cod_zona != -1)
		{$consulta = $consulta." and iz.cod_zona = $cod_zona";}
	//FILTRO POR INDICADOR
	 if($cod_indicador != -1)	
		{$consulta = $consulta." and i.cod_indicador = $cod_indicador";}	
	
	//echo $consulta . "<br>";	
	$result=query($consulta);
	echo "<table id='reporte' border='1'>
	<tr>
		<th bgcolor='#8DB4E3'></th>
		<th bgcolor='#8DB4E3'></th>
		<th bgcolor='#8DB4E3'></th>";
	if($cod_mes == -1)
	{
		echo "<th colspan='13' bgcolor='#8DB4E3'>META PROGRAMADA</th>
			  <th colspan='13' bgcolor='#8DB4E3'>META EJECUTADA</th>";

	  $consulta_meses="select valor from catalogo where tipo ='meses'";
	}
	else
	{
		echo "<th colspan='2' bgcolor='#8DB4E3'>META PROGRAMADA</th>
		      <th colspan='2' bgcolor='#8DB4E3'>META EJECUTADA</th>";
	  $consulta_meses="select valor from catalogo where tipo ='meses' and codigo = $cod_mes";
	}
			
	echo "</tr>
	<tr>
		<th align='left'  bgcolor='#8DB4E3'>Nº</th>
		<th align='left'  bgcolor='#8DB4E3'>INDICADORES N4</th>
		<th align='center' bgcolor='#8DB4E3'>DIRECCIÓN ZONAL</th>";
		//DIBUJA TODAS LOS MESES
		if($cod_mes == -1)
		{
			$result_meses=query($consulta_meses);
			while($mes_aux1=mysql_fetch_object($result_meses))
			{		
				echo '<th width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>'.strtoupper(substr($mes_aux1->valor,0,3)).'</left></strong></font></th>';
			}
				echo '<th width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>TOTAL METAS</left></strong></font></th>';
			$result_meses1=query($consulta_meses);
			while($mes_aux2=mysql_fetch_object($result_meses1))
			{		
				echo '<th width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>'.strtoupper(substr($mes_aux2->valor,0,3)).'</left></strong></font></th>';
			}
				echo '<th width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>TOTAL METAS</left></strong></font></th>';
		}
		//DIBUJA EL MES SELECCIONADO
		else
		{
			$result_meses=query($consulta_meses);
			while($mes_aux1=mysql_fetch_object($result_meses))
			{		
				echo '<th width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>'.strtoupper(substr($mes_aux1->valor,0,3)).'</left></strong></font></th>';
			}
				echo '<th width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>TOTAL METAS</left></strong></font></th>';
			$result_meses1=query($consulta_meses);
			while($mes_aux2=mysql_fetch_object($result_meses1))
			{		
				echo '<th width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>'.strtoupper(substr($mes_aux2->valor,0,3)).'</left></strong></font></th>';
			}
				echo '<th width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>TOTAL METAS</left></strong></font></th>';
		}
		echo"</tr>";
	$contador = 1;
	while($row = mysql_fetch_array($result))
	  {	
        $cod_indicador_aux =  $row['cod_indicador'];
		$indicador = $row['indicador'];
		$zona = $row['cod_zona'];
		   
		echo '<tr>
			<td align="center" bgcolor="#93CDDD">'.$contador.'</td>
			<td class="descripcionIndicador" align="left" bgcolor="#93CDDD">'.$indicador.'</td>
			<td align="center" bgcolor="#D99795">Zona '.$zona.'</td>';
			echo meta_programada($zona,$cod_indicador_aux,$cod_mes);
			echo meta_ejecutada($zona,$cod_indicador_aux,$cod_mes);
		echo'</tr>';
		$contador = $contador + 1;  
	  }

echo "</table>";
?>

