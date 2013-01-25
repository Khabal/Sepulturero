<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('traslados', $traslado['Traslado']['id'], date('d/m/Y', strtotime($traslado['Traslado']['fecha'])) . " - " . $traslado['Traslado']['motivo']); ?>
</div>

<?php /* Datos traslado */ ?>
<div class="view box">
 <h2><?php echo __('Datos del traslado');?></h2>
 <dl>
  <dt><?php echo __('Fecha'); ?>:</dt>
  <dd><?php echo date('d/m/Y', strtotime($traslado['Traslado']['fecha'])); ?>&nbsp;</dd>
  <dt><?php echo __('Cementerio de origen'); ?>:</dt>
  <dd><?php echo h($traslado['Traslado']['cementerio_origen']); ?>&nbsp;</dd>
  <dt><?php echo __('Cementerio de destino'); ?>:</dt>
  <dd><?php echo h($traslado['Traslado']['cementerio_destino']); ?>&nbsp;</dd>
  <dt><?php echo __('Motivo'); ?>:</dt>
  <dd><?php echo h($traslado['Traslado']['motivo']); ?>&nbsp;</dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo $traslado['Traslado']['observaciones']; ?>&nbsp;</dd>
 </dl>
</div>

<?php /* Difuntos relacionados */ ?>
<div class="related box">
 <h2><?php echo __('Difuntos trasladados'); ?></h2>
 <?php if (!empty($traslado['DifuntoTraslado'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Nombre'); ?></th>
     <th><?php echo __('D.N.I.'); ?></th>
     <th><?php echo __('Estado del cuerpo'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de documentos */ ?>
   <tbody>
    <?php $i = 0; ?>
    <?php foreach ($traslado['DifuntoTraslado'] as $difunto): ?>
     <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
     <tr<?php echo $class; ?>>
      <td><?php echo h($difunto['Difunto']['Persona']['nombre_completo']); ?>&nbsp;</td>
      <td><?php echo h($difunto['Difunto']['Persona']['dni']); ?>&nbsp;</td>
      <td><?php echo h($difunto['Difunto']['estado']); ?>&nbsp;</td>
      <td class="actions">
       <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'difuntos', 'action' => 'ver', $difunto['Difunto']['id']), array('escape' => false)); ?>
      </td>
     </tr>
    <?php endforeach; ?>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Tumba relacionada */ ?>
<div class="related box">
 <h2><?php echo __('Tumba de origen'); ?></h2>
 <?php
  $origen = null;
  foreach ($traslado['TrasladoTumba'] as $tumba) {
   if ($tumba['origen_destino'] == "Origen") {
    $origen = $tumba;
    break;
   }
  }
 ?>
 <?php if ($origen): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Tipo de tumba'); ?></th>
     <th><?php echo __('Identificador de tumba'); ?></th>
     <th><?php echo __('Población'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información de la tumba */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h($origen['Tumba']['tipo']); ?>&nbsp;</td>
     <td>
      <?php
       if ($origen['Tumba']['Columbario']) {
        echo h($origen['Tumba']['Columbario']['identificador']);
       }
       elseif ($origen['Tumba']['Nicho']) {
        echo h($origen['Tumba']['Nicho']['identificador']);
       }
       elseif ($origen['Tumba']['Panteon']) {
        echo h($origen['Tumba']['Panteon']['identificador']);
       }
       elseif ($origen['Tumba']['Exterior']) {
        echo h($origen['Tumba']['Exterior']['identificador']);
       }
      ?>&nbsp;
     </td>
     <td><?php echo h($origen['Tumba']['poblacion']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'tumbas', 'action' => 'ver', $origen['tumba_id']), array('escape' => false)); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Tumba relacionada */ ?>
<div class="related box">
 <h2><?php echo __('Tumba de destino'); ?></h2>
 <?php
  $destino = null;
  foreach ($traslado['TrasladoTumba'] as $tumba) {
   if ($tumba['origen_destino'] == "Destino") {
    $destino = $tumba;
    break;
   }
  }
 ?>
 <?php if ($destino): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Tipo de tumba'); ?></th>
     <th><?php echo __('Identificador de tumba'); ?></th>
     <th><?php echo __('Población'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información de la tumba */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h($destino['Tumba']['tipo']); ?>&nbsp;</td>
     <td>
      <?php
       if ($destino['Tumba']['Columbario']) {
        echo h($destino['Tumba']['Columbario']['identificador']);
       }
       elseif ($destino['Tumba']['Nicho']) {
        echo h($destino['Tumba']['Nicho']['identificador']);
       }
       elseif ($destino['Tumba']['Panteon']) {
        echo h($destino['Tumba']['Panteon']['identificador']);
       }
       elseif ($destino['Tumba']['Exterior']) {
        echo h($destino['Tumba']['Exterior']['identificador']);
       }
      ?>&nbsp;
     </td>
     <td><?php echo h($destino['Tumba']['poblacion']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'tumbas', 'action' => 'ver', $destino['tumba_id']), array('escape' => false)); ?>
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
 <?php if (!empty($traslado['Documento'])): ?>
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
    <?php foreach ($traslado['Documento'] as $documento): ?>
     <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
     <tr<?php echo $class; ?>>
      <td><?php echo h($documento['nombre']); ?>&nbsp;</td>
      <td><?php echo h($documento['tipo']); ?>&nbsp;</td>
      <td class="actions">
       <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'documentos', 'action' => 'ver', $traslado['Documento']['id']), array('escape' => false)); ?>
      </td>
     </tr>
    <?php endforeach; ?>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>