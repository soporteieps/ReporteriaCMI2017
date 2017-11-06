<?php
//include("../lib/dbconfig.php");
$nombresMes  = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');


function GetHeadReporte($indiceReporte)
{
	$headTable = "";
	if($indiceReporte == 1)
	{
		$headTable = "<tr class='cabecera'>
						<th>AÑO</th>
						<th>MES</th>
						<th>ZONA</th>
						<th>PROVINCIA</th>
						<th>CANTÓN</th>
						<th>PARROQUIA</th>
						<th>TIPO DE ORGANIZACIÓN</th>
						<th>NOMBRE DE LA ORGANIZACIÓN</th>
						<th>ANTIGÜEDAD</th>
						<th>CÓDIGO DE EMPRENDIMIENTO</th>
						<th>RUC /RISE</th>
						<th>NOMBRE DEL REPRESENTANTE LEGAL</th>
						<th>TELÉFONO CONVENCIONAL</th>
						<th>TELÉFONO CELULAR</th>
						<th>CORREO ELECthÓNICO</th>
						<th>COLOQUE 'SI', EN CASO DE QUE ALIMENTE AL INDICADOR DE CIRCUITOS.</th>
						<th>ASESORÍA PARA LA ELABORACIÓN DE PLANES DE NEGOCIO SOLIDARIOS</th>
						<th>DESCRIPCIÒN</th>
						<th>COFINANCIAMIENTO PARA PROYECTOS DE LA EPS</th>
						<th>DESCRIPCIÒN</th>
						<th>ASISTENCIA TÉCNICA EN PROCESOS ADMINISthATIVOS</th>
						<th>DESCRIPCIÒN</th>
						<th>ALIANZAS CON INSTITUCIONES PARA LA AT EN PROCESOS OPERATIVOS</th>
						<th>DESCRIPCIÒN</th>
						<th>MONTO DE COFINANCIAMIENTO</th>
						<th>DESTINO DEL FINANCIAMIENTO</th>
						<th>CIRCUITO HABILITANTE</th>
						<th>SECTOR DE LA MAthIZ PRODUCTIVA</th>
						<th>ACTIVIDAD DE LA MAthIZ PRODUCTIVA</th>
						<th>DESCRIPCIÓN DEL BIEN O SERVICIO</th>
						<th>URBANO</th>
						<th>RURAL</th>
						<th>TOTAL</th>
						<th>EJECUTADO</th>
						<th>SERVICIO</th>
						<th>TIPO SERVICIO</th>
						<th>ESTADO</th>
						<th>VALIDADOS</th>
						<th>NOMBRE REPRESENTANTE LEGAL</th>
						<th>CÉDULA REPRESENTANTE LEGAL</th>
						<th>ETNIA</th>
						<th>SEXO</th>
					</tr>";
	}

	else if($indiceReporte == 2)
	{
		$headTable = "<tr class='cabecera'>
						<th>AÑO</th>
						<th>MES</th>
						<th>ZONA</th>
						<th>PROVINCIA</th>
						<th>CANTÓN</th>
						<th>PARROQUIA</th>
						<th>TIPO DE ORGANIZACIÓN</th>
						<th>NOMBRE DE LA ORGANIZACIÓN</th>
						<th>ANTIGÜEDAD</th>
						<th>CÓDIGO DE EMPRENDIMIENTO</th>
						<th>RUC /RISE</th>
						<th>NOMBRE DEL REPRESENTANTE LEGAL</th>
						<th>TELÉFONO CONVENCIONAL</th>
						<th>TELÉFONO CELULAR</th>
						<th>CORREO ELECthÓNICO</th>
						<th>COLOQUE 'SI', EN CASO DE QUE ALIMENTE AL INDICADOR DE CIRCUITOS.</th>
						<th>ASESORÍA PARA LA ELABORACIÓN DE PLANES DE NEGOCIO SOLIDARIOS</th>
						<th>DESCRIPCIÒN</th>
						<th>COFINANCIAMIENTO PARA PROYECTOS DE LA EPS</th>
						<th>DESCRIPCIÒN</th>
						<th>ASISTENCIA TÉCNICA EN PROCESOS ADMINISthATIVOS</th>
						<th>DESCRIPCIÒN</th>
						<th>ALIANZAS CON INSTITUCIONES PARA LA AT EN PROCESOS OPERATIVOS</th>
						<th>DESCRIPCIÒN</th>
						<th>MONTO DE COFINANCIAMIENTO</th>
						<th>DESTINO DEL FINANCIAMIENTO</th>
						<th>CIRCUITO HABILITANTE</th>
						<th>SECTOR DE LA MAthIZ PRODUCTIVA</th>
						<th>ACTIVIDAD DE LA MAthIZ PRODUCTIVA</th>
						<th>DESCRIPCIÓN DEL BIEN O SERVICIO</th>
						<th>URBANO</th>
						<th>RURAL</th>
						<th>TOTAL</th>
						<th>EJECUTADO</th>
						<th>CÉDULA</th>
						<th>VALIDACIÓN</th>
						<th>NOMBRES</th>
						<th>ETNIA</th>
						<th>GENERO</th>						
						<th>ESTADO</th>
					</tr>";
	}

	return $headTable;
}

