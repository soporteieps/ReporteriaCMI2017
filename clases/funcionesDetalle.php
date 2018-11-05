<?php

/*******************
* variables
*******************/
$orgSocios = array();
$eventosAsistentes = array();

// solo para reporte de fortalecimiento
$tablaCapacitados = "<table>";
$tablaCapacitados .= "<tr>
						<th>INDICE</th>
						<th>NOMBRES</th>
						<th>CEDULA</th>
						<th>GENERO</th>
						<th>EDAD</th>
						<th>EVENTO</th>
						<th>TIPOEVENTO</th>
						<th>ORG / UEP</th>
					</tr>";
$indiceCap = 0;





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

function print_r2($val)
{
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}

function CrearDetalleIndicador()
{
	//BORRAR LUEGO, SOLO PARA FORTALECIMIENTO
	global $tablaCapacitados;


	//global $tabla;
	global $eventosAsistentes;
	$anioCurso = getAnioSeleccionado();
	$indicadorSel = getIndicador();
	$mesSel = getMes();
	$zonaSel = getZona();
	$lineasTabla = "";
	$tablaHeader = "";

	//echo $anioCurso . " - " . $indicadorSel . " - " . $mesSel. " - " . $zonaSel . "<br>";

	if($indicadorSel == 1)
	{
		$resIndicador = primer_indicador($mesSel, $zonaSel);
		//print_r2($resIndicador);

		if(count($resIndicador) > 0)
		{
			//provincias de las organizaciones
			$provOrg = RecuperarInfoOrg($resIndicador, 'provincia');
			//nombres de las organizaciones
			$nombresOrganizaciones = RecuperarInfoOrg($resIndicador, 'nombresOrg');
			// ruc de las organizaciones
			$rucProvisional = RecuperarInfoOrg($resIndicador, 'rucProvisionalOrg');
			$rucDefinitivo = RecuperarInfoOrg($resIndicador, 'rucDefinitivoOrg');
			//categoria Matriz productiva de las organizaciones
			$catMatrizProductivaOrg = RecuperarInfoOrg($resIndicador, 'categoriaMatriz');
			// numero de socios por cada organizacion
			$numSociosOrganizacion = NumSociosOrganizacion($resIndicador);
			// numero de personas Capacitadas
			$numPerCapacitadas = NumPersonasCapacitadas($resIndicador, $anioCurso, $mesSel, 'ORG', $zonaSel);
			//print_r2($eventosAsistentes);
			//Servicio Brindado por Fortalecimiento
			$servicioFortalecimiento = ServiciosBrindadosOrg($resIndicador, $anioCurso, $mesSel, 'ORG', $zonaSel);
			// identificacion actividad matriz productiva
			$actOrgMP = RecuperarInfoOrg($resIndicador, 'identificacionMatriz');
			//capacitados por Genero
			$capMujeres = NumCapacitadosGenero($resIndicador, $anioCurso, $mesSel, 'ORG', $zonaSel, 'mujer');
			$capHombres = NumCapacitadosGenero($resIndicador, $anioCurso, $mesSel, 'ORG', $zonaSel, 'hombre');

			// BORRAR LUEGO SOLO PARA FORTALECIMIENTO
			$tablaCapacitados .= "</table>";


			//print_r2($resIndicador);

			$tablaHeader = "<tr class='cabecera'>
								<th>INDICE</th>
								<th>MES REPORTE</th>
								<th>ZONA</th>
								<th>PROVINCIA</th>
								<th>ORGANIZACION</th>
								<th>RUC</th>
								<th>CATEGORIA ACTIVIDAD MATRIZ PRODUCTIVA</th>
								<th>IDENTIFICACION ACTIVIDAD MP</th>
								<th>NUMERO DE SOCIOS</th>
								<th>NUMERO DE CAPACITADOS TOTAL</th>
								<th>NUMERO DE CAPACITADOS MUJERES TOTAL</th>
								<th>NUMERO DE CAPACITADOS HOMBRES TOTAL</th>
								<th>CAMPO FORTALECIMIENTO</th>
								<th>CODIGO EVENTO</th>
							</tr>";
			
			$nomMes = GetNombreMes($mesSel);

			$lineasTabla = "";
			$cont = 0;
			$indice = 0;
			foreach($resIndicador as $valor)
			{

				
				$indice = $cont + 1;

				$lineasTabla .= "<tr>
									<td>" . $indice . "</td>
									<td>" . $nomMes . "</td>
									<td>" . $zonaSel . "</td>
									<td>" . $provOrg[$cont] . "</td>
									<td>" . $nombresOrganizaciones[$cont] . "</td>
									<td>" . $rucDefinitivo[$cont] . " - " . $rucProvisional[$cont] . "</td>
									<td>" . $catMatrizProductivaOrg[$cont] . "</td>
									<td>" . $actOrgMP[$cont] . "</td>
									<td>" . $numSociosOrganizacion[$cont] . "</td>
									<td>" . $numPerCapacitadas[$cont] . "</td>
									<td>" . $capMujeres[$cont] . "</td>
									<td>" . $capHombres[$cont] . "</td>
									<td>" . $servicioFortalecimiento[$cont] . "</td>
									<td>" . $eventosAsistentes[$cont] . "</td>
								</tr>";
				$cont++;
			}

			
		}
		else
		{
			$tabla .= "<tr>
						<td>ESTE INDICADOR TIENE 0 REGISTROS REPORTADOS</td>
					</tr>";
		}


		
	}
	if($indicadorSel == 2)
	{
		//print_r2($resIndicador);
		$resIndicador = segundo_indicador($mesSel,$zonaSel);
		//print_r2($resIndicador);
		if(count($resIndicador) > 0)
		{
			//provincias de las uep
			$provUep = RecuperarInfoOrg($resIndicador, 'provincia');
			//nombres de las uep
			$nombresUep = RecuperarInfoOrg($resIndicador, 'nombresOrg');
			// ruc de las uep
			$rucProvisional = RecuperarInfoOrg($resIndicador, 'rucProvisionalOrg');
			$rucDefinitivo = RecuperarInfoOrg($resIndicador, 'rucDefinitivoOrg');
			//categoria Matriz productiva de las uep
			$catMatrizProductivaOrg = RecuperarInfoOrg($resIndicador, 'categoriaMatriz');
			// numero de socios por cada organizacion
			$numSociosOrganizacion = NumSociosOrganizacion($resIndicador);
			// numero de personas Capacitadas
			$numPerCapacitadas = NumPersonasCapacitadas($resIndicador, $anioCurso, $mesSel, 'UEP', $zonaSel);
			//print_r2($eventosAsistentes);
			//Servicio Brindado por Fortalecimiento
			$servicioFortalecimiento = ServiciosBrindadosOrg($resIndicador, $anioCurso, $mesSel, 'UEP', $zonaSel);
			// identificacion actividad matriz productiva
			$actOrgMP = RecuperarInfoOrg($resIndicador, 'identificacionMatriz');
			//capacitados por Genero
			$capMujeres = NumCapacitadosGenero($resIndicador, $anioCurso, $mesSel, 'UEP', $zonaSel, 'mujer');
			$capHombres = NumCapacitadosGenero($resIndicador, $anioCurso, $mesSel, 'UEP', $zonaSel, 'hombre');


			// BORRAR LUEGO SOLO PARA FORTALECIMIENTO
			$tablaCapacitados .= "</table>";




			$tablaHeader = "<tr  class='cabecera'>
							<th>INDICE</th>
							<th>MES REPORTE</th>
							<th>ZONA</th>
							<th>PROVINCIA</th>
							<th>UEP</th>
							<th>RUC PROVISIONAL</th>
							<th>CATEGORIA ACTIVIDAD MATRIZ PRODUCTIVA</th>
							<th>IDENTIFICACION ACTIVIDAD MP</th>
							<th>NUMERO DE SOCIOS</th>
							<th>NUMERO DE CAPACITADOS TOTAL</th>
							<th>NUMERO DE CAPACITADOS MUJERES TOTAL</th>
							<th>NUMERO DE CAPACITADOS HOMBRES TOTAL</th>
							<th>CAMPO FORTALECIMIENTO</th>
							<th>CODIGO EVENTO</th>
						</tr>";

			
			$nomMes = GetNombreMes($mesSel);

			$lineasTabla = "";
			$cont = 0;
			$indice = 0;
			foreach($resIndicador as $valor)
			{

				
				$indice = $cont + 1;

				$lineasTabla .= "<tr>
									<td>" . $indice . "</td>
									<td>" . $nomMes . "</td>
									<td>" . $zonaSel . "</td>
									<td>" . $provUep[$cont] . "</td>
									<td>" . $nombresUep[$cont] . "</td>
									<td>" . $rucDefinitivo[$cont] . " - " . $rucProvisional[$cont] . "</td>
									<td>" . $catMatrizProductivaOrg[$cont] . "</td>
									<td>" . $actOrgMP[$cont] . "</td>
									<td>" . $numSociosOrganizacion[$cont] . "</td>
									<td>" . $numPerCapacitadas[$cont] . "</td>
									<td>" . $capMujeres[$cont] . "</td>
									<td>" . $capHombres[$cont] . "</td>
									<td>" . $servicioFortalecimiento[$cont] . "</td>
									<td>" . $eventosAsistentes[$cont] . "</td>
								</tr>";
				$cont++;
			}

			
		}
		else
		{
			$tabla .= "<tr>
						<td>ESTE INDICADOR TIENE 0 REGISTROS REPORTADOS</td>
					</tr>";
		}

	}

	if($indicadorSel == 3)
	{
		$resIndicador = tercer_indicador($mesSel,$zonaSel);
		//print_r2($resIndicador);			

		if(count($resIndicador) > 0)
		{
			//provincias de las organizaciones
			$provOrg = RecuperarInfoOrg($resIndicador, 'provincia');
			//nombres de las organizaciones
			$nombresOrganizaciones = RecuperarInfoOrg($resIndicador, 'nombresOrg');
			// ruc de las organizaciones
			$rucProvisional = RecuperarInfoOrg($resIndicador, 'rucProvisionalOrg');
			$rucDefinitivo = RecuperarInfoOrg($resIndicador, 'rucDefinitivoOrg');
			// actividad de la organizacion
			$actividadOrg = RecuperarInfoOrg($resIndicador, 'identificacionMatriz');
			//categoria Matriz productiva de las organizaciones
			$catMatrizProductivaOrg = RecuperarInfoOrg($resIndicador, 'categoriaMatriz');
			// numero de socios por cada organizacion
			$numSociosOrganizacion = NumSociosOrganizacion($resIndicador);			
			//Servicio Brindado por Fortalecimiento
			$servicioFortalecimiento = ServiciosBrindadosOrg($resIndicador, $anioCurso, $mesSel, 'ORG', $zonaSel);
			//print_r2($resIndicador);
			// identificacion actividad matriz productiva
			$actOrgMP = RecuperarInfoOrg($resIndicador, 'identificacionMatriz');
			//Asistentes al circuito
			$asistentesCircuito = GetAsistentesCircuitosEconomicos($resIndicador, $anioCurso, $mesSel, $zonaSel);


			// BORRAR LUEGO SOLO PARA FORTALECIMIENTO
			$tablaCapacitados .= "</table>";


			$tablaHeader = "<tr class='cabecera'>
								<th>INDICE</th>
								<th>MES</th>
								<th>ZONA</th>									
								<th>PROVINCIA</th>
								<th>RUC</th>
								<th>ORGANIZACION</th>
								<th>ACTIVIDAD</th>
								<th>CATEGORIA ACTIVIDAD MATRIZ PRODUCTIVA</th>
								<th>IDENTIFICACION ACTIVIDAD MP</th>									
								<th>CAMPO FORTALECIMIENTO</th>
								<th>NUMERO DE ASISTENTES</th>
								<th>NUMERO DE SOCIOS</th>
							</tr>";
			

			$nomMes = GetNombreMes($mesSel);

			$lineasTabla = "";
			$cont = 0;
			$indice = 0;
			foreach($resIndicador as $valor)
			{

				
				$indice = $cont + 1;

				$lineasTabla .= "<tr>
									<td>" . $indice . "</td>
									<td>" . $nomMes . "</td>
									<td>" . $zonaSel . "</td>
									<td>" . $provOrg[$cont] . "</td>
									<td>" . $rucDefinitivo[$cont] . " - " . $rucProvisional[$cont] . "</td>
									<td>" . $nombresOrganizaciones[$cont] . "</td>
									<td>" . $actividadOrg[$cont] . "</td>
									<td>" . $catMatrizProductivaOrg[$cont] . "</td>
									<td>" . $actOrgMP[$cont] . "</td>
									<td>" . $servicioFortalecimiento[$cont] . "</td>
									<td>" . $asistentesCircuito[$cont] . "</td>
									<td>" . $numSociosOrganizacion[$cont] . "</td>					
								</tr>";
				$cont++;
			}

			
		}
		else
		{
			$tabla .= "<tr>
						<td>ESTE INDICADOR TIENE 0 REGISTROS REPORTADOS</td>
					</tr>";
		}
	}

	if($indicadorSel == 4)
	{
		global $orgSocios;
		$resIndicador = cuarto_indicador($mesSel, $zonaSel);
		$provNombre = "";
		$rucSocio = "";
		$cedulaSocio = "";
		$apellidosSocio = "";
		$orgSocio = "";
		$actividadOrgSocio = "";
		$categoriaOrgSocio = "";
		$identificacionCategoriaOrgSocio = "";
		$campoFortalecimiento = "";
		$generoSocio = "";
		$poblacionSocio = "";
		$grupoEtnicoSocio = "";


		//print_r2($resIndicador);
		//print_r2($orgSocios);

		if(count($resIndicador) > 0)
		{
			$provNombre = "";
			
			$nomMes = GetNombreMes($mesSel);
			$tablaHeader = "<tr class='cabecera'>
								<th>INDICE</th>
								<th>MES</th>
								<th>ZONA</th>									
								<th>PROVINCIA</th>
								<th>RUC</th>
								<th>CEDULA</th>
								<th>APELLIDOS Y NOMBRES</th>
								<th>GENERO</th>
								<th>POBLACION</th>
								<th>GRUPO ETNICO</th>
								<th>ORGANIZACION</th>
								<th>ACTIVIDAD</th>
								<th>CATEGORIA ACTIVIDAD MATRIZ PRODUCTIVA</th>
								<th>IDENTIFICACION ACTIVIDAD MP</th>									
								<th>CAMPO FORTALECIMIENTO</th>									
							</tr>";
			

			$lineasTabla = "";
			$cont = 0;
			$indice = 0;

			foreach($resIndicador as $valor)
			{					
				$rucSocio = "";
				$cedulaSocio = "";
				$apellidosSocio = "";
				$orgSocio = "";
				$actividadOrgSocio = "";
				$categoriaOrgSocio = "";
				$identificacionCategoriaOrgSocio = "";
				$campoFortalecimiento = "";
				$generoSocio = "";
				$poblacionSocio = "";
				$grupoEtnicoSocio = "";

				$sqlOrgSocios = "select cod_u_organizaciones from socios where cedula = '" . $valor . "' and estado = 1 group by cod_u_organizaciones";

				$resSqlOrgSocios = query($sqlOrgSocios);
				$numRegistros = mysql_num_rows($resSqlOrgSocios);
				//echo  $sqlOrgSocios . "<br>";
				//echo  $cont . " " . $numRegistros . "<br>";

				if($numRegistros > 1)
				{
					// El socio existe en mas de una organizacion, por lo cual se debe de tomar los cod_u_organizaciones
					$codOrgSocio = array();
					$codOrgReportada = array();
					while($fila = mysql_fetch_array($resSqlOrgSocios))
					{
						array_push($codOrgSocio, $fila['cod_u_organizaciones']);
					}



					// Se busca las organizaciones que han sido reportadas en el mes
					foreach($codOrgSocio as $codigoOrg)
					{
						if(in_array($codigoOrg, $orgSocios))
						{
							//si el codigo de organizacion se encuentra reportada se guarda en codOrgReportada
							array_push($codOrgReportada, $codigoOrg);
						}
					}

					//print_r2($codOrgReportada);

					// Se completa la informacion correspondiente
					$sqlNombresSocios = "select apellidos, cedula, zona, cod_provincia, cod_canton, cod_parroquia, genero, grupo_etnico, poblacion, fecha_nacimiento, discapacidad, tipo_discapacidad, fecha_reporte from socios where cedula = '" . $valor . "' group by cedula";

					$resSqlSocios = query($sqlNombresSocios);
					while($fila = mysql_fetch_array($resSqlSocios))
					{
						//echo $fila['cod_provincia'] . "  $indice<br>";
						$provNombre = GetNombreProvincia($zonaSel, $fila['cod_provincia']);
						$cedulaSocio = $fila['cedula'];
						$apellidosSocio = $fila['apellidos'];
						$generoSocio = $fila['genero'];
						if($generoSocio == '') $generoSocio = "No registrado";
						$poblacionSocio = $fila['poblacion'];
						if($poblacionSocio == '') $poblacionSocio = "No registrado";
						$grupoEtnicoSocio = $fila['grupo_etnico'];
						if($grupoEtnicoSocio == '') $grupoEtnicoSocio = "No registrado";

						$aux = 0;
						foreach($codOrgReportada as $codigoOrg)
						{
							$sqlRucOrgSocio = "select ruc_definitivo, ruc_provisional, organizacion, actividad, categoria_actividad_mp, identificacion_actividad_mp from u_organizaciones where cod_u_organizaciones = " . $codigoOrg;
							
							$resSqlRucOrgSocio = query($sqlRucOrgSocio);
							
							while($fila1 = mysql_fetch_array($resSqlRucOrgSocio))
							{
								if($aux == 0)
								{
									$rucSocio = $fila1['ruc_definitivo'] . " - " . $fila1['ruc_provisional'];
									$orgSocio = $fila1['organizacion'];
									$actividadOrgSocio = $fila1['actividad'];
									$categoriaOrgSocio = $fila1['categoria_actividad_mp'];
									$identificacionCategoriaOrgSocio = $fila1['identificacion_actividad_mp'];
								}
								else
								{
									$rucSocio .= " - " . $fila1['ruc_definitivo'] . " - " . $fila1['ruc_provisional'];
									$orgSocio .= " - " . $fila1['organizacion'];
									$actividadOrgSocio .= " - " . $fila1['actividad'];
									$categoriaOrgSocio .= " - " . $fila1['categoria_actividad_mp'];
									$identificacionCategoriaOrgSocio .= " - " . $fila1['identificacion_actividad_mp'];
								}
								
								
							}

							$sqlFortalecimiento = "select e.campo_fortalecimiento, e.cod_evento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento) where ev.cod_u_organizaciones = " . $codigoOrg . " and month(e.fecha_reporte) = " . $mesSel . " and e.anio = " . $anioCurso . " group by e.campo_fortalecimiento";
							//echo $sqlFortalecimiento . "<br>";
							$resFortalecimiento = query($sqlFortalecimiento);
							$aux1 = 0;
							if(mysql_num_rows($resFortalecimiento) > 0)
							{
								while($fila1 = mysql_fetch_array($resFortalecimiento))
								{
									//se tiene que revisar si hay mas de un evento relacionado con esta org
									if($aux1 == 0) $campoFortalecimiento .= $fila1['campo_fortalecimiento'];
									else $campoFortalecimiento .= " - " . $fila1['campo_fortalecimiento'];
									$aux1++;
								}

								
							}
							else
							{
								$sqlFortalecimiento = "select  e.cod_asistencia_legal from  asistencia_legal_org e where e.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and month(e.fecha_reporte) = " . $mesSel . " and e.anio = " . $anioCurso . " group by e.cod_asistencia_legal";
								//echo $sqlFortalecimiento . "<br>";
								$resFortalecimiento = query($sqlFortalecimiento);
								if(mysql_num_rows($resFortalecimiento) > 0)
								{
									$campoFortalecimiento = "asistencia_legal";
								}
							}
							$aux++;						


						}
						
					}



				}
				if($numRegistros == 1)
				{
					$sqlNombresSocios = "select apellidos, cedula, zona, cod_provincia, cod_canton, cod_parroquia, genero, grupo_etnico, poblacion, fecha_nacimiento, discapacidad, tipo_discapacidad, fecha_reporte , cod_u_organizaciones from socios where cedula = '" . $valor . "' order by cod_u_organizaciones";

					$resSqlSocios = query($sqlNombresSocios);
					while($fila = mysql_fetch_array($resSqlSocios))
					{
						//echo $fila['cod_provincia'] . "  $indice - $zonaSel<br>";
						$provNombre = GetNombreProvincia($zonaSel, $fila['cod_provincia']);
						$cedulaSocio = $fila['cedula'];
						$apellidosSocio = $fila['apellidos'];
						$generoSocio = $fila['genero'];
						if($generoSocio == '') $generoSocio = "No registrado";
						$poblacionSocio = $fila['poblacion'];
						if($poblacionSocio == '') $poblacionSocio = "No registrado";
						$grupoEtnicoSocio = $fila['grupo_etnico'];
						if($grupoEtnicoSocio == '') $grupoEtnicoSocio = "No registrado";

						$sqlRucOrgSocio = "select ruc_definitivo, ruc_provisional, organizacion, actividad, categoria_actividad_mp, identificacion_actividad_mp from u_organizaciones where cod_u_organizaciones = " . $fila['cod_u_organizaciones'];
						//echo $sqlRucOrgSocio . "<br>";
						$resSqlRucOrgSocio = query($sqlRucOrgSocio);
						while($fila1 = mysql_fetch_array($resSqlRucOrgSocio))
						{
							$rucSocio = $fila1['ruc_definitivo'] . " - " . $fila1['ruc_provisional'];
							$orgSocio = $fila1['organizacion'];
							$actividadOrgSocio = $fila1['actividad'];
							$categoriaOrgSocio = $fila1['categoria_actividad_mp'];
							$identificacionCategoriaOrgSocio = $fila1['identificacion_actividad_mp'];
						} 

						$sqlFortalecimiento = "select e.campo_fortalecimiento, e.cod_evento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento) where ev.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and month(e.fecha_reporte) = " . $mesSel . " and e.anio = " . $anioCurso . " group by e.campo_fortalecimiento";
						//echo $sqlFortalecimiento . "<br>";
						$resFortalecimiento = query($sqlFortalecimiento);
						$aux = 0;
						if(mysql_num_rows($resFortalecimiento) > 0)
						{
							while($fila1 = mysql_fetch_array($resFortalecimiento))
							{
								//se tiene que revisar si hay mas de un evento relacionado con esta org
								if($aux == 0) $campoFortalecimiento .= $fila1['campo_fortalecimiento'];
								else $campoFortalecimiento .= " - " . $fila1['campo_fortalecimiento'];
								
							}
						}
						else
						{
							$sqlFortalecimiento = "select  e.cod_asistencia_legal from  asistencia_legal_org e where e.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and month(e.fecha_reporte) = " . $mesSel . " and e.anio = " . $anioCurso . " group by e.cod_asistencia_legal";
							//echo $sqlFortalecimiento . "<br>";
							$resFortalecimiento = query($sqlFortalecimiento);
							if(mysql_num_rows($resFortalecimiento) > 0)
							{
								$campoFortalecimiento = "asistencia_legal";
							}
						}
						$aux++;
						
					}
				}

				$indice = $cont + 1;

				$lineasTabla .= "<tr>
									<td>" . $indice . "</td>
									<td>" . $nomMes . "</td>
									<td>" . $zonaSel . "</td>
									<td>" . $provNombre . "</td>
									<td>" . $rucSocio . "</td>
									<td>" . $cedulaSocio . "</td>
									<td>" . $apellidosSocio . "</td>
									<td>" . $generoSocio . "</td>
									<td>" . $poblacionSocio . "</td>
									<td>" . $grupoEtnicoSocio . "</td>
									<td>" . $orgSocio . "</td>
									<td>" . $actividadOrgSocio . "</td>
									<td>" . $categoriaOrgSocio . "</td>
									<td>" . $identificacionCategoriaOrgSocio . "</td>
									<td>" . $campoFortalecimiento . "</td>					
								</tr>";
				$cont++;				
					
			}
			
		}
		else
		{
			$tabla .= "<tr>
						<td>ESTE INDICADOR TIENE 0 REGISTROS REPORTADOS</td>
					</tr>";
		}

		
	}

	if($indicadorSel == 5)
	{
		$resIndicador = quinto_indicador($mesSel,$zonaSel);
		//print_r2($resIndicador);

		$numRegistros = count($resIndicador);
		if($numRegistros > 0)
		{
			$tablaHeader = "<tr class='cabecera'>
								<th>INDICE</th>
								<th>MES</th>
								<th>ZONA</th>									
								<th>PROVINCIA</th>									
								<th>ORGANIZACION</th>
								<th>RUC</th>
								<th>CATEGORIA ACTIVIDAD MATRIZ PRODUCTIVA</th>
								<th>IDENTIFICACION ACTIVIDAD MATRIZ PRODUCTIVA</th>
								<th>NUMERO DE HORAS DE CAPACITACION</th>										
								<th>CAMPO FORTALECIMIENTO</th>
								<th>EVENTO</th>
							</tr>";
			

			$nomMes = GetNombreMes($mesSel);

			$lineasTabla = "";
			$cont = 0;
			$indice = 0;

			for($i = 0; $i < count($resIndicador); $i = $i + 2)
			{
				$orgEvento = array();
				$orgFortalecimiento = array();
				$sqlOrgEventos = "select ev.cod_u_organizaciones, e.campo_fortalecimiento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento) where ev.anio = " . $anioCurso . " and ev.cod_evento = '" . $resIndicador[$i] . "' group by ev.cod_u_organizaciones";
				//echo $sqlOrgEventos . "<br>";
				$resOrgEventos = query($sqlOrgEventos);

				if(mysql_num_rows($resOrgEventos) > 0)
				{
					while($fila = mysql_fetch_array($resOrgEventos))
					{
						array_push($orgEvento, $fila['cod_u_organizaciones']);
						array_push($orgFortalecimiento, $fila['campo_fortalecimiento']);
					}

					$cont1 = 0;					
					foreach($orgEvento as $valor)
					{

						$sqlOrganizacion = "select cod_provincia, organizacion, ruc_definitivo, ruc_provisional, categoria_actividad_mp, identificacion_actividad_mp from u_organizaciones where cod_u_organizaciones = " . $valor;
						$resOrganizacion = query($sqlOrganizacion);
						$provOrg = "";
						$nombreOrg = "";
						$catMatrizProductivaOrg = "";
						$actividadOrg = "";
						while($fila = mysql_fetch_array($resOrganizacion))
						{
							$provOrg = GetNombreProvincia($zonaSel, $fila['cod_provincia']);
							$nombreOrg = $fila['organizacion'];
							$rucDefinitivo = $fila['ruc_definitivo'] . " - " . $fila['ruc_provisional'];
							$catMatrizProductivaOrg = $fila['categoria_actividad_mp'];
							$actividadOrg = $fila['identificacion_actividad_mp'];

						}

						
						$indice = $cont + 1;

						$lineasTabla .= "<tr>
											<td>" . $indice . "</td>
											<td>" . $nomMes . "</td>
											<td>" . $zonaSel . "</td>
											<td>" . $provOrg . "</td>
											<td>" . $nombreOrg . "</td>
											<td>" . $rucDefinitivo . "</td>
											<td>" . $catMatrizProductivaOrg . "</td>
											<td>" . $actividadOrg . "</td>											
											<td>" . $resIndicador[$i + 1] . "</td>
											<td>" . $orgFortalecimiento[$cont1] . "</td>
											<td>" . $resIndicador[$i] . "</td>											
										</tr>";
						$cont++;
						$cont1++;
					}
				}
				else
				{
					$indice = $cont + 1;

					$lineasTabla .= "<tr>
										<td>" . $indice . "</td>
										<td>" . $nomMes . "</td>
										<td>" . $zonaSel . "</td>
										<td> - </td>
										<td>NO EXISTEN ORGANIZACIONES REGISTRADAS</td>
										<td> - </td>
										<td> - </td>
										<td> - </td>											
										<td>" . $resIndicador[$i + 1] . "</td>
										<td> - </td>
										<td>" . $resIndicador[$i] . "</td>											
									</tr>";
					$cont++;
					
				}
				
			}

			
		}
		else
		{
			$tabla .= "<tr>
						<td>ESTE INDICADOR TIENE 0 REGISTROS REPORTADOS</td>
					</tr>";
		}		

		

	}

	if($indicadorSel == 6)
	{
		$resIndicador = sexto_indicador($mesSel, $zonaSel);
		//print_r2($resIndicador);
		$numRegistros = count($resIndicador);
		$nomMes = GetNombreMes($mesSel);

		// si hay registros se debe crear la tabla de detalle
		if($numRegistros > 0)
		{
			// armado del header de la tabla
			$tablaHeader = "<tr class='cabecera'>
								<th>INDICE</th>
								<th>MES</th>
								<th>ZONA</th>									
								<th>PROVINCIA</th>
								<th>CEDULA</th>
								<th>APELLIDOS Y NOMBRES</th>
								<th>GRUPO ETNICO</th>
								<th>GENERO</th>
								<th>POBLACION</th>
								<th>CODIGO DIALOGO SOCIAL</th>
							</tr>";
			

			//tengo el array con codigos del dialgo social devuelto por el indicador
			$cont = 0;
			$lineasTabla = "";			
			foreach($resIndicador as $valor)
			{
				// debe buscar la informacion del dialogo social
				$sqlDetalleDialogo = "select  cod_provincia, cedula, nombres, apellidos, grupo_etnico, poblacion, genero from asistentes where cod_evento = '" . $valor . "' and anio = " . $anioCurso . " group by cedula";
				//echo $sqlDetalleDialogo . "<br>";
				$resDetalleDialogo = query($sqlDetalleDialogo);
									
				
				while($fila = mysql_fetch_array($resDetalleDialogo))
				{
					$indice = $cont + 1;
					$provOrg = GetNombreProvincia($zonaSel, $fila['cod_provincia']);
					$cedulaA = $fila['cedula'];
					$apellidosNombres = $fila['apellidos'];
					$grupoEtnico = $fila['grupo_etnico'];
					$generoA = $fila['genero'];
					$poblacionA = $fila['poblacion'];

					$lineasTabla .= "<tr>
										<td>" . $indice . "</td>
										<td>" . $nomMes . "</td>
										<td>" . $zonaSel . "</td>
										<td>" . $provOrg . "</td>
										<td>" . $cedulaA . "</td>
										<td>" . $apellidosNombres . "</td>
										<td>" . $grupoEtnico . "</td>
										<td>" . $generoA . "</td>
										<td>" . $poblacionA . "</td>
										<td>" . $valor . "</td>																
									</tr>";
					$cont++;
				}

			}

			

		}
		else
		{
			// si no existe registros lo hacemos saber al usuario
			$tabla .= "<tr>
						<td>ESTE INDICADOR TIENE 0 REGISTROS REPORTADOS</td>
					</tr>";
		}

		
		

	}

	if($indicadorSel == 7)
	{
		$resIndicador = septimo_indicador($mesSel, $zonaSel);
		//print_r2($resIndicador);

		// si el indicador regresa datos comenzamos a armar la tabla de detalle
		if(count($resIndicador) > 0)
		{
			// armado del header de la tabla
			$tablaHeader = "<tr class='cabecera'>
								<th>INDICE</th>
								<th>MES</th>
								<th>ZONA</th>									
								<th>PROVINCIA</th>
								<th>CEDULA</th>
								<th>APELLIDOS Y NOMBRES</th>
								<th>GRUPO ETNICO</th>
								<th>GENERO</th>
								<th>POBLACION</th>
							</tr>";
			
			$cont = 0;
			$lineasTabla = "";
			$nomMes = GetNombreMes($mesSel);
			foreach($resIndicador as $valor)
			{
				// consulto el detalle de los asistentes a eps
				$sqlAsistentes = "select cod_provincia, apellidos, grupo_etnico, genero, poblacion from asistentes where tipo_evento = 'EPS' and zona=" . $zonaSel . " and month(fecha_reporte) = " . $mesSel . " and year(fecha_reporte) =" . $anioCurso . " and anio =" . $anioCurso . " and cedula = '" . $valor . "'";
				$resAsistentes = query($sqlAsistentes);
				while($fila = mysql_fetch_array($resAsistentes))
				{
					$provOrg = GetNombreProvincia($zonaSel, $fila['cod_provincia']);
					$apellidosNombres = $fila['apellidos'];
					$grupoEtnico = $fila['grupo_etnico'];
					$generoA = $fila['genero'];
					$poblacionA = $fila['poblacion'];

				}

				$indice = $cont + 1;


				$lineasTabla .= "<tr>
									<td>" . $indice . "</td>
									<td>" . $nomMes . "</td>
									<td>" . $zonaSel . "</td>
									<td>" . $provOrg . "</td>
									<td>" . $valor . "</td>
									<td>" . $apellidosNombres . "</td>
									<td>" . $grupoEtnico . "</td>
									<td>" . $generoA . "</td>
									<td>" . $poblacionA . "</td>																
								</tr>";
				$cont++;

			}

			
		}
		else
		{
			// si no hay registros
			$tabla .= "<tr>
						<td>ESTE INDICADOR TIENE 0 REGISTROS REPORTADOS</td>
					</tr>";
		}
	}

	if($indicadorSel == 8)
	{
		$resIndicador = octavo_indicador($mesSel, $zonaSel);

		if(count($resIndicador) > 0)
		{
			//provincias de las organizaciones
			$provOrg = RecuperarInfoOrg($resIndicador, 'provincia');
			//nombres de las organizaciones
			$nombresOrganizaciones = RecuperarInfoOrg($resIndicador, 'nombresOrg');
			// ruc de las organizaciones
			$rucProvisional = RecuperarInfoOrg($resIndicador, 'rucProvisionalOrg');
			$rucDefinitivo = RecuperarInfoOrg($resIndicador, 'rucDefinitivoOrg');
			//categoria Matriz productiva de las organizaciones
			$catMatrizProductivaOrg = RecuperarInfoOrg($resIndicador, 'categoriaMatriz');
			// numero de socios por cada organizacion
			$numSociosOrganizacion = NumSociosOrganizacion($resIndicador);
			// numero de personas Capacitadas
			$numPerCapacitadas = NumPersonasCapacitadas($resIndicador, $anioCurso, $mesSel, 'ORG', $zonaSel);
			//print_r2($eventosAsistentes);
			//Servicio Brindado por Fortalecimiento
			$servicioFortalecimiento = ServiciosBrindadosOrg($resIndicador, $anioCurso, $mesSel, 'ORG', $zonaSel);
			//print_r2($resIndicador);
			// identificacion actividad matriz productiva
			$actOrgMP = RecuperarInfoOrg($resIndicador, 'identificacionMatriz');
			//capacitados por Genero
			$capMujeres = NumCapacitadosGenero($resIndicador, $anioCurso, $mesSel, 'ORG', $zonaSel, 'mujer');
			$capHombres = NumCapacitadosGenero($resIndicador, $anioCurso, $mesSel, 'ORG', $zonaSel, 'hombre');


			// BORRAR LUEGO SOLO PARA FORTALECIMIENTO
			$tablaCapacitados .= "</table>";

			$tablaHeader = "<tr class='cabecera'>
								<th>INDICE</th>
								<th>MES REPORTE</th>
								<th>ZONA</th>
								<th>PROVINCIA</th>
								<th>ORGANIZACION</th>
								<th>RUC</th>
								<th>CATEGORIA ACTIVIDAD MATRIZ PRODUCTIVA</th>
								<th>IDENTIFICACION ACTIVIDAD MP</th>
								<th>NUMERO DE SOCIOS</th>
								<th>NUMERO DE CAPACITADOS</th>
								<th>NUMERO DE CAPACITADOS MUJERES</th>
								<th>NUMERO DE CAPACITADOS HOMBRES</th>
								<th>CAMPO FORTALECIMIENTO</th>
								<th>CODIGO EVENTO</th>
							</tr>";
			
			$nomMes = GetNombreMes($mesSel);

			$lineasTabla = "";
			$cont = 0;
			$indice = 0;
			foreach($resIndicador as $valor)
			{

				
				$indice = $cont + 1;

				$lineasTabla .= "<tr>
									<td>" . $indice . "</td>
									<td>" . $nomMes . "</td>
									<td>" . $zonaSel . "</td>
									<td>" . $provOrg[$cont] . "</td>
									<td>" . $nombresOrganizaciones[$cont] . "</td>
									<td>" . $rucDefinitivo[$cont] . " - " . $rucProvisional[$cont] . "</td>
									<td>" . $catMatrizProductivaOrg[$cont] . "</td>
									<td>" . $actOrgMP[$cont] . "</td>
									<td>" . $numSociosOrganizacion[$cont] . "</td>
									<td>" . $numPerCapacitadas[$cont] . "</td>
									<td>" . $capMujeres[$cont] . "</td>
									<td>" . $capHombres[$cont] . "</td>
									<td>" . $servicioFortalecimiento[$cont] . "</td>
									<td>" . $eventosAsistentes[$cont] . "</td>
								</tr>";
				$cont++;
			}

			
		}
		else
		{
			$tabla .= "<tr>
						<td>ESTE INDICADOR TIENE 0 REGISTROS REPORTADOS</td>
					</tr>";
		}
	}

	if($indicadorSel == 9)
	{
		$resIndicador = noveno_indicador($mesSel, $zonaSel);
		//print_r2($resIndicador);
		//global $orgSocios;

		$provNombre = "";
		$rucSocio = "";
		$cedulaSocio = "";
		$apellidosSocio = "";
		$orgSocio = "";
		$actividadOrgSocio = "";
		$categoriaOrgSocio = "";
		$identificacionCategoriaOrgSocio = "";
		$campoFortalecimiento = "";
		$generoSocio = "";
		$poblacionSocio = "";
		$grupoEtnicoSocio = "";

		//print_r2($resIndicador);
		//print_r2($orgSocios);

		if(count($resIndicador) > 0)
		{
			$provNombre = "";
			
			$nomMes = GetNombreMes($mesSel);
			$tablaHeader = "<tr class='cabecera'>
								<th>INDICE</th>
								<th>MES</th>
								<th>ZONA</th>									
								<th>PROVINCIA</th>
								<th>RUC</th>
								<th>CEDULA</th>
								<th>APELLIDOS Y NOMBRES</th>
								<th>GENERO</th>
								<th>GRUPO ETNICO</th>
								<th>POBLACION</th>
								<th>ORGANIZACION</th>
								<th>ACTIVIDAD</th>
								<th>CATEGORIA ACTIVIDAD MATRIZ PRODUCTIVA</th>
								<th>IDENTIFICACION ACTIVIDAD MP</th>									
								<th>CAMPO FORTALECIMIENTO</th>									
							</tr>";
			

			$lineasTabla = "";
			$cont = 0;
			$indice = 0;

			foreach($resIndicador as $valor)
			{					
				$rucSocio = "";
				$cedulaSocio = "";
				$apellidosSocio = "";
				$orgSocio = "";
				$actividadOrgSocio = "";
				$categoriaOrgSocio = "";
				$identificacionCategoriaOrgSocio = "";
				$campoFortalecimiento = "";
				$generoSocio = "";
				$poblacionSocio = "";
				$grupoEtnicoSocio = "";

				$sqlOrgSocios = "select cod_u_organizaciones from socios where cedula = '" . $valor . "' group by cod_u_organizaciones";

				$resSqlOrgSocios = query($sqlOrgSocios);
				$numRegistros = mysql_num_rows($resSqlOrgSocios);
				//echo $numRegistros . "<br>";

				if($numRegistros > 1)
				{
					// El socio existe en mas de una organizacion, por lo cual se debe de tomar los cod_u_organizaciones
					$codOrgSocio = array();
					$codOrgReportada = array();
					while($fila = mysql_fetch_array($resSqlOrgSocios))
					{
						array_push($codOrgSocio, $fila['cod_u_organizaciones']);
					}

					// Se busca las organizaciones que han sido reportadas en el mes
					/*foreach($codOrgSocio as $codigoOrg)
					{
						if(in_array($codigoOrg, $orgSocios))
						{
							//si el codigo de organizacion se encuentra reportada se guarda en codOrgReportada
							array_push($codOrgReportada, $codigoOrg);
						}
					}*/

					// Se completa la informacion correspondiente
					$sqlNombresSocios = "select apellidos, cedula, zona, cod_provincia, cod_canton, cod_parroquia, genero, grupo_etnico, poblacion, fecha_nacimiento, discapacidad, tipo_discapacidad, fecha_reporte from socios where cedula = '" . $valor . "' group by cedula";

					$resSqlSocios = query($sqlNombresSocios);
					$codOrgReportada = $codOrgSocio;
					while($fila = mysql_fetch_array($resSqlSocios))
					{
						$provNombre = GetNombreProvincia($zonaSel, $fila['cod_provincia']);
						$cedulaSocio = $fila['cedula'];
						$apellidosSocio = $fila['apellidos'];
						$generoSocio = $fila['genero'];
						if($generoSocio == '') $generoSocio = "No registrado";
						$poblacionSocio = $fila['poblacion'];
						if($poblacionSocio == '') $poblacionSocio = "No registrado";
						$grupoEtnicoSocio = $fila['grupo_etnico'];
						if($grupoEtnicoSocio == '') $grupoEtnicoSocio = "No registrado";

						$aux = 0;
						foreach($codOrgReportada as $codigoOrg)
						{
							$sqlRucOrgSocio = "select ruc_definitivo, ruc_provisional, organizacion, actividad, categoria_actividad_mp, identificacion_actividad_mp from u_organizaciones where cod_u_organizaciones = " . $codigoOrg;
							$resSqlRucOrgSocio = query($sqlRucOrgSocio);
							
							while($fila1 = mysql_fetch_array($resSqlRucOrgSocio))
							{
								if($aux == 0)
								{
									$rucSocio = $fila1['ruc_definitivo'] . " - " . $fila1['ruc_provisional'];
									$orgSocio = $fila1['organizacion'];
									$actividadOrgSocio = $fila1['actividad'];
									$categoriaOrgSocio = $fila1['categoria_actividad_mp'];
									$identificacionCategoriaOrgSocio = $fila1['identificacion_actividad_mp'];
								}
								else
								{
									$rucSocio .= " - " . $fila1['ruc_definitivo'] . " - " . $fila1['ruc_provisional'];
									$orgSocio .= " - " . $fila1['organizacion'];
									$actividadOrgSocio .= " - " . $fila1['actividad'];
									$categoriaOrgSocio .= " - " . $fila1['categoria_actividad_mp'];
									$identificacionCategoriaOrgSocio .= " - " . $fila1['identificacion_actividad_mp'];
								}
								
								
							}

							$sqlFortalecimiento = "select e.campo_fortalecimiento, e.cod_evento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento) where ev.cod_u_organizaciones = " . $codigoOrg . " and month(e.fecha_reporte) = " . $mesSel . " and e.anio = " . $anioCurso . " group by e.campo_fortalecimiento";

							//echo $sqlFortalecimiento . "<br>";
							$resFortalecimiento = query($sqlFortalecimiento);
							$aux1 = 0;
							while($fila1 = mysql_fetch_array($resFortalecimiento))
							{
								//se tiene que revisar si hay mas de un evento relacionado con esta org
								if($aux1 == 0) $campoFortalecimiento .= $fila1['campo_fortalecimiento'];
								else $campoFortalecimiento .= " - " . $fila1['campo_fortalecimiento'];
								$aux1++;
							}

							$aux++;


						}
						
					}



				}
				if($numRegistros == 1)
				{
					$sqlNombresSocios = "select apellidos, cedula, zona, cod_provincia, cod_canton, cod_parroquia, genero, grupo_etnico, poblacion, fecha_nacimiento, discapacidad, tipo_discapacidad, fecha_reporte , cod_u_organizaciones from socios where cedula = '" . $valor . "' order by cod_u_organizaciones";

					$resSqlSocios = query($sqlNombresSocios);
					while($fila = mysql_fetch_array($resSqlSocios))
					{
						$provNombre = GetNombreProvincia($zonaSel, $fila['cod_provincia']);
						$cedulaSocio = $fila['cedula'];
						$apellidosSocio = $fila['apellidos'];
						$generoSocio = $fila['genero'];
						if($generoSocio == '') $generoSocio = "No registrado";
						$poblacionSocio = $fila['poblacion'];
						if($poblacionSocio == '') $poblacionSocio = "No registrado";
						$grupoEtnicoSocio = $fila['grupo_etnico'];
						if($grupoEtnicoSocio == '') $grupoEtnicoSocio = "No registrado";

						$sqlRucOrgSocio = "select ruc_definitivo, ruc_provisional, organizacion, actividad, categoria_actividad_mp, identificacion_actividad_mp from u_organizaciones where cod_u_organizaciones = " . $fila['cod_u_organizaciones'];
						//echo $sqlRucOrgSocio . "<br>";
						$resSqlRucOrgSocio = query($sqlRucOrgSocio);
						while($fila1 = mysql_fetch_array($resSqlRucOrgSocio))
						{
							$rucSocio = $fila1['ruc_definitivo'] . " - " . $fila1['ruc_provisional'];
							$orgSocio = $fila1['organizacion'];
							$actividadOrgSocio = $fila1['actividad'];
							$categoriaOrgSocio = $fila1['categoria_actividad_mp'];
							$identificacionCategoriaOrgSocio = $fila1['identificacion_actividad_mp'];
						} 

						$sqlFortalecimiento = "select e.campo_fortalecimiento, e.cod_evento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento) where ev.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and month(e.fecha_reporte) = " . $mesSel . " and e.anio = " . $anioCurso . " group by e.campo_fortalecimiento";
						$resFortalecimiento = query($sqlFortalecimiento);
						$aux = 0;
						while($fila1 = mysql_fetch_array($resFortalecimiento))
						{
							//se tiene que revisar si hay mas de un evento relacionado con esta org
							if($aux == 0) $campoFortalecimiento .= $fila1['campo_fortalecimiento'];
							else $campoFortalecimiento .= " - " . $fila1['campo_fortalecimiento'];
							$aux++;
						}
					}
				}

				if($numRegistros == 0)
				{
					// No es un asistente que pertnezca a una organizacion
					$rucSocio = "No pertenece a una ORG/UEP";
					$orgSocio = "No pertenece a una ORG/UEP";
					$actividadOrgSocio = "No pertenece a una ORG/UEP";
					$categoriaOrgSocio = "No pertenece a una ORG/UEP";
					$identificacionCategoriaOrgSocio =  "No pertenece a una ORG/UEP";
					$sqlAsisten = "select cod_provincia, cedula, apellidos, campo_fortalecimiento, genero, grupo_etnico, poblacion from asistentes where cedula = '" . $valor . "' and month(fecha_reporte) = " . $mesSel . " and year(fecha_reporte) = " . $anioCurso . " and anio = " . $anioCurso;
					$resAsisten = query($sqlAsisten);
					while($fila = mysql_fetch_array($resAsisten))
					{
						$provNombre = GetNombreProvincia($zonaSel, $fila['cod_provincia']);
						$cedulaSocio = $valor;
						$apellidosSocio = $fila['apellidos'];
						$campoFortalecimiento = $fila['campo_fortalecimiento'];
						$generoSocio = $fila['genero'];
						if($generoSocio == '') $generoSocio = "No registrado";
						$poblacionSocio = $fila['poblacion'];
						if($poblacionSocio == '') $poblacionSocio = "No registrado";
						$grupoEtnicoSocio = $fila['grupo_etnico'];
						if($grupoEtnicoSocio == '') $grupoEtnicoSocio = "No registrado";
					}
				}

				$indice = $cont + 1;

				$lineasTabla .= "<tr>
									<td>" . $indice . "</td>
									<td>" . $nomMes . "</td>
									<td>" . $zonaSel . "</td>
									<td>" . $provNombre . "</td>
									<td>" . $rucSocio . "</td>
									<td>" . $cedulaSocio . "</td>
									<td>" . $apellidosSocio . "</td>
									<td>" . $generoSocio . "</td>
									<td>" . $grupoEtnicoSocio . "</td>
									<td>" . $poblacionSocio . "</td>
									<td>" . $orgSocio . "</td>
									<td>" . $actividadOrgSocio . "</td>
									<td>" . $categoriaOrgSocio . "</td>
									<td>" . $identificacionCategoriaOrgSocio . "</td>
									<td>" . $campoFortalecimiento . "</td>					
								</tr>";
				$cont++;				
					
			}
			
		}
		else
		{
			$tabla .= "<tr>
						<td>ESTE INDICADOR TIENE 0 REGISTROS REPORTADOS</td>
					</tr>";
		}



	}
	$resultadoFinal = $tablaHeader . $lineasTabla;
	return $resultadoFinal;
}

