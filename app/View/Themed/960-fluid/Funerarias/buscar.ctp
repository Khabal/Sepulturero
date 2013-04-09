<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('funerarias'); ?>
</div>

<?php /* Formulario buscar médico forense */ ?>
<div class="find form">
 <?php echo $this->Form->create('Funeraria', array(
    'url' => array('controller' => 'funerarias', 'action' => 'index'),
    'type' => 'get'
  ));
 ?>
  <fieldset>
  <legend><?php echo __('Información sobre la funeraria'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('cif', array('label' => 'C.I.F.:'));
    echo $this->Form->input('nombre', array('label' => 'Nombre:'));
    echo $this->Form->input('direccion', array('label' => 'Dirección:'));
    echo $this->Form->input('telefono_fijo', array('label' => 'Teléfono:'));
    echo $this->Form->input('telefono_movil', array('label' => 'Teléfono móvil:'));
    echo $this->Form->input('fax', array('label' => 'Fax:'));
    echo $this->Form->input('correo_electronico', array('label' => 'Correo electrónico:'));
    echo $this->Form->input('pagina_web', array('label' => 'Página web:'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Buscar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
