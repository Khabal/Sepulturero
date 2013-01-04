<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('licencias', $licencia['Licencia']['id'], $licencia['Licencia']['identificador']); ?>
</div>

<?php /* Datos funeraria */ ?>
<div class="view box">
 <h2><?php echo __('Datos de la licencia'); ?></h2>
 <dl>
  <dt><?php echo __('Número de licencia'); ?>:</dt>
  <dd><?php echo h($licencia['Licencia']['numero_licencia']); ?>&nbsp;</dd>
  <dt><?php echo __('Fecha de aprobación'); ?>:</dt>
  <dd><?php echo date('d/m/Y', strtotime($licencia['Licencia']['fecha_aprobacion'])); ?>&nbsp;</dd>
  <dt><?php echo __('Años de concesión'); ?>:</dt>
  <dd><?php echo $licencia['Licencia']['anos_concesion']; ?>&nbsp;</dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($licencia['Licencia']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>

<?php /* Enterramiento relacionado */ ?>
<div class="related box">
 <h2><?php echo __('Enterramiento licenciado'); ?></h2>
  <?php if (!empty($licencia['Enterramiento'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Fecha de enterramiento'); ?></th>
     <th><?php echo __('Difunto'); ?></th>
     <th><?php echo __('D.N.I.'); ?></th>
     <th><?php echo __('Tipo de tumba'); ?></th>
     <th><?php echo __('Identificador de tumba'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información del enterramiento */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo date('d/m/Y', strtotime($licencia['Enterramiento']['fecha'])); ?>&nbsp;</td>
     <td><?php echo h($licencia['Enterramiento']['Difunto']['Persona']['nombre_completo']); ?>&nbsp;</td>
     <td><?php echo h($licencia['Enterramiento']['Difunto']['Persona']['dni']); ?>&nbsp;</td>
     <td><?php echo h($licencia['Enterramiento']['Tumba']['tipo']); ?>&nbsp;</td>
     <td>
      <?php
       if ($licencia['Enterramiento']['Tumba']['Columbario']) {
        echo h($licencia['Enterramiento']['Tumba']['Columbario']['identificador']);
       }
       elseif ($licencia['Enterramiento']['Tumba']['Nicho']) {
        echo h($licencia['Enterramiento']['Tumba']['Nicho']['identificador']);
       }
       elseif ($licencia['Enterramiento']['Tumba']['Panteon']) {
        echo h($licencia['Enterramiento']['Tumba']['Panteon']['identificador']);
       }
       elseif ($licencia['Enterramiento']['Tumba']['Exterior']) {
        echo h($licencia['Enterramiento']['Tumba']['Exterior']['identificador']);
       }
      ?>&nbsp;
     </td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'enterramientos', 'action' => 'ver', $licencia['Enterramiento']['id']), array('escape' => false)); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Documentos relacionados */ ?>
<div class="related box">
 <h2><?php echo __('Documentos asociados'); ?></h2>
 <?php if (!empty($licencia['Documento'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Nombre'); ?></th>
     <th><?php echo __('Tipo'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de documentos */ ?>
   <tbody>
    <?php $i = 0; ?>
    <?php foreach ($licencia['Documento'] as $documento): ?>
     <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
     <tr<?php echo $class; ?>>
      <td><?php echo h($documento['nombre']); ?>&nbsp;</td>
      <td><?php echo h($documento['tipo']); ?>&nbsp;</td>
      <td class="actions">
       <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'documentos', 'action' => 'ver', $licencia['Documento']['id']), array('escape' => false)); ?>
      </td>
     </tr>
    <?php endforeach; ?>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>
