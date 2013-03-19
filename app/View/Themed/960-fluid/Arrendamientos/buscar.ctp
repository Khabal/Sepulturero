<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<script>
 $(function() {
   
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#ArrendamientoFechaDesde").datepicker({
     altField: "#ArrendamientoDesde",
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
     onClose: function(selectedDate) {
       $("#ArrendamientoFechaHasta").datepicker("option", "minDate", selectedDate);
     }
   });
   
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#ArrendamientoFechaHasta").datepicker({
     altField: "#ArrendamientoHasta",
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
     onClose: function(selectedDate) {
       $("#ArrendamientoFechaDesde").datepicker("option", "maxDate", selectedDate);
     }
   });
   
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#ArrendamientoArrendatario").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'arrendatarios', 'action' => 'autocomplete')); ?>",
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
     minLength: 2,
     select: function(event, ui) {
       event.preventDefault(),
       $("#ArrendamientoArrendatario").val(ui.item.label),
       $("#ArrendamientoArrendatarioId").val(ui.item.value)
     },
     open: function() {
       $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
     },
     close: function() {
       $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
     }
   });
   
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#ArrendamientoConcesion").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'concesiones', 'action' => 'autocomplete')); ?>",
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
     minLength: 2,
     select: function(event, ui) {
       event.preventDefault(),
       $("#ArrendamientoConcesion").val(ui.item.label),
       $("#ArrendamientoConcesionId").val(ui.item.value)
     },
     open: function() {
       $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
     },
     close: function() {
       $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
     }
   });
   
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#ArrendamientoTumba").autocomplete({
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
     minLength: 2,
     select: function(event, ui) {
       event.preventDefault(),
       $("#ArrendamientoTumba").val(ui.item.label),
       $("#ArrendamientoTumbaId").val(ui.item.value)
     },
     open: function() {
       $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
     },
     close: function() {
       $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
     }
   });
 });
</script>

<?php /* Formulario buscar arrendamiento */ ?>
<div class="find form">
 <?php echo $this->Form->create('Arrendamiento', array(
    'url' => array('controller' => strtolower($this->name), 'action' => 'index'),
    'type' => 'get'
  ));
 ?>
  <fieldset>
  <legend><?php echo __('Información sobre el arrendamiento'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('arrendatario', array('label' => 'Arrendatario:')); //Campo imaginario
    echo $this->Form->input('arrendatario_id', array('type' => 'hidden'));
    echo $this->Form->input('concesion', array('label' => 'Tipo de concesión:')); //Campo imaginario
    echo $this->Form->input('concesion_id', array('type' => 'hidden'));
    echo $this->Form->input('tumba', array('label' => 'Tumba:')); //Campo imaginario
    echo $this->Form->input('tumba_id', array('type' => 'hidden'));
    echo '<div class="intervalo">';
    echo $this->Form->input('fecha_desde', array('label' => 'Fecha de arrendamiento desde:')); //Campo imaginario
    echo $this->Form->input('desde', array('type' => 'hidden'));
    echo $this->Form->input('fecha_hasta', array('label' => 'hasta:')); //Campo imaginario
    echo $this->Form->input('hasta', array('type' => 'hidden'));
    echo '</div>';
    echo $this->Form->input('estado', array('label' => 'Estado del arrendamiento:', 'type' => 'select', 'options' => $estado, 'empty' => ''));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Buscar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
