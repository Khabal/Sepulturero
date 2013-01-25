<?php /* Obtener identificador de tumba */ ?>
<?php $identificador = ""; if($tumba['Columbario']['identificador']) {$identificador = $tumba['Columbario']['identificador'];} elseif($tumba['Nicho']['identificador']) {$identificador = $tumba['Nicho']['identificador'];} elseif($tumba['Panteon']['identificador']) {$identificador = $tumba['Panteon']['identificador'];} ?>

<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('tumbas', $tumba['Tumba']['id'], $tumba['Tumba']['tipo'] . " - " . $identificador); ?>
</div>

<?php /* Datos tumba */ ?>
<div class="view box">
 <h2><?php echo __('Datos de la tumba'); ?></h2>
 <dl>
  <dt><?php echo __('Tipo de tumba:'); ?></dt>
  <dd><?php echo h($tumba['Tumba']['tipo']); ?>&nbsp;</dd>
  <?php if (!empty($tumba['Columbario']['id'])): ?>
   <dt><?php echo __('Número de columbario:'); ?></dt>
   <dd><?php echo $tumba['Columbario']['numero_columbario']; ?>&nbsp;</dd>
   <dt><?php echo __('Fila:'); ?></dt>
   <dd><?php echo $tumba['Columbario']['fila']; ?>&nbsp;</dd>
   <dt><?php echo __('Patio:'); ?></dt>
   <dd><?php echo h($tumba['Columbario']['patio']); ?>&nbsp;</dd>
  <?php elseif (!empty($tumba['Nicho']['id'])): ?>
   <dt><?php echo __('Número de nicho:'); ?></dt>
   <dd><?php echo $tumba['Nicho']['numero_nicho']; ?>&nbsp;</dd>
   <dt><?php echo __('Fila:'); ?></dt>
   <dd><?php echo $tumba['Nicho']['fila']; ?>&nbsp;</dd>
   <dt><?php echo __('Patio:'); ?></dt>
   <dd><?php echo h($tumba['Nicho']['patio']); ?>&nbsp;</dd>
  <?php elseif (!empty($tumba['Panteon']['id'])): ?>
   <dt><?php echo __('Número de panteón:'); ?></dt>
   <dd><?php echo $tumba['Nicho']['numero_panteon']; ?>&nbsp;</dd>
   <dt><?php echo __('Familia:'); ?></dt>
   <dd><?php echo $tumba['Panteon']['familia']; ?>&nbsp;</dd>
   <dt><?php echo __('Patio:'); ?></dt>
   <dd><?php echo h($tumba['Panteon']['patio']); ?>&nbsp;</dd>
  <?php endif; ?>
  <dt><?php echo __('Población:'); ?></dt>
  <dd><?php echo h($tumba['Tumba']['poblacion']); ?>&nbsp;</dd>
  <dt><?php echo __('Anotaciones:'); ?></dt>
  <dd><?php echo h($tumba['Tumba']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>

<?php /* Arrendatario relacionado */ ?>
<div class="related box">
 <h2><?php echo __('Arrendatario actual'); ?></h2>
  <?php if (!empty($tumba['ArrendatarioTumba'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Fecha de arrendamiento'); ?></th>
     <th><?php echo __('Nombre'); ?></th>
     <th><?php echo __('D.N.I.'); ?></th>
     <th><?php echo __('Dirección'); ?></th>
     <th><?php echo __('Localidad'); ?></th>
     <th><?php echo __('Provincia'); ?></th>
     <th><?php echo __('País'); ?></th>
     <th><?php echo __('Código postal'); ?></th>
     <th><?php echo __('Teléfono'); ?></th>
     <th><?php echo __('Correo electrónico'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información de los arrendatarios */ ?>
   <tbody>
    <?php $arrendatario = $tumba['ArrendatarioTumba'][0]; ?>
    <tr class="altrow">
     <td><?php echo date('d/m/Y', strtotime($arrendatario['fecha_arrendamiento'])); ?></td>
     <td><?php echo h($arrendatario['Arrendatario']['Persona']['nombre_completo']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['Persona']['dni']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['direccion']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['localidad']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['provincia']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['pais']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['codigo_postal']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['telefono']); ?>&nbsp;</td>
     <td class="email"><?php echo h($arrendatario['Arrendatario']['correo_electronico']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'arrendatarios', 'action' => 'ver', $arrendatario['Arrendatario']['id']), array('escape' => false)); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Difuntos relacionados */ ?>
<div class="related box">
 <h2><?php echo __('Difuntos actualmente en la tumba'); ?></h2>
  <?php if (!empty($tumba['Difunto'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Nombre'); ?></th>
     <th><?php echo __('D.N.I.'); ?></th>
     <th><?php echo __('Estado del cuerpo'); ?></th>
     <th><?php echo __('Fecha de defunción'); ?></th>
     <th><?php echo __('Edad de defunción'); ?></th>
     <th><?php echo __('Causa de defunción'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información de los difuntos */ ?>
   <tbody>
   <?php $i = 0; ?>
   <?php foreach ($tumba['Difunto'] as $difunto): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td><?php echo h($difunto['Persona']['nombre_completo']); ?>&nbsp;</td>
     <td><?php echo h($difunto['Persona']['dni']); ?>&nbsp;</td>
     <td><?php echo h($difunto['estado']); ?>&nbsp;</td>
     <td><?php echo date('d/m/Y', strtotime($difunto['fecha_defuncion'])); ?>&nbsp;</td>
     <td><?php echo h($difunto['edad_defuncion']); ?>&nbsp;</td>
     <td><?php echo h($difunto['causa_defuncion']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'difuntos', 'action' => 'ver', $difunto['id']), array('escape' => false)); ?>
     </td>
    </tr>
   <?php endforeach; ?>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Enterramientos relacionados */ ?>
<div class="related box">
 <h2><?php echo __('Enterramientos habidos en la tumba'); ?></h2>
  <?php if (!empty($tumba['Enterramiento'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Fecha'); ?></th>
     <th><?php echo __('Difunto'); ?></th>
     <th><?php echo __('D.N.I.'); ?></th>
     <th><?php echo __('Licencia '); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información de los enterramientos */ ?>
   <tbody>
   <?php $i = 0; ?>
   <?php foreach ($tumba['Enterramiento'] as $enterramiento): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td><?php echo date('d/m/Y', strtotime($enterramiento['fecha'])); ?>&nbsp;</td>
     <td><?php echo h($enterramiento['Difunto']['Persona']['nombre_completo']); ?>&nbsp;</td>
     <td><?php echo h($enterramiento['Difunto']['Persona']['dni']); ?>&nbsp;</td>
     <td><?php echo h($enterramiento['Licencia']['identificador']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'enterramientos', 'action' => 'ver', $enterramiento['id']), array('escape' => false)); ?>
     </td>
    </tr>
   <?php endforeach; ?>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Traslados relacionados */ ?>
<div class="related box">
 <h2><?php echo __('Histórico de traslados relacionados con la tumba'); ?></h2>
  <?php if (!empty($tumba['TrasladoTumba'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Fecha'); ?></th>
     <th><?php echo __('Cementerio de origen'); ?></th>
     <th><?php echo __('Tumba de origen'); ?></th>
     <th><?php echo __('Cementerio de destino'); ?></th>
     <th><?php echo __('Tumba de destino'); ?></th>
     <th><?php echo __('Motivo'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de tumbas */ ?>
   <tbody>
    <?php $i = 0; ?>
    <?php foreach ($tumba['TrasladoTumba'] as $traslado): ?>
     <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
     <tr<?php echo $class; ?>>
      <td><?php echo date('d/m/Y', strtotime($traslado['Traslado']['fecha'])); ?>&nbsp;</td>
      <td><?php echo h($traslado['Traslado']['cementerio_origen']); ?>&nbsp;</td>
       <?php
        $origen = null;
        $destino = null;
        foreach ($tumba['TrasladoTumba'] as $suricato) {
         if (($suricato['origen_destino'] == "Origen") && ($suricato['traslado_id'] == $traslado['traslado_id'])) {
          $origen = $suricato;
          break;
         }
        }
        foreach ($tumba['TrasladoTumba'] as $suricato) {
         if (($suricato['origen_destino'] == "Destino") && ($suricato['traslado_id'] == $traslado['traslado_id'])) {
          $destino = $suricato;
          break;
         }
        }
       ?>
      <td <?php if ($origen['tumba_id'] == $tumba['Tumba']['id']) {echo ' class="resaltado"';} ?>>
       <?php
        echo h($origen['Tumba']['tipo']) . ' - ';
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
      <td><?php echo h($traslado['Traslado']['cementerio_destino']); ?>&nbsp;</td>
    <td <?php if ($destino['tumba_id'] == $tumba['Tumba']['id']) {echo ' class="resaltado"';} ?>>
       <?php
        echo h($destino['Tumba']['tipo']) . ' - ';
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
      <td><?php echo h($traslado['Traslado']['motivo']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'traslados', 'action' => 'ver', $traslado['Traslado']['id']), array('escape' => false)); ?>
     </td>
    </tr>
   <?php endforeach; ?>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>