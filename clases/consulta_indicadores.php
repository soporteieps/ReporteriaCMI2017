<?php
function resultado_indicadores($cod_indicador, $cod_mes, $cod_zona)
{
	//echo "resultado_indicadores=".$cod_indicador."<br>";
	switch ($cod_indicador) {
    case '1':
		//echo 'case 1<br>';
        $resultado = primer_indicador($cod_mes,$cod_zona);
        break;
    case '2':
		//echo 'case 2<br>';
        $resultado = segundo_indicador($cod_mes,$cod_zona);
        break;
    case '3':
		//echo 'case 3<br>';
        $resultado = tercer_indicador($cod_mes,$cod_zona);
        break;
	case '4':
		$resultado = cuarto_indicador($cod_mes,$cod_zona);
		break;
	case '5':
		$resultado = quinto_indicador($cod_mes,$cod_zona);
		break;
	case '6':
		$resultado = sexto_indicador($cod_mes,$cod_zona);
		break;
	case '7':
		$resultado = septimo_indicador($cod_mes,$cod_zona);
		break;
	case '8':
		$resultado = octavo_indicador($cod_mes,$cod_zona);
		break;
	case '9':
		$resultado = noveno_indicador($cod_mes,$cod_zona);
		break;
	}
//echo "resultado_indicadores=".$cod_indicador.",".$cod_mes.",".$cod_zona.", resultado = ".$resultado."<br>";
return $resultado;
}

function getAnioSeleccionado()
{	
	$anioCurso = $_GET['anio'];
	
	return $anioCurso;
}

