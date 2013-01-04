<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('tasas', $tasa['Tasa']['id'], $tasa['Tasa']['tipo']); ?>
</div>

<?php /* Datos tasa */ ?>
<div class="view box">
 <h2><?php echo __('Datos de la tasa'); ?></h2>
 <dl>
  <dt><?php echo __('Tipo'); ?>:</dt>
  <dd><?php echo h($tasa['Tasa']['tipo']); ?>&nbsp;</dd>
  <dt><?php echo __('Cantidad'); ?>:</dt>
  <dd><?php echo $this->Number->format($tasa['Tasa']['cantidad'], array('places' => 2, 'before' => '', 'escape' => false, 'decimals' => ',', 'thousands' => '.')); ?>&nbsp;</dd>
  <dt><?php echo __('Moneda'); ?>:</dt>
  <dd><?php echo h($tasa['Tasa']['moneda']); ?>&nbsp;</dd>
  <dt><?php echo __('Inicio de validez'); ?>:</dt>
  <dd><?php echo date('d/m/Y', strtotime($tasa['Tasa']['inicio_validez'])); ?>&nbsp;</dd>
  <dt><?php echo __('Fin de validez'); ?>:</dt>
  <dd><?php echo date('d/m/Y', strtotime($tasa['Tasa']['fin_validez'])); ?>&nbsp;</dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($tasa['Tasa']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>
