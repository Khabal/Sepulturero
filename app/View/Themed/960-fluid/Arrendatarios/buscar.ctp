<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<?php /* Formulario buscar arrendatario */ ?>
<div class="find form">
 <?php echo $this->Form->create('Arrendatario', array(
    'url' => array('controller' => strtolower($this->name), 'action' => 'index'),
    'type' => 'get'
  ));
 ?>
  <fieldset>
  <legend><?php echo __('Información sobre el arrendatario'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('nombre', array('label' => 'Nombre:'));
    echo $this->Form->input('apellido1', array('label' => 'Primer apellido:'));
    echo $this->Form->input('apellido2', array('label' => 'Segundo apellido:'));
    echo $this->Form->input('dni', array('label' => 'D.N.I.:'));
    echo $this->Form->input('nacionalidad', array('label' => 'Nacionalidad:'));
    echo $this->Form->input('direccion', array('label' => 'Dirección:'));
    echo $this->Form->input('localidad', array('label' => 'Localidad:'));
    echo $this->Form->input('provincia', array('label' => 'Provincia:'));
    echo $this->Form->input('pais', array('label' => 'País:'));
    echo $this->Form->input('codigo_postal', array('label' => 'Código postal:'));
    echo $this->Form->input('telefono', array('label' => 'Teléfono:'));
    echo $this->Form->input('correo_electronico', array('label' => 'Correo electrónico:'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Buscar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
