<div class="receta-wrap">
<?php 
GLOBAL $wpdb;
$doctor = get_current_user_ID();
$recetas = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}recetas WHERE doctor = {$doctor}");


 ?>	
	<table class="table">
		<thead>
			<th>ID</th>
			<th>Hora</th>
			<th>Comentario</th>
			<th>Acciones</th>
		</thead>

		<tbody>
			<?php foreach ($recetas as $receta): ?>
				
<tr>
	<td><?php echo $receta->id; ?></td>
	<td><?php printf( _x( '%1$s ago', '%2$s = human-readable time difference', 'wordpress' ),
    human_time_diff( $receta->time,
    current_time( 'timestamp' )
));
     ?></td>
	<td><?php echo wp_trim_words( $receta->comentario, 10); ?></td>
	<td>
		
<a href="" class="btn btn-primary"><i class="fa fa-eye"></i></a>
<a href="" class="btn btn-danger"><i class="fa fa-file-pdf"></i></a>
<!-- <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a> -->
	</td>
</tr>

			<?php endforeach ?>
		</tbody>
	</table>
</div>