function GetAsistentesCircuitosEconomicos($organizaciones, $anio, $mes, $zona)
{
	$anioCurso = getAnioSeleccionado();
	$codEvento = array();
	$cedulasAsistentes = array();
	$numAsistentes = array();

	foreach($organizaciones as $valor)
	{
		$check_registrado_3 = "select eo.cod_evento from eventos_u_organizaciones eo inner join eventos e on(eo.cod_evento = e.cod_evento) inner join u_organizaciones u on (u.cod_u_organizaciones = eo.cod_u_organizaciones) 
		where e.tipo_evento = 'ORG' and eo.anio = " . $anioCurso . " and u.cod_u_organizaciones = " . $valor . " and u.circuito_economico = 'si' and year(e.fecha_registro) = " . $anioCurso;

	
		$sqlMesAnterior = $check_registrado_3;
		if($zona!="")
		{
			$check_registrado_3 = $check_registrado_3." and e.zona=$zona";
			$sqlMesAnterior = $check_registrado_3;
		}
		if($mes!="")
		{	
			$check_registrado_3 = $check_registrado_3." and month(e.fecha_reporte) = $mes"; 			
		}

		$check_registrado_3 .= " group by eo.cod_evento";

		$resEvento = query($check_registrado_3);
		while($fila = mysql_fetch_array($resEvento))
		{
			array_push($codEvento, $fila['cod_evento']);
		}


		foreach($codEvento as $valor1)
		{
			$sqlAsisCircuito = "select cedula from asistentes where cod_evento = '" . $valor1 . "' and anio = " . $anioCurso;
			//echo $sqlAsisCircuito . "<br>";
			$resAsistentes = query($sqlAsisCircuito);
			while($fila = mysql_fetch_array($resAsistentes))
			{
				array_push($cedulasAsistentes, $fila['cedula']);
			}			

		}
		$cedulasAsistentes = array_unique($cedulasAsistentes);
		$cedulasAsistentes = array_values($cedulasAsistentes);
		$contCedulas = count($cedulasAsistentes);
		array_push($numAsistentes, $contCedulas);



		//BORRAR DESPUES 
		//print_r2($cedulasAsistentes);
		EdadesCapacitadosCI($cedulasAsistentes, $codEvento, $valor);
	}

	return $numAsistentes;
}

