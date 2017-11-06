<?php
include '../lib/dbconfig.php';

//tomo los datos enviados
$idIndicador = $_POST['idIndicador'];
$idZona = $_POST['idZona'];
$idMes = $_POST['idMes'];

$tabla = "<table>
			<tr>
				<th colspan='6'>SERVICIOS DE LA DIRECCION</th>
				<th colspan='4'>CUMPLIMIENTO</th>
			</tr>
			<tr>
				<th>INDICADORES</th>
				<th>Asesoría para la elaboración de planes de negocio solidarios.</th>
				<th>Cofinanciamiento para proyectos de la EPS.</th>
				<th>Asistencia técnica en procesos administrativos.</th>
				<th>Alianza con instituciones para la AT en procesos operativos.</th>
				<th>Zona.</th>
				<th>Mes.</th>
				<th class='total'>Total.</th>
				<th>Meta Periodo.</th>
				<th>% Ejecutado.</th>
				<th>Meta Anual.</th>
				<th>%Avance.</th>
			</tr>";

//Indicadores
$nombresIndicadores = array('NÚMERO DE ORGANIZACIONES DE LA EPS QUE RECIBIERON OTRO SERVICIO DE LA DIRECCIÓN DE FOMENTO PRODUCTIVO',
		'NÚMERO DE NUEVAS ORGANIZACIONES DE LA EPS QUE RECIBIERON AL MENOS UN SERVICIO DE LA DIRECCIÓN DE FOMENTO PRODUCTIVO',
		'NÚMERO DE UNIDADES ECONÓMICAS Y SOLIDARIAS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DFP',
		'NÚMERO DE CIRCUITOS ECONÓMICOS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DFP',
		'NÚMERO DE PERSONAS DE LA EPS QUE ACCEDEN A PLAZAS DE TRABAJO A TRAVÉS DE COFINANCIAMIENTO',
		'NÚMERO DE PERSONAS DE LA EPS QUE ACCEDEN AL MENOS A UN SERVICIO DE LA DFP ENMARCADOS EN LA ESTRATEGIA DEL CAMBIO EN LA MATRIZ PRODUCTIVA',
		'NÚMERO DE ORGANIZACIONES QUE HAN RECIBIDO PROCESOS DE ASISTENCIA TÉCNICA');

Indicador01();

