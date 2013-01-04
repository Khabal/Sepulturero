<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('traslados'); ?>
</div>

<?php /* Tabla traslados */ ?>
<div class="index box">
 <h2><?php echo __('Traslados'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Traslado.fecha', 'Fecha');?></th>
    <th><?php echo $this->Paginator->sort('DifuntoTraslado.Difunto.Persona.nombre_completo', 'Difuntos trasladados');?></th>
    <th><?php echo $this->Paginator->sort('Traslado.cementerio_origen', 'Cementerio de origen');?></th>
    <th><?php echo $this->Paginator->sort('TrasladoTumba.Tumba', 'Tumba de origen');?></th>
    <th><?php echo $this->Paginator->sort('Traslado.cementerio_destino', 'Cementerio de destino');?></th>
    <th><?php echo $this->Paginator->sort('TrasladoTumba.Tumba', 'Tumba de destino');?></th>
    <th><?php echo $this->Paginator->sort('Traslado.motivo', 'Motivo');?></th>
    <th class="actions"><?php echo __('Acciones');?></th>
   </tr>
  </thead>
  <?php /* Listado de traslados */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($traslados as $traslado): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <?php
      /* Obtener identificadores de tumbas de origen y destino */
      $origen = null;
      $destino = null;
      foreach ($traslado['TrasladoTumba'] as $tumba) {
       if ($tumba['origen_destino'] == "Origen") {
        $origen = $tumba;
       }
       elseif ($tumba['origen_destino'] == "Destino") {
        $destino = $tumba;
       }
      }
     ?>
     <td><?php echo date('d/m/Y', strtotime($traslado['Traslado']['fecha'])); ?>&nbsp;</td>
     <td><?php echo count($traslado['DifuntoTraslado']); ?>&nbsp;</td>
     <td><?php echo $traslado['Traslado']['cementerio_origen']; ?>&nbsp;</td>
     <?php /* Obtener identificador de tumba */ ?>
     <?php $identificador = null; if($origen['Tumba']['Columbario']) {$identificador = $origen['Tumba']['Columbario']['identificador'];} elseif($origen['Tumba']['Nicho']) {$identificador = $origen['Tumba']['Nicho']['identificador'];} elseif($origen['Tumba']['Panteon']) {$identificador = $origen['Tumba']['Panteon']['identificador'];} ?>
     <td>
      <?php if (strlen($identificador) > 0): ?>
       <?php echo $this->Html->link($origen['Tumba']['tipo'] . " - " . $identificador, array('controller' => 'tumbas', 'action' => 'ver', $origen['tumba_id'])); ?>
      <?php else: ?>
       Sin información
      <?php endif; ?>&nbsp;
     </td>
     <td><?php echo $traslado['Traslado']['cementerio_destino']; ?>&nbsp;</td>
     <?php /* Obtener identificador de tumba */ ?>
     <?php $identificador = null; if($destino['Tumba']['Columbario']) {$identificador = $destino['Tumba']['Columbario']['identificador'];} elseif($destino['Tumba']['Nicho']) {$identificador = $destino['Tumba']['Nicho']['identificador'];} elseif($destino['Tumba']['Panteon']) {$identificador = $destino['Tumba']['Panteon']['identificador'];} ?>
     <td>
      <?php if (strlen($identificador) > 0): ?>
       <?php echo $this->Html->link($destino['Tumba']['tipo'] . " - " . $identificador, array('controller' => 'tumbas', 'action' => 'ver', $destino['tumba_id'])); ?>
      <?php else: ?>
       Sin información
      <?php endif; ?>&nbsp;
     </td>
     <td><?php echo $traslado['Traslado']['motivo']; ?>&nbsp;</td>
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
