<?php
 include("../../lib/dbconfig.php");
 //$name=$_POST['name'];
 //$usr_login=$_POST['usr_login'];
 //echo "*****************name=".$name." ,usr_login=".$usr_login."***********************<br>";
 ?>
<?php $zonaUsr = $_GET['zonaUsr'];  // tomamos la zona del usuario enviada en la url ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>REPORTE DE INDICADORES</title>
   <link rel="stylesheet" type="text/css" href="../../css/style.css" />
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
    <!-- <script src="../../js/index.js"></script> -->
    <script src="../../js/control.js"></script>
</head>
<body>
<div id='DivIndex' align='center'>
<form action="../../clases/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>

    <form name="form1" method="post"> 
           <table style="border-style:none" align="center">
                 <tr>
                    <td colspan="9" height="30" align="center" valign="middle" bgcolor='#000000'><font color='#ffffff' size='3' face='Arial, Helvetica, sans-serif'><strong><left>REPORTE DE INDICADORES CONSOLIDADO CMI NACIONAL 2017</left></strong></font>
                    </td>
              </tr>
              
              <tr>
	              <td width="140" align="center" bgcolor='#000000'><font color='#ffffff' size='2' face='Arial, Helvetica, sans-serif'><strong><left>Indicador</left></strong></font></td>
                    <td width="240" align="center" valign="middle">
                        <?php
                            $consulta="select cod_indicador,indicador from indicador where departamento = 'FA' and estado = 1";
                            $result=query($consulta);
                            echo '<select name="cmbIndicador" id="cmbIndicador" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"><option value = "-1">--TODOS--</option>';
                            while($indicadores_aux=mysql_fetch_object($result))
                                {		
									//$indicador = utf8_encode($indicadores_aux->indicador);
									$indicador = $indicadores_aux->cod_indicador."- ".$indicadores_aux->indicador;
									echo '<option value="'. $indicadores_aux->cod_indicador .'">'.$indicador.'</option>';
                                }
                        ?>
                    </td>
                    <td width="140" align="center" bgcolor='#000000'><font color='#ffffff' size='2' face='Arial, Helvetica, sans-serif'><strong>
                    <left>Zona</left></strong></font></td>
                    <td width="240" align="center" valign="middle">
                        <?php
                            $consulta="select cod_zona, zona from u_zona";
                            $result=query($consulta);
                            echo '<select name="cmbZona" id="cmbZona" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"><option value = "-1">--TODOS--</option>';
                            while($zona_aux=mysql_fetch_object($result))
                                {		
                                        $zona_nom = utf8_encode($zona_aux->zona);
                                        echo '<option value="'. $zona_aux->cod_zona .'">'.$zona_nom.'</option>';
                                }
                        ?>
                   </td>
                    <td width="140" align="center" bgcolor='#000000'><font color='#ffffff' size='2' face='Arial, Helvetica, sans-serif'><strong><left>Mes</left></strong></font></td>
                    <td width="240" align="center" valign="middle">
                        <?php
                            $consulta="select codigo , valor from catalogo where tipo ='meses'";
                            $result=query($consulta);
                            echo '<select name="cmbMeses" id="cmbMeses" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"><option value = "-1">--TODOS--</option>';
                            while($mes_aux=mysql_fetch_object($result))
                                {		
                                        $valor = utf8_encode($mes_aux->valor);
                                        echo '<option value="'. $mes_aux->codigo .'">'.$valor.'</option>';
                                }
                        ?>
                    </td>
                    <td width="140" align="center" bgcolor='#000000'><font color='#ffffff' size='2' face='Arial, Helvetica, sans-serif'><strong><left>Año</left></strong></font></td>
                    <td width="240" align="center" valign="middle">
                        <?php                            
                            echo '<select name="cmbAnios" id="cmbAnios" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"><option value = "-1">--TODOS--</option>';
                            $anioActual = date('Y');
                            for($i = 2017; $i <= $anioActual; $i++)
                                {                            
                                    echo '<option value="'. $i .'">'.$i.'</option>';
                                }
                        ?>                    
                    </td>
                   <td colspan="2" width="88" align="center" valign="middle">
                         <input name='btnBuscar' id='btnBuscar' type='button' value="          Buscar" style='background-image:url(../../images/buscar.jpg);background-repeat:no-repeat;height:32px;width:90px;background-position:left; cursor: pointer;' onclick='reporte(document.form1.cmbIndicador.value, document.form1.cmbMeses.value, document.form1.cmbZona.value, document.form1.cmbAnios.value);'>
                   </td>
              </tr>
              <tr>
                    <td colspan="9" width="140" height="30">
                     <input name='btnExportar' id='btnExportar' type='button' value="   Exportar" style='background-image:url(../../images/export.gif);background-repeat:no-repeat;height:32px;width:90px;background-position:left; cursor: pointer;' onclick='exportarExcell();'>
                     
                     </td>
                      
			</tr>      
