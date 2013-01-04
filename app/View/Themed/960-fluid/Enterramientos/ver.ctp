<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido(strtolower($this->name), $enterramiento['Enterramiento']['id'], $enterramiento['Difunto']['Persona']['nombre_completo']); ?>
</div>

<?php /* Datos enterramiento */ ?>
<div class="view box">
 <h2><?php echo __('Datos del enterramiento');?></h2>
 <dl>
  <dt><?php echo __('Fecha de enterramiento'); ?></dt>
  <dd><?php echo h(date('d/m/Y', strtotime($enterramiento['Enterramiento']['fecha']))); ?>&nbsp;</dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($enterramiento['Enterramiento']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>

<?php /* Difunto relacionado */ ?>
<div class="related box">
 <h2><?php echo __('Difunto enterrado'); ?></h2>
  <?php if (!empty($enterramiento['Difunto'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Nombre'); ?></th>
     <th><?php echo __('D.N.I.'); ?></th>
     <th><?php echo __('Estado del cuerpo'); ?></th>
     <th><?php echo __('Fecha de defunción'); ?></th>
     <th><?php echo __('Edad de defunción'); ?></th>
     <th><?php echo __('Causa de defunción'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información del difunto */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h($enterramiento['Difunto']['Persona']['nombre_completo']); ?>&nbsp;</td>
     <td><?php echo h($enterramiento['Difunto']['Persona']['dni']); ?>&nbsp;</td>
     <td><?php echo h($enterramiento['Difunto']['estado']); ?>&nbsp;</td>
     <td>
      <?php
       if ($enterramiento['Difunto']['fecha_defuncion']) {
        echo h(date('d/m/Y', strtotime($enterramiento['Difunto']['fecha_defuncion'])));
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if ($enterramiento['Difunto']['edad_defuncion']) {
        echo h($enterramiento['Difunto']['edad_defuncion']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if ($enterramiento['Difunto']['causa_defuncion']) {
        echo h($enterramiento['Difunto']['causa_defuncion']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'difuntos', 'action' => 'ver', $enterramiento['Difunto']['id']), array('escape' => false)); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Tumba relacionada */ ?>
<div class="related box">
 <h2><?php echo __('Tumba de enterramiento'); ?></h2>
  <?php if (!empty($enterramiento['Tumba'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Tipo de tumba'); ?></th>
     <th><?php echo __('Identificador de tumba'); ?></th>
     <th><?php echo __('Población'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información de la tumba */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h($enterramiento['Tumba']['tipo']); ?>&nbsp;</td>
     <td>
      <?php
       if ($enterramiento['Tumba']['Columbario']) {
        echo h($enterramiento['Tumba']['Columbario']['identificador']);
       }
       elseif ($enterramiento['Tumba']['Nicho']) {
        echo h($enterramiento['Tumba']['Nicho']['identificador']);
       }
       elseif ($enterramiento['Tumba']['Panteon']) {
        echo h($enterramiento['Tumba']['Panteon']['identificador']);
       }
       elseif ($enterramiento['Tumba']['Exterior']) {
        echo h($enterramiento['Tumba']['Exterior']['identificador']);
       }
      ?>&nbsp;
     </td>
     <td><?php echo h($enterramiento['Tumba']['poblacion']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'tumbas', 'action' => 'ver', $enterramiento['Enterramiento']['tumba_id']), array('escape' => false)); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Licencia relacionada */ ?>
<div class="related box">
 <h2><?php echo __('Licencia para enterramiento'); ?></h2>
  <?php if (!empty($enterramiento['Licencia'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Licencia'); ?></th>
     <th><?php echo __('Número de licencia'); ?></th>
     <th><?php echo __('Fecha de aprobación'); ?></th>
     <th><?php echo __('Años de concesión'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información de la licencia */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h($enterramiento['Licencia']['identificador']); ?>&nbsp;</td>
     <td><?php echo h($enterramiento['Licencia']['numero_licencia']); ?>&nbsp;</td>
     <td><?php echo h(date('d/m/Y', strtotime($enterramiento['Licencia']['fecha_aprobacion']))); ?>&nbsp;</td>
     <td><?php echo h($enterramiento['Licencia']['anos_concesion']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'tumbas', 'action' => 'ver', $enterramiento['Enterramiento']['licencia_id']), array('escape' => false)); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Tasas relacionadas */ ?>
<div class="related box">
 <h2><?php echo __('Tasas de enterramiento'); ?></h2>
 <?php if (!empty($enterramiento['EnterramientoTasa'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Tipo'); ?></th>
     <th><?php echo __('Cantidad'); ?></th>
     <th><?php echo __('Moneda'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de tasas */ ?>
   <tbody>
    <?php $i = 0; ?>
    <?php foreach ($enterramiento['EnterramientoTasa'] as $tasa): ?>
     <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
     <tr<?php echo $class; ?>>
      <td><?php echo h($tasa['Tasa']['tipo']); ?>&nbsp;</td>
      <td><?php echo h($tasa['Tasa']['cantidad']); ?>&nbsp;</td>
      <td><?php echo h($tasa['Tasa']['moneda']); ?>&nbsp;</td>
      <td class="actions">
       <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'tasas', 'action' => 'ver', $tasa['Tasa']['id']), array('escape' => false)); ?>
      </td>
     </tr>
    <?php endforeach; ?>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>
