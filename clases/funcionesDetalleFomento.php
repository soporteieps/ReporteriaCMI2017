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
$nombresServicios = array('Asesoría para la elaboración de planes de negocio solidarios',
							'Cofinanciamiento para proyectos de la EPS',
							'Asistencia técnica en procesos administrativos',
							'Alianza con instituciones para la AT en procesos operativos');

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
	$sqlNombresIndicadores = "select cod_indicador, indicador from indicador where estado = 1 and departamento = 'FP' order by cod_indicador";
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
		case 10:
		case 11:
		case 12:
		case 16:
		{
			//echo $indicadorSeleccionado . "<br>";
			$tHeader = "<tr class='cabecera'>
							<th>INDICE</th>
							<th>MES REPORTE</th>
							<th>ZONA</th>
							<th>PROVINCIA</th>
							<th>ORGANIZACIÓN</th>
							<th>RUC</th>
							<th>CATEGORÍA ACTIVIDAD MATRIZ PRODUCTIVA</th>
							<th>IDENTIFICACIÓN ACTIVIDAD MP</th>
							<th>NÚMERO DE SOCIOS</th>
							<th>NÚMERO DE CAPACITADOS TOTAL</th>
							<th>NÚMERO DE CAPACITADOS MUJERES TOTAL</th>
							<th>NÚMERO DE CAPACITADOS HOMBRES TOTAL</th>
							<th>CAMPO FOMENTO</th>
							<th>REGISTRO ID</th>							
						</tr>";
			break;
		}
		case 13:		
		{
			$tHeader = "<tr class='cabecera'>
							<th>INDICE</th>
							<th>MES REPORTE</th>
							<th>ZONA</th>
							<th>PROVINCIA</th>
							<th>RUC</th>						
							<th>ORGANIZACIÓN</th>
							<th>ACTIVIDAD</th>
							<th>CATEGORÍA ACTIVIDAD MATRIZ PRODUCTIVA</th>
							<th>IDENTIFICACIÓN ACTIVIDAD MP</th>
							<th>CAMPO FOMENTO</th>
							<th>NÚMERO DE ASISTENTES</th>
							<th>NÚMERO DE SOCIOS</th>							
							<th>ID REGISTRO</th>
						</tr>";
			break;
		}

		case 14:
		case 15:
		{
			$tHeader = "<tr class='cabecera'>
							<th>INDICE</th>
							<th>MES REPORTE</th>
							<th>ZONA</th>
							<th>PROVINCIA</th>
							<th>RUC ORG</th>
							<th>CÉDULA</th>
							<th>APELLIDOS Y NOMBRES</th>							
							<th>GÉNERO</th>
							<th>POBLACIÓN</th>
							<th>GRUPO ÉTINICO</th>
							<th>ORGANIZACIÓN</th>
							<th>ACTIVIDAD</th>														
							<th>CATEGORÍA ACTIVIDAD MATRIZ PRODUCTIVA</th>
							<th>IDENTIFICACIÓN ACTIVIDAD MP</th>
							<th>CAMPO FOMENTO</th>
							<th>ID REGISTRO</th>							
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

	// echo "anio: " . $anioInd . ", mes: " . $mesInd . ", zona: " . $zonaInd . ", indicador: " . $indSeleccionado . "<br>";
	// print_r2($codIndicadores);

	// echo $indSeleccionado .  " - " . $codIndicadores[0] . "<br>";

	// Indicador 1
	if($indSeleccionado == $codIndicadores[0])
	{
		$resDetalle = Indicador01($zonaInd, $mesInd);
		

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 14)
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
						</tr>";
		}
		
		$tabla .= "</table>";
			
	}

	// Indicador 2
	if($indSeleccionado == $codIndicadores[1])
	{
		$resDetalle = Indicador02($zonaInd, $mesInd);

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 14)
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
						</tr>";
		}
		
		$tabla .= "</table>";
		
	}

	// Indicador 3
	if($indSeleccionado == $codIndicadores[2])
	{
		$resDetalle = Indicador03($zonaInd, $mesInd);

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 14)
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
						</tr>";
		}
		
		$tabla .= "</table>";
		
	}

	// Indicador 4

	if($indSeleccionado == $codIndicadores[3])
	{
		$resDetalle = Indicador04($zonaInd, $mesInd);

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 13)
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
						</tr>";
		}
		
		$tabla .= "</table>";
		
	}

	// Indicador 5

	if($indSeleccionado == $codIndicadores[4])
	{
		$resDetalle = Indicador05($zonaInd, $mesInd);		

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 16)
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
						</tr>";
		}

		// ademas se de sumar el numero de beneficiarios por cdh
		// Sumamos las personas beneficiadas para cdh
		$sqlSumPersonasCdh = "select sum(num_per_benef_cdh) as suma from fp_asesoria_asistencia_cofinanciamiento where month(fecha_reporte) = " . $mesInd . " and documentacion_valida = 'si' and year(fecha_reporte) = " . $anioInd . " and zona = " . $zonaInd;

		$resSumPersonasCdh = query($sqlSumPersonasCdh);
		$sumPersonasCdh = 0;
		while($fila = mysql_fetch_array($resSumPersonasCdh))
		{
			$sumPersonasCdh = $fila['suma'];
		}
		
		$tabla .= "<tr><td colspan = '15'>BENEFICIARIOS CDH</td><td>" . $sumPersonasCdh . "</td></tr>";
		$tabla .= "</table>";
		
	}

	// Indicador 6
	if($indSeleccionado == $codIndicadores[5])
	{
		$resDetalle = Indicador06($zonaInd, $mesInd);

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 16)
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
						</tr>";
		}
		
		$tabla .= "</table>";
		
	}

	// Indicador 7
	if($indSeleccionado == $codIndicadores[6])
	{
		$resDetalle = Indicador07($zonaInd, $mesInd);

		$tabla = "<table>";
		$tabla .= getHeaderTablaIndicador($indSeleccionado);
		

		for($i = 0; $i < count($resDetalle); $i += 14)
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

	echo $tabla;




	//echo "Indicador = " . $indSeleccionado . ", año = " . $anioInd . ", mes= " . $mesInd . ", zona = " . $zonaInd . "<br>";
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

	if($tipoInfo == "socios")
	{
		$sqlInfoOrganizacion = "select num_socios from u_organizaciones where cod_u_organizaciones = " . $codOrgConsultar;
		$resInfoOrganizacion = query($sqlInfoOrganizacion);

		while($row = mysql_fetch_array($resInfoOrganizacion))
		{
			
			$infoConsultada = $row['num_socios'];
			
		}
	}

	return $infoConsultada;

}

