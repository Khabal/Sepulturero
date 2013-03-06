<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($movimientos);
 echo '</pre>';
 */
?>

<?php /* Tabla movimientos */ ?>
<div class="index box">
 <h2><?php echo __('Movimientos'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Movimiento.fecha', 'Fecha');?></th>
    <th><?php echo $this->Paginator->sort('Movimiento.tipo', 'Tipo');?></th>
    <th><?php echo $this->Paginator->sort('Movimiento.viajeros', 'Difuntos trasladados');?></th>
    <th><?php echo $this->Paginator->sort('Movimiento.cementerio_origen', 'Cementerio de origen');?></th>
    <th><?php echo $this->Paginator->sort('MovimientoTumba.Tumba', 'Tumba de origen');?></th>
    <th><?php echo $this->Paginator->sort('Movimiento.cementerio_destino', 'Cementerio de destino');?></th>
    <th><?php echo $this->Paginator->sort('MovimientoTumba.Tumba', 'Tumba de destino');?></th>
    <th><?php echo $this->Paginator->sort('Movimiento.motivo', 'Motivo');?></th>
    <th class="actions"><?php echo __('Acciones');?></th>
   </tr>
  </thead>
  <?php /* Listado de movimientos */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($movimientos as $movimiento): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <?php
      /* Obtener identificadores de tumbas de origen y destino */
      $origen = null;
      $destino = null;
      foreach ($movimiento['MovimientoTumba'] as $tumba) {
       if ($tumba['origen_destino'] == "Origen") {
        $origen = $tumba;
       }
       elseif ($tumba['origen_destino'] == "Destino") {
        $destino = $tumba;
       }
      }
     ?>
     <td><?php echo h(date('d/m/Y', strtotime($movimiento['Movimiento']['fecha']))); ?>&nbsp;</td>
     <td><?php echo h($movimiento['Movimiento']['tipo']); ?>&nbsp;</td>
     <td><?php echo h($movimiento['Movimiento']['viajeros']); ?>&nbsp;</td>
     <td><?php echo h($movimiento['Movimiento']['cementerio_origen']); ?>&nbsp;</td>
     <?php /* Obtener identificador de tumba */ ?>
     <?php $identificador = null; if($origen['Tumba']['Columbario']) {$identificador = $origen['Tumba']['Columbario']['localizacion'];} elseif($origen['Tumba']['Nicho']) {$identificador = $origen['Tumba']['Nicho']['localizacion'];} elseif($origen['Tumba']['Panteon']) {$identificador = $origen['Tumba']['Panteon']['localizacion'];} ?>
     <td>
      <?php if (strlen($identificador) > 0): ?>
       <?php echo $this->Html->link($origen['Tumba']['tipo'] . " - " . $identificador, array('controller' => 'tumbas', 'action' => 'ver', $origen['tumba_id'])); ?>
      <?php else: ?>
       Sin información
      <?php endif; ?>&nbsp;
     </td>
     <td><?php echo $movimiento['Traslado']['cementerio_destino']; ?>&nbsp;</td>
     <?php /* Obtener identificador de tumba */ ?>
     <?php $identificador = null; if($destino['Tumba']['Columbario']) {$identificador = $destino['Tumba']['Columbario']['localizacion'];} elseif($destino['Tumba']['Nicho']) {$identificador = $destino['Tumba']['Nicho']['localizacion'];} elseif($destino['Tumba']['Panteon']) {$identificador = $destino['Tumba']['Panteon']['localizacion'];} ?>
     <td>
      <?php if (strlen($identificador) > 0): ?>
       <?php echo $this->Html->link($destino['Tumba']['tipo'] . " - " . $identificador, array('controller' => 'tumbas', 'action' => 'ver', $destino['tumba_id'])); ?>
      <?php else: ?>
       Sin información
      <?php endif; ?>&nbsp;
     </td>
     <td><?php echo $movimiento['Traslado']['motivo']; ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones('traslados', $traslado['Traslado']['id'], date('d/m/Y', strtotime($traslado['Traslado']['fecha'])) . " - " . $traslado['Traslado']['motivo']); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
