<?php 

/**
 * Prodocolo Class
 */
class recetasProtocolo
{
	
	function __construct()
	{
		sombrilla_post_type('protocolo');
		$this->customFields();
	}


	function customFields(){
		$boxPosts = sombrilla_metabox('Protocolo');
		$boxPosts->addScreen('protocolo');
		$boxPosts->setCallback(function () {
		    $form = sombrilla_form();
		    echo $form->image('Archivo');

		   
		});

	}
}

new recetasProtocolo();