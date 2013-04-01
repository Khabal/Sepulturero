<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('difuntos'); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($difuntos);
 echo '</pre>';
 */
?>

<?php /* Tabla difuntos */ ?>
<div class="index box">
 <h2><?php echo __('Difuntos'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Persona.nombre_completo', 'Nombre'); ?></th>
    <th><?php echo $this->Paginator->sort('Persona.dni', 'D.N.I.'); ?></th>
    <th><?php echo $this->Paginator->sort('Tumba.localizacion', 'Tumba'); ?></th>
    <th><?php echo $this->Paginator->sort('Difunto.estado', 'Estado del cuerpo'); ?></th>
    <th><?php echo $this->Paginator->sort('Difunto.fecha_defuncion', 'Fecha de defunción'); ?></th>
    <th><?php echo $this->Paginator->sort('Difunto.edad', 'Edad'); ?></th>
    <th><?php echo $this->Paginator->sort('Difunto.causa_fallecimiento', 'Causa de fallecimiento'); ?></th>
    <th><?php echo $this->Paginator->sort('Difunto.certificado_defuncion', 'Certificado de defunción'); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de difuntos */ ?>
  <tbody>
   <?php $i = 0; ?>
   <?php foreach ($difuntos as $difunto): ?>
    <?php $class = null; if ($i++ % 2 == 0) { $class = ' class="altrow"'; } ?>
    <tr<?php echo $class; ?>>
     <td>
      <?php echo $this->Html->link($difunto['Persona']['nombre_completo'], array('controller' => 'difuntos', 'action' => 'ver', $difunto['Difunto']['id'])); ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($difunto['Persona']['dni'])) {
        echo h($difunto['Persona']['dni']);
       }
       else {
        echo h("Desconocido");
       }
      ?>&nbsp;
     </td>
     <td class="enlace">
      <?php
       if (!empty($difunto['Difunto']['tumba_id'])) {
        /* Obtener la localización de tumba */
        $localizacion = "";
        if (!empty($difunto['Tumba']['Columbario']['localizacion'])) {
         $localizacion = $difunto['Tumba']['Columbario']['localizacion'];
        }
        elseif(!empty($difunto['Tumba']['Exterior']['localizacion'])) {
         $localizacion = $difunto['Tumba']['Exterior']['localizacion'];
        }
        elseif(!empty($difunto['Tumba']['Nicho']['localizacion'])) {
         $localizacion = $difunto['Tumba']['Nicho']['localizacion'];
        }
        elseif(!empty($difunto['Tumba']['Panteon']['localizacion'])) {
         $localizacion = $difunto['Tumba']['Panteon']['localizacion'];
        }
        echo $this->Html->link($difunto['Tumba']['tipo'] . " - " . $localizacion, array('controller' => 'tumbas', 'action' => 'ver', $difunto['Difunto']['tumba_id']));
       }
       else {
        echo h("Tumba desconocida");
       }
      ?>&nbsp;
     </td>
     <td><?php echo h($difunto['Difunto']['estado']); ?>&nbsp;</td>
     <td>
      <?php
       if (!empty($difunto['Difunto']['fecha_defuncion'])) {
        echo h(date('d/m/Y', strtotime($difunto['Difunto']['fecha_defuncion'])));
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($difunto['Difunto']['edad'])) {
        echo h($difunto['Difunto']['edad']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td>
      <?php
       if (!empty($difunto['Difunto']['causa_fallecimiento'])) {
        echo h($difunto['Difunto']['causa_fallecimiento']);
       }
       else {
        echo h("Desconocida");
       }
      ?>&nbsp;
     </td>
     <td><?php echo h($difunto['Difunto']['certificado_defuncion']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->GuarritasEnergeticas->guarrita_acciones('difuntos', $difunto['Difunto']['id'], $difunto['Persona']['nombre_completo']); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <?php /* Paginación */ ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_pagilleitor(); ?>
 
</div>
