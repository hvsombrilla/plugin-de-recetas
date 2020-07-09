<?php

//PostType
sombrilla_post_type('Productos', ['supports' => ['title']]);

//Taxonomias
sombrilla_taxonomy('Marcas')->addPostType('productos');

//Custom Fields

$box = sombrilla_metabox('Ficha del Medicamento');
$box->addPostType(['productos']);
$box->setCallback(function () {
    $form = sombrilla_form();
    echo $form->image('Imagen');
    echo $form->text('Nombre Tecnico')->setHelp("Nombre con que aparecerá en la receta");
    echo $form->items('Dosis Recomendadas');
    echo $form->text('Detalle');
});

add_role( 'medico', __('Medico'), [ 'read' => true, 'edit_posts' => true] );
