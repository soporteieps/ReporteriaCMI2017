<?php
include '../lib/dbconfig.php';

//tomo los datos enviados
$idIndicador = $_POST['idIndicador'];
$idZona = $_POST['idZona'];
$idMes = $_POST['idMes'];


$tabla = "<table id='tablaResultado'>
			<tr>
				<th id='cuadroBlanco'></th>
				<th colspan='5' class='colorIndicador total'>SERVICIOS DE LA DIRECCION</th>
				<th colspan='6' class='colorIndicador1'>CUMPLIMIENTO</th>
			</tr>
			<tr>
				<th class='colorIndicador'>INDICADORES</th>
				<th class='colorIndicador'>Asesoría para la elaboración de planes de negocio solidarios</th>
				<th class='colorIndicador'>Cofinanciamiento para proyectos de la EPS</th>
				<th class='colorIndicador'>Asistencia técnica en procesos administrativos</th>
				<th class='colorIndicador'>Alianza con instituciones para la AT en procesos operativos</th>
				<th class='total colorIndicador'>Total</th>
				<th class='colorIndicador1'>Meta Periodo</th>
				<th class='colorIndicador1'>% Ejecutado</th>
				<th class='colorIndicador1'>Meta Anual</th>
				<th class='colorIndicador1'>%Avance</th>
				<th class='colorIndicador1'>Zona</th>
				<th class='colorIndicador1'>Mes</th>
			</tr>";

//Indicadores
$nombresIndicadores = array();
/*$nombresIndicadores = array('NÚMERO DE ORGANIZACIONES DE LA EPS QUE RECIBIERON OTRO SERVICIO DE LA DIRECCIÓN DE FOMENTO PRODUCTIVO',
		'NÚMERO DE NUEVAS ORGANIZACIONES DE LA EPS QUE RECIBIERON AL MENOS UN SERVICIO DE LA DIRECCIÓN DE FOMENTO PRODUCTIVO',
		'NÚMERO DE UNIDADES ECONÓMICAS Y SOLIDARIAS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DFP',
		'NÚMERO DE CIRCUITOS ECONÓMICOS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DFP',
		'NÚMERO DE PERSONAS DE LA EPS QUE ACCEDEN A PLAZAS DE TRABAJO A TRAVÉS DE COFINANCIAMIENTO',
		'NÚMERO DE PERSONAS DE LA EPS QUE ACCEDEN AL MENOS A UN SERVICIO DE LA DFP ENMARCADOS EN LA ESTRATEGIA DEL CAMBIO EN LA MATRIZ PRODUCTIVA',
		'NÚMERO DE ORGANIZACIONES QUE HAN RECIBIDO PROCESOS DE ASISTENCIA TÉCNICA');*/


function getNombresIndicadores()
{
	$auxNombresIndicadores = array();
	$sqlNombresInd = "select indicador from indicador where estado = 1 and departamento = 'FP' order by cod_indicador";
	$resSqlNombreInd = query($sqlNombresInd);
	while($fila = mysql_fetch_array($resSqlNombreInd))
	{
		array_push($auxNombresIndicadores, $fila['indicador']);
	}
	return $auxNombresIndicadores;
}

//Tomamos los nombres de los indicadores
$nombresIndicadores = getNombresIndicadores();

//Dependiendo de la eleccion que se haga, imprimera los resultados
if($idZona == -1 && $idMes == -1 && $idIndicador == -1)
{
	//Quiere ver todos los meses e indicadores
	for($i = 1; $i < 10; $i++) //zonas
	{
		for($j = 1; $j < 13; $j++) //meses
		{
			Indicador01($i, $j);
			Indicador02($i, $j);
			Indicador03($i, $j);
			Indicador04($i, $j);
			Indicador05($i, $j);
			Indicador06($i, $j);
			Indicador07($i, $j);
		}
	}
}

//Si ha elegido la zona pero no el mes e indicador
if($idZona != -1 && $idMes == -1 && $idIndicador == -1)
{
	for($i = 1; $i < 13; $i++)
	{
		Indicador01($idZona, $i);
		Indicador02($idZona, $i);
		Indicador03($idZona, $i);
		Indicador04($idZona, $i);
		Indicador05($idZona, $i);
		Indicador06($idZona, $i);
		Indicador07($idZona, $i);
	}
}

//Si ha elegido el mes pero no la zona e indicador
if($idZona == -1 && $idMes != -1 && $idIndicador == -1)
{
	for($i = 1; $i < 10; $i++)
	{
		Indicador01($i, $idMes);
		Indicador02($i, $idMes);
		Indicador03($i, $idMes);
		Indicador04($i, $idMes);
		Indicador05($i, $idMes);
		Indicador06($i, $idMes);
		Indicador07($i, $idMes);
	}
}

