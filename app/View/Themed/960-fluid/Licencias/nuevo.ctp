<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('licencias'); ?>
</div>

<pre>
<?php print_r($this->request->data); ?>
</pre>
<script>
 /* Establecer opciones de 'UI datepicker' para JQuery */
 $(function() {
   $("#fecha").datepicker({
     altField: "#LicenciaFechaAprobacion",
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

<?php /* Formulario nueva licencia */ ?>
<div class="add form">
 <?php echo $this->Form->create('Licencia');?>
  <fieldset>
   <legend><?php echo __('Datos de la licencia'); ?></legend>
   <?php
    echo $this->Form->input('Licencia.numero_licencia', array('label' => 'Número de licencia:'));
   ?>
   <div class="input text required">
    <label for="fecha">Fecha de aprobación:</label>
    <input id="fecha" value="<?php if ($this->request->data) { echo date('d/m/Y', strtotime($this->request->data['Licencia']['fecha_aprobacion'])); } ?>"/>
   </div>
   <?php echo $this->Form->input('Licencia.fecha_aprobacion', array('type' => 'hidden')); ?>
   <?php
    echo $this->Form->input('Licencia.anos_concesion', array('label' => 'Años de concesión:'));
    echo $this->Form->input('Licencia.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Documento asociado'); ?></legend>
   <?php /* Campos */
	/*echo $this->AutoComplete->input('Funeraria.nombre', array('label' => 'Funeraria:')/*, array('source' => '/arrendatarios/kkkk/'));*/
    echo $this->Form->input('Documento', array('label' => 'Documento:'));
    ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar y Nuevo'), array('value' => 'guardar_y_nuevo', 'type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
