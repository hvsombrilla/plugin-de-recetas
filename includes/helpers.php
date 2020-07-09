<?php 

function productName($pid){


	$name = get_post_meta($pid, 'nombre_tecnico', true);

	if (empty($name)) {
		$name = get_the_title( $pid);
	}

	return $name;
}