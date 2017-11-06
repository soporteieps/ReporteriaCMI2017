
<?php
/*$client = new SoapClient('http://interoperabilidad.dinardap.gob.ec:7979/interoperador?wsdl');
var_dump($client->__getFunctions());*/

$servicio="http://interoperabilidad.dinardap.gob.ec:7979/interoperador?wsdl"; //url del servicio
$parametros=array(); //parametros de la llamada
$parametros['login']="iOpaDRIeps";
$parametros['password']="6Tmq[]3ic}";
$client = new SoapClient("http://interoperabilidad.dinardap.gob.ec:7979/interoperador?wsdl", $parametros);
var_dump($client->__getFunctions());
echo "<br>";
var_dump($client->__getTypes());

$valores = array();
$valores['numeroIdentificacion'] = "1712900032";
$valores['codigoPaquete'] = 185;
//print_r($valores);
echo "<br>";

try
{
	$res = $client->__soapCall("getFichaGeneral", array($valores));
	print_r2($res);

	echo $res->return->instituciones->datosPrincipales->registros[0]->valor. "*********************";

}
catch(SoapFault $exception)
{
	echo $exception;
}

function print_r2($val)
{
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}


/*$client = new SoapClient('http://interoperabilidad.dinardap.gob.ec:7979/interoperador?wsdl');
var_dump($client->__getTypes());*/
?>
