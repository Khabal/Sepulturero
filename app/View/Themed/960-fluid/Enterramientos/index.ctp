<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<!-- Tabla enterramientos -->
<div class="index box">
 <h2><?php __('Enterramientos');?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Enterramiento.fecha', 'Fecha'); ?></th>
    <th><?php echo $this->Paginator->sort('Difunto.Persona.nombre_completo', 'Nombre del difunto'); ?></th>
    <th><?php echo $this->Paginator->sort('Difunto.Persona.dni', 'D.N.I. del difunto'); ?></th>
    <th><?php echo $this->Paginator->sort('Licencia.identificador', 'Número de licencia'); ?></th>
    <th><?php echo $this->Paginator->sort('Tumba.identificador', 'Tumba'); ?></th>
    <th class="actions"><?php echo __('Acciones');?></th>
   </tr>
  </thead>
  <?php /* Listado de enterramientos */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($enterramientos as $enterramiento): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td><?php echo h(date('d/m/Y', strtotime($enterramiento['Enterramiento']['fecha']))); ?>&nbsp;</td>
     <td>
      <?php echo $this->Html->link($enterramiento['Difunto']['Persona']['nombre_completo'], array('controller' => 'difuntos', 'action' => 'ver', $enterramiento['Enterramiento']['difunto_id'])); ?>&nbsp;
     </td>
     <td><?php echo h($enterramiento['Difunto']['Persona']['dni']); ?>&nbsp;</td>
     <td>
      <?php echo $this->Html->link($enterramiento['Licencia']['identificador'], array('controller' => 'licencias', 'action' => 'ver', $enterramiento['Enterramiento']['licencia_id'])); ?>&nbsp;
     <td class="enlace">
      <?php /* Obtener identificador de tumba */
       $identificador = "";
       if ($enterramiento['Tumba']['Columbario']) {
        $identificador = $enterramiento['Tumba']['Columbario']['identificador'];
       }
       elseif ($enterramiento['Tumba']['Nicho']) {
        $identificador = $enterramiento['Tumba']['Nicho']['identificador'];
       }
       elseif ($enterramiento['Tumba']['Panteon']) {
        $identificador = $enterramiento['Tumba']['Panteon']['identificador'];
       }
       echo $this->Html->link($enterramiento['Tumba']['tipo'] . " - " . $identificador, array('controller' => 'tumbas', 'action' => 'ver', $enterramiento['Enterramiento']['tumba_id']));
      ?> &nbsp;
     </td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones(strtolower($this->name), $enterramiento['Enterramiento']['id'], $enterramiento['Enterramiento']['fecha']); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>