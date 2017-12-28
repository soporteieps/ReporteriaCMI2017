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
				<th colspan='7' class='colorIndicador1'>CUMPLIMIENTO</th>
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
				<th class='colorIndicador1'>Detalles</th>
			</tr>";

//Indicadores
$nombresIndicadores = array();
$codIndicadores = array();
/*$nombresIndicadores = array('NÚMERO DE ORGANIZACIONES DE LA EPS QUE RECIBIERON OTRO SERVICIO DE LA DIRECCIÓN DE FOMENTO PRODUCTIVO',
		'NÚMERO DE NUEVAS ORGANIZACIONES DE LA EPS QUE RECIBIERON AL MENOS UN SERVICIO DE LA DIRECCIÓN DE FOMENTO PRODUCTIVO',
		'NÚMERO DE UNIDADES ECONÓMICAS Y SOLIDARIAS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DFP',
		'NÚMERO DE CIRCUITOS ECONÓMICOS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DFP',
		'NÚMERO DE PERSONAS DE LA EPS QUE ACCEDEN A PLAZAS DE TRABAJO A TRAVÉS DE COFINANCIAMIENTO',
		'NÚMERO DE PERSONAS DE LA EPS QUE ACCEDEN AL MENOS A UN SERVICIO DE LA DFP ENMARCADOS EN LA ESTRATEGIA DEL CAMBIO EN LA MATRIZ PRODUCTIVA',
		'NÚMERO DE ORGANIZACIONES QUE HAN RECIBIDO PROCESOS DE ASISTENCIA TÉCNICA');*/


function getNombresIndicadores()
{
	global $codIndicadores;
	$auxNombresIndicadores = array();
	$sqlNombresInd = "select indicador, cod_indicador from indicador where estado = 1 and departamento = 'FP' order by cod_indicador";
	$resSqlNombreInd = query($sqlNombresInd);
	while($fila = mysql_fetch_array($resSqlNombreInd))
	{
		array_push($auxNombresIndicadores, $fila['indicador']);
		array_push($codIndicadores, $fila['cod_indicador']);
	}
	return $auxNombresIndicadores;
}

//Tomamos los nombres de los indicadores
$nombresIndicadores = getNombresIndicadores();

// echo $idZona . " - " . $idMes . " - " . $idIndicador . "<br>";

//Dependiendo de la eleccion que se haga, imprimira los resultados
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
			if($j == 3 || $j == 6 || $j == 9 || $j == 12) 
			{
				Indicador07($i, $j);
			}
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
		if($i == 3 || $i == 6 || $i == 9 || $i == 12)
		{
			Indicador07($idZona, $i);
		}
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
		if($idMes == 3 || $idMes == 6 || $idMes == 9 || $idMes == 12)
		{
			Indicador07($i, $idMes);
		}
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
		    if(($idIndicador == 16) && ($j == 3 || $j == 6 || $j == 9 || $j == 12))
		    {
		    	Indicador07($i, $j);		    
		    }
		}
	}
}

