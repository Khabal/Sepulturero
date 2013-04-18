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
  <dt><?php echo __('Total'); ?>:</dt>
  <dd><?php echo $this->Number->format($pago['Pago']['total'], array('places' => 2, 'before' => '', 'escape' => false, 'decimals' => ',', 'thousands' => '.')); ?>&nbsp;</dd>
  <dt><?php echo __('Moneda'); ?>:</dt>
  <dd><?php echo h($pago['Pago']['moneda']); ?>&nbsp;</dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($pago['Pago']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>

<?php /* Pagador(Arrendatario/Funeraria) relacionado */ ?>
<div class="related box">
 <h2><?php echo __('Pagador'); ?></h2>
 <?php if (!empty($pago['Pago']['arrendatario_id'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Tipo'); ?></th>
     <th><?php echo __('Nombre'); ?></th>
     <th><?php echo __('D.N.I.'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de tasas */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h("Particular"); ?>&nbsp;</td>
     <td><?php echo h($pago['Arrendatario']['Persona']['nombre_completo']); ?>&nbsp;</td>
     <td>
      <?php
       if ($pago['Arrendatario']['Persona']['dni']) {
        echo h($pago['Arrendatario']['Persona']['dni']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'arrendatarios', 'action' => 'ver', $pago['Pago']['arrendatario_id']), array('escape' => false, 'title' => 'Ver arrendatario')); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php elseif (!empty($pago['Pago']['funeraria_id'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Tipo'); ?></th>
     <th><?php echo __('Nombre'); ?></th>
     <th><?php echo __('C.I.F.'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de tasas */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h("Funeraria"); ?>&nbsp;</td>
     <td><?php echo h($pago['Funeraria']['nombre']); ?>&nbsp;</td>
     <td><?php echo h($pago['Funeraria']['cif']); ?>&nbsp;</td>
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'funerarias', 'action' => 'ver', $pago['Pago']['tasa_id']), array('escape' => false, 'title' => 'Ver funeraria')); ?>
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
 <h2><?php echo __('Tasas pagadas'); ?></h2>
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
