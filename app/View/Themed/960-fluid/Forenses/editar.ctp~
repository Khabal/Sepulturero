<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido(strtolower($this->name), $this->Session->read('Forense.id'), $this->Session->read('Forense.nombre_completo')); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($this->request->data);
 echo '</pre>';
 */
?>

<?php /* Formulario editar médico forense */ ?>
<div class="edit form">
 <?php echo $this->Form->create('Forense');?>
  <fieldset>
   <legend><?php echo __('Datos del médico forense'); ?></legend>
   <?php
    echo $this->Form->input('Persona.nombre', array('label' => 'Nombre:'));
    echo $this->Form->input('Persona.apellido1', array('label' => 'Primer apellido:'));
    echo $this->Form->input('Persona.apellido2', array('label' => 'Segundo apellido:'));
    echo $this->Form->input('Persona.dni', array('label' => 'D.N.I.:'));
    echo $this->Form->input('Forense.numero_colegiado', array('label' => 'Número de colegiado:'));
    echo $this->Form->input('Forense.colegio', array('label' => 'Colegio:'));
    echo $this->Form->input('Forense.telefono', array('label' => 'Teléfono:'));
    echo $this->Form->input('Forense.correo_electronico', array('label' => 'Correo electrónico:'));
    echo $this->Form->input('Persona.observaciones', array('label' => 'Anotaciones:'));
    echo $this->Form->input('Persona.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Modificar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Descartar cambios'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