function RecuperarInfoOrg($orgReportadas, $infoSolicitada)
{
	// se recupera las zonas de las organizaciones
	$infoRecuperada = array();
	//peticion de la provincia de la organizacion
	if($infoSolicitada == "provincia")
	{
		foreach ($orgReportadas as $valor) 
		{
			$sqlZonaOrg = "select p.provincia from u_organizaciones u inner join u_provincia p on (u.cod_provincia = p.cod_provincia) where cod_u_organizaciones = " . $valor;
			//echo $sqlZonaOrg . "<br>";
			$resSqlZonaOrg = query($sqlZonaOrg);
			$numRow = mysql_num_rows($resSqlZonaOrg);
			if($numRow > 0)
			{
				while($fila = mysql_fetch_array($resSqlZonaOrg))
				{
					array_push($infoRecuperada, $fila['provincia']);						
				}
			}
			else
			{
				array_push($infoRecuperada, "Dato faltante");
			}

			
		}
	}
	// peticion del canton de la organizacion
	if($infoSolicitada == "canton")
	{
		foreach ($orgReportadas as $valor) 
		{
			$sqlZonaOrg = "select c.canton from u_organizaciones u inner join u_provincia p on (u.cod_provincia = p.cod_provincia) inner join u_canton c on (u.cod_canton = c.cod_canton and p.cod_provincia = c.cod_provincia) where cod_u_organizaciones = " . $valor;
			$resSqlZonaOrg = query($sqlZonaOrg);
			$numRow = mysql_num_rows($resSqlZonaOrg);
			if($numRow > 0)
			{
				while($fila = mysql_fetch_array($resSqlZonaOrg))
				{
					array_push($infoRecuperada, $fila['canton']);
				}
			}
			else
				array_push($infoRecuperada, "Dato faltante");
			
		}
	}
	//peticion de la parroquia de la organizacion
	if($infoSolicitada == "parroquia")
	{
		foreach ($orgReportadas as $valor) 
		{
			$sqlZonaOrg = "select pa.parroquia from u_organizaciones u inner join u_provincia p on (u.cod_provincia = p.cod_provincia) inner join u_canton c on (u.cod_canton = c.cod_canton and p.cod_provincia = c.cod_provincia) inner join u_parroquia pa on (pa.cod_canton = c.cod_canton and pa.cod_parroquia = u.cod_parroquia) where cod_u_organizaciones = " . $valor;
			$resSqlZonaOrg = query($sqlZonaOrg);
			$numRow = mysql_num_rows($resSqlZonaOrg);
			if($numRow > 0)
			{
				while($fila = mysql_fetch_array($resSqlZonaOrg))
				{
					array_push($infoRecuperada, $fila['parroquia']);
				}
			}
			else
				array_push($infoRecuperada, "Dato faltante");			
		}
	}
	//peticion de los nombres de las organizaciones
	if($infoSolicitada == "nombresOrg")
	{
		foreach($orgReportadas as $valor)
		{
			$sqlNombreOrg = "select organizacion from u_organizaciones where cod_u_organizaciones = " . $valor;
			$resSqlNombreOrg = query($sqlNombreOrg);
			$numRow = mysql_num_rows($resSqlNombreOrg);

			if($numRow > 0)
			{
				while($fila = mysql_fetch_array($resSqlNombreOrg))
				{
					array_push($infoRecuperada, $fila['organizacion']);
				}
			}
			else
				array_push($infoRecuperada, "Dato faltante");
		}
	}
	//se devuelve el ruc dependiendo de cual (provisional/definitivo) se solicite
	if($infoSolicitada == "rucProvisionalOrg" or $infoSolicitada == "rucDefinitivoOrg")
	{
		$opcion = 0;
		switch ($infoSolicitada) 
		{
			case "rucProvisionalOrg":
				# code...
				$opcion = 1;
				break;
			case "rucDefinitivoOrg":
				$opcion = 2;
				break;			
			default:
				$opcion = 0;
				break;
		}

		foreach($orgReportadas as $valor)
		{
			$sqlRucOrg = "";
			if($opcion == 1) $sqlRucOrg = "select ruc_provisional from u_organizaciones where cod_u_organizaciones = " . $valor;
			if($opcion == 2) $sqlRucOrg = "select ruc_definitivo from u_organizaciones where cod_u_organizaciones = " . $valor;

			if($opcion != 0)
			{
				$resSqlRucOrg = query($sqlRucOrg);
				$numRow = mysql_num_rows($resSqlRucOrg);
				if($numRow > 0)
				{
					while($fila = mysql_fetch_array($resSqlRucOrg))
					{
						if($opcion == 1) array_push($infoRecuperada, $fila['ruc_provisional']);
						if($opcion == 2) array_push($infoRecuperada, $fila['ruc_definitivo']);
					}
				}
				else
					array_push($infoRecuperada, "Dato faltante");
			}
			else
				array_push($infoRecuperada, "Dato faltante");
			
		}
	}
	//peticion de fecha de registro de la organizacion
	if($infoSolicitada == "fechaRegistro")
	{
		foreach($orgReportadas as $valor)
		{
			$sqlFechaRegistro = "select fecha_registro from u_organizaciones where cod_u_organizaciones = " . $valor;
			$resSqlFechaRegistro = query($sqlFechaRegistro);
			$numRow = mysql_num_rows($resSqlFechaRegistro);
			if($numRow > 0)
			{
				while($fila = mysql_fetch_array($resSqlFechaRegistro))
				{
					array_push($infoRecuperada, $fila['fecha_registro']);
				}
			}
			else
				array_push($infoRecuperada, "Dato faltante");
		}
	}
	//peticion del circuito economico de la organizacion
	if($infoSolicitada == "circuito")
	{
		foreach($orgReportadas as $valor)
		{
			$sqlCircuitoEconomico = "select circuito_economico from u_organizaciones where cod_u_organizaciones = " . $valor;
			$resSqlCircuitoEconomico = query($sqlCircuitoEconomico);
			$numRow = mysql_num_rows($resSqlCircuitoEconomico);
			if($numRow > 0)
			{
				while($fila = mysql_fetch_array($resSqlCircuitoEconomico))
				{
					array_push($infoRecuperada, $fila['circuito_economico']);
				}
			}
			else
				array_push($infoRecuperada, "Dato faltante");
		}
	}
	//peticion de la actividad de la matriz productiva
	if($infoSolicitada == "identificacionMatriz")
	{
		foreach($orgReportadas as $valor)
		{
			$sqlActividadMatriz = "select identificacion_actividad_mp from u_organizaciones where cod_u_organizaciones = " . $valor;
			//echo $sqlActividadMatriz . "<br>";
			$resSqlActividadMatriz = query($sqlActividadMatriz);
			$numRow = mysql_num_rows($resSqlActividadMatriz);
			if($numRow > 0)
			{
				while($fila = mysql_fetch_array($resSqlActividadMatriz))
				{
					array_push($infoRecuperada, $fila['identificacion_actividad_mp']);
				}
			}
			else
				array_push($infoRecuperada, "Dato faltante");
		}
	}
	//peticion de la actividad de la matriz productiva
	if($infoSolicitada == "categoriaMatriz")
	{
		foreach($orgReportadas as $valor)
		{
			$sqlCategoriaMatriz = "select categoria_actividad_mp from u_organizaciones where cod_u_organizaciones = " . $valor;
			//echo $sqlCategoriaMatriz . "<br>";
			$resSqlCategoriaMatriz = query($sqlCategoriaMatriz);
			$numRow = mysql_num_rows($resSqlCategoriaMatriz);
			if($numRow > 0)
			{
				while($fila = mysql_fetch_array($resSqlCategoriaMatriz))
				{
					array_push($infoRecuperada, $fila['categoria_actividad_mp']);
				}
			}
			else
				array_push($infoRecuperada, "Dato faltante");
		}
	}
	return $infoRecuperada;
	

}

