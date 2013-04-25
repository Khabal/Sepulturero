<?php /* Menú de accciones */ ?>
<div class="actions box">
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('funerarias'); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($this->request->data);
 print_r($this->validationErrors);
 echo '</pre>';
 */
?>

<?php /* Formulario nueva funeraria */ ?>
<div class="add form">
 <?php echo $this->Form->create('Funeraria'); ?>
 <fieldset>
  <legend><?php echo __('Datos de la funeraria'); ?></legend>
  <?php /* Campos */
   echo $this->Form->input('Funeraria.cif', array('label' => 'C.I.F.:'));
   echo $this->Form->input('Funeraria.nombre', array('label' => 'Nombre:'));
   echo $this->Form->input('Funeraria.direccion', array('label' => 'Dirección:'));
   echo $this->Form->input('Funeraria.telefono_fijo', array('label' => 'Teléfono fijo:'));
   echo $this->Form->input('Funeraria.telefono_movil', array('label' => 'Teléfono móvil:'));
   echo $this->Form->input('Funeraria.fax', array('label' => 'Fax:'));
   echo $this->Form->input('Funeraria.correo_electronico', array('label' => 'Correo electrónico:'));
   echo $this->Form->input('Funeraria.pagina_web', array('label' => 'Página web:'));
   echo $this->Form->input('Funeraria.observaciones', array('label' => 'Anotaciones:'));
  ?>
 </fieldset>
 
 <?php /* Botones */
  echo $this->GuarritasEnergeticas->burtones_nuevo();
  echo $this->Form->end();
 ?>
 
</div>
