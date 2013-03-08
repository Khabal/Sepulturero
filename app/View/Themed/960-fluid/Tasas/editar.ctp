<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php $tasa = $this->request->data; ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('tasas', $this->Session->read('Tasa.id'), $this->Session->read('Tasa.concepto')); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($this->request->data);
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
   });
 });
</script>

<?php /* Formulario editar tasa */ ?>
<div class="edit form">
 <?php echo $this->Form->create('Tasa', array('type' => 'post')); ?>
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
  echo $this->Form->button(__('Modificar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Descartar cambios'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
