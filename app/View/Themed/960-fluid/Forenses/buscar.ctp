<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('forenses'); ?>
</div>

<?php /* Formulario buscar médico forense */ ?>
<div class="find form">
 <?php echo $this->Form->create('Forense', array(
    'url' => array('controller' => 'forenses', 'action' => 'index'),
    'type' => 'get'
  ));
 ?>
 <fieldset>
  <legend><?php echo __('Información sobre el médico forense'); ?></legend>
  <?php /* Campos */
   echo $this->Form->input('nombre', array('label' => 'Nombre:'));
   echo $this->Form->input('apellido1', array('label' => 'Primer apellido:'));
   echo $this->Form->input('apellido2', array('label' => 'Segundo apellido:'));
   echo $this->Form->input('dni', array('label' => 'D.N.I.:'));
   echo $this->Form->input('numero_colegiado', array('label' => 'Número de colegiado:'));
   echo $this->Form->input('colegio', array('label' => 'Colegio:'));
   echo $this->Form->input('telefono', array('label' => 'Teléfono:'));
   echo $this->Form->input('correo_electronico', array('label' => 'Correo electrónico:'));
  ?>
 </fieldset>
 
 <?php /* Botones */
  echo $this->GuarritasEnergeticas->burtones_buscar();
  echo $this->Form->end();
 ?>
 
</div>