//Si ha elegido el indicador pero no la zona y el mes
if($idZona == -1 && $idMes == -1 && $idIndicador != -1)
{
	for($i = 1; $i < 10; $i++)
	{
		for($j = 1; $j < 13; $j++)
		{
		    if($idIndicador == 10)Indicador01($i, $j);
		    if($idIndicador == 11)Indicador02($i, $j);
		    if($idIndicador == 12)Indicador03($i, $j);
		    if($idIndicador == 13)Indicador04($i, $j);
		    if($idIndicador == 14)Indicador05($i, $j);
		    if($idIndicador == 15)Indicador06($i, $j);
		    if($idIndicador == 16)Indicador07($i, $j);
		}
	}
}

//Si ha elegido la zona y el mes pero no el Indicador
if($idZona != -1 && $idMes != -1 && $idIndicador == -1)
{
	Indicador01($idZona, $idMes);
	Indicador02($idZona, $idMes);
	Indicador03($idZona, $idMes);
	Indicador04($idZona, $idMes);
	Indicador05($idZona, $idMes);
	Indicador06($idZona, $idMes);
	Indicador07($idZona, $idMes);
}

//Si ha elegido la zona y el indicador pero no el mes
if($idZona != -1 && $idMes == -1 && $idIndicador != -1)
{
	for($i = 1; $i < 13; $i++)
	{
		if($idIndicador == 10)Indicador01($idZona, $i);
	    if($idIndicador == 11)Indicador02($idZona, $i);
	    if($idIndicador == 12)Indicador03($idZona, $i);
	    if($idIndicador == 13)Indicador04($idZona, $i);
	    if($idIndicador == 14)Indicador05($idZona, $i);
	    if($idIndicador == 15)Indicador06($idZona, $i);
	    if($idIndicador == 16)Indicador07($idZona, $i);
	}
}

//Si ha elegido el mes y el indicador pero no la zona
if($idZona == -1 && $idMes != -1 && $idIndicador != -1)
{
	for($i = 1; $i < 10; $i++)
	{
		if($idIndicador == 10)Indicador01($i, $idMes);
	    if($idIndicador == 11)Indicador02($i, $idMes);
	    if($idIndicador == 12)Indicador03($i, $idMes);
	    if($idIndicador == 13)Indicador04($i, $idMes);
	    if($idIndicador == 14)Indicador05($i, $idMes);
	    if($idIndicador == 15)Indicador06($i, $idMes);
	    if($idIndicador == 16)Indicador07($i, $idMes);
	}
}

//Si ha elegido todos los parametros
if($idZona != -1 && $idMes != -1 && $idIndicador != -1)
{	
	if($idIndicador == 10)Indicador01($idZona, $idMes);
    if($idIndicador == 11)Indicador02($idZona, $idMes);
    if($idIndicador == 12)Indicador03($idZona, $idMes);
    if($idIndicador == 13)Indicador04($idZona, $idMes);
    if($idIndicador == 14)Indicador05($idZona, $idMes);
    if($idIndicador == 15)Indicador06($idZona, $idMes);
    if($idIndicador == 16)Indicador07($idZona, $idMes);	
}


$tabla .= "</table>";
echo $tabla;

function getAnioSeleccionado()
{	
	$anioCurso = $_POST['idAnio'];
	
	return $anioCurso;
}

function MetaMensual($zona, $mes, $indicador)
{
	$anioCurso = getAnioSeleccionado();

	$metaProgramada = 0;
	//consultamos la meta programada
	$sqlMetaProgramada = "
	select i.indicador, iz.cod_zona, izm.mes, izm.meta_programada 
	from indicador_zona_mes izm
	inner join indicador_zona iz on (iz.cod_indicador_zona = izm.cod_indicador_zona)
	inner join indicador i on (i.cod_indicador = iz.cod_indicador)
	where i.cod_indicador = " . $indicador . " and izm.mes = " . $mes . " and iz.cod_zona = " .$zona . " and izm.anio_indicador = " . $anioCurso;

	$resSqlMetaProgramada = query($sqlMetaProgramada);
	while($fila = mysql_fetch_array($resSqlMetaProgramada))
	{
		$metaProgramada = $fila['meta_programada'];
	}

	return $metaProgramada;
}

