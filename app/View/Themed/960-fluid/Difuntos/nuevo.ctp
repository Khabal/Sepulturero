<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<script>
 $(function() {
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#DifuntoFechaBonita").datepicker({
     altField: "#DifuntoFechaDefuncion",
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
   $("#DifuntoTumbaBonita").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'tumbas', 'action' => 'autocomplete')); ?>",
         dataType: "json",
         type: "GET",
         data: {
           term: request.term
         },
timeout: 20000,
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
       $("#DifuntoTumbaBonita").val(ui.item.label),
       $("#DifuntoTumbaId").val(ui.item.value)
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

<?php /* Formulario nuevo difunto */ ?>
<div class="add form">
 <?php echo $this->Form->create('Difunto');?>
  <fieldset>
  <legend><?php echo __('Datos del difunto'); ?></legend>
   <?php
    echo $this->Form->input('Persona.nombre', array('label' => 'Nombre:'));
    echo $this->Form->input('Persona.apellido1', array('label' => 'Primer apellido:'));
    echo $this->Form->input('Persona.apellido2', array('label' => 'Segundo apellido:'));
    echo $this->Form->input('Persona.dni', array('label' => 'D.N.I.:'));
    echo $this->Form->input('Difunto.estado', array('label' => 'Estado del cuerpo:', 'type' => 'select', 'options' => $estado, 'empty' => ''));
    echo $this->Form->input('Difunto.fecha_bonita', array('label' => 'Fecha de defunción:')); //Campo imaginario
    echo $this->Form->input('Difunto.fecha_defuncion', array('type' => 'hidden'));
    echo $this->Form->input('Difunto.edad_defuncion', array('label' => 'Edad de defunción:'));
    echo $this->Form->input('Difunto.causa_defuncion', array('label' => 'Causa de defunción:'));
    echo $this->Form->input('Persona.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Tumba de descanso actual'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Difunto.tumba_bonita', array('label' => 'Tumba:')); //Campo imaginario
    echo $this->Form->input('Difunto.tumba_id', array('type' => 'hidden'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar y Nuevo'), array('value' => 'guardar_y_nuevo', 'type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
