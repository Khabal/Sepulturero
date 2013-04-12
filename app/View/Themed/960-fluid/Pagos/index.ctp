<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('pagos'); ?>
</div>

<?php
 
 echo '<pre>';
 print_r($pagos);
 echo '</pre>';
 
?>

<?php /* Tabla pagos */ ?>
<div class="index box">
 <h2><?php echo __('Pagos');?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Pago.tipo_pagador', 'Tipo de pagador', array('escape' => false, 'title' => 'Ordenar por tipo de pagador')); ?></th>
    <th><?php echo $this->Paginator->sort('Pago.pagador', 'Pagador', array('escape' => false, 'title' => 'Ordenar por pagador')); ?></th>
    <th><?php echo $this->Paginator->sort('Pago.fecha', 'Fecha', array('escape' => false, 'title' => 'Ordenar por fecha')); ?></th>
    <th><?php echo $this->Paginator->sort('Pago.total', 'Total', array('escape' => false, 'title' => 'Ordenar por cantidad total')); ?></th>
    <th><?php echo $this->Paginator->sort('Pago.entregado', 'Entregado', array('escape' => false, 'title' => 'Ordenar por cantidad entregada')); ?></th>
    <th><?php echo $this->Paginator->sort('Pago.moneda', 'Moneda', array('escape' => false, 'title' => 'Ordenar por moneda')); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de pagos */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($pagos as $pago): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <?php /* Información según sea el pagador */
      if (!empty($pago['ArrendatarioPago'])) {
       echo "<td> Particular &nbsp;</td>";
       echo "<td>" . $this->Html->link($pago['ArrendatarioPago']['Arrendatario']['Persona']['nombre_completo'] . " - " . $pago['ArrendatarioPago']['Arrendatario']['Persona']['dni'], array('controller' => 'arrendatarios', 'action' => 'ver', $pago['ArrendatarioPago']['arrendatario_id'])) . "&nbsp;</td>";
      }
      elseif (!empty($pago['FunerariaPago'])) {
       echo "<td> Funeraria &nbsp;</td>";
       echo "<td>" . $this->Html->link($pago['FunerariaPago']['Funeraria']['nombre'] . " - " . $pago['FunerariaPago']['Funeraria']['cif'], array('controller' => 'funerarias', 'action' => 'ver', $pago['FunerariaPago']['funeraria_id'])) . "&nbsp;</td>";
      }
      else {
       echo "Sin información";
      }
     ?>
     <td><?php echo date('d/m/Y', strtotime($pago['Pago']['fecha'])); ?>&nbsp;</td>
     <td><?php echo $this->Number->format($pago['Pago']['cantidad'], array('places' => 2, 'before' => '', 'escape' => false, 'decimals' => ',', 'thousands' => '.')); ?>&nbsp;</td>
     <td><?php echo $pago['Pago']['moneda']; ?>&nbsp;</td>
     <td><?php echo $pago['Pago']['concepto']; ?>&nbsp;</td>
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
