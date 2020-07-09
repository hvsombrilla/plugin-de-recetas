<?php
/*
Plugin Name: Receta Medica
Plugin URI: http://hvsombrilla.com
Description: Plugin hecho a la medida para registro de recetas.
Author: HV Sombrilla
Version: 1.2
Author URI: http://hvsombrilla.com/
*/


define('RECETA_MEDICA_PATH', dirname(__FILE__));
define('RECETA_MEDICA_URL', plugin_dir_url( __FILE__ ));

include(RECETA_MEDICA_PATH . '/includes/framework/init.php');
include(RECETA_MEDICA_PATH . '/includes/helpers.php');
include(RECETA_MEDICA_PATH . '/includes/shortcodes.php');
include(RECETA_MEDICA_PATH . '/includes/medicamentos.php');
include(RECETA_MEDICA_PATH . '/includes/protocolos.php');
include(RECETA_MEDICA_PATH . '/includes/RecetaClass.php');



add_action( 'wp_enqueue_scripts', function(){
	wp_enqueue_style( 'receta-style', RECETA_MEDICA_URL ."assets/css/style.css",[], uniqid() );
} );



sombrilla_route()->get('/recetas-api/get-products', function(){
	$recetaClass = new RecetaClass();
	$recetaClass->getProducts();
});


sombrilla_route()->post('/recetas-api/save', function(){
	$recetaClass = new RecetaClass();
	$recetaClass->save();
});

sombrilla_route()->get('/recetas-api/get-product/{pid}', function($pid){
	$recetaClass = new RecetaClass();
	$recetaClass->getProduct($pid);
});


sombrilla_route()->get('/view-receta/{id}', function($id){
	include(RECETA_MEDICA_PATH . '/views/recetas/view-pdf.php');
	exit();
});

sombrilla_route()->get('/download-receta/{id}', function($id){

	GLOBAL $wpdb;
	$receta = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}recetas WHERE id = {$id}");

	if (get_current_user_ID() != $receta->doctor) {
		exit("No estás autorizado a ver esta receta");
	}
	
	$recetaClass = new RecetaClass();

	

	$file_url = $recetaClass->generatePDF($id);
	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
	readfile($file_url); 


	exit();
});
