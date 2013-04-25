<?php /* Menú de accciones */ ?>
<div class="actions box">
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('arrendatarios'); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($arrendatarios);
 echo '</pre>';
 */
?>

<?php /* Tabla arrendatarios */ ?>
<div class="index box">
 <h2><?php echo __('Arrendatarios'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Persona.nombre_completo', 'Nombre', array('escape' => false, 'title' => 'Ordenar por nombre')); ?></th>
    <th><?php echo $this->Paginator->sort('Persona.dni', 'D.N.I.', array('escape' => false, 'title' => 'Ordenar por D.N.I.')); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.direccion', 'Dirección', array('escape' => false, 'title' => 'Ordenar por dirección')); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.localidad', 'Localidad', array('escape' => false, 'title' => 'Ordenar por localidad')); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.provincia', 'Provincia', array('escape' => false, 'title' => 'Ordenar por provincia')); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.pais', 'País', array('escape' => false, 'title' => 'Ordenar por país')); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.codigo_postal', 'Código postal', array('escape' => false, 'title' => 'Ordenar por código postal')); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.telefono_fijo', 'Teléfono fijo', array('escape' => false, 'title' => 'Ordenar por teléfono fijo')); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.telefono_movil', 'Teléfono móvil', array('escape' => false, 'title' => 'Ordenar por teléfono móvil')); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.correo_electronico', 'Correo electrónico', array('escape' => false, 'title' => 'Ordenar por correo electrónico')); ?></th>
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
     <td>
      <?php
       if (!empty($arrendatario['Persona']['dni'])) {
        echo h($arrendatario['Persona']['dni']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendatario['Arrendatario']['direccion'])) {
        echo h($arrendatario['Arrendatario']['direccion']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendatario['Arrendatario']['localidad'])) {
        echo h($arrendatario['Arrendatario']['localidad']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendatario['Arrendatario']['provincia'])) {
        echo h($arrendatario['Arrendatario']['provincia']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendatario['Arrendatario']['pais'])) {
        echo h($arrendatario['Arrendatario']['pais']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendatario['Arrendatario']['codigo_postal'])) {
        echo h($arrendatario['Arrendatario']['codigo_postal']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendatario['Arrendatario']['telefono_fijo'])) {
        echo h($arrendatario['Arrendatario']['telefono_fijo']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($arrendatario['Arrendatario']['telefono_movil'])) {
        echo h($arrendatario['Arrendatario']['telefono_movil']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td class="email">
      <?php
       if (!empty($arrendatario['Arrendatario']['correo_electronico'])) {
        echo h($arrendatario['Arrendatario']['correo_electronico']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
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