function NumSociosOrganizacion($orgConsultadas)
{
	// Se debe revisar los socios de cada organizacion para el reporte

	$numSociosOrg = array();
	foreach ($orgConsultadas as $valor) 
	{
		$sqlNumSocios = "select count(distinct cod_socios) as numsocios from socios where cod_u_organizaciones = " . $valor ;
		$resNumSocios = query($sqlNumSocios);
		while($fila = mysql_fetch_array($resNumSocios))
		{
			array_push($numSociosOrg, $fila['numsocios']);
		}

	}

	return $numSociosOrg;
}

function NumPersonasCapacitadas($orgReportadas, $anio, $mes, $tipoOrg, $zona)
{
	global $eventosAsistentes;
	//las personas capacitadas se refieren a sus socios y si estos han sido capacitados	
	$sociosOrg = array();
	$asistentes = array();
	$capacitados = array();			//guarda el numero de capacitados por organizacion
	//$cont = 0;					// para fines de depuracion
	foreach($orgReportadas as $valor)
	{
		$listaEventos = "";
		//se consulta los socios de la organizacion
		$sqlSociosOrg = "select cedula from socios where cod_u_organizaciones = " . $valor . " and estado = 1 group by cedula";
		//echo $sqlSociosOrg . "<br>";
		unset($sociosOrg);			//porq ocurria un error al reiniciar el array a 0 elementos
		$sociosOrg = array();
		$resSociosOrg = query($sqlSociosOrg);
		while($fila = mysql_fetch_array($resSociosOrg))
		{
			array_push($sociosOrg, $fila['cedula']);
		}

		//se consulta los eventos reportados en el mes indicado por cada organizacion enviada en la variable $orgReportadas
		$sqlEventos = "select ev.cod_evento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento) where ev.tipo_evento = '" . $tipoOrg . "' and ev.cod_u_organizaciones = " . $valor . " and month(e.fecha_reporte) = " . $mes . " and year(e.fecha_reporte) = " . $anio . " and e.zona = " . $zona . " and ev.anio = " . $anio . " group by ev.cod_evento";
		//echo $sqlEventos . ";<br>";	
		$resSqlEventos = query($sqlEventos);
		unset($asistentes);
		$asistentes = array();				
		while($fila = mysql_fetch_array($resSqlEventos))
		{
			//se consulta las cedulas de los asistentes al evento			
			$sqlAsistentes = "select cedula from asistentes where cod_evento = '" . $fila['cod_evento'] . "' and anio = " . $anio . " and tipo_evento = '" . $tipoOrg . "' group by cedula";
			//echo $cont . " - " . $sqlAsistentes . "<br>";
			$resSqlAsistentes = query($sqlAsistentes);
			$listaEventos .= $fila['cod_evento'] . " ";
			while($fila1 = mysql_fetch_array($resSqlAsistentes))
			{
				//se guardan las cedulas de los asistentes, no importa si este se repite en diferentes eventos
				//luego se procedera a eliminar duplicados
				array_push($asistentes, $fila1['cedula']);
				
			}
		}
		// eliminacion de cedulas de asistentes duplicados
		$asistentes = array_unique($asistentes);
		$contCap = 0;						//guardara el numero de socios capacitados
		
		$contCap = count($asistentes);
		// Para posible revision
		//revisamos si dentro de asistentes se encuentran los socios de la organizacion
		/*foreach ($sociosOrg as $cedSocio) 
		{
			if(in_array($cedSocio, $asistentes))
			{
				// si encuentra coincidencia, se sumara al numero de socios capacitados
				$contCap++;
			}
		}*/
		//guardamos el resultado final de esta operacion en el array $capacitados
		array_push($capacitados, $contCap);
		//echo "Organizacion: " . $valor . "<br>";	
		//echo "NumCapacitados: " . $contCap . "<br>";
		array_push($eventosAsistentes, $listaEventos);

	}
	return $capacitados;	
}

