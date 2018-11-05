<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>REPORTE DE INDICADORES</title>
   <link rel="stylesheet" type="text/css" href="../../css/style.css" />
    <link rel="stylesheet" type="text/css" href="../../css/flexigrid.css" />
    <script src='../../js/jquery-1.6.4.min.js'></script> 
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
                 type: "GET",  
                 url: "BusquedaGeneralExcel.php",
				 data:'cod_indicador='+$('#cmbIndicador').val()+'&cod_mes='+$('#cmbMeses').val()+'&cod_zona='+$('#cmbZona').val()+'&anio='+$('#cmbAnios').val(),	
                 success: function(html){  
					    $("#datos_a_enviar").val(html);
     				 $("#FormularioExportacion").submit();	 
               }  
             });  
	//} 
}
</script> 
<?php
include("../lib/dbconfig.php");
include("consulta_indicadores.php");
session_start(); 
if ($accion=="consultar")
{
     consultar($indicador, $mes, $zona, $anio);  
}

function consultar($cod_indicador, $cod_mes, $cod_zona, $anio)
{
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
                     $consulta="select cod_indicador,indicador from indicador where estado = 1 and departamento = 'FA'";
					 
                     $result=query($consulta);		
                     echo '<select name="cmbIndicador" id="cmbIndicador" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"><option value = "-1">--TODOS--</option>';
                            while($indicadores_aux=mysql_fetch_object($result))
                                {		
										$indicador = $indicadores_aux->cod_indicador."- ".$indicadores_aux->indicador;
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
                            for($i = 2016; $i <= $anioActual; $i++)
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
                         <input name="btnBuscar" id="btnBuscar"type="button" value="          Buscar" style="background-image:url(../../images/buscar.jpg);background-repeat:no-repeat;height:32px;width:90px;background-position:left; cursor: pointer;" onclick="reporte(document.form1.cmbIndicador.value, document.form1.cmbMeses.value, document.form1.cmbZona.value, document.form1.cmbAnios.value);">
                   </td>				   
              </tr>
              <tr>
					<td colspan="9" width="140" height="30">
                     <input name="btnExportar" id="btnExportar" type="button" value="   Exportar" style="background-image:url(../../images/export.gif);background-repeat:no-repeat;height:32px;width:90px;background-position:left; cursor: pointer;" onclick="exportarExcell();">
                     
                     </td>
               </tr>
</table>
<table style="border-style:none" align="center"> 
				 <tr>
				 	<td bgcolor="#8DB4E3">
					</td>
					<td bgcolor="#8DB4E3">
					</td>
					<td bgcolor="#8DB4E3">
					</td>';
					if($cod_mes == -1)
					{
						echo '<td colspan="13" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>META PROGRAMADA</left></strong></font></td>
						
						<td colspan="13" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>META EJECUTADA</left></strong></font></td>
						<td colspan="13" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>DETALLE</left></strong></font></td>';

					}
					else
					{
						echo '<td colspan="2" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>META PROGRAMADA</left></strong></font></td>
						
						<td colspan="2" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>META EJECUTADA</left></strong></font></td>
						<td colspan="13" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>DETALLE</left></strong></font></td>';
					}
					
				 echo'</tr>
                 <tr>
				    <td align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>Nº</left></strong></font></td>
                    <td align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>INDICADORES N4</left></strong></font></td>
                    
                    <td width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>DIRECCIÓN ZONAL</left></strong></font></td>';
					//DIBUJA TODAS LOS MESES
					if($cod_mes == -1)
					{
						$consulta_meses="select valor from catalogo where tipo ='meses'";
	                     $result_meses=query($consulta_meses);
						while($mes_aux1=mysql_fetch_object($result_meses))
                                {
									echo '<td width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>'.strtoupper(substr($mes_aux1->valor,0,3)).'</left></strong></font></td>';
                                }
								echo '<td width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>TOTAL METAS</left></strong></font></td>';
						$result_meses1=query($consulta_meses);
						while($mes_aux2=mysql_fetch_object($result_meses1))
                                {		
									echo '<td width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>'.strtoupper(substr($mes_aux2->valor,0,3)).'</left></strong></font></td>';
                                }
								echo '<td width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>TOTAL METAS</left></strong></font></td>
								<td width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>LINK</left></strong></font></td>';
					}
					//DIBUJA EL MES SELECCIONADO
					else
					{
						$consulta_meses="select valor from catalogo where tipo ='meses' and codigo = $cod_mes";
	                     $result_meses=query($consulta_meses);
						while($mes_aux1=mysql_fetch_object($result_meses))
                                {		
									echo '<td width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>'.strtoupper(substr($mes_aux1->valor,0,3)).'</left></strong></font></td>';
                                }
								echo '<td width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>TOTAL METAS</left></strong></font></td>';
						$result_meses1=query($consulta_meses);
						while($mes_aux2=mysql_fetch_object($result_meses1))
                                {		
									echo '<td width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>'.strtoupper(substr($mes_aux2->valor,0,3)).'</left></strong></font></td>';
                                }
								echo '<td width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>TOTAL METAS</left></strong></font></td>
								<td width="140" align="center" bgcolor="#8DB4E3"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong><left>LINK</left></strong></font></td>';
					}
                 echo'</tr>';
				 
				 
					$consulta="select iz.cod_zona,i.cod_indicador,i.indicador from indicador i 
					inner join indicador_zona iz on(i.cod_indicador = iz.cod_indicador)";
					//FILTRO POR ZONA
					 if($cod_zona != -1)
						{$consulta = $consulta." and iz.cod_zona = $cod_zona";}
					//FILTRO POR INDICADOR
					 if($cod_indicador != -1)	
						{$consulta = $consulta." and i.cod_indicador = $cod_indicador";}

					$consulta .= " and i.estado = 1 and i.departamento = 'FA'";
					
					
					$result=query($consulta);
					$contador = 1;
					
					while($indicadores=mysql_fetch_object($result))
					{	
						$cod_indicador_aux	= $indicadores->cod_indicador;
						$indicador = $indicadores->indicador;
						$zona = $indicadores->cod_zona;
					echo '<tr>
						<td align="center" bgcolor="#93CDDD">'.$contador.'</td>
						<td class="descripcionIndicador" align="left" bgcolor="#93CDDD">'.$indicador.'</td>
						<td align="center" bgcolor="#D99795">Zona '.$zona.'</td>';
						echo meta_programada($zona,$cod_indicador_aux,$cod_mes);
						echo meta_ejecutada($zona,$cod_indicador_aux,$cod_mes);
						echo'</tr>';
						$contador = $contador + 1;
					 }
        echo '</table>
    </form>
</div>';	
}
?>

