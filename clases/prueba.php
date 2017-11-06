<?php
$matrixMesZona = array();
$auxServicio = array(0, 0, 0, 0);

	//enceramos todos los datos de $matrixMesZona
	for($i = 0; $i < 9; $i++)
	{
		for($j = 0; $j < 12; $j++)
		{
			$matrixMesZona[$i][$j] = $auxServicio;
		}

	}

	print_r($matrixMesZona);
?>