<div class="receta-wrap">
	
<div class="row">
	<div class="col-md-6">


<div class="row">

		<div class="col-md-4">
		<select name="" id="search-cat" class="form-control">
			<option value=""><?php _e("Todas tipo"); ?></option>
<?php 
$marcas = get_terms('category');

foreach ($marcas as $marca) { ?>
	<option value="<?php echo $marca->term_id; ?>"><?php echo $marca->name; ?></option>
<?php }
			 ?>

		</select>
	</div>


	<div class="col-md-4">
		<select name="" id="search-marca" class="form-control">
			<option value=""><?php _e("Todas las marcas"); ?></option>
			<?php 
$marcas = get_terms('marcas');

foreach ($marcas as $marca) { ?>
	<option value="<?php echo $marca->term_id; ?>"><?php echo $marca->name; ?></option>
<?php }
			 ?>

		</select>
	</div>




	<div class="col-md-4">
		<select name="" id="search-marca" class="form-control">
			<option value=""><?php _e("Todas las marcas"); ?></option>
			<?php 
$marcas = get_terms('marcas');

foreach ($marcas as $marca) { ?>
	<option value="<?php echo $marca->term_id; ?>"><?php echo $marca->name; ?></option>
<?php }
			 ?>

		</select>
	</div>



</div>
<div class="row mt-2">

	<div class="col-md-8">
		<input type="text" placeholder="<?php _e("Buscar..."); ?>" class="form-control"  id="search-term">
	</div>
	<div class="col-md-4">
		<a href="" class="btn btn-primary btn-block " id="search-btn"><i class="fa fa-search"></i></a>
	</div>

</div>


	

		<div class="mt-3">

			<div  id="products-catalog">
				
			</div>
			
		</div>



		<div class="row add-otras-presc">

			<div class="col-md-6">
				<label for="" class="barra-baja">Otras <span class="font-weight-lighter">Prescripciones:</span></label>
			</div>
			<div class="col-md-6 text-right">
				<span id="addOtherPresc"><i class="fa fa-plus-circle"></i></span>
			</div>
			
			
		</div>



		<div class="">
			<label for="" class="barra-baja"><span class="font-weight-lighter">Anotaciones</span> Finales:</label>
			<textarea name="" id="receta-comentario" cols="30" rows="5" class="form-control"></textarea>	
		</div>


	</div>

	<div class="col-md-6">
<div class="green-box">
	

		<h3>Receta</h3>

 <ul class="list-group receta-ul">


                    
</ul>


		<div class="mt-3">
			<input type="submit" class="btn btn-primary btn-block" id="addPaciente" value="Finalizar Receta">
		</div>
</div>

	</div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.full.min.js"></script>




</div>



<!-- Inicio Modal Add Item -->

<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php _e('Añadir a la Receta'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      	<h5 id="item-to-add-title"></h5>
      	<input type="hidden" id="item-to-add-id">
        <div class="row">
        	<div class="col-md-6 text-center">
        		<img src="" alt="" id="item-to-add-image">
        	</div>
        	<div class="col-md-6">
     
		<div>

			
			<label for="">Dosis:</label>

		
			<input class="form-control update-full-dosis" id="dosis" placeholder="Dosis" required>
		</div>




		<div>

			
			<label for="">Frecuencia</label>

<div class="row">
	<div class="col-4">
		<input type="number" class="form-control update-full-dosis" id="frecuency_times" value="2" required>
	</div>


	<div class="col-8">
		<select name="" id="frecuency_cicles"  class="form-control update-full-dosis" required >
				<option value="Horas">Horas</option>
				<option value="Días">Días</option>
				<option value="Semanas">Semana(s)</option>
				<option value="Mes">Mes(es)</option>
		</select>
	</div>
</div>
			

		</div>


<div>

			
			<label for="">Duración:</label>

<div class="row">
	<div class="col-4">
		<input type="number" class="form-control update-full-dosis" id="time_times" value="2" required>
	</div>


	<div class="col-8">
		<select name="" id="time_cicles"  class="form-control update-full-dosis" required >
				<option value="Días">Días</option>
				<option value="Semanas">Semana(s)</option>
				<option value="Mes">Mes(es)</option>
		</select>
	</div>
</div>
			
		</div>
	

        	</div>
        	
        </div>

<div class="dosis-full-container mt-3">
	<textarea name="" id="dosis_full" cols="30" rows="3" class="form-control"></textarea>
</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e('Cancel'); ?></button>
        <button type="button" class="btn btn-primary"   id="addToList" ><?php _e('Añadir a la Receta'); ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Fin Modal Add Item -->




<!-- Inicio Modal Add Item -->

<div class="modal fade" id="clientAndProtocoles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php _e('Nombre del Paciente y Protocolos'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<div class="form-group">
				<label for="">Nombre de Paciente:</label>
				<input type="text" id="paciente-name" class="form-control" placeholder="<?php _e( 'Ej: Juan Perez' )?>">
			</div>
			<h3>Protocolos</h3>

			 <?php
			 $protocolos = get_posts(['post_type' => 'protocolo']);
			  foreach ($protocolos as $protocolo): ?>
			 	<input type="checkbox" name="protocolo[]" value="<?php echo $protocolo->ID; ?>"> <?php echo $protocolo->post_title; ?><br>
			 <?php endforeach; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e('Cancel'); ?></button>
        <button type="button" class="btn btn-primary"   id="saveRecipe" ><?php _e('Guardar'); ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Fin Modal Add Item -->

<!-- Inicio Modal Otra Prescripcion -->

<div class="modal fade" id="addPrescriptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php _e('AddPrescription'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<div class="form-group">
				<label for="">Otra Prescripción:</label>
				<textarea name="" id="otra-presc" cols="30" rows="3" class="form-control"></textarea>
			</div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e('Cancel'); ?></button>
        <button type="button" class="btn btn-primary"   id="saveOtherPresc" ><?php _e('Add'); ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Fin Modal Otra Prescripcion-->