function MetaAnio($zona, $mes, $indicador)
{
	$metaA = 0;
	$anioCurso = getAnioSeleccionado();

	//sql meta anual por zona
	$sqlMetaAnual = "select i.indicador, iz.cod_zona, izm.mes, sum(izm.meta_programada) as suma
	from indicador_zona_mes izm
	inner join indicador_zona iz on (iz.cod_indicador_zona = izm.cod_indicador_zona)
	inner join indicador i on (i.cod_indicador = iz.cod_indicador)
	where i.cod_indicador = " . $indicador . " and iz.cod_zona = " . $zona . " and izm.anio_indicador = " . $anioCurso . " 
	group by iz.cod_zona";

	$resMetaAnual = query($sqlMetaAnual);
	
	while($fila = mysql_fetch_array($resMetaAnual))
	{
		$metaA = $fila['suma'];		
	}

	return $metaA;
}

function Indicador01($zona, $mes)
{

	global $tabla, $nombresIndicadores;	
	
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

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== PRIMER INDICADOR =======================*/
	/*NUMERO DE ORGANIZACIONES DE LA EPS QUE RECIBIERON  OTRO SERVICIO DE LA DIRECCION DE FOMENTO PRODUCTIVO*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, 10);
	$metaAnual = MetaAnio($zona, $mes, 10);	

	


	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and u.tipo = 'org' and fp.documentacion_valida = 'si' group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_registro from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' order by fp.fecha_registro asc limit 1";

		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
		}		
	}

	/*echo "<br>Organizaciones<br>";
	print_r2($orgCodYServicios);
	echo "<br>Organizaciones<br>";*/


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 2)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.fecha_registro < '" . $fechaConsultar . "'" ;

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
			$sqlOrgOtroServicio = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio <> " . $orgCodYServicios[$i + 1] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.fecha_registro < '" . $fechaConsultar . "'";

			//echo $sqlOrgOtroServicio . "<br>";

			/*****************************************************************************************************************
			- Se puede tener dos resultados:
			-- Si existe registros anteriores con otro codigo de servicio, esta organizacion es antigua y  debe sumar al indicador con respecto a la posicion en el array.
			-- Si no existe ningun otro codigo, esta organizacion es nueva y es su primera vez tomando un servicio de Fomento Productivo, por lo cual no deberia sumar a este indicador
			******************************************************************************************************************/

			$resOrgOtroServicio = query($sqlOrgOtroServicio);

			$numFilasOrgOtroServicio = mysql_num_rows($resOrgOtroServicio);
			if($numFilasOrgOtroServicio >= 1)
			{
				$orgServicios[$orgCodYServicios[$i + 1] - 1]++;
			}			
		}
		
	}

	//Se guarda la suma total en la ultima posicion del array
	$orgServicios[4] = $orgServicios[0] + $orgServicios[1] + $orgServicios[2] + $orgServicios[3]; 

	//Porcentaje de meta mensual y anual
	$metaMensual = round(($orgServicios[4] * 100) / $metaMes, 2);
	$metaAnio = round(($orgServicios[4] * 100) / $metaAnual, 2);

	/*echo "<br>Servicios<br>";
	print_r2($orgServicios);
	echo "<br>Servicios<br>";*/

	//IMPRESION DE RESULATDOS	

	/*<tr>
				<th>INDICADORES</th>
				<th>Asesoría para la elaboración de planes de negocio solidarios</th>
				<th>Cofinanciamiento para proyectos de la EPS</th>
				<th>Asistencia técnica en procesos administrativos</th>
				<th>Alianza con instituciones para la AT en procesos operativos</th>
				<th>Total</th>
				<th class='total'>Meta Periodo</th>
				<th>% Ejecutado</th>
				<th>Meta Anual</th>
				<th>%Avance</th>
				<th>Zona</th>
				<th>Mes</th>
			</tr>*/

	
	$tabla .= "<tr>
			<td>" . $nombresIndicadores[0] . "</td>
			<td>" . $orgServicios[0] . "</td>
			<td>" . $orgServicios[1] . "</td>
			<td>" . $orgServicios[2] . "</td>
			<td>" . $orgServicios[3] . "</td>
			<td class = 'total'>" . $orgServicios[4] . "</td>			
			<td>" . $metaMes . "</td>
			<td>" . $metaMensual . "%</td>
			<td>" . $metaAnual . "</td>
			<td>" . $metaAnio . "%</td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
		</tr>";	
	
	
}

