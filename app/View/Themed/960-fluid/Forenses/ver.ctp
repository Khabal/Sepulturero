<?php /* Menú de accciones */ ?>
<div class="actions box">
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('forenses', $forense['Forense']['id'], $forense['Persona']['nombre_completo']); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($forense);
 echo '</pre>';
 */
?>

<?php echo $this->GuarritasEnergeticas->burton_volver(); ?>

<?php /* Datos médico forense */ ?>
<div class="view box">
 <h2><?php echo __('Datos del médico forense'); ?></h2>
 <dl>
  <dt><?php echo __('Nombre'); ?>:</dt>
  <dd><?php echo h($forense['Persona']['nombre_completo']); ?>&nbsp;</dd>
  <dt><?php echo __('D.N.I.'); ?>:</dt>
  <dd>
   <?php
    if (!empty($forense['Persona']['dni'])) {
     echo h($forense['Persona']['dni']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Número de colegiado'); ?>:</dt>
  <dd><?php echo h($forense['Forense']['numero_colegiado']); ?>&nbsp;</dd>
  <dt><?php echo __('Colegio'); ?>:</dt>
  <dd><?php echo h($forense['Forense']['colegio']); ?>&nbsp;</dd>
  <dt><?php echo __('Teléfono'); ?>:</dt>
  <dd>
   <?php
    if (!empty($forense['Forense']['telefono'])) {
     echo h($forense['Forense']['telefono']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Correo electrónico'); ?>:</dt>
  <dd class="email">
   <?php
    if (!empty($forense['Forense']['correo_electronico'])) {
     echo h($forense['Forense']['correo_electronico']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($forense['Persona']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>

<?php echo $this->GuarritasEnergeticas->burton_volver(); ?>
