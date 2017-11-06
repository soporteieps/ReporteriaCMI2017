<?php
include '../lib/dbconfig.php';

$sql = "select fp.cod_u_organizaciones from fp_asesoria_asistencia_cofinanciamiento fp group by cod_u_organizaciones ";
$resOrg = query($sql);

$codOrg = array();

$aOrg = array();
while($fila = mysql_fetch_array($resOrg))
{
	//primer registro
	$sqlFR = "select cod_asesoria_asistencia_cofinanciamiento, fecha_registro from fp_asesoria_asistencia_cofinanciamiento where cod_u_organizaciones = " . $fila['cod_u_organizaciones'] . " and cod_servicio = 2 order by fecha_registro asc limit 1";

	$resSqlFr = query($sqlFR);
	while($fila1 = mysql_fetch_array($resSqlFr))
	{
		array_push($codOrg, $fila1['cod_asesoria_asistencia_cofinanciamiento']);
	}
}

for($i = 0; $i < count($codOrg); $i++)
{
	$sqlNumVen = "select count(*) as numSocios from socios s inner join fp_asesoria_asistencia_cofinanciamiento fp on (fp.cod_u_organizaciones = s.cod_u_organizaciones) where fp.cod_asesoria_asistencia_cofinanciamiento = " . $codOrg[$i];

	//echo $sqlNumVen . "<br>";

	$resSqlNumVen = query($sqlNumVen);

	while($fila = mysql_fetch_array($resSqlNumVen))
	{
		$numSocios = $fila['numSocios'];

		$sqlUpdate = "update fp_asesoria_asistencia_cofinanciamiento set num_personas_cofinanciamiento = " . $numSocios . " where cod_asesoria_asistencia_cofinanciamiento = " . $codOrg[$i];
		$resUpd = query($sqlUpdate);
	}
}

echo "Done!!";


?>