function getAnio()
{
	$anioAux = $_GET['anio'];
	return $anioAux;
}

function getMes()
{
	$auxMes = $_GET['mes'];
	return $auxMes;
}

function getReporteIndice()
{
	$auxReporte = $_GET['reporte'];
	return $auxReporte;
}

function ReporteBaseOepsUeps()
{
	global $nombresMes;
	$anio = getAnio();
	$mesConsulta = getMes();
	$resultadoConsulta = array();
	$tableBody = "";
	$consultaReporte = "select * from fp_asesoria_asistencia_cofinanciamiento
	where month(fecha_reporte) = " . $mesConsulta . " and year(fecha_reporte)=" . $anio . "
	order by zona";

	$resConsultaReporte = query($consultaReporte);


	while($fila = mysql_fetch_array($resConsultaReporte))
	{
		array_push($resultadoConsulta, $anio);
		array_push($resultadoConsulta, $nombresMes[$mesConsulta - 1]);

		$zona = $fila['zona'];
		$codProv = $fila['cod_provincia'];
		$nombreProv = GetNombreProvincia($zona, $codProv);
		array_push($resultadoConsulta, "DTZ" . $zona);
		array_push($resultadoConsulta, $nombreProv);

		$codCanton = $fila['cod_canton'];
		$canton = GetNombreCanton($codProv, $codCanton);
		array_push($resultadoConsulta, $canton);

		$codParroquia = $fila['cod_parroquia'];
		$nParroquia = GetNombreParroquia($codProv, $codCanton, $codParroquia);
		array_push($resultadoConsulta, $nParroquia); 

		$codOrg = $fila['cod_u_organizaciones'];
		$tipoOrg = GetInformacionOrg($codOrg, "tipoOrg");
		if($tipoOrg == 'org')
			array_push($resultadoConsulta, "ORGANIZACIÓN");
		else
			array_push($resultadoConsulta, "UNIDAD ECONÓMICA SOLIDARIA");

		$nOrg = GetInformacionOrg($codOrg, 'nombre');
		array_push($resultadoConsulta, $nOrg);

		//antiguedad
		if($fila['antiguedad'] == 'si')
			array_push($resultadoConsulta, "antigua");
		else
			array_push($resultadoConsulta, "nueva");
		//array_push($resultadoConsulta, $fila['antiguedad']);

		// codigo emprendimiento 
		array_push($resultadoConsulta, '-');

		// ruc
		$rOrg = GetInformacionOrg($codOrg, 'ruc');
		array_push($resultadoConsulta, $rOrg);

		// nombre representante legal
		$nRepresentanteOrg = GetInformacionOrg($codOrg, 'representante');
		if($nRepresentanteOrg == '')
			array_push($resultadoConsulta, 'NO SE REGISTRA EN EL SIU');
		else
			array_push($resultadoConsulta, $nRepresentanteOrg);

		// telefono org
		$tOrg = GetInformacionOrg($codOrg, 'telefono');
		array_push($resultadoConsulta, $tOrg);

		//celular
		$cOrg = GetInformacionOrg($codOrg, 'celular');
		if($cOrg == '')
			array_push($resultadoConsulta, 'NO SE REGISTRA EN SIU');
		else
			array_push($resultadoConsulta, $cOrg);

		//mail
		$emailOrg = GetInformacionOrg($codOrg, 'email');
		if($emailOrg == '')
			array_push($resultadoConsulta, 'NO SE REGISTRA EN SIU');
		else
			array_push($resultadoConsulta, $emailOrg);

		// circuito economico
		$circuitoOrg = GetInformacionOrg($codOrg, 'circuito');
		array_push($resultadoConsulta, $circuitoOrg);

		// *********************************** 
		// Servicios
		// 1 - ASESORIAS PARA LA ELABORACI�N DE PLANES DE NEGOCIOS SOLIDARIOS
		// 2 - COFINANCIAMIENTO PARA PROYECTOS DE LA EPS
		// 3 - ASISTENCIA T�CNICA EN PROCESOS ADMINISTRATIVOS
		// 4 - ALIANZAS CON INSTITUCIONES PARA LA ASISTENCIA T�CNICA EN PROCESOS OPERATIVOS

		$codServicioOrg = $fila['cod_servicio'];

		if($codServicioOrg == 1) 
		{
			array_push($resultadoConsulta, '1');
			array_push($resultadoConsulta, $fila['descripcion']);
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
		}

		else if($codServicioOrg == 2) 
		{
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '1');
			array_push($resultadoConsulta, $fila['descripcion']);
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
		}

		else if($codServicioOrg == 3) 
		{
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '1');
			array_push($resultadoConsulta, $fila['descripcion']);
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
		}

		else if($codServicioOrg == 4) 
		{
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '1');
			array_push($resultadoConsulta, $fila['descripcion']);
		}

		// fin servicios
		//*******************************

		// monto de cofinanciamiento
		$montonCofinanciamiento = $fila['monto_cofinanciamiento'];
		array_push($resultadoConsulta, $montonCofinanciamiento);

		// destino del financiamiento
		$destinoFinanciamiento = $fila['destino_financiamiento'];
		if($destinoFinanciamiento == '')
			array_push($resultadoConsulta, '0');
		else
			array_push($resultadoConsulta, $destinoFinanciamiento);

		// circuito habilitante
		$circuitoHabilitante = $fila['circuito_habilitante'];
		if($circuitoHabilitante == '')
			array_push($resultadoConsulta, '0');
		else
			array_push($resultadoConsulta, $circuitoHabilitante);

		// sector de la matriz productiva
		$sectorMatrizP = $fila['categoria_actividad_mp'];
		array_push($resultadoConsulta, $sectorMatrizP);

		// identificacion actividad matriz productiva
		$actividadMatrizP = $fila['identificacion_actividad_mp'];
		array_push($resultadoConsulta, $actividadMatrizP);

		// descripcion del bien o servicio
		$descripcionBien = $fila['descripcion_bien_servicio'];
		array_push($resultadoConsulta, $descripcionBien);

		// num personas urbanas
		$numPersonasUrbanas = $fila['num_per_urbanas'];
		array_push($resultadoConsulta, $numPersonasUrbanas);

		// num personas rurales
		$numPersonasRurales = $fila['num_per_rurales'];
		array_push($resultadoConsulta, $numPersonasRurales);

		// total personas beneficiarias
		$totalPersonas = $numPersonasUrbanas + $numPersonasRurales;
		array_push($resultadoConsulta, $totalPersonas);

		// ejecutado
		$ejecutadoOrg = $fila['documentacion_valida'];
		array_push($resultadoConsulta, $ejecutadoOrg);

		// servicio
		if($ejecutadoOrg == 'si')
			array_push($resultadoConsulta, 1);
		else
			array_push($resultadoConsulta, 0);

		// describe servicio
		if($codServicioOrg == 1)
			array_push($resultadoConsulta, "ASESORIAS PARA LA ELABORACIÓN DE PLANES DE NEGOCIOS SOLIDARIOS");
		else if($codServicioOrg == 2)
			array_push($resultadoConsulta, "COFINANCIAMIENTO PARA PROYECTOS DE LA EPS");
		else if($codServicioOrg == 3)
			array_push($resultadoConsulta, "ASISTENCIA T�CNICA EN PROCESOS ADMINISTRATIVOS");
		else if($codServicioOrg == 4)
			array_push($resultadoConsulta, "ALIANZAS CON INSTITUCIONES PARA LA ASISTENCIA T�CNICA EN PROCESOS OPERATIVOS");

		// estado org
		$orgEstado = RevisarServiciosAnteriores($codOrg, $anio, $mesConsulta);
		array_push($resultadoConsulta, $orgEstado);

		// validacion
		$cedulaR = GetInformacionOrg($codOrg, "cedulaRepresentante");
		if($cedulaR == "" || $nRepresentanteOrg == "NO TIENE REPRESENTANTE LEGAL")
			array_push($resultadoConsulta, "INCORRECTO");
		else
		{
			array_push($resultadoConsulta, "CORRECTO");
		}

		// nombre representante legal
		if($nRepresentanteOrg == '' || $nRepresentanteOrg == "NO TIENE REPRESENTANTE LEGAL")
			array_push($resultadoConsulta, '');
		else
			array_push($resultadoConsulta, $nRepresentanteOrg);

		// cedula representante legal
		if($cedulaR == "" || $cedulaR <= 0)
			array_push($resultadoConsulta, "");
		else
			array_push($resultadoConsulta, $cedulaR);

		// etnia representante legal
		$etniaRepresentante = GetInfoRepresentanteLegal($cedulaR, $codOrg, "etnia");
		if($etniaRepresentante == '')
			array_push($resultadoConsulta, '');
		else
			array_push($resultadoConsulta, $etniaRepresentante);

		// genero representante legal
		$generoRepresentante = GetInfoRepresentanteLegal($cedulaR, $codOrg, "genero");
		if($generoRepresentante == '')
			array_push($resultadoConsulta, '');
		else
			array_push($resultadoConsulta, $generoRepresentante);




	}

	for($i = 0; $i < count($resultadoConsulta); $i = $i + 42)
	{
		$tableBody .= "<tr>
						<td>" . $resultadoConsulta[$i] . "</td>
						<td>" . $resultadoConsulta[$i + 1] . "</td>
						<td>" . $resultadoConsulta[$i + 2] . "</td>
						<td>" . $resultadoConsulta[$i + 3] . "</td>
						<td>" . $resultadoConsulta[$i + 4] . "</td>
						<td>" . $resultadoConsulta[$i + 5] . "</td>
						<td>" . $resultadoConsulta[$i + 6] . "</td>
						<td>" . $resultadoConsulta[$i + 7] . "</td>
						<td>" . $resultadoConsulta[$i + 8] . "</td>
						<td>" . $resultadoConsulta[$i + 9] . "</td>
						<td>" . $resultadoConsulta[$i + 10] . "</td>
						<td>" . $resultadoConsulta[$i + 11] . "</td>
						<td>" . $resultadoConsulta[$i + 12] . "</td>
						<td>" . $resultadoConsulta[$i + 13] . "</td>
						<td>" . $resultadoConsulta[$i + 14] . "</td>
						<td>" . $resultadoConsulta[$i + 15] . "</td>
						<td>" . $resultadoConsulta[$i + 16] . "</td>
						<td>" . $resultadoConsulta[$i + 17] . "</td>
						<td>" . $resultadoConsulta[$i + 18] . "</td>
						<td>" . $resultadoConsulta[$i + 19] . "</td>
						<td>" . $resultadoConsulta[$i + 20] . "</td>
						<td>" . $resultadoConsulta[$i + 21] . "</td>
						<td>" . $resultadoConsulta[$i + 22] . "</td>
						<td>" . $resultadoConsulta[$i + 23] . "</td>
						<td>" . $resultadoConsulta[$i + 24] . "</td>
						<td>" . $resultadoConsulta[$i + 25] . "</td>
						<td>" . $resultadoConsulta[$i + 26] . "</td>
						<td>" . $resultadoConsulta[$i + 27] . "</td>
						<td>" . $resultadoConsulta[$i + 28] . "</td>
						<td>" . $resultadoConsulta[$i + 29] . "</td>
						<td>" . $resultadoConsulta[$i + 30] . "</td>
						<td>" . $resultadoConsulta[$i + 31] . "</td>
						<td>" . $resultadoConsulta[$i + 32] . "</td>
						<td>" . $resultadoConsulta[$i + 33] . "</td>
						<td>" . $resultadoConsulta[$i + 34] . "</td>
						<td>" . $resultadoConsulta[$i + 35] . "</td>
						<td>" . $resultadoConsulta[$i + 36] . "</td>
						<td>" . $resultadoConsulta[$i + 37] . "</td>
						<td>" . $resultadoConsulta[$i + 38] . "</td>
						<td>" . $resultadoConsulta[$i + 39] . "</td>
						<td>" . $resultadoConsulta[$i + 40] . "</td>
						<td>" . $resultadoConsulta[$i + 41] . "</td>						
					</tr>";
	}


	return $tableBody;
}

