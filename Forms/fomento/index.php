<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset='UTF-8'>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>REPORTE DE INDICADORES</title>
    <link rel="stylesheet" type="text/css" href="../../css/font-awesome.css" />
   <link rel="stylesheet" type="text/css" href="../../css/style.css" />
   <link rel="stylesheet" type="text/css" href="../../css/estilos.css" />
    <link rel="stylesheet" type="text/css" href="../../css/flexigrid.css" />
    <script src='../../js/jquery.js'></script> 
    <script type="text/javascript" src="../../js/flexigrid.pack.js"></script>  
    <link rel="stylesheet" href="../../css/themes/base/jquery.ui.all.css">
    <script src="../../js/external/jquery.bgiframe-2.1.2.js"></script>
    <script src="../../js/ui/jquery.ui.core.js"></script>
    <script src="../../js/ui/jquery.ui.widget.js"></script>
    <script src="../../js/ui/jquery.ui.mouse.js"></script>
    <script src="../../js/ui/jquery.ui.button.js"></script>
    <script src="../../js/ui/jquery.ui.draggable.js"></script>
    <script src="../../js/ui/jquery.ui.position.js"></script>
    <script src="../../js/ui/jquery.ui.resizable.js"></script>
    <script src="../../js/ui/jquery.ui.dialog.js"></script>
    <script src="../../js/ui/jquery.effects.core.js"></script>    
    <script src="../../js/ui/jquery.ui.datepicker.js"></script> 
	<script src="../../js/jquery-ui-1.8.14.custom.min.js"></script>
    <script src="../../js/jquery-ui-timepicker-addon.js"></script>
    <script src="../../js/index.js"></script>
    <script src="../../js/control.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-73816205-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-73816205-1');
