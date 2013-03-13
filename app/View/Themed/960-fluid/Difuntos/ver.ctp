<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido(strtolower($this->name), $difunto['Difunto']['id'], $difunto['Persona']['nombre_completo']); ?>
</div>

<?php
 
 echo '<pre>';
 print_r($difunto);
 echo '</pre>';
 
?>

<?php /* Datos difunto */ ?>
<div class="view box">
 <h2><?php echo __('Datos del difunto'); ?></h2>
 <dl>
  <dt><?php echo __('Nombre'); ?>:</dt>
  <dd><?php echo h($difunto['Persona']['nombre_completo']); ?>&nbsp;</dd>
  <dt><?php echo __('D.N.I.'); ?>:</dt>
  <dd><?php echo h($difunto['Persona']['dni']); ?>&nbsp;</dd>
  <dt><?php echo __('Nacionalidad'); ?>:</dt>
  <dd>
   <?php
    if ($difunto['Persona']['nacionalidad']) {
     echo h($difunto['Persona']['nacionalidad']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Sexo'); ?>:</dt>
  <dd><?php echo h($difunto['Persona']['sexo']); ?>&nbsp;</dd>
  <dt><?php echo __('Estado'); ?>:</dt>
  <dd><?php echo h($difunto['Difunto']['estado']); ?>&nbsp;</dd>
  <dt><?php echo __('Fecha de defunción'); ?>:</dt>
  <dd>
   <?php
    if ($difunto['Difunto']['fecha_defuncion']) {
     echo h($difunto['Difunto']['fecha_defuncion']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Edad'); ?>:</dt>
  <dd>
   <?php
    if ($difunto['Difunto']['edad']) {
     echo h($difunto['Difunto']['edad']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Causa de defunción'); ?>:</dt>
  <dd>
   <?php
    if ($difunto['Difunto']['causa_fallecimiento']) {
     echo h($difunto['Difunto']['causa_fallecimiento']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($difunto['Persona']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>

<?php /* Tumba relacionada */ ?>
<div class="related box">
 <h2><?php echo __('Tumba actual'); ?></h2>
  <?php if (!empty($difunto['Difunto']['tumba_id'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Tipo de tumba'); ?></th>
     <th><?php echo __('Localización'); ?></th>
     <th><?php echo __('Población'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información de la tumba */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h($difunto['Tumba']['tipo']); ?>&nbsp;</td>
     <?php /* Obtener la localización de tumba */
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
     ?>
     <td><?php echo h($localizacion); ?>&nbsp;</td>
     <td><?php echo h($difunto['Tumba']['poblacion']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'tumbas', 'action' => 'ver', $difunto['Difunto']['tumba_id']), array('escape' => false)); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Movimientos relacionados */ ?>
<div class="related box">
 <h2><?php echo __('Histórico de movimientos');?></h2>
 <?php if (!empty($difunto['DifuntoMovimiento'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Fecha'); ?></th>
     <th><?php echo __('Tipo'); ?></th>
     <th><?php echo __('Cementerio de origen'); ?></th>
     <th><?php echo __('Tumba de origen'); ?></th>
     <th><?php echo __('Cementerio de destino'); ?></th>
     <th><?php echo __('Tumba de destino'); ?></th>
     <th><?php echo __('Motivo'); ?></th>
     <th class="actions">&nbsp;</th>
   </tr>
  </thead>
  <?php /* Listado de movimientos */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($difunto['DifuntoMovimiento'] as $movimiento): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td><?php echo date('d/m/Y', strtotime($movimiento['Movimiento']['fecha'])); ?>&nbsp;</td>
     <td><?php echo h($movimiento['Movimiento']['tipo']); ?>&nbsp;</td>
     <td><?php echo h($movimiento['Traslado']['cementerio_origen']); ?>&nbsp;</td>
     <td>
      <?php foreach ($traslado['Traslado']['TrasladoTumba'] as $tumba): ?>
       <?php if ($tumba['origen_destino'] == "Origen"): ?>
        <?php
         echo h($tumba['Tumba']['tipo']) . " - ";
         if ($tumba['Tumba']['Columbario']) {
          echo h($tumba['Tumba']['Columbario']['localizacion']);
         }
         elseif ($tumba['Tumba']['Nicho']) {
          echo h($tumba['Tumba']['Nicho']['identificador']);
         }
         elseif ($tumba['Tumba']['Panteon']) {
          echo h($tumba['Tumba']['Panteon']['identificador']);
         }
         elseif ($tumba['Tumba']['Exterior']) {
          echo h($tumba['Tumba']['Exterior']['identificador']);
         }
        ?>
       <?php endif; ?>
      <?php endforeach; ?>
     </td>
     <td><?php echo h($traslado['Traslado']['cementerio_destino']); ?>&nbsp;</td>
     <td>
      <?php foreach ($traslado['Traslado']['TrasladoTumba'] as $tumba): ?>
       <?php if ($tumba['origen_destino'] == "Destino"): ?>
        <?php
         echo h($tumba['Tumba']['tipo']) . " - ";
         if ($tumba['Tumba']['Columbario']) {
          echo h($tumba['Tumba']['Columbario']['localizacion']);
         }
         elseif ($tumba['Tumba']['Nicho']) {
          echo h($tumba['Tumba']['Nicho']['identificador']);
         }
         elseif ($tumba['Tumba']['Panteon']) {
          echo h($tumba['Tumba']['Panteon']['identificador']);
         }
         elseif ($tumba['Tumba']['Exterior']) {
          echo h($tumba['Tumba']['Exterior']['identificador']);
         }
        ?>
       <?php endif; ?>
      <?php endforeach; ?>
     </td>
     <td><?php echo h($traslado['Traslado']['motivo']); ?>&nbsp;</td>
      <td class="actions">
       <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'traslados', 'action' => 'ver', $traslado['traslado_id']), array('escape' => false)); ?>
      </td>
     </tr>
    <?php endforeach; ?>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>
