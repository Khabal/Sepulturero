<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('concesiones'); ?>
</div>

<?php /* Formulario buscar concesión */ ?>
<div class="find form">
 <?php echo $this->Form->create('Concesión', array(
    'url' => array('controller' => 'concesiones', 'action' => 'index'),
    'type' => 'get'
  ));
 ?>
  <fieldset>
   <legend><?php echo __('Información sobre la concesión'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('tipo', array('label' => 'Tipo de concesión:'));
    echo $this->Form->input('anos_concesion', array('label' => 'Años de concesión:'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Buscar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
