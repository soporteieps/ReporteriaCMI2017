<!DOCTYPE html>
<?php


/*******************
* variables
*******************/
$orgSocios = array();
$eventosAsistentes = array();
$nombresIndicadores = array();
$codIndicadores = array();
$totalVentas = 0;
$nombresMes  = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');

function getAnioSeleccionado()
{	
	$anioCurso = $_GET['anio'];
	
	return $anioCurso;
}

function getIndicador()
{
	$codIndicador = $_GET['indicador'];
	return $codIndicador;
}

function getMes()
{
	$codMes = $_GET['mes'];
	return $codMes;
}

function getZona()
{
	$codZona = $_GET['zona'];
	return $codZona;
}

function getNombresIndicadores()
{
	global $codIndicadores, $nombresIndicadores;
	$sqlNombresIndicadores = "select cod_indicador, indicador from indicador where estado = 1 and departamento = 'IM' order by cod_indicador";
	$resNombresIndicadores = query($sqlNombresIndicadores);
	while($fila = mysql_fetch_array($resNombresIndicadores))
	{
		array_push($codIndicadores, $fila['cod_indicador']);
		array_push($nombresIndicadores, $fila['indicador']);
	}
}

function print_r2($val)
{
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}

function getHeaderTablaIndicador($indicadorSeleccionado)
{
	$tHeader = '';


	switch($indicadorSeleccionado)
	{
		case 17:
		{
			//echo $indicadorSeleccionado . "<br>";
			$tHeader = "<tr class='cabecera'>
							<th>INDICE</th>
							<th>ZONA</th>
							<th>PROVINCIA</th>
							<th>CANTÓN</th>
							<th>MES REPORTE</th>
							<th>ENTIDAD CONTRATANTE</th>
							<th>FECHA ADJUDICACIÓN DEL CONTRATO</th>
							<th>CÓDIGO DEL PROCESO</th>
							<th>CÓDIGO CPC</th>
							<th>MONTO DE CONTRATACIÓN</th>
							<th>TIPO ENTIDAD CONTRATANTE</th>
							<th>NOMBRE ENTIDAD CONTRATANTE</th>
							<th>SECTOR PRIORIZADO</th>
							<th>BIEN O SERVICIO CONTRATADO</th>
							<th>TIPO ORGANIZACION EPS</th>
							<th>CIRCUITO ECONOMICO</th>
							<th>NOMBRE DE LA ORGANIZACIÓN</th>
							<th>SIGLAS ORG</th>
							<th>RUC ORG</th>
							<th>NUM SOCIOS</th>
							<th>NUM EMPLEADOS</th>
							<th>NUEVA ORGANIZACIÓN</th>																				
						</tr>";
			break;
		}
		case 18:		
		{
			$tHeader = "<tr class='cabecera'>
							<th>INDICE</th>
							<th>ZONA</th>
							<th>PROVINCIA</th>
							<th>CANTÓN</th>
							<th>MES REPORTE</th>
							<th>ENTIDAD CONTRATANTE</th>
							<th>FECHA ADJUDICACIÓN DEL CONTRATO</th>
							<th>CÓDIGO DEL PROCESO</th>
							<th>CÓDIGO CPC</th>
							<th>MONTO DE CONTRATACIÓN</th>
							<th>TIPO ENTIDAD CONTRATANTE</th>
							<th>NOMBRE ENTIDAD CONTRATANTE</th>
							<th>SECTOR PRIORIZADO</th>
							<th>BIEN O SERVICIO CONTRATADO</th>
							<th>TIPO ORGANIZACION EPS</th>
							<th>CIRCUITO ECONOMICO</th>
							<th>NOMBRE DE LA ORGANIZACIÓN</th>
							<th>SIGLAS ORG</th>
							<th>RUC ORG</th>
							<th>NUM SOCIOS</th>
							<th>NUM EMPLEADOS</th>
							<th>NUEVA ORGANIZACIÓN</th>
						</tr>";
			break;
		}

		case 19:
		case 20:
		case 24:
		{
			$tHeader = "<tr class='cabecera'>
							<th>INDICE</th>
							<th>ZONA</th>
							<th>PROVINCIA</th>
							<th>CANTÓN</th>
							<th>MES REPORTE</th>
							<th>ACOMPAÑAMIENTO / ASESORÍA EN EL PROCESO DE COMPRA PÚBLICA A INSTITUCIONES PÚBLICAS</th>
							<th>ACOMPAÑAMIENTO / ASESORÍA EN EL PROCESO DE COMPRA PÚBLICA INCLUSIVA A ORGANIZACIONES O UNIDADES EPS</th>
							<th>PARTICIPACIÓN EN EVENTOS DE COMERCIALIZACIÓN RED DE FERIAS SOMOS TUS MANOS ECUADOR</th>
							<th>PARTICIPACIÓN EN EVENTOS DE COMERCIALIZACIÓN RUEDA DE NEGOCIOS</th>
							<th>ASISTENCIA TÉCNICA EN PROCESOS COMERCIALES</th>							
							<th>RUC ORG</th>
							<th>ORGANIZACIÓN</th>
							<th>TIPO DE ORGANIZACIÓN EPS</th>
							<th>CIRCUITO ECONÓMICO</th>
							<th>CONTRATACION / SERVICIO</th>
							<th>COD CONTRATACION / COD SERVICIO</th>
							<th>ENTIDAD CONTRATANTE</th>							
							<th>NUM SOCIOS</th>
							<th>NUM EMPLEADOS</th>																					
						</tr>";
			break;
		}

		

		
		case 21:
		case 23:
		{
			$tHeader = "<tr class='cabecera'>
							<th>INDICE</th>
							<th>CÉDULA</th>
							<th>VALIDACIÓN</th>
							<th>GÉNERO</th>
							<th>APELLIDOS Y NOMBRES</th>
							<th>ETNIA</th>
							<th>ESTATUS</th>
							<th>DISCAPACIDAD</th>
							<th>SECTOR</th>
							<th>SECTOR PRIORIZADO</th>
							<th>BIEN O SERVICIO</th>
							<th>ADJUDICADO</th>
							<th>MES REPORTE</th>
							<th>ORGANIZACIÓN</th>
							<th>CDMP</th>
							<th>ZONA</th>
							<th>PROVINCIA</th>
							<th>ACOMPAÑAMIENTO / ASESORÍA EN EL PROCESO DE COMPRA PÚBLICA A INSTITUCIONES PÚBLICAS</th>
							<th>ACOMPAÑAMIENTO / ASESORÍA EN EL PROCESO DE COMPRA PÚBLICA INCLUSIVA A ORGANIZACIONES O UNIDADES EPS</th>
							<th>PARTICIPACIÓN EN EVENTOS DE COMERCIALIZACIÓN RED DE FERIAS SOMOS TUS MANOS ECUADOR</th>
							<th>PARTICIPACIÓN EN EVENTOS DE COMERCIALIZACIÓN RUEDA DE NEGOCIOS</th>
							<th>ASISTENCIA TÉCNICA EN PROCESOS COMERCIALES</th>
							<th>CIRCUITO ECONÓMICO</th>
							<th>TIPO DE ORGANIZACIÓN</th>
							<th>MERCADO</th>
							<th>RUC ORGANIZACIÓN / UEP</th>
							<th>NOMBRE ORGANIZACIÓN / UEP</th>
							<th>ORGANIZACIÓN NUEVA</th>
							<th>TIPO SERVICIO - CONTRATACIÓN</th>
							<th>CODIGO SERVICIO - CONTRATACIÓN</th>
						</tr>";
			break;
		}

		case 22:
		{
			$tHeader = "<tr class='cabecera'>
							<th>INDICE</th>
							<th>ZONA</th>
							<th>COD CONTRATACION / COD SERVICIO</th>
							<th>CONTRATACION / SERVICIO</th>
							<th>ENTIDAD CONTRATANTE</th>
							<th>RUC</th>
							<th>ORGANIZACIÓN</th>
							<th>TIPO ORG</th>
							<th>CIRCUITO ECONOMICO</th>							
							<th>NUM SOCIOS</th>
							<th>NUM EMPLEADOS</th>							
							<th>MES REPORTE</th>							
						</tr>";
			break;
		}

		
		

		case 0:
		{
			$tHeader = "<tr class='cabecera'>
							<th>INDICE</th>
							<th>CÉDULA</th>
							<th>VALIDACIÓN</th>
							<th>GÉNERO</th>
							<th>APELLIDOS Y NOMBRES</th>
							<th>ETNIA</th>
							<th>ESTATUS</th>
							<th>DISCAPACIDAD</th>
							<th>SECTOR</th>
							<th>SECTOR PRIORIZADO</th>
							<th>BIEN O SERVICIO</th>
							<th>ADJUDICADO</th>
							<th>MES REPORTE</th>
							<th>ORGANIZACIÓN</th>
							<th>CDMP</th>
							<th>ZONA</th>
							<th>PROVINCIA</th>
							<th>ACOMPAÑAMIENTO / ASESORÍA EN EL PROCESO DE COMPRA PÚBLICA A INSTITUCIONES PÚBLICAS</th>
							<th>ACOMPAÑAMIENTO / ASESORÍA EN EL PROCESO DE COMPRA PÚBLICA INCLUSIVA A ORGANIZACIONES O UNIDADES EPS</th>
							<th>PARTICIPACIÓN EN EVENTOS DE COMERCIALIZACIÓN RED DE FERIAS SOMOS TUS MANOS ECUADOR</th>
							<th>PARTICIPACIÓN EN EVENTOS DE COMERCIALIZACIÓN RUEDA DE NEGOCIOS</th>
							<th>ASISTENCIA TÉCNICA EN PROCESOS COMERCIALES</th>
							<th>CIRCUITO ECONÓMICO</th>
							<th>TIPO DE ORGANIZACIÓN</th>
							<th>MERCADO</th>
							<th>RUC ORGANIZACIÓN / UEP</th>
							<th>NOMBRE ORGANIZACIÓN / UEP</th>
							<th>ORGANIZACIÓN NUEVA</th>
							<th>TIPO SERVICIO - CONTRATACIÓN</th>
							<th>CODIGO SERVICIO - CONTRATACIÓN</th>
						</tr>";
			break;
		}

		case 1:
		{
			$tHeader = "<tr class='cabecera'>
							<th>INDICE</th>
							<th>SECTOR</th>
							<th>MONTO</th>							
						</tr>";
			break;
		}

		case 2:
		{
			$tHeader = "<tr class='cabecera'>
							<th>INDICE</th>
							<th>PROVINCIA</th>
							<th>MONTO</th>							
						</tr>";
			break;
		}
		case 7:
		{
			$tHeader = "<tr class='cabecera'>
							<th colspan='4'>MERCADO PÚBLICO Y PRIVADO 2010 A " . $nombreMes[getMes() - 1] . " " . getAnioSeleccionado() . "</th>
						</tr>
						<tr class='cabecera'>
							<th>AÑO</th>
							<th>PÚBLICO</th>
							<th>PRIVADO</th>
							<th>MONTO</th>
						</tr>";
			break;
		}

		


	}
	return $tHeader;
}