function ServiciosBrindadosOrg($orgReportadas, $anio, $mes, $tipoOrg, $zona)
{
	/*************************************
	Se necesita averiguar los eventos que se dieron en el mes y año indicado para cada organizacion
	de ahi se toma los diferentes registros de servicios brindados
	**************************************/
	$serviciosBrindados = array();			//guarda los servicios brindados para cada org

	foreach ($orgReportadas as $valor) 
	{
		//consulta de eventos	
		$sqlEventos = "select ev.cod_evento, e.campo_fortalecimiento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento) where ev.tipo_evento = '" . $tipoOrg . "' and ev.cod_u_organizaciones = " . $valor . " and month(e.fecha_reporte) = " . $mes . " and year(e.fecha_reporte) = " . $anio . " and e.zona = " . $zona . " and ev.anio = " . $anio . " group by ev.cod_evento";

		//echo $sqlEventos . "<br>";
		$resSqlEventos = query($sqlEventos);
		$serviciosRegistrados = array();				//guardara los servicios registrados
		while($fila = mysql_fetch_array($resSqlEventos))
		{
			array_push($serviciosRegistrados, $fila['campo_fortalecimiento']);
		}
		//eliminamos duplicados
		$serviciosRegistrados = array_unique($serviciosRegistrados);
		//recorremos el array $servicioRegistrados y si existe mas de un servicio, se integra en una sola respuesta
		$serviciosIntegrados = "";
		$contServicios = 0;
		foreach ($serviciosRegistrados as $nombreServicio) 
		{
			if($contServicios == 0)
				$serviciosIntegrados = $nombreServicio;
			else
				$serviciosIntegrados .= " - " . $nombreServicio;
			$contServicios++;
			
		}
		//se integra el valor de $serviciosIntegrados al array final $serviciosBrindados

		if(strlen($serviciosIntegrados) > 0)
			array_push($serviciosBrindados, $serviciosIntegrados);
		else
			array_push($serviciosBrindados, "N/A");
	}

	//print_r2($serviciosBrindados);
	return $serviciosBrindados;

}