function ReporteSociosGeneral()
{
	global $nombresMes;
	$anio = getAnio();
	$mesConsulta = getMes();
	$resultadoConsulta = array();
	$tableBody = "";
	$consultaReporte = "select * from fp_asesoria_asistencia_cofinanciamiento_socios
	where month(fecha_reporte_fp) = " . $mesConsulta . " and year(fecha_reporte_fp)=" . $anio . "
	order by cod_u_organizaciones";

	$resConsultaReporte = query($consultaReporte);


	while($fila = mysql_fetch_array($resConsultaReporte))
	{
		//echo $fila['cedula'] . "<br>";
		array_push($resultadoConsulta, $anio);
		array_push($resultadoConsulta, $nombresMes[$mesConsulta - 1]);

		
		$codRegistroFomento = $fila['cod_fp_asesoria_asistencia_cofinanciamiento'];
		$cedulaFomento = $fila['cedula'];
		$codSocio = $fila['cod_socios'];

		$sqlRegistroFomento = "select * from fp_asesoria_asistencia_cofinanciamiento where cod_asesoria_asistencia_cofinanciamiento = " . $codRegistroFomento . " and year(fecha_reporte) = " . $anio . " and month(fecha_reporte) = " . $mesConsulta;
		$resRegistroFomento = query($sqlRegistroFomento);
		$codProv = "";
		$zona = "";
		$codCanton = "";
		$codParroquia = "";
		$codOrg = "";
		$antiguedadOrg = "";
		$codServicioOrg = "";
		$descripcionServicio = "";
		$montonCofinanciamiento = "";
		$destinoFinanciamiento = "";
		$circuitoHabilitante = "";
		$sectorMatrizP = "";
		$actividadMatrizP = "";
		$descripcionBien = "";
		$numPersonasUrbanas = "";
		$numPersonasRurales = "";
		$ejecutadoOrg = "";
		while($filaRegistro = mysql_fetch_array($resRegistroFomento))
		{
			$zona = $filaRegistro['zona'];
			$codProv = $filaRegistro['cod_provincia'];
			$codCanton = $filaRegistro['cod_canton'];
			$codParroquia = $filaRegistro['cod_parroquia'];
			$codOrg = $filaRegistro['cod_u_organizaciones'];
			$antiguedadOrg = $filaRegistro['antiguedad'];
			$codServicioOrg = $filaRegistro['cod_servicio'];
			$descripcionServicio = $filaRegistro['descripcion'];
			$montonCofinanciamiento = $filaRegistro['monto_cofinanciamiento'];
			$destinoFinanciamiento = $filaRegistro['destino_financiamiento'];
			$circuitoHabilitante = $filaRegistro['circuito_habilitante'];
			$sectorMatrizP = $filaRegistro['categoria_actividad_mp'];
			$actividadMatrizP = $filaRegistro['identificacion_actividad_mp'];
			$descripcionBien = $filaRegistro['descripcion_bien_servicio'];
			$numPersonasUrbanas = $filaRegistro['num_per_urbanas'];
			$numPersonasRurales = $filaRegistro['num_per_rurales'];
			$ejecutadoOrg = $filaRegistro['documentacion_valida'];
		}
		
		$nombreProv = GetNombreProvincia($zona, $codProv);
		array_push($resultadoConsulta, "DTZ" . $zona);
		array_push($resultadoConsulta, $nombreProv);
		
		$canton = GetNombreCanton($codProv, $codCanton);
		array_push($resultadoConsulta, $canton);

		
		$nParroquia = GetNombreParroquia($codProv, $codCanton, $codParroquia);
		array_push($resultadoConsulta, $nParroquia); 

		
		$tipoOrg = GetInformacionOrg($codOrg, "tipoOrg");
		if($tipoOrg == 'org')
			array_push($resultadoConsulta, "ORGANIZACIÓN");
		else
			array_push($resultadoConsulta, "UNIDAD ECONÓMICA SOLIDARIA");

		$nOrg = GetInformacionOrg($codOrg, 'nombre');
		array_push($resultadoConsulta, $nOrg);

		//antiguedad
		if($antiguedadOrg == 'si')
			array_push($resultadoConsulta, "antigua");
		else
			array_push($resultadoConsulta, "nueva");
		

		// codigo emprendimiento 
		array_push($resultadoConsulta, '-');

		// ruc
		$rOrg = GetInformacionOrg($codOrg, 'ruc');
		array_push($resultadoConsulta, $rOrg);

		// nombre representante legal
		$nRepresentanteOrg = GetInformacionOrg($codOrg, 'representante');
		if($nRepresentanteOrg == '')
			array_push($resultadoConsulta, 'NO SE REGISTRA EN EL SIU');
		else
			array_push($resultadoConsulta, $nRepresentanteOrg);

		// telefono org
		$tOrg = GetInformacionOrg($codOrg, 'telefono');
		array_push($resultadoConsulta, $tOrg);

		//celular
		$cOrg = GetInformacionOrg($codOrg, 'celular');
		if($cOrg == '')
			array_push($resultadoConsulta, 'NO SE REGISTRA EN SIU');
		else
			array_push($resultadoConsulta, $cOrg);

		//mail
		$emailOrg = GetInformacionOrg($codOrg, 'email');
		if($emailOrg == '')
			array_push($resultadoConsulta, 'NO SE REGISTRA EN SIU');
		else
			array_push($resultadoConsulta, $emailOrg);

		// circuito economico
		$circuitoOrg = GetInformacionOrg($codOrg, 'circuito');
		array_push($resultadoConsulta, $circuitoOrg);

		// *********************************** 
		// Servicios
		// 1 - ASESORIAS PARA LA ELABORACI�N DE PLANES DE NEGOCIOS SOLIDARIOS
		// 2 - COFINANCIAMIENTO PARA PROYECTOS DE LA EPS
		// 3 - ASISTENCIA T�CNICA EN PROCESOS ADMINISTRATIVOS
		// 4 - ALIANZAS CON INSTITUCIONES PARA LA ASISTENCIA T�CNICA EN PROCESOS OPERATIVOS

		

		if($codServicioOrg == 1) 
		{
			array_push($resultadoConsulta, '1');
			array_push($resultadoConsulta, $descripcionServicio);
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
		}

		else if($codServicioOrg == 2) 
		{
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '1');
			array_push($resultadoConsulta, $descripcionServicio);
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
		}

		else if($codServicioOrg == 3) 
		{
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '1');
			array_push($resultadoConsulta, $descripcionServicio);
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
		}

		else if($codServicioOrg == 4) 
		{
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '0');
			array_push($resultadoConsulta, '-');
			array_push($resultadoConsulta, '1');
			array_push($resultadoConsulta, $descripcionServicio);
		}

		// fin servicios
		//*******************************

		// monto de cofinanciamiento
		
		array_push($resultadoConsulta, $montonCofinanciamiento);

		// destino del financiamiento
		
		if($destinoFinanciamiento == '')
			array_push($resultadoConsulta, '0');
		else
			array_push($resultadoConsulta, $destinoFinanciamiento);

		// circuito habilitante
		
		if($circuitoHabilitante == '')
			array_push($resultadoConsulta, '0');
		else
			array_push($resultadoConsulta, $circuitoHabilitante);

		// sector de la matriz productiva
		
		array_push($resultadoConsulta, $sectorMatrizP);

		// identificacion actividad matriz productiva
		
		array_push($resultadoConsulta, $actividadMatrizP);

		// descripcion del bien o servicio
		
		array_push($resultadoConsulta, $descripcionBien);

		// num personas urbanas
		
		array_push($resultadoConsulta, $numPersonasUrbanas);

		// num personas rurales
		
		array_push($resultadoConsulta, $numPersonasRurales);

		// total personas beneficiarias
		$totalPersonas = $numPersonasUrbanas + $numPersonasRurales;
		array_push($resultadoConsulta, $totalPersonas);

		// ejecutado
		
		array_push($resultadoConsulta, $ejecutadoOrg);

		// cedula
		array_push($resultadoConsulta, $cedulaFomento);

		// validacion
		array_push($resultadoConsulta, "");

		// informacion del socio
		$sqlSociosRegistrados = "select * from socios where cod_socios = " . $codSocio . " and cod_u_organizaciones = " . $codOrg . " limit 1";
		$resSociosRegistrados = query($sqlSociosRegistrados);
		$nombresSocio = "";
		$grupoEtnico = "";
		$generoSocio = "";
		while($filaSocios = mysql_fetch_array($resSociosRegistrados))
		{
			$nombresSocio = $filaSocios['apellidos'];
			$grupoEtnico = $filaSocios['grupo_etnico'];
			$generoSocio = $filaSocios['genero'];
		}

		// nombre del socio
		array_push($resultadoConsulta, $nombresSocio);

		// etnia
		array_push($resultadoConsulta, $grupoEtnico);

		//genero
		array_push($resultadoConsulta, $generoSocio);


		

		// estado org
		$orgEstado = RevisarServiciosAnteriores($codOrg, $anio, $mesConsulta);
		array_push($resultadoConsulta, $orgEstado);
	}

	//print_r2($resultadoConsulta);

	for($i = 0; $i < count($resultadoConsulta); $i = $i + 40)
	{
		$tableBody .= "<tr>
						<td>" . $resultadoConsulta[$i] . "</td>
						<td>" . $resultadoConsulta[$i + 1] . "</td>
						<td>" . $resultadoConsulta[$i + 2] . "</td>
						<td>" . $resultadoConsulta[$i + 3] . "</td>
						<td>" . $resultadoConsulta[$i + 4] . "</td>
						<td>" . $resultadoConsulta[$i + 5] . "</td>
						<td>" . $resultadoConsulta[$i + 6] . "</td>
						<td>" . $resultadoConsulta[$i + 7] . "</td>
						<td>" . $resultadoConsulta[$i + 8] . "</td>
						<td>" . $resultadoConsulta[$i + 9] . "</td>
						<td>" . $resultadoConsulta[$i + 10] . "</td>
						<td>" . $resultadoConsulta[$i + 11] . "</td>
						<td>" . $resultadoConsulta[$i + 12] . "</td>
						<td>" . $resultadoConsulta[$i + 13] . "</td>
						<td>" . $resultadoConsulta[$i + 14] . "</td>
						<td>" . $resultadoConsulta[$i + 15] . "</td>
						<td>" . $resultadoConsulta[$i + 16] . "</td>
						<td>" . $resultadoConsulta[$i + 17] . "</td>
						<td>" . $resultadoConsulta[$i + 18] . "</td>
						<td>" . $resultadoConsulta[$i + 19] . "</td>
						<td>" . $resultadoConsulta[$i + 20] . "</td>
						<td>" . $resultadoConsulta[$i + 21] . "</td>
						<td>" . $resultadoConsulta[$i + 22] . "</td>
						<td>" . $resultadoConsulta[$i + 23] . "</td>
						<td>" . $resultadoConsulta[$i + 24] . "</td>
						<td>" . $resultadoConsulta[$i + 25] . "</td>
						<td>" . $resultadoConsulta[$i + 26] . "</td>
						<td>" . $resultadoConsulta[$i + 27] . "</td>
						<td>" . $resultadoConsulta[$i + 28] . "</td>
						<td>" . $resultadoConsulta[$i + 29] . "</td>
						<td>" . $resultadoConsulta[$i + 30] . "</td>
						<td>" . $resultadoConsulta[$i + 31] . "</td>
						<td>" . $resultadoConsulta[$i + 32] . "</td>
						<td>" . $resultadoConsulta[$i + 33] . "</td>
						<td>" . $resultadoConsulta[$i + 34] . "</td>
						<td>" . $resultadoConsulta[$i + 35] . "</td>
						<td>" . $resultadoConsulta[$i + 36] . "</td>
						<td>" . $resultadoConsulta[$i + 37] . "</td>
						<td>" . $resultadoConsulta[$i + 38] . "</td>
						<td>" . $resultadoConsulta[$i + 39] . "</td>						
					</tr>";
	}


	return $tableBody;
}