function Indicador02($zona, $mes)
{
	global $tabla, $nombresIndicadores;	
	
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

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== SEGUNDO INDICADOR =======================*/
	/*NÚMERO DE NUEVAS ORGANIZACIONES DE LA EPS QUE RECIBIERON AL MENOS UN SERVICIO DE LA DIRECCIÓN DE FOMENTO PRODUCTIVO*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, 11);
	$metaAnual = MetaAnio($zona, $mes, 11);	

	


	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and u.tipo = 'org' and fp.documentacion_valida = 'si' group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_registro from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' order by fp.fecha_registro asc limit 1";

		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
		}		
	}

	/*echo "<br>Organizaciones<br>";
	print_r2($orgCodYServicios);
	echo "<br>Organizaciones<br>";*/


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 2)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.fecha_registro < '" . $fechaConsultar . "'" ;

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
			$sqlOrgOtroServicio = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio <> " . $orgCodYServicios[$i + 1] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.fecha_registro < '" . $fechaConsultar . "'";

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
				$orgServicios[$orgCodYServicios[$i + 1] - 1]++;
			}			
		}
		
	}

	//Se guarda la suma total en la ultima posicion del array
	$orgServicios[4] = $orgServicios[0] + $orgServicios[1] + $orgServicios[2] + $orgServicios[3]; 

	//Porcentaje de meta mensual y anual
	$metaMensual = round(($orgServicios[4] * 100) / $metaMes, 2);
	$metaAnio = round(($orgServicios[4] * 100) / $metaAnual, 2);

	/*echo "<br>Servicios<br>";
	print_r2($orgServicios);
	echo "<br>Servicios<br>";*/

	//IMPRESION DE RESULATDOS	

	/*<tr>
				<th>INDICADORES</th>
				<th>Asesoría para la elaboración de planes de negocio solidarios</th>
				<th>Cofinanciamiento para proyectos de la EPS</th>
				<th>Asistencia técnica en procesos administrativos</th>
				<th>Alianza con instituciones para la AT en procesos operativos</th>
				<th>Total</th>
				<th class='total'>Meta Periodo</th>
				<th>% Ejecutado</th>
				<th>Meta Anual</th>
				<th>%Avance</th>
				<th>Zona</th>
				<th>Mes</th>
			</tr>*/

	
	$tabla .= "<tr>
			<td>" . $nombresIndicadores[1] . "</td>
			<td>" . $orgServicios[0] . "</td>
			<td>" . $orgServicios[1] . "</td>
			<td>" . $orgServicios[2] . "</td>
			<td>" . $orgServicios[3] . "</td>
			<td class = 'total'>" . $orgServicios[4] . "</td>			
			<td>" . $metaMes . "</td>
			<td>" . $metaMensual . "%</td>
			<td>" . $metaAnual . "</td>
			<td>" . $metaAnio . "%</td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
		</tr>";

}

function Indicador03($zona, $mes)
{
	global $tabla, $nombresIndicadores;	
	
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

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== TERCER INDICADOR =======================*/
	/*'NÚMERO DE UNIDADES ECONÓMICAS Y SOLIDARIAS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DFP*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, 12);
	$metaAnual = MetaAnio($zona, $mes, 12);	

	


	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.documentacion_valida = 'si' and u.tipo = 'uep' group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_registro from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and fp.documentacion_valida = 'si' and u.tipo = 'uep'  order by fp.fecha_registro asc limit 1";

		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
		}		
	}

	/*echo "<br>Organizaciones<br>";
	print_r2($orgCodYServicios);
	echo "<br>Organizaciones<br>";*/


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 2)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and u.tipo = 'uep' and fp.documentacion_valida = 'si' and fp.fecha_registro < '" . $fechaConsultar . "'" ;

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
			$sqlOrgOtroServicio = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio <> " . $orgCodYServicios[$i + 1] . " and u.tipo = 'uep' and fp.documentacion_valida = 'si' and fp.fecha_registro < '" . $fechaConsultar . "'";

			//echo $sqlOrgOtroServicio . "<br>";

			/*****************************************************************************************************************
			- Se puede tener dos resultados:
			-- Si existe registros anteriores con otro codigo de servicio, esta organizacion es antigua y no debe sumar al indicador.
			-- Si no existe ningun otro codigo, esta organizacion es nueva y es su primera vez tomando un servicio de Fomento Productivo, por lo cual debe supara 1 al valor del servicio
			******************************************************************************************************************/

			$resOrgOtroServicio = query($sqlOrgOtroServicio);

			$numFilasOrgOtroServicio = mysql_num_rows($resOrgOtroServicio);
			if($numFilasOrgOtroServicio >= 1)
			{
				$orgServicios[$orgCodYServicios[$i + 1] - 1]++;
			}			
		}
		
	}

	//Se guarda la suma total en la ultima posicion del array
	$orgServicios[4] = $orgServicios[0] + $orgServicios[1] + $orgServicios[2] + $orgServicios[3]; 

	//Porcentaje de meta mensual y anual
	$metaMensual = round(($orgServicios[4] * 100) / $metaMes, 2);
	$metaAnio = round(($orgServicios[4] * 100) / $metaAnual, 2);

	/*echo "<br>Servicios<br>";
	print_r2($orgServicios);
	echo "<br>Servicios<br>";*/

	//IMPRESION DE RESULATDOS	

	/*<tr>
				<th>INDICADORES</th>
				<th>Asesoría para la elaboración de planes de negocio solidarios</th>
				<th>Cofinanciamiento para proyectos de la EPS</th>
				<th>Asistencia técnica en procesos administrativos</th>
				<th>Alianza con instituciones para la AT en procesos operativos</th>
				<th>Total</th>
				<th class='total'>Meta Periodo</th>
				<th>% Ejecutado</th>
				<th>Meta Anual</th>
				<th>%Avance</th>
				<th>Zona</th>
				<th>Mes</th>
			</tr>*/

	
	$tabla .= "<tr>
			<td>" . $nombresIndicadores[2] . "</td>
			<td>" . $orgServicios[0] . "</td>
			<td>" . $orgServicios[1] . "</td>
			<td>" . $orgServicios[2] . "</td>
			<td>" . $orgServicios[3] . "</td>
			<td class = 'total'>" . $orgServicios[4] . "</td>			
			<td>" . $metaMes . "</td>
			<td>" . $metaMensual . "%</td>
			<td>" . $metaAnual . "</td>
			<td>" . $metaAnio . "%</td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
		</tr>";
}

