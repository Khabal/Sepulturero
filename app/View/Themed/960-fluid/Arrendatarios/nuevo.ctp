<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<pre>
<?php print_r($this->request->data);
print_r($persona);
?>
</pre>

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
     <?php /* Cambiar el número iniFormsCount si hay datos para que los muestre */
      if ($this->request->data) {
       $ini = sizeof($this->request->data['ArrendatarioFuneraria']);
      }
      else {
       $ini = 0;
      }
     ?>
     iniFormsCount: <?php echo $ini; ?>,
     removeAllConfirmationMsg: '¿Eliminar todas las funerarias asociadas?',
   /*     afterAdd: function(source, newForm) {
            alert('After add form'+source.toSource());
        },
     afterClone: function(source, clone) {
       alert('After clone form'+clone.toSource());$(clone).children().attr('value', '');
     }*/
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
     <?php /* Cambiar el número iniFormsCount si hay datos para que los muestre */
      if ($this->request->data) {
       $ini = sizeof($this->request->data['ArrendatarioFuneraria']);
      }
      else {
       $ini = 0;
      }
     ?>
     iniFormsCount: <?php echo $ini; ?>,
     removeAllConfirmationMsg: '¿Eliminar todas las tumbas asociadas?',
     afterClone: function(source, clone) {
       alert('After clone form'+clone);clone.val("");
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
      echo $this->Form->input('ArrendatarioFuneraria.#index#.funeraria_bonita', array('label' => 'Funeraria:', 'onFocus' => 'autoFunerarias("ArrendatarioFuneraria#index#")')); //Campo imaginario
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
      echo $this->Form->input('ArrendatarioTumba.#index#.tumba_bonita', array('label' => 'Tumba:', 'onFocus' => "autoTumbas('ArrendatarioTumba#index#')")); //Campo imaginario
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
  echo $this->Form->button(__('Guardar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar y Nuevo'), array('value' => 'guardar_y_nuevo', 'type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