function GetNombreProvincia($zona, $codigoProvincia)
{
	$sqlNombreProvincia = "select provincia from u_provincia where zona = " . $zona . " and cod_provincia = " . $codigoProvincia;
	$resSqlNombreProvincia = query($sqlNombreProvincia);
	$resNombreProvincia = '';
	//echo $sqlNombreProvincia . "<br>";
	while($filaProvincia = mysql_fetch_array($resSqlNombreProvincia))
	{
		$resNombreProvincia = $filaProvincia['provincia'];
	}
	return $resNombreProvincia;
}

function GetNombreCanton($codProvincia, $codCanton)
{
	$sqlNombreCanton = "select canton from u_canton where cod_provincia = " . $codProvincia ." and cod_canton= " . $codCanton;
	$resNombreCanton = query($sqlNombreCanton);
	$nombreCanton = "";

	while($filaCanton = mysql_fetch_array($resNombreCanton))
	{
		$nombreCanton = $filaCanton['canton'];
	}
	return $nombreCanton;
}

function GetNombreParroquia($codProvincia, $codCanton, $codParroquia)
{
	$sqlNombreParroquia = "select parroquia from u_parroquia where cod_provincia = " . $codProvincia ." and cod_canton= " . $codCanton . " and cod_parroquia = " . $codParroquia;
	$resNombreParroquia = query($sqlNombreParroquia);
	$nombreParroquia = "";

	while($filaParroquia = mysql_fetch_array($resNombreParroquia))
	{
		$nombreParroquia = $filaParroquia['parroquia'];
	}
	return $nombreParroquia;
}

