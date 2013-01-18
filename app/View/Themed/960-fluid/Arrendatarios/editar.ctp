<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido(strtolower($this->name), $this->Session->read('Arrendatario.id'), $this->Session->read('Arrendatario.nombre_completo')); ?>
</div>

<?php echo '<pre>'; ?>
<?php print_r($this->request->data); ?>
<?php echo '</pre>'; ?>

<?php
 /* Cambiar el número iniFormsCount de sheepIt si hay datos para que los muestre */
 /* Preparar los datos para una inyección a sheepIt de haberlos */
 $ini_f = sizeof($this->request->data['ArrendatarioFuneraria']);
 if ($ini_f > 0) {
  $data_f = array();
  foreach($this->request->data['ArrendatarioFuneraria'] as $funeraria) {
   array_push($data_f, array("ArrendatarioFuneraria#index#FunerariaBonita" => $funeraria['funeraria_bonita'], "ArrendatarioFuneraria#index#FunerariaId" => $funeraria['funeraria_id']));
  }
  $data_f = json_encode($data_f);
 }
 else {
  $data_f = "[]";
 }
 
 $ini_t = sizeof($this->request->data['ArrendatarioTumba']);
 if ($ini_t > 0) {
  $data_t = array();
  foreach($this->request->data['ArrendatarioTumba'] as $tumba) {
   array_push($data_t, array("ArrendatarioTumba#index#TumbaBonita" => $tumba['tumba_bonita'], "ArrendatarioTumba#index#TumbaId" => $tumba['tumba_id'], "ArrendatarioTumba#index#FechaBonita" => $tumba['fecha_bonita'], "ArrendatarioTumba#index#FechaArrendamiento" => $tumba['fecha_arrendamiento'], "ArrendatarioTumba#index#Estado" => $tumba['estado']));
  }
  $data_t = json_encode($data_t);
 }
 else {
  $data_t = "[]";
 }
?>

<script>
 function autoFunerarias (campo) {
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#" + campo + "FunerariaBonita").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'funerarias', 'action' => 'autocomplete')); ?>",
         dataType: "json",
         type: "GET",
         data: {
           term: request.term
         },
         timeout: 2000,
         success: function(data) {
           response( $.map(data, function(x) {
             return {
               label: x.label,
               value: x.value
             }
           }));
         }
       });
     },
     minLength: 1,
     select: function(event, ui) {
       event.preventDefault(),
       $("#" + campo + "FunerariaBonita").val(ui.item.label),
       $("#" + campo + "FunerariaId").val(ui.item.value)
     },
     open: function() {
       $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
     },
     close: function() {
       $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
     }
   });
 };
 
 function autoTumbas (campo) {
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#" + campo + "TumbaBonita").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'tumbas', 'action' => 'autocomplete')); ?>",
         dataType: "json",
         type: "GET",
         data: {
           term: request.term
         },
         timeout: 2000,
         success: function(data) {
           response( $.map(data, function(x) {
             return {
               label: x.label,
               value: x.value
             }
           }));
         }
       });
     },
     minLength: 1,
     select: function(event, ui) {
       event.preventDefault(),
       $("#" + campo + "TumbaBonita").val(ui.item.label),
       $("#" + campo + "TumbaId").val(ui.item.value)
     },
     open: function() {
       $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
     },
     close: function() {
       $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
     }
   });
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#" + campo + "FechaBonita").datepicker({
     altField: "#" + campo + "FechaArrendamiento",
     altFormat: "yy-mm-dd",
     buttonImage: "calendario.gif",
     changeMonth: true,
     changeYear: true,
     selectOtherMonths: true,
     showAnim: "slide",
     showOn: "both",
     showButtonPanel: true,
     showOtherMonths: true,
     showWeek: true,
   });
 };
</script>

<script>
 $(function() {
   /* Formulario sheepIt para agregar funerarias */
   $("#SubFormularioFuneraria").sheepIt({
     separator: '',
     allowRemoveLast: true,
     allowRemoveCurrent: true,
     allowRemoveAll: true,
     allowAdd: true,
     allowAddN: false,
     maxFormsCount: 100,
     minFormsCount: 0,
     iniFormsCount: <?php echo h($ini_f); ?>,
     removeAllConfirmationMsg: '¿Eliminar todas las funerarias asociadas?',
     data: <?php echo $data_f; ?>
   });
   /* Formulario sheepIt para agregar tumbas */
   $("#SubFormularioTumbas").sheepIt({
     separator: '',
     allowRemoveLast: true,
     allowRemoveCurrent: true,
     allowRemoveAll: true,
     allowAdd: true,
     allowAddN: false,
     maxFormsCount: 100,
     minFormsCount: 0,
     iniFormsCount: <?php echo h($ini_t); ?>,
     removeAllConfirmationMsg: '¿Eliminar todas las tumbas asociadas?',
     data: <?php echo $data_t; ?>
   });
 });

</script>