function CrearDetalleIndicador()
{
	global $codIndicadores, $nombresIndicadores, $totalVentas;
	$anioInd = getAnioSeleccionado();
	$mesInd = getMes();
	$zonaInd = getZona();
	$indSeleccionado = getIndicador();
	getNombresIndicadores();
	$tabla = "";

	// Indicador 5.1
	if($indSeleccionado == $codIndicadores[0])
	{
		$resDetalle = Indicador01($zonaInd, $mesInd);

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 22)
		{
			$tabla .= "<tr>
							<td>" .$resDetalle[$i] . "</td>
							<td>" .$resDetalle[$i + 1] . "</td>
							<td>" .$resDetalle[$i + 2] . "</td>
							<td>" .$resDetalle[$i + 3] . "</td>
							<td>" .$resDetalle[$i + 4] . "</td>
							<td>" .$resDetalle[$i + 5] . "</td>
							<td>" .$resDetalle[$i + 6] . "</td>
							<td>" .$resDetalle[$i + 7] . "</td>
							<td>" .$resDetalle[$i + 8] . "</td>
							<td>" .$resDetalle[$i + 9] . "</td>
							<td>" .$resDetalle[$i + 10] . "</td>
							<td>" .$resDetalle[$i + 11] . "</td>
							<td>" .$resDetalle[$i + 12] . "</td>
							<td>" .$resDetalle[$i + 13] . "</td>
							<td>" .$resDetalle[$i + 14] . "</td>
							<td>" .$resDetalle[$i + 15] . "</td>
							<td>" .$resDetalle[$i + 16] . "</td>
							<td>" .$resDetalle[$i + 17] . "</td>
							<td>" .$resDetalle[$i + 18] . "</td>
							<td>" .$resDetalle[$i + 19] . "</td>
							<td>" .$resDetalle[$i + 20] . "</td>
							<td>" .$resDetalle[$i + 21] . "</td>						
						</tr>";
		}

		$tabla .= "<tr>
						<td colspan='9'>TOTAL</td>
						<td>" . $totalVentas . "</td>
					<tr>";
		$tabla .= "</table>";
			
	}

	// Indicador 5.2
	if($indSeleccionado == $codIndicadores[1])
	{
		$resDetalle = Indicador02($zonaInd, $mesInd);

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 22)
		{
			$tabla .= "<tr>
							<td>" .$resDetalle[$i] . "</td>
							<td>" .$resDetalle[$i + 1] . "</td>
							<td>" .$resDetalle[$i + 2] . "</td>
							<td>" .$resDetalle[$i + 3] . "</td>
							<td>" .$resDetalle[$i + 4] . "</td>
							<td>" .$resDetalle[$i + 5] . "</td>
							<td>" .$resDetalle[$i + 6] . "</td>
							<td>" .$resDetalle[$i + 7] . "</td>
							<td>" .$resDetalle[$i + 8] . "</td>
							<td>" .$resDetalle[$i + 9] . "</td>
							<td>" .$resDetalle[$i + 10] . "</td>
							<td>" .$resDetalle[$i + 11] . "</td>
							<td>" .$resDetalle[$i + 12] . "</td>
							<td>" .$resDetalle[$i + 13] . "</td>
							<td>" .$resDetalle[$i + 14] . "</td>
							<td>" .$resDetalle[$i + 15] . "</td>
							<td>" .$resDetalle[$i + 16] . "</td>
							<td>" .$resDetalle[$i + 17] . "</td>
							<td>" .$resDetalle[$i + 18] . "</td>
							<td>" .$resDetalle[$i + 19] . "</td>
							<td>" .$resDetalle[$i + 20] . "</td>
							<td>" .$resDetalle[$i + 21] . "</td>
						</tr>";
		}

		$tabla .= "<tr>
						<td colspan='9'>TOTAL</td>
						<td>" . $totalVentas . "</td>
					<tr>";
		$tabla .= "</table>";
		
	}

	// Indicador 5.5
	if($indSeleccionado == $codIndicadores[2])
	{
		$resDetalle = Indicador03($zonaInd, $mesInd);

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 19)
		{
			$tabla .= "<tr>
							<td>" . $resDetalle[$i] . "</td>
							<td>" . $resDetalle[$i + 1] . "</td>
							<td>" . $resDetalle[$i + 2] . "</td>
							<td>" . $resDetalle[$i + 3] . "</td>
							<td>" . $resDetalle[$i + 4] . "</td>
							<td>" . $resDetalle[$i + 5] . "</td>
							<td>" . $resDetalle[$i + 6] . "</td>
							<td>" . $resDetalle[$i + 7] . "</td>
							<td>" . $resDetalle[$i + 8] . "</td>
							<td>" . $resDetalle[$i + 9] . "</td>
							<td>" . $resDetalle[$i + 10] . "</td>
							<td>" . $resDetalle[$i + 11] . "</td>
							<td>" . $resDetalle[$i + 12] . "</td>
							<td>" . $resDetalle[$i + 13] . "</td>
							<td>" . $resDetalle[$i + 14] . "</td>
							<td>" . $resDetalle[$i + 15] . "</td>
							<td>" . $resDetalle[$i + 16] . "</td>
							<td>" . $resDetalle[$i + 17] . "</td>
							<td>" . $resDetalle[$i + 18] . "</td>
						</tr>";
		}
		
		$tabla .= "</table>";
		
	}

	// Indicador 5.6

	if($indSeleccionado == $codIndicadores[3])
	{
		$resDetalle = Indicador04($zonaInd, $mesInd);

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 19)
		{
			$tabla .= "<tr>
							<td>" . $resDetalle[$i] . "</td>
							<td>" . $resDetalle[$i + 1] . "</td>
							<td>" . $resDetalle[$i + 2] . "</td>
							<td>" . $resDetalle[$i + 3] . "</td>
							<td>" . $resDetalle[$i + 4] . "</td>
							<td>" . $resDetalle[$i + 5] . "</td>
							<td>" . $resDetalle[$i + 6] . "</td>
							<td>" . $resDetalle[$i + 7] . "</td>
							<td>" . $resDetalle[$i + 8] . "</td>
							<td>" . $resDetalle[$i + 9] . "</td>
							<td>" . $resDetalle[$i + 10] . "</td>
							<td>" . $resDetalle[$i + 11] . "</td>
							<td>" . $resDetalle[$i + 12] . "</td>
							<td>" . $resDetalle[$i + 13] . "</td>
							<td>" . $resDetalle[$i + 14] . "</td>
							<td>" . $resDetalle[$i + 15] . "</td>
							<td>" . $resDetalle[$i + 16] . "</td>
							<td>" . $resDetalle[$i + 17] . "</td>
							<td>" . $resDetalle[$i + 18] . "</td>							
						</tr>";
		}
		
		$tabla .= "</table>";
		
	}

	// Indicador 5.7

	if($indSeleccionado == $codIndicadores[4])
	{
		$resDetalle = Indicador05($zonaInd, $mesInd);

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 30)
		{
			$tabla .= "<tr>
							<td>" . $resDetalle[$i] . "</td>
							<td>" . $resDetalle[$i + 1] . "</td>
							<td>" . $resDetalle[$i + 2] . "</td>
							<td>" . $resDetalle[$i + 3] . "</td>
							<td>" . $resDetalle[$i + 4] . "</td>
							<td>" . $resDetalle[$i + 5] . "</td>
							<td>" . $resDetalle[$i + 6] . "</td>
							<td>" . $resDetalle[$i + 7] . "</td>
							<td>" . $resDetalle[$i + 8] . "</td>
							<td>" . $resDetalle[$i + 9] . "</td>
							<td>" . $resDetalle[$i + 10] . "</td>
							<td>" . $resDetalle[$i + 11] . "</td>
							<td>" . $resDetalle[$i + 12] . "</td>
							<td>" . $resDetalle[$i + 13] . "</td>
							<td>" . $resDetalle[$i + 14] . "</td>
							<td>" . $resDetalle[$i + 15] . "</td>
							<td>" . $resDetalle[$i + 16] . "</td>
							<td>" . $resDetalle[$i + 17] . "</td>
							<td>" . $resDetalle[$i + 18] . "</td>
							<td>" . $resDetalle[$i + 19] . "</td>
							<td>" . $resDetalle[$i + 20] . "</td>
							<td>" . $resDetalle[$i + 21] . "</td>
							<td>" . $resDetalle[$i + 22] . "</td>
							<td>" . $resDetalle[$i + 23] . "</td>
							<td>" . $resDetalle[$i + 24] . "</td>
							<td>" . $resDetalle[$i + 25] . "</td>
							<td>" . $resDetalle[$i + 26] . "</td>
							<td>" . $resDetalle[$i + 27] . "</td>
							<td>" . $resDetalle[$i + 28] . "</td>
							<td>" . $resDetalle[$i + 29] . "</td>
						</tr>";
		}
		
		$tabla .= "</table>";
		
	}

	// Indicador 5.8
	if($indSeleccionado == $codIndicadores[5])
	{
		$resDetalle = Indicador06($zonaInd, $mesInd);

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 12)
		{
			$tabla .= "<tr>
							<td>" . $resDetalle[$i] . "</td>
							<td>" . $resDetalle[$i + 1] . "</td>
							<td>" . $resDetalle[$i + 2] . "</td>
							<td>" . $resDetalle[$i + 3] . "</td>
							<td>" . $resDetalle[$i + 4] . "</td>
							<td>" . $resDetalle[$i + 5] . "</td>
							<td>" . $resDetalle[$i + 6] . "</td>
							<td>" . $resDetalle[$i + 7] . "</td>
							<td>" . $resDetalle[$i + 8] . "</td>
							<td>" . $resDetalle[$i + 9] . "</td>
							<td>" . $resDetalle[$i + 10] . "</td>
							<td>" . $resDetalle[$i + 11] . "</td>							
						</tr>";
		}
		
		$tabla .= "</table>";
		
	}

	// Indicador 5.9
	if($indSeleccionado == $codIndicadores[6])
	{
		$resDetalle = Indicador07($zonaInd, $mesInd);

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 30)
		{
			$tabla .= "<tr>
							<td>" . $resDetalle[$i] . "</td>
							<td>" . $resDetalle[$i + 1] . "</td>
							<td>" . $resDetalle[$i + 2] . "</td>
							<td>" . $resDetalle[$i + 3] . "</td>
							<td>" . $resDetalle[$i + 4] . "</td>
							<td>" . $resDetalle[$i + 5] . "</td>
							<td>" . $resDetalle[$i + 6] . "</td>
							<td>" . $resDetalle[$i + 7] . "</td>
							<td>" . $resDetalle[$i + 8] . "</td>
							<td>" . $resDetalle[$i + 9] . "</td>
							<td>" . $resDetalle[$i + 10] . "</td>
							<td>" . $resDetalle[$i + 11] . "</td>
							<td>" . $resDetalle[$i + 12] . "</td>
							<td>" . $resDetalle[$i + 13] . "</td>
							<td>" . $resDetalle[$i + 14] . "</td>
							<td>" . $resDetalle[$i + 15] . "</td>
							<td>" . $resDetalle[$i + 16] . "</td>
							<td>" . $resDetalle[$i + 17] . "</td>
							<td>" . $resDetalle[$i + 18] . "</td>
							<td>" . $resDetalle[$i + 19] . "</td>
							<td>" . $resDetalle[$i + 20] . "</td>
							<td>" . $resDetalle[$i + 21] . "</td>
							<td>" . $resDetalle[$i + 22] . "</td>
							<td>" . $resDetalle[$i + 23] . "</td>
							<td>" . $resDetalle[$i + 24] . "</td>
							<td>" . $resDetalle[$i + 25] . "</td>
							<td>" . $resDetalle[$i + 26] . "</td>
							<td>" . $resDetalle[$i + 27] . "</td>
							<td>" . $resDetalle[$i + 28] . "</td>
							<td>" . $resDetalle[$i + 29] . "</td>
						</tr>";
		}
		
		$tabla .= "</table>";
		
	}
	// Indicador 5.10
	if($indSeleccionado == $codIndicadores[7])
	{
		$resDetalle = Indicador08($zonaInd, $mesInd);

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 19)
		{
			$tabla .= "<tr>
							<td>" . $resDetalle[$i] . "</td>
							<td>" . $resDetalle[$i + 1] . "</td>
							<td>" . $resDetalle[$i + 2] . "</td>
							<td>" . $resDetalle[$i + 3] . "</td>
							<td>" . $resDetalle[$i + 4] . "</td>
							<td>" . $resDetalle[$i + 5] . "</td>
							<td>" . $resDetalle[$i + 6] . "</td>
							<td>" . $resDetalle[$i + 7] . "</td>
							<td>" . $resDetalle[$i + 8] . "</td>
							<td>" . $resDetalle[$i + 9] . "</td>
							<td>" . $resDetalle[$i + 10] . "</td>
							<td>" . $resDetalle[$i + 11] . "</td>
							<td>" . $resDetalle[$i + 12] . "</td>
							<td>" . $resDetalle[$i + 13] . "</td>
							<td>" . $resDetalle[$i + 14] . "</td>
							<td>" . $resDetalle[$i + 15] . "</td>
							<td>" . $resDetalle[$i + 16] . "</td>
							<td>" . $resDetalle[$i + 17] . "</td>
							<td>" . $resDetalle[$i + 18] . "</td>
						</tr>";
		}
		
		$tabla .= "</table>";
		
	}

	if($indSeleccionado == 0)
	{
		$resDetalle = ReporteGeneralActores($zonaInd, $mesInd);
		// print_r2($resDetalle);
		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);

		for($i = 0; $i < count($resDetalle); $i += 30)
		{
			$tabla .= "<tr>
							<td>" . $resDetalle[$i] . "</td>
							<td>" . $resDetalle[$i + 1] . "</td>
							<td>" . $resDetalle[$i + 2] . "</td>
							<td>" . $resDetalle[$i + 3] . "</td>
							<td>" . $resDetalle[$i + 4] . "</td>
							<td>" . $resDetalle[$i + 5] . "</td>
							<td>" . $resDetalle[$i + 6] . "</td>
							<td>" . $resDetalle[$i + 7] . "</td>
							<td>" . $resDetalle[$i + 8] . "</td>
							<td>" . $resDetalle[$i + 9] . "</td>
							<td>" . $resDetalle[$i + 10] . "</td>
							<td>" . $resDetalle[$i + 11] . "</td>
							<td>" . $resDetalle[$i + 12] . "</td>
							<td>" . $resDetalle[$i + 13] . "</td>
							<td>" . $resDetalle[$i + 14] . "</td>
							<td>" . $resDetalle[$i + 15] . "</td>
							<td>" . $resDetalle[$i + 16] . "</td>							
							<td>" . $resDetalle[$i + 17] . "</td>
							<td>" . $resDetalle[$i + 18] . "</td>
							<td>" . $resDetalle[$i + 19] . "</td>
							<td>" . $resDetalle[$i + 20] . "</td>
							<td>" . $resDetalle[$i + 21] . "</td>
							<td>" . $resDetalle[$i + 22] . "</td>	
							<td>" . $resDetalle[$i + 23] . "</td>	
							<td>" . $resDetalle[$i + 24] . "</td>	
							<td>" . $resDetalle[$i + 25] . "</td>	
							<td>" . $resDetalle[$i + 26] . "</td>	
							<td>" . $resDetalle[$i + 27] . "</td>	
							<td>" . $resDetalle[$i + 28] . "</td>
							<td>" . $resDetalle[$i + 29] . "</td>
						</tr>";
		}
		
		$tabla .= "</table>";
	}

	if($indSeleccionado >= 1 && $indSeleccionado <= 6)
	{

		
		$tabla = "<div class='table-responsive'>";
		$tabla .= "<div class='col-md-6'>";
		$tabla .= "<table class=''>";
		$tabla .= getHeaderTablaIndicador(1);
		$tabla .= GetMontos($mesInd, $anioInd, $indSeleccionado, 'sector');
		$tabla .= "</table>";
		$tabla .= "</div>";

		$tabla .= "<div class='col-md-6'>";
		$tabla .= "<table class=''>";
		$tabla .= getHeaderTablaIndicador(2); 
		$tabla .= GetMontos($mesInd, $anioInd, $indSeleccionado, 'provincia');
		$tabla .= "</table>";
		$tabla .= "</div>";
		$tabla .= "</div>";
	}

	if($indSeleccionado == 7)
	{

		
		$tabla = "<div class='table-responsive'>";
		$tabla .= "<div class='col-md-12'>";
		$tabla .= "<table class=''>";
		$tabla .= getHeaderTablaIndicador(7);
		$tabla .= GetMontos($mesInd, $anioInd, $indSeleccionado, 'general');
		$tabla .= "</table>";
		$tabla .= "</div>";

		
	}

	echo $tabla;




	//echo "Indicador = " . $indSeleccionado . ", año = " . $anioInd . ", mes= " . $mesInd . ", zona = " . $zonaInd . "<br>";
}

function getInfoOrganizacion($codOrganizacionConsultar)
{
	$aOrganizacion = array();
	if($codOrganizacionConsultar < 0)
	{
		array_push($aOrganizacion, 'NO TIENE');
		
		
	}
	else
	{
		$sqlInformacionOrganizacion = "select * from u_organizaciones where cod_u_organizaciones = " . $codOrganizacionConsultar;
		$resInformacionOrganizacion = query($sqlInformacionOrganizacion);
		while($filaOrganizacion = mysql_fetch_array($resInformacionOrganizacion))
		{						

			if($filaOrganizacion['tipo'] != '')
				array_push($aOrganizacion, $filaOrganizacion['tipo']);
			else
				array_push($aOrganizacion, 'NO TIENE');			

			
			// echo $filaOrganizacion['organizacion'] . "<br>";
		}
	}

	return $aOrganizacion;
}

function GetInformacionOrg($codOrgConsultar, $tipoInfo)
{
	$sqlInfoOrganizacion = "";
	$infoConsultada = "";
	if($tipoInfo == "tipoOrg")
	{
		$sqlInfoOrganizacion = "select tipo from u_organizaciones where cod_u_organizaciones = " . $codOrgConsultar;
		$resInfoOrganizacion = query($sqlInfoOrganizacion);

		while($row = mysql_fetch_array($resInfoOrganizacion))
		{
			$infoConsultada = $row['tipo'];			
		}
	}

	if($tipoInfo == "nombre")
	{
		$sqlInfoOrganizacion = "select organizacion from u_organizaciones where cod_u_organizaciones = " . $codOrgConsultar;
		$resInfoOrganizacion = query($sqlInfoOrganizacion);

		while($row = mysql_fetch_array($resInfoOrganizacion))
		{
			$infoConsultada = $row['organizacion'];			
		}
	}

	if($tipoInfo == "ruc")
	{
		$sqlInfoOrganizacion = "select ruc_definitivo, ruc_provisional from u_organizaciones where cod_u_organizaciones = " . $codOrgConsultar;
		$resInfoOrganizacion = query($sqlInfoOrganizacion);

		while($row = mysql_fetch_array($resInfoOrganizacion))
		{
			if($row['ruc_definitivo'] != "")
				$infoConsultada = $row['ruc_definitivo'];
			else
				$infoConsultada = $row['ruc_provisional'];			
		}
	}

	if($tipoInfo == "categoria")
	{
		$sqlInfoOrganizacion = "select categoria_actividad_mp from u_organizaciones where cod_u_organizaciones = " . $codOrgConsultar;
		$resInfoOrganizacion = query($sqlInfoOrganizacion);

		while($row = mysql_fetch_array($resInfoOrganizacion))
		{
			
			$infoConsultada = $row['categoria_actividad_mp'];
			
		}
	}

	if($tipoInfo == "actividad")
	{
		$sqlInfoOrganizacion = "select identificacion_actividad_mp from u_organizaciones where cod_u_organizaciones = " . $codOrgConsultar;
		$resInfoOrganizacion = query($sqlInfoOrganizacion);

		while($row = mysql_fetch_array($resInfoOrganizacion))
		{
			
			$infoConsultada = $row['identificacion_actividad_mp'];
			
		}
	}

	if($tipoInfo == "producto")
	{
		$sqlInfoOrganizacion = "select producto_servicio from u_organizaciones where cod_u_organizaciones = " . $codOrgConsultar;
		$resInfoOrganizacion = query($sqlInfoOrganizacion);

		while($row = mysql_fetch_array($resInfoOrganizacion))
		{
			
			$infoConsultada = $row['producto_servicio'];
			
		}
	}

	return $infoConsultada;

}

function Indicador01($zona, $mes)
{
	global $nombresIndicadores, $codIndicadoresArray, $totalVentas, $nombresMes;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();
	$resultadoFinal = array();

	//variables locales	
	$ventasMes = 0;
	$avanceMes = 0;
	$avanceEjecutadoAcumulado = 0;
	$avanceEjecutadoAnual = 0;
	$metaAcumulaEjecutada = 0;
	$metaAcumuladaProgramada = 0;
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$orgServicios = array(0, 0, 0, 0, 0); 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== PRIMER INDICADOR =======================*/
	/*MONTO EN VENTA DE ORGANIZACIONES Y UEPS AL MERCADO PÚBLICO*/

	

	//sql que consulta las ventas en el mes indicado
	$sqlVentasMesPub = "select sum(ic.monto_contratacion) as ventas from im_contratacion ic where month(ic.fecha_reporte) <= " . $mesInd . " and ic.cod_zona = ". $zonaInd . " and year(ic.fecha_registro) = " . $anioInd . " and ic.tipo_contrato = 'publica'";

	//echo $sqlVentasMesPub . "<br>";

	
	//ejecucion del sql
	
	$resVentasMesPub = query($sqlVentasMesPub);
	while($fila = mysql_fetch_array($resVentasMesPub))
	{
		$totalVentas = $fila['ventas'];
	}

	//echo $ventasMes . "<br>";

	//calculamos el avance mensual
	// $avanceMes = round(($ventasMes * 100) / $metaMes, 2);
	//echo $avanceMes . "<br>";

	//calcularemos las ventas acumuladas hasta el mes especificado
	$sqlVentasAcumuladas = "select cod_zona, cod_provincia, cod_canton, codigo_proceso, codigo_cpc, cod_tipo_entidad_contratante, cod_contratacion, tipo_contrato, cod_u_organizaciones, antiguedad, bien_servicio, categoria_actividad_mp, num_socios, num_empleados, fecha_adjudicacion, month(fecha_reporte) as mesReporte, monto_contratacion, cod_tipo_entidad_contratante, cod_entidad_contratante, circuito_economico from im_contratacion ic where month(ic.fecha_reporte) <= " . $mesInd . " and ic.cod_zona = ". $zonaInd . " and year(ic.fecha_reporte) = " . $anioInd . " and ic.tipo_contrato = 'publica'";

	//echo $sqlVentasAcumuladas . "<br>";
	$resVentasAcumuladas = query($sqlVentasAcumuladas);
	$indice = 0;
	while($filaVentas = mysql_fetch_array($resVentasAcumuladas))
	{
		$indice++;
		$codOrganizacion = $filaVentas['cod_u_organizaciones'];
		// añadimos la informacion a desplegar en el reporte
		array_push($resultadoFinal, $indice); // indice
		array_push($resultadoFinal, $filaVentas['cod_zona']); // zona
		//Obtenemos nombre provincia
		$provinciaOrg = GetNombreProvincia($filaVentas['cod_zona'], $filaVentas['cod_provincia']);
		array_push($resultadoFinal, $provinciaOrg);

		//Obtenemos el nombre del canton
		$cantonOrg = GetNombreCanton($filaVentas['cod_provincia'], $filaVentas['cod_canton']);
		array_push($resultadoFinal, $cantonOrg);

		// mes de reporte
		$mesDeReporte = $filaVentas['mesReporte'];
		array_push($resultadoFinal, $nombresMes[$mesDeReporte - 1]); // mes de reporte

		// obtenemos la informacion entidad contratante
		$entidadContratante = getEntidadContratante($filaVentas['cod_tipo_entidad_contratante'], $filaVentas['cod_entidad_contratante']);
		array_push($resultadoFinal, $entidadContratante); // nombre entidad contratante

		array_push($resultadoFinal, $filaVentas['fecha_adjudicacion']); // fecha adjudicacion
		array_push($resultadoFinal, $filaVentas['codigo_proceso']); // codigo proceso
		array_push($resultadoFinal, $filaVentas['codigo_cpc']); // codigo cpc
		array_push($resultadoFinal, $filaVentas['monto_contratacion']); // monto contratacion sin iva

		// Tipo Entidad Contratante
		$entidadTipo = GetTipoEntidadContratante($filaVentas['cod_tipo_entidad_contratante']);
		array_push($resultadoFinal, $entidadTipo);

		// obtenemos la informacion entidad contratante
		$entidadContratante = getEntidadContratante($filaVentas['cod_tipo_entidad_contratante'], $filaVentas['cod_entidad_contratante']);
		array_push($resultadoFinal, $entidadContratante); // nombre entidad contratante

		$categoriaMp = GetInformacionOrg($codOrganizacion, "categoria");
		array_push($resultadoFinal, $categoriaMp); // sector priorizado

		$bienServicio = GetInformacionOrg($codOrganizacion, "actividad");
		array_push($resultadoFinal, $bienServicio); // bien o servicio contratado

		// Tipo de Organizacion
		$codOrganizacion = $filaVentas['cod_u_organizaciones'];
		$tipoDeOrganizacion = GetInformacionOrg($codOrganizacion, "tipoOrg");
		array_push($resultadoFinal, $tipoDeOrganizacion);

		// circuito económico
		if($filaVentas['circuito_economico'] == -1)
			array_push($resultadoFinal, 'NO DEFINIDO');		
		else
			array_push($resultadoFinal, $filaVentas['circuito_economico']);


		//Nombre de la organizacion
		$nOrganizacion = GetInformacionOrg($codOrganizacion, "nombre");
		array_push($resultadoFinal, $nOrganizacion);

		// Siglas de la org
		array_push($resultadoFinal, "NO DEFINIDO");

		// Ruc de la organizacion
		$rucOrganizacion = GetInformacionOrg($codOrganizacion, "ruc");
		array_push($resultadoFinal, $rucOrganizacion);

		array_push($resultadoFinal, $filaVentas['num_socios']); // num socios		
		
		array_push($resultadoFinal, $filaVentas['num_empleados']); // num empleados

		array_push($resultadoFinal, $filaVentas['antiguedad']); // antiguedad

		
		
		
		
				
		

	}

	return $resultadoFinal;


}

