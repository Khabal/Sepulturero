<?php /* Menú de accciones */ ?>
<div class="actions box">
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('concesiones'); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($concesiones);
 echo '</pre>';
 */
?>

<?php /* Tabla concesiones */ ?>
<div class="index box">
 <h2><?php echo __('Concesiones');?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Concesion.tipo', 'Tipo de concesión', array('escape' => false, 'title' => 'Ordenar por tipo de concesión')); ?></th>
    <th><?php echo $this->Paginator->sort('Concesion.duracion', 'Duración de la concesión', array('escape' => false, 'title' => 'Ordenar por duración de la concesión')); ?></th>
    <th><?php echo $this->Paginator->sort('Concesion.unidad_tiempo', 'Unidad de tiempo', array('escape' => false, 'title' => 'Ordenar por unidad de tiempo')); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de concesiones */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($concesiones as $concesion): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td>
      <?php echo $this->Html->link($concesion['Concesion']['tipo'], array('controller' => 'concesiones', 'action' => 'ver', $concesion['Concesion']['id'])); ?>&nbsp;
     </td>
     <td><?php echo h($concesion['Concesion']['duracion']); ?>&nbsp;</td>
     <td><?php echo h($concesion['Concesion']['unidad_tiempo']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones('concesiones', $concesion['Concesion']['id'], $concesion['Concesion']['tipo'], false, true); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
