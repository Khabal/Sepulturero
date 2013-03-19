<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<script>
 $(function() {
   
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#MovimientoFechaDesde").datepicker({
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
       $("#MovimientoFechaHasta").datepicker("option", "minDate", selectedDate);
     }
   });
   
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#MovimientoFechaHasta").datepicker({
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
       $("#MovimientoFechaDesde").datepicker("option", "maxDate", selectedDate);
     }
   });
   
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#MovimientoTumbaOrigen").autocomplete({
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
       $("#MovimientoTumbaOrigen").val(ui.item.label),
       $("#MovimientoTumbaOrigenId").val(ui.item.value)
     },
     open: function() {
       $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
     },
     close: function() {
       $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
     }
   });
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#MovimientoTumbaDestino").autocomplete({
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
       $("#MovimientoTumbaDestino").val(ui.item.label),
       $("#MovimientoTumbaDestinoId").val(ui.item.value)
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

<?php /* Formulario buscar movimientos */ ?>
<div class="find form">
 <?php echo $this->Form->create('Movimiento', array(
    'url' => array('controller' => strtolower($this->name), 'action' => 'index'),
    'type' => 'get'
  ));
 ?>
  <fieldset>
  <legend><?php echo __('Información sobre el movimiento'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('tipo', array('label' => 'Clase de movimiento:', 'type' => 'select', 'options' => $tipo, 'empty' => ''));
    echo '<div class="intervalo">';
    echo $this->Form->input('fecha_desde', array('label' => 'Fecha de arrendamiento desde:')); //Campo imaginario
    echo $this->Form->input('desde', array('type' => 'hidden'));
    echo $this->Form->input('fecha_hasta', array('label' => 'hasta:')); //Campo imaginario
    echo $this->Form->input('hasta', array('type' => 'hidden'));
    echo '</div>';
    echo $this->Form->input('motivo', array('label' => 'Motivo:'));
    echo $this->Form->input('cementerio_origen', array('label' => 'Cementerio de origen:'));
    echo $this->Form->input('tumba_origen', array('label' => 'Tumba de origen:')); //Campo imaginario
    echo $this->Form->input('tumba_origen_id', array('type' => 'hidden'));
    echo $this->Form->input('cementerio_destino', array('label' => 'Cementerio de destino:'));
    echo $this->Form->input('tumba_destino', array('label' => 'Tumba de destino:')); //Campo imaginario
    echo $this->Form->input('tumba_destino_id', array('type' => 'hidden'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Buscar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
