<?php /* Menú de accciones */ ?>
<div class="actions box">
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('tasas'); ?>
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
   $("#TasaInicioBonito").datepicker({
     altField: "#TasaInicioValidez",
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
       $("#TasaFinBonito").datepicker("option", "minDate", selectedDate);
     }
   });
   
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#TasaFinBonito").datepicker({
     altField: "#TasaFinValidez",
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
       $("#TasaInicioBonito").datepicker("option", "maxDate", selectedDate);
     }
   });
 });
</script>

<?php /* Formulario nueva tasa */ ?>
<div class="add form">
 <?php echo $this->Form->create('Tasa'); ?>
  <fieldset>
   <legend><?php echo __('Datos de la tasa'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Tasa.concepto', array('label' => 'Concepto:'));
    echo $this->Form->input('Tasa.cantidad', array('label' => 'Cantidad:'));
    echo $this->Form->input('Tasa.moneda', array('label' => 'Moneda:', 'type' => 'select', 'options' => $monedas, 'empty' => ''));
    echo $this->Form->input('Tasa.inicio_bonito', array('label' => 'Fecha de inicio de validez:')); //Campo imaginario
    echo $this->Form->input('Tasa.inicio_validez', array('type' => 'hidden'));
    echo $this->Form->input('Tasa.fin_bonito', array('label' => 'Fecha de fin de validez:')); //Campo imaginario
    echo $this->Form->input('Tasa.fin_validez', array('type' => 'hidden'));
    echo $this->Form->input('Tasa.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
 
 <?php /* Botones */
  echo $this->GuarritasEnergeticas->burtones_nuevo();
  echo $this->Form->end();
 ?>
 
</div>
