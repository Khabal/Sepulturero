<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('movimientos'); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($movimientos);
 echo '</pre>';
 */
?>

<?php /* Tabla movimientos */ ?>
<div class="index box">
 <h2><?php echo __('Movimientos'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Movimiento.fecha', 'Fecha');?></th>
    <th><?php echo $this->Paginator->sort('Movimiento.tipo', 'Tipo');?></th>
    <th><?php echo $this->Paginator->sort('Movimiento.viajeros', 'Difuntos');?></th>
    <th><?php echo $this->Paginator->sort('Movimiento.cementerio_origen', 'Cementerio de origen');?></th>
    <th><?php echo $this->Paginator->sort('MovimientoTumba.Tumba.localizacion', 'Tumba de origen');?></th>
    <th><?php echo $this->Paginator->sort('Movimiento.cementerio_destino', 'Cementerio de destino');?></th>
    <th><?php echo $this->Paginator->sort('MovimientoTumba.Tumba.localizacion', 'Tumba de destino');?></th>
    <th><?php echo $this->Paginator->sort('Movimiento.motivo', 'Motivo');?></th>
    <th class="actions"><?php echo __('Acciones');?></th>
   </tr>
  </thead>
  <?php /* Listado de movimientos */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($movimientos as $movimiento): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <?php if ($movimiento['Movimiento']['documental']) { $estilo = ' style="color:#FF0000;"'; } ?>
    <tr<?php echo $class; echo $estilo;?>>
     <?php /* Obtener identificadores de tumbas de origen y destino */
      $origen = null;
      $destino = null;
      foreach ($movimiento['MovimientoTumba'] as $tumba) {
       if ($tumba['origen_destino'] == "Origen") {
        $origen = $tumba;
       }
       elseif ($tumba['origen_destino'] == "Destino") {
        $destino = $tumba;
       }
      }
     ?>
     <td><?php echo h(date('d/m/Y', strtotime($movimiento['Movimiento']['fecha']))); ?>&nbsp;</td>
     <td><?php echo h($movimiento['Movimiento']['tipo']); ?>&nbsp;</td>
     <td><?php echo h($movimiento['Movimiento']['viajeros']); ?>&nbsp;</td>
     
     <?php /* Ignorar información si el movimiento no tiene origen */
      if ($movimiento['Movimiento']['tipo'] == "Inhumación") {
       echo '<td>' . '-----' . '&nbsp;</td>';
       echo '<td>' . '-----' . '&nbsp;</td>';
      }
      else {
       echo '<td>'. h($movimiento['Movimiento']['cementerio_origen']) . '&nbsp;</td>';
       /* Obtener la localización de tumba */
       $localizacion = "";
       if (!empty($origen['Tumba']['Columbario']['localizacion'])) {
        $localizacion = $origen['Tumba']['Columbario']['localizacion'];
       }
       elseif(!empty($origen['Tumba']['Exterior']['localizacion'])) {
        $localizacion = $origen['Tumba']['Exterior']['localizacion'];
       }
       elseif(!empty($origen['Tumba']['Nicho']['localizacion'])) {
        $localizacion = $origen['Tumba']['Nicho']['localizacion'];
       }
       elseif(!empty($origen['Tumba']['Panteon']['localizacion'])) {
        $localizacion = $origen['Tumba']['Panteon']['localizacion'];
       }
       
       if (!empty($localizacion)) {
        echo '<td>'. $this->Html->link($origen['Tumba']['tipo'] . " - " . $localizacion, array('controller' => 'tumbas', 'action' => 'ver', $origen['tumba_id'])) . '&nbsp;</td>';
       }
       else {
        echo '<td>'. 'Sin información' . '&nbsp;</td>';
       } 
      }
     ?>
     
     <?php /* Ignorar información si el movimiento no tiene destino */
      if ($movimiento['Movimiento']['tipo'] == "Exhumación") {
       echo '<td>' . '-----' . '&nbsp;</td>';
       echo '<td>' . '-----' . '&nbsp;</td>';
      }
      else {
       echo '<td>'. h($movimiento['Movimiento']['cementerio_destino']) . '&nbsp;</td>';
       /* Obtener la localización de tumba */
       $localizacion = "";
       if (!empty($destino['Tumba']['Columbario']['localizacion'])) {
        $localizacion = $destino['Tumba']['Columbario']['localizacion'];
       }
       elseif(!empty($destino['Tumba']['Exterior']['localizacion'])) {
        $localizacion = $destino['Tumba']['Exterior']['localizacion'];
       }
       elseif(!empty($destino['Tumba']['Nicho']['localizacion'])) {
        $localizacion = $destino['Tumba']['Nicho']['localizacion'];
       }
       elseif(!empty($destino['Tumba']['Panteon']['localizacion'])) {
        $localizacion = $destino['Tumba']['Panteon']['localizacion'];
       }
       
       if (!empty($localizacion)) {
        echo '<td>'. $this->Html->link($destino['Tumba']['tipo'] . " - " . $localizacion, array('controller' => 'tumbas', 'action' => 'ver', $destino['tumba_id'])) . '&nbsp;</td>';
       }
       else {
        echo '<td>'. 'Sin información' . '&nbsp;</td>';
       }
      }
     ?>
     
     <td><?php echo $movimiento['Movimiento']['motivo']; ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones('movimientos', $movimiento['Movimiento']['id'], date('d/m/Y', strtotime($movimiento['Movimiento']['fecha'])) . " - " . $movimiento['Movimiento']['motivo']); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
