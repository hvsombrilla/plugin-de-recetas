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


add_shortcode( 'nueva-receta', function(){
	if (empty($_GET['receta'])) {
		return recetaMedicaShowView('recetas/new');
	} else {
		return recetaMedicaShowView('recetas/view');
	}

	
	
} );

add_shortcode( 'editar-perfil', function(){
	return recetaMedicaShowView('perfil/editar');
});

add_shortcode( 'historial-recetas', function(){
	if (empty($_GET['receta'])) {
		return recetaMedicaShowView('recetas/historial');
	} else {
		return recetaMedicaShowView('recetas/view');
	}
	
	
});