<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido(strtolower($this->name), $this->Session->read('Arrendamiento.id'), $this->Session->read('Arrendamiento.identificador')); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($this->request->data);
 print_r($this->validationErrors);
 echo '</pre>';
 */
?>

<script>
 $(function() {
   
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#ArrendamientoFechaBonita").datepicker({
     altField: "#ArrendamientoFechaArrendamiento",
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
   $("#ArrendamientoArrendatarioBonito").autocomplete({
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
       $("#ArrendamientoArrendatarioBonito").val(ui.item.label),
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
   $("#ArrendamientoConcesionBonita").autocomplete({
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
       $("#ArrendamientoConcesionBonita").val(ui.item.label),
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
   $("#ArrendamientoTumbaBonita").autocomplete({
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
       $("#ArrendamientoTumbaBonita").val(ui.item.label),
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

<?php /* Formulario editar arrendamiento */ ?>
<div class="edit form">
 <?php echo $this->Form->create('Arrendamiento'); ?>
  <fieldset>
   <legend><?php echo __('Datos del arrendamiento'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Arrendamiento.arrendatario_bonito', array('label' => 'Arrendatario:')); //Campo imaginario
    echo $this->Form->input('Arrendamiento.arrendatario_id', array('type' => 'hidden'));
    echo $this->Form->input('Arrendamiento.concesion_bonita', array('label' => 'Tipo de concesión:')); //Campo imaginario
    echo $this->Form->input('Arrendamiento.concesion_id', array('type' => 'hidden'));
    echo $this->Form->input('Arrendamiento.tumba_bonita', array('label' => 'Tumba:')); //Campo imaginario
    echo $this->Form->input('Arrendamiento.tumba_id', array('type' => 'hidden'));
    echo $this->Form->input('Arrendamiento.fecha_bonita', array('label' => 'Fecha de arrendamiento:')); //Campo imaginario
    echo $this->Form->input('Arrendamiento.fecha_arrendamiento', array('type' => 'hidden'));
    echo $this->Form->input('Arrendamiento.estado', array('label' => 'Estado del arrendamiento:', 'type' => 'select', 'options' => $estado, 'empty' => ''));
    echo $this->Form->input('Arrendamiento.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Modificar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Descartar cambios'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
