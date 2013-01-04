<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('funerarias'); ?>
</div>

<?php /* Formulario nueva funeraria */ ?>
<div class="add form">
 <?php echo $this->Form->create('Funeraria', array('type' => 'post')); ?>
  <fieldset>
   <legend><?php echo __('Datos de la funeraria'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Funeraria.nombre', array('label' => 'Nombre:'));
    echo $this->Form->input('Funeraria.direccion', array('label' => 'Dirección:'));
    echo $this->Form->input('Funeraria.telefono', array('label' => 'Teléfono:'));
    echo $this->Form->input('Funeraria.fax', array('label' => 'Fax:'));
    echo $this->Form->input('Funeraria.correo_electronico', array('label' => 'Correo electrónico:'));
    echo $this->Form->input('Funeraria.pagina_web', array('label' => 'Página web:'));
    echo $this->Form->input('Funeraria.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar y Nuevo'), array('value' => 'guardar_y_nuevo', 'type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
