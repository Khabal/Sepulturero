<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('concesiones'); ?>
</div>

<?php /* Formulario buscar concesión */ ?>
<div class="find form">
 <?php
  echo $this->Form->create('Concesión', array('url' => array('controller' => 'concesiones', 'action' => 'index'), 'type' => 'get'));
 ?>
 <fieldset>
  <legend><?php echo __('Información sobre la concesión'); ?></legend>
  <?php /* Campos */
   echo $this->Form->input('tipo', array('label' => 'Tipo de concesión:'));
   echo $this->Form->input('duracion', array('label' => 'Duración de la concesión:'));
   echo $this->Form->input('unidad_tiempo', array('label' => 'Unidad de tiempo:', 'type' => 'select', 'options' => $tiempo, 'empty' => ''));
  ?>
 </fieldset>
 
 <?php /* Botones */
  echo $this->GuarritasEnergeticas->burtones_buscar();
  echo $this->Form->end();
 ?>
 
</div>