/*******************************************PRIMER INDICADOR*********************************************************/
/************NÚMERO DE ORGANIZACIONES QUE RECIBIERON AL MENOS UN SERVICIO DE FORTALECIMIENTO DE ACTORES**************/
function primer_indicador($mes,$zona)
{

	$anioCurso = getAnioSeleccionado();
	$arrayEventos = array();
	$arrayAsistencias = array();
	$arrayOrgEventos = array();
	$arrayOrgAsistencias = array();

	//consulto los eventos relacioneados a este mes
	$sqlEventosMes = "select ev.cod_evento, e.fecha_reporte, e.tipo_evento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento) where e.tipo_evento = 'org' and ev.anio = " . $anioCurso . "  and e.anio = " . $anioCurso;

	$sqlAsistencias = "select a.cod_asistencia_legal, a.estado_proceso_org, a.anio from asistencia_legal_org a where a.anio = " . $anioCurso;

	if($mes != -1)
	{
		$sqlEventosMes .= " and month(e.fecha_reporte) = " . $mes;
		if($mes == 1)
		{
			$sqlAsistencias .= " and a.estado_proceso_org in ('adecuacion_de_estatutos') and month(a.fecha_reporte) = " . $mes;
		}
		else
		{
			$sqlAsistencias .= " and a.estado_proceso_org in ('aprobacion_de_personalidad_juridica', 'adecuacion_de_estatutos') and month(a.fecha_reporte) = " . $mes;
		}		

	}

	if($zona != -1)
	{
		$sqlEventosMes .= " and e.zona = " . $zona;
		$sqlAsistencias .= " and a.zona = " . $zona;
	}

	$sqlEventosMes .= " group by ev.cod_evento";
	$sqlAsistencias .= " group by a.cod_asistencia_legal";

	/*echo $sqlEventosMes . "<br>";
	echo $sqlAsistencias . "<br>";*/

	$resSqlEventosMes = query($sqlEventosMes);
	$resSqlAsistencias = query($sqlAsistencias);

	while($fila = mysql_fetch_array($resSqlEventosMes))
	{
		array_push($arrayEventos, $fila['cod_evento']);
	}

	while($fila = mysql_fetch_array($resSqlAsistencias))
	{
		array_push($arrayAsistencias, $fila['cod_asistencia_legal']);
	}

	/*print_r2($arrayEventos);
	print_r2($arrayAsistencias);*/
	$codEventos = "(";
	$codAsistencias = "(";
	$tamArrayEventos = count($arrayEventos);
	$tamArrayAsistencias = count($arrayAsistencias);

	if($tamArrayEventos > 0)
	{
		for($i = 0; $i < $tamArrayEventos; $i++)
		{
			if($i == ($tamArrayEventos - 1))
				$codEventos .= "'" . $arrayEventos[$i] . "')";
			else
				$codEventos .= "'" . $arrayEventos[$i] . "',";
		}

		$sqlOrgEventos = "select cod_u_organizaciones from eventos_u_organizaciones where cod_evento in " . $codEventos . " and anio = " . $anioCurso . " and tipo_evento = 'org' group by cod_u_organizaciones";
		//echo $sqlOrgEventos . "<br>";
		$resSqlOrgEventos = query($sqlOrgEventos);
		while($fila = mysql_fetch_array($resSqlOrgEventos))
		{
			$sqlNumEventosOrg = "select cod_evento, anio from eventos_u_organizaciones where cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and tipo_evento = 'org' order by anio";
			//echo $sqlNumEventosOrg . "<br>";

			$resNumEventosOrg = query($sqlNumEventosOrg);

			while($fila1 = mysql_fetch_array($resNumEventosOrg))
			{
				if($fila1['anio'] < $anioCurso)
				{
					array_push($arrayOrgEventos, $fila['cod_u_organizaciones']);
					break;
				}
				else
				{
					$sqlEvento = "select year(fecha_reporte) as anio, month(fecha_reporte) as mess from eventos where cod_evento = '" . $fila1['cod_evento'] . "' and anio = " . $fila1['anio'] . " and tipo_evento = 'org'";
					//echo $sqlEvento . "<br>";
					$resSqlEvento = query($sqlEvento);
					while($fila2 = mysql_fetch_array($resSqlEvento))
					{
						if($fila2['anio'] == $anioCurso && $fila2['mess'] < $mes)
						{
							array_push($arrayOrgEventos, $fila['cod_u_organizaciones']);
							break;
						}
					}
				}
			}

			$sqlNumAsistenciasOrg = "select cod_asistencia_legal, anio from asistencia_legal_org where cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " order by anio";
			$resNumAsistenciasOrg = query($sqlNumAsistenciasOrg);
			//echo $sqlNumAsistenciasOrg . "<br>";


			while($fila1 = mysql_fetch_array($resNumAsistenciasOrg))
			{
				if($fila1['anio'] < $anioCurso)
				{
					array_push($arrayOrgEventos, $fila['cod_u_organizaciones']);
					break;
				}
				else
				{
					$sqlEvento = "select year(fecha_reporte) as anio, month(fecha_reporte) as mess from asistencia_legal_org where cod_asistencia_legal = '" . $fila1['cod_asistencia_legal'] . "' and anio = " . $fila1['anio'];
					//echo $sqlEvento . "<br>";
					$resSqlEvento = query($sqlEvento);
					while($fila2 = mysql_fetch_array($resSqlEvento))
					{
						if($fila2['anio'] == $anioCurso && $fila2['mess'] < $mes)
						{
							array_push($arrayOrgEventos, $fila['cod_u_organizaciones']);
							break;
						}
					}
				}
			}





			//echo $fila['cod_u_organizaciones'] . " - " . mysql_num_rows($resNumEventosOrg) . "<br>";
			/*if(mysql_num_rows($resNumEventosOrg) > 1)
				array_push($arrayOrgEventos, $fila['cod_u_organizaciones']);*/
		}
	}

	if($tamArrayAsistencias > 0)
	{
		for($i = 0; $i < $tamArrayAsistencias; $i++)
		{
			if($i == ($tamArrayAsistencias - 1))
				$cosAsistencias .= "'" . $arrayEventos[$i] . "')";
			else
				$cosAsistencias .= "'" . $arrayEventos[$i] . "',";
		}

		$sqlOrgAsistencias = "select cod_u_organizaciones from asistencia_legal_org where cod_asistencia_legal in " . $cosAsistencias . " and anio = " . $anioCurso . " group by cod_u_organizaciones";
		//echo $sqlOrgAsistencias . "<br>";
		$resSqlOrgAsistencias = query($sqlOrgAsistencias);
		while($fila = mysql_fetch_array($resSqlOrgAsistencias))
		{
			$sqlNumAsistenciasOrg = "select cod_asistencia_legal, anio from asistencia_legal_org where cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " order by anio";
			$resNumAsistenciasOrg = query($sqlNumAsistenciasOrg);
			//echo $sqlNumAsistenciasOrg . "<br>";


			while($fila1 = mysql_fetch_array($resNumAsistenciasOrg))
			{
				if($fila1['anio'] < $anioCurso)
				{
					array_push($arrayOrgAsistencias, $fila['cod_u_organizaciones']);
					break;
				}
				else
				{
					$sqlEvento = "select year(fecha_reporte) as anio, month(fecha_reporte) as mess from asistencia_legal_org where cod_asistencia_legal = '" . $fila1['cod_asistencia_legal'] . "' and anio = " . $fila1['anio'];
					//echo $sqlEvento . "<br>";
					$resSqlEvento = query($sqlEvento);
					while($fila2 = mysql_fetch_array($resSqlEvento))
					{
						if($fila2['anio'] == $anioCurso && $fila2['mess'] < $mes)
						{
							array_push($arrayOrgAsistencias, $fila['cod_u_organizaciones']);
							break;
						}
					}
				}
			}

			$sqlNumEventosOrg = "select cod_evento, anio from eventos_u_organizaciones where cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and tipo_evento = 'org' order by anio";
			//echo $sqlNumEventosOrg . "<br>";

			$resNumEventosOrg = query($sqlNumEventosOrg);

			while($fila1 = mysql_fetch_array($resNumEventosOrg))
			{
				if($fila1['anio'] < $anioCurso)
				{
					array_push($arrayOrgAsistencias, $fila['cod_u_organizaciones']);
					break;
				}
				else
				{
					$sqlEvento = "select year(fecha_reporte) as anio, month(fecha_reporte) as mess from eventos where cod_evento = '" . $fila1['cod_evento'] . "' and anio = " . $fila1['anio'] . " and tipo_evento = 'org'";
					//echo $sqlEvento . "<br>";
					$resSqlEvento = query($sqlEvento);
					while($fila2 = mysql_fetch_array($resSqlEvento))
					{
						if($fila2['anio'] == $anioCurso && $fila2['mess'] < $mes)
						{
							array_push($arrayOrgAsistencias, $fila['cod_u_organizaciones']);
							break;
						}
					}
				}
			}


			/*if(mysql_num_rows($resNumAsistenciasOrg) > 1)
				array_push($arrayOrgAsistencias, $fila['cod_u_organizaciones']);*/
		}
	}

	$arrayOrgEventos = array_unique($arrayOrgEventos);
	$arrayOrgAsistencias = array_unique($arrayOrgAsistencias);
	/*print_r2($arrayOrgEventos);
	print_r2($arrayOrgAsistencias);*/


	//echo $codEventos . "<br>" . $codAsistencias . "<br>";

	// revisar los codigos de eventos de meses anteriores y tener los organizaciones de meses anteriores
	if($mes != 1)
	{
		$arrayEventosAnteriores = array();
		$arrayAsistenciasAnteriores = array();
		$arrayOrgAnt = array();
		$arrayOrgAsisAnt = array();
		for($i = 1; $i < $mes; $i++)
		{
			$sqlEventosAnteriores = "select ev.cod_evento, e.fecha_reporte, e.tipo_evento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento) where e.tipo_evento = 'org' and ev.anio = ". $anioCurso ." and e.anio = " . $anioCurso ." and month(e.fecha_reporte) = " . $i . " and e.zona = " . $zona . " group by ev.cod_evento";
			//echo $sqlEventosAnteriores . "<br>";
			$resEventosAnteriores = query($sqlEventosAnteriores);
			while($fila = mysql_fetch_array($resEventosAnteriores))
			{
				array_push($arrayEventosAnteriores, $fila['cod_evento']);
			}

			$sqlAsistenciasAnteriores = "select a.cod_asistencia_legal, a.estado_proceso_org, a.anio from asistencia_legal_org a where a.anio = " . $anioCurso . " and a.estado_proceso_org in ('aprobacion_de_personalidad_juridica', 'adecuacion_de_estatutos') and month(a.fecha_reporte) = " . $i . " and a.zona = " . $zona . " group by a.cod_asistencia_legal";

			$resAsistenciasAnteriores = query($sqlAsistenciasAnteriores);
			while($fila = mysql_fetch_array($resAsistenciasAnteriores))
			{
				array_push($arrayAsistenciasAnteriores, $fila['cod_asistencia_legal']);
			}
		}

		$arrayEventosAnteriores = array_unique($arrayEventosAnteriores);
		$arrayEventosAnteriores = array_values($arrayEventosAnteriores);
		$arrayAsistenciasAnteriores = array_unique($arrayAsistenciasAnteriores);
		$arrayAsistenciasAnteriores = array_values($arrayAsistenciasAnteriores);

		/*print_r2($arrayEventosAnteriores);
		print_r2($arrayAsistenciasAnteriores);*/

		// se debe buscar las organizaciones con estos eventos

		foreach($arrayEventosAnteriores as $valor)
		{
			$sqlOrgAnt = "select cod_u_organizaciones from eventos_u_organizaciones where anio = " . $anioCurso . " and tipo_evento = 'org' and cod_evento = '" . $valor . "'";
			//echo $sqlOrgAnt . "<br>";
			$resSqlOrgAnt = query($sqlOrgAnt);
			while($fila = mysql_fetch_array($resSqlOrgAnt))
			{
				array_push($arrayOrgAnt, $fila['cod_u_organizaciones']);
			}
		}

		foreach($arrayAsistenciasAnteriores as $valor)
		{
			$sqlOrgAnt = "select cod_u_organizaciones from asistencia_legal_org where anio = " . $anioCurso . " and a.estado_proceso_org in ('aprobacion_de_personalidad_juridica', 'adecuacion_de_estatutos') and cod_asistencia_legal = '" . $valor . "'";
			//echo $sqlOrgAnt . "<br>";
			$resSqlOrgAnt = query($sqlOrgAnt);
			while($fila = mysql_fetch_array($resSqlOrgAnt))
			{
				array_push($arrayOrgAnt, $fila['cod_u_organizaciones']);
			}
		}

		$arrayOrgAnt = array_unique($arrayOrgAnt);
		$arrayOrgAnt = array_values($arrayOrgAnt);
		$arrayOrgAsisAnt = array_unique($arrayOrgAsisAnt);
		$arrayOrgAsisAnt = array_values($arrayOrgAsisAnt);

		$arrayOrgAnt = array_merge($arrayOrgAnt, $arrayOrgAsisAnt);
		$arrayOrgEventos = array_merge($arrayOrgEventos, $arrayOrgAsistencias);
		$arrayOrgAnt = array_unique($arrayOrgAnt);
		$arrayOrgEventos = array_unique($arrayOrgEventos);

		/*print_r2($arrayOrgAnt);
		print_r2($arrayOrgAsisAnt);*/

		$cont = 0;
		foreach($arrayOrgEventos as $valor)
		{
			if(in_array($valor, $arrayOrgAnt))
			{
				unset($arrayOrgEventos[$cont]);
			}
			$cont++;
		}

		/*$cont = 0;
		foreach($arrayOrgAsistencias as $valor)
		{
			if(in_array($valor, $arrayOrgAnt))
			{
				unset($arrayOrgAsistencias[$cont]);
			}
			$cont++;
		}*/

	}

	$arrayOrgEventos = array_values($arrayOrgEventos);
	//$arrayOrgAsistencias = array_values($arrayOrgAsistencias);
	/*print_r2($arrayOrgEventos);
	print_r2($arrayOrgAsistencias);*/

	//$arrayOrgEventos = array_merge($arrayOrgEventos, $arrayOrgAsistencias);
	$arrayOrgEventos = array_unique($arrayOrgEventos);

	return count($arrayOrgEventos);



}
function primer_indicador1($mes,$zona)
{
	/*******************************************************************************************************************************************/
	/**********************************CONSULTA TODAS LAS CAPACITACIONES A ORGANIZACIONES*******************************************************/ 
	/*$organizaciones = "select eo.ruc_institucion as ruc from eventos_u_organizaciones eo 
	inner join eventos e on(eo.cod_evento = e.cod_evento)
	inner join u_organizaciones o on(eo.ruc_institucion = o.ruc_provisional OR eo.ruc_institucion = o.ruc_definitivo)
	where eo.tipo_evento = 'ORG' and year(o.fecha_registro) = 2015"; 
	if($zona != "-1")
		{
			$organizaciones = $organizaciones." and e.zona = $zona";
		}
	if($mes!="")
		{	
			$organizaciones = $organizaciones." and month(e.fecha_reporte) = $mes"; 
		}
	
	$organizaciones = $organizaciones." group by eo.ruc_institucion";
	echo $organizaciones . "<br> ";*/

	$anioCurso = getAnioSeleccionado();
	//echo $anioCurso . "<br>";

	$organizaciones = "select eo.cod_u_organizaciones 
						from eventos_u_organizaciones eo
						inner join eventos e on (eo.cod_evento = e.cod_evento and year(e.fecha_reporte) = " . $anioCurso .")
						inner join u_organizaciones uo on (eo.cod_u_organizaciones = uo.cod_u_organizaciones and year(uo.fecha_registro)<=" . $anioCurso . " - 1)
						where eo.tipo_evento = 'ORG' and eo.anio = " . $anioCurso . " ";

	/*$organizaciones = "select eo.cod_u_organizaciones 
						from eventos_u_organizaciones eo
						inner join eventos e on (eo.cod_evento = e.cod_evento)
						inner join u_organizaciones uo on (eo.cod_u_organizaciones = uo.cod_u_organizaciones and year(uo.fecha_registro)=year(now()) - 1)
						where eo.tipo_evento = 'ORG'";*/

	if($mes != 1)
	{
		$asistencia_legal = "select al.cod_u_organizaciones
						from asistencia_legal_org al
						inner join u_organizaciones uo on (uo.cod_u_organizaciones = al.cod_u_organizaciones and year(uo.fecha_registro)<=" . $anioCurso . " - 1)
						where al.estado_proceso_org in ('aprobacion_de_personalidad_juridica', 'adecuacion_de_estatutos') and year(al.fecha_reporte) = " . $anioCurso . " and al.anio = " . $anioCurso . "";

		/*$asistencia_legal = "select al.cod_u_organizaciones
						from asistencia_legal_org al
						inner join u_organizaciones uo on (uo.cod_u_organizaciones = al.cod_u_organizaciones and year(uo.fecha_registro)=year(now()) - 1)
						where al.estado_proceso_org in ('aprobacion_de_personalidad_juridica', 'adecuacion_de_estatutos')";*/
	}		
	else
	{
		$asistencia_legal = "select al.cod_u_organizaciones
						from asistencia_legal_org al
						inner join u_organizaciones uo on (uo.cod_u_organizaciones = al.cod_u_organizaciones and year(uo.fecha_registro)<=" . $anioCurso . " - 1)
						where al.estado_proceso_org in ('adecuacion_de_estatutos') and year(al.fecha_reporte) = " . $anioCurso ."  and al.anio = " . $anioCurso . "";

		/*$asistencia_legal = "select al.cod_u_organizaciones
						from asistencia_legal_org al
						inner join u_organizaciones uo on (uo.cod_u_organizaciones = al.cod_u_organizaciones and year(uo.fecha_registro)=year(now()) - 1)
						where al.estado_proceso_org in ('adecuacion_de_estatutos')";*/
	}

	$arrayCodOrg = array(); 		//guardara los cod de organizaciones que han tenido algun evento
	$arrayAsistencia = array(); 	//guardara los cod de organizaciones que han recibido asistencia legal
	$arrayFinal = array();



	if($zona != "-1")
	{
		$organizaciones .= " and e.zona =" . $zona;
		$asistencia_legal .= " and al.zona = " . $zona;

		//reviso si el mes esta designado
		if($mes != "")
		{
			$organizaciones .= " and month(e.fecha_reporte) = " . $mes . " group by eo.cod_u_organizaciones order by eo.cod_u_organizaciones";

			$asistencia_legal .= " and month(al.fecha_reporte) = " . $mes . " group by al.cod_u_organizaciones order by al.cod_u_organizaciones";

			/*echo "<br>Organizaciones " . $organizaciones . "<br>";
			echo "<br>Asistencia " . $asistencia_legal . "<br>";*/


			

			//guardo todos los cod de organizaciones en mes y zona elegido
			$resOrg = query($organizaciones);
			$resAsist = query($asistencia_legal);

			//guardo los cod encontrados en el mes indicado
			while($fila = mysql_fetch_array($resOrg))
			{
				//revisamos si la organizacion reportada es nueva o vieja
				$sqlNuevaOrg = "select cod_u_organizaciones from eventos_u_organizaciones where cod_u_organizaciones = " . $fila['cod_u_organizaciones'];
				$resNuevaOrg = query($sqlNuevaOrg);
				$numNuevaOrg = mysql_num_rows($resNuevaOrg);
				if($numNuevaOrg > 1)
					array_push($arrayCodOrg, $fila['cod_u_organizaciones']);
			}

			while($fila = mysql_fetch_array($resAsist))
			{
				array_push($arrayAsistencia, $fila['cod_u_organizaciones']);
			}

			//uno los dos resultados
			$arrayFinal = array_merge($arrayCodOrg, $arrayAsistencia);

			//eliminar duplicados
			$arrayFinal = array_unique($arrayFinal);


			/*************
			Si el mes escogido no es enero, se debe revisar los registros de organizaciones de los meses anteriores
			**************/
			$auxArrayCodOrg = array();
			$auxArrayAsistencia = array();

			for($i = 1; $i < $mes; $i++)
			{
				//se forma la sentencia sql
				$orgMesAnterior = "select eo.cod_u_organizaciones 
						from eventos_u_organizaciones eo
						inner join eventos e on (eo.cod_evento = e.cod_evento and year(e.fecha_reporte) = " . $anioCurso .")
						inner join u_organizaciones uo on (eo.cod_u_organizaciones = uo.cod_u_organizaciones and year(uo.fecha_registro)<=" . $anioCurso . " - 1)
						where eo.tipo_evento = 'ORG' and eo.anio = " . $anioCurso . " and month(e.fecha_reporte) = " . $i;

				/*$orgMesAnterior = "select eo.cod_u_organizaciones 
						from eventos_u_organizaciones eo
						inner join eventos e on (eo.cod_evento = e.cod_evento)
						inner join u_organizaciones uo on (eo.cod_u_organizaciones = uo.cod_u_organizaciones and year(uo.fecha_registro)=year(now()) - 1)
						where eo.tipo_evento = 'ORG' and month(e.fecha_reporte) = " . $i;*/

				$asistMesAnterior = "select al.cod_u_organizaciones
						from asistencia_legal_org al
						inner join u_organizaciones uo on (uo.cod_u_organizaciones = al.cod_u_organizaciones and year(uo.fecha_registro)<=" . $anioCurso . " - 1)
						where al.estado_proceso_org in ('aprobacion_de_personalidad_juridica', 'adecuacion_de_estatutos')  and al.anio = " . $anioCurso . " and  month(al.fecha_reporte) = " . $i;

				/*$asistMesAnterior = "select al.cod_u_organizaciones
						from asistencia_legal_org al
						inner join u_organizaciones uo on (uo.cod_u_organizaciones = al.cod_u_organizaciones and year(uo.fecha_registro)=year(now()) - 1)
						where al.estado_proceso_org in ('aprobacion_de_personalidad_juridica', 'adecuacion_de_estatutos') and month(al.fecha_reporte) = " . $i;*/

				$resAuxOrg = query($orgMesAnterior);
				$resAuxAsist = query($asistMesAnterior);
				//echo "<br>" . $orgMesAnterior . "<br>" . $asistMesAnterior;

				//guardo los resultados en $auxArrayCodOrg

				while($fila = mysql_fetch_array($resAuxOrg))
				{
					array_push($auxArrayCodOrg, $fila['cod_u_organizaciones']);

				}

				while($fila = mysql_fetch_array($resAuxAsist))				
				{
					array_push($auxArrayAsistencia, $fila['cod_u_organizaciones']);
				}
			}

			//se elimina datos duplicados en el array resultante
			$auxArrayCodOrg = array_unique($auxArrayCodOrg);
			$auxArrayAsistencia = array_unique($auxArrayAsistencia);


			$sumaAuxArray = array_merge($auxArrayCodOrg, $auxArrayAsistencia);

			//eliminamos datos duplicados en $sumaAuxArray
			$sumaAuxArray = array_unique($sumaAuxArray);
			//echo "<br>";
			//print_r2($sumaAuxArray);
			//print_r2($arrayFinal);

			$cont = 0;

			foreach($arrayFinal as $valor)
			{
				if(in_array($valor, $sumaAuxArray))
				{
					//echo "<br>si esta";
					//elimino del array
					unset($arrayFinal[$cont]);
				}

				$cont++;
			}
		}
		else
		{
			$organizaciones .= " group by eo.cod_u_organizaciones order by eo.cod_u_organizaciones";

			$asistencia_legal .= " group by al.cod_u_organizaciones order by al.cod_u_organizaciones";
			

			//guardo todos los cod de organizaciones en mes y zona elegido
			$resOrg = query($organizaciones);
			$resAsist = query($asistencia_legal);

			//guardo los cod encontrados en el mes indicado
			while($fila = mysql_fetch_array($resOrg))
			{
				//revisamos si la organizacion reportada es nueva o vieja
				$sqlNuevaOrg = "select cod_u_organizaciones from eventos_u_organizaciones where cod_u_organizaciones = " . $fila['cod_u_organizaciones'];
				$resNuevaOrg = query($sqlNuevaOrg);
				$numNuevaOrg = mysql_num_rows($resNuevaOrg);
				if($numNuevaOrg > 1)
					array_push($arrayCodOrg, $fila['cod_u_organizaciones']);
			}

			while($fila = mysql_fetch_array($resAsist))
			{
				array_push($arrayAsistencia, $fila['cod_u_organizaciones']);
			}

			//uno los dos resultados
			$arrayFinal = array_merge($arrayCodOrg, $arrayAsistencia);

			//eliminar duplicados
			$arrayFinal = array_unique($arrayFinal);
			
		}

	}
	else
	{
		if($mes != "")
		{
			$organizaciones .= " and month(e.fecha_reporte) = " . $mes . " group by eo.cod_u_organizaciones order by eo.cod_u_organizaciones";

			$asistencia_legal .= " and month(al.fecha_reporte) = " . $mes . " group by al.cod_u_organizaciones order by al.cod_u_organizaciones";
			

			//guardo todos los cod de organizaciones en mes y zona elegido
			$resOrg = query($organizaciones);
			$resAsist = query($asistencia_legal);

			//guardo los cod encontrados en el mes indicado
			while($fila = mysql_fetch_array($resOrg))
			{
				//revisamos si la organizacion reportada es nueva o vieja
				$sqlNuevaOrg = "select cod_u_organizaciones from eventos_u_organizaciones where cod_u_organizaciones = " . $fila['cod_u_organizaciones'];
				$resNuevaOrg = query($sqlNuevaOrg);
				$numNuevaOrg = mysql_num_rows($resNuevaOrg);
				if($numNuevaOrg > 1)
					array_push($arrayCodOrg, $fila['cod_u_organizaciones']);
			}

			while($fila = mysql_fetch_array($resAsist))
			{
				array_push($arrayAsistencia, $fila['cod_u_organizaciones']);
			}

			//uno los dos resultados
			$arrayFinal = array_merge($arrayCodOrg, $arrayAsistencia);

			//eliminar duplicados
			$arrayFinal = array_unique($arrayFinal);


			/*************
			Si el mes escogido no es enero, se debe revisar los registros de organizaciones de los meses anteriores
			**************/
			$auxArrayCodOrg = array();
			$auxArrayAsistencia = array();

			for($i = 1; $i < $mes; $i++)
			{
				//se forma la sentencia sql
				$orgMesAnterior = "select eo.cod_u_organizaciones 
						from eventos_u_organizaciones eo
						inner join eventos e on (eo.cod_evento = e.cod_evento)
						inner join u_organizaciones uo on (eo.cod_u_organizaciones = uo.cod_u_organizaciones and year(uo.fecha_registro)<=" . $anioCurso . " - 1)
						where eo.tipo_evento = 'ORG' and eo.anio = " . $anioCurso . " and month(e.fecha_reporte) = " . $i;

				/*$orgMesAnterior = "select eo.cod_u_organizaciones 
						from eventos_u_organizaciones eo
						inner join eventos e on (eo.cod_evento = e.cod_evento)
						inner join u_organizaciones uo on (eo.cod_u_organizaciones = uo.cod_u_organizaciones and year(uo.fecha_registro)=year(now()) - 1)
						where eo.tipo_evento = 'ORG' and month(e.fecha_reporte) = " . $i;*/

				$asistMesAnterior = "select al.cod_u_organizaciones
						from asistencia_legal_org al
						inner join u_organizaciones uo on (uo.cod_u_organizaciones = al.cod_u_organizaciones and year(uo.fecha_registro)<=" . $anioCurso . "  - 1)
						where al.estado_proceso_org in ('aprobacion_de_personalidad_juridica', 'adecuacion_de_estatutos')  and al.anio = " . $anioCurso . " and month(al.fecha_reporte) = " . $i;

				/*$asistMesAnterior = "select al.cod_u_organizaciones
						from asistencia_legal_org al
						inner join u_organizaciones uo on (uo.cod_u_organizaciones = al.cod_u_organizaciones and year(uo.fecha_registro)=year(now())  - 1)
						where al.estado_proceso_org in ('aprobacion_de_personalidad_juridica', 'adecuacion_de_estatutos') and month(al.fecha_reporte) = " . $i;*/

				$resAuxOrg = query($orgMesAnterior);
				$resAuxAsist = query($asistMesAnterior);
				//echo "<br>" . $orgMesAnterior . "<br>" . $asistMesAnterior;

				//guardo los resultados en $auxArrayCodOrg

				while($fila = mysql_fetch_array($resAuxOrg))
				{
					array_push($auxArrayCodOrg, $fila['cod_u_organizaciones']);

				}

				while($fila = mysql_fetch_array($resAuxAsist))				
				{
					array_push($auxArrayAsistencia, $fila['cod_u_organizaciones']);
				}
			}

			//se elimina datos duplicados en el array resultante
			$auxArrayCodOrg = array_unique($auxArrayCodOrg);
			$auxArrayAsistencia = array_unique($auxArrayAsistencia);

			$sumaAuxArray = array_merge($auxArrayCodOrg, $auxArrayAsistencia);

			//eliminamos datos duplicados en $sumaAuxArray
			$sumaAuxArray = array_unique($sumaAuxArray);

			$cont = 0;

			foreach($arrayFinal as $valor)
			{
				if(in_array($valor, $sumaAuxArray))
				{
					//echo "<br>si esta";
					//elimino del array
					unset($arrayFinal[$cont]);
				}

				$cont++;
			}
		}
		else
		{
			$organizaciones .= " group by eo.cod_u_organizaciones order by eo.cod_u_organizaciones";

			$asistencia_legal .= " group by al.cod_u_organizaciones order by al.cod_u_organizaciones";
			

			//guardo todos los cod de organizaciones en mes y zona elegido
			$resOrg = query($organizaciones);
			$resAsist = query($asistencia_legal);

			//guardo los cod encontrados en el mes indicado
			while($fila = mysql_fetch_array($resOrg))
			{
				//revisamos si la organizacion reportada es nueva o vieja
				$sqlNuevaOrg = "select cod_u_organizaciones from eventos_u_organizaciones where cod_u_organizaciones = " . $fila['cod_u_organizaciones'];
				$resNuevaOrg = query($sqlNuevaOrg);
				$numNuevaOrg = mysql_num_rows($resNuevaOrg);
				if($numNuevaOrg > 1)
					array_push($arrayCodOrg, $fila['cod_u_organizaciones']);
			}

			while($fila = mysql_fetch_array($resAsist))
			{
				array_push($arrayAsistencia, $fila['cod_u_organizaciones']);
			}

			//uno los dos resultados
			$arrayFinal = array_merge($arrayCodOrg, $arrayAsistencia);

			//eliminar duplicados
			$arrayFinal = array_unique($arrayFinal);
			
		}
	}

	//echo "<br>" . $organizaciones . "<br>" . $asistencia_legal;
	//print_r2($arrayFinal);

	return $indicador_1 = count($arrayFinal);		
}