//Si ha elegido la zona y el mes pero no el Indicador
if($idZona != -1 && $idMes != -1 && $idIndicador == -1)
{
	// echo "her<br>";
	Indicador01($idZona, $idMes);
	Indicador02($idZona, $idMes);
	Indicador03($idZona, $idMes);
	Indicador04($idZona, $idMes);
	Indicador05($idZona, $idMes);
	Indicador06($idZona, $idMes);	
	if($idMes == 3 || $idMes == 6 || $idMes == 9 || $idMes == 12)
	{
		Indicador07($idZona, $idMes);
	}
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
	    if(($idIndicador == 16) && ($i == 3 || $i == 6 || $i == 9 || $i == 12))
	    {
	    	Indicador07($idZona, $i);	    
	    }
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
	    if(($idIndicador == 16) && ($idMes == 3 || $idMes == 6 || $idMes == 9 || $idMes == 12))
	    {
	    	Indicador07($i, $idMes);
	    }
	    
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
    if(($idIndicador == 16) && ($idMes == 3 || $idMes == 6 || $idMes == 9 || $idMes == 12))
    {
    	Indicador07($idZona, $idMes);	
    }
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

	//echo $sqlMetaProgramada . "<br>";

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

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== PRIMER INDICADOR =======================*/
	/*NUMERO DE ORGANIZACIONES DE LA EPS QUE RECIBIERON  OTRO SERVICIO DE LA DIRECCION DE FOMENTO PRODUCTIVO*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadores[0]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadores[0]);	

	


	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.antiguedad = 'si'  group by fp.cod_u_organizaciones";

	// echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_reporte from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.antiguedad = 'si' order by fp.fecha_reporte asc limit 1";

		//echo $sqlPrimerRegistroOrg . "<br>";
		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
		}		
	}

	// echo "<br>Organizaciones<br>";
	// print_r2($orgCodYServicios);
	// echo "<br>Organizaciones<br>";


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 2)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.antiguedad = 'si' and fp.fecha_reporte < '" . $fechaConsultar . "'" ;

		// echo $sqlOrgServAnteriores . "<br>";
		
		$resSqlOrgServAnteriores = query($sqlOrgServAnteriores);

		$numFilas = mysql_num_rows($resSqlOrgServAnteriores);
		// echo "numero de filas= " . $numFilas . "<br>";

		/************************************************************************************************************
		- Si el numero de Filas es mayor a cero quiere decir q es una organizacion vieja q ya a recibido el servicio
		- Si el numero de filas es cero, debemos realizar un ultimo control, que es revisar si la organizacion ha recibido otro servicio, lo cual debera registrarse en la posicion del array de OrganizacionesServicios($orgServicios).		
		************************************************************************************************************/

		if($numFilas == 0)
		{

			// Esta sentencia comprueba si la organizacion ya fue reportada
			// Por solicitud de 27-12-2017 se deshabilita este control
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
				$orgServicios[$orgCodYServicios[$i + 1] - 1]++;
			// }			
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
			<td><a href='../../clases/detalleFomento.php?anio=" . $anioInd . "&indicador=" . $codIndicadores[0] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";	
	
	
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

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== SEGUNDO INDICADOR =======================*/
	/*NÚMERO DE NUEVAS ORGANIZACIONES DE LA EPS QUE RECIBIERON AL MENOS UN SERVICIO DE LA DIRECCIÓN DE FOMENTO PRODUCTIVO*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadores[1]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadores[1]);	

	


	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.antiguedad = 'no' group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_reporte from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.antiguedad = 'no' order by fp.fecha_reporte asc limit 1";

		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
		}		
	}

	// echo "<br>Organizaciones<br>";
	// print_r2($orgCodYServicios);
	// echo "<br>Organizaciones<br>";


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 2)
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
			// Esta sentencia controla que la organizacion no sea reportada dos veces
			// Se pide deshabilitar este control el 27-12-2017
			
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
				$orgServicios[$orgCodYServicios[$i + 1] - 1]++;
			// }			
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
			<td><a href='../../clases/detalleFomento.php?anio=" . $anioInd . "&indicador=" . $codIndicadores[1] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";

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
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== TERCER INDICADOR =======================*/
	/*'NÚMERO DE UNIDADES ECONÓMICAS Y SOLIDARIAS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DFP*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadores[2]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadores[2]);	

	


	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.documentacion_valida = 'si' and u.tipo = 'uep' group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_reporte from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and fp.documentacion_valida = 'si' and u.tipo = 'uep'  order by fp.fecha_reporte asc limit 1";

		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
		}		
	}

	// echo "<br>Organizaciones<br>";
	// print_r2($orgCodYServicios);
	// echo "<br>Organizaciones<br>";


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 2)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and u.tipo = 'uep' and fp.documentacion_valida = 'si' and fp.fecha_reporte < '" . $fechaConsultar . "'" ;

		//echo $sqlOrgServAnteriores . "***<br>";
		
		$resSqlOrgServAnteriores = query($sqlOrgServAnteriores);

		$numFilas = mysql_num_rows($resSqlOrgServAnteriores);
		// echo "numero de filas= " . $numFilas . "<br>";

		/************************************************************************************************************
		- Si el numero de Filas es mayor a cero quiere decir q es una uep vieja q ya a recibido el servicio
		- Si el numero de filas es cero, debemos realizar un ultimo control, que es revisar si la organizacion ha recibido otro servicio, lo cual debera registrarse en la posicion del array de OrganizacionesServicios($orgServicios).		
		************************************************************************************************************/

		if($numFilas == 0)
		{
			$sqlOrgOtroServicio = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and u.tipo = 'uep' and fp.documentacion_valida = 'si' and fp.fecha_registro < '" . $fechaConsultar . "'";

			// echo $sqlOrgOtroServicio . "<br>";

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

	// echo "<br>Servicios<br>";
	// print_r2($orgServicios);
	// echo "<br>Servicios<br>";

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
			<td><a href='../../clases/detalleFomento.php?anio=" . $anioInd . "&indicador=" . $codIndicadores[2] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";

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
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== CUARTO INDICADOR =======================*/
	/*NÚMERO DE CIRCUITOS ECONÓMICOS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DFP*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadores[3]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadores[3]);

	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and u.circuito_economico = 'si' and fp.documentacion_valida = 'si' group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_reporte from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and u.circuito_economico = 'si' and fp.documentacion_valida = 'si' order by fp.fecha_reporte asc limit 1";

		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
		}		
	}

	// echo "<br>Organizaciones<br>";
	// print_r2($orgCodYServicios);
	// echo "<br>Organizaciones<br>";


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 2)
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
			<td><a href='../../clases/detalleFomento.php?anio=" . $anioInd . "&indicador=" . $codIndicadores[3] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";



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

	$metaMes = MetaMensual($zona, $mes, $codIndicadores[4]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadores[4]);

	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_servicio = 2 and fp.documentacion_valida = 'si' group by fp.cod_u_organizaciones";

	//echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_reporte, fp.cod_asesoria_asistencia_cofinanciamiento from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) = " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and fp.cod_servicio = 2 and fp.documentacion_valida = 'si' order by fp.fecha_reporte asc limit 1";

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

	// arrays para cada servicio
	$sociosServicio1 = array();
	$sociosServicio2 = array();
	$sociosServicio3 = array();
	$sociosServicio4 = array();
	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 2)
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

			$sqlNumPersonas = "select cedula from fp_asesoria_asistencia_cofinanciamiento_socios where cod_fp_asesoria_asistencia_cofinanciamiento = " . $orgCodYServicios[$i + 1] . " and cod_u_organizaciones = " . $orgCodYServicios[$i];

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

	



	// print_r2($sociosServicio1);
	// print_r2($sociosServicio2);
	// print_r2($sociosServicio3);
	// print_r2($sociosServicio4);

	// Guardo el numero de plazas de trabajo accedidos por cofinanciamiento
	$orgServicios[1] = count($sociosServicio2);

	// Sumamos las personas beneficiadas para cdh
	$sqlSumPersonasCdh = "select sum(num_per_benef_cdh) as suma from fp_asesoria_asistencia_cofinanciamiento where month(fecha_reporte) = " . $mesInd . " and documentacion_valida = 'si' and year(fecha_reporte) = " . $anioInd . " and zona = " . $zonaInd;

	$resSumPersonasCdh = query($sqlSumPersonasCdh);
	$sumPersonasCdh = 0;
	while($fila = mysql_fetch_array($resSumPersonasCdh))
	{
		$sumPersonasCdh = $fila['suma'];
	}

	$orgServicios[1] += $sumPersonasCdh;

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
			<td><a href='../../clases/detalleFomento.php?anio=" . $anioInd . "&indicador=" . $codIndicadores[4] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";
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
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 
	$fechaInicial = $anioInd .'-01-01';

	/*=========== SEXTO INDICADOR =======================*/
	/*NÚMERO DE PERSONAS DE LA EPS QUE ACCEDEN AL MENOS A UN SERVICIO DE LA DFP ENMARCADOS EN LA ESTRATEGIA DEL CAMBIO EN LA MATRIZ PRODUCTIVA*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadores[5]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadores[5]);

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
		}		
	}

	// echo "<br>Organizaciones<br>";
	// print_r2($orgCodYServicios);
	// echo "<br>Organizaciones<br>";


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	$sociosServicio1 = array();
	$sociosServicio2 = array();
	$sociosServicio3 = array();
	$sociosServicio4 = array();
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 3)
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
				if($orgCodYServicios[$i + 1] == 1)
				{
					array_push($sociosServicio1, $fila['cedula']);
				}
				if($orgCodYServicios[$i + 1] == 2)
				{
					array_push($sociosServicio2, $fila['cedula']);
				}
				if($orgCodYServicios[$i + 1] == 3)
				{
					array_push($sociosServicio3, $fila['cedula']);
				}
				if($orgCodYServicios[$i + 1] == 4)
				{
					array_push($sociosServicio4, $fila['cedula']);
				}
				
			}	
			
						
		// }
		
	}

	if(count($sociosServicio1) > 0)
	{
		$sociosServicio1 = array_unique($sociosServicio1);
		$sociosServicio1 = array_values($sociosServicio1);
	}

	if(count($sociosServicio2) > 0)
	{
		$sociosServicio2 = array_unique($sociosServicio2);
		$sociosServicio2 = array_values($sociosServicio2);
	}

	if(count($sociosServicio3) > 0)
	{
		$sociosServicio3 = array_unique($sociosServicio3);
		$sociosServicio3 = array_values($sociosServicio3);
	}

	if(count($sociosServicio4) > 0)
	{
		$sociosServicio4 = array_unique($sociosServicio4);
		$sociosServicio4 = array_values($sociosServicio4);
	}

	// print_r2($sociosServicio1);
	// print_r2($sociosServicio2);
	// print_r2($sociosServicio3);
	// print_r2($sociosServicio4);


	// Se debe 

	//Se guarda la suma total en la ultima posicion del array
	// $orgServicios[4] = $orgServicios[0] + $orgServicios[1] + $orgServicios[2] + $orgServicios[3];
	$orgServicios[0] = count($sociosServicio1);
	$orgServicios[1] = count($sociosServicio2);
	$orgServicios[2] = count($sociosServicio3);
	$orgServicios[3] = count($sociosServicio4);

	//*****************************************
	// Cambio solicitado por MÓNICA PLATZER
	// if($zonaInd == 6 and $mesInd == 1)
	// {
	// 	$orgServicios[0] += 18;
	// }
	//*****************************************

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
			<td><a href='../../clases/detalleFomento.php?anio=" . $anioInd . "&indicador=" . $codIndicadores[5] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";

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
	$fechaInicial = $anioInd .'-01-01';
	$mesInicial = $mesInd - 2;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== SEPTIMO INDICADOR =======================*/
	/*NÚMERO DE ORGANIZACIONES QUE HAN RECIBIDO PROCESOS DE ASISTENCIA TÉCNICA*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadores[6]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadores[6]);



	//sql que consulta las organizaciones en el mes indicado
	$sqlOrgReportadaMes = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) >= " . $mesInicial . " and month(fp.fecha_reporte) <= " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.cod_servicio = 3 group by fp.cod_u_organizaciones";

	// echo $sqlOrgReportadaMes . "<br>";

	
	//ejecucion del sql
	$resSqlOrgReportadasMes = query($sqlOrgReportadaMes);
	while($fila = mysql_fetch_array($resSqlOrgReportadasMes))
	{
		// se necesita, si fuera el caso, el primer registro correspondiente a la organizacion
		$sqlPrimerRegistroOrg = "select fp.cod_u_organizaciones, fp.cod_servicio, fp.fecha_reporte from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where month(fp.fecha_reporte) >= " . $mesInicial . " and month(fp.fecha_reporte) <= " . $mesInd ." and year(fp.fecha_reporte) = " . $anioInd . " and fp.zona = " . $zonaInd ." and fp.cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and u.tipo = 'org' and fp.documentacion_valida = 'si' and fp.cod_servicio = 3  order by fp.fecha_reporte asc limit 1";

		// echo $sqlPrimerRegistroOrg . "<br>";

		//guardo los datos en un array
		$resPrimerRegistroOrg = query($sqlPrimerRegistroOrg);
		while($fPrimerRegistro = mysql_fetch_array($resPrimerRegistroOrg))
		{
			array_push($orgCodYServicios, $fPrimerRegistro['cod_u_organizaciones']);
			array_push($orgCodYServicios, $fPrimerRegistro['cod_servicio']);
		}		
	}

	// echo "<br>Organizaciones<br>";
	// print_r2($orgCodYServicios);
	// echo "<br>Organizaciones<br>";


	//Se revisa si esta organizacion ya tuvo registrado el servicio en fechas anteriores
	for($i = 0; $i < count($orgCodYServicios); $i = $i + 2)
	{
		$sqlOrgServAnteriores = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp inner join u_organizaciones u on (u.cod_u_organizaciones = fp.cod_u_organizaciones) where fp.cod_u_organizaciones = " . $orgCodYServicios[$i] . " and fp.cod_servicio = " . $orgCodYServicios[$i + 1] . " and u.tipo = 'org' and fp.fecha_reporte > '" . $fechaInicial . "' and fp.documentacion_valida = 'si' and month(fp.fecha_reporte) < " . $mesInicial;

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
			<td><a href='../../clases/detalleFomento.php?anio=" . $anioInd . "&indicador=" . $codIndicadores[6] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";	
	
}

function print_r2($val)
{
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}





?>