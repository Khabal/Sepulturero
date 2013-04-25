<?php /* Menú de accciones */ ?>
<div class="actions box">
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('difuntos'); ?>
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
     maxDate: "+0D",
   });
   
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#DifuntoForenseBonito").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'forenses', 'action' => 'autocomplete')); ?>",
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
       $("#DifuntoForenseBonito").val(ui.item.label),
       $("#DifuntoForenseId").val(ui.item.value)
     },
     open: function() {
       $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
     },
     close: function() {
       $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
     }
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
       $("#DifuntoTumbaBonita").val(ui.item.label),
       $("#DifuntoTumbaId").val(ui.item.value)
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

<?php /* Formulario nuevo difunto */ ?>
<div class="add form">
 <?php echo $this->Form->create('Difunto');?>
 <fieldset>
  <legend><?php echo __('Datos del difunto'); ?></legend>
  <?php /* Campos */
   echo $this->Form->input('Persona.nombre', array('label' => 'Nombre:'));
   echo $this->Form->input('Persona.apellido1', array('label' => 'Primer apellido:'));
   echo $this->Form->input('Persona.apellido2', array('label' => 'Segundo apellido:'));
   echo $this->Form->input('Persona.dni', array('label' => 'D.N.I.:', 'required' => false));
   echo $this->Form->input('Persona.sexo', array('label' => 'Sexo:', 'type' => 'select', 'options' => $sexo));
   echo $this->Form->input('Persona.nacionalidad', array('label' => 'Nacionalidad:'));
   echo $this->Form->input('Difunto.estado', array('label' => 'Estado del cuerpo:', 'type' => 'select', 'options' => $estado, 'empty' => ''));
   echo $this->Form->input('Difunto.fecha_bonita', array('label' => 'Fecha de defunción:')); //Campo imaginario
   echo $this->Form->input('Difunto.fecha_defuncion', array('type' => 'hidden'));
   echo $this->Form->input('Difunto.edad', array('label' => 'Edad:'));
   echo $this->Form->input('Difunto.unidad_tiempo', array('label' => 'Unidad de tiempo:', 'type' => 'select', 'options' => $tiempo, 'empty' => ''));
   echo $this->Form->input('Difunto.causa_fundamental', array('label' => 'Causa fundamental de fallecimiento:'));
   echo $this->Form->input('Difunto.causa_inmediata', array('label' => 'Causa inmediata de fallecimiento:', 'default' => ' Parada cardiorrespiratoria'));
   echo $this->Form->input('Difunto.forense_bonito', array('label' => 'Médico forense:')); //Campo imaginario
   echo $this->Form->input('Difunto.forense_id', array('type' => 'hidden'));
   echo $this->Form->input('Difunto.certificado_defuncion', array('label' => 'Certificado de defunción:'));
   echo $this->Form->input('Persona.observaciones', array('label' => 'Anotaciones:'));
  ?>
 </fieldset>
 <fieldset>
  <legend><?php echo __('Tumba de descanso actual (Opcional)'); ?></legend>
  <?php /* Campos */
   echo $this->Form->input('Difunto.tumba_bonita', array('label' => 'Tumba:')); //Campo imaginario
   echo $this->Form->input('Difunto.tumba_id', array('type' => 'hidden'));
  ?>
 </fieldset>
 
 <?php /* Botones */
  echo $this->GuarritasEnergeticas->burtones_nuevo();
  echo $this->Form->end();
 ?>
 
</div>
