<?php /* Datos funeraria */ ?>
<div class="view box">
 <h2><?php echo __('Datos de la funeraria'); ?></h2>
 <dl>
  <dt><?php echo __('C.I.F.'); ?>:</dt>
  <dd><?php echo h($funeraria['Funeraria']['cif']); ?>&nbsp;</dd>
  <dt><?php echo __('Nombre'); ?>:</dt>
  <dd><?php echo h($funeraria['Funeraria']['nombre']); ?>&nbsp;</dd>
  <dt><?php echo __('Dirección'); ?>:</dt>
  <dd><?php echo h($funeraria['Funeraria']['direccion']); ?>&nbsp;</dd>
  <dt><?php echo __('Teléfono'); ?>:</dt>
  <dd>
   <?php
    if (!empty($funeraria['Funeraria']['telefono'])) {
     echo h($funeraria['Funeraria']['telefono']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Fax'); ?>:</dt>
  <dd>
   <?php
    if (!empty($funeraria['Funeraria']['fax'])) {
     echo h($funeraria['Funeraria']['fax']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Correo electrónico'); ?>:</dt>
  <dd class="email">
   <?php
    if (!empty($funeraria['Funeraria']['correo_electronico'])) {
     echo h($funeraria['Funeraria']['correo_electronico']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Página web'); ?>:</dt>
  <dd class="enlace">
   <?php
    if (!empty($funeraria['Funeraria']['pagina_web'])) {
     echo $this->Html->link(__($funeraria['Funeraria']['pagina_web']), $funeraria['Funeraria']['pagina_web'], array('escape' => false, 'target' => '_blank'));
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($funeraria['Funeraria']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>
