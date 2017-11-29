<?php
include '../lib/dbconfig.php';

//tomo los datos enviados
//print_r($_SESSION);
$idIndicador = $_POST['idIndicador'];
$idZona = $_POST['idZona'];
$idMes = $_POST['idMes'];
$nombresMes  = array('ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC');

$tabla = "<table id='tablaResultado'>
			<tr>				
				<th colspan='2' class='colorBlanco'></th>
				<th colspan='12' class='colorIndicador_im1'>DIRECCIÓN TÉCNICA ZONAL " . $idZona . "</th>
			</tr>
			<tr>
				<th class='colorIndicador_im'>NUMERACIÓN GPR DEL INDICADOR</th>
				<th class='colorIndicador_im'>NOMBRES DE LOS INDICADORES (Misma denominación que consta en GPR y Fichas Técnicas)</th>
				<th class='colorIndicador_im'>META MENSUAL PROGRAMADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador_im'>META MENSUAL EJECUTADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador_im'>% DE AVANCE MENSUAL (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador_im1'>META PROGRAMADA (ENE-DIC)</th>
				<th class='colorIndicador_im1'>META ACUMULADA PROGRAMADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador_im1'>META ACUMULADA EJECUTADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador_im1'>% AVANCE (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador_im1'>% AVANCE (ANUAL)</th>
				<th class='colorIndicador_im1'>JUSTIFICACIÓN SOBRECUMPLIMIENTO O NO CUMPLIMIENTO</th>
				<th class='colorIndicador_im1'>Zona</th>
				<th class='colorIndicador_im1'>Mes</th>
				<th class='colorIndicador_im1' target='_blank'>Detalles</th>
			</tr>";

//Indicadores

$sqlInd = "select cod_indicador, indicador from indicador where estado = 1 and departamento = 'IM' order by cod_indicador";
$resSqlInd = query($sqlInd);
$nombresIndicadores = array();
$codIndicadoresArray = array();

while($fila = mysql_fetch_array($resSqlInd))
{
	array_push($nombresIndicadores, $fila['indicador']);
	array_push($codIndicadoresArray, $fila['cod_indicador']);
}

//print_r2($codIndicadoresArray);
/*$nombresIndicadores = array('MONTO EN VENTAS DE ORGANIZACIONES EPS Y UEPS AL MERCADO PÚBLICO',
		'MONTO EN VENTAS DE ORGANIZACIONES EPS Y UEPS AL MERCADO PRIVADO',
		'NÚMERO DE ORGANIZACIONES DE LA EPS QUE RECIBIERON AL MENOS UN SERVICIO DE LA DIRECCIÓN DE INTERCAMBIO Y MERCADOS',
		'NÚMERO DE UNIDADES ECONÓMICAS POPULARES - UEPS QUE RECIBIERON AL MENOS UN SERVICIO DIRECCIÓN DE INTERCAMBIO Y MERCADOS',
		'NÚMERO DE PERSONAS QUE CONFORMAN LAS ORGANIZACIONES Y UEPS QUE HAN RECIBIDO AL MENOS UN SERVICIO DE LA DIM Y SE ENMARCAN EN LA ESTRATEGIA PARA EL CAMBIO DE LA MATRIZ PRODUCTIVA',
		'NÚMERO DE CIRCUITOS ECONÓMICOS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DIRECCIÓN DE INTERCAMBIO Y MERCADOS',
		'NÚMERO DE PERSONAS DE LA EPS CON PLAZAS DE TRABAJO POR ACCESO PÚBLICO O PRIVADO',
		'NÚMERO DE NUEVAS ORGANIZACIONES DE LA EPS QUE RECIBIERON AL MENOS UN SERVICIO DE LA DIRECCIÓN DE INTERCAMBIO Y MERCADOS', 'NÚMERO DE ORGANIZACIONES QUE RECIBEN UN SERVICIO DE LA DIRECCIÓN DE INTERCAMBIO Y MERCADOS RELATIVO A COMERCIO JUSTO NACIONAL E INTERNACIONAL');*/



//Dependiendo de la eleccion que se haga, imprimera los resultados
if($idZona == -1 && $idMes == -1 && $idIndicador == -1)
{

	// echo "if 1 <br>";
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
			Indicador08($i, $j);
			//Indicador09($i, $j);
		}
	}
}

//Si ha elegido la zona pero no el mes e indicador
if($idZona != -1 && $idMes == -1 && $idIndicador == -1)
{
	// echo "if 2 <br>";
	for($i = 1; $i < 13; $i++)
	{
		Indicador01($idZona, $i);
		Indicador02($idZona, $i);
		Indicador03($idZona, $i);
		Indicador04($idZona, $i);
		Indicador05($idZona, $i);
		Indicador06($idZona, $i);
		Indicador07($idZona, $i);
		Indicador08($idZona, $i);
		//Indicador09($idZona, $i);
	}
}

//Si ha elegido el mes pero no la zona e indicador
if($idZona == -1 && $idMes != -1 && $idIndicador == -1)
{
	// echo "if 3 <br>";
	for($i = 1; $i < 10; $i++)
	{
		Indicador01($i, $idMes);
		Indicador02($i, $idMes);
		Indicador03($i, $idMes);
		Indicador04($i, $idMes);
		Indicador05($i, $idMes);
		Indicador06($i, $idMes);
		Indicador07($i, $idMes);
		Indicador08($i, $idMes);
		//Indicador09($i, $idMes);
	}
}

//Si ha elegido el indicador pero no la zona y el mes
if($idZona == -1 && $idMes == -1 && $idIndicador != -1)
{
	// echo "if 4 <br>";
	for($i = 1; $i < 10; $i++)
	{
		for($j = 1; $j < 13; $j++)
		{
		    if($idIndicador == 17)Indicador01($i, $j);
		    if($idIndicador == 18)Indicador02($i, $j);
		    if($idIndicador == 19)Indicador03($i, $j);
		    if($idIndicador == 20)Indicador04($i, $j);
		    if($idIndicador == 21)Indicador05($i, $j);
		    if($idIndicador == 22)Indicador06($i, $j);
		    if($idIndicador == 23)Indicador07($i, $j);
		    if($idIndicador == 24)Indicador08($i, $j);
		    //if($idIndicador == 25)Indicador09($i, $j);
		}
	}
}

//Si ha elegido la zona y el mes pero no el Indicador
if($idZona != -1 && $idMes != -1 && $idIndicador == -1)
{
	// echo "if 5 <br>";
	Indicador01($idZona, $idMes);
	Indicador02($idZona, $idMes);
	Indicador03($idZona, $idMes);
	Indicador04($idZona, $idMes);
	Indicador05($idZona, $idMes);
	Indicador06($idZona, $idMes);
	Indicador07($idZona, $idMes);
	Indicador08($idZona, $idMes);
	//Indicador09($idZona, $idMes);
}

//Si ha elegido la zona y el indicador pero no el mes
if($idZona != -1 && $idMes == -1 && $idIndicador != -1)
{
	// echo "if 6 <br>";
	for($i = 1; $i < 13; $i++)
	{
		if($idIndicador == 17)Indicador01($idZona, $i);
	    if($idIndicador == 18)Indicador02($idZona, $i);
	    if($idIndicador == 19)Indicador03($idZona, $i);
	    if($idIndicador == 20)Indicador04($idZona, $i);
	    if($idIndicador == 21)Indicador05($idZona, $i);
	    if($idIndicador == 22)Indicador06($idZona, $i);
	    if($idIndicador == 23)Indicador07($idZona, $i);
	    if($idIndicador == 24)Indicador08($idZona, $i);
	    //if($idIndicador == 25)Indicador09($idZona, $i);
	}
}

