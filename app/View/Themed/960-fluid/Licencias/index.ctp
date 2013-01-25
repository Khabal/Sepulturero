<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('licencias'); ?>
</div>

<?php /* Tabla licencias */ ?>
<div class="index box">
 <h2><?php echo __('Licencias');?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Licencia.identificador', 'Licencia'); ?></th>
    <th><?php echo $this->Paginator->sort('Licencia.numero_licencia', 'Número de licencia'); ?></th>
    <th><?php echo $this->Paginator->sort('Licencia.fecha_aprobacion', 'Fecha de aprobación'); ?></th>
    <th><?php echo $this->Paginator->sort('Licencia.anos_concesion', 'Años de concesión'); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de licencias */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($licencias as $licencia): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td>
      <?php echo $this->Html->link($licencia['Licencia']['identificador'], array('controller' => 'licencias', 'action' => 'ver', $licencia['Licencia']['id'])); ?>&nbsp;
     </td>
     <td><?php echo $licencia['Licencia']['numero_licencia']; ?>&nbsp;</td>
     <td><?php echo date('d/m/Y', strtotime($licencia['Licencia']['fecha_aprobacion'])); ?>&nbsp;</td>
     <td><?php echo $licencia['Licencia']['anos_concesion']; ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones('licencias', $licencia['Licencia']['id'], $licencia['Licencia']['identificador'], false, true); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>