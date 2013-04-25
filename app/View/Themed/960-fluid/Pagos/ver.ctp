<?php /* Menú de accciones */ ?>
<div class="actions box">
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('pagos', $pago['Pago']['id'], date('d/m/Y', strtotime($pago['Pago']['fecha']))); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($pago);
 echo '</pre>';
 */
?>

<?php echo $this->GuarritasEnergeticas->burton_volver(); ?>

<?php /* Datos pago */ ?>
<div class="view box">
 <h2><?php echo __('Datos del pago'); ?></h2>
 <dl>
  <dt><?php echo __('Fecha'); ?>:</dt>
  <dd><?php echo date('d/m/Y', strtotime($pago['Pago']['fecha'])); ?>&nbsp;</dd>
  <dt><?php echo __('Total'); ?>:</dt>
  <dd><?php echo $this->Number->format($pago['Pago']['total'], array('places' => 2, 'before' => '', 'escape' => false, 'decimals' => ',', 'thousands' => '.')); ?>&nbsp;</dd>
  <dt><?php echo __('Moneda'); ?>:</dt>
  <dd><?php echo h($pago['Pago']['moneda']); ?>&nbsp;</dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($pago['Pago']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>

<?php /* Pagador(Arrendatario/Funeraria) relacionado */ ?>
<div class="related box">
 <h2><?php echo __('Pagador'); ?></h2>
 <?php if (!empty($pago['Pago']['arrendatario_id'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Tipo'); ?></th>
     <th><?php echo __('Nombre'); ?></th>
     <th><?php echo __('D.N.I.'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Pagador Arrendatario */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h("Particular"); ?>&nbsp;</td>
     <td><?php echo h($pago['Arrendatario']['Persona']['nombre_completo']); ?>&nbsp;</td>
     <td>
      <?php
       if ($pago['Arrendatario']['Persona']['dni']) {
        echo h($pago['Arrendatario']['Persona']['dni']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'arrendatarios', 'action' => 'ver', $pago['Pago']['arrendatario_id']), array('escape' => false, 'title' => 'Ver arrendatario')); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php elseif (!empty($pago['Pago']['funeraria_id'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Tipo'); ?></th>
     <th><?php echo __('Nombre'); ?></th>
     <th><?php echo __('C.I.F.'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Pagador Funeraria */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h("Funeraria"); ?>&nbsp;</td>
     <td><?php echo h($pago['Funeraria']['nombre']); ?>&nbsp;</td>
     <td><?php echo h($pago['Funeraria']['cif']); ?>&nbsp;</td>
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'funerarias', 'action' => 'ver', $pago['Pago']['funeraria_id']), array('escape' => false, 'title' => 'Ver funeraria')); ?>
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
 <h2><?php echo __('Tumba'); ?></h2>
 <?php if (!empty($pago['Pago']['tumba_id'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Tipo'); ?></th>
     <th><?php echo __('Localización'); ?></th>
     <th><?php echo __('Población'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Datos de la tumba */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h($pago['Tumba']['tipo']); ?>&nbsp;</td>
     <td>
      <?php /* Obtener la localización de tumba */
       $localizacion = "";
       if (!empty($pago['Tumba']['Columbario']['localizacion'])) {
        $localizacion = $pago['Tumba']['Columbario']['localizacion'];
       }
       elseif(!empty($pago['Tumba']['Exterior']['localizacion'])) {
        $localizacion = $pago['Tumba']['Exterior']['localizacion'];
       }
       elseif(!empty($pago['Tumba']['Nicho']['localizacion'])) {
        $localizacion = $pago['Tumba']['Nicho']['localizacion'];
       }
       elseif(!empty($pago['Tumba']['Panteon']['localizacion'])) {
        $localizacion = $pago['Tumba']['Panteon']['localizacion'];
       }
       echo h($localizacion);
      ?>&nbsp;
     </td>
     <td><?php echo h($pago['Tumba']['poblacion']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'tumbas', 'action' => 'ver', $pago['Pago']['tumba_id']), array('escape' => false, 'title' => 'Ver tumba')); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Tasas pagadas */ ?>
<div class="related box">
 <h2><?php echo __('Tasas pagadas'); ?></h2>
 <?php if (!empty($pago['PagoTasa'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Concepto'); ?></th>
     <th><?php echo __('Cantidad'); ?></th>
     <th><?php echo __('Moneda'); ?></th>
     <th><?php echo __('Detalle'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de tasas */ ?>
   <tbody>
    <?php $i = 0; ?>
    <?php foreach ($pago['PagoTasa'] as $tasa): ?>
     <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
     <tr<?php echo $class; ?>>
      <td><?php echo h($tasa['Tasa']['concepto']); ?>&nbsp;</td>
      <td><?php echo $this->Number->format($tasa['Tasa']['cantidad'], array('places' => 2, 'before' => '', 'escape' => false, 'decimals' => ',', 'thousands' => '.')); ?>&nbsp;</td>
      <td><?php echo h($tasa['Tasa']['moneda']); ?>&nbsp;</td>
      <td><?php echo h($tasa['detalle']); ?>&nbsp;</td>
      <td class="actions">
       <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'tasas', 'action' => 'ver', $tasa['tasa_id']), array('escape' => false, 'title' => 'Ver tasa')); ?>
      </td>
     </tr>
    <?php endforeach; ?>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php echo $this->GuarritasEnergeticas->burton_volver(); ?>