function Indicador04($zona, $mes)
{
	global $tabla, $nombresIndicadores;	
	
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

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== CUARTO INDICADOR =======================*/
	/*NÚMERO DE CIRCUITOS ECONÓMICOS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DFP*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, 13);
	$metaAnual = MetaAnio($zona, $mes, 13);

	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and u.circuito_economico = 'si' and fp.documentacion_valida = 'si' group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_registro from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and u.circuito_economico = 'si' and fp.documentacion_valida = 'si' order by fp.fecha_registro asc limit 1";

		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
		}		
	}

	/*echo "<br>Organizaciones<br>";
	print_r2($orgCodYServicios);
	echo "<br>Organizaciones<br>";*/


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 2)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and fp.documentacion_valida = 'si' and u.circuito_economico = 'si' and fp.fecha_registro < '" . $fechaConsultar . "'" ;

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
			$sqlOrgOtroServicio = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio <> " . $orgCodYServicios[$i + 1] . " and u.circuito_economico = 'si' and fp.documentacion_valida = 'si' and fp.fecha_registro < '" . $fechaConsultar . "'";

			//echo $sqlOrgOtroServicio . "<br>";

			/*****************************************************************************************************************
			- Se puede tener dos resultados:
			-- Si existe registros anteriores con otro codigo de servicio, esta organizacion es antigua y no debe sumar al indicador.
			-- Si no existe ningun otro codigo, esta organizacion es nueva y es su primera vez tomando un servicio de Fomento Productivo, por lo cual debe supara 1 al valor del servicio
			******************************************************************************************************************/

			$resOrgOtroServicio = query($sqlOrgOtroServicio);

			$numFilasOrgOtroServicio = mysql_num_rows($resOrgOtroServicio);
			if($numFilasOrgOtroServicio >= 1)
			{
				$orgServicios[$orgCodYServicios[$i + 1] - 1]++;
			}			
		}
		
	}

	//Se guarda la suma total en la ultima posicion del array
	$orgServicios[4] = $orgServicios[0] + $orgServicios[1] + $orgServicios[2] + $orgServicios[3]; 

	//Porcentaje de meta mensual y anual
	$metaMensual = round(($orgServicios[4] * 100) / $metaMes, 2);
	$metaAnio = round(($orgServicios[4] * 100) / $metaAnual, 2);

	/*echo "<br>Servicios<br>";
	print_r2($orgServicios);
	echo "<br>Servicios<br>";*/

	//IMPRESION DE RESULATDOS	

	/*<tr>
				<th>INDICADORES</th>
				<th>Asesoría para la elaboración de planes de negocio solidarios</th>
				<th>Cofinanciamiento para proyectos de la EPS</th>
				<th>Asistencia técnica en procesos administrativos</th>
				<th>Alianza con instituciones para la AT en procesos operativos</th>
				<th>Total</th>
				<th class='total'>Meta Periodo</th>
				<th>% Ejecutado</th>
				<th>Meta Anual</th>
				<th>%Avance</th>
				<th>Zona</th>
				<th>Mes</th>
			</tr>*/

	
	$tabla .= "<tr>
			<td>" . $nombresIndicadores[3] . "</td>
			<td>" . $orgServicios[0] . "</td>
			<td>" . $orgServicios[1] . "</td>
			<td>" . $orgServicios[2] . "</td>
			<td>" . $orgServicios[3] . "</td>
			<td class = 'total'>" . $orgServicios[4] . "</td>			
			<td>" . $metaMes . "</td>
			<td>" . $metaMensual . "%</td>
			<td>" . $metaAnual . "</td>
			<td>" . $metaAnio . "%</td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
		</tr>";



}

