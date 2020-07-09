<?php 

function recetaMedicaShowView($view) {

	ob_start();
	include(RECETA_MEDICA_PATH . '/views/'.$view.'.php');
	$content = ob_get_contents();
	ob_clean();
	return $content;
}

function newIndicationForm( $atts, $content = null ) {

	ob_start();
	include(RECETA_MEDICA_PATH . '/views/recetas/new.php');
	$content = ob_get_contents();
	ob_clean();
	return $content;
}


add_shortcode( 'new-rec', function(){
	if (empty($_GET['receta'])) {
		return recetaMedicaShowView('recetas/new');
	} else {
		return recetaMedicaShowView('recetas/view');
	}

	
	
} );