function Indicador02($zona, $mes)
{
	global $nombresIndicadores, $codIndicadoresArray, $totalVentas, $nombresMes;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();
	$resultadoFinal = array();

	//variables locales	
	$ventasMes = 0;
	$avanceMes = 0;
	$avanceEjecutadoAcumulado = 0;
	$avanceEjecutadoAnual = 0;
	$metaAcumulaEjecutada = 0;
	$metaAcumuladaProgramada = 0;
	
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== PRIMER INDICADOR =======================*/
	/*MONTO EN VENTA DE ORGANIZACIONES Y UEPS AL MERCADO PÚBLICO*/

	

	//sql que consulta las ventas en el mes indicado
	$sqlVentasMesPub = "select sum(ic.monto_contratacion) as ventas from im_contratacion ic where month(ic.fecha_reporte) <= " . $mesInd . " and ic.cod_zona = ". $zonaInd . " and year(ic.fecha_registro) = " . $anioInd . " and ic.tipo_contrato = 'privada'";

	//echo $sqlVentasMesPub . "<br>";

	
	//ejecucion del sql
	
	$resVentasMesPub = query($sqlVentasMesPub);
	while($fila = mysql_fetch_array($resVentasMesPub))
	{
		$totalVentas = $fila['ventas'];
	}

	//echo $ventasMes . "<br>";

	//calculamos el avance mensual
	// $avanceMes = round(($ventasMes * 100) / $metaMes, 2);
	//echo $avanceMes . "<br>";

	//calcularemos las ventas acumuladas hasta el mes especificado
	$sqlVentasAcumuladas = "select cod_zona, cod_provincia, cod_canton, cod_contratacion, categoria_actividad_mp, circuito_economico, bien_servicio, fecha_adjudicacion, codigo_cpc, codigo_proceso, tipo_contrato, cod_u_organizaciones, antiguedad, num_socios, num_empleados, fecha_adjudicacion, month(fecha_reporte) as mesReporte, monto_contratacion, cod_tipo_entidad_contratante, cod_entidad_contratante from im_contratacion ic where month(ic.fecha_reporte) <= " . $mesInd . " and ic.cod_zona = ". $zonaInd . " and year(ic.fecha_reporte) = " . $anioInd . " and ic.tipo_contrato = 'privada'";

	//echo $sqlVentasAcumuladas . "<br>";
	$resVentasAcumuladas = query($sqlVentasAcumuladas);
	$indice = 0;
	while($filaVentas = mysql_fetch_array($resVentasAcumuladas))
	{
		$indice++;
		$codOrganizacion = $filaVentas['cod_u_organizaciones'];
		// añadimos la informacion a desplegar en el reporte
		array_push($resultadoFinal, $indice); // indice
		array_push($resultadoFinal, $filaVentas['cod_zona']); // zona

		//Obtenemos nombre provincia
		$provinciaOrg = GetNombreProvincia($filaVentas['cod_zona'], $filaVentas['cod_provincia']);
		array_push($resultadoFinal, $provinciaOrg);

		//Obtenemos el nombre del canton
		$cantonOrg = GetNombreCanton($filaVentas['cod_provincia'], $filaVentas['cod_canton']);
		array_push($resultadoFinal, $cantonOrg);

		$mesDeReporte = $filaVentas['mesReporte'];
		array_push($resultadoFinal, $nombresMes[$mesDeReporte - 1]); // mes reporte

		// obtenemos la informacion entidad contratante
		$entidadContratante = getEntidadContratante($filaVentas['cod_tipo_entidad_contratante'], $filaVentas['cod_entidad_contratante']);
		array_push($resultadoFinal, $entidadContratante); // nombre entidad contratante

		array_push($resultadoFinal, $filaVentas['fecha_adjudicacion']); // fecha adjudicacion
		array_push($resultadoFinal, $filaVentas['codigo_proceso']); // codigo proceso
		array_push($resultadoFinal, $filaVentas['codigo_cpc']); // codigo cpc
		array_push($resultadoFinal, $filaVentas['monto_contratacion']); // monto contratacion sin iva

		// Tipo Entidad Contratante
		$entidadTipo = GetTipoEntidadContratante($filaVentas['cod_tipo_entidad_contratante']);
		array_push($resultadoFinal, $entidadTipo);

		// obtenemos la informacion entidad contratante
		$entidadContratante = getEntidadContratante($filaVentas['cod_tipo_entidad_contratante'], $filaVentas['cod_entidad_contratante']);
		array_push($resultadoFinal, $entidadContratante); // nombre entidad contratante

		$categoriaMp = GetInformacionOrg($codOrganizacion, "categoria");
		array_push($resultadoFinal, $categoriaMp); // sector priorizado

		$bienServicio = GetInformacionOrg($codOrganizacion, "actividad");
		array_push($resultadoFinal, $bienServicio); // bien o servicio contratado

		// Tipo de Organizacion
		$codOrganizacion = $filaVentas['cod_u_organizaciones'];
		$tipoDeOrganizacion = GetInformacionOrg($codOrganizacion, "tipoOrg");
		array_push($resultadoFinal, $tipoDeOrganizacion);

		// circuito económico
		if($filaVentas['circuito_economico'] == -1)
			array_push($resultadoFinal, 'NO DEFINIDO');		
		else
			array_push($resultadoFinal, $filaVentas['circuito_economico']);

		//Nombre de la organizacion
		$nOrganizacion = GetInformacionOrg($codOrganizacion, "nombre");
		array_push($resultadoFinal, $nOrganizacion);

		// Siglas de la org
		array_push($resultadoFinal, "NO DEFINIDO");

		// Ruc de la organizacion
		$rucOrganizacion = GetInformacionOrg($codOrganizacion, "ruc");
		array_push($resultadoFinal, $rucOrganizacion);

		array_push($resultadoFinal, $filaVentas['num_socios']); // num socios		
		
		array_push($resultadoFinal, $filaVentas['num_empleados']); // num empleados

		array_push($resultadoFinal, $filaVentas['antiguedad']); // antiguedad

		
		





	}

	return $resultadoFinal;
}

function Indicador03($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadoresArray, $nombresMes;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	$resultadoFinal = array();
	$ventasMes = 0;
	$montoParticipacion = 0;
	$avanceMes = 0;
	$avanceEjecutadoAcumulado = 0;
	$avanceEjecutadoAnual = 0;
	$metaAcumulaEjecutada = 0;
	$metaAcumuladaProgramada = 0;
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)	
	$numOrgReportadas = 0; 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== TERCER INDICADOR =======================*/
	/*NÚMERO DE ORGANIZACIONES DE LA EPS QUE RECIBIERON AL MENOS UN SERVICIO DE LA DIRECCIÓN DE INTERCAMBIO Y MERCADOS*/

	
	
	for($i = 1; $i <= $mesInd; $i++)
	{
		$numOrgReportadas = RevisarOrgMes($zonaInd, $i, "org");

		// add to a $orgReportadasMes
		foreach($numOrgReportadas as $valor)
		{
			array_push($orgReportadasMes, $valor);
		}
	}

	// delete duplicate
	$orgReportadasMes = array_unique($orgReportadasMes);
	// reinicio el index del array
	$orgReportadasMes = array_values($orgReportadasMes);

	// print_r2($orgReportadasMes);

	$indice = 0;
	foreach($orgReportadasMes as $valor)
	{
		$indice++;
		

		// Se debe consultar el primer reporte registrado de la organizacion 
		// y se debe guardar si es contratacion o es servicio

		$codOrg = $valor;
		$sqlOrgContratacion = "select cod_contratacion, circuito_economico, num_socios, cod_provincia, cod_canton, tipo_contrato, cod_tipo_entidad_contratante, cod_entidad_contratante, month(fecha_reporte) as mesReporte, num_socios, num_empleados  from im_contratacion where cod_u_organizaciones = " . $codOrg . " and cod_zona = " . $zonaInd . " and year(fecha_reporte) = " . $anioInd . " and antiguedad = 'no' and se_reporta = 'si' order by cod_contratacion limit 1";
		//echo $sqlOrgContratacion . "<br />";

		$resOrgContratacion = query($sqlOrgContratacion);
		$numFilas = mysql_num_rows($resOrgContratacion);
		$mesContratacionServicio = 0;
		$codContratacionServicio = 0;
		$tipoContratacionServicio = 0;
		$entidadContratante = 0;
		$numSocios = 0;
		$numEmpleados = 0;
		$codProv = 0;
		$canton = 0;
		$servicioRegistrado = "";
		$tipoServicioRegistrado = "";
		$cEconomico = "";
		$numSocios = 0;

		if($numFilas == 1)
		{
			while($fila = mysql_fetch_array($resOrgContratacion))
			{
				$mesContratacionServicio = $fila['mesReporte'];
				$codContratacionServicio = $fila['cod_contratacion'];
				$tipoContratacionServicio = "Contratación - " . $fila['tipo_contrato'];
				$entidadContratante = getEntidadContratante($fila['cod_tipo_entidad_contratante'], $fila['cod_entidad_contratante']);
				$numSocios = $fila['num_socios'];
				$numEmpleados = $fila['num_empleados'];
				$codProv = $fila['cod_provincia'];
				$canton = $fila['cod_canton'];
				$asesoriaPublica = "no";
				$servicioRegistrado = "no";
				$tipoServicioRegistrado = "no";
				$cEconomico = $fila['circuito_economico'];
				$numSocios = $fila['num_socios'];

			}

			// Revisamos si existe un servicio anterior a la fecha de contratacion
			$sqlExisteServicio = "select * from im_servicios where cod_u_organizaciones = " . $codOrg . " and year(fecha_reporte) = " . $anioInd . " and antiguedad = 'no' and se_reporta = 'si' and month(fecha_reporte) < " . $mesContratacionServicio;

			$resExisteServicio = query($sqlExisteServicio);
			$numFilasServ = mysql_num_rows($resExisteServicio);
			if($numFilasServ > 0)
			{
				$sqlServicio = "select cod_servicio, cod_provincia, num_socios, circuito_economico, cod_canton, servicio, tipo_servicio, descripcion, tipo_servicio, month(fecha_reporte) as mesReporte, num_socios, num_empleados from im_servicios where cod_u_organizaciones = " . $codOrg . " and  year(fecha_reporte) = " . $anioInd . " and se_reporta = 'si' order by cod_servicio limit 1";
				$resServicio = query($sqlServicio);
				while($fila = mysql_fetch_array($resServicio))
				{
					// reemplazo los valores de contratacion
					$mesContratacionServicio = $fila['mesReporte'];
					$codContratacionServicio = $fila['cod_servicio'];
					$tipoContratacionServicio = "Servicio - " . $fila['servicio'] . " - " . $fila['tipo_servicio'];
					$entidadContratante = " - ";
					$numSocios = $fila['num_socios'];
					$numEmpleados = $fila['num_empleados'];
					$codProv = $fila['cod_provincia'];
					$canton = $fila['cod_canton'];
					// $asesoriaPublica = $fila['descripcion'];
					$asesoriaPublica = GetInformacionOrg($codOrg, "actividad");
					$servicioRegistrado = $fila['servicio'];
					$tipoServicioRegistrado = $fila['tipo_servicio'];
					$cEconomico = $fila['circuito_economico'];
					$numSocios = $fila['num_socios'];
				}
			}
		}
		else
		{
			// Al no haber contrataciones se revisa los servicios
			$sqlServicio = "select cod_servicio, cod_provincia, num_socios, cod_canton, servicio, tipo_servicio, month(fecha_reporte) as mesReporte, num_socios, num_empleados from im_servicios where cod_u_organizaciones = " . $codOrg . " and year(fecha_reporte) = " . $anioInd . " and se_reporta = 'si' order by cod_servicio limit 1";
			$resServicio = query($sqlServicio);			
			while($fila = mysql_fetch_array($resServicio))
			{
				// reemplazo los valores de contratacion
				$mesContratacionServicio = $fila['mesReporte'];
				$codContratacionServicio = $fila['cod_servicio'];
				$tipoContratacionServicio = "Servicio - " . $fila['servicio'] . " - " . $fila['tipo_servicio'];
				$entidadContratante = " - ";
				$numSocios = $fila['num_socios'];
				$numEmpleados = $fila['num_empleados'];
				$codProv = $fila['cod_provincia'];
				$canton = $fila['cod_canton'];
				// $asesoriaPublica = $fila['descripcion'];
				$asesoriaPublica = GetInformacionOrg($codOrg, "actividad");
				$servicioRegistrado = $fila['servicio'];
				$tipoServicioRegistrado = $fila['tipo_servicio'];
				$cEconomico = $fila['circuito_economico'];
				$numSocios = $fila['num_socios'];
			}
			
		}
		

		array_push($resultadoFinal, $indice);	// indice de la tabla
		array_push($resultadoFinal, $zonaInd);	// zona del reporte

		//Obtenemos la provincia		
		$provincia = GetNombreProvincia($zonaInd, $codProv);
		array_push($resultadoFinal, $provincia);

		// Obtenemos el cantón
		$canton = GetNombreCanton($codProv, $canton);
		array_push($resultadoFinal, $canton);

		// mes de reporte
		array_push($resultadoFinal, $nombresMes[$mesContratacionServicio - 1]);

		// revisamos que tipo de servicio se realizo
		//**************************************
		// SERVICIOS
		$asesoriaCompraPublica = "no"; // Acompañamiento / Asesoria en el proceso de compra pública a Instituciones públicas
		$asesoriaCompraOrg = "no";		// Acompañamiento / Asesoría en el proceso de compra pública inclusiva a organizaciones o unidades EPS
		$redFeriasSomos = "no";		//Participación en eventos de Comercialización Red de Ferias Somos Tus Manos Ecuador
		$comercializacionRuedasNegocio = "no";		//Participación en eventos de Comercialización Rueda de Negocios
		$asistenciaTecnica = "no";		// Asistencia Técnica en procesos comerciales
		//**************************************
		// echo $indice . '-' .$servicioRegistrado . " - " . $tipoServicioRegistrado . "<br>";
		if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "instituciones_publicas")
		{
			$asesoriaCompraPublica = "si";
		}
		if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "organizaciones_unidades_eps")
		{
			$asesoriaCompraOrg = "si";
		}
		if($servicioRegistrado == "asistencia_tecnica_comercial" && $tipoServicioRegistrado == "asistencia_tecnica")
		{
			$asistenciaTecnica = "si";
		}
		if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ferias")
		{
			$redFeriasSomos = "si";
		}
		if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ruedas_de_negocio")
		{
			$comercializacionRuedasNegocio = "si";
		}
		if($servicioRegistrado == "no" && $tipoServicioRegistrado == "no")
		{
			$asesoriaCompraPublica = "no"; // Acompañamiento / Asesoria en el proceso de compra pública a Instituciones públicas
			$asesoriaCompraOrg = "no";		// Acompañamiento / Asesoría en el proceso de compra pública inclusiva a organizaciones o unidades EPS
			$redFeriasSomos = "no";		//Participación en eventos de Comercialización Red de Ferias Somos Tus Manos Ecuador
			$comercializacionRuedasNegocio = "no";		//Participación en eventos de Comercialización Rueda de Negocios
			$asistenciaTecnica = "no";		// Asistencia Técnica en procesos comerciales			
		}

		array_push($resultadoFinal, $asesoriaCompraPublica);
		array_push($resultadoFinal, $asesoriaCompraOrg);
		array_push($resultadoFinal, $redFeriasSomos);
		array_push($resultadoFinal, $comercializacionRuedasNegocio);
		array_push($resultadoFinal, $asistenciaTecnica);

		// Ruc de la organizacion
		$rucOrganizacion = GetInformacionOrg($codOrg, "ruc");
		array_push($resultadoFinal, $rucOrganizacion);

		//Nombre de la organizacion
		$nOrganizacion = GetInformacionOrg($codOrg, "nombre");
		array_push($resultadoFinal, $nOrganizacion);

		// Tipo de Organizacion		
		$tipoDeOrganizacion = GetInformacionOrg($codOrg, "tipoOrg");
		array_push($resultadoFinal, $tipoDeOrganizacion);

		// circuito económico
		// echo $indice . ' - ' . $cEconomico . "<br>";
		if($cEconomico == -1 || $cEconomico == "")
			array_push($resultadoFinal, 'NO DEFINIDO');		
		else
			array_push($resultadoFinal, $cEconomico);


		array_push($resultadoFinal, $codContratacionServicio);	// codigo de la contratacion o servicio
		array_push($resultadoFinal, $tipoContratacionServicio);	// descripcion de contratacion o servicio
		array_push($resultadoFinal, $entidadContratante);	// entidad contratante
		
		array_push($resultadoFinal, $numSocios); // num socios
				
		// array_push($resultadoFinal, $numSocios);	// numero socios
		array_push($resultadoFinal, $numEmpleados);	// numero empleados
		


	}

	return $resultadoFinal;
}

