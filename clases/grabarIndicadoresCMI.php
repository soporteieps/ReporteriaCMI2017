<!DOCTYPE html>
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

function getIndicador()
{
    $indicador = $_POST['idIndicador'];
    return $indicador;
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
    $indicador = getIndicador();
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

    if($existenRegistros)
    {
        echo 'update';
    }
    else
    {
        echo 'insert';
    }

    // for($i = 0; $i < count($indicadores); $i++)
    // {
    //     $sqlInsertIndicador = "insert into indicador_registro_mensual(cod_indicador, departamento, mes, anio, valor_registro, zona) values(" . $indicadores[$i] . ", '" . $idDepartamento . "', " . $mesInd . ", " . $anioInd .", " . $valoresIndicadores[$i] . ", " . $zonaInd . ")";
    //     query($sqlInsertIndicador);     
    // }

    // echo "Datos ingresados correctamente";
    


}

function print_r2($val)
{
    echo '<pre>';
    print_r($val);
    echo '</pre>';
}

GrabarIndicadores();

?>