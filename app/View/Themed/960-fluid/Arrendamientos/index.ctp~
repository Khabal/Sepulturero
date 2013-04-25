<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('arrendamientos'); ?>
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
    <th><?php echo $this->Paginator->sort('Persona.nombre_completo', 'Arrendatario (Nombre)', array('escape' => false, 'title' => 'Ordenar por nombre del arrendatario')); ?></th>
    <th><?php echo $this->Paginator->sort('Persona.dni', 'Arrendatario (D.N.I.)', array('escape' => false, 'title' => 'Ordenar por D.N.I. del arrendatario')); ?></th>
    <th><?php echo $this->Paginator->sort('Tumba.localizacion', 'Tumba', array('escape' => false, 'title' => 'Ordenar por tumba')); ?></th>
    <th><?php echo $this->Paginator->sort('Concesion.tipo', 'Concesión', array('escape' => false, 'title' => 'Ordenar por tipo de concesión')); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendamiento.fecha_arrendamiento', 'Fecha de arrendamiento', array('escape' => false, 'title' => 'Ordenar por fecha de arrendamiento')); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendamiento.estado', 'Estado del arrendamiento', array('escape' => false, 'title' => 'Ordenar por estado de arrendamiento')); ?></th>
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
       /* Obtener la localización de tumba */
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
       $tumba = $arrendamiento['Tumba']['tipo'] . " - " . $localizacion;
       echo $this->Html->link($tumba, array('controller' => 'tumbas', 'action' => 'ver', $arrendamiento['Tumba']['id']));
      ?>&nbsp;
     </td>
     <td>
      <?php echo $this->Html->link($arrendamiento['Concesion']['tipo'] . " - " . $arrendamiento['Concesion']['duracion'] . " " . $arrendamiento['Concesion']['unidad_tiempo'], array('controller' => 'concesiones', 'action' => 'ver', $arrendamiento['Concesion']['id'])); ?>&nbsp;
     </td>
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
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones('arrendamientos', $arrendamiento['Arrendamiento']['id'], $tumba . " por " . $arrendamiento['Concesion']['duracion'] . " " . $arrendamiento['Concesion']['unidad_tiempo']); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