function Indicador04($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadoresArray, $nombresMes;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	$resultadoFinal = array();
	$ventasMes = 0;
	$montoParticipacion = 0;
	$avanceMes = 0;
	$avanceEjecutadoAcumulado = 0;
	$avanceEjecutadoAnual = 0;
	$metaAcumulaEjecutada = 0;
	$metaAcumuladaProgramada = 0;
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)	
	$numOrgReportadas = 0; 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== TERCER INDICADOR =======================*/
	//NÚMERO DE UNIDADES ECONÓMICAS POPULARES - UEP QUE RECIBIERON AL MENOS UN SERVICIO DIRECCIÓN DE INTERCAMBIO Y MERCADOS

	
	
	for($i = 1; $i <= $mesInd; $i++)
	{
		$numOrgReportadas = RevisarOrgMes($zonaInd, $i, "uep");

		// add to a $orgReportadasMes
		foreach($numOrgReportadas as $valor)
		{
			array_push($orgReportadasMes, $valor);
		}
	}

	// delete duplicate
	$orgReportadasMes = array_unique($orgReportadasMes);
	// reinicio el index del array
	$orgReportadasMes = array_values($orgReportadasMes);

	$indice = 0;
	foreach($orgReportadasMes as $valor)
	{
		$indice++;
		

		// Se debe consultar el primer reporte registrado de la organizacion 
		// y se debe guardar si es contratacion o es servicio
		$mesContratacionServicio = 0;
		$codContratacionServicio = 0;
		$tipoContratacionServicio = 0;
		$entidadContratante = 0;
		$numSocios = 0;
		$numEmpleados = 0;
		$codProv = 0;
		$codCanton = 0;
		$servicioRegistrado = "";
		$tipoServicioRegistrado = "";
		$cEconomico = "";
		$asesoriaCompraPublica = "no";
		$asesoriaCompraOrg = "no";
		$redFeriasSomos = "no";
		$comercializacionRuedasNegocio = "no";
		$asistenciaTecnica = "no";

		$codOrg = $valor;
		$sqlOrgContratacion = "select cod_contratacion, cod_provincia, circuito_economico, cod_canton, tipo_contrato, cod_tipo_entidad_contratante, cod_entidad_contratante, month(fecha_reporte) as mesReporte, num_socios, num_empleados  from im_contratacion where cod_u_organizaciones = " . $codOrg . " and cod_zona = " . $zonaInd . " and year(fecha_reporte) = " . $anioInd . "  order by cod_contratacion limit 1";
		//echo $sqlOrgContratacion . "<br />";

		$resOrgContratacion = query($sqlOrgContratacion);
		$numFilas = mysql_num_rows($resOrgContratacion);

		if($numFilas == 1)
		{
			while($fila = mysql_fetch_array($resOrgContratacion))
			{
				$mesContratacionServicio = $fila['mesReporte'];
				$codContratacionServicio = $fila['cod_contratacion'];
				$tipoContratacionServicio = "Contratación - " . $fila['tipo_contrato'];
				$entidadContratante = getEntidadContratante($fila['cod_tipo_entidad_contratante'], $fila['cod_entidad_contratante']);
				$numSocios = $fila['num_socios'];
				$numEmpleados = $fila['num_empleados'];
				$codProv = $fila['cod_provincia'];
				$codCanton = $fila['cod_canton'];
				$servicioRegistrado = "no";
				$tipoServicioRegistrado = "no";
				$cEconomico = $fila['circuito_economico'];

				// echo $fila['tipo_contrato'] . "<br>";
				if($fila['tipo_contrato'] == 'publica')
				{
					$asesoriaCompraPublica = "no";
					$asesoriaCompraOrg = "si";
					$redFeriasSomos = "no";
					$comercializacionRuedasNegocio = "no";
					$asistenciaTecnica = "no";
				}
				else
				{
					$asesoriaCompraPublica = "no";
					$asesoriaCompraOrg = "no";
					$redFeriasSomos = "no";
					$comercializacionRuedasNegocio = "no";
					$asistenciaTecnica = "si";
				}
			}

			// Revisamos si existe un servicio anterior a la fecha de contratacion
			$sqlExisteServicio = "select * from im_servicios where cod_u_organizaciones = " . $codOrg . " and year(fecha_reporte) = " . $anioInd . " and antiguedad = 'no' and month(fecha_reporte) < " . $mesContratacionServicio;

			$resExisteServicio = query($sqlExisteServicio);
			$numFilasServ = mysql_num_rows($resExisteServicio);
			if($numFilasServ > 0)
			{
				$sqlServicio = "select cod_servicio, circuito_economico, cod_provincia, cod_canton, servicio, tipo_servicio, month(fecha_reporte) as mesReporte, num_socios, num_empleados from im_servicios where cod_u_organizaciones = " . $codOrg . " and year(fecha_reporte) = " . $anioInd . " order by cod_servicio limit 1";
				$resServicio = query($sqlServicio);
				while($fila = mysql_fetch_array($resServicio))
				{
					// reemplazo los valores de contratacion
					$mesContratacionServicio = $fila['mesReporte'];
					$codContratacionServicio = $fila['cod_servicio'];
					$tipoContratacionServicio = "Servicio - " . $fila['servicio'] . " - " . $fila['tipo_servicio'];
					$entidadContratante = " - ";
					$numSocios = $fila['num_socios'];
					$numEmpleados = $fila['num_empleados'];
					$codProv = $fila['cod_provincia'];
					$codCanton = $fila['cod_canton'];
					$servicioRegistrado = $fila['servicio'];
					$tipoServicioRegistrado = $fila['tipo_servicio'];
					$cEconomico = $fila['circuito_economico'];



					if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "instituciones_publicas")
					{
						$asesoriaCompraPublica = "si";
					}
					if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "organizaciones_unidades_eps")
					{
						$asesoriaCompraOrg = "si";
					}
					if($servicioRegistrado == "asistencia_tecnica_comercial" && $tipoServicioRegistrado == "asistencia_tecnica")
					{
						$asistenciaTecnica = "si";
					}
					if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ferias")
					{
						$redFeriasSomos = "si";
					}
					if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ruedas_de_negocio")
					{
						$comercializacionRuedasNegocio = "si";
					}					
				}
			}
		}
		else
		{
			// Al no haber contrataciones se revisa los servicios
			$sqlServicio = "select cod_servicio, cod_provincia, cod_canton, circuito_economico, servicio, tipo_servicio, month(fecha_reporte) as mesReporte, num_socios, num_empleados from im_servicios where cod_u_organizaciones = " . $codOrg . " and year(fecha_reporte) = " . $anioInd . " order by cod_servicio limit 1";
			$resServicio = query($sqlServicio);			
			while($fila = mysql_fetch_array($resServicio))
			{
				// reemplazo los valores de contratacion
				$mesContratacionServicio = $fila['mesReporte'];
				$codContratacionServicio = $fila['cod_servicio'];
				$tipoContratacionServicio = "Servicio - " . $fila['servicio'] . " - " . $fila['tipo_servicio'];
				$entidadContratante = " - ";
				$numSocios = $fila['num_socios'];
				$numEmpleados = $fila['num_empleados'];
				$codProv = $fila['cod_provincia'];
				$codCanton = $fila['cod_canton'];
				$servicioRegistrado = $fila['servicio'];
				$tipoServicioRegistrado = $fila['tipo_servicio'];
				$cEconomico = $fila['circuito_economico'];

				if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "instituciones_publicas")
				{
					$asesoriaCompraPublica = "si";
				}
				if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "organizaciones_unidades_eps")
				{
					$asesoriaCompraOrg = "si";
				}
				if($servicioRegistrado == "asistencia_tecnica_comercial" && $tipoServicioRegistrado == "asistencia_tecnica")
				{
					$asistenciaTecnica = "si";
				}
				if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ferias")
				{
					$redFeriasSomos = "si";
				}
				if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ruedas_de_negocio")
				{
					$comercializacionRuedasNegocio = "si";
				}
				
			}
			
		}
		

		array_push($resultadoFinal, $indice);	// indice de la tabla
		array_push($resultadoFinal, $zonaInd);	// zona del reporte

		//Obtenemos la provincia		
		$provincia = GetNombreProvincia($zonaInd, $codProv);
		array_push($resultadoFinal, $provincia);

		// Obtenemos el cantón
		$canton = GetNombreCanton($codProv, $codCanton);
		array_push($resultadoFinal, $canton);

		// mes de reporte
		array_push($resultadoFinal, $nombresMes[$mesContratacionServicio - 1]);

		// revisamos que tipo de servicio se realizo
		//**************************************
		// SERVICIOS		
		array_push($resultadoFinal, $asesoriaCompraPublica);
		array_push($resultadoFinal, $asesoriaCompraOrg);
		array_push($resultadoFinal, $redFeriasSomos);
		array_push($resultadoFinal, $comercializacionRuedasNegocio);
		array_push($resultadoFinal, $asistenciaTecnica);

		// Ruc de la organizacion
		$rucOrganizacion = GetInformacionOrg($codOrg, "ruc");
		array_push($resultadoFinal, $rucOrganizacion);

		//Nombre de la organizacion
		$nOrganizacion = GetInformacionOrg($codOrg, "nombre");
		array_push($resultadoFinal, $nOrganizacion);

		// Tipo de Organizacion		
		$tipoDeOrganizacion = GetInformacionOrg($codOrg, "tipoOrg");
		array_push($resultadoFinal, $tipoDeOrganizacion);

		// circuito económico
		// echo $indice . ' - ' . $cEconomico . "<br>";
		if($cEconomico == -1 || $cEconomico == "")
			array_push($resultadoFinal, 'NO DEFINIDO');		
		else
			array_push($resultadoFinal, $cEconomico);



		array_push($resultadoFinal, $codContratacionServicio);	// codigo de la contratacion o servicio
		array_push($resultadoFinal, $tipoContratacionServicio);	// descripcion de contratacion o servicio
		array_push($resultadoFinal, $entidadContratante);	// entidad contratante
		
		array_push($resultadoFinal, $numSocios);	// numero socios
		array_push($resultadoFinal, $numEmpleados);	// numero empleados		


	}

	return $resultadoFinal;
}

function Indicador05($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadoresArray, $nombresMes;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	$resultadoFinal = array();
	$ventasMes = 0;
	$montoParticipacion = 0;
	$avanceMes = 0;
	$avanceEjecutadoAcumulado = 0;
	$avanceEjecutadoAnual = 0;
	$metaAcumulaEjecutada = 0;
	$metaAcumuladaProgramada = 0;
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	
	$sociosRep = 0; 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== QUINTO INDICADOR =======================*/
	//NÚMERO DE PERSONAS QUE CONFORMAN LAS ORGANIZACIONES Y UEPS QUE HAN RECIBIDO AL MENOS UN SERVICIO DE LA DIM Y SE ENMARCAN EN LA ESTRATEGIA PARA EL CAMBIO DE LA MATRIZ PRODUCTIVA

	

	$sociosRep = RevisarSociosOrg($zonaInd, $mesInd);
	// print_r2($sociosRep);
	// echo "REVISAR SOCIOS ORG <BR>";

	// <tr class='cabecera'>
		// <th>INDICE</th>
		// <th>ZONA</th>
		// <th>COD CONTRATACION / COD SERVICIO</th>
		// <th>CONTRATACION / SERVICIO</th>
		// <th>RUC ORGANIZACION / UEP</th>
		// <th>ORGANIZACION / UEP</th>		
		// <th>CÉDULA</th>
		// <th>NOMBRE SOCIO</th>
		// <th>TIPO SOCIO / EMPLEADO</th>										
		// <th>MES REPORTE</th>							
	// </tr>

	$indice = 0;
	foreach($sociosRep as $valor)
	{
		$indice++;

		// Se debe buscar la primera y unico registro de la cedula
		$sqlSociosServiciosContrataciones = "select cod_im_contratacion_servicios_socios, cod_socios, cedula, cod_im_contratacion_servicios, cod_u_organizaciones, month(fecha_reporte) as mesReporte, tipo from im_contratacion_servicios_socios where cedula = '" . $valor . "' and year(fecha_reporte) = " . $anioInd . " order by cod_im_contratacion_servicios_socios asc";
		//echo $sqlSociosServiciosContrataciones . "<br />";
		$resSociosServiciosContrataciones = query($sqlSociosServiciosContrataciones);
		$codOrg = 0;
		$mesReporte = 0;
		$codServicioContratacion = 0;
		$tipoServicioContratacion = 0;
		$apellidosSocio = 0;
		$tipoSocio = 0;
		$infoOrg = array();
		$genero = 0;
		$grupoEtnico = "";
		$estatus = "";
		$bienServicio = "";
		$adjudicadoMonto = "";
		$codProv = "";
		$servicioRegistrado = "";
		$tipoServicioRegistrado = "";
		$cEconomico = "";
		$antiguedadOrg = "";
		$poblacion = "";
		$mercado = "";

		$asesoriaCompraPublica = "no"; // Acompañamiento / Asesoria en el proceso de compra pública a Instituciones públicas
		$asesoriaCompraOrg = "no";		// Acompañamiento / Asesoría en el proceso de compra pública inclusiva a organizaciones o unidades EPS
		$redFeriasSomos = "no";		//Participación en eventos de Comercialización Red de Ferias Somos Tus Manos Ecuador
		$comercializacionRuedasNegocio = "no";		//Participación en eventos de Comercialización Rueda de Negocios
		$asistenciaTecnica = "no";		// Asistencia Técnica en procesos comerciales

		while($filaServicioContratacion = mysql_fetch_array($resSociosServiciosContrataciones))
		{
			$codOrg = $filaServicioContratacion['cod_u_organizaciones'];
			$mesReporte = $filaServicioContratacion['mesReporte'];
			$codServicioContratacion = $filaServicioContratacion['cod_im_contratacion_servicios'];
			$tipoServicioContratacion = $filaServicioContratacion['tipo'];
			$bienServicio = GetInformacionOrg($codOrg, "actividad");
		}

		// Informacion de la organizacion
		$infoOrg = getInfoOrganizacion($codOrg);

		// Informacion del servicio o contratacion
		if($tipoServicioContratacion == 'c')
		{
			$sqlInfoContratacion = "select tipo_contrato, bien_servicio, cod_provincia, circuito_economico, antiguedad from im_contratacion where cod_contratacion = " . $codServicioContratacion . " and year(fecha_reporte) = " . $anioInd;
			$resInfoContratacion = query($sqlInfoContratacion);
			while($filaInfoContratacion = mysql_fetch_array($resInfoContratacion))
			{
				$tipoServicioContratacion = $filaInfoContratacion['tipo_contrato'];
				// $bienServicio = $filaInfoContratacion['bien_servicio'];
				// $bienServicio = GetInformacionOrg($codOrg, "actividad");
				$adjudicadoMonto = 0;
				$codProv = $filaInfoContratacion['cod_provincia'];
				$servicioRegistrado = "no";
				$tipoServicioRegistrado = "no";
				$cEconomico = $filaInfoContratacion['circuito_economico'];
				$antiguedadOrg = $filaInfoContratacion['antiguedad'];

				if($filaInfoContratacion['tipo_contrato'] == 'publica')
				{
					$asesoriaCompraPublica = "no";
					$asesoriaCompraOrg = "si";
					$redFeriasSomos = "no";
					$comercializacionRuedasNegocio = "no";
					$asistenciaTecnica = "no";
				}
				else
				{
					$asesoriaCompraPublica = "no";
					$asesoriaCompraOrg = "no";
					$redFeriasSomos = "no";
					$comercializacionRuedasNegocio = "no";
					$asistenciaTecnica = "si";
				}

				$mercado = $filaInfoContratacion['tipo_contrato'];


			}
		}
		else if($tipoServicioContratacion == 's')
		{
			$asesoriaCompraPublica = "no";
			$asesoriaCompraOrg = "no";
			$redFeriasSomos = "no";
			$comercializacionRuedasNegocio = "no";
			$asistenciaTecnica = "no";
			$sqlInfoServicios = "select servicio, descripcion, adjudicado, cod_provincia, servicio, tipo_servicio, circuito_economico, antiguedad from im_servicios where cod_servicio = " . $codServicioContratacion . " and year(fecha_reporte) = " . $anioInd;
			$resInfoServicios = query($sqlInfoServicios);
			while($filaInfoServicios = mysql_fetch_array($resInfoServicios))
			{
				$tipoServicioContratacion = $filaInfoServicios['servicio'];
				// $bienServicio = $filaInfoServicios['descripcion'];
				
				$adjudicadoMonto = $filaInfoServicios['adjudicado'];
				$codProv = $filaInfoServicios['cod_provincia'];
				$servicioRegistrado = $filaInfoServicios['servicio'];
				$tipoServicioRegistrado = $filaInfoServicios['tipo_servicio'];
				$cEconomico = $filaInfoServicios['circuito_economico'];
				$antiguedadOrg = $filaInfoServicios['antiguedad'];

				if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "instituciones_publicas")
				{
					$asesoriaCompraPublica = "si";
					$mercado = "publica";

				}
				if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "organizaciones_unidades_eps")
				{
					$asesoriaCompraOrg = "si";
					$mercado = "publica";
				}
				if($servicioRegistrado == "asistencia_tecnica_comercial" && $tipoServicioRegistrado == "asistencia_tecnica")
				{
					$asistenciaTecnica = "si";
					$mercado = "privada";
				}
				if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ferias")
				{
					$redFeriasSomos = "si";
					$mercado = "privada";
				}
				if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ruedas_de_negocio")
				{
					$comercializacionRuedasNegocio = "si";
					$mercado = "privada";
				}				
			}
		}

		// Info del socio
		$sqlInfoSocios = "select apellidos, socio_empleado, grupo_etnico, tipo_discapacidad, genero, poblacion from socios where cedula = '" . $valor . "' and cod_u_organizaciones = " . $codOrg . " group by cedula";
		$resInfoSocios = query($sqlInfoSocios);
		while($filaInfoSocios = mysql_fetch_array($resInfoSocios))
		{
			$apellidosSocio = $filaInfoSocios['apellidos'];
			$tipoSocio = $filaInfoSocios['socio_empleado'];
			$genero = $filaInfoSocios['genero'];
			$grupoEtnico = $filaInfoSocios['grupo_etnico'];
			$estatus = $filaInfoSocios['socio_empleado'];
			$tipoDiscapacidad = $filaInfoSocios['tipo_discapacidad'];
			$poblacion = $filaInfoSocios['poblacion'];

			if($estatus == "")
				$estatus = "NO DEFINIDO";

			if($tipoDiscapacidad == "")
				$tipoDiscapacidad = "NO";
		}




		array_push($resultadoFinal, $indice);	// indice
		array_push($resultadoFinal, $valor);// cedula socio

		//VALIDACIN
		array_push($resultadoFinal, " - ");

		// genero
		array_push($resultadoFinal, $genero);	

		array_push($resultadoFinal, $apellidosSocio);		// apellidos socio

		// grupo etnico
		array_push($resultadoFinal, $grupoEtnico);

		// estatus
		array_push($resultadoFinal, $estatus);

		// discapacidad
		array_push($resultadoFinal, $tipoDiscapacidad);

		// sector
		array_push($resultadoFinal, $poblacion);

		// actividad mp
		$categoria = GetInformacionOrg($codOrg, "categoria");
		array_push($resultadoFinal, $categoria);
		// $actividad = GetInformacionOrg($codOrg, "actividad");
		// array_push($resultadoFinal, $actividad);

		// BIEN O SERVICIO
		$bienServicio = GetInformacionOrg($codOrg, "actividad");
		array_push($resultadoFinal, $bienServicio);

		// adjudicado
		if($adjudicadoMonto == 0)
			array_push($resultadoFinal, 'no');
		else
			array_push($resultadoFinal, 'si');

		array_push($resultadoFinal, $nombresMes[$mesReporte - 1]);		// mesReporte

		// ES ORGANIZACION??
		$tipoDeOrganizacion = GetInformacionOrg($codOrg, "tipoOrg");
		if($tipoDeOrganizacion == 'org')
			array_push($resultadoFinal, 'si');
		else
			array_push($resultadoFinal, 'no');
		

		// categoria priorizada en la matriz productiva
		if($categoria == 'no_priorizado_en_el_cambio_matriz_productiva')
			array_push($resultadoFinal, 'no');
		else
			array_push($resultadoFinal, 'si');

		array_push($resultadoFinal, $zona);		// zona

		//Obtenemos la provincia		
		$provincia = GetNombreProvincia($zonaInd, $codProv);
		array_push($resultadoFinal, $provincia);

		// revisamos que tipo de servicio se realizo
		//**************************************
		// SERVICIOS

		array_push($resultadoFinal, $asesoriaCompraPublica);
		array_push($resultadoFinal, $asesoriaCompraOrg);
		array_push($resultadoFinal, $redFeriasSomos);
		array_push($resultadoFinal, $comercializacionRuedasNegocio);
		array_push($resultadoFinal, $asistenciaTecnica);

		// circuito económico
		// echo $indice . ' - ' . $cEconomico . "<br>";
		if($cEconomico == -1 || $cEconomico == "")
			array_push($resultadoFinal, 'NO DEFINIDO');		
		else
			array_push($resultadoFinal, $cEconomico);

		// Tipo de Organizacion		
		
		array_push($resultadoFinal, $tipoDeOrganizacion);

		array_push($resultadoFinal,$mercado); 	// MERCADO

		// RUC
		$rucOrg = GetInformacionOrg($codOrg, "ruc");
		array_push($resultadoFinal, $rucOrg);

		// Nombre de la organización
		$nombreOrg = GetInformacionOrg($codOrg, "nombre");
		array_push($resultadoFinal, $nombreOrg);

		// org nueva
		array_push($resultadoFinal, $antiguedadOrg);


		array_push($resultadoFinal, $tipoServicioContratacion); 	// tipo servicio o la contratacion
		array_push($resultadoFinal, $codServicioContratacion); 	// CODIGO DE CONTRATACION O SERVICIO
		// array_push($resultadoFinal, '');		// nombre organizacion				
		// array_push($resultadoFinal, $apellidosSocio);		// apellidos socio
		// array_push($resultadoFinal, $tipoSocio);		// tipo de socio		
		
		

		//print_r2($infoOrg);

	}

	
	return $resultadoFinal;	
}

