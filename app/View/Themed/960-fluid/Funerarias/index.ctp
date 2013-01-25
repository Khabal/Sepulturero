<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('funerarias'); ?>
</div>

<?php /* Tabla funerarias */ ?>
<div class="index box">
 <h2><?php echo __('Funerarias'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Funeraria.nombre', 'Nombre'); ?></th>
    <th><?php echo $this->Paginator->sort('Funeraria.direccion', 'Dirección'); ?></th>
    <th><?php echo $this->Paginator->sort('Funeraria.telefono', 'Teléfono'); ?></th>
    <th><?php echo $this->Paginator->sort('Funeraria.fax', 'Fax'); ?></th>
    <th><?php echo $this->Paginator->sort('Funeraria.correo_electronico', 'Correo electrónico'); ?></th>
    <th><?php echo $this->Paginator->sort('Funeraria.pagina_web', 'Página web'); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de funerarias */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($funerarias as $funeraria): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td><?php echo h($funeraria['Funeraria']['nombre']); ?>&nbsp;</td>
     <td><?php echo h($funeraria['Funeraria']['direccion']); ?>&nbsp;</td>
     <td><?php echo h($funeraria['Funeraria']['telefono']); ?>&nbsp;</td>
     <td><?php echo h($funeraria['Funeraria']['fax']); ?>&nbsp;</td>
     <td class="email"><?php echo h($funeraria['Funeraria']['correo_electronico']); ?>&nbsp;</td>
     <td class="enlace"><?php echo $this->Html->link(__($funeraria['Funeraria']['pagina_web']), $funeraria['Funeraria']['pagina_web'], array('escape' => false, 'target' => '_blank')); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones('funerarias', $funeraria['Funeraria']['id'], $funeraria['Funeraria']['nombre']); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>