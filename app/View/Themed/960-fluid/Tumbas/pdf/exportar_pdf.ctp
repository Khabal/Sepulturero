<?php /* Datos tumba */ ?>
<div class="view box">
 <h2><?php echo __('Datos de la tumba'); ?></h2>
 <dl>
  <dt><?php echo __('Tipo de tumba:'); ?></dt>
  <dd><?php echo h($tumba['Tumba']['tipo']); ?>&nbsp;</dd>
  <?php if (!empty($tumba['Columbario']['id'])): ?>
   <dt><?php echo __('Número de columbario:'); ?></dt>
   <dd><?php echo $tumba['Columbario']['numero_columbario']; ?>&nbsp;</dd>
   <dt><?php echo __('Letra:'); ?></dt>
   <dd><?php echo $tumba['Columbario']['letra']; ?>&nbsp;</dd>
   <dt><?php echo __('Fila:'); ?></dt>
   <dd><?php echo $tumba['Columbario']['fila']; ?>&nbsp;</dd>
   <dt><?php echo __('Patio:'); ?></dt>
   <dd><?php echo h($tumba['Columbario']['patio']); ?>&nbsp;</dd>
  <?php elseif (!empty($tumba['Nicho']['id'])): ?>
   <dt><?php echo __('Número de nicho:'); ?></dt>
   <dd><?php echo $tumba['Nicho']['numero_nicho']; ?>&nbsp;</dd>
   <dt><?php echo __('Letra:'); ?></dt>
   <dd><?php echo $tumba['Nicho']['letra']; ?>&nbsp;</dd>
   <dt><?php echo __('Fila:'); ?></dt>
   <dd><?php echo $tumba['Nicho']['fila']; ?>&nbsp;</dd>
   <dt><?php echo __('Patio:'); ?></dt>
   <dd><?php echo h($tumba['Nicho']['patio']); ?>&nbsp;</dd>
  <?php elseif (!empty($tumba['Panteon']['id'])): ?>
   <dt><?php echo __('Número de panteón:'); ?></dt>
   <dd><?php echo $tumba['Panteon']['numero_panteon']; ?>&nbsp;</dd>
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
  <?php if (!empty($tumba['Arrendamiento']['Arrendatario'])): ?>
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
    <?php $arrendatario = $tumba['Arrendamiento'][0]; ?>
    <tr class="altrow">
     <td><?php echo date('d/m/Y', strtotime($arrendatario['fecha_arrendamiento'])); ?></td>
     <td><?php echo h($arrendatario['Arrendatario']['Persona']['nombre_completo']); ?>&nbsp;</td>
     <td>
      <?php
       if (!empty($arrendatario['Arrendatario']['Persona']['dni'])) {
        echo h($arrendatario['Arrendatario']['Persona']['dni']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td><?php echo h($arrendatario['Arrendatario']['direccion']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['localidad']); ?>&nbsp;</td>
     <td>
      <?php
       if (!empty($arrendatario['Arrendatario']['provincia'])) {
        echo h($arrendatario['Arrendatario']['provincia']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td><?php echo h($arrendatario['Arrendatario']['pais']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['codigo_postal']); ?>&nbsp;</td>
     <td>
      <?php
       if (!empty($arrendatario['Arrendatario']['telefono'])) {
        echo h($arrendatario['Arrendatario']['telefono']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td class="email">
      <?php
       if (!empty($arrendatario['Arrendatario']['correo_electronico'])) {
        echo h($arrendatario['Arrendatario']['correo_electronico']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
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
     <th><?php echo __('Sexo'); ?></th>
     <th><?php echo __('Nacionalidad'); ?></th>
     <th><?php echo __('Estado del cuerpo'); ?></th>
     <th><?php echo __('Fecha de defunción'); ?></th>
     <th><?php echo __('Edad'); ?></th>
     <th><?php echo __('Causa de fallecimiento'); ?></th>
     <th><?php echo __('Certificado de defunción'); ?></th>
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
     <td><?php echo h($difunto['edad']); ?>&nbsp;</td>
     <td><?php echo h($difunto['causa_fallecimiento']); ?>&nbsp;</td>
     <td><?php echo h($difunto['certificado_defuncion']); ?>&nbsp;</td>
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

<?php /* Movimientos relacionados */ ?>
<div class="related box">
 <h2><?php echo __('Histórico de movimientos habidos en la tumba'); ?></h2>
  <?php if (!empty($tumba['MovimientoTumba'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Fecha'); ?></th>
     <th><?php echo __('Viajeros'); ?></th>
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