/*******************************************SEGUNDO INDICADOR*********************************************************/
/*****************NÚMERO DE UEP QUE RECIBIERON AL MENOS UN SERVICIO DE FORTALECIMIENTO DE ACTORES*********************/
function segundo_indicador($mes,$zona)
{

	$anioCurso = getAnioSeleccionado();
	$arrayEventos = array();
	$arrayAsistencias = array();
	$arrayOrgEventos = array();
	$arrayOrgAsistencias = array();

	//consulto los eventos relacioneados a este mes
	$sqlEventosMes = "select ev.cod_evento, e.fecha_reporte, e.tipo_evento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento) where e.tipo_evento = 'uep' and ev.anio = " . $anioCurso . "  and e.anio = " . $anioCurso;

	

	if($mes != -1)
	{
		$sqlEventosMes .= " and month(e.fecha_reporte) = " . $mes;			

	}

	if($zona != -1)
	{
		$sqlEventosMes .= " and e.zona = " . $zona;
		
	}

	$sqlEventosMes .= " group by ev.cod_evento";	

	/*echo $sqlEventosMes . "<br>";
	echo $sqlAsistencias . "<br>";*/

	$resSqlEventosMes = query($sqlEventosMes);
	

	while($fila = mysql_fetch_array($resSqlEventosMes))
	{
		array_push($arrayEventos, $fila['cod_evento']);
	}
	

	/*print_r2($arrayEventos);
	print_r2($arrayAsistencias);*/
	$codEventos = "(";
	
	$tamArrayEventos = count($arrayEventos);
	

	if($tamArrayEventos > 0)
	{
		for($i = 0; $i < $tamArrayEventos; $i++)
		{
			if($i == ($tamArrayEventos - 1))
				$codEventos .= "'" . $arrayEventos[$i] . "')";
			else
				$codEventos .= "'" . $arrayEventos[$i] . "',";
		}

		$sqlOrgEventos = "select cod_u_organizaciones from eventos_u_organizaciones where cod_evento in " . $codEventos . " and anio = " . $anioCurso . " and tipo_evento = 'uep' group by cod_u_organizaciones";
		//echo $sqlOrgEventos . "<br>";
		$resSqlOrgEventos = query($sqlOrgEventos);
		while($fila = mysql_fetch_array($resSqlOrgEventos))
		{
			$sqlNumEventosOrg = "select cod_evento from eventos_u_organizaciones where cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and tipo_evento = 'uep'";
			//echo $sqlNumEventosOrg . "<br>";

			$resNumEventosOrg = query($sqlNumEventosOrg);
			//echo $fila['cod_u_organizaciones'] . " - " . mysql_num_rows($resNumEventosOrg) . "<br>";
			if(mysql_num_rows($resNumEventosOrg) >= 1)
				array_push($arrayOrgEventos, $fila['cod_u_organizaciones']);
		}
	}

	

	/*print_r2($arrayOrgEventos);
	print_r2($arrayOrgAsistencias);*/

	//echo $codEventos . "<br>" . $codAsistencias . "<br>";

	// revisar los codigos de eventos de meses anteriores y tener los organizaciones de meses anteriores
	if($mes != 1)
	{
		$arrayEventosAnteriores = array();
		
		$arrayOrgAnt = array();
		
		for($i = 1; $i < $mes; $i++)
		{
			$sqlEventosAnteriores = "select ev.cod_evento, e.fecha_reporte, e.tipo_evento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento) where e.tipo_evento = 'uep' and ev.anio = ". $anioCurso ." and e.anio = " . $anioCurso ." and month(e.fecha_reporte) = " . $i . " and e.zona = " . $zona . " group by ev.cod_evento";
			//echo $sqlEventosAnteriores . "<br>";
			$resEventosAnteriores = query($sqlEventosAnteriores);
			while($fila = mysql_fetch_array($resEventosAnteriores))
			{
				array_push($arrayEventosAnteriores, $fila['cod_evento']);
			}

			
		}

		$arrayEventosAnteriores = array_unique($arrayEventosAnteriores);
		$arrayEventosAnteriores = array_values($arrayEventosAnteriores);
		

		//print_r2($arrayEventosAnteriores);

		// se debe buscar las organizaciones con estos eventos

		foreach($arrayEventosAnteriores as $valor)
		{
			$sqlOrgAnt = "select cod_u_organizaciones from eventos_u_organizaciones where anio = " . $anioCurso . " and tipo_evento = 'uep' and cod_evento = '" . $valor . "'";
			//echo $sqlOrgAnt . "<br>";
			$resSqlOrgAnt = query($sqlOrgAnt);
			while($fila = mysql_fetch_array($resSqlOrgAnt))
			{
				array_push($arrayOrgAnt, $fila['cod_u_organizaciones']);
			}
		}

		

		$arrayOrgAnt = array_unique($arrayOrgAnt);
		$arrayOrgAnt = array_values($arrayOrgAnt);
		

		/*print_r2($arrayOrgAnt);
		print_r2($arrayOrgAsisAnt);*/

		$cont = 0;
		foreach($arrayOrgEventos as $valor)
		{
			if(in_array($valor, $arrayOrgAnt))
			{
				unset($arrayOrgEventos[$cont]);
			}
			$cont++;
		}

		

	}

	$arrayOrgEventos = array_values($arrayOrgEventos);
	
	/*print_r2($arrayOrgEventos);
	print_r2($arrayOrgAsistencias);*/

	

	return count($arrayOrgEventos);



}

