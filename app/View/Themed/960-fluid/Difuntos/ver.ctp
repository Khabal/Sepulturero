<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido(strtolower($this->name), $difunto['Difunto']['id'], $difunto['Persona']['nombre_completo']); ?>
</div>

<?php /* Datos difunto */ ?>
<div class="view box">
 <h2><?php echo __('Datos del difunto'); ?></h2>
 <dl>
  <dt><?php echo __('Nombre'); ?>:</dt>
  <dd><?php echo h($difunto['Persona']['nombre_completo']); ?>&nbsp;</dd>
  <dt><?php echo __('D.N.I.'); ?>:</dt>
  <dd><?php echo h($difunto['Persona']['dni']); ?>&nbsp;</dd>
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
  <dt><?php echo __('Edad de defunción'); ?>:</dt>
  <dd>
   <?php
    if ($difunto['Difunto']['edad_defuncion']) {
     echo h($difunto['Difunto']['edad_defuncion']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Causa de defunción'); ?>:</dt>
  <dd>
   <?php
    if ($difunto['Difunto']['causa_defuncion']) {
     echo h($difunto['Difunto']['causa_defuncion']);
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
  <?php if (!empty($difunto['Tumba'])): ?>
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
     <td><?php echo h($difunto['Tumba']['tipo']); ?>&nbsp;</td>
     <td>
      <?php
       if ($difunto['Tumba']['Columbario']) {
        echo h($difunto['Tumba']['Columbario']['identificador']);
       }
       elseif ($difunto['Tumba']['Nicho']) {
        echo h($difunto['Tumba']['Nicho']['identificador']);
       }
       elseif ($difunto['Tumba']['Panteon']) {
        echo h($difunto['Tumba']['Panteon']['identificador']);
       }
       elseif ($difunto['Tumba']['Exterior']) {
        echo h($difunto['Tumba']['Exterior']['identificador']);
       }
      ?>&nbsp;
     </td>
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

<?php /* Enterramiento relacionado */ ?>
<div class="related box">
 <h2><?php echo __('Datos del enterramiento'); ?></h2>
 <?php if (!empty($difunto['Enterramiento'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Fecha de enterramiento'); ?></th>
     <th><?php echo __('Tumba de enterramiento'); ?></th>
     <th><?php echo __('Número de licencia'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Información del enterramiento */ ?>
   <tbody>
    <tr class="altrow">
     <td><?php echo h(date('d/m/Y', strtotime($difunto['Enterramiento']['fecha']))); ?>&nbsp;</td>
     <td><?php echo h($difunto['Enterramiento']['Tumba']['tipo'] . " - ");
       if ($difunto['Enterramiento']['Tumba']['Columbario']) {
        echo h($difunto['Enterramiento']['Tumba']['Columbario']['identificador']);
       }
       elseif ($difunto['Enterramiento']['Tumba']['Nicho']) {
        echo h($difunto['Enterramiento']['Tumba']['Nicho']['identificador']);
       }
       elseif ($difunto['Enterramiento']['Tumba']['Panteon']) {
        echo h($difunto['Enterramiento']['Tumba']['Panteon']['identificador']);
       }
       elseif ($difunto['Enterramiento']['Tumba']['Exterior']) {
        echo h($difunto['Enterramiento']['Tumba']['Exterior']['identificador']);
       }
      ?>&nbsp;
     </td>
     <td><?php echo h($difunto['Enterramiento']['Licencia']['identificador']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'enterramientos', 'action' => 'ver', $difunto['Enterramiento']['id']), array('escape' => false)); ?>
     </td>
    </tr>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Traslados relacionados */ ?>
<div class="related box">
 <h2><?php echo __('Histórico de traslados');?></h2>
 <?php if (!empty($difunto['DifuntoTraslado'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Fecha de traslado'); ?></th>
     <th><?php echo __('Cementerio de origen'); ?></th>
     <th><?php echo __('Tumba de origen'); ?></th>
     <th><?php echo __('Cementerio de destino'); ?></th>
     <th><?php echo __('Tumba de destino'); ?></th>
     <th><?php echo __('Motivo'); ?></th>
     <th class="actions">&nbsp;</th>
   </tr>
  </thead>
  <?php /* Listado de traslados */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($difunto['DifuntoTraslado'] as $traslado): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td><?php echo date('d/m/Y', strtotime($traslado['Traslado']['fecha'])); ?>&nbsp;</td>
     <td><?php echo h($traslado['Traslado']['cementerio_origen']); ?>&nbsp;</td>
     <td>
      <?php foreach ($traslado['Traslado']['TrasladoTumba'] as $tumba): ?>
       <?php if ($tumba['origen_destino'] == "Origen"): ?>
        <?php
         echo h($tumba['Tumba']['tipo']) . " - ";
         if ($tumba['Tumba']['Columbario']) {
          echo h($tumba['Tumba']['Columbario']['identificador']);
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
          echo h($tumba['Tumba']['Columbario']['identificador']);
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
