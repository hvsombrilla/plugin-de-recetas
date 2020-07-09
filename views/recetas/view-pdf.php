<?php 
GLOBAL $wpdb;
$recetaid = (int) $id;
$receta = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}recetas WHERE id = {$recetaid}");
$recetaItems = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}recetas_items WHERE rid = {$receta->id}");
$usermeta = get_user_meta($receta->doctor);
$logo =  (!empty($usermeta['centro-image'][0])) ? $usermeta['centro-image'][0]: get_bloginfo('template_url') . '/img/logo-grande.png';
$firma =  (!empty($usermeta['doctor-firma-image'][0])) ? $usermeta['doctor-firma-image'][0]: get_bloginfo('template_url') . '';
 ?><!DOCTYPE html>
<html>
<head>
	<title>Receta</title>
    <link rel="stylesheet"
          href="<?php echo esc_url( plugins_url( 's.css', __FILE__ ) )?>">
</head>
<body>

<div class="container">
	
	<div class="row">
		<div class="col-md-6">
			<div class="p-4"><img src="<?php echo $logo; ?>" alt="Logo" class="img-fluid" height="80px" ></div>
			
		</div>
		<div class="col-md-6 text-right">
			<div class="p-4">
				<b>Fecha de receta:</b> <?php echo date('d-m-Y', $receta->time); ?> <br>
				<b><?php echo $usermeta['centro_address'][0]; ?></b><br>
				<b>Tel:</b> <?php echo $usermeta['centro_phone'][0]; ?><br>
				<b>email:</b> <?php echo $usermeta['user_email'][0]; ?>
			</div>
 	 	</div>
	</div>
 	<div class="p-4">
		Plan de medicación de: <br>
		<?php echo $receta->paciente; ?>
 	</div>
 <div class="box">
		<h1 class="big-title">Receta Médica</h1>
	</div>
 <?php foreach ($recetaItems as $item):
 $imagen    = wp_get_attachment_image_src(get_post_meta($item->pid, 'imagen', true), 'full');
 	 ?>
<div class="row box">
	<div class="col-6 text-center">
		<img src="<?php echo $imagen[0]; ?>" class="img-fluid" alt="">
	</div>
	<div class="col-6">
		<div class="p-4">
		<h4><?php echo productName($item->pid); ?> </h4>
     	<?php echo _e($item->dosis_full); ?>
    </div>
   </div>
</div>
 	<?php endforeach ?>
 <div class="box">
		<h2>Comentarios</h2>
 	<p><?php echo $receta->comentario; ?></p>
 <p class="firma">
		<img src="<?php echo $firma; ?>" alt="Logo" class="img-fluid" height="80px" >
	</p>
 	<p class="disclaimer"><?php _e('* espacio reservado para los avisos legales y los relacionados con los antibióticos.'); ?></p>
	</div>
</div>
<?php if (!empty($_GET['print'])): ?>
	<script type="text/javascript">
		window.print();
	</script>	
<?php endif ?>

</body>
</html>