//Si ha elegido el mes y el indicador pero no la zona
if($idZona == -1 && $idMes != -1 && $idIndicador != -1)
{
	// echo "if 7 <br>";
	for($i = 1; $i < 10; $i++)
	{
		if($idIndicador == 17)Indicador01($i, $idMes);
	    if($idIndicador == 18)Indicador02($i, $idMes);
	    if($idIndicador == 19)Indicador03($i, $idMes);
	    if($idIndicador == 20)Indicador04($i, $idMes);
	    if($idIndicador == 21)Indicador05($i, $idMes);
	    if($idIndicador == 22)Indicador06($i, $idMes);
	    if($idIndicador == 23)Indicador07($i, $idMes);
	    if($idIndicador == 24)Indicador08($i, $idMes);
	    //if($idIndicador == 25)Indicador09($i, $idMes);
	}
}

//Si ha elegido todos los parametros
if($idZona != -1 && $idMes != -1 && $idIndicador != -1)
{	
	// echo "if 8 <br>";
	if($idIndicador == 17)Indicador01($idZona, $idMes);
    if($idIndicador == 18)Indicador02($idZona, $idMes);
    if($idIndicador == 19)Indicador03($idZona, $idMes);
    if($idIndicador == 20)Indicador04($idZona, $idMes);
    if($idIndicador == 21)Indicador05($idZona, $idMes);
    if($idIndicador == 22)Indicador06($idZona, $idMes);
    if($idIndicador == 23)Indicador07($idZona, $idMes);	
    if($idIndicador == 24)Indicador08($idZona, $idMes);	
    //if($idIndicador == 25)Indicador09($idZona, $idMes);	
}

/*Indicador01(2, 4);
Indicador02(2, 4);
Indicador03(2, 4);
Indicador04(2, 4);
Indicador05(2, 4);
Indicador06(2, 4);
Indicador07(2, 4);
Indicador08(2, 4);
Indicador09(2, 4);  */


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
	where i.cod_indicador = " . $indicador . "  and izm.mes = " . $mes . " and iz.cod_zona = " . $zona . " and izm.anio_indicador = " . $anioCurso;

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
	global $tabla, $nombresIndicadores, $codIndicadoresArray;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

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

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadoresArray[0]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadoresArray[0]);

		//echo $metaMes . "<br>" . $metaAnual;


	//sql que consulta las ventas en el mes indicado
	$sqlVentasMesPub = "select sum(ic.monto_contratacion) as ventas, ic.cod_zona, ic.fecha_registro from im_contratacion ic where month(ic.fecha_reporte) = " . $mesInd . " and ic.cod_zona = ". $zonaInd . " and year(ic.fecha_registro) = " . $anioInd . " and ic.tipo_contrato = 'publica'";

	//echo $sqlVentasMesPub . "<br>";

	
	//ejecucion del sql
	
	$resVentasMesPub = query($sqlVentasMesPub);
	while($fila = mysql_fetch_array($resVentasMesPub))
	{
		$ventasMes = $fila['ventas'];
	}

	//echo $ventasMes . "<br>";

	//calculamos el avance mensual
	$avanceMes = round(($ventasMes * 100) / $metaMes, 2);
	//echo $avanceMes . "<br>";

	//calcularemos las ventas acumuladas hasta el mes especificado
	$sqlVentasAcumuladas = "select sum(ic.monto_contratacion) as ventas, ic.cod_zona, ic.fecha_reporte from im_contratacion ic where month(ic.fecha_reporte) <= " . $mesInd . " and ic.cod_zona = ". $zonaInd . " and year(ic.fecha_reporte) = " . $anioInd . " and ic.tipo_contrato = 'publica'";

	$resVentasAcumuladas = query($sqlVentasAcumuladas);
	while($fila = mysql_fetch_array($resVentasAcumuladas))
	{
		$metaAcumulaEjecutada = $fila['ventas'];
	}

	//echo $metaAcumulaEjecutada . "<br>";

	//calcular la meta acumulada programada hasta el mes señalado	
	for($i = 1; $i <= $mesInd; $i++)
	{
		$metaAcumuladaProgramada += metaMensual($zonaInd, $i, $codIndicadoresArray[0]); 
	}

	//echo $metaAcumuladaProgramada . "<br>";

	//calculamos el porcentaje de cada uno
	$avanceEjecutadoAcumulado = round(($metaAcumulaEjecutada * 100) / $metaAcumuladaProgramada, 2);
	$avanceEjecutadoAnual = round(($metaAcumulaEjecutada * 100) / $metaAnual, 2);

	//echo $avanceEjecutadoAcumulado . "<br>" . $avanceEjecutadoAnual;





	

	//IMPRESION DE RESULATDOS	

	/*"		<tr>
				<th class='colorIndicador'>ZONA</th>
				<th class='colorIndicador'>PROVINCIA</th>
				<th class='colorIndicador'>CANTÓN</th>
				<th class='colorIndicador'>MES DE REPORTE</th>
				<th class='colorIndicador'>ENTIDAD CONTRATANTE</th>				
				<th class='colorIndicador1'>FECHA DE ADJUDICACION</th>
				<th class='colorIndicador1'>CÓDIGO DEL PROCESO</th>
				<th class='colorIndicador1'>CÓDIGO CPC</th>
				<th class='colorIndicador1'>MONTO DE CONTRATACIÓN SIN IVA</th>
				<th class='colorIndicador1'>TIPO ENTINDAD CONTRATANTE</th>
				<th class='colorIndicador1'>NOMBRE DE ENTIDAD CONTRATANTE</th>
				<th class='colorIndicador1'>FECHA DE ADJUDICACION DEL CONTRATO</th>
				<th class='colorIndicador1'>MONTO DE CONTRATACION SIN IVA</th>
				<th class='colorIndicador1'>SECTOR PRIORIZADO</th>
			</tr>";*/

	//print_r2($codIndicadoresArray);

	
	$tabla .= "<tr>
			<td>5.1</td>
			<td>" . $nombresIndicadores[0] . "</td>
			<td>" . $metaMes . "</td>
			<td>" . $ventasMes . "</td>
			<td>" . $avanceMes . "%</td>
			<td>" . $metaAnual . "</td>			
			<td>" . $metaAcumuladaProgramada . "</td>
			<td>" . $metaAcumulaEjecutada . "</td>
			<td>" . $avanceEjecutadoAcumulado . "%</td>
			<td>" . $avanceEjecutadoAnual . "%</td>
			<td></td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
			<td><a href='../../clases/detalleIntercambio.php?anio=" . $anioInd . "&indicador=" . $codIndicadoresArray[0] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";

}

