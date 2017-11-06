<?php
include ('../lib/dbconfig.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reporte edades</title>
    <link rel="stylesheet" href="">
</head>
<body>
    <?php
    // $anioCurso = date('Y');
    $anioCurso = 2016;
    $rucOgrs = array();
    $table = "<table>";
    $table .= "<tr>
                    <th>Nombre Organizacion</th>
                    <th>Ruc</th>
                    <th>Capacitado 18 a 24</th>
                    <th>Capacitado 25 a 29</th>
                    <th>Capacitado 30 a 45</th>
                    <th>Capacitado 46 a 64</th>
                    <th>Capacitado 65 o más</th> 
                    <th>Año</th>                    
                </tr>";

    $codOrgActual = 0;
    $codEventosActual = array();
    $cedulaAsistentesActual = array();

    for($i = 2016; $i <= $anioCurso; $i++ )
    {
        // Se debe consultar todas las organizaciones que se capacitaron para obtener sus rucs
        $sqlOrgCapacitadas = "select eo.cod_u_organizaciones, o.organizacion, o.ruc_definitivo, o.ruc_provisional from eventos_u_organizaciones eo inner join u_organizaciones o on (o.cod_u_organizaciones = eo.cod_u_organizaciones) where eo.anio = " . $i . " group by eo.cod_u_organizaciones";

        // $pruebaEdad = CalculoEdad(2, 11, 1986);
        // echo $sqlOrgCapacitadas . "<br>";
        $resOrgCapacitadas = query($sqlOrgCapacitadas);
        while($filaOrg = mysql_fetch_array($resOrgCapacitadas))
        {
            $nombreOrg = $filaOrg['organizacion'];
            $codigoOrg = $filaOrg['cod_u_organizaciones'];
            $rucOrg = $filaOrg['ruc_definitivo'];
            if($rucOrg == '')
                $rucOrg = $filaOrg['ruc_provisional'];

            // echo $rucOrg . "<br>";
            $edadesConsultadas = GetCapacitadosPorEdad($codigoOrg, $i);
            
            // // echo $edad65120 . "<br>";

            $lineaTabla = "<tr>
                            <td>" . $nombreOrg . "</td>
                            <td>" . $rucOrg . "</td>
                            <td>" . $edadesConsultadas[0] . "</td>
                            <td>" . $edadesConsultadas[1] . "</td>
                            <td>" . $edadesConsultadas[2] . "</td>
                            <td>" . $edadesConsultadas[3] . "</td>
                            <td>" . $edadesConsultadas[4] . "</td>
                            <td>" . $i . "</td>
                            </tr>";
            $table .= $lineaTabla;
            echo '.';
        }
    }
    $table .= "</table>";
    echo $table;

    // $edad1824 = GetCapacitadosPorEdad(1200, 18, 24, 2017);
    // echo $edad1824 . "<br>";
    // $edad2529 = GetCapacitadosPorEdad(1200, 25, 29, 2017);
    // echo $edad2529 . "<br>";
    // $edad3045 = GetCapacitadosPorEdad(1200, 30, 45, 2017);
    // echo $edad3045 . "<br>";
    // $edad4664 = GetCapacitadosPorEdad(1201, 46, 64, 2017);
    // echo $edad4664 . "<br>";
    // $edad65120 = GetCapacitadosPorEdad(1201, 65, 120, 2017);
    // echo $edad65120 . "<br>";



    function GetCapacitadosPorEdad($codOrganizacion, $anio)
    {
        global $codOrgActual, $codEventosActual, $cedulaAsistentesActual;
        $edadesRango = array(0, 0, 0, 0, 0);
        
        if($codOrgActual == 0 || $codOrgActual != $codOrganizacion)
        {
            $codOrgActual = $codOrganizacion;
            //echo $codOrgActual . "<br>";
            $sqlCodEventos = "select cod_evento from eventos_u_organizaciones where cod_u_organizaciones = " . $codOrganizacion . " and anio = " . $anio;
            // echo $sqlCodEventos . "</br>";
            $resCodEventos = query($sqlCodEventos);
            $codEventos = array();
            while($row = mysql_fetch_array($resCodEventos))
            {
                array_push($codEventos, $row['cod_evento']);
            }
            

            // puede existir codEventos repetidos por lo cual eliminamos, si fuera el caso, eventos repetidos
            $codEventos = array_unique($codEventos);
            $codEventos = array_values($codEventos);           
            $codEventosActual = $codEventos;
            // print_r2($codEventos);

            //  Con el codigo de evento se consulta los asistentes
            $cedulaAsistentes = array();
            $tamCodEventos = count($codEventos);
            for($i = 0; $i < $tamCodEventos; $i++)
            {
                $sqlAsistentes = "select cedula from asistentes where cod_evento = '" . $codEventos[$i] . "' and anio = " . $anio;
                // echo $sqlAsistentes . "<br>";
                $resAsistentes = query($sqlAsistentes);
                while($row = mysql_fetch_array($resAsistentes))
                {
                    array_push($cedulaAsistentes, $row['cedula']);
                }
            }

            // eliminar las cedulas repetidas
            $cedulaAsistentes = array_unique($cedulaAsistentes);
            $cedulaAsistentes = array_values($cedulaAsistentes);            
            $cedulaAsistentesActual = $cedulaAsistentes;
            //print_r2($cedulaAsistentes);
        }

        
        $tamCedulaAsistentes = count($cedulaAsistentesActual);

        // echo $tamCodEventos . " - numevemtos - " . $tamCedulaAsistentes . " - numAsistetenes<br>";
        

       

        // Ahora revisamos los siguientes puntos:
        //  - cedula pertenece a la organizacion
        //  - calculo de edad
        //  - si califica para el rango ingresado        
        $edadConsultada = 0;
        for($i = 0; $i < $tamCedulaAsistentes; $i++)
        {
           
            $sqlCedulaPerteneceOrg = "select day(fecha_nacimiento) as dia, month(fecha_nacimiento) as mes, year(fecha_nacimiento) as anio from socios where cod_u_organizaciones = " . $codOrganizacion . " and cedula = '" . $cedulaAsistentesActual[$i] . "'";
            // echo $sqlCedulaPerteneceOrg . "<br>";
            $resCedulaPerteneceOrg = query($sqlCedulaPerteneceOrg);
            // Dependiendo del resultado de la consulta se realiza lo siguiente
            //  - Puede que la fecha de nacimiento no este actualizada y conste como 0000/00/00
            //      En este caso se debe tomar la edad registrada en la tabla asistentes
            while($row = mysql_fetch_array($resCedulaPerteneceOrg))
            {
                $anioConsultado = $row['anio'];
                $mesConsultado = $row['mes'];
                $diaConsultado = $row['dia'];

                if($anioConsultado <= 0 || $mesConsultado <= 0 || $diaConsultado <= 0)
                {
                    // Si el anio, mes o dia de nacimiento es cero, se tiene que consultar la edad registrada en tabla asistentes
                    $sqlEdadAsistente = "select edad from asistentes where cedula = '" . $cedulaAsistentesActual[$i] . "' group by cedula";
                    $resEdadAsistente = query($sqlEdadAsistente);
                    while($rowEdad = mysql_fetch_array($resEdadAsistente))
                    {
                        $edadConsultada = $rowEdad['edad'];
                    }
                }
                else
                {
                    // Si existe la fecha de nacimiento se llama a la funcion CalculoEdad
                    $edadConsultada = CalculoEdad($diaConsultado, $mesConsultado, $anioConsultado);
                }
            }
            

            // Si la edad consultada concuerda con el rango especificado, se suma 1 al numero de capacitados   

            if($edadConsultada >= 18 && $edadConsultada <= 24)
                $edadesRango[0]++;
            if($edadConsultada >= 25 && $edadConsultada <= 29)
                $edadesRango[1]++;
            if($edadConsultada >= 30 && $edadConsultada <= 45)
                $edadesRango[2]++;
            if($edadConsultada >= 46 && $edadConsultada <= 64)
                $edadesRango[3]++;
            if($edadConsultada >= 65)
                $edadesRango[4]++;
        }

        return $edadesRango;
        


    }

    function CalculoEdad($diaNacimiento, $mesNacimiento, $anioNacimiento)
    {
        // Se calcula la edad que tendra en este año el sujeto
        $anioActual = date('Y');
        $edad = $anioActual - $anioNacimiento;

        // Ahora calculamos la edad exacta del sujeto
        $mesActual = date('m');
        $diaActual = date('d');
        // echo $diaActual . "<br>";
        if($mesActual < $mesNacimiento)
        {
            $edad-=1;
        }
        else
        {
            if($mesActual == $mesNacimiento)
            {
                if($diaActual < $diaNacimiento)
                {
                    $edad-=1;
                }
            }
        }
        // echo $edad . "<br>";
        return $edad;
    }

    function print_r2($val)
    {
        echo '<pre>';
        print_r($val);
        echo '</pre>';
    }

    ?>  
</body>
</html>