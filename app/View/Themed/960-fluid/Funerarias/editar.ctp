<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php $funeraria = $this->request->data; ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('funerarias', $this->Session->read('Funeraria.id'), $funeraria['Funeraria']['nombre']); ?>
</div>

<?php /* Formulario editar funeraria */ ?>
<div class="edit form">
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
  echo $this->Form->button(__('Modificar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Descartar cambios'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