function Indicador02($zona, $mes)
{

	global $tabla, $nombresIndicadores, $codIndicadoresArray;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales	
	$ventasMes = 0;
	$montoParticipacion = 0;
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

	/*=========== SEGUNDO INDICADOR =======================*/
	/*MONTO EN VENTA DE ORGANIZACIONES Y UEPS AL MERCADO PRIVADO*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadoresArray[1]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadoresArray[1]);

	//	echo $metaMes . "<br>" . $metaAnual;


	//sql que consulta las ventas en el mes indicado
	$sqlVentasMesPub = "select sum(ic.monto_contratacion) as ventas, ic.cod_zona, ic.fecha_reporte from im_contratacion ic where month(ic.fecha_reporte) = " . $mesInd . " and ic.cod_zona = ". $zonaInd . " and year(ic.fecha_reporte) = " . $anioInd . " and ic.tipo_contrato = 'privada'";

	//echo $sqlVentasMesPub . "<br>";

	
	//ejecucion del sql
	
	$resVentasMesPub = query($sqlVentasMesPub);
	while($fila = mysql_fetch_array($resVentasMesPub))
	{
		$ventasMes = $fila['ventas'];
	}

	//echo $ventasMes . "<br>";

	$sqlParticipacionMonto = "select ip.cod_participacion_eventos, ip.monto_articulado, ip.monto_articulado_postevento from im_participacion_eventos ip where month(ip.fecha_reporte) = " . $mesInd . " and year(ip.fecha_reporte) = " . $anioInd . " and ip.cod_zona = " . $zonaInd;

	$resParticipacionMonto = query($sqlParticipacionMonto);
	while($fila = mysql_fetch_array($resParticipacionMonto))
	{
		$montoParticipacion += ($fila['monto_articulado'] + $fila['monto_articulado_postevento']);
	}

	//Las ventas totales en el sector privado contaran de las contrataciones y los montos articulados y posteventos de cada participación
	$ventasMes += $montoParticipacion;
	

	//calculamos el avance mensual
	$avanceMes = round(($ventasMes * 100) / $metaMes, 2);
	//echo $avanceMes . "<br>";

	//calcularemos las ventas acumuladas hasta el mes especificado
	$sqlVentasAcumuladas = "select sum(ic.monto_contratacion) as ventas, ic.cod_zona, ic.fecha_reporte from im_contratacion ic where month(ic.fecha_reporte) <= " . $mesInd . " and ic.cod_zona = ". $zonaInd . " and year(ic.fecha_reporte) = " . $anioInd . " and ic.tipo_contrato = 'privada'";

	$resVentasAcumuladas = query($sqlVentasAcumuladas);
	while($fila = mysql_fetch_array($resVentasAcumuladas))
	{
		$metaAcumulaEjecutada = $fila['ventas'];
	}

	//echo $metaAcumulaEjecutada . "<br>";

	//calcular la meta acumulada programada hasta el mes señalado	
	for($i = 1; $i <= $mesInd; $i++)
	{
		$metaAcumuladaProgramada += metaMensual($zonaInd, $i, $codIndicadoresArray[1]); 
	}

	//echo $metaAcumuladaProgramada . "<br>";

	//calculamos el porcentaje de cada uno
	$avanceEjecutadoAcumulado = round(($metaAcumulaEjecutada * 100) / $metaAcumuladaProgramada, 2);
	$avanceEjecutadoAnual = round(($metaAcumulaEjecutada * 100) / $metaAnual, 2);

	//echo $avanceEjecutadoAcumulado . "<br>" . $avanceEjecutadoAnual;





	

	//IMPRESION DE RESULATDOS	

	/*"		<tr>
				<th class='colorIndicador'>NUMERACIÓN GPR DEL INDICADOR</th>
				<th class='colorIndicador'>NOMBRES DE LOS INDICADORES (Misma denominación que consta en GPR y Fichas Técnicas)</th>
				<th class='colorIndicador'>META MENSUAL PROGRAMADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>META MENSUAL EJECUTADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>% DE AVANCE MENSUAL (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META PROGRAMADA (ENE-DIC)</th>
				<th class='colorIndicador1'>META ACUMULADA PROGRAMADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META ACUMULADA EJECUTADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ANUAL)</th>
				<th class='colorIndicador1'>JUSTIFICACIÓN SOBRECUMPLIMIENTO O NO CUMPLIMIENTO</th>
				<th class='colorIndicador1'>Zona</th>
				<th class='colorIndicador1'>Mes</th>
			</tr>";*/

	
	$tabla .= "<tr>
			<td>5.2</td>
			<td>" . $nombresIndicadores[1] . "</td>
			<td>" . $metaMes . "</td>
			<td>" . $ventasMes . "</td>
			<td>" . $avanceMes . "%</td>
			<td>" . $metaAnual . "</td>			
			<td>" . $metaAcumuladaProgramada . "</td>
			<td>" . $metaAcumulaEjecutada . "</td>
			<td>" . $avanceEjecutadoAcumulado . "%</td>
			<td>" . $avanceEjecutadoAnual . "%</td>
			<td></td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
			<td><a href='../../clases/detalleIntercambio.php?anio=" . $anioInd . "&indicador=" . $codIndicadoresArray[1] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";
	
	
}

function Indicador03($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadoresArray;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	$ventasMes = 0;
	$montoParticipacion = 0;
	$avanceMes = 0;
	$avanceEjecutadoAcumulado = 0;
	$avanceEjecutadoAnual = 0;
	$metaAcumulaEjecutada = 0;
	$metaAcumuladaProgramada = 0;
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$orgServicios = array(0, 0, 0, 0, 0);
	$numOrgReportadas = 0; 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== TERCER INDICADOR =======================*/
	/*NÚMERO DE ORGANIZACIONES DE LA EPS QUE RECIBIERON AL MENOS UN SERVICIO DE LA DIRECCIÓN DE INTERCAMBIO Y MERCADOS*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadoresArray[2]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadoresArray[2]);

	//	echo $metaMes . "<br>" . $metaAnual;


	$numOrgReportadas = RevisarOrgMes($zonaInd, $mesInd, "org");
	//print_r2($numOrgReportadas);
	//echo $numOrgReportadas . "***********<br>";
		

	//calcular la meta acumulada programada hasta el mes señalado	
	for($i = 1; $i <= $mesInd; $i++)
	{
		$metaAcumuladaProgramada += metaMensual($zonaInd, $i, $codIndicadoresArray[2]); 
	}
	//echo $metaAcumuladaProgramada . "<br>";

	if($mesInd == 1)
	{
		$metaAcumulaEjecutada += RevisarOrgMes($zonaInd, 1, "org");
	}
	else
	{
		for($i = 1; $i < $mesInd; $i++)
		{
			$metaAcumulaEjecutada += RevisarOrgMes($zonaInd, $i, "org");
		}
		$metaAcumulaEjecutada += $numOrgReportadas;
	}
	

	//Ahora ejecutaremos la misma codificacion pero para meses anteriores al señalado para tener la meta acumulada ejecutada
	
	


	//echo $metaAcumulaEjecutada . "<br>";

	//calculamos el porcentaje de cada uno
	$avanceEjecutadoAcumulado = round(($metaAcumulaEjecutada * 100) / $metaAcumuladaProgramada, 2);
	$avanceEjecutadoAnual = round(($metaAcumulaEjecutada * 100) / $metaAnual, 2);
	//calculamos el avance mensual
	$avanceMes = round(($numOrgReportadas * 100) / $metaMes, 2);
	//echo $avanceMes . "<br>";

	//echo $avanceEjecutadoAcumulado . "<br>" . $avanceEjecutadoAnual;





	

	//IMPRESION DE RESULATDOS	

	/*"		<tr>
				<th class='colorIndicador'>NUMERACIÓN GPR DEL INDICADOR</th>
				<th class='colorIndicador'>NOMBRES DE LOS INDICADORES (Misma denominación que consta en GPR y Fichas Técnicas)</th>
				<th class='colorIndicador'>META MENSUAL PROGRAMADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>META MENSUAL EJECUTADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>% DE AVANCE MENSUAL (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META PROGRAMADA (ENE-DIC)</th>
				<th class='colorIndicador1'>META ACUMULADA PROGRAMADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META ACUMULADA EJECUTADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ANUAL)</th>
				<th class='colorIndicador1'>JUSTIFICACIÓN SOBRECUMPLIMIENTO O NO CUMPLIMIENTO</th>
				<th class='colorIndicador1'>Zona</th>
				<th class='colorIndicador1'>Mes</th>
			</tr>";*/

	
	$tabla .= "<tr>
			<td>5.5</td>
			<td>" . $nombresIndicadores[2] . "</td>
			<td>" . $metaMes . "</td>
			<td>" . $numOrgReportadas . "</td>
			<td>" . $avanceMes . "%</td>
			<td>" . $metaAnual . "</td>			
			<td>" . $metaAcumuladaProgramada . "</td>
			<td>" . $metaAcumulaEjecutada . "</td>
			<td>" . $avanceEjecutadoAcumulado . "%</td>
			<td>" . $avanceEjecutadoAnual . "%</td>
			<td></td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
			<td><a href='../../clases/detalleIntercambio.php?anio=" . $anioInd . "&indicador=" . $codIndicadoresArray[2] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";
}

