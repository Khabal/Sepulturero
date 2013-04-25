<?php /* Menú de accciones */ ?>
<div class="actions box">
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('forenses'); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($forenses);
 echo '</pre>';
 */
?>

<?php /* Tabla médicos forenses */ ?>
<div class="index box">
 <h2><?php echo __('Médicos forenses'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Persona.nombre_completo', 'Nombre', array('escape' => false, 'title' => 'Ordenar por nombre del médico forense')); ?></th>
    <th><?php echo $this->Paginator->sort('Persona.dni', 'D.N.I.', array('escape' => false, 'title' => 'Ordenar por D.N.I. del médico forense')); ?></th>
    <th><?php echo $this->Paginator->sort('Forense.numero_colegiado', 'Número de colegiado', array('escape' => false, 'title' => 'Ordenar por número de colegiado')); ?></th>
    <th><?php echo $this->Paginator->sort('Forense.colegio', 'Colegio', array('escape' => false, 'title' => 'Ordenar por colegio')); ?></th>
    <th><?php echo $this->Paginator->sort('Forense.telefono', 'Teléfono', array('escape' => false, 'title' => 'Ordenar por teléfono')); ?></th>
    <th><?php echo $this->Paginator->sort('Forense.correo_electronico', 'Correo electrónico', array('escape' => false, 'title' => 'Ordenar por correo electrónico')); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de médicos forenses */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($forenses as $forense): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td>
      <?php echo $this->Html->link($forense['Persona']['nombre_completo'], array('controller' => 'forenses', 'action' => 'ver', $forense['Forense']['id'])); ?>&nbsp;
     </td>
     <td>
	 <?php
       if (!empty($forense['Persona']['dni'])) {
        echo h($forense['Persona']['dni']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td><?php echo h($forense['Forense']['numero_colegiado']); ?>&nbsp;</td>
     <td><?php echo h($forense['Forense']['colegio']); ?>&nbsp;</td>
     <td>
      <?php
       if (!empty($forense['Forense']['telefono'])) {
        echo h($forense['Forense']['telefono']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td class="email">
      <?php
       if (!empty($forense['Forense']['correo_electronico'])) {
        echo h($forense['Forense']['correo_electronico']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones('forenses', $forense['Forense']['id'], $forense['Persona']['nombre_completo']); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