function Indicador06($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadoresArray, $nombresMes;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	$resultadoFinal = array();
	$ventasMes = 0;
	$montoParticipacion = 0;
	$avanceMes = 0;
	$avanceEjecutadoAcumulado = 0;
	$avanceEjecutadoAnual = 0;
	$metaAcumulaEjecutada = 0;
	$metaAcumuladaProgramada = 0;
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	
	$circuitosEconomicos = 0; 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== SEXTO INDICADOR =======================*/
	/*NÚMERO DE CIRCUITOS ECONÓMICOS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DIRECCIÓN DE INTERCAMBIO Y MERCADOS*/


	$circuitosEconomicos = RevisarCircuitosEconomicos($zonaInd, $mesInd);
		
	$indice = 0;
	foreach($circuitosEconomicos as $valor)
	{
		$indice++;
		

		// Se debe consultar el primer reporte registrado de la organizacion 
		// y se debe guardar si es contratacion o es servicio

		$codOrg = $valor;
		$sqlOrgContratacion = "select cod_contratacion, tipo_contrato, cod_tipo_entidad_contratante, cod_entidad_contratante, month(fecha_reporte) as mesReporte, num_socios, num_empleados  from im_contratacion where cod_u_organizaciones = " . $codOrg . " and cod_zona = " . $zonaInd . " and year(fecha_reporte) = " . $anioInd . " and circuito_economico = 'si' order by cod_contratacion limit 1";
		// echo $sqlOrgContratacion . "<br />";

		$resOrgContratacion = query($sqlOrgContratacion);
		$numFilas = mysql_num_rows($resOrgContratacion);
		$mesContratacionServicio = 0;
		$codContratacionServicio = 0;
		$tipoContratacionServicio = 0;
		$entidadContratante = 0;
		$numSocios = 0;
		$numEmpleados = 0;

		if($numFilas == 1)
		{
			while($fila = mysql_fetch_array($resOrgContratacion))
			{
				$mesContratacionServicio = $fila['mesReporte'];
				$codContratacionServicio = $fila['cod_contratacion'];
				$tipoContratacionServicio = "Contratación - " . $fila['tipo_contrato'];
				$entidadContratante = getEntidadContratante($fila['cod_tipo_entidad_contratante'], $fila['cod_entidad_contratante']);
				$numSocios = $fila['num_socios'];
				$numEmpleados = $fila['num_empleados'];

			}

			// Revisamos si existe un servicio anterior a la fecha de contratacion
			$sqlExisteServicio = "select * from im_servicios where cod_u_organizaciones = " . $codOrg . " and circuito_economico = 'si' and year(fecha_reporte) = " . $anioInd . " and antiguedad = 'no' and month(fecha_reporte) < " . $mesContratacionServicio;

			$resExisteServicio = query($sqlExisteServicio);
			$numFilasServ = mysql_num_rows($resExisteServicio);
			if($numFilasServ > 0)
			{
				$sqlServicio = "select cod_servicio, servicio, tipo_servicio, month(fecha_reporte) as mesReporte, num_socios, num_empleados from im_servicios where cod_u_organizaciones = " . $codOrg . " and year(fecha_reporte) = " . $anioInd . " and circuito_economico = 'si' order by cod_servicio limit 1";
				$resServicio = query($sqlServicio);
				while($fila = mysql_fetch_array($resServicio))
				{
					// reemplazo los valores de contratacion
					$mesContratacionServicio = $fila['mesReporte'];
					$codContratacionServicio = $fila['cod_servicio'];
					$tipoContratacionServicio = "Servicio - " . $fila['servicio'] . " - " . $fila['tipo_servicio'];
					$entidadContratante = " - ";
					$numSocios = $fila['num_socios'];
					$numEmpleados = $fila['num_empleados'];
				}
			}
		}
		else
		{
			// Al no haber contrataciones se revisa los servicios
			$sqlServicio = "select cod_servicio, servicio, tipo_servicio, month(fecha_reporte) as mesReporte, num_socios, num_empleados from im_servicios where cod_u_organizaciones = " . $codOrg . " and year(fecha_reporte) = " . $anioInd . " and circuito_economico = 'si' order by cod_servicio limit 1";

			// echo $sqlServicio . "<br />";
			$resServicio = query($sqlServicio);			
			while($fila = mysql_fetch_array($resServicio))
			{
				// reemplazo los valores de contratacion
				$mesContratacionServicio = $fila['mesReporte'];
				$codContratacionServicio = $fila['cod_servicio'];
				$tipoContratacionServicio = "Servicio - " . $fila['servicio'] . " - " . $fila['tipo_servicio'];
				$entidadContratante = " - ";
				$numSocios = $fila['num_socios'];
				$numEmpleados = $fila['num_empleados'];
			}
			
		}
		

		array_push($resultadoFinal, $indice);	// indice de la tabla
		array_push($resultadoFinal, $zonaInd);	// zona del reporte
		array_push($resultadoFinal, $codContratacionServicio);	// codigo de la contratacion o servicio
		array_push($resultadoFinal, $tipoContratacionServicio);	// descripcion de contratacion o servicio
		array_push($resultadoFinal, $entidadContratante);	// entidad contratante
		// obtener la informacion de la organizacion
		$informacionOrg = getInfoOrganizacion($codOrg);
		// RUC
		$rucOrg = GetInformacionOrg($codOrg, "ruc");
		array_push($resultadoFinal, $rucOrg); // anadimos el ruc

		// Nombre de la organización
		$nombreOrg = GetInformacionOrg($codOrg, "nombre");
		array_push($resultadoFinal, $nombreOrg);

		// Tipo de Organizacion
		// ES ORGANIZACION??
		$tipoDeOrganizacion = GetInformacionOrg($codOrg, "tipoOrg");
		if($tipoDeOrganizacion == 'org')
			array_push($resultadoFinal, 'si');
		else
			array_push($resultadoFinal, 'no');		

		array_push($resultadoFinal, 'si');		
		array_push($resultadoFinal, $numSocios);	// numero socios
		array_push($resultadoFinal, $numEmpleados);	// numero empleados
		array_push($resultadoFinal, $nombresMes[$mesContratacionServicio - 1]);	// numero socios


	}
	
	

	return $resultadoFinal;

	
	
}

function Indicador07($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadoresArray, $nombresMes;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();	
	$montoParticipacion = 0;
	$avanceMes = 0;
	$avanceEjecutadoAcumulado = 0;
	$avanceEjecutadoAnual = 0;
	$metaAcumulaEjecutada = 0;
	$metaAcumuladaProgramada = 0;
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$resultadoFinal = array();
	$plazasTrabajo = 0; 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== SEPTIMO INDICADOR =======================*/
	/*NÚMERO DE PERSONAS DE LA EPS CON PLAZAS DE TRABAJO POR ACCESO PÚBLICO O PRIVADO*/

	$plazasTrabajo = RevisarPlazasTrabajo($zonaInd, $mesInd);

	//***************************************************
	// Caso Especial por pedido de Stefany Lopez
	// BORRAR EN EL 2018
	// echo $zona . " - -" . $mes . "<br>";
	if($zona == 1 && $mes == 2)
	{
		array_push($plazasTrabajo, '0502284243');
		array_push($plazasTrabajo, '1707550834');
		array_push($plazasTrabajo, '1711931723');
	}


	$plazasTrabajo = array_unique($plazasTrabajo);
	$plazasTrabajo = array_values($plazasTrabajo);

	// *********************************************************
	// print_r2($plazasTrabajo);

	$indice = 0;
	foreach($plazasTrabajo as $valor)
	{
		$indice++;

		// Se debe buscar la primera y unico registro de la cedula
		$sqlSociosServiciosContrataciones = "select cod_im_contratacion_servicios_socios, cod_socios, cedula, cod_im_contratacion_servicios, cod_u_organizaciones, month(fecha_reporte) as mesReporte, tipo from im_contratacion_servicios_socios where cedula = '" . $valor . "' and year(fecha_reporte) = " . $anioInd . " order by cod_im_contratacion_servicios_socios asc";
		//echo $sqlSociosServiciosContrataciones . "<br />";
		$resSociosServiciosContrataciones = query($sqlSociosServiciosContrataciones);
		$codOrg = 0;
		$mesReporte = 0;
		$codServicioContratacion = 0;
		$tipoServicioContratacion = 0;
		$apellidosSocio = 0;
		$tipoSocio = 0;
		$infoOrg = array();
		$genero = "";
		$gEtnico = "";
		$discapacidad = "";
		$tipoDiscapacidad = "";
		$poblacion = "";
		$bienServicio = "";
		$adjudicadoSocio = "";
		$cdmp = 0;
		$codProv = 0;
		$circutioEc = '';

		$asesoriaCompraPublica = "no";
		$asesoriaCompraOrg = "no";
		$redFeriasSomos = "no";
		$comercializacionRuedasNegocio = "no";
		$asistenciaTecnica = "no";

		$mercado = '';
		$nuevaOrg = '';

		while($filaServicioContratacion = mysql_fetch_array($resSociosServiciosContrataciones))
		{
			$codOrg = $filaServicioContratacion['cod_u_organizaciones'];
			$mesReporte = $filaServicioContratacion['mesReporte'];
			$codServicioContratacion = $filaServicioContratacion['cod_im_contratacion_servicios'];
			$tipoServicioContratacion = $filaServicioContratacion['tipo'];
		}

		// Informacion de la organizacion
		$infoOrg = getInfoOrganizacion($codOrg);

		// Informacion del servicio o contratacion
		if($tipoServicioContratacion == 'c')
		{
			$sqlInfoContratacion = "select tipo_contrato, bien_servicio, monto_contratacion, categoria_actividad_mp, antiguedad, cod_provincia, circuito_economico from im_contratacion where cod_contratacion = " . $codServicioContratacion . " and year(fecha_reporte) = " . $anioInd;
			$resInfoContratacion = query($sqlInfoContratacion);
			while($filaInfoContratacion = mysql_fetch_array($resInfoContratacion))
			{
				$tipoServicioContratacion = $filaInfoContratacion['tipo_contrato'];
				// $bienServicio = $filaInfoContratacion['bien_servicio'];
				$bienServicio = GetInformacionOrg($codOrg, "actividad");
				if($filaInfoContratacion['monto_contratacion'] > 0)
					$adjudicadoSocio = 'si';
				else
					$adjudicadoSocio = 'no';

				if($filaInfoContratacion['categoria_actividad_mp'] == 'no_priorizado_en_el_cambio_matriz_productiva')
					$cdmp = 'no';
				else
					$cdmp = 'si';

				$codProv = $filaInfoContratacion['cod_provincia'];

				if($filaInfoContratacion['tipo_contrato'] == 'publica')
				{
					$asesoriaCompraPublica = "no";
					$asesoriaCompraOrg = "si";
					$redFeriasSomos = "no";
					$comercializacionRuedasNegocio = "no";
					$asistenciaTecnica = "no";
				}
				else
				{
					$asesoriaCompraPublica = "no";
					$asesoriaCompraOrg = "no";
					$redFeriasSomos = "no";
					$comercializacionRuedasNegocio = "no";
					$asistenciaTecnica = "si";
				}

				if($filaInfoContratacion['circuito_economico'] == 'si')
					$circuitoEc = 'si';
				else
					$circuitoEc = 'no';

				$mercado = $filaInfoContratacion['tipo_contrato'];

				if($filaInfoContratacion['antiguedad'] == 'si')
					$nuevaOrg = 'si';
				else
					$nuevaOrg = 'no';

				
			}
		}
		else if($tipoServicioContratacion == 's')
		{
			$sqlInfoServicios = "select servicio, tipo_servicio, descripcion, categoria_actividad_mp, antiguedad, circuito_economico, cod_provincia from im_servicios where cod_servicio = " . $codServicioContratacion . " and year(fecha_reporte) = " . $anioInd;
			$resInfoServicios = query($sqlInfoServicios);
			while($filaInfoServicios = mysql_fetch_array($resInfoServicios))
			{
				$tipoServicioContratacion = $filaInfoServicios['tipo_contrato'];
				// $bienServicio = $filaInfoServicios['descripcion'];
				$bienServicio = GetInformacionOrg($codOrg, "actividad");

				$adjudicadoSocio = 'no';

				if($filaInfoServicios['categoria_actividad_mp'] == 'no_priorizado_en_el_cambio_matriz_productiva')
					$cdmp = 'no';
				else
					$cdmp = 'si';

				$codProv = $filaInfoServicios['cod_provincia'];

				// revisamos que tipo de servicio se realizo
				//**************************************
				$servicioRegistrado = $filaServicio['servicio'];
				$tipoServicioRegistrado = $filaServicio['tipo_servicio'];
				//**************************************
				// echo $indice . '-' .$servicioRegistrado . " - " . $tipoServicioRegistrado . "<br>";
				if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "instituciones_publicas")
				{
					$asesoriaCompraPublica = "si";
					$mercado = 'publica';
				}
				if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "organizaciones_unidades_eps")
				{
					$asesoriaCompraOrg = "si";
					$mercado = 'publica';
				}
				if($servicioRegistrado == "asistencia_tecnica_comercial" && $tipoServicioRegistrado == "asistencia_tecnica")
				{
					$asistenciaTecnica = "si";
					$mercado = 'privada';
				}
				if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ferias")
				{
					$redFeriasSomos = "si";
					$mercado = 'privada';
				}
				if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ruedas_de_negocio")
				{
					$comercializacionRuedasNegocio = "si";
					$mercado = 'privada';
				}

				if($filaInfoServicios['circuito_economico'] == 'si')
					$circuitoEc = 'si';
				else
					$circutioEc = 'no';

				if($filaInfoServicios['antiguedad'] == 'si')
					$nuevaOrg = 'si';
				else
					$nuevaOrg = 'no';
				
			}
		}

		// Info del socio
		$sqlInfoSocios = "select apellidos, socio_empleado, genero, grupo_etnico, discapacidad, tipo_discapacidad, poblacion from socios where cedula = '" . $valor . "' and cod_u_organizaciones = " . $codOrg . " group by cedula";
		$resInfoSocios = query($sqlInfoSocios);
		while($filaInfoSocios = mysql_fetch_array($resInfoSocios))
		{
			$apellidosSocio = $filaInfoSocios['apellidos'];
			$tipoSocio = $filaInfoSocios['socio_empleado'];
			$genero = $filaInfoSocios['genero'];
			$gEtnico = $filaInfoSocios['grupo_etnico'];
			$discapacidad = $filaInfoSocios['discapacidad'];
			if($discapacidad == 'si')
				$tipoDiscapacidad = $filaInfoSocios['tipo_discapacidad'];
			else
				$tipoDiscapacidad = 'no';

			$poblacion = $filaInfoSocios['poblacion'];
		}

		// info de la organizacion
		$sqlInfoOrg = "select tipo, ruc_definitivo, ruc_provisional, organizacion from u_organizaciones where cod_u_organizaciones = " . $codOrg;
		$resInfoOrg = query($sqlInfoOrg);
		$tipoOrg = "";
		$organizacion = "";
		$ruc = '';
		$nombreOrg = '';
		while($filaInfoOrg = mysql_fetch_array($resInfoOrg))
		{
			if($filaInfoOrg['tipo'] == "org")
			{
				$organizacion = 'ORGANIZACION';
				$tipoOrg = 'si';
			}
			else
			{
				$organizacion = "UNIDAD ECONÓMICA POPULAR";
				$tipoOrg = 'no';
			}

			if($filaInfoOrg['ruc_definitivo'] == '')
				$ruc = $filaInfoOrg['ruc_provisional'];
			else
				$ruc = $filaInfoOrg['ruc_definitivo'];

			$nombreOrg = $filaInfoOrg['organizacion'];
		}




		array_push($resultadoFinal, $indice);	// indice
		array_push($resultadoFinal, $valor);	// cedula
		array_push($resultadoFinal, ' - ');		//validacion
		array_push($resultadoFinal, $genero);		//genero
		array_push($resultadoFinal, $apellidosSocio);		// apellidos socio
		array_push($resultadoFinal, $gEtnico);		// grupo etnico
		array_push($resultadoFinal, $tipoSocio);		// tipo de socio

		//Discapacidad
		array_push($resultadoFinal, $discapacidad);
		// tipo de discapacidad
		array_push($resultadoFinal, $tipoDiscapacidad);

		//Sector o poblacion
		array_push($resultadoFinal, $poblacion);

		//Bien o servicio
		$bienServicio = GetInformacionOrg($codOrg, "actividad");
		array_push($resultadoFinal, $bienServicio);

		// adjudicador
		array_push($resultadoFinal, $adjudicadoSocio);

		array_push($resultadoFinal, $nombresMes[$mesReporte - 1]);		// mesReporte

		// tipo de organizacion
		array_push($resultadoFinal, $tipoOrg);

		// cdmp
		array_push($resultadoFinal, $cdmp);

		array_push($resultadoFinal, $zona);		// zona

		// provincia
		$codProv = GetNombreProvincia($zonaInd, $codProv);
		array_push($resultadoFinal, $codProv);

		// Servicios
		array_push($resultadoFinal, $asesoriaCompraPublica);
		array_push($resultadoFinal, $asesoriaCompraOrg);
		array_push($resultadoFinal, $redFeriasSomos);
		array_push($resultadoFinal, $comercializacionRuedasNegocio);
		array_push($resultadoFinal, $asistenciaTecnica);

		// circuito economico
		array_push($resultadoFinal, $circuitoEc);

		// tipo de organizacion
		array_push($resultadoFinal, $organizacion);

		// mercado
		array_push($resultadoFinal, $mercado);

		// ruc
		array_push($resultadoFinal, $ruc);

		// nombre de la org
		array_push($resultadoFinal, $nombreOrg);

		// org nueva
		array_push($resultadoFinal, $nuevaOrg);

		array_push($resultadoFinal, $tipoServicioContratacion); 	// tipo servicio o la contratacion
		array_push($resultadoFinal, $codServicioContratacion); 	// cod servicio o la contratacion
		
		
		
		
		

		//print_r2($infoOrg);

	}

	
	return $resultadoFinal;	
}

