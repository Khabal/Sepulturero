<?php /* Obtener identificador de tumba */
 $localizacion = "";
 if (!empty($tumba['Columbario']['localizacion'])) {
  $localizacion = $tumba['Columbario']['localizacion'];
 }
 elseif(!empty($tumba['Exterior']['localizacion'])) {
  $localizacion = $tumba['Exterior']['localizacion'];
 }
 elseif(!empty($tumba['Nicho']['localizacion'])) {
  $localizacion = $tumba['Nicho']['localizacion'];
 }
 elseif(!empty($tumba['Panteon']['localizacion'])) {
  $localizacion = $tumba['Panteon']['localizacion'];
 }
?>

<?php /* Menú de accciones */ ?>
<div class="actions box">
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('tumbas', $tumba['Tumba']['id'], $tumba['Tumba']['tipo'] . " - " . $localizacion); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($tumba);
 echo '</pre>';
 */
?>

<?php echo $this->GuarritasEnergeticas->burton_volver(); ?>

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

<?php /* Buscar el arrendamiento vigente o caducado */
 $arrendamiento = null;
 foreach ($tumba['Arrendamiento'] as $arrendamiento) {
  if (($arrendamiento['estado'] == "Vigente") || ($arrendamiento['estado'] == "Caducado")) {
   break;
  }
  else {
   $arrendamiento = null;
  }
}
?>

<?php /* Arrendamiento relacionado no antiguo */ ?>
<div class="related box">
 <h2><?php echo __('Datos del arrendamiento'); ?></h2>
  <?php if (!empty($arrendamiento)): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Fecha de arrendamiento'); ?>:</th>
     <th><?php echo __('Tipo de concesión'); ?>:</th>
     <th><?php echo __('Duración de concesión'); ?>:</th>
     <th><?php echo __('Estado de la concesión'); ?>:</th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <tbody>
    <tr class="altrow">
     <td><?php echo h(date('d/m/Y', strtotime($arrendamiento['fecha_arrendamiento']))); ?>&nbsp;</td>
     <td><?php echo h($arrendamiento['Concesion']['tipo']); ?>&nbsp;</td>
     <td><?php echo h($arrendamiento['Concesion']['duracion'] . " - " . $arrendamiento['Concesion']['unidad_tiempo']); ?>&nbsp;</td>
  <?php
   $colorico = null;
   if ($arrendamiento['estado'] == "Caducado") {
    $colorico = ' style="color:#FF0000;font-weight:bold;"';
   }
   elseif($arrendamiento['estado'] == "Vigente") {
    $colorico = ' style="color:#04B404;font-weight:bold;"';
   }
  ?>
  <td<?php echo $colorico; ?>><?php echo h($arrendamiento['estado']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'arrendamientos', 'action' => 'ver', $arrendamiento['id']), array('escape' => false, 'title' => 'Ver')); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>