<?php /* Formulario arrendatario */ ?>
<div class="edit form">
 <?php echo $this->Form->create('Arrendatario'); ?>
  <fieldset>
   <legend><?php echo __('Datos del arrendatario'); ?></legend>
   <?php
    echo $this->Form->input('Persona.nombre', array('label' => 'Nombre:'));
    echo $this->Form->input('Persona.apellido1', array('label' => 'Primer apellido:'));
    echo $this->Form->input('Persona.apellido2', array('label' => 'Segundo apellido:'));
    echo $this->Form->input('Persona.dni', array('label' => 'D.N.I.:'));
    echo $this->Form->input('Arrendatario.direccion', array('label' => 'Dirección:'));
    echo $this->Form->input('Arrendatario.localidad', array('label' => 'Localidad:'));
    echo $this->Form->input('Arrendatario.provincia', array('label' => 'Provincia:'));
    echo $this->Form->input('Arrendatario.pais', array('label' => 'País:'));
    echo $this->Form->input('Arrendatario.codigo_postal', array('label' => 'Código postal:'));
    echo $this->Form->input('Arrendatario.telefono', array('label' => 'Teléfono:'));
    echo $this->Form->input('Arrendatario.correo_electronico', array('label' => 'Correo electrónico:'));
    echo $this->Form->input('Persona.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Funerarias contratadas'); ?></legend>
   
   <div id="SubFormularioFuneraria">
    
    <div id="SubFormularioFuneraria_template">
     <?php /* Campos */
      echo $this->Form->input('ArrendatarioFuneraria.#index#.funeraria_bonita', array('label' => 'Funeraria:', 'onFocus' => 'autoFunerarias("ArrendatarioFuneraria#index#")')); //Campo imaginario
      echo $this->Form->input('ArrendatarioFuneraria.#index#.funeraria_id', array('type' => 'hidden'));
     ?>
     <a id="SubFormularioFuneraria_remove_current" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'class' => 'delete', 'style' => 'height:16px; width:16px;')); ?> </a>
    </div>
    
    <div id="SubFormularioFuneraria_noforms_template">No hay funerarias contratadas</div>
    
    <div id="SubFormularioFuneraria_controls">
     <a id="SubFormularioFuneraria_add" class="boton"> <?php echo $this->Html->image('nuevo.png', array('alt' => 'nuevo', 'style' => 'height:24px; width:24px;')) . ' Añadir funeraria'; ?> </a>
     <a id="SubFormularioFuneraria_remove_last" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'style' => 'height:24px; width:24px;')) . ' Eliminar última funeraria'; ?> </a>
     <a id="SubFormularioFuneraria_remove_all" class="boton"> <?php echo $this->Html->image('limpiar.png', array('alt' => 'limpiar', 'style' => 'height:24px; width:24px;')) . ' Eliminar todas las funerarias'; ?> </a>
    </div>
    
   </div>
   
 </fieldset>
 <fieldset>
  <legend><?php echo __('Tumbas arrendadas'); ?></legend>
  
  <div id="SubFormularioTumbas">
   
   <div id="SubFormularioTumbas_template">
    <?php /* Campos */
     echo $this->Form->input('ArrendatarioTumba.#index#.tumba_bonita', array('label' => 'Tumba:', 'onFocus' => "autoTumbas('ArrendatarioTumba#index#')")); //Campo imaginario
     echo $this->Form->input('ArrendatarioTumba.#index#.tumba_id', array('type' => 'hidden'));
     echo $this->Form->input('ArrendatarioTumba.#index#.fecha_bonita', array('label' => 'Fecha de arrendamiento:')); //Campo imaginario
     echo $this->Form->input('ArrendatarioTumba.#index#.fecha_arrendamiento', array('type' => 'hidden'));
     echo $this->Form->input('ArrendatarioTumba.#index#.estado', array('label' => 'Estado del arrendamiento:', 'type' => 'select', 'options' => $estado, 'empty' => ''));
    ?>
    <a id="SubFormularioTumbas_remove_current" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'class' => 'delete', 'style' => 'height:16px; width:16px;')); ?> </a>
   </div>
   
   <div id="SubFormularioTumbas_noforms_template">No hay tumbas arrendadas</div>
   
   <div id="SubFormularioTumbas_controls">
    <a id="SubFormularioTumbas_add" class="boton"> <?php echo $this->Html->image('nuevo.png', array('alt' => 'nuevo', 'style' => 'height:24px; width:24px;')) . ' Añadir tumba'; ?> </a>
    <a id="SubFormularioTumbas_remove_last" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'style' => 'height:24px; width:24px;')) . ' Eliminar última tumba'; ?> </a>
    <a id="SubFormularioTumbas_remove_all" class="boton"> <?php echo $this->Html->image('limpiar.png', array('alt' => 'limpiar', 'style' => 'height:24px; width:24px;')) . ' Eliminar todas las tumbas'; ?> </a>
   </div>
   
  </div>
  
 </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Modificar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Descartar cambios'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
