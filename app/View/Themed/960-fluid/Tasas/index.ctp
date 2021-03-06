<?php /* Menú de accciones */ ?>
<div class="actions box">
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('tasas'); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($tasas);
 echo '</pre>';
 */
?>

<?php /* Tabla tasas */ ?>
<div class="index box">
 <h2><?php echo __('Tasas'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Tasa.concepto', 'Concepto', array('escape' => false, 'title' => 'Ordenar por concepto')); ?></th>
    <th><?php echo $this->Paginator->sort('Tasa.cantidad', 'Cantidad', array('escape' => false, 'title' => 'Ordenar por cantidad')); ?></th>
    <th><?php echo $this->Paginator->sort('Tasa.moneda', 'Moneda', array('escape' => false, 'title' => 'Ordenar por moneda')); ?></th>
    <th><?php echo $this->Paginator->sort('Tasa.inicio_validez', 'Inicio de validez', array('escape' => false, 'title' => 'Ordenar por inicio de validez')); ?></th>
    <th><?php echo $this->Paginator->sort('Tasa.fin_validez', 'Fin de validez', array('escape' => false, 'title' => 'Ordenar por fin de validez')); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de tasas */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($tasas as $tasa): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td>
      <?php echo $this->Html->link($tasa['Tasa']['concepto'], array('controller' => 'tasas', 'action' => 'ver', $tasa['Tasa']['id'])); ?>&nbsp;
     </td>
     <td>
      <?php echo h($this->Number->format($tasa['Tasa']['cantidad'], array('places' => 2, 'before' => '', 'escape' => false, 'decimals' => ',', 'thousands' => '.'))); ?>&nbsp;
     </td>
     <td><?php echo h($tasa['Tasa']['moneda']); ?>&nbsp;</td>
     <td><?php echo h(date('d/m/Y', strtotime($tasa['Tasa']['inicio_validez']))); ?>&nbsp;</td>
     <td>
      <?php
       if ($tasa['Tasa']['fin_validez']) {
        echo h(date('d/m/Y', strtotime($tasa['Tasa']['fin_validez'])));
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones('tasas', $tasa['Tasa']['id'], $tasa['Tasa']['concepto']); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
