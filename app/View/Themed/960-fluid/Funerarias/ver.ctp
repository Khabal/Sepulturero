<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('funerarias', $funeraria['Funeraria']['id'], $funeraria['Funeraria']['nombre']); ?>
</div>

<?php /* Datos funeraria */ ?>
<div class="view box">
 <h2><?php echo __('Datos de la funeraria'); ?></h2>
 <dl>
  <dt><?php echo __('Nombre'); ?>:</dt>
  <dd><?php echo h($funeraria['Funeraria']['nombre']); ?>&nbsp;</dd>
  <dt><?php echo __('Dirección'); ?>:</dt>
  <dd><?php echo h($funeraria['Funeraria']['direccion']); ?>&nbsp;</dd>
  <dt><?php echo __('Teléfono'); ?>:</dt>
  <dd><?php echo h($funeraria['Funeraria']['telefono']); ?>&nbsp;</dd>
  <dt><?php echo __('Fax'); ?>:</dt>
  <dd><?php echo h($funeraria['Funeraria']['fax']); ?>&nbsp;</dd>
  <dt><?php echo __('Correo electrónico'); ?>:</dt>
  <dd class="email"><?php echo h($funeraria['Funeraria']['correo_electronico']); ?>&nbsp;</dd>
  <dt><?php echo __('Página web'); ?>:</dt>
  <dd>
   <?php echo $this->Html->link(__($funeraria['Funeraria']['pagina_web']), $funeraria['Funeraria']['pagina_web'], array('escape' => false, 'target' => '_blank')); ?>&nbsp;
  </dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($funeraria['Funeraria']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>
