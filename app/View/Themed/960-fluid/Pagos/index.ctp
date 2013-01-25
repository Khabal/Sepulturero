<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('pagos'); ?>
</div>

<?php /* Tabla pagos */ ?>
<div class="index box">
 <h2><?php echo __('Pagos');?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Tasa.tipo', 'Tasa'); ?></th>
    <th><?php echo $this->Paginator->sort('Pago.fecha', 'Fecha'); ?></th>
    <th><?php echo $this->Paginator->sort('Pago.cantidad', 'Cantidad'); ?></th>
    <th><?php echo $this->Paginator->sort('Pago.moneda', 'Moneda'); ?></th>
    <th><?php echo $this->Paginator->sort('Pago.motivo', 'Concepto'); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de pagos */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($pagos as $pago): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td>
      <?php echo $this->Html->link($pago['Tasa']['tipo'], array('controller' => 'tasas', 'action' => 'ver', $pago['Pago']['tasa_id'])); ?>&nbsp;
     </td>
     <td><?php echo date('d/m/Y', strtotime($pago['Pago']['fecha'])); ?>&nbsp;</td>
     <td><?php echo $this->Number->format($pago['Pago']['cantidad'], array('places' => 2, 'before' => '', 'escape' => false, 'decimals' => ',', 'thousands' => '.')); ?>&nbsp;</td>
     <td><?php echo $pago['Pago']['moneda']; ?>&nbsp;</td>
     <td><?php echo $pago['Pago']['motivo']; ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones('pagos', $pago['Pago']['id'], date('d/m/Y', strtotime($pago['Pago']['fecha']))); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>