function Indicador01($zona, $mes)
{

	global $tabla, $nombresIndicadores, $codIndicadores, $nombresServicios;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$orgServicios = array(0, 0, 0, 0, 0);
	$resultadoFinal = array(); 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== PRIMER INDICADOR =======================*/
	/*NUMERO DE ORGANIZACIONES DE LA EPS QUE RECIBIERON  OTRO SERVICIO DE LA DIRECCION DE FOMENTO PRODUCTIVO*/	


	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.antiguedad = 'si'  group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_asesoria_asistencia_cofinanciamiento, fp.cod_servicio, fp.fecha_reporte, fp.cod_provincia, fp.categoria_actividad_mp, fp.identificacion_actividad_mp from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.antiguedad = 'si' order by fp.fecha_reporte asc limit 1";

		//echo $sqlPrimerRegistroOrg . "<br>";
		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_asesoria_asistencia_cofinanciamiento']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_provincia']);
			array_push($orgCodYServicios, $fPrimerRegistro['categoria_actividad_mp']);
			array_push($orgCodYServicios, $fPrimerRegistro['identificacion_actividad_mp']);
		}		
	}

	// echo "<br>Organizaciones<br>";
	// print_r2($orgCodYServicios);
	// echo "<br>Organizaciones<br>";


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 6)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.antiguedad = 'si' and fp.fecha_reporte < '" . $fechaConsultar . "'" ;

		// echo $sqlOrgServAnteriores . "<br>";
		
		$resSqlOrgServAnteriores = query($sqlOrgServAnteriores);

		$numFilas = mysql_num_rows($resSqlOrgServAnteriores);
		//echo "numero de filas= " . $numFilas . "<br>";

		/************************************************************************************************************
		- Si el numero de Filas es mayor a cero quiere decir q es una organizacion vieja q ya a recibido el servicio
		- Si el numero de filas es cero, debemos realizar un ultimo control, que es revisar si la organizacion ha recibido otro servicio, lo cual debera registrarse en la posicion del array de OrganizacionesServicios($orgServicios).		
		************************************************************************************************************/

		if($numFilas == 0)
		{
			// Deshabilitado por peticion del 27-12-2017

			// $sqlOrgOtroServicio = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.fecha_reporte < '" . $fechaConsultar . "'";

			// echo $sqlOrgOtroServicio . "<br>";

			/*****************************************************************************************************************
			- Se puede tener dos resultados:
			-- Si existe registros anteriores con otro codigo de servicio, esta organizacion es antigua y  debe sumar al indicador con respecto a la posicion en el array.
			-- Si no existe ningun otro codigo, esta organizacion es nueva y es su primera vez tomando un servicio de Fomento Productivo, por lo cual no deberia sumar a este indicador
			******************************************************************************************************************/

			// $resOrgOtroServicio = query($sqlOrgOtroServicio);

			// $numFilasOrgOtroServicio = mysql_num_rows($resOrgOtroServicio);
			// if($numFilasOrgOtroServicio == 0)
			// {
				// echo $orgCodYServicios[$i] . "<br>";
				// $orgServicios[$orgCodYServicios[$i + 1] - 1]++;
				array_push($resultadoFinal, $orgCodYServicios[$i]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 1]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 2]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 3]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 4]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 5]);
			// }			
		}
		
	}

	//print_r2($resultadoFinal);
	$resultadoFinal = GetDetalleIndicador($resultadoFinal, $codIndicadores[0]);

	return $resultadoFinal;
	
	
}