function GetNombreMes($codigoMes)
{
	$nombresMes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$resultMes = $nombresMes[$codigoMes - 1];
	return $resultMes;
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

	// echo $sqlEventosMes . "<br>";
	// echo $sqlAsistencias . "<br>";

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

	return $arrayOrgEventos;



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

	return $indicador_1 = $arrayFinal;		
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

	

	return $arrayOrgEventos;



}

function segundo_indicador1($mes,$zona)
{
	$uepFinal = array();
	$uepMesAnterior = array();

	$anioCurso = getAnioSeleccionado();

	$check_registrado_2 = "select eo.cod_u_organizaciones, eo.ruc_institucion,eo.cod_evento, eo.tipo_evento, e.tipo_evento
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
					array_push($uepMesAnterior, $fila['cod_u_organizaciones']);						
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
		array_push($uepFinal, $fila['cod_u_organizaciones']);
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
	return $indicador_2 = $uepFinal;
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
	where e.tipo_evento = 'ORG' and eo.anio = " . $anioCurso . " and u.circuito_economico = 'si' and year(e.fecha_registro) = " . $anioCurso;

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


	return $indicador_3 = $circuitosFinal;
}

/*******************************************CUARTO INDICADOR******************************************************
/*NÚMERO DE PERSONAS QUE CONFORMAN LAS ORGANIZACIONES O UEPS QUE HAN RECIBIDO AL MENOS UN SERVICIO DE UN SERVICIO DE 
LA DIRECCIÓN DE FORTALECIMIENTO DE ACTORES Y QUE SE ENCUENTRAN EN LA ESTRATEGIA PARA EL CAMBIO DE LA MATRIZ PRODUCTIVA*/


