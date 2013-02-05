<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($this->request->data);
 echo '</pre>';
 */
?>

<?php /* Cambiar el número iniFormsCount de sheepIt si hay datos para que los muestre */
 if (isset($this->request->data['ArrendatarioFuneraria'])) {
  $ini_f = sizeof($this->request->data['ArrendatarioFuneraria']);
  $data_f = array();
  foreach($this->request->data['ArrendatarioFuneraria'] as $funeraria) {
   array_push($data_f, array("ArrendatarioFuneraria#index#FunerariaBonita" => $funeraria['funeraria_bonita'], "ArrendatarioFuneraria#index#FunerariaId" => $funeraria['funeraria_id']));
  }
  $data_f = json_encode($data_f);
 }
 else {
  $ini_f = 0;
  $data_f = "[]";
 }
 
 if (isset($this->request->data['ArrendatarioTumba'])) {
  $ini_t = sizeof($this->request->data['ArrendatarioTumba']);
  $data_t = array();
  foreach($this->request->data['ArrendatarioTumba'] as $tumba) {
   array_push($data_t, array("ArrendatarioTumba#index#TumbaBonita" => $tumba['tumba_bonita'], "ArrendatarioTumba#index#TumbaId" => $tumba['tumba_id'], "ArrendatarioTumba#index#FechaBonita" => $tumba['fecha_bonita'], "ArrendatarioTumba#index#FechaArrendamiento" => $tumba['fecha_arrendamiento'], "ArrendatarioTumba#index#Estado" => $tumba['estado']));
  }
  $data_t = json_encode($data_t);
 }
 else {
  $ini_t = 0;
  $data_t = "[]";
 }
?>

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
     data: <?php echo $data_f; ?>,
     afterAdd: function(source, newForm) {
       /* Obtener identificadores de campos */
       var auto = "#" + $(newForm).children("div").children("input[id$='FunerariaBonita']").attr("id");
       var auto_oc = auto.replace("Bonita", "Id");
       
       /* Establecer opciones de 'UI Autocomplete' para jQuery */
       $(auto).autocomplete({
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
         minLength: 2,
         select: function(event, ui) {
           event.preventDefault(),
           $(auto).val(ui.item.label),
           $(auto_oc).val(ui.item.value)
         },
         open: function() {
           $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
         },
         close: function() {
           $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
         }
       });
     }
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
     data: <?php echo $data_t; ?>,
     afterAdd: function(source, newForm) {
       /* Obtener identificadores de campos */
       var auto = "#" + $(newForm).children("div").children("input[id$='TumbaBonita']").attr("id");
       var auto_oc = auto.replace("Bonita", "Id");
       var fecha = "#" + $(newForm).children("div").children("input[id$='FechaBonita']").attr("id");
       var fecha_oc = fecha.replace("Bonita", "Arrendamiento");
       
       /* Establecer opciones de 'UI Autocomplete' para jQuery */
       $(auto).autocomplete({
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
         minLength: 2,
         select: function(event, ui) {
           event.preventDefault(),
           $(auto).val(ui.item.label),
           $(auto_oc).val(ui.item.value)
         },
         open: function() {
           $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
         },
         close: function() {
           $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
         }
       });
       /* Establecer opciones de 'UI datepicker' para JQuery */
       $(fecha).datepicker({
         altField: fecha_oc,
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
     }
   });
 });

</script>

