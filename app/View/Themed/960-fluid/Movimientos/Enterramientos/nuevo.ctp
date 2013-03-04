<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<pre>
<?php print_r($this->request->data); ?>
</pre>

<script>
 $(function() {
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#EnterramientoFechaBonita").datepicker({
     altField: "#EnterramientoFecha",
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
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#EnterramientoDifuntoBonito").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'difuntos', 'action' => 'autocomplete')); ?>",
         dataType: "json",
         type: "GET",
         data: {
           term: request.term
         },
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
       $("#EnterramientoDifuntoBonito").val(ui.item.label),
       $("#EnterramientoDifuntoId").val(ui.item.value)
     },
     open: function() {
       $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
     },
     close: function() {
       $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
     }
   });
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#EnterramientoLicenciaBonita").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'licencias', 'action' => 'autocomplete')); ?>",
         dataType: "json",
         type: "GET",
         data: {
           term: request.term
         },
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
       $("#EnterramientoLicenciaBonita").val(ui.item.label),
       $("#EnterramientoLicenciaId").val(ui.item.value)
     },
     open: function() {
       $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
     },
     close: function() {
       $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
     }
   });
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#EnterramientoTumbaBonita").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'tumbas', 'action' => 'autocomplete')); ?>",
         dataType: "json",
         type: "GET",
         data: {
           term: request.term
         },
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
       $("#EnterramientoTumbaBonita").val(ui.item.label),
       $("#EnterramientoTumbaId").val(ui.item.value)
     },
     open: function() {
       $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
     },
     close: function() {
       $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
     }
   });
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#EnterramientoTasaBonita").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'tasas', 'action' => 'autocomplete')); ?>",
         dataType: "json",
         type: "GET",
         data: {
           term: request.term
         },
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
       $("#EnterramientoTasaBonita").val(ui.item.label),
       $("#EnterramientoTasaTasaId").val(ui.item.value)
     },
     open: function() {
       $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
     },
     close: function() {
       $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
     }
   });
 });
</script>

<?php /* Formulario nuevo enterramiento */ ?>
<div class="add form">
 <?php echo $this->Form->create('Enterramiento');?>
  <fieldset>
   <legend><?php echo __('Datos del enterramiento');?></legend>
   <?php
    echo $this->Form->input('Enterramiento.fecha_bonita', array('label' => 'Fecha de enterramiento:')); //Campo imaginario
    echo $this->Form->input('Enterramiento.fecha', array('type' => 'hidden'));
    echo $this->Form->input('Enterramiento.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Difunto enterrado'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Enterramiento.difunto_bonito', array('label' => 'Difunto:')); //Campo imaginario
    echo $this->Form->input('Enterramiento.difunto_id', array('type' => 'hidden'));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Licencia asociada'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Enterramiento.licencia_bonita', array('label' => 'Licencia:')); //Campo imaginario
    echo $this->Form->input('Enterramiento.licencia_id', array('type' => 'hidden'));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Tumba del enterramiento'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Enterramiento.tumba_bonita', array('label' => 'Tumba:')); //Campo imaginario
    echo $this->Form->input('Enterramiento.tumba_id', array('type' => 'hidden'));
    echo $this->Form->input('Enterramiento.tumba_final', array('type' => 'checkbox', 'label' => '¿Tumba actual del difunto?', 'value' => 0));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Tasas a pagar'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Enterramiento.tasa_bonita', array('label' => 'Tasa:')); //Campo imaginario
    //echo $this->Form->input('EnterramientoTasa.tasa_id', array('type' => 'hidden'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar y Nuevo'), array('value' => 'guardar_y_nuevo', 'type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>