</table>
<table style="border-style:none" align="center">               
                 <tr>
                    <td width="50" align="center" bgcolor='#8DB4E3'><font color='#000000' size='2' face='Arial, Helvetica, sans-serif'><strong><left>Nº</left></strong></font></td>
                    <td width="600" align="center" bgcolor='#8DB4E3'><font color='#000000' size='2' face='Arial, Helvetica, sans-serif'><strong><left>INDICADORES N4</left></strong></font></td>
                    
                    <td width="140" align="center" bgcolor='#8DB4E3'><font color='#000000' size='2' face='Arial, Helvetica, sans-serif'><strong><left>DIRECCIÓN ZONAL</left></strong></font></td>
                    
                    <td width="140" align="center" bgcolor='#8DB4E3'><font color='#000000' size='2' face='Arial, Helvetica, sans-serif'><strong><left>MES</left></strong></font></td>
                    
                    <td width="140" align="center" bgcolor='#8DB4E3'><font color='#000000' size='2' face='Arial, Helvetica, sans-serif'><strong><left>META PROGRAMADA</left></strong></font></td>
                    
                    <td width="140" align="left" bgcolor='#8DB4E3'><font color='#000000' size='2' face='Arial, Helvetica, sans-serif'><strong><left>META EJECUTADA</left></strong></font></td>
                 </tr>             
                 <?php
						$consulta="select indicador from indicador where departamento = 'FA' and estado = 1";
						$result=query($consulta);
						$contador = 1;
						/*echo '<select name="cmbZona" id="cmbZona" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"><option value = "-1">--TODOS--</option>';*/
						while($indicadores=mysql_fetch_object($result))
							{		
								//$indicador = utf8_encode($indicadores->indicador);
								$indicador = $indicadores->indicador;
							echo '<tr>
									<td width="50" align="center" bgcolor="#93CDDD">'.$contador.'</td>
									<td align="left" bgcolor="#93CDDD"><left>'.$indicador.'</left></td>
									<td align="center" bgcolor="#D99795"><left>-</left></td>
									<td align="center" bgcolor=""><left>-</left></td>
									<td align="center" bgcolor="#D7E4BC"><left>-</left></td>
									<td align="center" bgcolor="#93CDDD"><left>-</left></td>
								 </tr>';
								 $contador = $contador + 1;
							 }
					?>
				<tr> 
                	<td colspan="4" align="center"><strong><left>TOTAL METAS</left></strong></td>                    
                    <td align="left"><strong><left></left></strong></td>                    
                    <td align="left"><strong><left></left></strong></td>                                       
                </tr>
            </table>
    </form>
</div>
<script type="text/javascript">
function exportarExcell() {
	//alert("*************************function exportarExcell******************************");
	//if (com == 'Exportar') {
		     $.ajax({  
                 type: "GET",  
                 url: "../../clases/BusquedaGeneralExcel.php",
				 data:'cod_indicador='+$('#cmbIndicador').val()+'&cod_mes='+$('#cmbMeses').val()+'&cod_zona='+$('#cmbZona').val()+'&anio='+$('#cmbAnios').val(),	
                 success: function(html){  
					    $("#datos_a_enviar").val(html);
     				 $("#FormularioExportacion").submit();	 
               }  
             });  
	//} 
}
</script> 
</body>
</html>            
