<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('tumbas'); ?>
</div>

<?php /* Tabla tumbas */ ?>
<div class="index box">
 <h2><?php echo __('Tumbas'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Tumba.tipo', 'Tipo de tumba'); ?></th>
    <th><?php echo $this->Paginator->sort('Tumba', 'Identificación'); ?></th>
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
    <?php /* Obtener identificador de tumba */ ?>
    <?php $identificador = ""; if($tumba['Columbario']['identificador']) {$identificador = $tumba['Columbario']['identificador'];} elseif($tumba['Nicho']['identificador']) {$identificador = $tumba['Nicho']['identificador'];} elseif($tumba['Panteon']['identificador']) {$identificador = $tumba['Panteon']['identificador'];} ?>
     <td>
      <?php if (strlen($identificador) > 0): ?>
       <?php echo $this->Html->link($identificador, array('controller' => 'tumbas', 'action' => 'ver', $tumba['Tumba']['id'])); ?>
      <?php else: ?>
       Sin información
      <?php endif; ?>&nbsp;
     </td>
     <td><?php echo h($tumba['Tumba']['poblacion']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones('tumbas', $tumba['Tumba']['id'], $tumba['Tumba']['tipo'] . " - " . $identificador); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