function Indicador04($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadoresArray;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	$ventasMes = 0;
	$montoParticipacion = 0;
	$avanceMes = 0;
	$avanceEjecutadoAcumulado = 0;
	$avanceEjecutadoAnual = 0;
	$metaAcumulaEjecutada = 0;
	$metaAcumuladaProgramada = 0;
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$orgServicios = array(0, 0, 0, 0, 0);
	$numOrgReportadas = 0; 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== CUARTO INDICADOR =======================*/
	/*NÚMERO DE UNIDADES ECONÓMICAS POPULARES - UEPS QUE RECIBIERON AL MENOS UN SERVICIO DIRECCIÓN DE INTERCAMBIO Y MERCADOS*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadoresArray[3]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadoresArray[3]);

	//	echo $metaMes . "<br>" . $metaAnual;

	// echo "Indicador04: " . $mes . "<br>";
	$numOrgReportadas = RevisarOrgMes($zonaInd, $mesInd, "uep");
	//echo $numOrgReportadas . "***********<br>";
		

	//calcular la meta acumulada programada hasta el mes señalado	
	for($i = 1; $i <= $mesInd; $i++)
	{
		$metaAcumuladaProgramada += metaMensual($zonaInd, $i, $codIndicadoresArray[3]); 
	}
	//echo $metaAcumuladaProgramada . "<br>";

	if($mesInd == 1)
	{
		$metaAcumulaEjecutada += RevisarOrgMes($zonaInd, 1, "uep");
	}
	else
	{
		for($i = 1; $i < $mesInd; $i++)
		{
			// echo "Indicador04: " . $i . "<br>";
			$metaAcumulaEjecutada += RevisarOrgMes($zonaInd, $i, "uep");
		}
		$metaAcumulaEjecutada += $numOrgReportadas;
	}
	

	//Ahora ejecutaremos la misma codificacion pero para meses anteriores al señalado para tener la meta acumulada ejecutada
	
	


	//echo $metaAcumulaEjecutada . "<br>";

	//calculamos el porcentaje de cada uno
	$avanceEjecutadoAcumulado = round(($metaAcumulaEjecutada * 100) / $metaAcumuladaProgramada, 2);
	$avanceEjecutadoAnual = round(($metaAcumulaEjecutada * 100) / $metaAnual, 2);
	//calculamos el avance mensual
	$avanceMes = round(($numOrgReportadas * 100) / $metaMes, 2);
	//echo $avanceMes . "<br>";

	//echo $avanceEjecutadoAcumulado . "<br>" . $avanceEjecutadoAnual;





	

	//IMPRESION DE RESULATDOS	

	/*"		<tr>
				<th class='colorIndicador'>NUMERACIÓN GPR DEL INDICADOR</th>
				<th class='colorIndicador'>NOMBRES DE LOS INDICADORES (Misma denominación que consta en GPR y Fichas Técnicas)</th>
				<th class='colorIndicador'>META MENSUAL PROGRAMADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>META MENSUAL EJECUTADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>% DE AVANCE MENSUAL (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META PROGRAMADA (ENE-DIC)</th>
				<th class='colorIndicador1'>META ACUMULADA PROGRAMADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META ACUMULADA EJECUTADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ANUAL)</th>
				<th class='colorIndicador1'>JUSTIFICACIÓN SOBRECUMPLIMIENTO O NO CUMPLIMIENTO</th>
				<th class='colorIndicador1'>Zona</th>
				<th class='colorIndicador1'>Mes</th>
			</tr>";*/

	
	$tabla .= "<tr>
			<td>5.6</td>
			<td>" . $nombresIndicadores[3] . "</td>
			<td>" . $metaMes . "</td>
			<td>" . $numOrgReportadas . "</td>
			<td>" . $avanceMes . "%</td>
			<td>" . $metaAnual . "</td>			
			<td>" . $metaAcumuladaProgramada . "</td>
			<td>" . $metaAcumulaEjecutada . "</td>
			<td>" . $avanceEjecutadoAcumulado . "%</td>
			<td>" . $avanceEjecutadoAnual . "%</td>
			<td></td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
			<td><a href='../../clases/detalleIntercambio.php?anio=" . $anioInd . "&indicador=" . $codIndicadoresArray[3] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";



}

function Indicador05($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadoresArray;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	$ventasMes = 0;
	$montoParticipacion = 0;
	$avanceMes = 0;
	$avanceEjecutadoAcumulado = 0;
	$avanceEjecutadoAnual = 0;
	$metaAcumulaEjecutada = 0;
	$metaAcumuladaProgramada = 0;
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$orgServicios = array(0, 0, 0, 0, 0);
	$sociosRep = 0; 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== QUINTO INDICADOR =======================*/
	/*NÚMERO DE PERSONAS QUE CONFORMAN LAS ORGANIZACIONES Y UEPS QUE HAN RECIBIDO AL MENOS UN SERVICIO DE LA DIM Y SE ENMARCAN EN LA ESTRATEGIA PARA EL CAMBIO DE LA MATRIZ PRODUCTIVA*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadoresArray[4]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadoresArray[4]);

	//	echo $metaMes . "<br>" . $metaAnual;

	// echo "REVISAR SOCIOS ORG <BR>";

	$sociosRep = RevisarSociosOrg($zonaInd, $mesInd);
	// echo "REVISAR SOCIOS ORG <BR>";
		

	//calcular la meta acumulada programada hasta el mes señalado	
	for($i = 1; $i <= $mesInd; $i++)
	{
		$metaAcumuladaProgramada += metaMensual($zonaInd, $i, $codIndicadoresArray[4]); 
	}
	//echo $metaAcumuladaProgramada . "<br>";

	if($mesInd == 1)
	{
		$metaAcumulaEjecutada += RevisarSociosOrg($zonaInd, 1);
	}
	else
	{
		for($i = 1; $i < $mesInd; $i++)
		{
			$metaAcumulaEjecutada += RevisarSociosOrg($zonaInd, $i);
		}
		$metaAcumulaEjecutada += $sociosRep;
	}
	

	//Ahora ejecutaremos la misma codificacion pero para meses anteriores al señalado para tener la meta acumulada ejecutada
	
	


	//echo $metaAcumulaEjecutada . "<br>";

	//calculamos el porcentaje de cada uno
	$avanceEjecutadoAcumulado = round(($metaAcumulaEjecutada * 100) / $metaAcumuladaProgramada, 2);
	$avanceEjecutadoAnual = round(($metaAcumulaEjecutada * 100) / $metaAnual, 2);
	//calculamos el avance mensual
	$avanceMes = round(($sociosRep * 100) / $metaMes, 2);
	//echo $avanceMes . "<br>";

	//echo $avanceEjecutadoAcumulado . "<br>" . $avanceEjecutadoAnual;





	

	//IMPRESION DE RESULATDOS	

	/*"		<tr>
				<th class='colorIndicador'>NUMERACIÓN GPR DEL INDICADOR</th>
				<th class='colorIndicador'>NOMBRES DE LOS INDICADORES (Misma denominación que consta en GPR y Fichas Técnicas)</th>
				<th class='colorIndicador'>META MENSUAL PROGRAMADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>META MENSUAL EJECUTADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>% DE AVANCE MENSUAL (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META PROGRAMADA (ENE-DIC)</th>
				<th class='colorIndicador1'>META ACUMULADA PROGRAMADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META ACUMULADA EJECUTADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ANUAL)</th>
				<th class='colorIndicador1'>JUSTIFICACIÓN SOBRECUMPLIMIENTO O NO CUMPLIMIENTO</th>
				<th class='colorIndicador1'>Zona</th>
				<th class='colorIndicador1'>Mes</th>
			</tr>";*/

	
	$tabla .= "<tr>
			<td>5.7</td>
			<td>" . $nombresIndicadores[4] . "</td>
			<td>" . $metaMes . "</td>
			<td>" . $sociosRep . "</td>
			<td>" . $avanceMes . "%</td>
			<td>" . $metaAnual . "</td>			
			<td>" . $metaAcumuladaProgramada . "</td>
			<td>" . $metaAcumulaEjecutada . "</td>
			<td>" . $avanceEjecutadoAcumulado . "%</td>
			<td>" . $avanceEjecutadoAnual . "%</td>
			<td></td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
			<td><a href='../../clases/detalleIntercambio.php?anio=" . $anioInd . "&indicador=" . $codIndicadoresArray[4] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";
}