function segundo_indicador1($mes,$zona)
{
	$uepFinal = array();
	$uepMesAnterior = array();

	$anioCurso = getAnioSeleccionado();

	$check_registrado_2 = "select eo.ruc_institucion,eo.cod_evento, eo.tipo_evento, e.tipo_evento
		from eventos_u_organizaciones eo 
		inner join eventos e on(e.cod_evento = eo.cod_evento and e.tipo_evento = 'UEP')
		where eo.tipo_evento = 'UEP' and eo.anio = " . $anioCurso . " and year(e.fecha_reporte) = " . $anioCurso;

	/*$check_registrado_2 = "select eo.ruc_institucion,eo.cod_evento, eo.tipo_evento, e.tipo_evento
		from eventos_u_organizaciones eo 
		inner join eventos e on(e.cod_evento = eo.cod_evento and e.tipo_evento = 'UEP')
		where eo.tipo_evento = 'UEP' and year(e.fecha_reporte) = year(now())";*/

	$sqlMesAnterior = $check_registrado_2;
	if($zona != "-1")
		{
			$check_registrado_2 = $check_registrado_2." and e.zona = $zona";
			$sqlMesAnterior = $check_registrado_2;
		}
	if($mes!="")
	{	
		$check_registrado_2 = $check_registrado_2." and month(e.fecha_reporte) = $mes"; 

		if($mes > 1)
		{
			//mes mayor a enero
			$auxSql = $sqlMesAnterior;
			for($i = 1; $i < $mes; $i++)
			{
				$sqlMesAnterior = $auxSql;
				$sqlMesAnterior .= " and month(e.fecha_reporte) = " . $i . " group by eo.ruc_institucion";
				//echo $sqlMesAnterior . "<br>";

				$resMes = query($sqlMesAnterior);

				while($fila = mysql_fetch_array($resMes))
				{
					array_push($uepMesAnterior, $fila['ruc_institucion']);						
				}
			}

			array_unique($uepMesAnterior);
		}
	}

	$check_registrado_2 .= " group by eo.ruc_institucion";
	
	//echo "repetidos_2 = ".$check_registrado_2."<br>";
	$result=query($check_registrado_2);

	while($fila = mysql_fetch_array($result))
	{
		array_push($uepFinal, $fila['ruc_institucion']);
	}

	array_unique($uepFinal);

	if(count($uepMesAnterior) > 0)
	{
		//se hace la comparacion y se elimina el registro de enero
		$cont = 0;
		foreach($uepFinal as $valor)
		{
			if(in_array($valor, $uepMesAnterior))
			{
				//echo "<br>si esta";
				//elimino del array
				unset($uepFinal[$cont]);
			}

			$cont++;
		}

	}
	//print_r2($uepFinal);
	//print_r2($uepMesAnterior);


	//$total_uep_2 = mysql_num_rows($result);	
	//return $indicador_2 = $total_uep_2 ;	
	return $indicador_2 = count($uepFinal);
}

/*******************************************TERCER INDICADOR*********************************************************/
/***********NÚMERO DE CIRCUITOS ECONÓMICOS QUE RECIBIERON AL MENOS UN SERVICIO DE FORTALECIMIENTO DE ACTORES**********/
function tercer_indicador($mes,$zona)
{	
	$ciruitosMesesAnt = array();
	$circuitosFinal = array();

	$anioCurso = getAnioSeleccionado();

	$num_circuitos_3 = 0;
	$check_registrado_3 = "select eo.cod_u_organizaciones from eventos_u_organizaciones eo inner join eventos e on(eo.cod_evento = e.cod_evento) inner join u_organizaciones u on (u.cod_u_organizaciones = eo.cod_u_organizaciones) 
	where e.tipo_evento = 'ORG' and eo.anio = " . $anioCurso . " and u.circuito_economico = 'si' and year(e.fecha_reporte) = " . $anioCurso;

	/*$check_registrado_3 = "select eo.cod_u_organizaciones from eventos_u_organizaciones eo inner join eventos e on(eo.cod_evento = e.cod_evento) inner join u_organizaciones u on (u.cod_u_organizaciones = eo.cod_u_organizaciones) 
	where e.tipo_evento = 'ORG' and u.circuito_economico = 'si' and year(e.fecha_registro) = year(now())";*/

	$sqlMesAnterior = $check_registrado_3;
	if($zona!="")
	{
		$check_registrado_3 = $check_registrado_3." and e.zona=$zona";
		$sqlMesAnterior = $check_registrado_3;
	}
	if($mes!="")
	{	
		$check_registrado_3 = $check_registrado_3." and month(e.fecha_reporte) = $mes"; 
		if($mes > 1)
		{
			//mes mayor a enero
			$auxSql = $sqlMesAnterior;
			for($i = 1; $i < $mes; $i++)
			{
				$sqlMesAnterior = $auxSql;
				$sqlMesAnterior .= " and month(e.fecha_reporte) = " . $i . " group by eo.cod_u_organizaciones";

				$resMes = query($sqlMesAnterior);

				while($fila = mysql_fetch_array($resMes))
				{
					array_push($ciruitosMesesAnt, $fila['cod_u_organizaciones']);						
				}

				//echo "<br>" . $sqlMesAnterior;
			}
			//echo "<br>";
			//print_r($ciruitosMesesAnt);
			array_unique($ciruitosMesesAnt);
			//echo "<br>";
			//print_r($ciruitosMesesAnt);
		}
	}
	$check_registrado_3 = $check_registrado_3." group by eo.cod_u_organizaciones";
	//echo "registrados_3=".$check_registrado_3."<br>";
	
	$result=query($check_registrado_3);

	while($fila = mysql_fetch_array($result))
	{
		array_push($circuitosFinal, $fila['cod_u_organizaciones']);
	}

	array_unique($circuitosFinal);

	if(count($ciruitosMesesAnt) > 0)
	{
		//se hace la comparacion y se elimina el registro de enero
		$cont = 0;
		foreach($circuitosFinal as $valor)
		{
			if(in_array($valor, $ciruitosMesesAnt))
			{
				//echo "<br>si esta";
				//elimino del array
				unset($circuitosFinal[$cont]);
			}

			$cont++;
		}

	}
	/*$registrados_3 = 0;
	while($data=mysql_fetch_object($result))
	{		
		 $num_circuitos_3=$data->num_circuitos;
	}*/


	return $indicador_3 = count($circuitosFinal);
}

