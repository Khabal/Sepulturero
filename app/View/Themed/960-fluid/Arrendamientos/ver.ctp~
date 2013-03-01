<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido(strtolower($this->name), $arrendamiento['Arrendamiento']['id'], $arrendamiento['Tumba']['tipo'] . " - " . $arrendamiento['Tumba'][$arrendamiento['Tumba']['tipo']]['localizacion'] . " por " . $arrendamiento['Concesion']['anos_concesion'] . "años."); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($arrendamiento);
 echo '</pre>';
 */
?>

<?php /* Datos arrendamiento y concesión */ ?>
<div class="view box">
 <h2><?php echo __('Datos de la concesión'); ?></h2>
 <dl>
  <dt><?php echo __('Tipo de concesión'); ?>:</dt>
  <dd><?php echo h($arrendamiento['Concesion']['tipo']); ?>&nbsp;</dd>
  <dt><?php echo __('Años de concesión'); ?>:</dt>
  <dd><?php echo h($arrendamiento['Concesion']['anos_concesion']); ?>&nbsp;</dd>
  <dt><?php echo __('Fecha de arrendamiento'); ?>:</dt>
  <dd><?php echo h(date('d/m/Y', strtotime($arrendamiento['Arrendamiento']['fecha_arrendamiento']))); ?>&nbsp;</dd>
  <dt><?php echo __('Estado de la concesión'); ?>:</dt>
  <?php
   $colorico = null;
   if ($arrendamiento['Arrendamiento']['estado'] == "Caducado") {
    $colorico = ' style="color:#FF0000;font-weight:bold;"';
   }
   elseif($arrendamiento['Arrendamiento']['estado'] == "Vigente") {
    $colorico = ' style="color:#04B404;font-weight:bold;"';
   }
  ?>
  <dd<?php echo $colorico; ?>><?php echo h($arrendamiento['Arrendamiento']['estado']); ?>&nbsp;</dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($arrendamiento['Arrendamiento']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>


<?php /* Datos arrendatario */ ?>
<div class="related box">
 <h2><?php echo __('Datos del arrendatario'); ?></h2>
 <dl>
  <dt><?php echo __('Nombre'); ?>:</dt>
  <dd><?php echo h($arrendamiento['Arrendatario']['Persona']['nombre_completo']); ?>&nbsp;</dd>
  <dt><?php echo __('D.N.I.'); ?>:</dt>
  <dd><?php echo h($arrendamiento['Arrendatario']['Persona']['dni']); ?>&nbsp;</dd>
  <dt><?php echo __('Dirección'); ?>:</dt>
  <dd><?php echo h($arrendamiento['Arrendatario']['direccion']); ?>&nbsp;</dd>
  <dt><?php echo __('Localidad'); ?>:</dt>
  <dd><?php echo h($arrendamiento['Arrendatario']['localidad']); ?>&nbsp;</dd>
  <dt><?php echo __('Provincia'); ?>:</dt>
  <dd>
   <?php
    if ($arrendamiento['Arrendatario']['provincia']) {
     echo h($arrendamiento['Arrendatario']['provincia']);
    }
    else {
     echo h("Desconocida");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('País'); ?>:</dt>
  <dd><?php echo h($arrendamiento['Arrendatario']['pais']); ?>&nbsp;</dd>
  <dt><?php echo __('Código postal'); ?>:</dt>
  <dd><?php echo h($arrendamiento['Arrendatario']['codigo_postal']); ?>&nbsp;</dd>
  <dt><?php echo __('Teléfono'); ?>:</dt>
  <dd>
   <?php
    if ($arrendamiento['Arrendatario']['telefono']) {
     echo h($arrendamiento['Arrendatario']['telefono']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Correo electrónico'); ?>:</dt>
  <dd class="email">
   <?php
    if ($arrendamiento['Arrendatario']['correo_electronico']) {
     echo h($arrendamiento['Arrendatario']['correo_electronico']);
    }
    else {
     echo h("Desconocido");
    }
   ?>&nbsp;
  </dd>
  <dt><?php echo __('Anotaciones'); ?>:</dt>
  <dd><?php echo h($arrendamiento['Arrendatario']['Persona']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>

<?php /* Datos tumba */ ?>
<div class="related box">
 <h2><?php echo __('Datos de la tumba'); ?></h2>
 <dl>
  <dt><?php echo __('Tipo de tumba:'); ?></dt>
  <dd><?php echo h($arrendamiento['Tumba']['tipo']); ?>&nbsp;</dd>
  <dt><?php echo __('Localización:'); ?></dt>
  <dd><?php echo h($arrendamiento['Tumba'][$arrendamiento['Tumba']['tipo']]['localizacion']); ?>&nbsp;</dd>
  <dt><?php echo __('Población:'); ?></dt>
  <dd><?php echo h($arrendamiento['Tumba']['poblacion']); ?>&nbsp;</dd>
  <dt><?php echo __('Anotaciones:'); ?></dt>
  <dd><?php echo h($arrendamiento['Tumba']['observaciones']); ?>&nbsp;</dd>
 </dl>
</div>