function Indicador06($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadoresArray;	
	
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();

	//variables locales
	$orgReportadasMes = array();
	$orgCodYServicios = array();
	$ventasMes = 0;
	$montoParticipacion = 0;
	$avanceMes = 0;
	$avanceEjecutadoAcumulado = 0;
	$avanceEjecutadoAnual = 0;
	$metaAcumulaEjecutada = 0;
	$metaAcumuladaProgramada = 0;
	//$orgServicios contendra los resultados finales asi (indicador 1, indicador 2, indicador 3, indicador 4, total)
	$orgServicios = array(0, 0, 0, 0, 0);
	$circuitosEconomicos = 0; 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== SEXTO INDICADOR =======================*/
	/*NÚMERO DE CIRCUITOS ECONÓMICOS QUE HAYAN RECIBIDO AL MENOS UN SERVICIO DE LA DIRECCIÓN DE INTERCAMBIO Y MERCADOS*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadoresArray[5]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadoresArray[5]);

	//	echo $metaMes . "<br>" . $metaAnual;


	$circuitosEconomicos = RevisarCircuitosEconomicos($zonaInd, $mesInd);
		

	//calcular la meta acumulada programada hasta el mes señalado	
	for($i = 1; $i <= $mesInd; $i++)
	{
		$metaAcumuladaProgramada += metaMensual($zonaInd, $i, $codIndicadoresArray[5]); 
	}
	//echo $metaAcumuladaProgramada . "<br>";

	if($mesInd == 1)
	{
		$metaAcumulaEjecutada += RevisarCircuitosEconomicos($zonaInd, 1);
	}
	else
	{
		for($i = 1; $i < $mesInd; $i++)
		{
			$metaAcumulaEjecutada += RevisarCircuitosEconomicos($zonaInd, $i);
		}
		$metaAcumulaEjecutada += $circuitosEconomicos;
	}
	

	//Ahora ejecutaremos la misma codificacion pero para meses anteriores al señalado para tener la meta acumulada ejecutada
	
	


	//echo $metaAcumulaEjecutada . "<br>";

	//calculamos el porcentaje de cada uno
	$avanceEjecutadoAcumulado = round(($metaAcumulaEjecutada * 100) / $metaAcumuladaProgramada, 2);
	$avanceEjecutadoAnual = round(($metaAcumulaEjecutada * 100) / $metaAnual, 2);
	//calculamos el avance mensual
	$avanceMes = round(($circuitosEconomicos * 100) / $metaMes, 2);
	//echo $avanceMes . "<br>";

	//echo $avanceEjecutadoAcumulado . "<br>" . $avanceEjecutadoAnual;





	

	//IMPRESION DE RESULATDOS	

	/*"		<tr>
				<th class='colorIndicador'>NUMERACIÓN GPR DEL INDICADOR</th>
				<th class='colorIndicador'>NOMBRES DE LOS INDICADORES (Misma denominación que consta en GPR y Fichas Técnicas)</th>
				<th class='colorIndicador'>META MENSUAL PROGRAMADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>META MENSUAL EJECUTADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>% DE AVANCE MENSUAL (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META PROGRAMADA (ENE-DIC)</th>
				<th class='colorIndicador1'>META ACUMULADA PROGRAMADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META ACUMULADA EJECUTADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ANUAL)</th>
				<th class='colorIndicador1'>JUSTIFICACIÓN SOBRECUMPLIMIENTO O NO CUMPLIMIENTO</th>
				<th class='colorIndicador1'>Zona</th>
				<th class='colorIndicador1'>Mes</th>
			</tr>";*/

	
	$tabla .= "<tr>
			<td>5.8</td>
			<td>" . $nombresIndicadores[5] . "</td>
			<td>" . $metaMes . "</td>
			<td>" . $circuitosEconomicos . "</td>
			<td>" . $avanceMes . "%</td>
			<td>" . $metaAnual . "</td>			
			<td>" . $metaAcumuladaProgramada . "</td>
			<td>" . $metaAcumulaEjecutada . "</td>
			<td>" . $avanceEjecutadoAcumulado . "%</td>
			<td>" . $avanceEjecutadoAnual . "%</td>
			<td></td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
			<td><a href='../../clases/detalleIntercambio.php?anio=" . $anioInd . "&indicador=" . $codIndicadoresArray[5] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";
}

function Indicador07($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadoresArray;	
	
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
	$orgServicios = array(0, 0, 0, 0, 0);
	$plazasTrabajo = 0; 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== SEPTIMO INDICADOR =======================*/
	/*NÚMERO DE PERSONAS DE LA EPS CON PLAZAS DE TRABAJO POR ACCESO PÚBLICO O PRIVADO*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadoresArray[6]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadoresArray[6]);

	//	echo $metaMes . "<br>" . $metaAnual;

	//echo "indicador 07 <br>";
	$plazasTrabajo = RevisarPlazasTrabajo($zonaInd, $mesInd);
		

	//calcular la meta acumulada programada hasta el mes señalado	
	for($i = 1; $i <= $mesInd; $i++)
	{
		$metaAcumuladaProgramada += metaMensual($zonaInd, $i, $codIndicadoresArray[6]); 
	}
	//echo $metaAcumuladaProgramada . "<br>";

	if($mesInd == 1)
	{
		$metaAcumulaEjecutada += RevisarPlazasTrabajo($zonaInd, 1);
	}
	else
	{
		for($i = 1; $i < $mesInd; $i++)
		{
			$metaAcumulaEjecutada += RevisarPlazasTrabajo($zonaInd, $i);
		}
		$metaAcumulaEjecutada += $plazasTrabajo;
	}
	

	//Ahora ejecutaremos la misma codificacion pero para meses anteriores al señalado para tener la meta acumulada ejecutada
	
	


	//echo $metaAcumulaEjecutada . "<br>";

	//calculamos el porcentaje de cada uno
	$avanceEjecutadoAcumulado = round(($metaAcumulaEjecutada * 100) / $metaAcumuladaProgramada, 2);
	$avanceEjecutadoAnual = round(($metaAcumulaEjecutada * 100) / $metaAnual, 2);
	//calculamos el avance mensual
	$avanceMes = round(($plazasTrabajo * 100) / $metaMes, 2);
	//echo $avanceMes . "<br>";

	//echo $avanceEjecutadoAcumulado . "<br>" . $avanceEjecutadoAnual;





	

	//IMPRESION DE RESULATDOS	

	/*"		<tr>
				<th class='colorIndicador'>NUMERACIÓN GPR DEL INDICADOR</th>
				<th class='colorIndicador'>NOMBRES DE LOS INDICADORES (Misma denominación que consta en GPR y Fichas Técnicas)</th>
				<th class='colorIndicador'>META MENSUAL PROGRAMADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>META MENSUAL EJECUTADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>% DE AVANCE MENSUAL (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META PROGRAMADA (ENE-DIC)</th>
				<th class='colorIndicador1'>META ACUMULADA PROGRAMADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META ACUMULADA EJECUTADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ANUAL)</th>
				<th class='colorIndicador1'>JUSTIFICACIÓN SOBRECUMPLIMIENTO O NO CUMPLIMIENTO</th>
				<th class='colorIndicador1'>Zona</th>
				<th class='colorIndicador1'>Mes</th>
			</tr>";*/

	
	$tabla .= "<tr>
			<td>5.9</td>
			<td>" . $nombresIndicadores[6] . "</td>
			<td>" . $metaMes . "</td>
			<td>" . $plazasTrabajo . "</td>
			<td>" . $avanceMes . "%</td>
			<td>" . $metaAnual . "</td>			
			<td>" . $metaAcumuladaProgramada . "</td>
			<td>" . $metaAcumulaEjecutada . "</td>
			<td>" . $avanceEjecutadoAcumulado . "%</td>
			<td>" . $avanceEjecutadoAnual . "%</td>
			<td></td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
			<td><a href='../../clases/detalleIntercambio.php?anio=" . $anioInd . "&indicador=" . $codIndicadoresArray[6] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";	
	
}

