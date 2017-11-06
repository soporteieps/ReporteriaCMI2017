<?php
include '../lib/dbconfig.php';

$sqlMod = "select cod_u_organizaciones, cod_zona, user
from u_organizaciones 
where cod_zona IS NULL";

$res = query($sqlMod);

$cont = 0;
while($fila = mysql_fetch_array($res))
{
	$cont++;
	if($cont > 9)
		$cont = 1;

	$sqlUpd = "update u_organizaciones set cod_zona = " . $cont . " where cod_u_organizaciones = " . $fila['cod_u_organizaciones'];

	$res1 = query($sqlUpd);

}

echo "Esto se cambio";


?>