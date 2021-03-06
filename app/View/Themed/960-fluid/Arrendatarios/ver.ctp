<?php /* Menú de accciones */ ?>
<div class="actions box">
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('arrendatarios', $arrendatario['Arrendatario']['id'], $arrendatario['Persona']['nombre_completo']); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($arrendatario);
 echo '</pre>';
 */
?>

<?php echo $this->GuarritasEnergeticas->burton_volver(); ?>

<?php /* Datos arrendatario */ ?>
<div class="view box">
 <h2><?php echo __('Datos del arrendatario'); ?></h2>
 <dl>
  <dt><?php echo __('Nombre'); ?>:</dt>
  <dd><?php echo h($arrendatario['Persona']['nombre_completo']); ?>&nbsp;</dd>
  <dt><?php echo __('D.N.I.'); ?>:</dt>
  <dd>
   <?php
    if (!empty($arrendatario['Persona']['dni'])) {
     echo h($arrendatario['Persona']['dni']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
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
  <dd>
   <?php
    if (!empty($arrendatario['Arrendatario']['direccion'])) {
     echo h($arrendatario['Arrendatario']['direccion']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Localidad'); ?>:</dt>
  <dd>
   <?php
    if (!empty($arrendatario['Arrendatario']['localidad'])) {
     echo h($arrendatario['Arrendatario']['localidad']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
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
  <dd>
   <?php
    if (!empty($arrendatario['Arrendatario']['pais'])) {
     echo h($arrendatario['Arrendatario']['pais']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Código postal'); ?>:</dt>
  <dd>
   <?php
    if (!empty($arrendatario['Arrendatario']['codigo_postal'])) {
     echo h($arrendatario['Arrendatario']['codigo_postal']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Teléfono fijo'); ?>:</dt>
  <dd>
   <?php
    if (!empty($arrendatario['Arrendatario']['telefono_fijo'])) {
     echo h($arrendatario['Arrendatario']['telefono_fijo']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Teléfono móvil'); ?>:</dt>
  <dd>
   <?php
    if (!empty($arrendatario['Arrendatario']['telefono_movil'])) {
     echo h($arrendatario['Arrendatario']['telefono_movil']);
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
     <th><?php echo __('Teléfono fijo'); ?></th>
     <th><?php echo __('Teléfono móvil'); ?></th>
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
      <td>
       <?php
        if (!empty($funeraria['Funeraria']['telefono_fijo'])) {
         echo h($funeraria['Funeraria']['telefono_fijo']);
        }
        else {
         echo h("Desconocido");
        }
       ?>&nbsp;
      </td>
      <td>
       <?php
        if (!empty($funeraria['Funeraria']['telefono_movil'])) {
         echo h($funeraria['Funeraria']['telefono_movil']);
        }
        else {
         echo h("Desconocido");
        }
       ?>&nbsp;
      </td>
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
       <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'funerarias', 'action' => 'ver', $funeraria['Funeraria']['id']), array('escape' => false, 'title' => 'Ver')); ?>
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
      <?php
       $colorico = null;
       if ($tumba['estado'] == "Caducado") {
        $colorico = ' style="color:#FF0000;font-weight:bold;"';
       }
       elseif($tumba['estado'] == "Vigente") {
        $colorico = ' style="color:#04B404;font-weight:bold;"';
       }
      ?>
      <td<?php echo $colorico; ?>><?php echo h($tumba['estado']); ?>&nbsp;</td>
      <td><?php echo h($tumba['Tumba']['tipo']); ?>&nbsp;</td>
      <?php /* Obtener la localización de tumba */
       $localizacion = "";
       if (!empty($tumba['Tumba']['Columbario']['localizacion'])) {
        $localizacion = $tumba['Tumba']['Columbario']['localizacion'];
       }
       elseif(!empty($tumba['Tumba']['Exterior']['localizacion'])) {
        $localizacion = $tumba['Tumba']['Exterior']['localizacion'];
       }
       elseif(!empty($tumba['Tumba']['Nicho']['localizacion'])) {
        $localizacion = $tumba['Tumba']['Nicho']['localizacion'];
       }
       elseif(!empty($tumba['Tumba']['Panteon']['localizacion'])) {
        $localizacion = $tumba['Tumba']['Panteon']['localizacion'];
       }
      ?>
      <td><?php echo h($localizacion); ?>&nbsp;</td>
      <td><?php echo h($tumba['Tumba']['poblacion']); ?>&nbsp;</td>
      <td class="actions">
       <?php echo $this->Html->link(__($this->Html->image('ver.png', array('alt' => 'ver', 'style' => 'height:16px; width:16px;'))), array('controller' => 'tumbas', 'action' => 'ver', $tumba['Tumba']['id']), array('escape' => false, 'title' => 'Ver')); ?>
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