function Indicador05($zona, $mes)
{
	global $tabla, $nombresIndicadores;	
	
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
	$numSocios = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== QUINTO INDICADOR =======================*/
	/*NÚMERO DE PERSONAS DE LA EPS QUE ACCEDEN A PLAZAS DE TRABAJO A TRAVÉS DE COFINANCIAMIENTO*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, 14);
	$metaAnual = MetaAnio($zona, $mes, 14);

	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_servicio = 2 and fp.documentacion_valida = 'si' group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_registro, fp.cod_asesoria_asistencia_cofinanciamiento from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and fp.cod_servicio = 2 and fp.documentacion_valida = 'si' order by fp.fecha_registro asc limit 1";

		//echo $sqlPrimerRegistroOrg . "<br>";
		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_asesoria_asistencia_cofinanciamiento']);
		}		
	}

	/*echo "<br>Organizaciones<br>";
	print_r2($orgCodYServicios);
	echo "<br>Organizaciones<br>";*/


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 2)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.documentacion_valida = 'si' and fp.cod_servicio = 2 and fp.fecha_registro < '" . $fechaConsultar . "'" ;

		//echo $sqlOrgServAnteriores . "***<br>";
		
		$resSqlOrgServAnteriores = query($sqlOrgServAnteriores);

		$numFilas = mysql_num_rows($resSqlOrgServAnteriores);
		//echo "numero de filas= " . $numFilas . "<br>";

		/************************************************************************************************************
		- Si el numero de Filas es mayor a cero quiere decir q es una organizacion vieja q ya a recibido el servicio
		- Si el numero de filas es cero, quiere decir que es la primera vez que se registra el servicio por lo cual hay que contar los socios de la organizacion.		
		************************************************************************************************************/

		if($numFilas == 0)
		{
			$sqlOrgOtroServicio = "select fp.num_personas_cofinanciamiento from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (fp.cod_u_organizaciones = u.cod_u_organizaciones) where fp.cod_asesoria_asistencia_cofinanciamiento = " . $orgCodYServicios[$i + 1];

			//echo $sqlOrgOtroServicio . "<br>";

			/*****************************************************************************************************************
			- Se puede tener dos resultados:
			-- Si existe registros anteriores con otro codigo de servicio, esta organizacion es antigua y no debe sumar al indicador.
			-- Si no existe ningun otro codigo, esta organizacion es nueva y es su primera vez tomando un servicio de Fomento Productivo, por lo cual debe supara 1 al valor del servicio
			******************************************************************************************************************/

			$resOrgOtroServicio = query($sqlOrgOtroServicio);

			while($fila = mysql_fetch_array($resOrgOtroServicio))
			{
				$orgServicios[1] += $fila['num_personas_cofinanciamiento'];
			}			
		}
		
	}

	//Se guarda la suma total en la ultima posicion del array
	$orgServicios[4] = $orgServicios[0] + $orgServicios[1] + $orgServicios[2] + $orgServicios[3]; 

	//Porcentaje de meta mensual y anual
	$metaMensual = round(($orgServicios[4] * 100) / $metaMes, 2);
	$metaAnio = round(($orgServicios[4] * 100) / $metaAnual, 2);

	/*echo "<br>Servicios<br>";
	print_r2($orgServicios);
	echo "<br>Servicios<br>";*/

	//IMPRESION DE RESULATDOS	

	/*<tr>
				<th>INDICADORES</th>
				<th>Asesoría para la elaboración de planes de negocio solidarios</th>
				<th>Cofinanciamiento para proyectos de la EPS</th>
				<th>Asistencia técnica en procesos administrativos</th>
				<th>Alianza con instituciones para la AT en procesos operativos</th>
				<th>Total</th>
				<th class='total'>Meta Periodo</th>
				<th>% Ejecutado</th>
				<th>Meta Anual</th>
				<th>%Avance</th>
				<th>Zona</th>
				<th>Mes</th>
			</tr>*/

	
	$tabla .= "<tr>
			<td>" . $nombresIndicadores[4] . "</td>
			<td>" . $orgServicios[0] . "</td>
			<td>" . $orgServicios[1] . "</td>
			<td>" . $orgServicios[2] . "</td>
			<td>" . $orgServicios[3] . "</td>
			<td class = 'total'>" . $orgServicios[4] . "</td>			
			<td>" . $metaMes . "</td>
			<td>" . $metaMensual . "%</td>
			<td>" . $metaAnual . "</td>
			<td>" . $metaAnio . "%</td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
		</tr>";
}

