<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($arrendamientos);
 echo '</pre>';
 */
?>

<?php /* Tabla arrendamientos */ ?>
<div class="index box">
 <h2><?php echo __('Arrendamientos'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Persona.nombre_completo', 'Arrendatario'); ?></th>
    <th><?php echo $this->Paginator->sort('Persona.dni', 'D.N.I.'); ?></th>
    <th><?php echo $this->Paginator->sort('Tumba.localizacion', 'Tumba'); ?></th>
    <th><?php echo $this->Paginator->sort('Concesion.tipo', 'Tipo de concesión'); ?></th>
    <th><?php echo $this->Paginator->sort('Concesion.anos_concesion', 'Tiempo de concesión'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendamiento.fecha_arrendamiento', 'Fecha de arrendamiento'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendamiento.estado', 'Estado del arrendamiento'); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de arrendamientos */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach($arrendamientos as $arrendamiento): ?>
    <?php $class = null; if($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td>
      <?php echo $this->Html->link($arrendamiento['Arrendatario']['Persona']['nombre_completo'], array('controller' => 'arrendatarios', 'action' => 'ver', $arrendamiento['Arrendatario']['id'])); ?>&nbsp;
     </td>
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
       $tumba = $arrendamiento['Tumba']['tipo'] . " - " . $arrendamiento['Tumba'][$arrendamiento['Tumba']['tipo']]['localizacion'];
       echo $this->Html->link($tumba, array('controller' => 'tumbas', 'action' => 'ver', $arrendamiento['Tumba']['id']));
      ?>&nbsp;
     </td>
     <td>
      <?php echo $this->Html->link($arrendamiento['Concesion']['tipo'], array('controller' => 'concesiones', 'action' => 'ver', $arrendamiento['Concesion']['id'])); ?>&nbsp;
     </td>
     <td><?php echo h($arrendamiento['Concesion']['anos_concesion'] . " años"); ?>&nbsp;</td>
     <td><?php echo h(date('d/m/Y', strtotime($arrendamiento['Arrendamiento']['fecha_arrendamiento']))); ?>&nbsp;</td>
     <?php
      $colorico = null;
      if ($arrendamiento['Arrendamiento']['estado'] == "Caducado") {
       $colorico = ' style="color:#FF0000;font-weight:bold;"';
      }
      elseif($arrendamiento['Arrendamiento']['estado'] == "Vigente") {
       $colorico = ' style="color:#04B404;font-weight:bold;"';
      }
     ?>
     <td<?php echo $colorico; ?>><?php echo h($arrendamiento['Arrendamiento']['estado']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones(strtolower($this->name), $arrendamiento['Arrendamiento']['id'], $tumba . " por " . $arrendamiento['Concesion']['anos_concesion'] . "años."); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