function cuarto_indicador($mes,$zona)
{
	global $orgSocios;
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
	//print_r2($cedulaTotalOrg);
	$orgSocios = $totalOrg;

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

	return $indicador_4 = $cedulaTotalOrg;
}

function cuarto_indicador03082017($mes,$zona)
{
	global $orgSocios;
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
		$sqlCedulaTotal = "select cedula from socios where estado = 1 and cod_u_organizaciones = " . $valor;
		//echo $sqlCedulaTotal . "<br>";
		$resSqlCedulaTotal = query($sqlCedulaTotal);
		while($fila = mysql_fetch_array($resSqlCedulaTotal))
		{
			array_push($cedulaTotalOrg, $fila['cedula']);
		}
	}

	// quito duplicados
	$cedulaTotalOrg = array_unique($cedulaTotalOrg);
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
				$sqlCedulaTotal = "select cedula from socios where estado = 1 and cod_u_organizaciones = " . $valor;
				//echo $sqlCedulaTotal . "<br>";
				$resSqlCedulaTotal = query($sqlCedulaTotal);
				while($fila = mysql_fetch_array($resSqlCedulaTotal))
				{
					array_push($cedulaReporteAnt, $fila['cedula']);
				}
			}

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

	$orgSocios = $totalOrg;

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
	
	return $indicador_4 = $cedulaTotalOrg;
}

function cuarto_indicador1($mes,$zona)
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
		$sqlCedulaTotal = "select cedula from socios where estado = 1 and cod_u_organizaciones = " . $valor;
		//echo $sqlCedulaTotal . "<br>";
		$resSqlCedulaTotal = query($sqlCedulaTotal);
		while($fila = mysql_fetch_array($resSqlCedulaTotal))
		{
			array_push($cedulaTotalOrg, $fila['cedula']);
		}
	}

	// quito duplicados
	$cedulaTotalOrg = array_unique($cedulaTotalOrg);
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
				$sqlCedulaTotal = "select cedula from socios where estado = 1 and cod_u_organizaciones = " . $valor;
				//echo $sqlCedulaTotal . "<br>";
				$resSqlCedulaTotal = query($sqlCedulaTotal);
				while($fila = mysql_fetch_array($resSqlCedulaTotal))
				{
					array_push($cedulaReporteAnt, $fila['cedula']);
				}
			}

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
	
	return $indicador_4 = $cedulaTotalOrg;
}