function GetInfoRepresentanteLegal($cedula, $codOrg, $tipoInfo)
{
	$infoRepresenteante = "";
	if($tipoInfo == "genero")
	{
		$sqlInfoRepresentante = "select genero from socios where cedula = '" . $cedula . "' and cod_u_organizaciones = " . $codOrg . " limit 1";
		$resInfoRepresentante = query($sqlInfoRepresentante);
		while($filaRepresentante = mysql_fetch_array($resInfoRepresentante))
		{
			$infoRepresenteante = $filaRepresentante['genero'];
		}
	}
	if($tipoInfo == "etnia")
	{
		$sqlInfoRepresentante = "select grupo_etnico from socios where cedula = '" . $cedula . "' and cod_u_organizaciones = " . $codOrg . " limit 1";
		$resInfoRepresentante = query($sqlInfoRepresentante);
		while($filaRepresentante = mysql_fetch_array($resInfoRepresentante))
		{
			$infoRepresenteante = $filaRepresentante['grupo_etnico'];
		}
	}

	return $infoRepresenteante;
	
	
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

	if($tipoInfo == "representante")
	{
		$sqlInfoOrganizacion = "select nombre_representante_legal from u_organizaciones where cod_u_organizaciones = " . $codOrgConsultar;
		$resInfoOrganizacion = query($sqlInfoOrganizacion);

		while($row = mysql_fetch_array($resInfoOrganizacion))
		{
			
			$infoConsultada = $row['nombre_representante_legal'];
			
		}
	}
	
	if($tipoInfo == "telefono")
	{
		$sqlInfoOrganizacion = "select telefono from u_organizaciones where cod_u_organizaciones = " . $codOrgConsultar;
		$resInfoOrganizacion = query($sqlInfoOrganizacion);

		while($row = mysql_fetch_array($resInfoOrganizacion))
		{
			
			$infoConsultada = $row['telefono'];
			
		}
	}

	if($tipoInfo == "celular")
	{
		$sqlInfoOrganizacion = "select celular from u_organizaciones where cod_u_organizaciones = " . $codOrgConsultar;
		$resInfoOrganizacion = query($sqlInfoOrganizacion);

		while($row = mysql_fetch_array($resInfoOrganizacion))
		{
			
			$infoConsultada = $row['celular'];
			
		}
	}

	if($tipoInfo == "email")
	{
		$sqlInfoOrganizacion = "select email from u_organizaciones where cod_u_organizaciones = " . $codOrgConsultar;
		$resInfoOrganizacion = query($sqlInfoOrganizacion);

		while($row = mysql_fetch_array($resInfoOrganizacion))
		{
			
			$infoConsultada = $row['email'];
			
		}
	}

	if($tipoInfo == "circuito")
	{
		$sqlInfoOrganizacion = "select circuito_economico from u_organizaciones where cod_u_organizaciones = " . $codOrgConsultar;
		$resInfoOrganizacion = query($sqlInfoOrganizacion);

		while($row = mysql_fetch_array($resInfoOrganizacion))
		{
			
			$infoConsultada = $row['circuito_economico'];
			
		}
	}

	if($tipoInfo == "cedulaRepresentante")
	{
		$sqlInfoOrganizacion = "select cedula_representante_legal from u_organizaciones where cod_u_organizaciones = " . $codOrgConsultar;
		$resInfoOrganizacion = query($sqlInfoOrganizacion);

		while($row = mysql_fetch_array($resInfoOrganizacion))
		{
			
			$infoConsultada = $row['cedula_representante_legal'];
			
		}
	}

	return $infoConsultada;

}