/*******************************************CUARTO INDICADOR******************************************************
/*NÚMERO DE PERSONAS QUE CONFORMAN LAS ORGANIZACIONES O UEPS QUE HAN RECIBIDO AL MENOS UN SERVICIO DE 
LA DIRECCIÓN DE FORTALECIMIENTO DE ACTORES Y QUE SE ENCUENTRAN EN LA ESTRATEGIA PARA EL CAMBIO DE LA MATRIZ PRODUCTIVA*/
function cuarto_indicador($mes,$zona)
{
	$anioCurso = getAnioSeleccionado();
	$orgRepMes = array();
	$asistenciasRepMes = array();
	$eventoOrgMes = array();
	$codAsistenciasMes = array();
	$orgReportadasMesAnterior = array();
	$cedulasReportadas = array();
	$cedulaTotalOrg = array();
	$cedulaReporteAnt = array();


	$sqlOrg = "select ev.cod_u_organizaciones, ev.cod_evento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento and year(e.fecha_reporte) = " . $anioCurso . ") inner join u_organizaciones o on (ev.cod_u_organizaciones = o.cod_u_organizaciones and o.categoria_actividad_mp <>'no_priorizado_en_el_cambio_matriz_productiva') where ev.anio = " . $anioCurso;

	$sqlAsi = "select ev.cod_u_organizaciones, ev.cod_asistencia_legal from asistencia_legal_org ev inner join u_organizaciones o on (ev.cod_u_organizaciones = o.cod_u_organizaciones and o.categoria_actividad_mp <>'no_priorizado_en_el_cambio_matriz_productiva') where ev.anio = " . $anioCurso;
	
	if($mes != "")
	{
		// si el mes ha sido asignado
		$sqlOrg .= " and month(e.fecha_reporte) = " . $mes;
		$sqlAsi .= " and month(ev.fecha_reporte) = " . $mes;
	}

	if($zona != "")
	{
		$sqlOrg .= "  and e.zona = " . $zona;
		$sqlAsi .= "  and ev.zona = " . $zona;
	}
	
	$sqlOrg .= " group by ev.cod_u_organizaciones";
	$sqlAsi .= " group by ev.cod_u_organizaciones";

	//echo $sqlOrg . "<br>" . $sqlAsi . "<br>";

	//encontramos las organizaciones que son reportadas en ese mes
	$resSqlOrg = query($sqlOrg);
	$resAsistencia = query($sqlAsi);
	while($fila = mysql_fetch_array($resSqlOrg))
	{
		array_push($orgRepMes, $fila['cod_u_organizaciones']);
		array_push($eventoOrgMes, $fila['cod_evento']);
	}

	while($fila = mysql_fetch_array($resAsistencia))
	{
		array_push($asistenciasRepMes, $fila['cod_u_organizaciones']);
		array_push($codAsistenciasMes, $fila['cod_asistencia_legal']);
	}

	/*echo $sqlOrg . "<br>";
	echo $sqlAsi . "<br>";
	print_r2($orgRepMes);
	print_r2($eventoOrgMes);
	print_r2($asistenciasRepMes);
	print_r2($codAsistenciasMes);*/

	// junto los codigos de las organizaciones, borro duplicados y reinicio el indice en el array

	$totalOrg = array_merge($orgRepMes, $asistenciasRepMes);
	//borrar codigo duplicados
	$totalOrg = array_unique($totalOrg);
	$totalOrg = array_values($totalOrg);
	//print_r2($totalOrg);

	// busco las cedulas de las organizaciones

	
	foreach($totalOrg as $valor)
	{
		$auxCodSocios = array();
		$sqlCedulaTotal = "select cod_socios from eventos_socios where cod_u_organizaciones = " . $valor;
		//echo $sqlCedulaTotal . "<br>";
		$resSqlCedulaTotal = query($sqlCedulaTotal);
		while($fila = mysql_fetch_array($resSqlCedulaTotal))
		{
			array_push($auxCodSocios, $fila['cod_socios']);
		}
		//print_r2($auxCodSocios);

		foreach($auxCodSocios as $valorSoc)
		{
			$sqlCedulaTotal1 = "select cedula from socios where estado = 1 and cod_socios = " . $valorSoc;
			//echo $sqlCedulaTotal1 . "<br>";
			$resSqlCedulaTotal1 = query($sqlCedulaTotal1);
			while($fila1 = mysql_fetch_array($resSqlCedulaTotal1))
			{
				array_push($cedulaTotalOrg, $fila1['cedula']);
			}
		}
	}

	$cedulaTotalOrg = array_unique($cedulaTotalOrg);
	$cedulaTotalOrg = array_values($cedulaTotalOrg);

	// print_r2($cedulaTotalOrg);

	// foreach($totalOrg as $valor)
	// {
	// 	$sqlCedulaTotal = "select cedula from socios where estado = 1 and cod_u_organizaciones = " . $valor;
	// 	//echo $sqlCedulaTotal . "<br>";
	// 	$resSqlCedulaTotal = query($sqlCedulaTotal);
	// 	while($fila = mysql_fetch_array($resSqlCedulaTotal))
	// 	{
	// 		array_push($cedulaTotalOrg, $fila['cedula']);
	// 	}
	// }

	// quito duplicados
	//$cedulaTotalOrg = array_unique($cedulaTotalOrg);
	//print_r2($cedulaTotalOrg);
	
	/***********************************************************
	* Se debe buscar si las organizaciones reportadas en el mes
	* ya tienen algun evento asociado en meses anteriores (esto no aplica
	* si es enero).
	************************************************************/
	
	if($mes != "")
	{
		if($mes != 1)
		{
			for($i = 1; $i < $mes; $i++)
			{
				$sqlEventosAnt = "select ev.cod_u_organizaciones from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento and year(e.fecha_reporte) = " . $anioCurso . ") inner join u_organizaciones o on (ev.cod_u_organizaciones = o.cod_u_organizaciones and o.categoria_actividad_mp <>'no_priorizado_en_el_cambio_matriz_productiva') where  ev.anio = " . $anioCurso . " and month(e.fecha_reporte) = " . $i;

				$sqlEventosAsiAnt = "select ev.cod_u_organizaciones from asistencia_legal_org ev inner join u_organizaciones o on (ev.cod_u_organizaciones = o.cod_u_organizaciones and o.categoria_actividad_mp <>'no_priorizado_en_el_cambio_matriz_productiva') where ev.anio = " . $anioCurso . " and month(ev.fecha_reporte) = " . $i;

				if($zona!="")
				{
					$sqlEventosAnt .= " and e.zona = " . $zona;
					$sqlEventosAsiAnt .= " and ev.zona = " . $zona;
				}

				$sqlEventosAnt .= " group by ev.cod_u_organizaciones";
				$sqlEventosAsiAnt .= " group by ev.cod_u_organizaciones";

				$resEventosAnt = query($sqlEventosAnt);

				while($fila = mysql_fetch_array($resEventosAnt))
				{
					array_push($orgReportadasMesAnterior, $fila['cod_u_organizaciones']);
				}

				$resEventosAnt = query($sqlEventosAsiAnt);
				while($fila = mysql_fetch_array($resEventosAnt))
				{
					array_push($orgReportadasMesAnterior, $fila['cod_u_organizaciones']);
				}

			}


			$orgReportadasMesAnterior = array_unique($orgReportadasMesAnterior);
			// reviso si alguna de estas organizaciones se encuentra en el array $totalOrg

			// busco las cedulas de las organizaciones reportadas en meses anteriores
			foreach($orgReportadasMesAnterior as $valor)
			{
				$auxCodSocios = array();
				$sqlCedulaTotal = "select cod_socios from eventos_socios where cod_u_organizaciones = " . $valor;
				//echo $sqlCedulaTotal . "<br>";
				$resSqlCedulaTotal = query($sqlCedulaTotal);
				while($fila = mysql_fetch_array($resSqlCedulaTotal))
				{
					array_push($auxCodSocios, $fila['cod_socios']);
				}
				//print_r2($auxCodSocios);

				foreach($auxCodSocios as $valorSoc)
				{
					$sqlCedulaTotal1 = "select cedula from socios where estado = 1 and cod_socios = " . $valorSoc;
					//echo $sqlCedulaTotal1 . "<br>";
					$resSqlCedulaTotal1 = query($sqlCedulaTotal1);
					while($fila1 = mysql_fetch_array($resSqlCedulaTotal1))
					{
						array_push($cedulaReporteAnt, $fila1['cedula']);
					}
				}
			}

			// 
			// foreach($orgReportadasMesAnterior as $valor)
			// {
			// 	$sqlCedulaTotal = "select cedula from socios where estado = 1 and cod_u_organizaciones = " . $valor;
			// 	//echo $sqlCedulaTotal . "<br>";
			// 	$resSqlCedulaTotal = query($sqlCedulaTotal);
			// 	while($fila = mysql_fetch_array($resSqlCedulaTotal))
			// 	{
			// 		array_push($cedulaReporteAnt, $fila['cedula']);
			// 	}
			// }

			$cedulaReporteAnt = array_unique($cedulaReporteAnt);
			//print_r2($cedulaReporteAnt);
			//print_r2($cedulaTotalOrg);

			$posicion = 0;
			foreach($cedulaTotalOrg as $valor)
			{
				//echo $valor . "<br>";
				if(in_array($valor, $cedulaReporteAnt))
				{
					
					unset($cedulaTotalOrg[$posicion]);

				}
				$posicion++;
			}

			/*$posicion = 0;
			foreach($totalOrg as $valor)
			{
				if(in_array($valor, $orgReportadasMesAnterior))
				{
					unset($totalOrg[$posicion]);
				}
				$posicion++;
			}*/
		}
	}

	//echo count($cedulaTotalOrg) . "<br>";



	// Busco las cedulas de los socios correspondientes a las organizacione finales
	/*foreach($totalOrg as $valor)
	{
		$sqlSocios = "select cedula from socios where cod_u_organizaciones = " . $valor;
		$resSocios = query($sqlSocios);
		while($fila = mysql_fetch_array($resSocios))
		{
			array_push($cedulasReportadas, $fila['cedula']);
		}
	}

	//elimino duplicados y vuelvo a reiniciar el indice del array
	$cedulasReportadas = array_unique($cedulasReportadas);
	array_values($cedulasReportadas);*/

	//print_r2($cedulasReportadas);

	return $indicador_4 = count($cedulaTotalOrg);
}