function Indicador02($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadores;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$orgServicios = array(0, 0, 0, 0, 0);
	$metaMes = 0;
	$metaAnual = 0;
	$resultadoFinal = array();

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== SEGUNDO INDICADOR =======================*/
	/*NÚMERO DE NUEVAS ORGANIZACIONES DE LA EPS QUE RECIBIERON AL MENOS UN SERVICIO DE LA DIRECCIÓN DE FOMENTO PRODUCTIVO*/	


	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.antiguedad = 'no' group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_reporte, fp.cod_asesoria_asistencia_cofinanciamiento, fp.cod_provincia, fp.categoria_actividad_mp, fp.identificacion_actividad_mp from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.antiguedad = 'no' order by fp.fecha_reporte asc limit 1";

		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_asesoria_asistencia_cofinanciamiento']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_provincia']);
			array_push($orgCodYServicios, $fPrimerRegistro['categoria_actividad_mp']);
			array_push($orgCodYServicios, $fPrimerRegistro['identificacion_actividad_mp']);
		}		
	}

	// echo "<br>Organizaciones<br>";
	// print_r2($orgCodYServicios);
	// echo "<br>Organizaciones<br>";


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 6)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.antiguedad = 'no' and fp.fecha_reporte < '" . $fechaConsultar . "'" ;

		//echo $sqlOrgServAnteriores . "***<br>";
		
		$resSqlOrgServAnteriores = query($sqlOrgServAnteriores);

		$numFilas = mysql_num_rows($resSqlOrgServAnteriores);
		//echo "numero de filas= " . $numFilas . "<br>";

		/************************************************************************************************************
		- Si el numero de Filas es mayor a cero quiere decir q es una organizacion vieja q ya a recibido el servicio
		- Si el numero de filas es cero, debemos realizar un ultimo control, que es revisar si la organizacion ha recibido otro servicio, lo cual debera registrarse en la posicion del array de OrganizacionesServicios($orgServicios).		
		************************************************************************************************************/

		if($numFilas == 0)
		{
			// Deshabilitado por peticion de fomento productivo el 27-12-2017

			// $sqlOrgOtroServicio = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.fecha_registro < '" . $fechaConsultar . "'";

			//echo $sqlOrgOtroServicio . "<br>";

			/*****************************************************************************************************************
			- Se puede tener dos resultados:
			-- Si existe registros anteriores con otro codigo de servicio, esta organizacion es antigua y no debe sumar al indicador.
			-- Si no existe ningun otro codigo, esta organizacion es nueva y es su primera vez tomando un servicio de Fomento Productivo, por lo cual debe supara 1 al valor del servicio
			******************************************************************************************************************/

			// $resOrgOtroServicio = query($sqlOrgOtroServicio);

			// $numFilasOrgOtroServicio = mysql_num_rows($resOrgOtroServicio);
			// if($numFilasOrgOtroServicio == 0)
			// {
				//echo $orgCodYServicios[$i] . " nueva<br>";
				// $orgServicios[$orgCodYServicios[$i + 1] - 1]++;

				array_push($resultadoFinal, $orgCodYServicios[$i]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 1]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 2]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 3]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 4]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 5]);
			// }			
		}
		
	}

	//print_r2($resultadoFinal);
	$resultadoFinal = GetDetalleIndicador($resultadoFinal, $codIndicadores[1]);
	return $resultadoFinal;

}



function Indicador03($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadores;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$orgServicios = array(0, 0, 0, 0, 0);
	$resultadoFinal = array();
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== TERCER INDICADOR =======================*/
	/*'NÚMERO DE UNIDADES ECONÓMICAS Y SOLIDARIAS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DFP*/


	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.documentacion_valida = 'si' and u.tipo = 'uep' group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_reporte, fp.cod_asesoria_asistencia_cofinanciamiento, fp.cod_provincia, fp.categoria_actividad_mp, fp.identificacion_actividad_mp from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and fp.documentacion_valida = 'si' and u.tipo = 'uep'  order by fp.fecha_reporte asc limit 1";

		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_asesoria_asistencia_cofinanciamiento']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_provincia']);
			array_push($orgCodYServicios, $fPrimerRegistro['categoria_actividad_mp']);
			array_push($orgCodYServicios, $fPrimerRegistro['identificacion_actividad_mp']);
		}		
	}

	// echo "<br>Organizaciones<br>";
	// print_r2($orgCodYServicios);
	// echo "<br>Organizaciones<br>";


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 6)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and u.tipo = 'uep' and fp.documentacion_valida = 'si' and fp.fecha_reporte < '" . $fechaConsultar . "'" ;

		//echo $sqlOrgServAnteriores . "***<br>";
		
		$resSqlOrgServAnteriores = query($sqlOrgServAnteriores);

		$numFilas = mysql_num_rows($resSqlOrgServAnteriores);
		//echo "numero de filas= " . $numFilas . "<br>";

		/************************************************************************************************************
		- Si el numero de Filas es mayor a cero quiere decir q es una uep vieja q ya a recibido el servicio
		- Si el numero de filas es cero, debemos realizar un ultimo control, que es revisar si la organizacion ha recibido otro servicio, lo cual debera registrarse en la posicion del array de OrganizacionesServicios($orgServicios).		
		************************************************************************************************************/

		if($numFilas == 0)
		{

			//Esto se pide deshabilitar por parte de fomento el 27-12-2017

			// $sqlOrgOtroServicio = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and u.tipo = 'uep' and fp.documentacion_valida = 'si' and fp.fecha_registro < '" . $fechaConsultar . "'";

			//echo $sqlOrgOtroServicio . "<br>";

			/*****************************************************************************************************************
			- Se puede tener dos resultados:
			-- Si existe registros anteriores con otro codigo de servicio, esta organizacion es antigua y no debe sumar al indicador.
			-- Si no existe ningun otro codigo, esta organizacion es nueva y es su primera vez tomando un servicio de Fomento Productivo, por lo cual debe supara 1 al valor del servicio
			******************************************************************************************************************/

			// $resOrgOtroServicio = query($sqlOrgOtroServicio);

			// $numFilasOrgOtroServicio = mysql_num_rows($resOrgOtroServicio);
			// if($numFilasOrgOtroServicio == 0)
			// {
				// $orgServicios[$orgCodYServicios[$i + 1] - 1]++;
				array_push($resultadoFinal, $orgCodYServicios[$i]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 1]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 2]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 3]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 4]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 5]);
			// }			
		}
		
	}

	// print_r2($resultadoFinal);
	$resultadoFinal = GetDetalleIndicador($resultadoFinal, $codIndicadores[2]);
	return $resultadoFinal;


}