function Indicador08($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadoresArray;	
	
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
	$orgServicios = array(0, 0, 0, 0, 0);
	$orgNuevas = 0; 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== OCTAVO INDICADOR =======================*/
	/*NÚMERO DE NUEVAS ORGANIZACIONES DE LA EPS QUE RECIBIERON AL MENOS UN SERVICIO DE LA DIRECCIÓN DE INTERCAMBIO Y MERCADOS*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, $codIndicadoresArray[7]);
	$metaAnual = MetaAnio($zona, $mes, $codIndicadoresArray[7]);

	//	echo $metaMes . "<br>" . $metaAnual;

	// echo "mes Indicador = " .  $mesInd;
	$orgNuevas = RevisarOrgMesNuevas($zonaInd, $mesInd);
	//echo $orgNuevas . "*****<br>";
		

	//calcular la meta acumulada programada hasta el mes señalado	
	for($i = 1; $i <= $mesInd; $i++)
	{
		$metaAcumuladaProgramada += metaMensual($zonaInd, $i, $codIndicadoresArray[7]); 
	}
	//echo $metaAcumuladaProgramada . "<br>";

	if($mesInd == 1)
	{
		$metaAcumulaEjecutada += RevisarOrgMesNuevas($zonaInd, 1);
	}
	else
	{
		for($i = 1; $i < $mesInd; $i++)
		{
			$metaAcumulaEjecutada += RevisarOrgMesNuevas($zonaInd, $i);
		}
		$metaAcumulaEjecutada += $orgNuevas;
	}
	

	//Ahora ejecutaremos la misma codificacion pero para meses anteriores al señalado para tener la meta acumulada ejecutada
	
	


	//echo $metaAcumulaEjecutada . "<br>";

	//calculamos el porcentaje de cada uno
	$avanceEjecutadoAcumulado = round(($metaAcumulaEjecutada * 100) / $metaAcumuladaProgramada, 2);
	$avanceEjecutadoAnual = round(($metaAcumulaEjecutada * 100) / $metaAnual, 2);
	//calculamos el avance mensual
	$avanceMes = round(($orgNuevas * 100) / $metaMes, 2);
	//echo $avanceMes . "<br>";

	//echo $avanceEjecutadoAcumulado . "<br>" . $avanceEjecutadoAnual;





	

	//IMPRESION DE RESULATDOS	

	/*"		<tr>
				<th class='colorIndicador'>NUMERACIÓN GPR DEL INDICADOR</th>
				<th class='colorIndicador'>NOMBRES DE LOS INDICADORES (Misma denominación que consta en GPR y Fichas Técnicas)</th>
				<th class='colorIndicador'>META MENSUAL PROGRAMADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>META MENSUAL EJECUTADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>% DE AVANCE MENSUAL (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META PROGRAMADA (ENE-DIC)</th>
				<th class='colorIndicador1'>META ACUMULADA PROGRAMADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META ACUMULADA EJECUTADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ANUAL)</th>
				<th class='colorIndicador1'>JUSTIFICACIÓN SOBRECUMPLIMIENTO O NO CUMPLIMIENTO</th>
				<th class='colorIndicador1'>Zona</th>
				<th class='colorIndicador1'>Mes</th>
			</tr>";*/

	
	$tabla .= "<tr>
			<td>5.10</td>
			<td>" . $nombresIndicadores[7] . "</td>
			<td>" . $metaMes . "</td>
			<td>" . $orgNuevas . "</td>
			<td>" . $avanceMes . "%</td>
			<td>" . $metaAnual . "</td>			
			<td>" . $metaAcumuladaProgramada . "</td>
			<td>" . $metaAcumulaEjecutada . "</td>
			<td>" . $avanceEjecutadoAcumulado . "%</td>
			<td>" . $avanceEjecutadoAnual . "%</td>
			<td></td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
			<td><a href='../../clases/detalleIntercambio.php?anio=" . $anioInd . "&indicador=" . $codIndicadoresArray[7] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";	
	
}

function Indicador09($zona, $mes)
{
	global $tabla, $nombresIndicadores, $codIndicadoresArray;	
	
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
	$orgServicios = array(0, 0, 0, 0, 0);
	$comercio = 0; 
	$metaMes = 0;
	$metaAnual = 0;

	//fecha a consultar-formato: Y-m-d
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01'; 

	/*=========== NOVENO INDICADOR =======================*/
	/*NÚMERO DE ORGANIZACIONES QUE RECIBEN UN SERVICIO DE LA DIRECCIÓN DE INTERCAMBIO Y MERCADOS RELATIVO A COMERCIO JUSTO NACIONAL E INTERNACIONAL*/

	//consultamos la meta programada

	$metaMes = MetaMensual($zona, $mes, 25);
	$metaAnual = MetaAnio($zona, $mes, 25);

	//	echo $metaMes . "<br>" . $metaAnual;


	$comercio = RevisarComercios($zonaInd, $mesInd);
		

	//calcular la meta acumulada programada hasta el mes señalado	
	for($i = 1; $i <= $mesInd; $i++)
	{
		$metaAcumuladaProgramada += metaMensual($zonaInd, $i, 25); 
	}
	//echo $metaAcumuladaProgramada . "<br>";

	if($mesInd == 1)
	{
		$metaAcumulaEjecutada += RevisarComercios($zonaInd, 1);
	}
	else
	{
		for($i = 1; $i < $mesInd; $i++)
		{
			$metaAcumulaEjecutada += RevisarComercios($zonaInd, $i);
		}
		$metaAcumulaEjecutada += $comercio;
	}
	

	//Ahora ejecutaremos la misma codificacion pero para meses anteriores al señalado para tener la meta acumulada ejecutada
	
	


	//echo $metaAcumulaEjecutada . "<br>";

	//calculamos el porcentaje de cada uno
	$avanceEjecutadoAcumulado = round(($metaAcumulaEjecutada * 100) / $metaAcumuladaProgramada, 2);
	$avanceEjecutadoAnual = round(($metaAcumulaEjecutada * 100) / $metaAnual, 2);
	//calculamos el avance mensual
	$avanceMes = round(($comercio * 100) / $metaMes, 2);
	//echo $avanceMes . "<br>";

	//echo $avanceEjecutadoAcumulado . "<br>" . $avanceEjecutadoAnual;





	

	//IMPRESION DE RESULATDOS	

	/*"		<tr>
				<th class='colorIndicador'>NUMERACIÓN GPR DEL INDICADOR</th>
				<th class='colorIndicador'>NOMBRES DE LOS INDICADORES (Misma denominación que consta en GPR y Fichas Técnicas)</th>
				<th class='colorIndicador'>META MENSUAL PROGRAMADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>META MENSUAL EJECUTADA (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador'>% DE AVANCE MENSUAL (". $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META PROGRAMADA (ENE-DIC)</th>
				<th class='colorIndicador1'>META ACUMULADA PROGRAMADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>META ACUMULADA EJECUTADA (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ENE - " . $nombresMes[$idMes - 1] . ")</th>
				<th class='colorIndicador1'>% AVANCE (ANUAL)</th>
				<th class='colorIndicador1'>JUSTIFICACIÓN SOBRECUMPLIMIENTO O NO CUMPLIMIENTO</th>
				<th class='colorIndicador1'>Zona</th>
				<th class='colorIndicador1'>Mes</th>
			</tr>";*/

	
	$tabla .= "<tr>
			<td>5.11</td>
			<td>" . $nombresIndicadores[8] . "</td>
			<td>" . $metaMes . "</td>
			<td>" . $comercio . "</td>
			<td>" . $avanceMes . "%</td>
			<td>" . $metaAnual . "</td>			
			<td>" . $metaAcumuladaProgramada . "</td>
			<td>" . $metaAcumulaEjecutada . "</td>
			<td>" . $avanceEjecutadoAcumulado . "%</td>
			<td>" . $avanceEjecutadoAnual . "%</td>
			<td></td>
			<td>" . $zonaInd . "</td>
			<td>" . $mesInd . "</td>
			<td><a href='../../clases/detalleIntercambio.php?anio=" . $anioInd . "&indicador=" . $codIndicadoresArray[8] . "&mes=" . $mesInd . "&zona=" . $zonaInd . "' target='_blank'>Detalles</a></td>
		</tr>";	
	
}