function cuarto_indicador1($mes,$zona)
{
	$anioCurso = getAnioSeleccionado();
	//echo $anioCurso . "<br>";

	//se buscara por cedula y se debera comprobar el indicador con meses anteriores
	$check_registrado_4 = "select s.cod_socios,s.cedula from socios s inner join eventos e on(s.cod_evento = e.cod_evento) inner join u_organizaciones o on (s.cod_u_organizaciones = o.cod_u_organizaciones and o.categoria_actividad_mp <>'no_priorizado_en_el_cambio_matriz_productiva') where year(s.fecha_reporte)= " . $anioCurso . " and s.estado = 1";

	/*$check_registrado_4 = "select s.cod_socios,s.cedula from socios s inner join eventos e on(s.cod_evento = e.cod_evento) inner join u_organizaciones o on (s.cod_u_organizaciones = o.cod_u_organizaciones and o.categoria_actividad_mp <>'no_priorizado_en_el_cambio_matriz_productiva') where year(s.fecha_reporte)= year(now()) and s.estado = 1";*/

	$check_registrado_4a = "select s.cod_socios,s.cedula from socios s inner join asistencia_legal_org e on(s.cod_evento = e.cod_asistencia_legal) inner join u_organizaciones o on (s.cod_u_organizaciones = o.cod_u_organizaciones and o.categoria_actividad_mp <>'no_priorizado_en_el_cambio_matriz_productiva') where year(s.fecha_reporte)= " . $anioCurso . " and s.estado = 1";

	/*$check_registrado_4a = "select s.cod_socios,s.cedula from socios s inner join asistencia_legal_org e on(s.cod_evento = e.cod_asistencia_legal) inner join u_organizaciones o on (s.cod_u_organizaciones = o.cod_u_organizaciones and o.categoria_actividad_mp <>'no_priorizado_en_el_cambio_matriz_productiva') where year(s.fecha_reporte)= year(now()) and s.estado = 1";*/	

	//variable a ser utilizada en meses mayores a enero
	$sqlMesAnterior = $check_registrado_4;
	$sqlMesAnteriora = $check_registrado_4a;

	//socios del mes 
	$sociosMes = array();

	//socios de otros meses
	$sociosMesAnt = array();
	if($zona!="-1")
	{
		$check_registrado_4 = $check_registrado_4 ." and e.zona=$zona";
		$check_registrado_4a = $check_registrado_4a ." and e.zona=$zona";
		$sqlMesAnterior = $check_registrado_4;
		$sqlMesAnteriora = $check_registrado_4a;
	}
	if($mes!="")
	{	
		$check_registrado_4 = $check_registrado_4 ." and month(s.fecha_reporte) = $mes";
		$check_registrado_4 = $check_registrado_4 ." group by s.cedula";

		$check_registrado_4a = $check_registrado_4a ." and month(s.fecha_reporte) = $mes";
		$check_registrado_4a = $check_registrado_4a." group by s.cedula";

		$result=query($check_registrado_4);		

		while($fila = mysql_fetch_array($result))
		{
			array_push($sociosMes, $fila['cedula']);
		}

		$result1=query($check_registrado_4a);		

		while($fila = mysql_fetch_array($result1))
		{
			array_push($sociosMes, $fila['cedula']);
		}

		array_unique($sociosMes);
		
		//echo "<br>" . $check_registrado_4;
		//echo "<br>" . $check_registrado_4a;
		//si el mes es diferente a 1 se debe revisar las cedulas reportadas en meses anteriores
		if($mes > 1 )
		{
			$auxSql = $sqlMesAnterior;
			$auxSql1 = $sqlMesAnteriora;
			for($i = 1; $i < $mes; $i++)
			{
				$sqlMesAnterior = $auxSql;
				$sqlMesAnteriora = $auxSql1;
				$sqlMesAnterior .= " and month(s.fecha_reporte) = " . $i . " group by s.cedula";
				$sqlMesAnteriora .= " and month(s.fecha_reporte) = " . $i . " group by s.cedula";
				//echo "<br>" . $sqlMesAnterior;
				//echo "<br>" . $sqlMesAnteriora;

				$resAux = query($sqlMesAnterior);

				while($row = mysql_fetch_array($resAux))
				{
					array_push($sociosMesAnt, $row['cedula']);
				}

				$resAux1 = query($sqlMesAnteriora);

				while($row = mysql_fetch_array($resAux1))
				{
					array_push($sociosMesAnt, $row['cedula']);
				}

			}

			//eliminamos las cedulas repetidas
			array_unique($sociosMesAnt);
			//print_r($sociosMesAnt);
			$cont = 0;

			foreach ($sociosMes as $valor) 
			{
				if(in_array($valor, $sociosMesAnt))
					unset($sociosMes[$cont]);

				$cont++;

			}
			//print_r($sociosMes);
		}	

	}
	else
	{
		$check_registrado_4 = $check_registrado_4 ." group by s.cedula";
		$check_registrado_4a = $check_registrado_4a ." group by s.cedula";

		$result=query($check_registrado_4);

		

		while($fila = mysql_fetch_array($result))
		{
			array_push($sociosMes, $fila['cedula']);
		}

		$result1=query($check_registrado_4a);		

		while($fila = mysql_fetch_array($result1))
		{
			array_push($sociosMes, $fila['cedula']);
		}

		array_unique($sociosMes);
		//print_r($sociosMes);
	}	
	
	//echo "<br>" . $check_registrado_4;
	//echo "<br>" . $check_registrado_4a;
	/*echo "<br>Socios Mes";
	print_r2($sociosMes);
	echo "<br>Socios Mes anterior";
	print_r2($sociosMesAnt);
	echo "<br>sql<br>" . $check_registrado_4;
	echo "<br>sql<br>" . $check_registrado_4a;
	echo "<br>sql<br>" . $sqlMesAnterior;
	echo "<br>sql<br>" . $sqlMesAnteriora;*/

	//$total_personas_4 = mysql_num_rows($result);
	//print_r2($sociosMes);
	return $indicador_4 = count($sociosMes);
}


/*******************************************QUINTO INDICADOR*********************************************************/
/*******************NÚMERO DE HORAS DE CAPACITACIÓN DIRIGIDA HACIA LAS ORGANIZACIONES DE LA EPS**********************/
function quinto_indicador($mes,$zona)
{

	$anioCurso = getAnioSeleccionado();

	$check_registrado_5 = "select num_horas_evento from eventos where year(fecha_reporte)= " . $anioCurso;
	//$check_registrado_5 = "select num_horas_evento from eventos where year(fecha_reporte)= year(now())";
	if($zona!="")
		{
			$check_registrado_5 = $check_registrado_5 ." and zona=$zona";
		}
	if($mes!="")
		{	
			$check_registrado_5 = $check_registrado_5 ." and month(fecha_reporte) = $mes";
		}	


	$check_registrado_5 = $check_registrado_5 ." group by cod_evento";
	
	//echo "<br>" . $check_registrado_5;
	$result=query($check_registrado_5);
	$total_horas_5 = 0;
	while($data=mysql_fetch_object($result))
	{		
		 $total_horas_5 = $total_horas_5 + $data->num_horas_evento;
	}
	return $indicador_5 = $total_horas_5;

}


/*******************************************SEXTO INDICADOR*********************************************************/
/**********************************NÚMERO DE EVENTOS PARA DIÁLOGOS SOCIALES*****************************************/
function sexto_indicador($mes,$zona)
{
	$anioCurso = getAnioSeleccionado();

	$check_registrado_6 = "select count(cod_dialogo)as num_eventos from dialogo_social where year(fecha_reporte)= " . $anioCurso;
	//$check_registrado_6 = "select count(cod_dialogo)as num_eventos from dialogo_social where year(fecha_reporte)= year(now())";
	if($zona!="")
		{
			$check_registrado_6 = $check_registrado_6 ." and zona=$zona";
		}
	if($mes!="")
		{	
			$check_registrado_6 = $check_registrado_6 ." and month(fecha_dialogo) = $mes";
		}	

	$result=query($check_registrado_6);
	//echo $check_registrado_6 . "<br>";
	$num_eventos_6 = 0;
	while($data=mysql_fetch_object($result))
	{		
		 $num_eventos_6 = $num_eventos_6 + $data->num_eventos;
	}
	return $indicador_6 = $num_eventos_6;	
}

/*******************************************SEPTIMO INDICADOR*********************************************************/
/***********************NÚMERO DE PERSONAS QUE ASISTIERON A CAPACITACIONES EN EPS*************************************/
function septimo_indicador($mes,$zona)
{

	$anioCurso = getAnioSeleccionado();

	$num_eventos_7 = 0;
	$cedulaReportadasAnt = array();
	$cedulaMes = array();
	//$check_registrado_7 = "select count(*)num_eventos from capacitaciones_eps where month(fecha_reporte) = $mes";
	$check_registrado_7 = "select cedula from asistentes where tipo_evento = 'EPS' ";
	if($zona!="")
		{
			$check_registrado_7 = $check_registrado_7 ." and zona=$zona";
		}
	if($mes!="")
		{	
			$check_registrado_7 = $check_registrado_7 ." and month(fecha_reporte) = $mes and year(fecha_reporte) =" . $anioCurso;
			//$check_registrado_7 = $check_registrado_7 ." and month(fecha_reporte) = $mes and year(fecha_reporte) = year(now())";
		}
	$check_registrado_7 = $check_registrado_7 ." group by cedula";
	//echo $check_registrado_7 . "<br>";

	if($mes > 1)
	{
		for($i = 1; $i < $mes; $i++)
		{
			$sqlAsistentesAnt = "select cedula from asistentes where tipo_evento = 'EPS' and year(fecha_reporte) = " . $anioCurso . " and month(fecha_reporte) = " . $i;

			//$sqlAsistentesAnt = "select cedula from asistentes where tipo_evento = 'EPS' and year(fecha_reporte) = year(now()) and month(fecha_reporte) = " . $i;

			$auxRes = query($sqlAsistentesAnt);
			while($fila = mysql_fetch_array($auxRes))
			{
				array_push($cedulaReportadasAnt, $fila['cedula']);
			}

		}
		
	}
	
	//echo "<br>" . $check_registrado_7;
	$result=query($check_registrado_7);
	while($fila = mysql_fetch_array($result))
	{
		array_push($cedulaMes, $fila['cedula']);
	}
	$cedulaSinDuplicados = array_unique($cedulaMes);
	$cont= 0;

	foreach ($cedulaSinDuplicados as $valor) 
	{
		if(in_array($valor, $cedulaReportadasAnt))
		{
			unset($cedulaSinDuplicados[$cont]);
		}
		$cont++;
	}

	$num_eventos_7 = count($cedulaSinDuplicados);
	//print_r2($cedulaSinDuplicados);

	//$num_eventos_7 = mysql_num_rows($result);
	return $indicador_7 = $num_eventos_7;
}