function RevisarServiciosAnteriores($codOrganizacion, $anio, $mes)
{
	// Revisa si la organizacion tiene servicios registrados en meses anteriores

	$orgRepetida = 0;
	$sqlServiciosAnteriores = "select * from fp_asesoria_asistencia_cofinanciamiento where cod_u_organizaciones = " . $codOrganizacion . " and year(fecha_reporte) = " . $anio . " and month(fecha_reporte) < " . $mes;
	$resServiciosAnteriores = query($sqlServiciosAnteriores);
	$numFilasServiciosAnteriores = mysql_num_rows($resServiciosAnteriores);

	if($numFilasServiciosAnteriores > 0)
		$orgRepetida = "repetida";
	else
		$orgRepetida = " - ";

	return $orgRepetida;

}

function RevisarServiciosAnterioresSocios($codOrganizacion, $anio, $mes)
{
	// Revisa si la organizacion tiene servicios registrados en meses anteriores

	$orgRepetida = 0;
	$sqlServiciosAnteriores = "select * from fp_asesoria_asistencia_cofinanciamiento where cod_u_organizaciones = " . $codOrganizacion . " and year(fecha_reporte) = " . $anio . " and month(fecha_reporte) < " . $mes;
	$resServiciosAnteriores = query($sqlServiciosAnteriores);
	$numFilasServiciosAnteriores = mysql_num_rows($resServiciosAnteriores);

	if($numFilasServiciosAnteriores > 0)
		$orgRepetida = "repetida";
	else
		$orgRepetida = " - ";

	return $orgRepetida;

}

function print_r2($val)
{
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}
?>