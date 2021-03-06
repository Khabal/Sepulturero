<?php
 /*
 echo '<pre>';
 print_r($arrendatario);
 echo '</pre>';
 */
?>

<?php /* Datos arrendatario */ ?>
<div class="view box">
 <h2><?php echo __('Datos del arrendatario'); ?></h2>
 <dl>
  <dt><?php echo __('Nombre'); ?>:</dt>
  <dd><?php echo h($arrendatario['Persona']['nombre_completo']); ?>&nbsp;</dd>
  <dt><?php echo __('D.N.I.'); ?>:</dt>
  <dd><?php echo h($arrendatario['Persona']['dni']); ?>&nbsp;</dd>
  <dt><?php echo __('Nacionalidad'); ?>:</dt>
  <dd>
   <?php
    if (!empty($arrendatario['Persona']['nacionalidad'])) {
     echo h($arrendatario['Persona']['nacionalidad']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Dirección'); ?>:</dt>
  <dd><?php echo h($arrendatario['Arrendatario']['direccion']); ?>&nbsp;</dd>
  <dt><?php echo __('Localidad'); ?>:</dt>
  <dd><?php echo h($arrendatario['Arrendatario']['localidad']); ?>&nbsp;</dd>
  <dt><?php echo __('Provincia'); ?>:</dt>
  <dd>
   <?php
    if (!empty($arrendatario['Arrendatario']['provincia'])) {
     echo h($arrendatario['Arrendatario']['provincia']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('País'); ?>:</dt>
  <dd><?php echo h($arrendatario['Arrendatario']['pais']); ?>&nbsp;</dd>
  <dt><?php echo __('Código postal'); ?>:</dt>
  <dd><?php echo h($arrendatario['Arrendatario']['codigo_postal']); ?>&nbsp;</dd>
  <dt><?php echo __('Teléfono'); ?>:</dt>
  <dd>
   <?php
    if (!empty($arrendatario['Arrendatario']['telefono'])) {
     echo h($arrendatario['Arrendatario']['telefono']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Correo electrónico'); ?>:</dt>
  <dd class="email">
   <?php
    if (!empty($arrendatario['Arrendatario']['correo_electronico'])) {
     echo h($arrendatario['Arrendatario']['correo_electronico']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($arrendatario['Persona']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>

<?php /* Funerarias relacionadas */ ?>
<div class="related box">
 <h2><?php echo __('Funerarias contratadas'); ?></h2>
 <?php if (!empty($arrendatario['ArrendatarioFuneraria'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Nombre'); ?></th>
     <th><?php echo __('Dirección'); ?></th>
     <th><?php echo __('Teléfono'); ?></th>
     <th><?php echo __('Fax'); ?></th>
     <th><?php echo __('Correo electrónico'); ?></th>
     <th><?php echo __('Página web'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de funerarias */ ?>
   <tbody>
    <?php $i = 0; ?>
    <?php foreach ($arrendatario['ArrendatarioFuneraria'] as $funeraria): ?>
     <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
     <tr<?php echo $class; ?>>
      <td><?php echo h($funeraria['Funeraria']['nombre']); ?>&nbsp;</td>
      <td><?php echo h($funeraria['Funeraria']['direccion']); ?>&nbsp;</td>
      <td><?php echo h($funeraria['Funeraria']['telefono']); ?>&nbsp;</td>
      <td>
       <?php
        if (!empty($funeraria['Funeraria']['fax'])) {
         echo h($funeraria['Funeraria']['fax']);
        }
        else {
         echo h("Desconocido");
        }
       ?>&nbsp;
      </td>
      <td class="email">
       <?php
        if (!empty($funeraria['Funeraria']['correo_electronico'])) {
         echo h($funeraria['Funeraria']['correo_electronico']);
        }
        else {
         echo h("Desconocido");
        }
       ?>&nbsp;
      </td>
      <td>
       <?php
        if (!empty($funeraria['Funeraria']['pagina_web'])) {
         echo $this->Html->link(__($funeraria['Funeraria']['pagina_web']), $funeraria['Funeraria']['pagina_web'], array('escape' => false, 'target' => '_blank'));
        }
        else {
         echo h("Desconocido");
        }
       ?>&nbsp;
      </td>
      <td class="actions">
       <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'funerarias', 'action' => 'ver', $funeraria['Funeraria']['id']), array('escape' => false)); ?>
      </td>
     </tr>
    <?php endforeach; ?>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>

<?php /* Arrendamientos relacionados */ ?>
<div class="related box">
 <h2><?php echo __('Tumbas arrendadas'); ?></h2>
  <?php if (!empty($arrendatario['Arrendamiento'])): ?>
  <table cellpadding = "0" cellspacing = "0">
   <?php /* Cabecera de la tabla */ ?>
   <thead>
    <tr>
     <th><?php echo __('Fecha de arrendamiento'); ?></th>
     <th><?php echo __('Estado arrendamiento'); ?></th>
     <th><?php echo __('Tipo de tumba'); ?></th>
     <th><?php echo __('Localización'); ?></th>
     <th><?php echo __('Población de la tumba'); ?></th>
     <th class="actions">&nbsp;</th>
    </tr>
   </thead>
   <?php /* Listado de tumbas */ ?>
   <tbody>
    <?php $i = 0; ?>
    <?php foreach ($arrendatario['Arrendamiento'] as $tumba): ?>
     <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
     <tr<?php echo $class; ?>>
      <td><?php echo date('d/m/Y', strtotime($tumba['fecha_arrendamiento'])); ?>&nbsp;</td>
      <td><?php echo h($tumba['estado']); ?>&nbsp;</td>
      <td><?php echo h($tumba['Tumba']['tipo']); ?>&nbsp;</td>
      <td><?php echo h($tumba['Tumba'][$tumba['Tumba']['tipo']]['localizacion']); ?>&nbsp;</td>
      <td><?php echo h($tumba['Tumba']['poblacion']); ?>&nbsp;</td>
      <td class="actions">
       <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;')) . ' Ver'), array('controller' => 'tumbas', 'action' => 'ver', $tumba['Tumba']['id']), array('escape' => false)); ?>
      </td>
     </tr>
    <?php endforeach; ?>
   </tbody>
  </table>
 <?php else: ?>
  <p> No hay información disponible </p>
 <?php endif; ?>
</div>
