<?php /* Menú de accciones */ ?>
<div class="actions box">
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('tasas', $tasa['Tasa']['id'], $tasa['Tasa']['concepto']); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($tasa);
 echo '</pre>';
 */
?>

<?php echo $this->GuarritasEnergeticas->burton_volver(); ?>

<?php /* Datos tasa */ ?>
<div class="view box">
 <h2><?php echo __('Datos de la tasa'); ?></h2>
 <dl>
  <dt><?php echo __('Concepto'); ?>:</dt>
  <dd><?php echo h($tasa['Tasa']['concepto']); ?>&nbsp;</dd>
  <dt><?php echo __('Cantidad'); ?>:</dt>
  <dd><?php echo $this->Number->format($tasa['Tasa']['cantidad'], array('places' => 2, 'before' => '', 'escape' => false, 'decimals' => ',', 'thousands' => '.')); ?>&nbsp;</dd>
  <dt><?php echo __('Moneda'); ?>:</dt>
  <dd><?php echo h($tasa['Tasa']['moneda']); ?>&nbsp;</dd>
  <dt><?php echo __('Fecha de inicio de validez'); ?>:</dt>
  <dd><?php echo date('d/m/Y', strtotime($tasa['Tasa']['inicio_validez'])); ?>&nbsp;</dd>
  <dt><?php echo __('Fecha de fin de validez'); ?>:</dt>
  <dd>
   <?php
    if ($tasa['Tasa']['fin_validez']) {
     echo h(date('d/m/Y', strtotime($tasa['Tasa']['fin_validez'])));
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($tasa['Tasa']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>

<?php echo $this->GuarritasEnergeticas->burton_volver(); ?>