<?php /* Formulario nuevo arrendatario */ ?>
<div class="add form">
 <?php echo $this->Form->create('Arrendatario'); ?>
  <fieldset>
   <legend><?php echo __('Datos del arrendatario'); ?></legend>
   <?php
    echo $this->Form->input('Persona.nombre', array('label' => 'Nombre:'));
    echo $this->Form->input('Persona.apellido1', array('label' => 'Primer apellido:'));
    echo $this->Form->input('Persona.apellido2', array('label' => 'Segundo apellido:'));
    echo $this->Form->input('Persona.dni', array('label' => 'D.N.I.:'));
    echo $this->Form->input('Arrendatario.direccion', array('label' => 'Dirección:'));
    echo $this->Form->input('Arrendatario.localidad', array('label' => 'Localidad:', 'default' => 'Motril'));
    echo $this->Form->input('Arrendatario.provincia', array('label' => 'Provincia:', 'default' => 'Granada'));
    echo $this->Form->input('Arrendatario.pais', array('label' => 'País:', 'default' => 'España'));
    echo $this->Form->input('Arrendatario.codigo_postal', array('label' => 'Código postal:', 'default' => '18600'));
    echo $this->Form->input('Arrendatario.telefono', array('label' => 'Teléfono:'));
    echo $this->Form->input('Arrendatario.correo_electronico', array('label' => 'Correo electrónico:'));
    echo $this->Form->input('Persona.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Funerarias contratadas'); ?></legend>
   
   <!-- Formulario SheepIt -->
   <div id="SubFormularioFuneraria">
    
    <!-- Form template-->
    <div id="SubFormularioFuneraria_template">
     <?php /* Campos */
      echo $this->Form->input('ArrendatarioFuneraria.#index#.funeraria_bonita', array('label' => 'Funeraria:')); //Campo imaginario
      echo $this->Form->input('ArrendatarioFuneraria.#index#.funeraria_id', array('type' => 'hidden'));
     ?>
     <a id="SubFormularioFuneraria_remove_current" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'class' => 'delete', 'style' => 'height:16px; width:16px;')); ?> </a>
    </div>
    <!-- /Form template-->
     
    <!-- No forms template -->
    <div id="SubFormularioFuneraria_noforms_template">No hay funerarias contratadas</div>
    <!-- /No forms template-->
     
    <!-- Controls -->
    <div id="SubFormularioFuneraria_controls">
     <a id="SubFormularioFuneraria_add" class="boton"> <?php echo $this->Html->image('nuevo.png', array('alt' => 'nuevo', 'style' => 'height:24px; width:24px;')) . ' Añadir funeraria'; ?> </a>
     <a id="SubFormularioFuneraria_remove_last" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'style' => 'height:24px; width:24px;')) . ' Eliminar última funeraria'; ?> </a>
     <a id="SubFormularioFuneraria_remove_all" class="boton"> <?php echo $this->Html->image('limpiar.png', array('alt' => 'limpiar', 'style' => 'height:24px; width:24px;')) . ' Eliminar todas las funerarias'; ?> </a>
    </div>
    <!-- /Controls -->
    
   </div>
   <!-- /sheepIt Form -->
   
  </fieldset>
  <fieldset>
   <legend><?php echo __('Tumbas arrendadas'); ?></legend>
   
   <!-- Formulario SheepIt -->
   <div id="SubFormularioTumbas">
   
    <!-- Form template-->
    <div id="SubFormularioTumbas_template">
     <?php /* Campos */
      echo $this->Form->input('ArrendatarioTumba.#index#.tumba_bonita', array('label' => 'Tumba:')); //Campo imaginario
      echo $this->Form->input('ArrendatarioTumba.#index#.tumba_id', array('type' => 'hidden'));
      echo $this->Form->input('ArrendatarioTumba.#index#.fecha_bonita', array('label' => 'Fecha de arrendamiento:')); //Campo imaginario
      echo $this->Form->input('ArrendatarioTumba.#index#.fecha_arrendamiento', array('type' => 'hidden'));
      echo $this->Form->input('ArrendatarioTumba.#index#.estado', array('label' => 'Estado del arrendamiento:', 'type' => 'select', 'options' => $estado, 'empty' => ''));
     ?>
     <a id="SubFormularioTumbas_remove_current" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'class' => 'delete', 'style' => 'height:16px; width:16px;')); ?> </a>
    </div>
    <!-- /Form template-->
    
    <!-- No forms template -->
    <div id="SubFormularioTumbas_noforms_template">No hay tumbas arrendadas</div>
    <!-- /No forms template-->
    
    <!-- Controls -->
    <div id="SubFormularioTumbas_controls">
     <a id="SubFormularioTumbas_add" class="boton"> <?php echo $this->Html->image('nuevo.png', array('alt' => 'nuevo', 'style' => 'height:24px; width:24px;')) . ' Añadir tumba'; ?> </a>
     <a id="SubFormularioTumbas_remove_last" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'style' => 'height:24px; width:24px;')) . ' Eliminar última tumba'; ?> </a>
     <a id="SubFormularioTumbas_remove_all" class="boton"> <?php echo $this->Html->image('limpiar.png', array('alt' => 'limpiar', 'style' => 'height:24px; width:24px;')) . ' Eliminar todas las tumbas'; ?> </a>
    </div>
    <!-- /Controls -->
    
   </div>
   <!-- /sheepIt Form -->
   
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar'), array('type' => 'submit', 'name' => 'guardar', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar y Nuevo'), array('type' => 'submit', 'name' => 'guardar_y_nuevo', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
