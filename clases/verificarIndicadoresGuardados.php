<?php

include("../lib/dbconfig.php");

function VerificarIndicadoresIngresados()
{
	$anio = $_POST['anio'];
	$mes = $_POST['mes'];
	$zona = $_POST['zona'];
	$departamento = $_POST['departamento'];
	$nombresMes  = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	$sqlValoresIndicador = "select * from indicador_registro_mensual where anio = " . $anio . " and mes = " . $mes . " and zona = " . $zona . " and departamento = '" . $departamento . "'";
	// echo $sqlValoresIndicador;
    $resValoresIndicador = query($sqlValoresIndicador);
    $numFilasValoresIndicador = mysql_num_rows($resValoresIndicador);
    $existeRegistroIndicador = false;

    switch ($departamento) 
    {
        case 'FA':
        {
            if($numFilasValoresIndicador == 9)
            {
                $existeRegistroIndicador = true;
                break;
            }
        }
        default:
        {
        	$existeRegistroIndicador = false;
        }
    }

    if($existeRegistroIndicador)
    {
    	echo "Ya existen registros para los indicadores de la zona " . $zona . ", en el mes de " . $nombresMes[$mes - 1] . " en el año " . $anio . ". Desea guardar de todas formas?";
    }
    else
    {
    	echo "Desea guardar los indicadores de la zona " . $zona . ", del mes de " . $nombresMes[$mes - 1] . " del año " . $anio . "?";
    } 
}

VerificarIndicadoresIngresados();

?>