function Indicador04($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadores;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$orgServicios = array(0, 0, 0, 0, 0);
	$resultadoFinal = array();
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== CUARTO INDICADOR =======================*/
	/*NÚMERO DE CIRCUITOS ECONÓMICOS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DFP*/

	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and u.circuito_economico = 'si' and fp.documentacion_valida = 'si' group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_reporte, fp.cod_asesoria_asistencia_cofinanciamiento, fp.cod_provincia, fp.categoria_actividad_mp, fp.identificacion_actividad_mp from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and u.circuito_economico = 'si' and fp.documentacion_valida = 'si' order by fp.fecha_reporte asc limit 1";

		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_asesoria_asistencia_cofinanciamiento']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_provincia']);
			array_push($orgCodYServicios, $fPrimerRegistro['categoria_actividad_mp']);
			array_push($orgCodYServicios, $fPrimerRegistro['identificacion_actividad_mp']);
		}		
	}

	// echo "<br>Organizaciones<br>";
	// print_r2($orgCodYServicios);
	// echo "<br>Organizaciones<br>";


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 6)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and fp.documentacion_valida = 'si' and u.circuito_economico = 'si' and fp.fecha_reporte < '" . $fechaConsultar . "'" ;

		//echo $sqlOrgServAnteriores . "***<br>";
		
		$resSqlOrgServAnteriores = query($sqlOrgServAnteriores);

		$numFilas = mysql_num_rows($resSqlOrgServAnteriores);
		//echo "numero de filas= " . $numFilas . "<br>";

		/************************************************************************************************************
		- Si el numero de Filas es mayor a cero quiere decir q es una organizacion vieja q ya a recibido el servicio
		- Si el numero de filas es cero, debemos realizar un ultimo control, que es revisar si la organizacion ha recibido otro servicio, lo cual debera registrarse en la posicion del array de OrganizacionesServicios($orgServicios).		
		************************************************************************************************************/

		if($numFilas == 0)
		{
			$sqlOrgOtroServicio = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and u.circuito_economico = 'si' and fp.documentacion_valida = 'si' and fp.fecha_reporte < '" . $fechaConsultar . "'";

			//echo $sqlOrgOtroServicio . "<br>";

			/*****************************************************************************************************************
			- Se puede tener dos resultados:
			-- Si existe registros anteriores con otro codigo de servicio, esta organizacion es antigua y no debe sumar al indicador.
			-- Si no existe ningun otro codigo, esta organizacion es nueva y es su primera vez tomando un servicio de Fomento Productivo, por lo cual debe supara 1 al valor del servicio
			******************************************************************************************************************/

			$resOrgOtroServicio = query($sqlOrgOtroServicio);

			$numFilasOrgOtroServicio = mysql_num_rows($resOrgOtroServicio);
			if($numFilasOrgOtroServicio == 0)
			{
				// $orgServicios[$orgCodYServicios[$i + 1] - 1]++;
				array_push($resultadoFinal, $orgCodYServicios[$i]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 1]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 2]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 3]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 4]);
				array_push($resultadoFinal, $orgCodYServicios[$i + 5]);

			}


		}
		
	}

	//print_r2($resultadoFinal);
	$resultadoFinal = GetDetalleIndicador($resultadoFinal, $codIndicadores[3]);
	return $resultadoFinal;



}



