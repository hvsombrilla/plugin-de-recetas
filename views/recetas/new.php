<div class="receta-wrap">
<link rel="stylesheet"
      href="<?php echo esc_url( plugins_url( 'f.css', __FILE__ ) )?>">
<div class="row">
	<div class="col-md-6">
    <div class="row">
         <div class="col-md-3" id ="select1">
         </div>
         <div class="col-md-3" id="select2" >
         </div>
         <div class="col-md-3" id="select3">
         </div>
        <div class="col-md-3" id="button1">
            <a style="background-color: white;color: #00776d; border: #00776d solid;" href="" class="btn btn-primary btn-block " id="search-btn">Buscar</a>
        </div>

    </div>
    <div class="row mt-2 nodisplay" >
        <div class="col-md-8">
            <input type="text" placeholder="<?php _e("Buscar..."); ?>" class="form-control "  id="search-term">
        </div>
    </div>
    <div class="mt-3">
       <div  id="products-catalog">
       </div>
	 </div>
     <div class="row add-otras-presc">
        <div class="col-md-6">
				<h3 style ="color: #00776d" for="" class="barra-baja">Otras <span class="font-weight-lighter">Prescripciones:</span></h3>
			</div>
			<div class="col-md-6 text-right">
				<span id="addOtherPresc"><i class="fa fa-plus-circle"></i></span>
			</div>
	 </div>
     <div class="">
			<label for="" class="barra-baja"><span class="font-weight-lighter">Anotaciones</span> Finales:</label>
			<textarea name="" id="receta-comentario" cols="30" rows="5" class="form-control"></textarea>	
		</div>
         <div class="mt-3">
            <input style="width:200px" type="submit" class="btn btn-primary btn-block" id="addPaciente" value="Enviar Receta">
        </div>
	</div>
  	<div class="col-md-6">
    <div class="green-box">
	     <h3>Receta</h3>
         <ul class="list-group receta-ul">
         </ul>
    </div>
   </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.full.min.js"></script>
</div>
<?php include_once esc_url( plugins_url( 'm.php', __FILE__ ) );?>
<script type="text/javascript" src="<?php echo esc_url( plugins_url( 'f.js', __FILE__ ) )?>"></script>

<?php
put_meta_select("category" ,"search-cat");
put_meta_select("marcas" ,"search-marca");
put_meta_select("marcas" ,"search-marca1");

function put_meta_select($t ,$i){
    $c = get_terms($t);
    foreach ($c as $s) {
        ?>
        <script>
            var z = document.createElement("option");
            z.setAttribute("value", "<?php echo $s->term_id?>");
            var t = document.createTextNode("<?php echo $s->name?>");
            z.appendChild(t);
            document.getElementById("<?php echo $i ?>").appendChild(z);
        </script>

        <?php

    }

}