function Indicador08($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadoresArray, $nombresMes;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();		
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$resultadoFinal = array();
	$orgNuevas = 0; 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== OCTAVO INDICADOR =======================*/
	/*NÚMERO DE NUEVAS ORGANIZACIONES DE LA EPS QUE RECIBIERON AL MENOS UN SERVICIO DE LA DIRECCIÓN DE INTERCAMBIO Y MERCADOS*/
	
	//	echo $metaMes . "<br>" . $metaAnual;


	$orgNuevas = RevisarOrgMesNuevas($zonaInd, $mesInd);
	//echo $orgNuevas . "*****<br>";
	//print_r2($orgNuevas);

	$indice = 0;
	foreach($orgNuevas as $valor)
	{
		$indice++;
		

		// Se debe consultar el primer reporte registrado de la organizacion 
		// y se debe guardar si es contratacion o es servicio

		$codOrg = $valor;
		$sqlOrgContratacion = "select cod_contratacion, tipo_contrato, cod_canton, cod_tipo_entidad_contratante, cod_entidad_contratante, month(fecha_reporte) as mesReporte, num_socios, num_empleados, circuito_economico, cod_provincia  from im_contratacion where cod_u_organizaciones = " . $codOrg . " and cod_zona = " . $zonaInd . " and year(fecha_reporte) = " . $anioInd . " and antiguedad = 'si' order by cod_contratacion limit 1";
		//echo $sqlOrgContratacion . "<br />";

		$resOrgContratacion = query($sqlOrgContratacion);
		$numFilas = mysql_num_rows($resOrgContratacion);
		$mesContratacionServicio = 0;
		$codContratacionServicio = 0;
		$tipoContratacionServicio = 0;
		$entidadContratante = 0;
		$numSocios = 0;
		$numEmpleados = 0;
		$codProv = 0;
		$codCanton = 0;
		$asesoriaCompraPublica = "no";
		$asesoriaCompraOrg = "no";
		$redFeriasSomos = "no";
		$comercializacionRuedasNegocio = "no";
		$asistenciaTecnica = "no";
		$servicioRegistrado = "";
		$tipoServicioRegistrado = "";
		$cEconomico = "";

		if($numFilas == 1)
		{
			while($fila = mysql_fetch_array($resOrgContratacion))
			{
				$mesContratacionServicio = $fila['mesReporte'];
				$codContratacionServicio = $fila['cod_contratacion'];
				$tipoContratacionServicio = "Contratación - " . $fila['tipo_contrato'];
				$entidadContratante = getEntidadContratante($fila['cod_tipo_entidad_contratante'], $fila['cod_entidad_contratante']);
				$numSocios = $fila['num_socios'];
				$numEmpleados = $fila['num_empleados'];
				$codProv = $fila['cod_provincia'];
				$codCanton = $fila['cod_canton'];
				$cEconomico = $fila['circuito_economico'];

				// echo $fila['tipo_contrato'] . "<br>";
				if($fila['tipo_contrato'] == 'publica')
				{
					$asesoriaCompraPublica = "no";
					$asesoriaCompraOrg = "si";
					$redFeriasSomos = "no";
					$comercializacionRuedasNegocio = "no";
					$asistenciaTecnica = "no";
				}
				else
				{
					$asesoriaCompraPublica = "no";
					$asesoriaCompraOrg = "no";
					$redFeriasSomos = "no";
					$comercializacionRuedasNegocio = "no";
					$asistenciaTecnica = "si";
				}

			}

			// Revisamos si existe un servicio anterior a la fecha de contratacion
			$sqlExisteServicio = "select * from im_servicios where cod_u_organizaciones = " . $codOrg . " and year(fecha_reporte) = " . $anioInd . " and antiguedad = 'si' and month(fecha_reporte) < " . $mesContratacionServicio;

			$resExisteServicio = query($sqlExisteServicio);
			$numFilasServ = mysql_num_rows($resExisteServicio);
			if($numFilasServ > 0)
			{
				$sqlServicio = "select cod_servicio, cod_canton, servicio, cod_provincia, tipo_servicio, month(fecha_reporte) as mesReporte, num_socios, circuito_economico, num_empleados from im_servicios where cod_u_organizaciones = " . $codOrg . " and year(fecha_reporte) = " . $anioInd . " order by cod_servicio limit 1";
				$resServicio = query($sqlServicio);
				while($fila = mysql_fetch_array($resServicio))
				{
					// reemplazo los valores de contratacion
					$mesContratacionServicio = $fila['mesReporte'];
					$codContratacionServicio = $fila['cod_servicio'];
					$tipoContratacionServicio = "Servicio - " . $fila['servicio'] . " - " . $fila['tipo_servicio'];
					$entidadContratante = " - ";
					$numSocios = $fila['num_socios'];
					$numEmpleados = $fila['num_empleados'];
					$codProv = $fila['cod_provincia'];
					$codCanton = $fila['cod_canton'];

					$servicioRegistrado = $fila['servicio'];
					$tipoServicioRegistrado = $fila['tipo_servicio'];
					$cEconomico = $fila['circuito_economico'];

					if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "instituciones_publicas")
					{
						$asesoriaCompraPublica = "si";
					}
					if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "organizaciones_unidades_eps")
					{
						$asesoriaCompraOrg = "si";
					}
					if($servicioRegistrado == "asistencia_tecnica_comercial" && $tipoServicioRegistrado == "asistencia_tecnica")
					{
						$asistenciaTecnica = "si";
					}
					if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ferias")
					{
						$redFeriasSomos = "si";
					}
					if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ruedas_de_negocio")
					{
						$comercializacionRuedasNegocio = "si";
					}
				}
			}
		}
		else
		{
			// Al no haber contrataciones se revisa los servicios
			$sqlServicio = "select cod_servicio, cod_canton, servicio, cod_provincia, tipo_servicio, month(fecha_reporte) as mesReporte, circuito_economico, num_socios, num_empleados from im_servicios where cod_u_organizaciones = " . $codOrg . " and year(fecha_reporte) = " . $anioInd . " order by cod_servicio limit 1";
			$resServicio = query($sqlServicio);			
			while($fila = mysql_fetch_array($resServicio))
			{
				// reemplazo los valores de contratacion
				$mesContratacionServicio = $fila['mesReporte'];
				$codContratacionServicio = $fila['cod_servicio'];
				$tipoContratacionServicio = "Servicio - " . $fila['servicio'] . " - " . $fila['tipo_servicio'];
				$entidadContratante = " - ";
				$numSocios = $fila['num_socios'];
				$numEmpleados = $fila['num_empleados'];
				$codProv = $fila['cod_provincia'];
				$codCanton = $fila['cod_canton'];

				$servicioRegistrado = $fila['servicio'];
				$tipoServicioRegistrado = $fila['tipo_servicio'];
				$cEconomico = $fila['circuito_economico'];

				if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "instituciones_publicas")
				{
					$asesoriaCompraPublica = "si";
				}
				if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "organizaciones_unidades_eps")
				{
					$asesoriaCompraOrg = "si";
				}
				if($servicioRegistrado == "asistencia_tecnica_comercial" && $tipoServicioRegistrado == "asistencia_tecnica")
				{
					$asistenciaTecnica = "si";
				}
				if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ferias")
				{
					$redFeriasSomos = "si";
				}
				if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ruedas_de_negocio")
				{
					$comercializacionRuedasNegocio = "si";
				}


			}
			
		}
		

		array_push($resultadoFinal, $indice);	// indice de la tabla
		array_push($resultadoFinal, $zonaInd);	// zona del reporte

		//Provincia
		$codCanton = GetNombreCanton($codProv, $codCanton);
		$codProv = GetNombreProvincia($zonaInd, $codProv);
		array_push($resultadoFinal, $codProv);

		// Canton
		array_push($resultadoFinal, $codCanton);

		//mes
		array_push($resultadoFinal, $nombresMes[$mesContratacionServicio - 1]);

		// SERVICIOS		
		array_push($resultadoFinal, $asesoriaCompraPublica);
		array_push($resultadoFinal, $asesoriaCompraOrg);
		array_push($resultadoFinal, $redFeriasSomos);
		array_push($resultadoFinal, $comercializacionRuedasNegocio);
		array_push($resultadoFinal, $asistenciaTecnica);

		// Ruc de la organizacion
		$rucOrganizacion = GetInformacionOrg($codOrg, "ruc");
		array_push($resultadoFinal, $rucOrganizacion);

		//Nombre de la organizacion
		$nOrganizacion = GetInformacionOrg($codOrg, "nombre");
		array_push($resultadoFinal, $nOrganizacion);

		// Tipo de Organizacion		
		$tipoDeOrganizacion = GetInformacionOrg($codOrg, "tipoOrg");
		array_push($resultadoFinal, $tipoDeOrganizacion);

		// Circuito economico
		array_push($resultadoFinal, $cEconomico);

		array_push($resultadoFinal, $tipoContratacionServicio);	// descripcion de contratacion o servicio

		array_push($resultadoFinal, $codContratacionServicio);	// codigo de la contratacion o servicio
		
		array_push($resultadoFinal, $entidadContratante);	// entidad contratante

		array_push($resultadoFinal, $numSocios);	// numero socios

		array_push($resultadoFinal, $numEmpleados);	// numero empleados

		
		
		
		


	}

	//print_r2($resultadoFinal);
	return $resultadoFinal;

		

	
	
	
}

