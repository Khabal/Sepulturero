<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('tasas'); ?>
</div>

<script>
 /* Establecer opciones de 'UI datepicker' para JQuery */
 $(function() {
   $("#inicio").datepicker({
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
   $("#final").datepicker({
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

<?php /* Formulario nueva tasa */ ?>
<div class="add form">
 <?php echo $this->Form->create('Tasa'); ?>
  <fieldset>
   <legend><?php echo __('Datos de la tasa'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Tasa.tipo', array('label' => 'Tipo:'));
    echo $this->Form->input('Tasa.cantidad', array('label' => 'Cantidad:'));
   ?>
   <div class="input text required">
    <label for="TasaMoneda">Moneda:</label>
    <?php echo $this->Form->select('Tasa.moneda', $monedas); ?>
   </div>
   <div class="input text required">
    <label for="inicio">Inicio de validez:</label>
    <input id="inicio" value="<?php if ($this->request->data) { echo date('d/m/Y', strtotime($this->request->data['Tasa']['inicio_validez'])); } ?>"/>
   </div>
   <?php echo $this->Form->input('Tasa.inicio_validez', array('type' => 'hidden')); ?>
   <div class="input text required">
    <label for="final">Fin de validez:</label>
    <input id="final" value="<?php if ($this->request->data){ echo date('d/m/Y', strtotime($this->request->data['Tasa']['fin_validez'])); }?>"/>
   </div>
  <?php
    echo $this->Form->input('Tasa.fin_validez', array('type' => 'hidden'));
    echo $this->Form->input('Tasa.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar y Nuevo'), array('value' => 'guardar_y_nuevo', 'type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
