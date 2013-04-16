<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('tumbas'); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($tumbas);
 echo '</pre>';
 */
?>

<?php /* Tabla tumbas */ ?>
<div class="index box">
 <h2><?php echo __('Tumbas'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Tumba.tipo', 'Tipo de tumba', array('escape' => false, 'title' => 'Ordenar por tipo de tumba')); ?></th>
    <th><?php echo $this->Paginator->sort('Tumba.localizacion', 'Localicación', array('escape' => false, 'title' => 'Ordenar por localicación de la tumba')); ?></th>
    <th><?php echo $this->Paginator->sort('Tumba.poblacion', 'Población', array('escape' => false, 'title' => 'Ordenar por población de la tumba')); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de tumbas */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($tumbas as $tumba): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td><?php echo h($tumba['Tumba']['tipo']); ?>&nbsp;</td>
     <?php /* Obtener la localización de tumba */
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
     <td>
      <?php if (!empty($localizacion)): ?>
       <?php echo $this->Html->link($localizacion, array('controller' => 'tumbas', 'action' => 'ver', $tumba['Tumba']['id'])); ?>
      <?php else: ?>
       Sin información
      <?php endif; ?>&nbsp;
     </td>
     <td><?php echo h($tumba['Tumba']['poblacion']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones('tumbas', $tumba['Tumba']['id'], $tumba['Tumba']['tipo'] . " - " . $localizacion); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
