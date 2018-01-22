<?php

include("../lib/dbconfig.php");

function getAnio()
{
    $anio = $_POST['idAnio'];
    return $anio;
}

function getMes()
{
    $mes = $_POST['idMes'];
    return $mes;
}

function getZona()
{
    $zona = $_POST['idZona'];
    return $zona;
}

function getDepartamento()
{
    $departamento = $_POST['idDepartamento'];
    return $departamento;
}



function getValoresIndicadores()
{
    // el js envia un array, pero php lo toma como si fuera un string 
    // se debe convertir el string en un array, los valores son divididos por comas ',' 

    $valoresIndicadores = $_POST['valoresIndicadores'];
    $valoresIndicadores = explode(',', $valoresIndicadores);

    return $valoresIndicadores;
}

function getIndicadores($departamento)
{
    $sqlConsultaIndicador = "select * from indicador where departamento = '" . $departamento . "' and estado = 1 order by cod_indicador";
    $resConsultaIndicador = query($sqlConsultaIndicador);
    $indicadores = array();
    while($indicadoresDepartamento = mysql_fetch_array($resConsultaIndicador))
    {
        array_push($indicadores, $indicadoresDepartamento['cod_indicador']);        
    }

    return $indicadores;
}

function RevisarValoresIndicador($departamento, $anio, $mes, $zona)
{
    $sqlValoresIndicador = "select * from indicador_registro_mensual where anio = " . $anio . " and mes = " . $mes . " and zona = " . $zona . " and departamento = '" . $departamento . "'";
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
    }

    return $existeRegistroIndicador;
}

function GrabarIndicadores()
{

    // Se obtiene los valores elegidos en la interfaz de los indicadores
    
    $anioInd = getAnio();
    $mesInd = getMes();
    $zonaInd = getZona();
    $idDepartamento = getDepartamento();
    $valoresIndicadores = getValoresIndicadores();
    // print_r2($valoresIndicadores);

    // echo $indicador . " - " . $anioInd . " - " . $mesInd . " - " . $zonaInd . " - " . $idDepartamento;

    //***************************************
    // GUARDADO DE VALORES DE INDICADORES
    //***************************************

    $indicadores = getIndicadores($idDepartamento);
    // print_r2($indicadores);

    // dependiendo de la revision de los indicadores, la sentencia sql puede cambiar de INSERT a UPDATE
    $existenRegistros = RevisarValoresIndicador($idDepartamento, $anioInd, $mesInd, $zonaInd);
    $tipoConsulta = '';

    if($existenRegistros)
    {
        $tipoConsulta = 'update';
    }
    else
    {
        $tipoConsulta = 'insert';
    }

    for($i = 0; $i < count($indicadores); $i++)
    {
        $sqlInsertIndicador = "";
        if($tipoConsulta == 'insert')
        {
            $sqlInsertIndicador = "insert into indicador_registro_mensual(cod_indicador, departamento, mes, anio, valor_registro, zona) values(" . $indicadores[$i] . ", '" . $idDepartamento . "', " . $mesInd . ", " . $anioInd .", " . $valoresIndicadores[$i] . ", " . $zonaInd . ")";
            // echo $sqlInsertIndicador;
                     
        }
        else
        {

            $sqlInsertIndicador = "update indicador_registro_mensual set valor_registro = " . $valoresIndicadores[$i] . " where cod_indicador = " . $indicadores[$i] . " and zona = " . $zonaInd . " and mes = " . $mesInd . " and anio = " . $anioInd . " and departamento = '" . $idDepartamento . "'";
            
            // echo $sqlInsertIndicador;            
        }
        query($sqlInsertIndicador);
        
    }

    echo "Datos ingresados correctamente";
    


}

function VerificarIndicadoresIngresados()
{
    $anio = getAnio();
    $mes = getMes();
    $zona = getZona();
    $departamento = getDepartamento();
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

function print_r2($val)
{
    echo '<pre>';
    print_r($val);
    echo '</pre>';
}




//**********************************************
// Se ejecuta las sentencias dependiendo de la accion
// que enviemos desde el archivo control.js
//**********************************************

$accion = $_POST['accion'];
if($accion == 'verificar')
{
    VerificarIndicadoresIngresados();
}

if($accion == 'procesar')
{
    GrabarIndicadores();    
}


?>