function ReporteGeneralActores($zona, $mes)
{
	// Función que buscará todos los registros de las cédulas en el mes y zona escogidos
	global $nombresMes;
	$anioInd = getAnioSeleccionado();
	$mesInd = $mes;
	$zonaInd = $zona;
	$orgReportadas = array();
	$resultadoFinal = array();
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01';

	//echo $anioInd . " - " . $mesInd . " - " .  $zonaInd . "<br>";

	$sqlOrgReportadas = "select * from im_contratacion where cod_zona = " . $zonaInd . " and month(fecha_reporte) = " . $mesInd . " and year(fecha_reporte) = " . $anioInd . " and se_reporta = 'si' ";

	$resOrgReportadas = query($sqlOrgReportadas);
	while($filaOrgReportadas = mysql_fetch_array($resOrgReportadas))
	{
		array_push($orgReportadas, $filaOrgReportadas['cod_u_organizaciones']);
	}

	$sqlOrgReportadas = "select * from im_servicios where cod_zona = " . $zonaInd . " and month(fecha_reporte) = " . $mesInd . " and year(fecha_reporte) = " . $anioInd . " and se_reporta = 'si' ";

	$resOrgReportadas = query($sqlOrgReportadas);
	while($filaOrgReportadas = mysql_fetch_array($resOrgReportadas))
	{
		array_push($orgReportadas, $filaOrgReportadas['cod_u_organizaciones']);
	}

	$orgReportadas = array_unique($orgReportadas);
	$orgReportadas = array_values($orgReportadas);
	// print_r2($orgReportadas);

	//	con el codigo de organizaciones revisamos si existen contrataciones o servicios registrados
	$indice = 0;
	foreach($orgReportadas as $valor)
	{
		$sqlActorReportado = "select * from im_contratacion_servicios_socios where cod_u_organizaciones = " . $valor . " and month(fecha_reporte) = " . $mesInd . " and year(fecha_reporte) = " . $anioInd;
		

		$resActorReportado = query($sqlActorReportado);
		$numFilasActores = mysql_num_rows($resActorReportado);
		$cedula = 0;
		$genero = "";
		$nombresApellidos = "";
		$etniaActor = "";
		$tipoSocio = "";
		$discapacidadActor = "";
		$poblacionActor = "";

		//echo $sqlActorReportado . "<br> Numfilas = " . $numFilasActores . "<br>";

		if($numFilasActores > 0)
		{
			while($filaReportado = mysql_fetch_array($resActorReportado))
			{

				$cedula = $filaReportado['cedula'];			
				

				$sqlActor = "select * from socios where cedula = '" . $filaReportado['cedula'] . "' and estado = 1 and cod_u_organizaciones = " . $valor;
				$resActor = query($sqlActor);
				while($filaActor = mysql_fetch_array($resActor))
				{

					// Genero
					if($filaActor['genero'] == "")
						$genero = 'FALTA INFO LLENAR SIU';
					else
						$genero = $filaActor['genero'];

					// Nombres y apellidos
					$nombresApellidos = $filaActor['apellidos'];

					// Etnia
					if($filaActor['grupo_etnico'] == "")
						$etniaActor = 'FALTA INFO LLENAR SIU';
					else
						$etniaActor = $filaActor['grupo_etnico'];

					// Estatus
					if($filaActor['socio_empleado'] == "")
						$tipoSocio = 'FALTA INFO LLENAR SIU';
					else
						$tipoSocio = $filaActor['socio_empleado'];

					// Discapacidad
					if($filaActor['discapacidad'] == '')
						$discapacidadActor = 'FALTA INFO LLENAR SIU';
					else
						$discapacidadActor = $filaActor['discapacidad'];

					// Sector = ubicacion
					if($filaActor['poblacion'] == '')
						$poblacionActor = 'FALTA INFO LLENAR SIU';
					else
						$poblacionActor = $filaActor['poblacion'];

					// Informacion del servio o bien provisto
					$codContServicio = $filaReportado['cod_im_contratacion_servicios'];
					$tipoContServicio = $filaReportado['tipo'];
					$sectorPriorizado = "";
					$bienServicio = "";
					$adjudicadoActor = "";
					$cdmp = "";
					$codProv = 0;
					// SERVICIOS
					$asesoriaCompraPublica = "no"; // Acompañamiento / Asesoria en el proceso de compra pública a Instituciones públicas
					$asesoriaCompraOrg = "no";		// Acompañamiento / Asesoría en el proceso de compra pública inclusiva a organizaciones o unidades EPS
					$redFeriasSomos = "no";		//Participación en eventos de Comercialización Red de Ferias Somos Tus Manos Ecuador
					$comercializacionRuedasNegocio = "no";		//Participación en eventos de Comercialización Rueda de Negocios
					$asistenciaTecnica = "no";		// Asistencia Técnica en procesos comerciales
					$circuitoEc = "";
					$mercado = "";
					$orgNueva = "";
					$tipoServicioCont = "";

					if($tipoContServicio == "c")
					{
						// El socio es reportado como contracion
						$sqlContratacion = "select * from im_contratacion where cod_u_organizaciones = " . $valor . " and cod_contratacion = " . $codContServicio . " and year(fecha_reporte) = " . $anioInd . " and month(fecha_reporte) = " . $mesInd . " and cod_zona = " . $zonaInd;
						// echo $sqlContratacion . "<br>";
						$resContratacion = query($sqlContratacion);
						while($filaContratacion = mysql_fetch_array($resContratacion))
						{
							// sector priorizado
							$sectorPriorizado = $filaContratacion['categoria_actividad_mp'];

							// Bien o servicio
							$bienServicio = $filaContratacion['bien_servicio'];

							// adjudicado
							if($filaContratacion['monto_contratacion'] > 0)
								$adjudicadoActor = 'si';
							else
								$adjudicadoActor = 'no';

							// cdmp
							if($filaContratacion['categoria_actividad_mp'] == 'no_priorizado_en_el_cambio_matriz_productiva')
								$cdmp = 'no';
							else
								$cdmp = 'si';

							// Servicios
							$codProv = $filaContratacion['cod_provincia'];
							$codProv = GetNombreProvincia($zonaInd, $codProv);

							if($filaContratacion['tipo_contrato'] == 'publica')
							{
								$asesoriaCompraPublica = "no";
								$asesoriaCompraOrg = "si";
								$redFeriasSomos = "no";
								$comercializacionRuedasNegocio = "no";
								$asistenciaTecnica = "no";
							}
							else
							{
								$asesoriaCompraPublica = "no";
								$asesoriaCompraOrg = "no";
								$redFeriasSomos = "no";
								$comercializacionRuedasNegocio = "no";
								$asistenciaTecnica = "si";
							}

							// circuito economico
							$circuitoEc = $filaContratacion['circuito_economico'];

							// mercado
							$mercado = $filaContratacion['tipo_contrato'];

							//org nueva
							$orgNueva = $filaContratacion['antiguedad'];

							// tipo de servicio
							$tipoServicioCont = 'CONTRATACIÓN';



						}
					}
					else
					{
						// El socio es reportado como servicio
						$sqlServicio = "select * from im_servicios where cod_u_organizaciones = " . $valor . " and cod_servicio = " . $codContServicio . " and year(fecha_reporte) = " . $anioInd . " and month(fecha_reporte) = " . $mesInd . " and cod_zona = " . $zonaInd;
						$resServicio = query($sqlServicio);
						while($filaServicio = mysql_fetch_array($resServicio))
						{

							// sector priorizado
							$sectorPriorizado = $filaServicio['categoria_actividad_mp'];

							// Bien o servicio
							// $bienServicio = $filaServicio['descripcion'];
							$bienServicio = GetInformacionOrg($codOrg, "actividad");
							$adjudicadoActor = 'no';

							// cdmp
							if($filaServicio['categoria_actividad_mp'] == 'no_priorizado_en_el_cambio_matriz_productiva')
								$cdmp = 'no';
							else
								$cdmp = 'si';

							$codProv = $filaServicio['cod_provincia'];
							$codProv = GetNombreProvincia($zonaInd, $codProv);						

							// revisamos que tipo de servicio se realizo
							//**************************************
							$servicioRegistrado = $filaServicio['servicio'];
							$tipoServicioRegistrado = $filaServicio['tipo_servicio'];
							//**************************************
							// echo $indice . '-' .$servicioRegistrado . " - " . $tipoServicioRegistrado . "<br>";
							if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "instituciones_publicas")
							{
								$asesoriaCompraPublica = "si";
								$mercado = 'publica';
							}
							if($servicioRegistrado == "acompañamiento_asesoria" && $tipoServicioRegistrado == "organizaciones_unidades_eps")
							{
								$asesoriaCompraOrg = "si";
								$mercado = 'publica';
							}
							if($servicioRegistrado == "asistencia_tecnica_comercial" && $tipoServicioRegistrado == "asistencia_tecnica")
							{
								$asistenciaTecnica = "si";
								$mercado = 'privada';
							}
							if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ferias")
							{
								$redFeriasSomos = "si";
								$mercado = 'privada';
							}
							if($servicioRegistrado == "participacion_eventos_comercializacion" && $tipoServicioRegistrado == "ruedas_de_negocio")
							{
								$comercializacionRuedasNegocio = "si";
								$mercado = 'privada';
							}

							// circuito economico
							$circuitoEc = $filaServicio['circuito_economico'];

							//org nueva
							$orgNueva = $filaServicio['antiguedad'];

							// tipo de servicio
							$tipoServicioCont = 'SERVICIO';

						}
					}			

				}

				// armamos el reporte
				$indice++;
				array_push($resultadoFinal, $indice);
				array_push($resultadoFinal, $cedula); // cedula
				array_push($resultadoFinal, ' - ');	// validacion
				array_push($resultadoFinal, $genero);	// genero
				array_push($resultadoFinal, $nombresApellidos);	// nombres y apellidos
				array_push($resultadoFinal, $etniaActor);	// etnia
				array_push($resultadoFinal, $tipoSocio);	// estatus
				array_push($resultadoFinal, $discapacidadActor);	// discapacidad
				array_push($resultadoFinal, $poblacionActor);	// sector
				$sectorPriorizado = GetInformacionOrg($valor, "categoria");
				array_push($resultadoFinal, $sectorPriorizado);	//sector priorizado
				$bienServicio = GetInformacionOrg($valor, "actividad");
				array_push($resultadoFinal, $bienServicio);	// bien o servicio
				array_push($resultadoFinal, $adjudicadoActor);		// adjudicacion
				array_push($resultadoFinal, $nombresMes[$mesInd - 1]);	// mes

				// Organizacion
				$tipoDeOrganizacion = GetInformacionOrg($valor, "tipoOrg");
				if($tipoDeOrganizacion == 'org')
					array_push($resultadoFinal, 'si');
				else
					array_push($resultadoFinal, 'no');

				// Cdmp
				array_push($resultadoFinal, $cdmp);

				array_push($resultadoFinal, $zonaInd);	// zona
				array_push($resultadoFinal, $codProv);	// provincia

				// Servicios
				array_push($resultadoFinal, $asesoriaCompraPublica);
				array_push($resultadoFinal, $asesoriaCompraOrg);
				array_push($resultadoFinal, $redFeriasSomos);
				array_push($resultadoFinal, $comercializacionRuedasNegocio);
				array_push($resultadoFinal, $asistenciaTecnica);

				// circuito economico
				array_push($resultadoFinal, $circuitoEc);

				// tipo de Organizacion
				if($tipoDeOrganizacion == 'org')
					array_push($resultadoFinal, 'ORGANIZACIÓN');
				else
					array_push($resultadoFinal, 'UNIDAD ECONÓMICA POPULAR');

				// mercado
				array_push($resultadoFinal, $mercado);

				// Ruc de la organizacion
				$rucOrgUep = GetInformacionOrg($valor, "ruc");
				array_push($resultadoFinal, $rucOrgUep);

				// Nombre de la organizacion
				$nombreOrg = GetInformacionOrg($valor, "nombre");
				array_push($resultadoFinal, $nombreOrg);

				//Nueva org
				array_push($resultadoFinal, $orgNueva);

				

				// tipo de servicio
				array_push($resultadoFinal, $tipoServicioCont);	
				// id contratacion o servicio
				array_push($resultadoFinal, $codContServicio);

			}

				
		}
	}

	return $resultadoFinal;


}

function getEntidadContratante($codTipoEntidadContratante, $codEntidadContratante)
{
	$sqlEntidad = "select entidad_contratante from im_entidad_contratante where cod_entidad_contratante = " . $codEntidadContratante . " and cod_tipo_entidad_contratante = " . $codTipoEntidadContratante;

	$resEntidad = query($sqlEntidad);
	$nombreEntidad = 0;
	while($filaEntidad = mysql_fetch_array($resEntidad))
	{
		$nombreEntidad = $filaEntidad['entidad_contratante'];
	}
	return $nombreEntidad;
}

function RevisarOrgMes($zona, $mes, $tipoOrg)
{
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();
	$numOrgReportadas = 0;
	$orgReportadasMes = array();
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01';
	$sqlOrgMes = "";


	if($tipoOrg == 'org')
	{
		$sqlOrgMes = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona, si.servicio, si.tipo_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) = " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and se_reporta = 'si' and antiguedad = 'no' group by si.cod_u_organizaciones";
	}
	else
	{
		$sqlOrgMes = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona, si.servicio, si.tipo_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) = " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and se_reporta = 'si' group by si.cod_u_organizaciones";
	}

	//echo $sqlOrgMes . "<br>";

	//ejecucion del sql que busca las organizaciones del mes y zona indicados
	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);		
	}

	if($tipoOrg == 'org')
	{
		$sqlOrgMes = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona from im_contratacion si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) = " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and se_reporta = 'si' and antiguedad = 'no' group by si.cod_u_organizaciones";
	}
	else
	{
		$sqlOrgMes = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona from im_contratacion si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) = " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and se_reporta = 'si' group by si.cod_u_organizaciones";
	}

	//echo $sqlOrgMes . "<br>";

	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);
		
	}

	// Caso Especial por pedido de Paola Villavicencio
	if($zona == 3 and $mes == 2)
	{
		array_push($orgReportadasMes, '1734');	
		
	}

	$orgReportadasMes = array_unique($orgReportadasMes);
	$orgReportadasMes =  array_values($orgReportadasMes);
	//print_r2($orgReportadasMes);

	// $orgReportadasMes tienen org reportadas en este mes
	// $orgReportadasMesAnterior debe tener org reportadas en meses anteriores

	$orgReportadasMesAnterior = array();

	//Revisamos las organizaciones / uep reportadas en meses anteriores
	$orgReportadasMesAnterior = OrgReportadasMesesAnteriores($mesInd, $zonaInd, $tipoOrg);


	$posicionArray = 0;
	foreach ($orgReportadasMes as $valor) 
	{
		if(in_array($valor, $orgReportadasMesAnterior))
		{
			unset($orgReportadasMes[$posicionArray]);
		}
		$posicionArray++;
	}	

	$orgReportadasMes = array_unique($orgReportadasMes);
	$orgReportadasMes =  array_values($orgReportadasMes);



	$numOrgReportadas = $orgReportadasMes;

	

	return $numOrgReportadas;

}

function OrgReportadasMesesAnteriores($mes, $zona, $tipoOrg)
{

	$sqlOrgMesesAnteriores = "";
	$anioInd = getAnioSeleccionado();
	$orgAux = array();

	// Servicios
	if($tipoOrg == 'org')
	{
		$sqlOrgMesesAnteriores = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona, si.servicio, si.tipo_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) < " . $mes . " and si.cod_zona = " . $zona . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and se_reporta = 'si' and antiguedad = 'no' group by si.cod_u_organizaciones";
	}
	else
	{
		$sqlOrgMesesAnteriores = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona, si.servicio, si.tipo_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) < " . $mes . " and si.cod_zona = " . $zona . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and se_reporta = 'si' group by si.cod_u_organizaciones";
	}

	$resSqlOrgMesesAnteriores = query($sqlOrgMesesAnteriores);	
	
	while($fila = mysql_fetch_array($resSqlOrgMesesAnteriores))
	{
		array_push($orgAux, $fila['cod_u_organizaciones']);		
	}


	// Contrataciones
	if($tipoOrg == 'org')
	{
		$sqlOrgMesesAnteriores = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona from im_contratacion si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) < " . $mes . " and si.cod_zona = " . $zona . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and se_reporta = 'si' and antiguedad = 'no' group by si.cod_u_organizaciones";
	}
	else
	{
		$sqlOrgMesesAnteriores = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona from im_contratacion si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) < " . $mes . " and si.cod_zona = " . $zona . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and se_reporta = 'si' group by si.cod_u_organizaciones";
	}

	//echo $sqlOrgMesesAnteriores . "<br>";

	$resSqlOrgMesesAnteriores = query($sqlOrgMesesAnteriores);	
	
	while($fila = mysql_fetch_array($resSqlOrgMesesAnteriores))
	{
		array_push($orgAux, $fila['cod_u_organizaciones']);
		
	}

	$orgAux = array_unique($orgAux);
	$orgAux = array_values($orgAux);

	return $orgAux;
}


function RevisarSociosOrg($zona, $mes)
{
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();
	$sociosReportados = 0;
	$orgReportadasMes = array();
	$orgNoRepetidas = array();
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01';

	$arraySociosMes = array();
	$arraySociosMesAnterior = array();


	$sqlOrgMes = "select si.cod_u_organizaciones, si.cod_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) = " . $mesInd . " and si.cod_zona = " . $zonaInd . " and year(si.fecha_reporte) = " . $anioInd . " and si.categoria_actividad_mp <> 'no_priorizado_en_el_cambio_matriz_productiva' group by si.cod_u_organizaciones";

	//echo $sqlOrgMes . "<br>";

	//ejecucion del sql que busca las organizaciones del mes y zona indicados
	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);
		//array_push($orgReportadasMes, $fila['cod_servicio']);
		//array_push($orgReportadasMes, $fila['tipo_servicio']);
	}

	//print_r2($orgReportadasMes);	

	$sqlOrgMes = "select si.cod_u_organizaciones from im_contratacion si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) = " . $mesInd . " and si.cod_zona = " . $zonaInd . " and year(si.fecha_reporte) = " . $anioInd . " and si.categoria_actividad_mp <> 'no_priorizado_en_el_cambio_matriz_productiva' group by si.cod_u_organizaciones";

	//echo $sqlOrgMes . "<br>";

	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);
		//array_push($orgReportadasMes, $fila['cod_servicio']);
		//array_push($orgReportadasMes, $fila['tipo_servicio']);
	}
	$orgReportadasMes = array_unique($orgReportadasMes); 
	$orgReportadasMes =  array_values($orgReportadasMes);



	//print_r2($orgReportadasMes);	

	//se revisara si el codigo en la tabla de socios es igual al reportado
	for($i = 0; $i < count($orgReportadasMes); $i++)
	{

		
		$sqlSocios = "select cod_socios, cedula from im_contratacion_servicios_socios where year(fecha_reporte) = " . $anioInd . " and month(fecha_reporte) = " . $mesInd . " and cod_u_organizaciones = " . $orgReportadasMes[$i];

		// $sqlSocios = "select s.cod_socios, s.cedula from socios  s inner join im_contratacion_socios ic on (s.cod_socios = ic.cod_socios) where s.estado = 1 and year(ic.fecha_reporte_im) = " . $anioInd . " and month(ic.fecha_reporte_im) = " . $mesInd . " and ic.cod_u_organizaciones = " . $orgReportadasMes[$i];

		//$sqlSocios = "select cod_socios, cedula from socios where estado = 1 and cod_u_organizaciones = " . $orgReportadasMes[$i];
		//echo $sqlSocios . "<br>";

		$resSqlSocios = query($sqlSocios);

		while($fila = mysql_fetch_array($resSqlSocios))
		{

			array_push($arraySociosMes, $fila['cedula']);
			//$sociosReportados++;
		}	

		
		
	}
	$arraySociosMes = array_unique($arraySociosMes);
	$arraySociosMes = array_values($arraySociosMes);

	return $arraySociosMes;

}

function RevisarCircuitosEconomicos($zona, $mes)
{
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();
	$numOrgReportadas = 0;
	$orgReportadasMes = array();
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01';


	$sqlOrgMes = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona, si.servicio, si.tipo_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) <= " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = 'org' and year(si.fecha_reporte) = " . $anioInd . " and si.circuito_economico = 'si' and si.se_reporta = 'si' group by si.cod_u_organizaciones";

	//echo $sqlOrgMes . "<br>";

	//ejecucion del sql que busca las organizaciones del mes y zona indicados
	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);
		//array_push($orgReportadasMes, $fila['servicio']);
		//array_push($orgReportadasMes, $fila['tipo_servicio']);
	}

	$sqlOrgMes = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona from im_contratacion si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) <= " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = 'org' and year(si.fecha_reporte) = " . $anioInd . " and si.se_reporta = 'si' and  si.circuito_economico = 'si' group by si.cod_u_organizaciones";

	$resSqlOrgMes = query($sqlOrgMes);
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);
		//array_push($orgReportadasMes, $fila['servicio']);
		//array_push($orgReportadasMes, $fila['tipo_servicio']);
	}

	$orgReportadasMes = array_unique($orgReportadasMes); 
	$orgReportadasMes =  array_values($orgReportadasMes);

	//print_r2($orgReportadasMes);

	

	return $orgReportadasMes;

}

function RevisarPlazasTrabajo($zona, $mes)
{
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();
	$numPlazasTrabajo = 0;
	$orgReportadasMes = array();
	$orgNoRepetidas = array();
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01';
	$arraySociosReportar = array();

	$sqlOrgMes = "select ic.cod_contratacion, ic.tipo_contrato, ic.cod_u_organizaciones, ic.num_socios, ic.num_empleados, ic.fecha_adjudicacion, ic.monto_contratacion from im_contratacion ic where month(ic.fecha_reporte) = " . $mesInd . " and year(ic.fecha_reporte) = " . $anioInd . " and ic.monto_contratacion > 0 and ic.cod_zona = " . $zonaInd;

	//echo $sqlOrgMes . "<br>";

	//ejecucion del sql que busca las organizaciones del mes y zona indicados
	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);		
	}

	// print_r2($orgReportadasMes);
	$orgFiltrada = array_unique($orgReportadasMes);
	$orgFiltrada = array_values($orgFiltrada);	

	// print_r2($orgFiltrada);	

	//Se debe revisar si las organizaciones consultadas tienen reportado el mismo contratacion en meses anteriores
	for($i = 0; $i < count($orgFiltrada); $i++)
	{

		// $sqlSociosReportados = "select cedula from socios where cod_u_organizaciones = " . $orgFiltrada[$i] . " and estado = 1 and socio_empleado in ('socio', 'socio_trabajador') and year(fecha_reporte_im) = " . $anioInd . " and month(fecha_reporte_im) = " . $mesInd;

		$sqlSociosReportados = "select ic.cedula, s.estado, s.socio_empleado, ic.fecha_reporte from im_contratacion_servicios_socios ic inner join socios s on (s.cedula = ic.cedula) where ic.cod_u_organizaciones = " . $orgFiltrada[$i] . " and s.estado = 1 and s.socio_empleado in ('socio', 'socio_trabajador') and year(ic.fecha_reporte) = " . $anioInd . " and month(ic.fecha_reporte) = " . $mesInd;
		

		// echo $sqlSociosReportados . "<br>";
		$resSociosReportados = query($sqlSociosReportados);

		while($fila = mysql_fetch_array($resSociosReportados))
		{
			array_push($arraySociosReportar, $fila['cedula']);
		}

		//**************************************************************************************
		//*	Se debe buscar:
		//		Registros de la organizacion con el mismo tipo de contrato. Si existen, no se debe sumar a este indicador
		//		Si no existen:				
		//		-Si no existen mas registros ademas del reportado en el mes indicado, esta organizacion  debe sumar al indicador

		//****************************************************************************************
		
	}

	//print_r2($arraySociosReportar);

	// Caso Especial por pedido de Stefany Lopez


	if($zona == 1 && $mes == 2)
	{
		array_push($arraySociosReportar, '0502284243');
		array_push($arraySociosReportar, '1707550834');
		array_push($arraySociosReportar, '1711931723');
	}

	$arraySociosReportar = array_unique($arraySociosReportar);
	$arraySociosReportar = array_values($arraySociosReportar);
	$numPlazasTrabajo = $arraySociosReportar;

	// print_r2($numPlazasTrabajo);


	//si existen organizaciones, se debe contar los usuarios


	return $numPlazasTrabajo;

}