function print_r2($val)
{
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}

function RevisarOrgMes($zona, $mes, $tipoOrg)
{
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();
	$numOrgReportadas = 0;
	$orgReportadasMes = array();
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01';


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

	//Revisamos las organizaciones / uep reportadas en meses anteriores
	$orgReportadasMesAnterior = array();
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

	// echo "mes: " . $mes . "<br>";
	// print_r2($orgReportadasMes);


	$numOrgReportadas = count($orgReportadasMes);



	

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

	

	//print_r2($arraySociosMes);
	$sociosReportados = count($arraySociosMes);




	//si existen organizaciones, se debe contar los usuarios

	//CONSERVAMOS CODIGO POR POSIBLES CAMBIOS A FUTURO
	/*$sqlOrgMes = "select si.cod_u_organizaciones, si.cod_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_registro) = " . $mesInd . " and si.cod_zona = " . $zonaInd . " and year(si.fecha_registro) = " . $anioInd . " and u.categoria_actividad_mp <> 'no_priorizado_en_el_cambio_matriz_productiva' group by si.cod_u_organizaciones";

	echo $sqlOrgMes . "<br>";

	//ejecucion del sql que busca las organizaciones del mes y zona indicados
	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);
		array_push($orgReportadasMes, $fila['cod_servicio']);
		//array_push($orgReportadasMes, $fila['tipo_servicio']);
	}

	//print_r2($orgReportadasMes);	

	//se revisara si el codigo en la tabla de socios es igual al reportado
	for($i = 0; $i < count($orgReportadasMes); $i = $i + 2)
	{
		$sqlSocios = "select cod_socios, cod_servicio_im from socios where cod_u_organizaciones = " . $orgReportadasMes[$i];

		$resSqlSocios = query($sqlSocios);

		while($fila = mysql_fetch_array($resSqlSocios))
		{
			//si el cod_servicio_im es igual al reportado con la organizacion, se suma el socio al indicador
			if($fila['cod_servicio_im'] == $orgReportadasMes[$i + 1])
				$sociosReportados++;
		}
	}

	//si existen organizaciones, se debe contar los usuarios*/


	return $sociosReportados;

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



	$sqlOrgMes = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona, si.servicio, si.tipo_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) = " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and si.se_reporta = 'si' and antiguedad = 'si' group by si.cod_u_organizaciones";

	//echo $sqlOrgMes . "<br>";

	//ejecucion del sql que busca las organizaciones del mes y zona indicados
	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);		
	}

	$sqlOrgMes = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona from im_contratacion si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) = " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and si.se_reporta = 'si' and antiguedad = 'si' group by si.cod_u_organizaciones";

	//echo $sqlOrgMes . "<br>";


	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);
		
	}

	$orgReportadasMes = array_unique($orgReportadasMes);
	$orgReportadasMes = array_values($orgReportadasMes);
	

	// Revisar si las org /uep no han sido reportadas anteriormente
	$indiceArray = 0;
	foreach($orgReportadasMes as $valor)
	{
		$sqlRevision = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona, si.servicio, si.tipo_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) < " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and si.se_reporta = 'si' and si.cod_u_organizaciones = " . $valor;
		// echo $sqlRevision . "<br>";
		$resRevision = query($sqlRevision);
		$numFilasRevision = mysql_num_rows($resRevision);
		if($numFilasRevision > 0)
		{
			unset($orgReportadasMes[$indiceArray]);
		}
		else
		{
			// Revisar las contrataciones
			$sqlRevision = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona from im_contratacion si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) < " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = '" . $tipoOrg . "' and year(si.fecha_reporte) = " . $anioInd . " and si.se_reporta = 'si' and si.cod_u_organizaciones = " . $valor;
			// echo $sqlRevision . "<br>";

			$resRevision = query($sqlRevision);
			$numFilasRevision = mysql_num_rows($resRevision);
			if($numFilasRevision > 0)
			{
				unset($orgReportadasMes[$indiceArray]);
			}
		}
		$indiceArray++;
	}

	$orgReportadasMes = array_unique($orgReportadasMes);
	$orgReportadasMes = array_values($orgReportadasMes);
	// print_r2($orgReportadasMes);	
	$numOrgReportadas = count($orgReportadasMes);	

	return $numOrgReportadas;

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

	//print_r2($orgReportadasMes);
	$orgFiltrada = array();
	for($i = 0;  $i < count($orgReportadasMes); $i++)
	{
		if(in_array($orgReportadasMes[$i], $orgFiltrada) == 0)
		{
			array_push($orgFiltrada, $orgReportadasMes[$i]);
			
		}
		
	}

	//print_r2($orgFiltrada);	

	//Se debe revisar si las organizaciones consultadas tienen reportado el mismo contratacion en meses anteriores
	for($i = 0; $i < count($orgFiltrada); $i++)
	{

		// $sqlSociosReportados = "select cedula from socios where cod_u_organizaciones = " . $orgFiltrada[$i] . " and estado = 1 and socio_empleado in ('socio', 'socio_trabajador') and year(fecha_reporte_im) = " . $anioInd . " and month(fecha_reporte_im) = " . $mesInd;

		$sqlSociosReportados = "select ic.cedula, s.estado, s.socio_empleado, ic.fecha_reporte from im_contratacion_servicios_socios ic inner join socios s on (s.cedula = ic.cedula) where ic.cod_u_organizaciones = " . $orgFiltrada[$i] . " and s.estado = 1 and s.socio_empleado in ('socio', 'socio_trabajador') and year(ic.fecha_reporte) = " . $anioInd . " and month(ic.fecha_reporte) = " . $mesInd;
		

		//echo $sqlSociosReportados . "<br>";
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

	// echo $zona . " - -" . $mes . "<br>";
	if($zona == 1 && $mes == 2)
	{
		array_push($arraySociosReportar, '0502284243');
		array_push($arraySociosReportar, '1707550834');
		array_push($arraySociosReportar, '1711931723');
	}


	$arraySociosReportar = array_unique($arraySociosReportar);
	$arraySociosReportar = array_values($arraySociosReportar);
	$numPlazasTrabajo = count($arraySociosReportar);

	//print_r2($arraySociosReportar);


	//si existen organizaciones, se debe contar los usuarios


	return $numPlazasTrabajo;

}

