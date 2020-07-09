<?php 
GLOBAL $wpdb;
$recetaid = (int) $_GET['receta'];
$receta = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}recetas WHERE id = {$recetaid}");
$recetaItems = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}recetas_items WHERE rid = {$receta->id}");
$recetaPrescs = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}recetas_prescriptions WHERE rid = {$receta->id}");
$protocolos = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}recetas_protocolos WHERE rid = {$recetaid}");

if (isset($_POST['correo'])) {
	$recetaClass = new RecetaClass();


$filesToAttach = [];
	

	$filesToAttach[] = $recetaClass->generatePDF($recetaid);

	foreach ($protocolos as $prt) {
		$filesToAttach[] = get_attached_file(get_post_meta($prt->pid, 'archivo', true) );
	}



        $contentEmail = 'Adjunta esta la receta';
     //   $contentEmail = str_replace(['{nombre}', '{apellido}'], [$data['post']['client_name'], $data['post']['client_lastname']], $contentEmail);

      //  $asuntoEmail = get_option('asunto_del_correo', '');
      //  $asuntoEmail = str_replace(['{nombre}', '{apellido}'], [$data['post']['client_name'], $data['post']['client_lastname']], $asuntoEmail);

        $to = $_POST['correo'];

        $subject = 'Hola ' . $_POST['paciente'] . ', aquí está tu receta';

        $headers = array('Content-Type: text/html; charset=UTF-8');

    //    include COTIZADOR_PLUGIN_DIR . 'views/cotizacion-options.php';

       wp_mail($to, $subject, $contentEmail, $headers, $filesToAttach);
}
 ?>

<div class="receta-wrap">
<div class="row">
	<div class="col-md-6">
		<div class="green-box">

			<h3>Receta</h3>
			 <ul class="list-group receta-ul">

			 	<?php foreach ($recetaItems as $item): ?>
			 		 <li class="list-group-item barra-baja"><?php echo productName($item->pid); ?> 
			 		 <span class="receta-dosis"><?php echo _e($item->dosis_full); ?></span> 
	 				</li>
			 	<?php endforeach ?>




	         </ul>
  <h5>Otras <span class="font-weight-lighter">Prescripciones:</span></h5>

	         <ul class="list-group receta-ul">



			 	<?php foreach ($recetaPrescs as $item): ?>
			 		 <li class="list-group-item barra-baja"><?php echo $item->title; ?> 
			 		 
	 				</li>
			 	<?php endforeach ?>


	         </ul>


	         <h5><span class="font-weight-lighter">Anotaciones</span> Finales:</h5>

	         <div class="comentario">
	         	<?php echo wpautop($receta->comentario); ?>
	         </div>			

	          <h5>Protocolos:</h5>
			 <ul class="list-group receta-ul protocolos">
<?php 

foreach ($protocolos as $prot) {
 ?>


	<li class="list-group-item"><i class="fa fa-file-pdf text-danger"></i> <?php echo get_the_title($prot->pid); ?>


	 				</li>
<?php } ?>
</ul>

		</div>	

	</div>


	<div class="col-md-6">

		<div>
			<form action="" method="POST">
				<div class="form-group">
					<label for=""><?php _e( 'Nombre del Paciente:' )?></label>
					<input type="text" name="paciente" placeholder="<?php _e( 'Nombre del paciente' )?>" class="form-control" value="<?php echo $receta->paciente; ?>">
				</div>

				<div class="form-group">
					<label for=""><?php _e( 'Correo Electrónico:' )?></label>
					<input type="text" name="correo" placeholder="<?php echo _e("Email del paciente"); ?>" class="form-control">

				</div>


<div class="botones">
	<input type="submit" value="Enviar por Correo"  class="btn btn-primary" >
			<!-- <a href="" class="btn btn-primary"><i class="fa fa-envelope"></i> <?php echo __("Enviar por Email"); ?></a> -->
			<a href="" class="btn btn-info" onclick="imprimir(<?php echo $recetaid; ?>);"><i class="fa fa-print"></i> <?php echo __("Print"); ?></a>
			<a href="/download-receta/<?php echo $recetaid; ?>" class="btn btn-danger"><i class="fa fa-file-pdf"></i> <?php echo __("Guardar PDF"); ?></a>			
		</div>
			</form>
		</div>
	

		

	</div>

<script type="text/javascript">
	
	function imprimir(id){
		window.open("/view-receta/<?php echo $recetaid; ?>/?print=1");
	}
</script>
</div>

</div>