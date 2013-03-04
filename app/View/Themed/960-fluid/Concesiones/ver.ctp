<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido(strtolower($this->name), $concesion['Concesion']['id'], $concesion['Concesion']['tipo']); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($concesion);
 echo '</pre>';
 */
?>

<?php /* Datos concesión */ ?>
<div class="view box">
 <h2><?php echo __('Datos de la concesión'); ?></h2>
 <dl>
  <dt><?php echo __('Tipo de concesión'); ?>:</dt>
  <dd><?php echo h($concesion['Concesion']['tipo']); ?>&nbsp;</dd>
  <dt><?php echo __('Años de concesión'); ?>:</dt>
  <dd><?php echo h($concesion['Concesion']['anos_concesion']); ?>&nbsp;</dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($concesion['Concesion']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>