function Indicador06($zona, $mes)
{
	global $tabla, $nombresIndicadores;	
	
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

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 
	$fechaInicial = $anioInd .'-01-01';

	/*=========== SEXTO INDICADOR =======================*/
	/*NÚMERO DE PERSONAS DE LA EPS QUE ACCEDEN AL MENOS A UN SERVICIO DE LA DFP ENMARCADOS EN LA ESTRATEGIA DEL CAMBIO EN LA MATRIZ PRODUCTIVA*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, 15);
	$metaAnual = MetaAnio($zona, $mes, 15);

	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and u.categoria_actividad_mp <> 'no_priorizado_en_el_cambio_matriz_productiva' and fp.documentacion_valida = 'si' and fp.cod_servicio <> 1 group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_registro, fp.cod_asesoria_asistencia_cofinanciamiento from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and u.categoria_actividad_mp <> 'no_priorizado_en_el_cambio_matriz_productiva' and fp.cod_servicio <> 1 and fp.documentacion_valida = 'si' order by fp.fecha_registro asc limit 1";

		//echo $sqlPrimerRegistroOrg . "<br>";

		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_asesoria_asistencia_cofinanciamiento']);
		}		
	}

	/*echo "<br>Organizaciones<br>";
	print_r2($orgCodYServicios);
	echo "<br>Organizaciones<br>";*/


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 3)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and fp.documentacion_valida = 'si' and fp.fecha_registro >= '" . $fechaInicial ."' and fp.fecha_registro < '" . $fechaConsultar . "'" ;

		//echo $sqlOrgServAnteriores . "***<br>";
		
		$resSqlOrgServAnteriores = query($sqlOrgServAnteriores);

		$numFilas = mysql_num_rows($resSqlOrgServAnteriores);
		//echo "numero de filas= " . $numFilas . "<br>";

		/************************************************************************************************************
		- Si el numero de Filas es mayor a cero quiere decir q es una organizacion vieja q ya a recibido el servicio y las personas beneficiadas no deben ser contadas
		- Si el numero de filas es cero, debemos sumar las personas beneficiadas.		
		************************************************************************************************************/

		if($numFilas == 0)
		{
			$sqlOrgOtroServicio = "select fp.num_per_urbanas, fp.num_per_rurales from fp_asesoria_asistencia_cofinanciamiento fp where fp.cod_asesoria_asistencia_cofinanciamiento = " . $orgCodYServicios[$i + 2];

			//echo $sqlOrgOtroServicio . "<br>";

			/*****************************************************************************************************************
			- Se puede tener dos resultados:
			-- Si existe registros anteriores con otro codigo de servicio, esta organizacion es antigua y no debe sumar al indicador.
			-- Si no existe ningun otro codigo, esta organizacion es nueva y es su primera vez tomando un servicio de Fomento Productivo, por lo cual debe supara 1 al valor del servicio
			******************************************************************************************************************/

			$resOrgOtroServicio = query($sqlOrgOtroServicio);

			while($fila = mysql_fetch_array($resOrgOtroServicio))
			{
				$orgServicios[$orgCodYServicios[$i + 1] - 1] += $fila['num_per_rurales'] + $fila['num_per_urbanas'];	
			}
			
						
		}
		
	}

	//Se guarda la suma total en la ultima posicion del array
	$orgServicios[4] = $orgServicios[0] + $orgServicios[1] + $orgServicios[2] + $orgServicios[3]; 

	//Porcentaje de meta mensual y anual
	$metaMensual = round(($orgServicios[4] * 100) / $metaMes, 2);
	$metaAnio = round(($orgServicios[4] * 100) / $metaAnual, 2);

	/*echo "<br>Servicios<br>";
	print_r2($orgServicios);
	echo "<br>Servicios<br>";*/

	//IMPRESION DE RESULATDOS	

	/*<tr>
				<th>INDICADORES</th>
				<th>Asesoría para la elaboración de planes de negocio solidarios</th>
				<th>Cofinanciamiento para proyectos de la EPS</th>
				<th>Asistencia técnica en procesos administrativos</th>
				<th>Alianza con instituciones para la AT en procesos operativos</th>
				<th>Total</th>
				<th class='total'>Meta Periodo</th>
				<th>% Ejecutado</th>
				<th>Meta Anual</th>
				<th>%Avance</th>
				<th>Zona</th>
				<th>Mes</th>
			</tr>*/

	
	$tabla .= "<tr>
			<td>" . $nombresIndicadores[5] . "</td>
			<td>" . $orgServicios[0] . "</td>
			<td>" . $orgServicios[1] . "</td>
			<td>" . $orgServicios[2] . "</td>
			<td>" . $orgServicios[3] . "</td>
			<td class = 'total'>" . $orgServicios[4] . "</td>			
			<td>" . $metaMes . "</td>
			<td>" . $metaMensual . "%</td>
			<td>" . $metaAnual . "</td>
			<td>" . $metaAnio . "%</td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
		</tr>";

}

