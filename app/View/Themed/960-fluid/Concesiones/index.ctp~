<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
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
    <th><?php echo $this->Paginator->sort('Concesion.tipo', 'Tipo de concesión'); ?></th>
    <th><?php echo $this->Paginator->sort('Licencia.anos_concesion', 'Años de concesión'); ?></th>
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
     <td><?php echo $concesion['Concesion']['anos_concesion']; ?>&nbsp;</td>
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