function Indicador05($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadores;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	$resultadoFinal = array();
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$orgServicios = array(0, 0, 0, 0, 0);
	$metaMes = 0;
	$metaAnual = 0;
	$numSocios = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== QUINTO INDICADOR =======================*/
	/*NÚMERO DE PERSONAS DE LA EPS QUE ACCEDEN A PLAZAS DE TRABAJO A TRAVÉS DE COFINANCIAMIENTO*/

	//consultamos la meta programada	

	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_servicio = 2 and fp.documentacion_valida = 'si' group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_reporte, fp.cod_asesoria_asistencia_cofinanciamiento, fp.cod_provincia, fp.categoria_actividad_mp, fp.identificacion_actividad_mp from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and fp.cod_servicio = 2 and fp.documentacion_valida = 'si' order by fp.fecha_reporte asc limit 1";

		//echo $sqlPrimerRegistroOrg . "<br>";
		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_asesoria_asistencia_cofinanciamiento']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_provincia']);
			array_push($orgCodYServicios, $fPrimerRegistro['categoria_actividad_mp']);
			array_push($orgCodYServicios, $fPrimerRegistro['identificacion_actividad_mp']);
		}		
	}

	/*echo "<br>Organizaciones<br>";
	print_r2($orgCodYServicios);
	echo "<br>Organizaciones<br>";*/

	
	$sociosServicio2 = array();
	
	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 6)
	{
		//$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.documentacion_valida = 'si' and fp.cod_servicio = 2 and fp.fecha_reporte < '" . $fechaConsultar . "'" ;

		//echo $sqlOrgServAnteriores . "***<br>";
		
		//$resSqlOrgServAnteriores = query($sqlOrgServAnteriores);

		//$numFilas = mysql_num_rows($resSqlOrgServAnteriores);
		//echo "numero de filas= " . $numFilas . "<br>";

		/************************************************************************************************************
		- Si el numero de Filas es mayor a cero quiere decir q es una organizacion vieja q ya a recibido el servicio
		- Si el numero de filas es cero, quiere decir que es la primera vez que se registra el servicio por lo cual hay que contar los socios de la organizacion.		
		************************************************************************************************************/

		//if($numFilas == 0)
		//{
			//$sqlOrgOtroServicio = "select fp.num_personas_cofinanciamiento from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (fp.cod_u_organizaciones = u.cod_u_organizaciones) where fp.cod_asesoria_asistencia_cofinanciamiento = " . $orgCodYServicios[$i + 1];

			$sqlNumPersonas = "select cedula from fp_asesoria_asistencia_cofinanciamiento_socios where cod_fp_asesoria_asistencia_cofinanciamiento = " . $orgCodYServicios[$i + 2] . " and cod_u_organizaciones = " . $orgCodYServicios[$i];

			//echo $sqlOrgOtroServicio . "<br>";

			

			$resNumPersonas = query($sqlNumPersonas);
			while($fila = mysql_fetch_array($resNumPersonas))
			{
				array_push($sociosServicio2, $fila['cedula']);				
			}			
		//}
		
	}

	// Si existen cedulas, elimino las duplicadas
	if(count($sociosServicio2) > 0)
	{
		$sociosServicio2 = array_unique($sociosServicio2);
		$sociosServicio2 = array_values($sociosServicio2);
	}

	//print_r2($sociosServicio2);
	$resultadoFinal = GetDetalleIndicador($sociosServicio2, $codIndicadores[4]);	

	return $resultadoFinal;

	// $orgServicios[1] += $sumPersonasCdh;

	
}



function Indicador06($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadores;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	$cedulaSocios = array();
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$orgServicios = array(0, 0, 0, 0, 0);
	$resultadoFinal = array();
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 
	$fechaInicial = $anioInd .'-01-01';

	/*=========== SEXTO INDICADOR =======================*/
	/*NÚMERO DE PERSONAS DE LA EPS QUE ACCEDEN AL MENOS A UN SERVICIO DE LA DFP ENMARCADOS EN LA ESTRATEGIA DEL CAMBIO EN LA MATRIZ PRODUCTIVA*/

	//consultamos la meta programada


	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.categoria_actividad_mp <> 'no_priorizado_en_el_cambio_matriz_productiva' and fp.documentacion_valida = 'si' and fp.cod_servicio <> 1 group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_reporte, fp.cod_asesoria_asistencia_cofinanciamiento from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and fp.categoria_actividad_mp <> 'no_priorizado_en_el_cambio_matriz_productiva' and fp.cod_servicio <> 1 and fp.documentacion_valida = 'si' order by fp.fecha_reporte asc limit 1";

		//echo $sqlPrimerRegistroOrg . "<br>";

		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_asesoria_asistencia_cofinanciamiento']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_provincia']);
			array_push($orgCodYServicios, $fPrimerRegistro['categoria_actividad_mp']);
			array_push($orgCodYServicios, $fPrimerRegistro['identificacion_actividad_mp']);
		}		
	}

	// echo "<br>Organizaciones<br>";
	// print_r2($orgCodYServicios);
	// echo "<br>Organizaciones<br>";


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	
	$sociosServicio2 = array();
	
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 6)
	{
		//$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and fp.documentacion_valida = 'si' and fp.fecha_reporte >= '" . $fechaInicial ."' and fp.fecha_reporte < '" . $fechaConsultar . "'" ;

		//echo $sqlOrgServAnteriores . " <br>";
		
		//$resSqlOrgServAnteriores = query($sqlOrgServAnteriores);



		//$numFilas = mysql_num_rows($resSqlOrgServAnteriores);
		// echo "numero de filas= " . $numFilas . "<br>";

		/************************************************************************************************************
		- Si el numero de Filas es mayor a cero quiere decir q es una organizacion vieja q ya a recibido el servicio y las personas beneficiadas no deben ser contadas
		- Si el numero de filas es cero, debemos sumar las personas beneficiadas.		
		************************************************************************************************************/

		// if($numFilas == 0)
		// {
			$sqlNumPersonas = "select cedula from fp_asesoria_asistencia_cofinanciamiento_socios where cod_fp_asesoria_asistencia_cofinanciamiento = " . $orgCodYServicios[$i + 2] . " and cod_u_organizaciones = " . $orgCodYServicios[$i];

			//$sqlNumPersonas = "select fp.num_per_urbanas, fp.num_per_rurales from fp_asesoria_asistencia_cofinanciamiento fp where fp.cod_asesoria_asistencia_cofinanciamiento = " . $orgCodYServicios[$i + 2];

			//echo $sqlNumPersonas . "<br>";	

			$resNumPersonas = query($sqlNumPersonas);
			while($fila = mysql_fetch_array($resNumPersonas))
			{
				array_push($sociosServicio2, $fila['cedula']);				
			}		

			
			
						
		// }
		
	}

	

	// Si existen cedulas, elimino las duplicadas
	if(count($sociosServicio2) > 0)
	{
		$sociosServicio2 = array_unique($sociosServicio2);
		$sociosServicio2 = array_values($sociosServicio2);
	}

	//print_r2($sociosServicio2);
	$resultadoFinal = GetDetalleIndicador($sociosServicio2, $codIndicadores[5]);	

	return $resultadoFinal;

}