</script>


  
</head>
<form action="../../clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
</html>
<script type="text/javascript">
function exportarExcell() {
	//alert("*************************function exportarExcell******************************");
	//if (com == 'Exportar') {
		     $.ajax({  
                 type: "POST",  
                 url: "../../clases/indicadoresFomento.php",
				 data:'idIndicador='+$('#cmbIndicador').val()+'&idMes='+$('#cmbMeses').val()+'&idZona='+$('#cmbZona').val() + '&idAnio=' + $('#cmbAnios').val(),	
                 success: function(html){  
					    $("#datos_a_enviar").val(html);
     				 $("#FormularioExportacion").submit();	 
               }  
             });  
	//} 
}
</script> 
<?php
include("../../lib/dbconfig.php");
session_start(); 
echo "<div id='DivIndex' align='center'>";	
echo '<form name="form1" method="post"> 
      <table style="border-style:none" align="center">
             <tr>
                <td colspan="9" height="30" align="center" valign="middle" bgcolor="#000000"><font color="#ffffff" size="3" face="Arial, Helvetica, sans-serif"><strong><left>REPORTE DE INDICADORES CONSOLIDADO CMI NACIONAL 2017</left></strong></font>
                </td>
          </tr>
          
          <tr>
			  <td width="140" align="center" bgcolor="#000000"><font color="#ffffff" size="2" face="Arial, Helvetica, sans-serif"><strong><left>Indicador</left></strong></font></td>
                <td width="240" align="center" valign="middle">';
                 $consulta="select cod_indicador,indicador from indicador where departamento = 'FP' and estado = 1";
				 
                 $result=query($consulta);		
                 echo '<select name="cmbIndicador" id="cmbIndicador" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"><option value = "-1">--TODOS--</option>';
                        while($indicadores_aux=mysql_fetch_object($result))
                            {		
									$indicador = $indicadores_aux->indicador;
									if($cod_indicador == $indicadores_aux->cod_indicador)
									{echo '<option value="'. $indicadores_aux->cod_indicador .'"selected>'.$indicador.'</option>';}
                                    else
									{echo '<option value="'. $indicadores_aux->cod_indicador .'">'.$indicador.'</option>';}
                            }
                echo '</td>
		  
                <td width="140" align="center" bgcolor="#000000"><font color="#ffffff" size="2" face="Arial, Helvetica, sans-serif"><strong>
                <left>Zona</left></strong></font></td>
                <td width="240" align="center" valign="middle">';
                    $consulta="select cod_zona, zona from u_zona";
					$result=query($consulta);
					
					echo '<select name="cmbZona" id="cmbZona" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"><option value = "-1">--TODOS--</option>';
                        while($zona_aux=mysql_fetch_object($result))
                            {		
                                    $zona_nom = utf8_encode($zona_aux->zona);
									if($cod_zona == $zona_aux->cod_zona)
                                    {echo '<option value="'. $zona_aux->cod_zona .'"selected>'.$zona_nom.'</option>';}
									else
									{echo '<option value="'. $zona_aux->cod_zona .'">'.$zona_nom.'</option>';}
                            }
               echo'</td>
			    <td width="140" align="center" bgcolor="#000000"><font color="#ffffff" size="2" face="Arial, Helvetica, sans-serif"><strong><left>Mes</left></strong></font></td>
                <td width="240" align="center" valign="middle">';
                 $consulta="select codigo,valor from catalogo where tipo ='meses'";
				 
                 $result=query($consulta);		
                 echo '<select name="cmbMeses" id="cmbMeses" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"><option value = "-1">--TODOS--</option>';
                        while($mes_aux=mysql_fetch_object($result))
                            {		
								$valor = utf8_encode($mes_aux->valor);
								if($cod_mes == $mes_aux->codigo)
								{echo '<option value="'. $mes_aux->codigo .'"selected>'.$valor.'</option>';}
								else
								{echo '<option value="'. $mes_aux->codigo .'">'.$valor.'</option>';}
                            }
                echo '</td>
                    <td width="140" align="center" bgcolor="#000000"><font color="#ffffff" size="2" face="Arial, Helvetica, sans-serif"><strong><left>Año</left></strong></font></td>
                    <td width="240" align="center" valign="middle">';
                                                    
                        echo '<select name="cmbAnios" id="cmbAnios" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"><option value = "-1">--TODOS--</option>';
                            $anioActual = date('Y');
                            for($i = 2017; $i <= $anioActual; $i++)
                            { 
                                if($anio == $i)
                                {
                                    echo '<option value="'. $i .'" selected>'.$i.'</option>';
                                }
                                else
                                {
                                    echo '<option value="'. $i .'">'.$i.'</option>';
                                }
                            }
                        
               echo '</td>
               <td colspan="2" width="88" align="center" valign="middle">
                     <input name="btnBuscar" id="btnBuscar"type="button" value="Buscar" style="background-image:url(../../images/buscar.jpg);background-repeat:no-repeat;height:32px;width:90px;background-position:left; cursor: pointer;">
               </td>				   
          </tr>
          <tr>
				<td colspan="9" width="140" height="30">
                 <input name="btnExportar" id="btnExportar" type="button" value="Exportar" style="background-image:url(../../images/export.gif);background-repeat:no-repeat;height:32px;width:90px;background-position:left; cursor: pointer;" onclick="exportarExcell();"></td>
           </tr>
	</table>
</form>
</div>';	

?>
<?php
$perfil = $_GET['perfil'];
if($perfil == 7 || $perfil == 1)
{
    ?>
    <div class="reportesGenerales">
        <div class="linksReportes" id="linksReportes">
            <a class="reporte" id="reporteGeneralFp" href="#" target="_blank">Reporte General Organizaciones Ueps</a>
            <a class="reporte" id="reporteGeneralSociosFp" href="#" target="_blank">Reporte General Socios</a>
        </div>    
    </div>
    <div class="botonMuestra fa fa-angle-down" id="botonMuestra"></div>  
    <?php
}

?>

<div id="resultadoIndicadores"></div><!-- fin div resultadoIndicadores -->
<script src="../../js/controlReportesFp.js"></script>


