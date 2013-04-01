<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($this->request->data);
 print_r($this->validationErrors);
 echo '</pre>';
 */
?>

<?php /* Formulario nueva concesión */ ?>
<div class="add form">
 <?php echo $this->Form->create('Concesión');?>
  <fieldset>
   <legend><?php echo __('Datos de la concesión'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Concesion.tipo', array('label' => 'Tipo de concesión:'));
    echo $this->Form->input('Concesion.anos_concesion', array('label' => 'Años de concesión:'));
    echo $this->Form->input('Concesion.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar'), array('type' => 'submit', 'name' => 'guardar', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar y Nuevo'), array('type' => 'submit', 'name' => 'guardar_y_nuevo', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
