<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<?php
 
 echo '<pre>';
 print_r($arrendamientos);
 echo '</pre>';
 
?>

<?php /* Tabla arrendamientos */ ?>
<div class="index box">
 <h2><?php echo __('Arrendamientos'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Persona.nombre_completo', 'Arrendatario'); ?></th>
    <th><?php echo $this->Paginator->sort('Persona.dni', 'D.N.I.'); ?></th>
    <th><?php echo $this->Paginator->sort('Tumba.localizacion', 'Tumba'); ?></th>
    <th><?php echo $this->Paginator->sort('Concesion.tipo', 'Tipo de concesión'); ?></th>
    <th><?php echo $this->Paginator->sort('Concesion.anos_concesion', 'Años de concesión'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendamiento.fecha_arrendamiento', 'Fecha de arrendamiento'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendamiento.estado', 'Estado del arrendamiento'); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de arrendamientos */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach($arrendamientos as $arrendamiento): ?>
    <?php $class = null; if($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td>
      <?php echo $this->Html->link($arrendamiento['Persona']['nombre_completo'], array('controller' => 'arrendatarios', 'action' => 'ver', $arrendamiento['Arrendatario']['id'])); ?>&nbsp;
     </td>
     <td>
	 <?php
       if (!empty($arrendamiento['Persona']['dni'])) {
        echo h($arrendamiento['Persona']['dni']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td><?php echo h($arrendatario['Arrendatario']['direccion']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['localidad']); ?>&nbsp;</td>
     <td>
      <?php
       if ($arrendatario['Arrendatario']['provincia']) {
        echo h($arrendatario['Arrendatario']['provincia']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td><?php echo h($arrendatario['Arrendatario']['pais']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['codigo_postal']); ?>&nbsp;</td>
     <td>
      <?php
       if ($arrendatario['Arrendatario']['telefono']) {
        echo h($arrendatario['Arrendatario']['telefono']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td class="email">
      <?php
       if ($arrendatario['Arrendatario']['correo_electronico']) {
        echo h($arrendatario['Arrendatario']['correo_electronico']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones(strtolower($this->name), $arrendamiento['Arrendatario']['id'], $arrendamiento['Persona']['nombre_completo']); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