function RevisarPlazasTrabajo1($zona, $mes)
{

	//SE MANTIENE CODIGO POR POSIBLES CAMBIOS
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();
	$numPlazasTrabajo = 0;
	$orgReportadasMes = array();
	$orgNoRepetidas = array();
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01';

	$sqlOrgMes = "select ic.cod_contratacion, ic.tipo_contrato, ic.cod_u_organizaciones, ic.num_socios, ic.num_empleados, ic.fecha_adjudicacion, ic.monto_contratacion from im_contratacion ic where month(ic.fecha_reporte) = " . $mesInd . " and se_reporta = 'si' and year(ic.fecha_reporte) = " . $anioInd . " and ic.monto_contratacion > 0 and ic.cod_zona = " . $zonaInd;

	//echo $sqlOrgMes . "<br>";

	//ejecucion del sql que busca las organizaciones del mes y zona indicados
	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);
		array_push($orgReportadasMes, $fila['tipo_contrato']);
		array_push($orgReportadasMes, $fila['num_socios']);
		array_push($orgReportadasMes, $fila['num_empleados']);
		array_push($orgReportadasMes, $fila['fecha_adjudicacion']);
	}

	$orgFiltrada = array();
	for($i = 0;  $i < count($orgReportadasMes); $i = $i + 5)
	{
		if(in_array($orgReportadasMes[$i], $orgFiltrada) == 0)
		{
			array_push($orgFiltrada, $orgReportadasMes[$i]);
			array_push($orgFiltrada, $orgReportadasMes[$i + 1]);
			array_push($orgFiltrada, $orgReportadasMes[$i + 2]);
			array_push($orgFiltrada, $orgReportadasMes[$i + 3]);
			array_push($orgFiltrada, $orgReportadasMes[$i + 4]);
		}
		
	}

	//print_r2($orgFiltrada);	

	//Se debe revisar si las organizaciones consultadas tienen reportado el mismo contratacion en meses anteriores
	for($i = 0; $i < count($orgFiltrada); $i = $i + 5)
	{
		$sqlContratosAnteriores = "select ic.cod_u_organizaciones from im_contratacion ic where ic.fecha_reporte <= '" . $fechaConsultar . "' and year(ic.fecha_reporte) = " . $anioInd . " and ic.cod_zona = " . $zonaInd . " and ic.tipo_contrato = '" . $orgFiltrada[$i + 1] . "' and ic.fecha_adjudicacion <> '" . $orgFiltrada[$i + 4] . "' and ic.cod_u_organizaciones = " . $orgFiltrada[$i];

		//echo $sqlContratosAnteriores . "<br>";
		$resSqlContratosAnteriores = query($sqlContratosAnteriores);

		/**************************************************************************************
		*	Se debe buscar:
				Registros de la organizacion con el mismo tipo de contrato. Si existen, no se debe sumar a este indicador
				Si no existen:				
				-Si no existen mas registros ademas del reportado en el mes indicado, esta organizacion  debe sumar al indicador

		*****************************************************************************************/
		$numFilas = mysql_num_rows($resSqlContratosAnteriores);

		//echo $numFilas . "<br>";

		if($numFilas == 0)
		{
			$numPlazasTrabajo += ($orgFiltrada[$i +2] + $orgFiltrada[$i + 3]);

		}
	}

	//si existen organizaciones, se debe contar los usuarios


	return $numPlazasTrabajo;

}

function RevisarCircuitosEconomicos($zona, $mes)
{
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();
	$numOrgReportadas = 0;
	$orgReportadasMes = array();
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01';


	$sqlOrgMes = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona, si.servicio, si.tipo_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) = " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = 'org' and year(si.fecha_reporte) = " . $anioInd . " and si.circuito_economico = 'si' group by si.cod_u_organizaciones";

	// echo $sqlOrgMes . "<br>";

	//ejecucion del sql que busca las organizaciones del mes y zona indicados
	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);
		//array_push($orgReportadasMes, $fila['servicio']);
		//array_push($orgReportadasMes, $fila['tipo_servicio']);
	}

	$sqlOrgMes = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona from im_contratacion si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) = " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = 'org' and year(si.fecha_reporte) = " . $anioInd . " and si.circuito_economico = 'si' group by si.cod_u_organizaciones";

	// echo $sqlOrgMes . "<br>";

	$resSqlOrgMes = query($sqlOrgMes);
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);
		//array_push($orgReportadasMes, $fila['servicio']);
		//array_push($orgReportadasMes, $fila['tipo_servicio']);
	}

	$orgReportadasMes = array_unique($orgReportadasMes); 
	$orgReportadasMes =  array_values($orgReportadasMes);


	// Reviso si la org ha sido reportada antes
	$indiceArray = 0;
	foreach($orgReportadasMes as $valor)
	{
		$sqlOrgMesReportada = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona, si.servicio, si.tipo_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) < " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = 'org' and year(si.fecha_reporte) = " . $anioInd . " and si.circuito_economico = 'si' and si.cod_u_organizaciones = " . $valor;

		// echo $sqlOrgMesReportada . "<br>";
		$resOrgMesReportada = query($sqlOrgMesReportada);
		$vecesOrgReportada = mysql_num_rows($resOrgMesReportada);

		if($vecesOrgReportada > 0)
		{
			unset($orgReportadasMes[$indiceArray]);
		}
		else
		{
			// se revisa en contrataciones si ya fue reportada la org o uep
			$sqlOrgMesReportada = "select si.cod_u_organizaciones, si.fecha_reporte, si.cod_zona from im_contratacion si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_reporte) < " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = 'org' and year(si.fecha_reporte) = " . $anioInd . " and si.circuito_economico = 'si' and si.cod_u_organizaciones = " . $valor;
			$resOrgMesReportada = query($sqlOrgMesReportada);
			$vecesOrgReportada = mysql_num_rows($resOrgMesReportada);
			if($vecesOrgReportada > 0)
			{
				unset($orgReportadasMes[$indiceArray]);
			}
		}
		$indiceArray++;
	}

	$orgReportadasMes = array_values($orgReportadasMes);

	$numOrgReportadas = count($orgReportadasMes);

	// print_r2($orgReportadasMes);	

	return $numOrgReportadas;

}

function RevisarComercios($zona, $mes)
{
	$zonaInd = $zona;
	$mesInd = $mes;
	$anioInd = getAnioSeleccionado();
	$numOrgReportadas = 0;
	$orgReportadasMes = array();
	$fechaConsultar = $anioInd . '-' . $mesInd . '-01';

	$sqlOrgMes = "select si.cod_u_organizaciones, si.fecha_registro, si.cod_zona, si.servicio, si.tipo_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where month(si.fecha_registro) = " . $mesInd . " and si.cod_zona = " . $zonaInd . " and u.tipo = 'org' and si.servicio = 'asistencia_tecnica_comercial' and si.tipo_servicio = 'comercio_justo' and year(si.fecha_registro) = " . $anioInd . " group by si.cod_u_organizaciones";

	//echo $sqlOrgMes . "<br>";

	//ejecucion del sql que busca las organizaciones del mes y zona indicados
	$resSqlOrgMes = query($sqlOrgMes);	
	
	while($fila = mysql_fetch_array($resSqlOrgMes))
	{
		array_push($orgReportadasMes, $fila['cod_u_organizaciones']);
		array_push($orgReportadasMes, $fila['servicio']);
		array_push($orgReportadasMes, $fila['tipo_servicio']);
	}

	//print_r2($orgReportadasMes);

	//Se debe revisar si las organizaciones consultadas tienen reportado el mismo servicio en meses anteriores
	for($i = 0; $i < count($orgReportadasMes); $i = $i + 3)
	{
		$sqlRevisarServicioAnterior = "select si.cod_u_organizaciones, si.fecha_registro, si.cod_zona, si.servicio, si.tipo_servicio from im_servicios si inner join u_organizaciones u on (u.cod_u_organizaciones = si.cod_u_organizaciones) where si.fecha_registro <= '" . $fechaConsultar . "' and u.cod_u_organizaciones = " . $orgReportadasMes[$i] . " and si.servicio = '" . $orgReportadasMes[$i + 1] . "' and si.tipo_servicio = '" . $orgReportadasMes[$i + 2] . "' group by si.cod_u_organizaciones ";

		//echo $sqlRevisarServicioAnterior . "<br>";
		$resSqlRevisarServicioAnterior = query($sqlRevisarServicioAnterior);

		/**************************************************************************************
		*	Se debe buscar:
				Registros de la organizacion con los mismos servicios. Si existen, no se debe sumar a este indicador

				-Si no existen mas registros ademas del reportado en el mes indicado, esta organizacion es nueva y  debe sumar al indicador

		*****************************************************************************************/
		$numFilas = mysql_num_rows($resSqlRevisarServicioAnterior);

		//echo $numFilas . "<br>";

		if($numFilas == 0)
		{
			$numOrgReportadas++;
		}
	}

	return $numOrgReportadas;

}


?>