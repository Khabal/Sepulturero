<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('arrendamientos', $arrendamiento['Arrendamiento']['id'], $arrendamiento['Tumba']['tipo'] . " - " . $arrendamiento['Tumba'][$arrendamiento['Tumba']['tipo']]['localizacion'] . " por " . $arrendamiento['Concesion']['anos_concesion'] . "años."); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($arrendamiento);
 echo '</pre>';
 */
?>

<?php echo $this->Html->link('Volver a la página anterior','javascript:history.go(-1)'); ?>

<?php /* Datos arrendamiento y concesión */ ?>
<div class="view box">
 <h2><?php echo __('Datos de la concesión'); ?></h2>
 <dl>
  <dt><?php echo __('Tipo de concesión'); ?>:</dt>
  <dd><?php echo h($arrendamiento['Concesion']['tipo']); ?>&nbsp;</dd>
  <dt><?php echo __('Años de concesión'); ?>:</dt>
  <dd><?php echo h($arrendamiento['Concesion']['anos_concesion']); ?>&nbsp;</dd>
  <dt><?php echo __('Fecha de arrendamiento'); ?>:</dt>
  <dd><?php echo h(date('d/m/Y', strtotime($arrendamiento['Arrendamiento']['fecha_arrendamiento']))); ?>&nbsp;</dd>
  <dt><?php echo __('Estado de la concesión'); ?>:</dt>
  <?php
   $colorico = null;
   if ($arrendamiento['Arrendamiento']['estado'] == "Caducado") {
    $colorico = ' style="color:#FF0000;font-weight:bold;"';
   }
   elseif($arrendamiento['Arrendamiento']['estado'] == "Vigente") {
    $colorico = ' style="color:#04B404;font-weight:bold;"';
   }
  ?>
  <dd<?php echo $colorico; ?>><?php echo h($arrendamiento['Arrendamiento']['estado']); ?>&nbsp;</dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($arrendamiento['Arrendamiento']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>

<?php /* Arrendatario relacionado */ ?>
<div class="related box">
 <h2><?php echo __('Datos del arrendatario'); ?></h2>
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
     <th><?php echo __('Teléfono'); ?></th>
     <th><?php echo __('Correo electrónico'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información del arrendatario */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h($arrendamiento['Arrendatario']['Persona']['nombre_completo']); ?>&nbsp;</td>
     <td>
      <?php
       if (!empty($arrendatario['Persona']['dni'])) {
        echo h($arrendatario['Persona']['dni']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td><?php echo h($arrendamiento['Arrendatario']['direccion']); ?>&nbsp;</td>
     <td><?php echo h($arrendamiento['Arrendatario']['localidad']); ?>&nbsp;</td>
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
     <td><?php echo h($arrendamiento['Arrendatario']['pais']); ?>&nbsp;</td>
     <td><?php echo h($arrendamiento['Arrendatario']['codigo_postal']); ?>&nbsp;</td>
     <td>
      <?php
       if (!empty($arrendatario['Arrendatario']['telefono_fijo'])) {
        echo h($arrendatario['Arrendatario']['telefono_fijo']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendatario['Arrendatario']['telefono_movil'])) {
        echo h($arrendatario['Arrendatario']['telefono_movil']);
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
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'arrendatarios', 'action' => 'ver', $arrendamiento['Arrendamiento']['arrendatario_id']), array('escape' => false, 'title' => 'Ver')); ?>
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
 <h2><?php echo __('Datos de la tumba'); ?></h2>
  <?php if (!empty($arrendamiento['Tumba'])): ?>
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
     <td><?php echo h($arrendamiento['Tumba']['tipo']); ?>&nbsp;</td>
     <td>
      <?php /* Obtener la localización de tumba */
       $localizacion = "";
       if (!empty($arrendamiento['Tumba']['Columbario']['localizacion'])) {
        $localizacion = $arrendamiento['Tumba']['Columbario']['localizacion'];
       }
       elseif(!empty($arrendamiento['Tumba']['Exterior']['localizacion'])) {
        $localizacion = $arrendamiento['Tumba']['Exterior']['localizacion'];
       }
       elseif(!empty($arrendamiento['Tumba']['Nicho']['localizacion'])) {
        $localizacion = $arrendamiento['Tumba']['Nicho']['localizacion'];
       }
       elseif(!empty($arrendamiento['Tumba']['Panteon']['localizacion'])) {
        $localizacion = $arrendamiento['Tumba']['Panteon']['localizacion'];
       }
       echo h($localizacion);
      ?>&nbsp;
     </td>
     <td><?php echo h($arrendamiento['Tumba']['poblacion']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'tumbas', 'action' => 'ver', $arrendamiento['Arrendamiento']['tumba_id']), array('escape' => false, 'title' => 'Ver')); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
 <?php echo $this->Html->link('Volver a la página anterior','javascript:history.go(-1)', array('class' => 'boton_volver')); ?>
</div>