function Indicador07($zona, $mes)
{
	global $tabla, $nombresIndicadores;	
	
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

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== SEPTIMO INDICADOR =======================*/
	/*NÚMERO DE ORGANIZACIONES QUE HAN RECIBIDO PROCESOS DE ASISTENCIA TÉCNICA*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, 16);
	$metaAnual = MetaAnio($zona, $mes, 16);

	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.cod_servicio <> 1 and fp.cod_servicio <> 2 group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_registro from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_registro) = " . $mesInd ." and year(fp.fecha_registro) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and u.tipo = 'org'  and fp.cod_servicio <> 1 and fp.documentacion_valida = 'si' and fp.cod_servicio <> 2 order by fp.fecha_registro asc limit 1";



		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
		}		
	}

	/*echo "<br>Organizaciones<br>";
	print_r2($orgCodYServicios);
	echo "<br>Organizaciones<br>";*/


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 2)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and u.tipo = 'org' and fp.fecha_registro > '" . $fechaInicial . "' and fp.documentacion_valida = 'si' and fp.fecha_registro < '" . $fechaConsultar . "'" ;

		//echo $sqlOrgServAnteriores . "***<br>";
		
		$resSqlOrgServAnteriores = query($sqlOrgServAnteriores);

		$numFilas = mysql_num_rows($resSqlOrgServAnteriores);
		//echo "numero de filas= " . $numFilas . "<br>";

		/************************************************************************************************************
		- Si el numero de Filas es mayor a cero quiere decir q es una organizacion vieja q ya a recibido el servicio
		- Si el numero de filas es cero quiere decir que en este mes es la primera vez que tiene el servicio.		
		************************************************************************************************************/

		if($numFilas == 0)
		{
			
			$orgServicios[$orgCodYServicios[$i + 1] - 1]++;
						
		}
		
	}

	//Se guarda la suma total en la ultima posicion del array
	$orgServicios[4] = $orgServicios[0] + $orgServicios[1] + $orgServicios[2] + $orgServicios[3]; 

	//Porcentaje de meta mensual y anual
	$metaMensual = round(($orgServicios[4] * 100) / $metaMes, 2);
	$metaAnio = round(($orgServicios[4] * 100) / $metaAnual, 2);

	/*echo "<br>Servicios<br>";
	print_r2($orgServicios);
	echo "<br>Servicios<br>";*/

	//IMPRESION DE RESULATDOS	

	/*<tr>
				<th>INDICADORES</th>
				<th>Asesoría para la elaboración de planes de negocio solidarios</th>
				<th>Cofinanciamiento para proyectos de la EPS</th>
				<th>Asistencia técnica en procesos administrativos</th>
				<th>Alianza con instituciones para la AT en procesos operativos</th>
				<th>Total</th>
				<th class='total'>Meta Periodo</th>
				<th>% Ejecutado</th>
				<th>Meta Anual</th>
				<th>%Avance</th>
				<th>Zona</th>
				<th>Mes</th>
			</tr>*/

	
	$tabla .= "<tr>
			<td>" . $nombresIndicadores[6] . "</td>
			<td>" . $orgServicios[0] . "</td>
			<td>" . $orgServicios[1] . "</td>
			<td>" . $orgServicios[2] . "</td>
			<td>" . $orgServicios[3] . "</td>
			<td class = 'total'>" . $orgServicios[4] . "</td>			
			<td>" . $metaMes . "</td>
			<td>" . $metaMensual . "%</td>
			<td>" . $metaAnual . "</td>
			<td>" . $metaAnio . "%</td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
		</tr>";	
	
}

function print_r2($val)
{
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}





?>