/*******************************************QUINTO INDICADOR*********************************************************/
/*******************NÚMERO DE HORAS DE CAPACITACIÓN DIRIGIDA HACIA LAS ORGANIZACIONES DE LA EPS**********************/
function quinto_indicador($mes,$zona)
{

	$anioCurso = getAnioSeleccionado();
	$eventosQuinto = array();

	$check_registrado_5 = "select cod_evento, num_horas_evento from eventos where year(fecha_reporte)= " . $anioCurso;
	//$check_registrado_5 = "select num_horas_evento from eventos where year(fecha_reporte)= year(now())";
	if($zona!="")
		{
			$check_registrado_5 = $check_registrado_5 ." and zona=$zona";
		}
	if($mes!="")
		{	
			$check_registrado_5 = $check_registrado_5 ." and month(fecha_reporte) = $mes";
		}	


	$check_registrado_5 = $check_registrado_5 ." and anio = " . $anioCurso . " group by cod_evento";
	
	//echo "<br>" . $check_registrado_5;
	$result = query($check_registrado_5);
	$total_horas_5 = 0;
	while($data=mysql_fetch_array($result))
	{		
		//$total_horas_5 = $total_horas_5 + $data->num_horas_evento;
		array_push($eventosQuinto, $data['cod_evento']);
		array_push($eventosQuinto, $data['num_horas_evento']);
	}
	//print_r2($eventosQuinto);
	return $eventosQuinto;

}


/*******************************************SEXTO INDICADOR*********************************************************/
/**********************************NÚMERO DE EVENTOS PARA DIÁLOGOS SOCIALES*****************************************/
function sexto_indicador($mes,$zona)
{
	$anioCurso = getAnioSeleccionado();

	$check_registrado_6 = "select cod_dialogo from dialogo_social where year(fecha_reporte)= " . $anioCurso;
	//$check_registrado_6 = "select count(cod_dialogo)as num_eventos from dialogo_social where year(fecha_reporte)= year(now())";
	if($zona!="")
		{
			$check_registrado_6 = $check_registrado_6 ." and zona=$zona";
		}
	if($mes!="")
		{	
			$check_registrado_6 = $check_registrado_6 ." and month(fecha_dialogo) = $mes";
		}
	$check_registrado_6 .= " group by cod_dialogo";	
	//echo $check_registrado_6 . "<br>";

	$result=query($check_registrado_6);
	$num_eventos_6 = 0;
	$codDialogos = array();
	while($data=mysql_fetch_array($result))
	{		
		 array_push($codDialogos, $data['cod_dialogo']);
	}
	return $codDialogos;	
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

	$num_eventos_7 = $cedulaSinDuplicados;

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

	return $arrayOrgEventos;



}

function octavo_indicador1($mes,$zona)
{
	/*******************************************************************************************************************************************/
	/**********************************CONSULTA TODAS LAS CAPACITACIONES A ORGANIZACIONES*******************************************************/ 

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
	$total_organizaciones = $orgMes;	

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
	where a.tipo_evento in('UEP','ORG') and a.anio= " . $anioCurso . " and year(e.fecha_reporte)= " . $anioCurso;

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
	$num_eventos_9 = $cedSinDuplicados;
	return $indicador_9 = $num_eventos_9;
}

function NumCapacitadosGenero($orgReportadas, $anio, $mes, $tipoOrg, $zona, $genero)
{	
	$numGenero = array();
	//BORRRAR DEPSUES SOLO PARA FORTALECIMIENTO
	$eventosCapacitados = array();

	foreach($orgReportadas as $valor)
	{
		// Se debe buscar los numeros de capacitados por genero de la organizacion
		//se consulta los eventos reportados en el mes indicado por cada organizacion enviada en la variable $orgReportadas
		$sqlEventos = "select ev.cod_evento from eventos_u_organizaciones ev inner join eventos e on (e.cod_evento = ev.cod_evento) where ev.tipo_evento = '" . $tipoOrg . "' and ev.cod_u_organizaciones = " . $valor . " and month(e.fecha_reporte) = " . $mes . " and year(e.fecha_reporte) = " . $anio . " and e.zona = " . $zona . " and ev.anio = " . $anio . " group by ev.cod_evento";
		//echo $sqlEventos . ";<br>";	
		$resSqlEventos = query($sqlEventos);
		unset($asistentes);
		$asistentes = array();				
		while($fila = mysql_fetch_array($resSqlEventos))
		{
			//se consulta las cedulas de los asistentes al evento			
			$sqlAsistentes = "select cedula from asistentes where cod_evento = '" . $fila['cod_evento'] . "' and anio = " . $anio . " and genero = '" . $genero . "' and tipo_evento = '" . $tipoOrg . "' group by cedula";
			//echo $cont . " - " . $sqlAsistentes . "<br>";
			

			//BORRAR DESPUES
			array_push($eventosCapacitados, $fila['cod_evento']);



			$resSqlAsistentes = query($sqlAsistentes);
			while($fila1 = mysql_fetch_array($resSqlAsistentes))
			{
				//se guardan las cedulas de los asistentes, no importa si este se repite en diferentes eventos
				//luego se procedera a eliminar duplicados
				array_push($asistentes, $fila1['cedula']);

			}
		}
		// eliminacion de cedulas de asistentes duplicados
		$asistentes = array_unique($asistentes);
		$asistentes = array_values($asistentes);
		$contCap = 0;						//guardara el numero de socios capacitados
		
		$contCap = count($asistentes);
		// Para posible revision
		//revisamos si dentro de asistentes se encuentran los socios de la organizacion
		/*foreach ($sociosOrg as $cedSocio) 
		{
			if(in_array($cedSocio, $asistentes))
			{
				// si encuentra coincidencia, se sumara al numero de socios capacitados
				$contCap++;
			}
		}*/
		//guardamos el resultado final de esta operacion en el array $capacitados
		array_push($numGenero, $contCap);



		//SOLO PARA INFORME BORRAR LUEGO
		//print_r2($asistentes);
		// $eventosCapacitados = array_unique($eventosCapacitados);
		// $eventosCapacitados = array_values($eventosCapacitados);
		// EdadesCapacitados($asistentes, $eventosCapacitados, $tipoOrg, $valor);		

	}
	return $numGenero;
}

//SLOLO PARA INFORME DE FORTALECIMIENTO, BORRAR LUEGO
function EdadesCapacitados($arrayCedulasCapacitados, $eventosCap, $tipoOrg, $org)
{
	$arrayCedulasCapacitados = array_unique($arrayCedulasCapacitados);
	//$eventosCap = array_unique($eventosCap);
	//print_r2($arrayCedulasCapacitados);
	//print_r2($eventosCap);

	$sizeEventos = count($eventosCap);
	$anioSel = getAnioSeleccionado();
	global $tablaCapacitados;
	$indiceCap = 0;
	foreach($arrayCedulasCapacitados as $valor)
	{
		for($i = 0; $i < $sizeEventos; $i++)
		{
			$sqlDetalleCapacitados = "select * from asistentes where cod_evento = '" . $eventosCap[$i] . "' and cedula = '" . $valor . "' and anio = " . $anioSel . " and tipo_evento = '" . $tipoOrg . "' group by cedula";
			//echo $sqlDetalleCapacitados . "<br>";
			$resDetalleCap = query($sqlDetalleCapacitados);
			$numFilas = mysql_num_rows($resDetalleCap);

			if($numFilas > 0)
			{
				while($fila = mysql_fetch_array($resDetalleCap))
				{
					$indiceCap++;
					$nOrg = "";
					//echo $sqlDetalleCapacitados . "<br>";
					$sqlOrgCap = "select organizacion from u_organizaciones where cod_u_organizaciones = " . $org;
					$resOrgCap = query($sqlOrgCap);
					while($fila1 = mysql_fetch_array($resOrgCap))
					{
						$nOrg = $fila1['organizacion'];
					}
					$tablaCapacitados .= "<tr>
											<td>" . $indiceCap . "</td>
											<td>" . $fila['apellidos'] . "</td>
											<td>" . $fila['cedula'] . "</td>
											<td>" . $fila['genero'] . "</td>
											<td>" . $fila['edad'] . "</td>
											<td>" . $eventosCap[$i] . "</td>
											<td>" . $tipoOrg . "</td>
											<td>" . $nOrg . "</td>
										</tr>";
				}
			}
		}
		
	}
}

function EdadesCapacitadosCI($arrayCedulasCapacitados, $eventosCap, $org)
{
	$arrayCedulasCapacitados = array_unique($arrayCedulasCapacitados);
	//$eventosCap = array_unique($eventosCap);
	//print_r2($arrayCedulasCapacitados);
	//print_r2($eventosCap);

	$sizeEventos = count($eventosCap);
	$anioSel = getAnioSeleccionado();
	global $tablaCapacitados;
	$indiceCap = 0;
	foreach($arrayCedulasCapacitados as $valor)
	{
		for($i = 0; $i < $sizeEventos; $i++)
		{
			$sqlDetalleCapacitados = "select * from asistentes where cod_evento = '" . $eventosCap[$i] . "' and cedula = '" . $valor . "' and anio = " . $anioSel ." group by cedula";
			//echo $sqlDetalleCapacitados . "<br>";
			$resDetalleCap = query($sqlDetalleCapacitados);
			$numFilas = mysql_num_rows($resDetalleCap);

			if($numFilas > 0)
			{
				while($fila = mysql_fetch_array($resDetalleCap))
				{
					$indiceCap++;
					$nOrg = "";
					//echo $sqlDetalleCapacitados . "<br>";
					$sqlOrgCap = "select organizacion from u_organizaciones where cod_u_organizaciones = " . $org;
					$resOrgCap = query($sqlOrgCap);
					while($fila1 = mysql_fetch_array($resOrgCap))
					{
						$nOrg = $fila1['organizacion'];
					}
					$tablaCapacitados .= "<tr>
											<td>" . $indiceCap . "</td>
											<td>" . $fila['apellidos'] . "</td>
											<td>" . $fila['cedula'] . "</td>
											<td>" . $fila['genero'] . "</td>
											<td>" . $fila['edad'] . "</td>
											<td>" . $eventosCap[$i] . "</td>
											<td>" . $fila['tipo_evento'] . "</td>
											<td>" . $nOrg . "</td>
										</tr>";
				}
			}
		}
		
	}
}

function GetTablaCapacitados()
{
	global $tablaCapacitados;
	return $tablaCapacitados;
}

?>