<?php /* Arrendatario relacionado */ ?>
<div class="related box">
 <h2><?php echo __('Arrendatario actual'); ?></h2>
  <?php if (!empty($arrendamiento['Arrendatario'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Nombre'); ?></th>
     <th><?php echo __('D.N.I.'); ?></th>
     <th><?php echo __('Dirección'); ?></th>
     <th><?php echo __('Localidad'); ?></th>
     <th><?php echo __('Provincia'); ?></th>
     <th><?php echo __('País'); ?></th>
     <th><?php echo __('Código postal'); ?></th>
     <th><?php echo __('Teléfono fijo'); ?></th>
     <th><?php echo __('Teléfono móvil'); ?></th>
     <th><?php echo __('Correo electrónico'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información de los arrendatarios */ ?>
   <tbody>
    <?php $arrendatario = $tumba['Arrendamiento'][0]; ?>
    <tr class="altrow">
     <td><?php echo h($arrendamiento['Arrendatario']['Persona']['nombre_completo']); ?>&nbsp;</td>
     <td>
      <?php
       if (!empty($arrendamiento['Arrendatario']['Persona']['dni'])) {
        echo h($arrendamiento['Arrendatario']['Persona']['dni']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendamiento['Arrendatario']['direccion'])) {
        echo h($arrendamiento['Arrendatario']['direccion']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendamiento['Arrendatario']['localidad'])) {
        echo h($arrendamiento['Arrendatario']['localidad']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendamiento['Arrendatario']['provincia'])) {
        echo h($arrendamiento['Arrendatario']['provincia']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendamiento['Arrendatario']['pais'])) {
        echo h($arrendamiento['Arrendatario']['pais']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendamiento['Arrendatario']['codigo_postal'])) {
        echo h($arrendamiento['Arrendatario']['codigo_postal']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendamiento['Arrendatario']['telefono_fijo'])) {
        echo h($arrendamiento['Arrendatario']['telefono_fijo']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendamiento['Arrendatario']['telefono_movil'])) {
        echo h($arrendamiento['Arrendatario']['telefono_movil']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td class="email">
      <?php
       if (!empty($arrendamiento['Arrendatario']['correo_electronico'])) {
        echo h($arrendamiento['Arrendatario']['correo_electronico']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'arrendatarios', 'action' => 'ver', $arrendamiento['Arrendatario']['id']), array('escape' => false, 'title' => 'Ver')); ?>
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
     <th><?php echo __('Edad'); ?></th>
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
     <td>
      <?php
       if (!empty($difunto['Persona']['dni'])) {
        echo h($difunto['Persona']['dni']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td><?php echo h($difunto['estado']); ?>&nbsp;</td>
     <td>
      <?php
       if (!empty($difunto['fecha_defuncion'])) {
        echo h(date('d/m/Y', strtotime($difunto['fecha_defuncion'])));
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($difunto['edad'])) {
        echo h($difunto['edad'] . " " . $difunto['unidad_tiempo']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($difunto['certificado_defuncion'])) {
        echo h($difunto['certificado_defuncion']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'difuntos', 'action' => 'ver', $difunto['id']), array('escape' => false, 'title' => 'Ver')); ?>
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
     <th><?php echo __('Tipo'); ?></th>
     <th><?php echo __('Motivo'); ?></th>
     <th><?php echo __('Viajeros'); ?></th>
     <th><?php echo __('Cementerio de origen'); ?></th>
     <th><?php echo __('Tumba de origen'); ?></th>
     <th><?php echo __('Cementerio de destino'); ?></th>
     <th><?php echo __('Tumba de destino'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de tumbas */ ?>
   <tbody>
    <?php $i = 0; ?>
    <?php foreach ($tumba['MovimientoTumba'] as $movimiento): ?>
     <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
     <?php $estilo = null; if ($movimiento['Movimiento']['documental'] > 0) { $estilo = ' style="color:#FF0000;"'; } ?>
     <tr<?php echo $class; echo $estilo;?>>
     <?php /* Obtener identificadores de tumbas de origen y destino */
      $origen = null;
      $destino = null;
      foreach ($movimiento['Movimiento']['MovimientoTumba'] as $mini_tumba) {
       if ($mini_tumba['origen_destino'] == "Origen") {
        $origen = $mini_tumba;
       }
       elseif ($mini_tumba['origen_destino'] == "Destino") {
        $destino = $mini_tumba;
       }
      }
     ?>
     <td><?php echo date('d/m/Y', strtotime($movimiento['Movimiento']['fecha'])); ?>&nbsp;</td>
     <td><?php echo h($movimiento['Movimiento']['tipo']); ?>&nbsp;</td>
     <td><?php echo h($movimiento['Movimiento']['motivo']); ?>&nbsp;</td>
     <td><?php echo h($movimiento['Movimiento']['viajeros']); ?>&nbsp;</td>
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
      if ($movimiento['Movimiento']['tipo'] == "Exhumación") {
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
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'movimientos', 'action' => 'ver', $movimiento['Movimiento']['id']), array('escape' => false, 'title' => 'Ver')); ?>
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
