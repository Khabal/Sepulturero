<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($this->request->data);
 echo '</pre>';
 */
?>

<?php /* Formulario nuevo médico forense */ ?>
<div class="add form">
 <?php echo $this->Form->create('Forense');?>
  <fieldset>
  <legend><?php echo __('Datos del médico forense'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Persona.nombre', array('label' => 'Nombre:'));
    echo $this->Form->input('Persona.apellido1', array('label' => 'Primer apellido:'));
    echo $this->Form->input('Persona.apellido2', array('label' => 'Segundo apellido:'));
    echo $this->Form->input('Persona.dni', array('label' => 'D.N.I.:'));
    echo $this->Form->input('Forense.numero_colegiado', array('label' => 'Número de colegiado:'));
    echo $this->Form->input('Forense.colegio', array('label' => 'Colegio:'));
    echo $this->Form->input('Forense.telefono', array('label' => 'Teléfono:'));
    echo $this->Form->input('Forense.correo_electronico', array('label' => 'Correo electrónico:'));
    echo $this->Form->input('Persona.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar'), array('type' => 'submit', 'name' => 'guardar', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar y Nuevo'), array('type' => 'submit', 'name' => 'guardar_y_nuevo', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