function Indicador07($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadores;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$orgServicios = array(0, 0, 0, 0, 0); 
	$metaMes = 0;
	$metaAnual = 0;
	$resultadoFinal = array();

	//fecha a consultar-formato: Y-m-d
	$fechaInicial = $anioInd .'-01-01';
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01';
	$mesInicial = $mesInd - 2; 

	/*=========== SEPTIMO INDICADOR =======================*/
	/*NÚMERO DE ORGANIZACIONES QUE HAN RECIBIDO PROCESOS DE ASISTENCIA TÉCNICA*/

	
	

	//sql que consulta las organizaciones en el mes indicado
	// *******************************************
	// MODIFICACION 27-12-2017
	// El indicador tambien debe sumar las ueps
	//*********************************************
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) >= " . $mesInicial . " and month(fp.fecha_reporte) <= " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ."  and fp.documentacion_valida = 'si' and fp.cod_servicio = 3 group by fp.cod_u_organizaciones";

	// echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_reporte, fp.cod_asesoria_asistencia_cofinanciamiento, fp.cod_provincia, fp.categoria_actividad_mp, fp.identificacion_actividad_mp from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) >= " . $mesInicial . " and month(fp.fecha_reporte) <= " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . "  and fp.documentacion_valida = 'si' and fp.cod_servicio = 3  order by fp.fecha_reporte asc limit 1";



		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_asesoria_asistencia_cofinanciamiento']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_provincia']);
			array_push($orgCodYServicios, $fPrimerRegistro['categoria_actividad_mp']);
			array_push($orgCodYServicios, $fPrimerRegistro['identificacion_actividad_mp']);
		}		
	}

	/*echo "<br>Organizaciones<br>";
	print_r2($orgCodYServicios);
	echo "<br>Organizaciones<br>";*/


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 6)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and fp.fecha_reporte > '" . $fechaInicial . "' and fp.documentacion_valida = 'si' and month(fp.fecha_reporte) < " . $mesInicial;

		// echo $sqlOrgServAnteriores . "<br>";
		
		$resSqlOrgServAnteriores = query($sqlOrgServAnteriores);

		$numFilas = mysql_num_rows($resSqlOrgServAnteriores);
		//echo "numero de filas= " . $numFilas . "<br>";

		/************************************************************************************************************
		- Si el numero de Filas es mayor a cero quiere decir q es una organizacion vieja q ya a recibido el servicio
		- Si el numero de filas es cero quiere decir que en este mes es la primera vez que tiene el servicio.		
		************************************************************************************************************/

		if($numFilas == 0)
		{
			
			array_push($resultadoFinal, $orgCodYServicios[$i]);
			array_push($resultadoFinal, $orgCodYServicios[$i + 1]);
			array_push($resultadoFinal, $orgCodYServicios[$i + 2]);
			array_push($resultadoFinal, $orgCodYServicios[$i + 3]);
			array_push($resultadoFinal, $orgCodYServicios[$i + 4]);
			array_push($resultadoFinal, $orgCodYServicios[$i + 5]);
						
		}
		
	}

	//print_r2($resultadoFinal);
	$resultadoFinal = GetDetalleIndicador($resultadoFinal, $codIndicadores[6]);

	return $resultadoFinal;

	
	
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

