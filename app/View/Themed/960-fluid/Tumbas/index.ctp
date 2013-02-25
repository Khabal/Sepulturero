<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
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
    <th><?php echo $this->Paginator->sort('Tumba.tipo', 'Tipo de tumba'); ?></th>
    <th><?php echo $this->Paginator->sort('Tumba.localizacion', 'Localicación'); ?></th>
    <th><?php echo $this->Paginator->sort('Tumba.poblacion', 'Población'); ?></th>
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
      if (!empty($tumba['Tumba']['Columbario'])) {
       $localizacion = $tumba['Tumba']['Columbario']['localizacion'];
      }
      elseif(!empty($tumba['Tumba']['Exterior'])) {
       $localizacion = $tumba['Tumba']['Exterior']['localizacion'];
      }
      elseif(!empty($tumba['Tumba']['Nicho'])) {
       $localizacion = $tumba['Tumba']['Nicho']['localizacion'];
      }
      elseif(!empty($tumba['Tumba']['Panteon'])) {
       $localizacion = $tumba['Tumba']['Panteon']['localizacion'];
      }
     ?>
     <td>
      <?php if (strlen($localizacion) > 0): ?>
       <?php echo $this->Html->link($localizacion, array('controller' => 'tumbas', 'action' => 'ver', $tumba['Tumba']['id'])); ?>
      <?php else: ?>
       Sin información
      <?php endif; ?>&nbsp;
     </td>
     <td><?php echo h($tumba['Tumba']['poblacion']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones(strtolower($this->name), $tumba['Tumba']['id'], $tumba['Tumba']['tipo'] . " - " . $localizacion); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
