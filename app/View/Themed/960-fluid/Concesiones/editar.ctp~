<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('concesiones', $this->Session->read('Concesion.id'), $this->Session->read('Concesion.tipo')); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($this->request->data);
 print_r($this->validationErrors);
 echo '</pre>';
 */
?>

<?php /* Formulario editar concesión */ ?>
<div class="edit form">
 <?php echo $this->Form->create('Concesion'); ?>
 <fieldset>
  <legend><?php echo __('Datos de la concesión');?></legend>
  <?php /* Campos */
   echo $this->Form->input('Concesion.tipo', array('label' => 'Tipo de concesión:'));
   echo $this->Form->input('Concesion.duracion', array('label' => 'Años de concesión:'));
   echo $this->Form->input('Concesion.unidad_tiempo', array('label' => 'Unidad de tiempo:', 'type' => 'select', 'options' => $tiempo, 'empty' => ''));
   echo $this->Form->input('Concesion.observaciones', array('label' => 'Anotaciones:'));
  ?>
 </fieldset>
 
 <?php /* Botones */
  echo $this->GuarritasEnergeticas->burtones_editar();
  echo $this->Form->end();
 ?>
 
</div>
