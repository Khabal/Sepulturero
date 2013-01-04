<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('arrendatarios'); ?>
</div>

<pre>
<?php print_r($kk) ?>
<?php print_r($this->params->query) ?>
<?php print_r($this->params['pass']) ?>
</pre>

<?php /* Tabla arrendatarios */ ?>
<div class="index box">
 <h2><?php echo __('Arrendatarios'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Persona.nombre_completo', 'Nombre'); ?></th>
    <th><?php echo $this->Paginator->sort('Persona.dni', 'D.N.I.'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.direccion', 'Dirección'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.localidad', 'Localidad'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.provincia', 'Provincia'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.pais', 'País'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.codigo_postal', 'Código postal'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.telefono', 'Teléfono'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.correo_electronico', 'Correo electrónico'); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de arrendatarios */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach($arrendatarios as $arrendatario): ?>
    <?php $class = null; if($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td>
      <?php echo $this->Html->link($arrendatario['Persona']['nombre_completo'], array('controller' => 'arrendatarios', 'action' => 'ver', $arrendatario['Arrendatario']['id'])); ?>&nbsp;
     </td>
     <td><?php echo h($arrendatario['Persona']['dni']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['direccion']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['localidad']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['provincia']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['pais']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['codigo_postal']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['telefono']); ?>&nbsp;</td>
     <td class="email"><?php echo h($arrendatario['Arrendatario']['correo_electronico']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones('arrendatarios', $arrendatario['Arrendatario']['id'], $arrendatario['Persona']['nombre_completo']); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