function GetDetalleIndicador($aOrganizaciones, $indicador)
{
	// Indicador 01
	global $nombresMes, $nombresServicios, $codIndicadores;
	$detalle = array();
	$indice = 0;
	$mesInd = getMes();
	$zonaInd = getZona();
	$anioInd = getAnioSeleccionado();
	// INDICADOR 01
	if($indicador == $codIndicadores[0] || $indicador == $codIndicadores[1] || $indicador == $codIndicadores[2] || $indicador == $codIndicadores[6])
	{
		// revisamos si el array esta lleno o tiene organizaciones reportadas
		$numAOrganizaciones = count($aOrganizaciones);
		// echo $numAOrganizaciones . "<br>";

		if($numAOrganizaciones > 0)
		{
			// Formamos el detalle que se necesite en el indicador
			// *****************************************************
			// Posiciones del array:
			// 0 : codigo Organizacion
			// 1 : codigo del servicio
			// 2 : codigo de la tabla de fomento productivo
			// 3 : codigo de provincia
			// *******************************************************

			for($i = 0; $i < $numAOrganizaciones; $i = $i + 6)
			{
				$codOrg = $aOrganizaciones[$i];
				$codServicioFomento = $aOrganizaciones[$i + 2];
				$servicioFomento = $aOrganizaciones[$i + 1];

				// indice
				$indice++;
				array_push($detalle, $indice);

				// mes de reporte
				array_push($detalle, $nombresMes[$mesInd - 1]);

				// zona consulta
				array_push($detalle, $zonaInd);

				// provincia
				$provOrg = GetNombreProvincia($zonaInd, $aOrganizaciones[$i + 3]);
				array_push($detalle, $provOrg);

				// Organizacion
				$nombreOrg = GetInformacionOrg($codOrg, "nombre");
				array_push($detalle, $nombreOrg);

				// ruc de organizacion
				$rucOrg = GetInformacionOrg($codOrg, "ruc");
				array_push($detalle, $rucOrg);

				// categoria matriz productiva
				array_push($detalle, $aOrganizaciones[$i + 4]);

				// actividad matriz productiva
				array_push($detalle, $aOrganizaciones[$i + 5]);

				// numero de socios
				$numSociosOrg = GetInformacionOrg($codOrg, "socios");
				array_push($detalle, $numSociosOrg);

				// numero de capacitados
				$sqlSociosReportados = "select count(distinct cedula) as numCedula from fp_asesoria_asistencia_cofinanciamiento_socios where cod_u_organizaciones = " . $codOrg . " and cod_fp_asesoria_asistencia_cofinanciamiento = " . $codServicioFomento;
				// echo $sqlSociosReportados . "<br>";
				$resSociosReportados = query($sqlSociosReportados);
				while($fila = mysql_fetch_array($resSociosReportados))
				{
					array_push($detalle, $fila['numCedula']);
				}

				// numero capacitados mujeres, hombres
				$sqlSociosMujeres = "select fp.cedula, s.genero from fp_asesoria_asistencia_cofinanciamiento_socios as fp inner join socios s on (fp.cod_socios = s.cod_socios) where fp.cod_u_organizaciones = " . $codOrg . " and fp.cod_fp_asesoria_asistencia_cofinanciamiento = " . $codServicioFomento . " group by fp.cedula";
				// echo $sqlSociosMujeres . "<br>";
				$resSociosMujeres = query($sqlSociosMujeres);
				$mujeresReportados = 0;
				$hombresReportados = 0;
				while($fila = mysql_fetch_array($resSociosMujeres))
				{
					if($fila['genero'] == 'mujer')
						$mujeresReportados++;
					if($fila['genero'] == 'hombre')
						$hombresReportados++; 
				}
				array_push($detalle, $mujeresReportados);
				array_push($detalle, $hombresReportados);

				// Servicio de Fomento
				$servicioFomento = $nombresServicios[$servicioFomento - 1];
				array_push($detalle, $servicioFomento);

				// Registro en CMI Fomento
				array_push($detalle, $codServicioFomento);





			}
			
		}
	}

	if($indicador == $codIndicadores[3])
	{
		// revisamos si el array esta lleno o tiene organizaciones reportadas
		$numAOrganizaciones = count($aOrganizaciones);
		// echo $numAOrganizaciones . "<br>";

		if($numAOrganizaciones > 0)
		{
			// Formamos el detalle que se necesite en el indicador
			// *****************************************************
			// Posiciones del array:
			// 0 : codigo Organizacion
			// 1 : codigo del servicio
			// 2 : codigo de la tabla de fomento productivo
			// 3 : codigo de provincia
			// *******************************************************

			for($i = 0; $i < $numAOrganizaciones; $i = $i + 6)
			{
				$codOrg = $aOrganizaciones[$i];
				$codServicioFomento = $aOrganizaciones[$i + 2];
				$servicioFomento = $aOrganizaciones[$i + 1];

				// indice
				$indice++;
				array_push($detalle, $indice);

				// mes de reporte
				array_push($detalle, $nombresMes[$mesInd - 1]);

				// zona consulta
				array_push($detalle, $zonaInd);

				// provincia
				$provOrg = GetNombreProvincia($zonaInd, $aOrganizaciones[$i + 3]);
				array_push($detalle, $provOrg);

				// ruc de organizacion
				$rucOrg = GetInformacionOrg($codOrg, "ruc");
				array_push($detalle, $rucOrg);

				// Organizacion
				$nombreOrg = GetInformacionOrg($codOrg, "nombre");
				array_push($detalle, $nombreOrg);

				// Actividad
				$actividadOrg = GetInformacionOrg($codOrg, "actividad");
				array_push($detalle, $actividadOrg);				

				// categoria matriz productiva
				array_push($detalle, $aOrganizaciones[$i + 4]);

				// actividad matriz productiva
				array_push($detalle, $aOrganizaciones[$i + 5]);

				// Servicio de Fomento
				$servicioFomento = $nombresServicios[$servicioFomento - 1];
				array_push($detalle, $servicioFomento);

				// numero de capacitados
				$sqlSociosReportados = "select count(cedula) as numCedula from fp_asesoria_asistencia_cofinanciamiento_socios where cod_u_organizaciones = " . $codOrg . " and cod_fp_asesoria_asistencia_cofinanciamiento = " . $codServicioFomento;
				//echo $sqlSociosReportados . "<br>";
				$resSociosReportados = query($sqlSociosReportados);
				while($fila = mysql_fetch_array($resSociosReportados))
				{
					array_push($detalle, $fila['numCedula']);
				}

				// numero de socios
				$numSociosOrg = GetInformacionOrg($codOrg, "socios");
				array_push($detalle, $numSociosOrg);

				// Registro en CMI Fomento
				array_push($detalle, $codServicioFomento);

			}
			
		}
	}

	if($indicador == $codIndicadores[4] || $indicador == $codIndicadores[5])
	{
		// revisamos si el array esta lleno, en este caso de cédulas
		$cedulasOrganizacion = $aOrganizaciones;
		$numCedulasReportadas = count($cedulasOrganizacion);
		// echo $numCedulasReportadas . "<br>";

		if($numCedulasReportadas > 0)
		{
			// print_r2($cedulasOrganizacion);

			// Se arma el detalle del indicador
			foreach($cedulasOrganizacion as $valor)
			{
				// Indice
				$indice++;
				array_push($detalle, $indice);

				// mes de reporte
				$sqlReporte = "select * from fp_asesoria_asistencia_cofinanciamiento_socios where cedula = '" . $valor . "' and month(fecha_reporte_fp) = " . $mesInd . " and year(fecha_reporte_fp) = " . $anioInd;
				//echo $sqlReporte . "<br>";
				$resReporte = query($sqlReporte);
				$codOrg = 0;
				$codRegistroFomento = 0;
				while($filaReporte = mysql_fetch_array($resReporte))
				{
					$codOrg = $filaReporte['cod_u_organizaciones'];
					$codRegistroFomento = $filaReporte['cod_fp_asesoria_asistencia_cofinanciamiento'];
				}

				//echo $indice . " - " . $codOrg . " - " . $codRegistroFomento . "<br>";
				$sqlProvincia = "select cod_provincia, categoria_actividad_mp, identificacion_actividad_mp, cod_servicio, month(fecha_reporte) as mesReporte from fp_asesoria_asistencia_cofinanciamiento where cod_asesoria_asistencia_cofinanciamiento = " . $codRegistroFomento . " and cod_u_organizaciones = " . $codOrg . " and zona = " . $zonaInd;
				$resProvincia = query($sqlProvincia);
				$codProv = 0;
				$categoriaRegistro = "";
				$identificacionCategoriaRegistro = "";
				$servicioDetalle = 0;
				$mesAlianzas = 0;
				while($filaProv = mysql_fetch_array($resProvincia))
				{
					$codProv = $filaProv['cod_provincia'];
					$categoriaRegistro = $filaProv['categoria_actividad_mp'];
					$identificacionCategoriaRegistro = $filaProv['identificacion_actividad_mp'];
					$servicioDetalle = $filaProv['cod_servicio'];
					$mesAlianzas = $filaProv['mesReporte'];
				}

				if($indicador == $codIndicadores[5])
				{
					array_push($detalle, $nombresMes[$mesAlianzas - 1]);
				}
				else
				{
					array_push($detalle, $nombresMes[$mesInd - 1]);
				}				

				// zona
				array_push($detalle, $zonaInd);

				// provincia
				$codProv = GetNombreProvincia($zonaInd, $codProv);
				array_push($detalle, $codProv);

				// Ruc de organizacion
				$rucOrg = GetInformacionOrg($codOrg, "ruc");
				array_push($detalle, $rucOrg);

				// cedula
				array_push($detalle, $valor);

				//info del socio
				// ***************************************
				// apellidos
				// genero
				// poblacion
				//****************************************
				$sqlInfoConsultada = "select apellidos, genero, poblacion, grupo_etnico from socios where cedula = " . $valor . " and cod_u_organizaciones = " . $codOrg . " and estado = 1";
				$resInfoConsultada = query($sqlInfoConsultada);
				while($resInfo = mysql_fetch_array($resInfoConsultada))
				{
					// $infoConsultada = $resInfo['apellidos'];
					array_push($detalle, $resInfo['apellidos']);
					array_push($detalle, $resInfo['genero']);
					array_push($detalle, $resInfo['poblacion']);
					array_push($detalle, $resInfo['grupo_etnico']);
				}

				// Organizacion, actividad
				$sqlOrganizacion = "select organizacion, actividad from u_organizaciones where cod_u_organizaciones = " . $codOrg;
				// echo $sqlOrganizacion . "<br>";
				$resOrganizacion = query($sqlOrganizacion);
				while($resInfo = mysql_fetch_array($resOrganizacion))
				{
					array_push($detalle, $resInfo['organizacion']);
					array_push($detalle, $resInfo['actividad']);
				}

				//categoria actividad mp
				array_push($detalle, $categoriaRegistro);

				// identificacion mp
				array_push($detalle, $identificacionCategoriaRegistro);

				// campo fomento
				array_push($detalle, $nombresServicios[$servicioDetalle - 1]);

				// id registro
				array_push($detalle, $codRegistroFomento);



				






			}
		}
	}

	

	return $detalle;

}

