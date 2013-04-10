<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('pagos', $pago['Pago']['id'], date('d/m/Y', strtotime($pago['Pago']['fecha']))); ?>
</div>

<?php
 
 echo '<pre>';
 print_r($pago);
 echo '</pre>';
 
?>

<?php /* Datos pago */ ?>
<div class="view box">
 <h2><?php echo __('Datos del pago'); ?></h2>
 <dl>
  <dt><?php echo __('Fecha'); ?>:</dt>
  <dd><?php echo date('d/m/Y', strtotime($pago['Pago']['fecha'])); ?>&nbsp;</dd>
  <dt><?php echo __('Cantidad'); ?>:</dt>
  <dd><?php echo $this->Number->format($pago['Pago']['cantidad'], array('places' => 2, 'before' => '', 'escape' => false, 'decimals' => ',', 'thousands' => '.')); ?>&nbsp;</dd>
  <dt><?php echo __('Moneda'); ?>:</dt>
  <dd><?php echo h($pago['Pago']['moneda']); ?>&nbsp;</dd>
  <dt><?php echo __('Motivo'); ?>:</dt>
  <dd><?php echo h($pago['Pago']['motivo']); ?>&nbsp;</dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($pago['Pago']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>

<?php /* Pagador(Arrendatario/Funeraria) relacionado */ ?>
<div class="related box">
 <h2><?php echo __('Pagador'); ?></h2>
 <?php if (!empty($pago['Tasa'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Tipo'); ?></th>
     <th><?php echo __('Cantidad'); ?></th>
     <th><?php echo __('Moneda'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de tasas */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h($pago['Tasa']['tipo']); ?>&nbsp;</td>
     <td><?php echo $this->Number->format($pago['Tasa']['cantidad'], array('places' => 2, 'before' => '', 'escape' => false, 'decimals' => ',', 'thousands' => '.')); ?>&nbsp;</td>
     <td><?php echo h($pago['Tasa']['moneda']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'tasas', 'action' => 'ver', $pago['Pago']['tasa_id']), array('escape' => false)); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Tasa relacionada */ ?>
<div class="related box">
 <h2><?php echo __('Tasa pagada'); ?></h2>
 <?php if (!empty($pago['Tasa'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Tipo'); ?></th>
     <th><?php echo __('Cantidad'); ?></th>
     <th><?php echo __('Moneda'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de tasas */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h($pago['Tasa']['tipo']); ?>&nbsp;</td>
     <td><?php echo $this->Number->format($pago['Tasa']['cantidad'], array('places' => 2, 'before' => '', 'escape' => false, 'decimals' => ',', 'thousands' => '.')); ?>&nbsp;</td>
     <td><?php echo h($pago['Tasa']['moneda']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'tasas', 'action' => 'ver', $pago['Pago']['tasa_id']), array('escape' => false)); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Documentos relacionados */ ?>
<div class="related box">
 <h2><?php echo __('Documentos asociados'); ?></h2>
 <?php if (!empty($pago['Documento'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Nombre'); ?></th>
     <th><?php echo __('Tipo'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de documentos */ ?>
   <tbody>
    <?php $i = 0; ?>
    <?php foreach ($pago['Documento'] as $documento): ?>
     <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
     <tr<?php echo $class; ?>>
      <td><?php echo h($documento['nombre']); ?>&nbsp;</td>
      <td><?php echo h($documento['tipo']); ?>&nbsp;</td>
      <td class="actions">
       <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'documentos', 'action' => 'ver', $pago['Documento']['id']), array('escape' => false)); ?>
      </td>
     </tr>
    <?php endforeach; ?>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>
