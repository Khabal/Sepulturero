<?php /* Menú de accciones */ ?>
<div class="actions box">
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('difuntos', $difunto['Difunto']['id'], $difunto['Persona']['nombre_completo']); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($difunto);
 echo '</pre>';
 */
?>

<?php echo $this->GuarritasEnergeticas->burton_volver(); ?>

<?php /* Datos difunto */ ?>
<div class="view box">
 <h2><?php echo __('Datos del difunto'); ?></h2>
 <dl>
  <dt><?php echo __('Nombre'); ?>:</dt>
  <dd><?php echo h($difunto['Persona']['nombre_completo']); ?>&nbsp;</dd>
  <dt><?php echo __('D.N.I.'); ?>:</dt>
  <dd>
   <?php
    if ($difunto['Persona']['dni']) {
     echo h($difunto['Persona']['dni']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Nacionalidad'); ?>:</dt>
  <dd>
   <?php
    if ($difunto['Persona']['nacionalidad']) {
     echo h($difunto['Persona']['nacionalidad']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Sexo'); ?>:</dt>
  <dd><?php echo h($difunto['Persona']['sexo']); ?>&nbsp;</dd>
  <dt><?php echo __('Estado'); ?>:</dt>
  <dd><?php echo h($difunto['Difunto']['estado']); ?>&nbsp;</dd>
  <dt><?php echo __('Fecha de defunción'); ?>:</dt>
  <dd>
   <?php
    if ($difunto['Difunto']['fecha_defuncion']) {
     echo h($difunto['Difunto']['fecha_defuncion']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Edad'); ?>:</dt>
  <dd>
   <?php
    if ($difunto['Difunto']['edad']) {
     echo h($difunto['Difunto']['edad'] . " " . $difunto['Difunto']['unidad_tiempo']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Causa fundamental de defunción'); ?>:</dt>
  <dd>
   <?php
    if ($difunto['Difunto']['causa_fundamental']) {
     echo h($difunto['Difunto']['causa_fundamental']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Causa inmediata de defunción'); ?>:</dt>
  <dd>
   <?php
    if ($difunto['Difunto']['causa_inmediata']) {
     echo h($difunto['Difunto']['causa_inmediata']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($difunto['Persona']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>

<?php /* Tumba relacionada */ ?>
<div class="related box">
 <h2><?php echo __('Tumba actual'); ?></h2>
  <?php if (!empty($difunto['Difunto']['tumba_id'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Tipo de tumba'); ?></th>
     <th><?php echo __('Localización'); ?></th>
     <th><?php echo __('Población'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información de la tumba */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h($difunto['Tumba']['tipo']); ?>&nbsp;</td>
     <?php /* Obtener la localización de tumba */
      $localizacion = "";
      if (!empty($difunto['Tumba']['Columbario']['localizacion'])) {
       $localizacion = $difunto['Tumba']['Columbario']['localizacion'];
      }
      elseif(!empty($difunto['Tumba']['Exterior']['localizacion'])) {
       $localizacion = $difunto['Tumba']['Exterior']['localizacion'];
      }
      elseif(!empty($difunto['Tumba']['Nicho']['localizacion'])) {
       $localizacion = $difunto['Tumba']['Nicho']['localizacion'];
      }
      elseif(!empty($difunto['Tumba']['Panteon']['localizacion'])) {
       $localizacion = $difunto['Tumba']['Panteon']['localizacion'];
      }
     ?>
     <td><?php echo h($localizacion); ?>&nbsp;</td>
     <td><?php echo h($difunto['Tumba']['poblacion']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'tumbas', 'action' => 'ver', $difunto['Difunto']['tumba_id']), array('escape' => false, 'title' => 'Ver')); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Movimientos relacionados */ ?>
<div class="related box">
 <h2><?php echo __('Histórico de movimientos');?></h2>
 <?php if (!empty($difunto['DifuntoMovimiento'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Fecha'); ?></th>
     <th><?php echo __('Tipo'); ?></th>
     <th><?php echo __('Cementerio de origen'); ?></th>
     <th><?php echo __('Tumba de origen'); ?></th>
     <th><?php echo __('Cementerio de destino'); ?></th>
     <th><?php echo __('Tumba de destino'); ?></th>
     <th><?php echo __('Motivo'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de movimientos */ ?>
   <tbody>
    <?php $i = 0; ?>
    <?php foreach ($difunto['DifuntoMovimiento'] as $movimiento): ?>
     <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
     <tr<?php echo $class; ?>>
     <?php /* Obtener identificadores de tumbas de origen y destino */
      $origen = null;
      $destino = null;
      foreach ($movimiento['Movimiento']['MovimientoTumba'] as $tumba) {
       if ($tumba['origen_destino'] == "Origen") {
        $origen = $tumba;
       }
       elseif ($tumba['origen_destino'] == "Destino") {
        $destino = $tumba;
       }
      }
     ?>
     <td><?php echo date('d/m/Y', strtotime($movimiento['Movimiento']['fecha'])); ?>&nbsp;</td>
     <td><?php echo h($movimiento['Movimiento']['tipo']); ?>&nbsp;</td>
     <?php /* Mostrar información si el movimiento tiene origen */
      if ($movimiento['Movimiento']['tipo'] == "Inhumación"){
       echo '<td>' . '-----' . '&nbsp;</td>';
       echo '<td>' . '-----' . '&nbsp;</td>';
      }
      else {
       echo '<td>'. h($movimiento['Movimiento']['cementerio_origen']) . '&nbsp;</td>';
       /* Obtener la localización de tumba */
       $localizacion = "";
       if (!empty($origen['Tumba']['Columbario']['localizacion'])) {
        $localizacion = $origen['Tumba']['Columbario']['localizacion'];
       }
       elseif(!empty($origen['Tumba']['Exterior']['localizacion'])) {
        $localizacion = $origen['Tumba']['Exterior']['localizacion'];
       }
       elseif(!empty($origen['Tumba']['Nicho']['localizacion'])) {
        $localizacion = $origen['Tumba']['Nicho']['localizacion'];
       }
       elseif(!empty($origen['Tumba']['Panteon']['localizacion'])) {
        $localizacion = $origen['Tumba']['Panteon']['localizacion'];
       }
       
       if (!empty($localizacion)) {
        echo '<td>'. $this->Html->link($origen['Tumba']['tipo'] . " - " . $localizacion, array('controller' => 'tumbas', 'action' => 'ver', $origen['tumba_id'])) . '&nbsp;</td>';
       }
       else {
        echo '<td>'. 'Sin información' . '&nbsp;</td>';
       } 
      }
     ?>
     <?php /* Mostrar información si el movimiento tiene destino */
      if ($movimiento['Movimiento']['tipo'] == "Exhumación"){
       echo '<td>' . '-----' . '&nbsp;</td>';
       echo '<td>' . '-----' . '&nbsp;</td>';
      }
      else {
       echo '<td>'. h($movimiento['Movimiento']['cementerio_destino']) . '&nbsp;</td>';
       /* Obtener la localización de tumba */
       $localizacion = "";
       if (!empty($destino['Tumba']['Columbario']['localizacion'])) {
        $localizacion = $destino['Tumba']['Columbario']['localizacion'];
       }
       elseif(!empty($destino['Tumba']['Exterior']['localizacion'])) {
        $localizacion = $destino['Tumba']['Exterior']['localizacion'];
       }
       elseif(!empty($destino['Tumba']['Nicho']['localizacion'])) {
        $localizacion = $destino['Tumba']['Nicho']['localizacion'];
       }
       elseif(!empty($destino['Tumba']['Panteon']['localizacion'])) {
        $localizacion = $destino['Tumba']['Panteon']['localizacion'];
       }
       
       if (!empty($localizacion)) {
        echo '<td>'. $this->Html->link($destino['Tumba']['tipo'] . " - " . $localizacion, array('controller' => 'tumbas', 'action' => 'ver', $destino['tumba_id'])) . '&nbsp;</td>';
       }
       else {
        echo '<td>'. 'Sin información' . '&nbsp;</td>';
       } 
      }
     ?>
     <td><?php echo h($movimiento['Movimiento']['motivo']); ?>&nbsp;</td>
      <td class="actions">
       <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'movimientos', 'action' => 'ver', $movimiento['movimiento_id']), array('escape' => false, 'title' => 'Ver')); ?>
      </td>
     </tr>
    <?php endforeach; ?>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php echo $this->GuarritasEnergeticas->burton_volver(); ?>
