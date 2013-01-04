<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<?php /* Tabla difuntos */ ?>
<div class="index box">
 <h2><?php echo __('Difuntos'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Persona.nombre_completo', 'Nombre'); ?></th>
    <th><?php echo $this->Paginator->sort('Persona.dni', 'D.N.I.'); ?></th>
    <th><?php echo $this->Paginator->sort('Tumba.tumba_identificador', 'Tumba'); ?></th>
    <th><?php echo $this->Paginator->sort('Difunto.estado', 'Estado del cuerpo'); ?></th>
    <th><?php echo $this->Paginator->sort('Difunto.fecha_defuncion', 'Fecha de defunción'); ?></th>
    <th><?php echo $this->Paginator->sort('Difunto.edad_defuncion', 'Edad de defunción'); ?></th>
    <th><?php echo $this->Paginator->sort('Difunto.causa_defuncion', 'Causa de defunción'); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de difuntos */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($difuntos as $difunto): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td>
      <?php echo $this->Html->link($difunto['Persona']['nombre_completo'], array('controller' => 'difuntos', 'action' => 'ver', $difunto['Difunto']['id'])); ?>&nbsp;
     </td>
     <td><?php echo h($difunto['Persona']['dni']); ?>&nbsp;</td>
     <td class="enlace">
      <?php /* Obtener identificador de tumba */
       if ($difunto['Difunto']['tumba_id']) {
        $identificador = "";
        if ($difunto['Tumba']['Columbario']) {
         $identificador = $difunto['Tumba']['Columbario']['identificador'];
        }
        elseif ($difunto['Tumba']['Nicho']) {
         $identificador = $difunto['Tumba']['Nicho']['identificador'];
        }
        elseif ($difunto['Tumba']['Panteon']) {
         $identificador = $difunto['Tumba']['Panteon']['identificador'];
        }
        echo $this->Html->link($difunto['Tumba']['tipo'] . " - " . $identificador, array('controller' => 'tumbas', 'action' => 'ver', $difunto['Difunto']['tumba_id']));
       }
       else {
        echo h("Tumba desconocida");
       }
      ?> &nbsp;
     </td>
     <td><?php echo h($difunto['Difunto']['estado']); ?>&nbsp;</td>
     <td>
      <?php
       if ($difunto['Difunto']['fecha_defuncion']) {
        echo h(date('d/m/Y', strtotime($difunto['Difunto']['fecha_defuncion'])));
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if ($difunto['Difunto']['edad_defuncion']) {
        echo h($difunto['Difunto']['edad_defuncion']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if ($difunto['Difunto']['causa_defuncion']) {
        echo h($difunto['Difunto']['causa_defuncion']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones(strtolower($this->name), $difunto['Difunto']['id'], $difunto['Persona']['nombre_completo']); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