/*******************************************OCTAVO INDICADOR*********************************************************/
/****NÚMERO DE NUEVAS ORGANIZACIONES DE LA EPS QUE RECIBIERON AL MENOS UN SERVICIO DE FORTALICIMIENTO DE ACTORES*****/
function octavo_indicador($mes,$zona)
{

	$anioCurso = getAnioSeleccionado();
	$arrayEventos = array();
	$arrayAsistencias = array();
	$arrayOrgEventos = array();
	$arrayOrgAsistencias = array();

	//consulto los eventos relacioneados a este mes
	$sqlEventosMes = "select ev.cod_evento, e.fecha_reporte, e.tipo_evento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento) where e.tipo_evento = 'org' and ev.anio = " . $anioCurso . "  and e.anio = " . $anioCurso;

	$sqlAsistencias = "select a.cod_asistencia_legal, a.estado_proceso_org, a.anio from asistencia_legal_org a where a.anio = " . $anioCurso;

	if($mes != -1)
	{
		$sqlEventosMes .= " and month(e.fecha_reporte) = " . $mes;
		if($mes == 1)
		{
			$sqlAsistencias .= " and a.estado_proceso_org in ('adecuacion_de_estatutos') and month(a.fecha_reporte) = " . $mes;
		}
		else
		{
			$sqlAsistencias .= " and a.estado_proceso_org in ('aprobacion_de_personalidad_juridica', 'adecuacion_de_estatutos') and month(a.fecha_reporte) = " . $mes;
		}		

	}

	if($zona != -1)
	{
		$sqlEventosMes .= " and e.zona = " . $zona;
		$sqlAsistencias .= " and a.zona = " . $zona;
	}

	$sqlEventosMes .= " group by ev.cod_evento";
	$sqlAsistencias .= " group by a.cod_asistencia_legal";

	/*echo $sqlEventosMes . "<br>";
	echo $sqlAsistencias . "<br>";*/

	$resSqlEventosMes = query($sqlEventosMes);
	$resSqlAsistencias = query($sqlAsistencias);

	while($fila = mysql_fetch_array($resSqlEventosMes))
	{
		array_push($arrayEventos, $fila['cod_evento']);
	}

	while($fila = mysql_fetch_array($resSqlAsistencias))
	{
		array_push($arrayAsistencias, $fila['cod_asistencia_legal']);
	}

	/*print_r2($arrayEventos);
	print_r2($arrayAsistencias);*/
	$codEventos = "(";
	$codAsistencias = "(";
	$tamArrayEventos = count($arrayEventos);
	$tamArrayAsistencias = count($arrayAsistencias);

	if($tamArrayEventos > 0)
	{
		for($i = 0; $i < $tamArrayEventos; $i++)
		{
			if($i == ($tamArrayEventos - 1))
				$codEventos .= "'" . $arrayEventos[$i] . "')";
			else
				$codEventos .= "'" . $arrayEventos[$i] . "',";
		}

		$sqlOrgEventos = "select cod_u_organizaciones from eventos_u_organizaciones where cod_evento in " . $codEventos . " and anio = " . $anioCurso . " and tipo_evento = 'org' group by cod_u_organizaciones";
		//echo $sqlOrgEventos . "<br>";
		$resSqlOrgEventos = query($sqlOrgEventos);
		while($fila = mysql_fetch_array($resSqlOrgEventos))
		{
			$sqlNumEventosOrg = "select cod_evento, anio from eventos_u_organizaciones where cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and tipo_evento = 'org'";
			//echo $sqlNumEventosOrg . "<br>";

			$resNumEventosOrg = query($sqlNumEventosOrg);
			$orgNueva = 1;
			//echo $fila['cod_u_organizaciones'] . " - " . mysql_num_rows($resNumEventosOrg) . "<br>";

			while($fila1 = mysql_fetch_array($resNumEventosOrg))
			{
				if($fila1['anio'] < $anioCurso)
				{
					$orgNueva = 0;
					break;
				}
				else
				{
					$sqlEvento = "select year(fecha_reporte) as anio, month(fecha_reporte) as mess from eventos where cod_evento = '" . $fila1['cod_evento'] . "' and anio = " . $fila1['anio'] . " and tipo_evento = 'org'";
					//echo $sqlEvento . "<br>";
					$resSqlEvento = query($sqlEvento);
					while($fila2 = mysql_fetch_array($resSqlEvento))
					{
						if($fila2['anio'] == $anioCurso && $fila2['mess'] < $mes)
						{
							$orgNueva = 0;
							break;
						}
					}
				}
			}

			

			$sqlNumAsistenciasOrg = "select cod_asistencia_legal, anio from asistencia_legal_org where cod_u_organizaciones = " . $fila['cod_u_organizaciones'];
			$resNumAsistenciasOrg = query($sqlNumAsistenciasOrg);
			//echo $sqlNumAsistenciasOrg . "<br>";
			

			while($fila1 = mysql_fetch_array($resNumAsistenciasOrg))
			{
				if($fila1['anio'] < $anioCurso)
				{
					$orgNueva = 0;
					break;
				}
				else
				{
					$sqlEvento = "select year(fecha_reporte) as anio, month(fecha_reporte) as mess from asistencia_legal_org where cod_asistencia_legal = '" . $fila1['cod_asistencia_legal'] . "' and anio = " . $fila1['anio'];
					//echo $sqlEvento . "<br>";
					$resSqlEvento = query($sqlEvento);
					while($fila2 = mysql_fetch_array($resSqlEvento))
					{
						if($fila2['anio'] == $anioCurso && $fila2['mess'] < $mes)
						{
							$orgNueva = 0;
							break;
						}
					}
				}
			}

			if($orgNueva == 1)
				array_push($arrayOrgEventos, $fila['cod_u_organizaciones']);


			/*if(mysql_num_rows($resNumEventosOrg) == 1)
				array_push($arrayOrgEventos, $fila['cod_u_organizaciones']);*/
		}
	}

	if($tamArrayAsistencias > 0)
	{
		for($i = 0; $i < $tamArrayAsistencias; $i++)
		{
			if($i == ($tamArrayAsistencias - 1))
				$cosAsistencias .= "'" . $arrayEventos[$i] . "')";
			else
				$cosAsistencias .= "'" . $arrayEventos[$i] . "',";
		}

		$sqlOrgAsistencias = "select cod_u_organizaciones from asistencia_legal_org where cod_asistencia_legal in " . $cosAsistencias . " and anio = " . $anioCurso . " group by cod_u_organizaciones";
		//echo $sqlOrgAsistencias . "<br>";
		$resSqlOrgAsistencias = query($sqlOrgAsistencias);
		while($fila = mysql_fetch_array($resSqlOrgAsistencias))
		{
			$sqlNumAsistenciasOrg = "select cod_asistencia_legal, anio from asistencia_legal_org where cod_u_organizaciones = " . $fila['cod_u_organizaciones'];
			$resNumAsistenciasOrg = query($sqlNumAsistenciasOrg);
			//echo $sqlNumAsistenciasOrg . "<br>";
			$orgNueva = 1;

			while($fila1 = mysql_fetch_array($resNumAsistenciasOrg))
			{
				if($fila1['anio'] < $anioCurso)
				{
					$orgNueva = 0;
					break;
				}
				else
				{
					$sqlEvento = "select year(fecha_reporte) as anio, month(fecha_reporte) as mess from asistencia_legal_org where cod_asistencia_legal = '" . $fila1['cod_asistencia_legal'] . "' and anio = " . $fila1['anio'];
					//echo $sqlEvento . "<br>";
					$resSqlEvento = query($sqlEvento);
					while($fila2 = mysql_fetch_array($resSqlEvento))
					{
						if($fila2['anio'] == $anioCurso && $fila2['mess'] < $mes)
						{
							$orgNueva = 0;
							break;
						}
					}
				}
			}

			

			$sqlNumEventosOrg = "select cod_evento, anio from eventos_u_organizaciones where cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and tipo_evento = 'org'";
			//echo $sqlNumEventosOrg . "<br>";

			$resNumEventosOrg = query($sqlNumEventosOrg);			
			//echo $fila['cod_u_organizaciones'] . " - " . mysql_num_rows($resNumEventosOrg) . "<br>";

			while($fila1 = mysql_fetch_array($resNumEventosOrg))
			{
				if($fila1['anio'] < $anioCurso)
				{
					$orgNueva = 0;
					break;
				}
				else
				{
					$sqlEvento = "select year(fecha_reporte) as anio, month(fecha_reporte) as mess from eventos where cod_evento = '" . $fila1['cod_evento'] . "' and anio = " . $fila1['anio'] . " and tipo_evento = 'org'";
					//echo $sqlEvento . "<br>";
					$resSqlEvento = query($sqlEvento);
					while($fila2 = mysql_fetch_array($resSqlEvento))
					{
						if($fila2['anio'] == $anioCurso && $fila2['mess'] < $mes)
						{
							$orgNueva = 0;
							break;
						}
					}
				}
			}

			if($orgNueva == 1)
				array_push($arrayOrgAsistencias, $fila['cod_u_organizaciones']);


			/*if(mysql_num_rows($resNumAsistenciasOrg) == 1)
				array_push($arrayOrgAsistencias, $fila['cod_u_organizaciones']);*/
		}
	}

	/*print_r2($arrayOrgEventos);
	print_r2($arrayOrgAsistencias);*/

	//echo $codEventos . "<br>" . $codAsistencias . "<br>";

	// revisar los codigos de eventos de meses anteriores y tener los organizaciones de meses anteriores
	

	$arrayOrgEventos = array_values($arrayOrgEventos);
	$arrayOrgAsistencias = array_values($arrayOrgAsistencias);
	/*print_r2($arrayOrgEventos);
	print_r2($arrayOrgAsistencias);*/

	$arrayOrgEventos = array_merge($arrayOrgEventos, $arrayOrgAsistencias);
	$arrayOrgEventos = array_unique($arrayOrgEventos);

	//print_r2($arrayOrgEventos);

	return count($arrayOrgEventos);



}