function Indicador01($zona, $mes)
{
	$idZona = -1;
	$idMes = -1;
	
	
	/*=========== PRIMER INDICADOR =======================*/
	/*NUMERO DE ORGANIZACIONES DE LA EPS QUE RECIBIERON  OTRO SERVICIO DE LA DIRECCION DE FOMENTO PRODUCTIVO*/

	//solo debe reportarse una sola vez 
	// se debe de clasificar por el tipo de servicio que se recibe

	//variables que funcionaran si el mes es diferente a enero
	$auxSqlGlobal = "";
	$auxOrgReportadas = array();	
	$matrixMesZona = array();
	$auxServicios = array(0, 0, 0 ,0, 0);
	$metasZonaMes = array();
	$metasAnuales = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

	//consultamos la meta programada
	$sqlMetaProgramada = "
	select i.indicador, iz.cod_zona, izm.mes, izm.meta_programada 
	from indicador_zona_mes izm
	inner join indicador_zona iz on (iz.cod_indicador_zona = izm.cod_indicador_zona)
	inner join indicador i on (i.cod_indicador = iz.cod_indicador)
	where i.cod_indicador = 41";	

	if($idMes != -1)
	{
		$sqlMetaProgramada .= " and izm.mes = " . $idMes;

	}
	if($idZona != -1)
	{
		$sqlMetaProgramada .=" and iz.cod_zona = " .$idZona;
	}

	//enceramos todos los datos de $matrixMesZona y $metasZonaMes
	for($i = 0; $i < 9; $i++)
	{
		for($j = 0; $j < 12; $j++)
		{
			$matrixMesZona[$i][$j] = $auxServicios;
			$metasZonaMes[$i][$j] = 0;
		}

	}	

	$resMetas = query($sqlMetaProgramada);
	$auxMes = 0;			//sirven para recorrer los array
	$auxZona = 0;			//sirven para reccorre los array

	while($fila = mysql_fetch_array($resMetas))
	{
		if($idZona != -1 && $idMes != -1)
		{
			// se escogio un mes y una zona
			$metasZonaMes[$idZona - 1][$idMes - 1] = $fila['meta_programada'];
		}
		if($idZona != -1 && $idMes == -1)
		{
			//se escogio una zona pero no un mes
			$metasZonaMes[$idZona - 1][$auxMes] = $fila['meta_programada'];
			$auxMes++;
			if($auxMes >= 12)
				$auxMes = 0;
		}
		if($idZona == -1 && $idMes != -1)
		{
			//se escogio un mes pero no una zona
			$metasZonaMes[$auxZona][$idMes - 1] = $fila['meta_programada'];
			$auxZona++;
			if($auxZona >= 9)
				$auxZona = 0;
		}
		if($idZona == -1 && $idMes == -1)
		{
			// no se escojio un mes o zona
			$metasZonaMes[$auxZona][$auxMes] = $fila['meta_programada'];			
			$auxMes++;
			if($auxMes >= 12)
			{
				$auxMes = 0;
				$auxZona++;
			}
		}
	}

	echo "<br>META PROGRAMADA <br>";
	print_r2($metasZonaMes);
	echo "<br>META PROGRAMADA <br>";
	

	//sql meta anual por zona
	$sqlMetaAnual = "select i.indicador, iz.cod_zona, izm.mes, sum(izm.meta_programada) as suma
	from indicador_zona_mes izm
	inner join indicador_zona iz on (iz.cod_indicador_zona = izm.cod_indicador_zona)
	inner join indicador i on (i.cod_indicador = iz.cod_indicador)
	where i.cod_indicador = 41 
	group by iz.cod_zona";

	$resMetaAnual = query($sqlMetaAnual);
	$auxCont = 0;
	while($fila = mysql_fetch_array($resMetaAnual))
	{
		$metasAnuales[$auxCont] = $fila['suma'];
		$auxCont++;
	}

	echo "<br>META anuales <br>";
	print_r2($metasAnuales);
	echo "<br>META anulaes <br>";


	
	//sql global, de ahi tomaremos los datos necesarios

	$sqlGlobal = "select u.cod_u_organizaciones
	from u_organizaciones u
	inner join fp_asesoria_asistencia_cofinanciamiento fp on (fp.cod_u_organizaciones = u.cod_u_organizaciones)
	inner join servicio s on (s.cod_servicio = fp.cod_servicio)
	where year(u.fecha_registro) = 2015 and u.tipo = 'org'";

	//se revisa si el idZona esta definido
	if($idZona != -1)
	{
		$sqlGlobal .= " and fp.zona = " . $idZona;
	}

	if($idMes != -1)
	{
		//mantengo la sentencia original
		$auxSqlGlobal = $sqlGlobal;

		//añado la nueva condicion
		$sqlGlobal .= " and month(fp.fecha_registro) = " . $idMes;
	}		

	$sqlGlobal .= " group by u.cod_u_organizaciones order by u.cod_zona";

	/*
	=========Ejecución de sentencia===========
	* Si el mes es diferente de enero se debe revisar si la organizacion ya ha sido reportada
	* en meses anteriores
	*/
	echo '<br>' . $sqlGlobal .'<br>';

	if($idMes > 1)
	{
		// Se revisara desde enero hasta el mes seleccionado
		// las organizaciones reportadas
		
		for($i = 1; $i < $idMes; $i++)
		{
			$sqlMes = $auxSqlGlobal;
			$sqlMes .= " and month(fp.fecha_registro) = " . $i;

			$resAux = query($sqlMes);

			//tomo los datos generados

			while($fila = mysql_fetch_array($resAux))
			{
				array_push($auxOrgReportadas, $fila['cod_u_organizaciones']);					
			}

		}
		//borramos los duplicados
		$auxOrgReportadas = array_unique($auxOrgReportadas);		
	}

	//ejecutamos el sqlGlobal para traer los resultados 
	$resGlobal = query($sqlGlobal);

	while($fila = mysql_fetch_array($resGlobal))
	{
		array_push($arrayOrgFinal, $fila['cod_u_organizaciones']);
	}

	$cont = 0;
	foreach($arrayOrgFinal as $valor)
	{
		if(in_array($valor, $auxOrgReportadas))
		{
			//se borra el registro que ya haya sido ingresado en meses anteriores
			unset($arrayOrgFinal[$cont]);				
		}
		else
		{
			//debo tomar el primer valor de la organizacion
			$sqlZonal = "select fp.cod_asesoria_asistencia_cofinanciamiento, month(fp.fecha_registro) as mes, u.cod_zona,  fp.cod_servicio, s.nombre  
				from fp_asesoria_asistencia_cofinanciamiento fp
				inner join u_organizaciones u on (fp.cod_u_organizaciones = u.cod_u_organizaciones)
				inner join servicio s on (fp.cod_servicio = s.cod_servicio) 
				where fp.cod_u_organizaciones = " . $valor . " order by fp.fecha_registro asc
				limit 1";

			$resSqlZonal = query($sqlZonal);
			while($fila = mysql_fetch_array($resSqlZonal))
			{
				$codSqlZona = $fila['cod_zona'];
				$codSqlServicio = $fila['cod_servicio'];
				$mesIng = $fila['mes'];

				$matrixMesZona[$codSqlZona - 1][$mesIng -1][$codSqlServicio - 1] = $matrixMesZona[$codSqlZona - 1][$mesIng -1][$codSqlServicio - 1] + 1;

				$matrixMesZona[$codSqlZona - 1][$mesIng -1][4] = $matrixMesZona[$codSqlZona - 1][$mesIng -1][4] + 1;			
			}		

		}
		$cont++;
	}

	print_r2($matrixMesZona);

}

function print_r2($val)
{
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}




?>