function GetInformacionSocio($cedula, $codOrganizacion, $tipoInfo)
{
	$infoConsultada = "";
	$sqlInfoConsultada = "";
	if($tipoInfo == "apellidos")
	{
		$sqlInfoConsultada = "select apellidos from socios where cedula = " . $cedula . " and cod_u_organizaciones = " . $codOrganizacion . " and estado = 1";
		$resInfoConsultada = query($sqlInfoConsultada);
		while($resInfo = mysql_fetch_array($resInfoConsultada))
		{
			$infoConsultada = $resInfo['apellidos'];
		}
	}

	if($tipoInfo == "genero")
	{
		$sqlInfoConsultada = "select genero from socios where cedula = " . $cedula . " and cod_u_organizaciones = " . $codOrganizacion . " and estado = 1";
		$resInfoConsultada = query($sqlInfoConsultada);
		while($resInfo = mysql_fetch_array($resInfoConsultada))
		{
			$infoConsultada = $resInfo['genero'];
		}
	}

	if($tipoInfo == "poblacion")
	{
		$sqlInfoConsultada = "select poblacion from socios where cedula = " . $cedula . " and cod_u_organizaciones = " . $codOrganizacion . " and estado = 1";
		$resInfoConsultada = query($sqlInfoConsultada);
		while($resInfo = mysql_fetch_array($resInfoConsultada))
		{
			$infoConsultada = $resInfo['poblacion'];
		}
	}


	return $infoConsultada;
}



?>