function octavo_indicador1($mes,$zona)
{
	

	$anioCurso = getAnioSeleccionado();

	$organizaciones = "select eo.cod_u_organizaciones as ruc from eventos_u_organizaciones eo 
	inner join eventos e on(eo.cod_evento = e.cod_evento)
	inner join u_organizaciones o on(eo.cod_u_organizaciones = o.cod_u_organizaciones)
	where eo.tipo_evento = 'ORG' and eo.anio = " . $anioCurso . " and year(o.fecha_registro) = " . $anioCurso;

	/*$organizaciones = "select eo.cod_u_organizaciones as ruc from eventos_u_organizaciones eo 
	inner join eventos e on(eo.cod_evento = e.cod_evento)
	inner join u_organizaciones o on(eo.cod_u_organizaciones = o.cod_u_organizaciones)
	where eo.tipo_evento = 'ORG' and year(o.fecha_registro) = year(now())"; */ 
	$orgRepetidas = $organizaciones;
	if($zona != "-1")
		{
			$organizaciones = $organizaciones." and e.zona = $zona";
		}
	if($mes!="")
		{	
			$organizaciones = $organizaciones." and month(e.fecha_registro) = $mes"; 
		}
	
	$organizaciones = $organizaciones." group by eo.ruc_institucion";
	
	/*******************************************************************************************************************************************/
	/********CONSULTA TODAS LAS ASISTENCIAS LEGALES EN ESTADO DEL PROCESO 'adecuacion_de_estatutos y solicitud_de_constitucion_ingresada'*******/ 	
	$asistencia_legal = "select al.cod_u_organizaciones as ruc from asistencia_legal_org al 
	inner join u_organizaciones o on(al.cod_u_organizaciones = o.cod_u_organizaciones)
	where year(o.fecha_registro) = " . $anioCurso;

	/*$asistencia_legal = "select al.cod_u_organizaciones as ruc from asistencia_legal_org al 
	inner join u_organizaciones o on(al.cod_u_organizaciones = o.cod_u_organizaciones)
	where year(o.fecha_registro) = year(now())";*/
	$asisRepetidas = $asistencia_legal;	
		
	if($zona != "-1")
		{
			$asistencia_legal = $asistencia_legal." and zona = $zona";
		}
	if($mes!="")
		{	
			if($mes != 1)
				$asistencia_legal .= " and estado_proceso_org in('aprobacion_de_personalidad_juridica','adecuacion_de_estatutos')";
			else
				$asistencia_legal .= " and estado_proceso_org in('adecuacion_de_estatutos')";

			$asistencia_legal = $asistencia_legal." and month(al.fecha_registro) = $mes"; 
		}

	$asistencia_legal = $asistencia_legal." group by al.ruc_org";
	
		
	/*************************************************************************************/
	/************************UNION DE LAS DOS CONSULTAS***********************************/
	$check_repetidos_eventos_asistencia_legal_8 = $organizaciones.' UNION '.$asistencia_legal;

	//echo "<br> check_repetidos_eventos_asistencia_legal_1=".$check_repetidos_eventos_asistencia_legal_8."<br>";
	$result=query($check_repetidos_eventos_asistencia_legal_8);

	$orgMes = array();
	while($fila = mysql_fetch_array($result))
	{
		array_push($orgMes, $fila['ruc']);
	}

	//print_r2($orgMes);

	$repetidas = array();
	if($mes > 1)
	{
		for($i = 1; $i < $mes; $i++)
		{
			$auxOrg = $orgRepetidas;
			$auxAsi = $asisRepetidas;
			if($zona != "-1")
			{
				$auxOrg = $auxOrg." and e.zona = $zona";
				$auxAsi = $auxAsi." and zona = $zona";

			}
			
			$auxOrg = $auxOrg." and month(e.fecha_registro) = " . $i; 
			if($i != 1)
				$auxAsi .= " and estado_proceso_org in('aprobacion_de_personalidad_juridica','adecuacion_de_estatutos')";
			else
				$auxAsi .= " and estado_proceso_org in('adecuacion_de_estatutos')";

			$auxAsi = $auxAsi." and month(al.fecha_registro) = " . $i; 
			

			$auxUnion = $auxOrg . " UNION " . $auxAsi;
			$auxRes = query($auxUnion);

			while($fila = mysql_fetch_array($auxRes))
			{
				array_push($repetidas, $fila['ruc']);
			}

		}

		$repetidas1 = array_unique($repetidas);
		//print_r2($repetidas1);

		$cont= 0;

		foreach ($orgMes as $valor) 
		{
			if(in_array($valor, $repetidas1))
			{
				unset($orgMes[$cont]);
			}
			$cont++;
		}


	}

	

	$repetidos_eventos_asistencia_legal_8 = 0;
	//print_r2($orgMes);

	//$total_organizaciones = mysql_num_rows($result);	
	$total_organizaciones = count($orgMes);	

	return $indicador_8 = $total_organizaciones;
}

/*******************************************NOVENO INDICADOR*********************************************************/
/*****************NÚMERO DE PERSONAS CAPACITADAS EN TEMAS ADMINISTRATIVOS, ORGANIZATIVOS Y TECNICOS *****************/
function noveno_indicador($mes,$zona)
{

	$anioCurso = getAnioSeleccionado();

	$num_eventos_9 = 0;
	$cedReportadaAnt = array();
	$cedRepMes = array();	
	$check_registrado_9 = "select e.cod_evento,a.tipo_evento, a.cedula from asistentes a 
	inner join eventos e on(a.cod_evento = e.cod_evento and (e.tipo_evento = 'UEP' or e.tipo_evento = 'ORG'))
	where a.tipo_evento in('UEP','ORG') and a.anio= 2017 and year(e.fecha_reporte)= " . $anioCurso;

	/*$check_registrado_9 = "select e.cod_evento,a.tipo_evento, a.cedula from asistentes a 
	inner join eventos e on(a.cod_evento = e.cod_evento and (e.tipo_evento = 'UEP' or e.tipo_evento = 'ORG'))
	where a.tipo_evento in('UEP','ORG') and year(e.fecha_reporte)= year(now())";*/

	$sqlMesAnterior = $check_registrado_9;
	
	if($zona!="-1")
		{
			$check_registrado_9 = $check_registrado_9 ." and e.zona=$zona";
			$sqlMesAnterior = $check_registrado_9;
		}
	if($mes!="")
		{	
			$check_registrado_9 = $check_registrado_9 ." and month(e.fecha_reporte) = $mes";	


		}
	$check_registrado_9 = $check_registrado_9 ." group by a.cedula";
	//echo $check_registrado_9 . "<br>";

	if($mes > 1)
	{
		for($i = 1; $i < $mes; $i++)
		{
			$sqlCedRepAnt = "select e.cod_evento,a.tipo_evento, a.cedula from asistentes a 
			inner join eventos e on(a.cod_evento = e.cod_evento and (e.tipo_evento = 'UEP' or e.tipo_evento = 'ORG'))
			where a.tipo_evento in('UEP','ORG') and a.anio= " . $anioCurso . " and year(e.fecha_reporte)= " . $anioCurso . " and month(e.fecha_reporte) = " . $i . "and e.anio= " . $anioCurso;

			/*$sqlCedRepAnt = "select e.cod_evento,a.tipo_evento, a.cedula from asistentes a 
			inner join eventos e on(a.cod_evento = e.cod_evento and (e.tipo_evento = 'UEP' or e.tipo_evento = 'ORG'))
			where a.tipo_evento in('UEP','ORG') and year(e.fecha_reporte)= year(now()) and month(e.fecha_reporte) = " . $i;*/

			$resMesAnt = query($sqlCedRepAnt);

			while($fila = mysql_fetch_array($resMesAnt))
			{
				array_push($cedReportadaAnt, $fila['cedula']);
			}
		}
		

	}

	//echo "***check_registrado_9 = ".$check_registrado_9."<br>";

	$result=query($check_registrado_9);

	while($fila = mysql_fetch_array($result))
	{
		array_push($cedRepMes, $fila['cedula']);
	}

	$cedSinDuplicados = array_unique($cedRepMes);
	$cont++;

	foreach ($cedSinDuplicados as $valor) 
	{
		if(in_array($valor, $cedReportadaAnt))
		{
			unset($cedSinDuplicados[$cont]);
		}
		$cont++;
	}

	//$num_eventos_9 = mysql_num_rows($result);
	$num_eventos_9 = count($cedSinDuplicados);
	return $indicador_9 = $num_eventos_9;
}
/************************************FUNCION PARA TRAER LA META PROGRAMADA*********************************************************/

function meta_programada($zona,$cod_indicador,$cod_mes)
{

	$anioCurso = getAnioSeleccionado();

	//echo "meta_programada=".$zona.",".$cod_indicador.",".$cod_mes."<br>";
	$consulta_meses1="SELECT izm.mes,izm.meta_programada from indicador i 
					inner join indicador_zona iz on(i.cod_indicador = iz.cod_indicador)
					inner join indicador_zona_mes izm on(iz.cod_indicador_zona = izm.cod_indicador_zona and izm.anio_indicador = $anioCurso)
					inner join catalogo c on(c.codigo = izm.mes and tipo = 'meses')
					where estado = 1 and iz.cod_zona = $zona and iz.cod_indicador = $cod_indicador";
					//FILTRO POR INDICADOR
					if($cod_mes != -1)	
						{$consulta_meses1 = $consulta_meses1 ." and izm.mes = $cod_mes";}	
					  
	//echo "**************meta_programada=".$consulta_meses1."*****************<br>";
	$result_meses1=query($consulta_meses1);
	$numRows = mysql_num_rows($result_meses1);
	if($numRows > 0)
	{
		while($mes_aux1=mysql_fetch_object($result_meses1))
		{			
			$valor_meta_programada = $mes_aux1->meta_programada;
			//echo '<td align="center" bgcolor="#D7E4BC">'.$meta_programada.'</td>';
			$consulta = $consulta.'<td align="center">'.$valor_meta_programada .'</td>';
			$valor_meta_programada_total = $valor_meta_programada + $valor_meta_programada_total;
		}
		$consulta = $consulta.'<td align="center" bgcolor="#D7E4BC"><strong>'.$valor_meta_programada_total.'</strong></td>';
	}
	else
	{
		$valor_meta_programada = 0;
		//echo '<td align="center" bgcolor="#D7E4BC">'.$meta_programada.'</td>';
		$consulta = $consulta.'<td align="center">'.$valor_meta_programada .'</td>';
		$valor_meta_programada_total = $valor_meta_programada + $valor_meta_programada_total;
		$consulta = $consulta.'<td align="center" bgcolor="#D7E4BC"><strong>'.$valor_meta_programada_total.'</strong></td>';
	}
	
	return $consulta;
}

/************************************FUNCION PARA TRAER LA META EJECUTADA*********************************************************/

function meta_ejecutada($zona,$cod_indicador,$cod_mes)
{
	$anioCurso = getAnioSeleccionado();
	//$consulta_meses1="select valor from catalogo where tipo ='meses'";
	$consulta_meses1="SELECT izm.mes,izm.meta_programada from indicador i 
					inner join indicador_zona iz on(i.cod_indicador = iz.cod_indicador)
					inner join indicador_zona_mes izm on(iz.cod_indicador_zona = izm.cod_indicador_zona and izm.anio_indicador = $anioCurso)
					inner join catalogo c on(c.codigo = izm.mes and tipo = 'meses')
					where estado = 1 and iz.cod_zona = $zona and iz.cod_indicador = $cod_indicador ";
	//FILTRO POR INDICADOR
	if($cod_mes != -1)	
		{$consulta_meses1 = $consulta_meses1 ." and izm.mes = $cod_mes";}	
					
	$result_meses2=query($consulta_meses1);
	$consulta="";
	while($mes_aux2=mysql_fetch_object($result_meses2))
		{
			$mes = $mes_aux2->mes;
			$meta_alcanzada = resultado_indicadores($cod_indicador, $mes, $zona);
			$claseMetaEjecutada = $zona . "-" . $mes . "-" . $cod_indicador;
			//echo '<td align="center" bgcolor="#93CDDD">'.$meta_alcanzada.'</td>';
			$consulta = $consulta.'<td align="center" class="' . $claseMetaEjecutada . '">'.$meta_alcanzada.'</td>';
			$meta_alcanzada_total = $meta_alcanzada + $meta_alcanzada_total;
		}
	$consulta = $consulta.'<td align="center" bgcolor="#93CDDD"><strong>'.$meta_alcanzada_total.'</strong></td>';
	$consulta =  $consulta.'<td align="center" bgcolor="#93CDDD"><a href="../../clases/detalle.php?indicador=' . $cod_indicador . '&mes=' . $cod_mes . '&zona=' . $zona . '&anio='. $anioCurso . '" target="_blank">Detalle</a></td>';
	return $consulta;
}

function print_r2($val)
{
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}


?>
