<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('funerarias', $funeraria['Funeraria']['id'], $funeraria['Funeraria']['nombre']); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($funeraria);
 echo '</pre>';
 */
?>

<?php echo $this->Html->link('Volver a la página anterior','javascript:history.go(-1)'); ?>

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
  <dt><?php echo __('Teléfono fijo'); ?>:</dt>
  <dd>
   <?php
    if (!empty($funeraria['Funeraria']['telefono_fijo'])) {
     echo h($funeraria['Funeraria']['telefono_fijo']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Teléfono móvil'); ?>:</dt>
  <dd>
   <?php
    if (!empty($funeraria['Funeraria']['telefono_movil'])) {
     echo h($funeraria['Funeraria']['telefono_movil']);
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

<?php echo $this->Html->link('Volver a la página anterior','javascript:history.go(-1)'); ?>
