<!DOCTYPE html>
<?php include("../lib/dbconfig.php"); ?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Logs CMI</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/estilos.css">    
</head>
<body>
    <div class="container">
        <h1 class="text-center">LOGS</h1>    
        <div class="container-fluid">
            <div class="row controles">
                <div class="col-md-4 text-center">
                    <input type="radio" name="logIngresos" id="logIngresos">
                    <label for="logIngresos">Ingresos</label>                    
                </div>
                <div class="col-md-4 text-center">
                    <input type="radio" name="logIngresos" id="logOrgEventos">
                    <label for="logOrgEventos">Organizaciones - Eventos</label>                    
                </div>
                <div class="col-md-4 text-center">
                    <input type="radio" name="logIngresos" id="logEliminarSocios">
                    <label for="logEliminarSocios">Eliminacion Socios</label>                    
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row filtro">
                <div class="col-md-4 text-center">
                    <input type="text" class="inputDate" id="inputDate" value="" />
                    <label for="inputDate">Fecha Inicio</label>                    
                </div>
                <div class="col-md-4 text-center">
                    <input type="text" class="inputDateF" id="inputDateF" value="" />
                    <label for="inputDateF">Fecha Final</label>
                </div>
                <div class="col-md-4 text-center">
                    <button type="success" onclick="MostrarLog();">Buscar</button>
                </div>                
            </div>
        </div>
        <div class="container-fluid">
            <div class="row tabla">
                <table class="table table-hover" id="tablaRespuesta">
                    <thead>
                        <!-- <tr>
                            <th scope="col">#</th>
                            <th scope="col">Código Evento</th>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Acción</th>
                        </tr> -->
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre y Apellidos</th>
                            <th scope="col">Organizacion</th>
                            <th scope="col">Fecha Eliminación</th>
                            <th scope="col">Usuario SIU</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <?php
                        // $sql = "select * from log_eventos_u_organizaciones where fecha_registro >= '2017-08-10' and fecha_registro<='2018-01-31'";
                        // $resSql = query($sql);
                        // $tabla = "";
                        // $cont = 0;
                        // while($fila = mysql_fetch_array($resSql))
                        // {
                        //     $tabla .= "<tr>";
                        //     $tabla .= "<th scope='row'>" . $cont++ . "</th>";
                        //     $tabla .= "<td>" . $fila['cod_log_eventos_u_organizaciones'] . "</td>";
                        //     $sqlOrg = "select organizacion from u_organizaciones where cod_u_organizaciones = " . $fila['cod_u_organizaciones'];
                        //     $resOrg = query($sqlOrg);
                        //     $org = '';
                        //     while($forg = mysql_fetch_array($resOrg))
                        //     {
                        //         $org = $forg['organizacion'];
                        //     }
                        //     $tabla .= "<td>" . $org . "</td>";
                        //     $tabla .= "<td>" . $fila['fecha_registro'] . "</td>";
                        //     $tabla .= "<td>" . $fila['accion'] . "</td>";
                        //     $tabla .= "</tr>";

                        // }

                        $sql = "select * from log_socios_eliminados where fecha_eliminacion >= '2017-11-29' and fecha_eliminacion<='2018-01-31'";
                        $resSql = query($sql);
                        $tabla = "";
                        $cont = 0;
                        while($fila = mysql_fetch_array($resSql))
                        {
                            $tabla .= "<tr>";
                            $tabla .= "<th scope='row'>" . $cont++ . "</th>";
                            $tabla .= "<td>" . $fila['apellidos'] . "</td>";
                            $sqlOrg = "select organizacion from u_organizaciones where cod_u_organizaciones = " . $fila['cod_u_organizaciones'];
                            $resOrg = query($sqlOrg);
                            $org = '';
                            while($forg = mysql_fetch_array($resOrg))
                            {
                                $org = $forg['organizacion'];
                            }
                            $tabla .= "<td>" . $org . "</td>";
                            $tabla .= "<td>" . $fila['fecha_eliminacion'] . "</td>";
                            $tabla .= "<td>" . $fila['user'] . "</td>";
                            $tabla .= "</tr>";

                        }
                        echo $tabla;
                        ?>                                       
                    </tbody>
                </table>                
            </div>
        </div>
    </div>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery.js"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $('#inputDate').datepicker();
        $('#inputDateF').datepicker();        
    </script>    
</body>
</html>