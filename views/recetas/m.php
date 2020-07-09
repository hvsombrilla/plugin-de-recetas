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
                                <div class="col-8" id="select4">

                                </div>
                            </div>
                        </div>
                        <div><label for="">Duración:</label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="number" class="form-control update-full-dosis" id="time_times" value="2" required>
                                </div>
                                <div class="col-8" id ="select5">

                                </div>
                            </div> </div> </div> </div>
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