function RevisarOrgMesNuevas($zona, $mes)
{
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();
	$numOrgReportadas = 0;
	$orgReportadasMes = array();
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01';

	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();
	$numOrgReportadas = 0;
	$orgReportadasMes = array();
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01';
	$tipoOrg = 'org';



	$sqlOrgMes = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona, si.servicio, si.tipo_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) <= " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and si.se_reporta = 'si' and antiguedad = 'si' group by si.cod_u_organizaciones";

	//echo $sqlOrgMes . "<br>";

	//ejecucion del sql que busca las organizaciones del mes y zona indicados
	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);		
	}

	$sqlOrgMes = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona from im_contratacion si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) <= " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and si.se_reporta = 'si' and antiguedad = 'si' group by si.cod_u_organizaciones";

	//echo $sqlOrgMes . "<br>";


	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);
		
	}

	$orgReportadasMes = array_unique($orgReportadasMes);
	$orgReportadasMes = array_values($orgReportadasMes);
	$numOrgReportadas = $orgReportadasMes;
	
	// print_r2($orgReportadasMes);
	return $numOrgReportadas;

}

function GetNombreProvincia($zona, $codigoProvincia)
{
	$sqlNombreProvincia = "select provincia from u_provincia where zona = " . $zona . " and cod_provincia = " . $codigoProvincia;
	$resSqlNombreProvincia = query($sqlNombreProvincia);
	$resNombreProvincia = '';
	//echo $sqlNombreProvincia . "<br>";
	while($fila = mysql_fetch_array($resSqlNombreProvincia))
	{
		$resNombreProvincia = $fila['provincia'];
	}
	return $resNombreProvincia;
}

function GetNombreCanton($codProvincia, $codCanton)
{
	$sqlNombreCanton = "select canton from u_canton where cod_provincia = " . $codProvincia ." and cod_canton= " . $codCanton;
	$resNombreCanton = query($sqlNombreCanton);
	$nombreCanton = "";

	while($fila = mysql_fetch_array($resNombreCanton))
	{
		$nombreCanton = $fila['canton'];
	}
	return $nombreCanton;
}

function GetTipoEntidadContratante($codTipoEntidad)
{
	$sqlTipoEntidadContratante = "select tipo_entidad_contratante from im_tipo_entidad_contratante where cod_tipo_entidad_contratante = " . $codTipoEntidad;
	$resTipoEntidadContratante = query($sqlTipoEntidadContratante);
	$auxTipo = "";
	while($fila = mysql_fetch_array($resTipoEntidadContratante))
	{
		$auxTipo = $fila['tipo_entidad_contratante'];
	}

	return $auxTipo;
}

function GetMontos($mes, $anio, $indicador, $tipoReporte)
{
	$mesInd = $mes;
	$anioInd = $anio;
	$indicadorSel = $indicador;
	$tipoOrg = "";
	$resTabla = "";
	$montoPublica = 0;
	$montoPrivado = 0;

	$arrayOtros = array(
		'actividades_alojamiento_y_servicio_comidas',
		'astillero',
		'farmaceutica',
		'otros',
		'refineria_de_aluminio',
		'refineria_de_cobre',
		'siderurgica_acero',
		''
		);
	$arrayPetroquimica = array(
		'derivados_del_petroleo',
		'detergentes',
		'fibras_sinteticas',
		'jabones',
		'revestimientos'
		);
	$arrayPichincha = array(
		'DM QUITO',
		'PICHINCHA');
	$arrayGuayas = array(
		'DM GUAYAQUIL',
		'GUAYAS');
	$arrayTotalSectores = array();
	$arrayProvincias = array();

	$sqlTotalSectores = "select tipo, codigo from catalogo where tipo = 'identificacion_categoria_actividad' group by codigo";
	$resTotalSectores = query($sqlTotalSectores);

	while($fila = mysql_fetch_array($resTotalSectores))
	{
		array_push($arrayTotalSectores, $fila['codigo']);
	}
	array_push($arrayTotalSectores, '');

	$sqlProvincias = "select provincia from u_provincia group by provincia";
	$resProvincias = query($sqlProvincias);
	while($fila = mysql_fetch_array($resProvincias))
	{
		array_push($arrayProvincias, $fila['provincia']);
	}

	// print_r2($arrayTotalSectores);
	// print_r2($arrayProvincias);

	$sqlMontos = "";

	if($indicadorSel == 1 && $tipoReporte == 'sector')
	{
		$tipoOrg = 'org';	

		$sqlMontos = "select i.identificacion_actividad_mp as sector, sum(i.monto_contratacion) as monto from im_contratacion i inner join u_organizaciones o on (o.cod_u_organizaciones = i.cod_u_organizaciones and o.tipo='org') where month(i.fecha_reporte) = " . $mesInd . " and year(i.fecha_reporte) = " . $anioInd . " and i.se_reporta = 'si' and i.tipo_contrato = 'publica' group by i.identificacion_actividad_mp";

	}
	elseif ($indicadorSel == 1 && $tipoReporte == 'provincia') 
	{
		$sqlMontos = "select p.provincia, sum(i.monto_contratacion) as monto from im_contratacion i inner join u_provincia p on (p.cod_provincia = i.cod_provincia and p.zona = i.cod_zona) inner join u_organizaciones o on (o.cod_u_organizaciones = i.cod_u_organizaciones and o.tipo='org') where month(i.fecha_reporte) = " . $mesInd . " and year(i.fecha_reporte) = " . $anioInd . " and i.se_reporta = 'si' and i.tipo_contrato = 'publica' group by p.provincia";
	}
	elseif ($indicadorSel == 2 && $tipoReporte == 'sector') 
	{
		$sqlMontos = "select i.identificacion_actividad_mp as sector, sum(i.monto_contratacion) as monto from im_contratacion i inner join u_organizaciones o on (o.cod_u_organizaciones = i.cod_u_organizaciones and o.tipo='org') where month(i.fecha_reporte) = " . $mesInd . " and year(i.fecha_reporte) = " . $anioInd . " and i.se_reporta = 'si' and i.tipo_contrato = 'privada' group by i.identificacion_actividad_mp";
	}
	elseif ($indicadorSel == 2 && $tipoReporte == 'provincia') 
	{
		$sqlMontos = "select p.provincia, sum(i.monto_contratacion) as monto from im_contratacion i inner join u_provincia p on (p.cod_provincia = i.cod_provincia and p.zona = i.cod_zona) inner join u_organizaciones o on (o.cod_u_organizaciones = i.cod_u_organizaciones and o.tipo='org') where month(i.fecha_reporte) = " . $mesInd . " and year(i.fecha_reporte) = " . $anioInd . " and i.se_reporta = 'si' and i.tipo_contrato = 'privada' group by p.provincia";
	}
	elseif ($indicadorSel == 3 && $tipoReporte == 'sector') 
	{
		$sqlMontos = "select i.identificacion_actividad_mp as sector, sum(i.monto_contratacion) as monto from im_contratacion i inner join u_organizaciones o on (o.cod_u_organizaciones = i.cod_u_organizaciones and o.tipo='uep') where month(i.fecha_reporte) = " . $mesInd . " and year(i.fecha_reporte) = " . $anioInd . " and i.se_reporta = 'si' and i.tipo_contrato = 'publica' group by i.identificacion_actividad_mp";
	}
	elseif ($indicadorSel == 3 && $tipoReporte == 'provincia') 
	{
		$sqlMontos = "select p.provincia, sum(i.monto_contratacion) as monto from im_contratacion i inner join u_provincia p on (p.cod_provincia = i.cod_provincia and p.zona = i.cod_zona) inner join u_organizaciones o on (o.cod_u_organizaciones = i.cod_u_organizaciones and o.tipo='uep') where month(i.fecha_reporte) = " . $mesInd . " and year(i.fecha_reporte) = " . $anioInd . " and i.se_reporta = 'si' and i.tipo_contrato = 'publica' group by p.provincia";
	}

	elseif ($indicadorSel == 4 && $tipoReporte == 'sector') 
	{
		$sqlMontos = "select i.identificacion_actividad_mp as sector, sum(i.monto_contratacion) as monto from im_contratacion i inner join u_organizaciones o on (o.cod_u_organizaciones = i.cod_u_organizaciones and o.tipo='uep') where month(i.fecha_reporte) = " . $mesInd . " and year(i.fecha_reporte) = " . $anioInd . " and i.se_reporta = 'si' and i.tipo_contrato = 'privada' group by i.identificacion_actividad_mp";
	}
	elseif ($indicadorSel == 4 && $tipoReporte == 'provincia') 
	{
		$sqlMontos = "select p.provincia, sum(i.monto_contratacion) as monto from im_contratacion i inner join u_provincia p on (p.cod_provincia = i.cod_provincia and p.zona = i.cod_zona) inner join u_organizaciones o on (o.cod_u_organizaciones = i.cod_u_organizaciones and o.tipo='uep') where month(i.fecha_reporte) = " . $mesInd . " and year(i.fecha_reporte) = " . $anioInd . " and i.se_reporta = 'si' and i.tipo_contrato = 'privada' group by p.provincia";
	}

	elseif ($indicadorSel == 5 && $tipoReporte == 'sector') 
	{
		$sqlMontos = "select i.identificacion_actividad_mp as sector, sum(i.monto_contratacion) as monto from im_contratacion i where month(i.fecha_reporte) <= " . $mesInd . " and year(i.fecha_reporte) = " . $anioInd . " and i.se_reporta = 'si' and i.tipo_contrato = 'publica' group by i.identificacion_actividad_mp";
	}
	elseif ($indicadorSel == 5 && $tipoReporte == 'provincia') 
	{
		$sqlMontos = "select p.provincia, sum(i.monto_contratacion) as monto from im_contratacion i inner join u_provincia p on (p.cod_provincia = i.cod_provincia and p.zona = i.cod_zona) where month(i.fecha_reporte) <= " . $mesInd . " and year(i.fecha_reporte) = " . $anioInd . " and i.se_reporta = 'si' and i.tipo_contrato = 'publica' group by p.provincia";
	}
	elseif ($indicadorSel == 6 && $tipoReporte == 'sector') 
	{
		$sqlMontos = "select i.identificacion_actividad_mp as sector, sum(i.monto_contratacion) as monto from im_contratacion i where month(i.fecha_reporte) <= " . $mesInd . " and year(i.fecha_reporte) = " . $anioInd . " and i.se_reporta = 'si' and i.tipo_contrato = 'privada' group by i.identificacion_actividad_mp";
	}
	elseif ($indicadorSel == 6 && $tipoReporte == 'provincia') 
	{
		$sqlMontos = "select p.provincia, sum(i.monto_contratacion) as monto from im_contratacion i inner join u_provincia p on (p.cod_provincia = i.cod_provincia and p.zona = i.cod_zona) where month(i.fecha_reporte) <= " . $mesInd . " and year(i.fecha_reporte) = " . $anioInd . " and i.se_reporta = 'si' and i.tipo_contrato = 'privada' group by p.provincia";
	}

	elseif ($indicadorSel == 7 && $tipoReporte == 'general') 
	{
		

		for($anioReporte = 2010; $anioReporte <= $anioInd; $anioReporte++)
		{

			$sqlMontos = "select sum(i.monto_contratacion) as monto from im_contratacion i where  year(i.fecha_reporte) = " . $anioReporte . " and i.se_reporta = 'si' and i.tipo_contrato = 'publica'";
			$resMontos = query($sqlMontos);
			while($fila = mysql_fetch_array($resMontos))
			{
				if($fila['monto'] != '')
				{
					$montoPublica = $fila['monto'];	
				}
				else
					$montoPublica = 0;
				
			}

			$sqlMontos = "select sum(i.monto_contratacion) as monto from im_contratacion i where  year(i.fecha_reporte) = " . $anioReporte . " and i.se_reporta = 'si' and i.tipo_contrato = 'privada'";
			$resMontos = query($sqlMontos);
			while($fila = mysql_fetch_array($resMontos))
			{
				if($fila['monto'] != '')
					$montoPrivado = $fila['monto'];
				else
					$montoPrivado = 0;
			}

			$resTabla .= "<tr>";
			$resTabla .= "<td>" . $anioReporte . "</td>";
			$resTabla .= "<td>" . CambiarPuntoComa($montoPublica) . "</td>";
			$resTabla .= "<td>" . CambiarPuntoComa($montoPrivado) . "</td>";
			$resTabla .= "<td>" . CambiarPuntoComa($montoPublica + $montoPrivado) . "</td>";
			$resTabla .= "</tr>";

		}

		return $resTabla;


	}	


	$resMontos = query($sqlMontos);
	$montosMes = array();
	$arraySectores = array();
	while($fila = mysql_fetch_array($resMontos))
	{
		if($tipoReporte == 'sector')
		{
			array_push($arraySectores, $fila['sector']);				
		}
		elseif($tipoReporte == 'provincia')
		{
			array_push($arraySectores, $fila['provincia']);			
		}		
		array_push($montosMes, $fila['monto']);
		
	}
	// print_r2($arraySectores);
	// print_r2($montosMes);

	$montosOtros = 0;
	$montosPetroquimica = 0;
	$montosTotal = 0;
	$montosPichincha = 0;
	$montosGuayas = 0;
	$cont = 0;
	if($tipoReporte == 'sector')
	{
		foreach($arrayTotalSectores as $valor)
		{
			// echo $valor;
			if(in_array($valor, $arrayOtros))
			{
				$index = GetIndexArray($arraySectores, $valor);
				if($index >= 0)
				{
					$montosOtros += $montosMes[$index];
				}
				// echo " - " . $index . " -<br> "; 				
			}
			elseif(in_array($valor, $arrayPetroquimica))
			{
				$index = GetIndexArray($arraySectores, $valor);
				if($index >= 0)
				{
					$montosPetroquimica += $montosMes[$index];
				}				
			}
			else
			{
				$cont++;
				$index = GetIndexArray($arraySectores, $valor);				
				$resTabla .= "<tr>";
				$resTabla .= "<td>" . $cont  . "</td>";
				$resTabla .= "<td>" . strtoupper($valor)  . "</td>";
				if($index >= 0)
				{
					$resTabla .= "<td>" . CambiarPuntoComa($montosMes[$index]) . "</td>";
				}
				else
				{
					$resTabla .= "<td>0</td>";	
				}				
				$resTabla .= "</tr>";

				$montosTotal += $montosMes[$index];
			}
		}

		// // suma al array cuando no tiene identificador
		// if(in_array('', $arraySectores))
		// {
		// 	$index = GetIndexArray($arraySectores, '');
		// 	$montosOtros += $montosMes[$index];
		// }

		$resTabla .= "<tr>";
		$resTabla .= "<td>" . $cont++  . "</td>";
		$resTabla .= "<td>PETROQUÍMICA</td>";		
		$resTabla .= "<td>" . CambiarPuntoComa($montosPetroquimica) . "</td>";		
		$resTabla .= "</tr>";
		$resTabla .= "<tr>";
		$resTabla .= "<td>" . $cont++  . "</td>";
		$resTabla .= "<td>OTROS</td>";		
		$resTabla .= "<td>" . CambiarPuntoComa($montosOtros) . "</td>";		
		$resTabla .= "</tr>";

		$montosTotal += ($montosPetroquimica + $montosOtros);

		$resTabla .= "<tr>";
		$resTabla .= "<td colspan=2>TOTAL</td>";		
		$resTabla .= "<td>" . CambiarPuntoComa($montosTotal) . "</td>";		
		$resTabla .= "</tr>";
	}
	elseif($tipoReporte == 'provincia')
	{
		foreach($arrayProvincias as $valor)
		{

			if(in_array($valor, $arrayPichincha))
			{
				$index = GetIndexArray($arraySectores, $valor);
				if($index >= 0)
				{
					$montosPichincha += $montosMes[$index];
				}				
			}
			elseif(in_array($valor, $arrayGuayas))
			{
				$index = GetIndexArray($arraySectores, $valor);
				if($index >= 0)
				{
					$montosGuayas += $montosMes[$index];
				}				
			}
			else
			{
				$cont++;
				$index = GetIndexArray($arraySectores, $valor);				
				$resTabla .= "<tr>";
				$resTabla .= "<td>" . $cont  . "</td>";
				$resTabla .= "<td>" . strtoupper($valor)  . "</td>";
				if($index >= 0)
				{
					$resTabla .= "<td>" . CambiarPuntoComa($montosMes[$index]) . "</td>";
				}
				else
				{
					$resTabla .= "<td>0</td>";	
				}				
				$resTabla .= "</tr>";

				$montosTotal += $montosMes[$index];
			}
		}

		$resTabla .= "<tr>";
		$resTabla .= "<td>" . $cont++  . "</td>";
		$resTabla .= "<td>PICHINCHA</td>";		
		$resTabla .= "<td>" . CambiarPuntoComa($montosPichincha) . "</td>";		
		$resTabla .= "</tr>";
		$resTabla .= "<tr>";
		$resTabla .= "<td>" . $cont++  . "</td>";
		$resTabla .= "<td>GUAYAS</td>";		
		$resTabla .= "<td>" . CambiarPuntoComa($montosGuayas) . "</td>";		
		$resTabla .= "</tr>";

		$montosTotal += ($montosPichincha + $montosGuayas);

		$resTabla .= "<tr>";
		$resTabla .= "<td colspan=2>TOTAL</td>";		
		$resTabla .= "<td>" . CambiarPuntoComa($montosTotal) . "</td>";		
		$resTabla .= "</tr>";
	}
	

	return $resTabla;

	// echo $mesInd . " - " . $anioInd . " - " . $tipoOrg . "<br>";
}

function GetIndexArray($arrayBuscar, $valorBuscar)
{
	$tamArrayBuscar = count($arrayBuscar);
	// echo $tamArrayBuscar."<br>";
	$resIndex = -1;
	for($i = 0; $i < $tamArrayBuscar; $i++)
	{
		if($valorBuscar == $arrayBuscar[$i])
		{
			$resIndex = $i;
		}
	}

	return $resIndex;
}

function CambiarPuntoComa($valor)
{
	$cambio = str_replace(".", ",", $valor);
	return $cambio;
}



?>
