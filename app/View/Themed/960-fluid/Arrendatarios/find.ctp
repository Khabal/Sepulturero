<!-- Lista de accciones -->
<div class="actions box">
 <h2><?php echo __('Lista de accciones'); ?></h2>
 <ul class="nav">
  <li>
   <?php echo $this->Html->link(__('Listado'), array('controller' => 'arrendatarios', 'action' => 'index')); ?>
  </li>
  <li>
   <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'arrendatarios', 'action' => 'add')); ?>
  </li>
  <li>
   <?php echo $this->Html->link(__('Buscar'), array('controller' => 'arrendatarios', 'action' => 'search')); ?>
  </li>
 </ul>
</div>

<?php
echo $this->Form->create('Arrendatario', array(
		'url' => array_merge(array('action' => 'index'), $this->params['pass'])
	));
	echo $this->Form->input('nombre', array('div' => false));
	/*echo $this->Form->input('blog_id', array('div' => false, 'options' => $blogs));
	echo $this->Form->input('status', array('div' => false, 'multiple' => 'checkbox', 'options' => array('open', 'closed')));
	echo $this->Form->input('username', array('div' => false));*/
	echo $this->Form->submit(__('Search'), array('div' => false));
	echo $this->Form->end();
?>

<!-- Tabla arrendatarios -->
<div class="arrendatarios index box">
 <h2><?php echo __('Arrendatarios'); ?></h2>
 <table cellpadding="0" cellspacing="0">
  <?php /* Cabecera de la tabla */ ?>
  <thead>
   <tr>
    <th><?php echo $this->Paginator->sort('Persona.nombre_completo', 'Nombre'); ?></th>
    <th><?php echo $this->Paginator->sort('Persona.dni', 'D.N.I.'); ?></th>
    <th><?php echo $this->Paginator->sort('direccion', 'Dirección'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.localidad', 'Localidad'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.provincia', 'Provincia'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.pais', 'País'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.codigo_postal', 'Código postal'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.telefono', 'Teléfono'); ?></th>
    <th><?php echo $this->Paginator->sort('Arrendatario.correo_electronico', 'Correo electrónico'); ?></th>
    <th class="actions"><?php echo __('Acciones'); ?></th>
   </tr>
  </thead>
  <?php /* Listado de arrendatarios */ ?>
  <tbody>
   <?php foreach ($arrendatarios as $arrendatario): ?>
    <tr>
     <td>
      <?php echo $this->Html->link($arrendatario['Persona']['nombre_completo'], array('controller' => 'arrendatarios', 'action' => 'view', $arrendatario['Arrendatario']['id'])); ?>
     </td>
     <td><?php echo h($arrendatario['Persona']['dni']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['direccion']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['localidad']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['provincia']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['pais']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['codigo_postal']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['telefono']); ?>&nbsp;</td>
     <td><?php echo h($arrendatario['Arrendatario']['correo_electronico']); ?>&nbsp;</td>
     <td class="actions">
      <?php echo $this->Html->link(__('Ver'), array('action' => 'view', $arrendatario['Arrendatario']['id'])); ?>
      <?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $arrendatario['Arrendatario']['id'])); ?>
      <?php echo $this->Form->postLink(__('Borrar'), array('action' => 'delete', $arrendatario['Arrendatario']['id']), null, __('Esto borrará de forma permanente este registro.\n\n ¿Está seguro que desea borrar a %s?', $arrendatario['Persona']['nombre_completo'])); ?>
     </td>
    </tr>
   <?php endforeach; ?>
  </tbody>
 </table>
 
 <!-- Paginación -->
 <p>
  <?php echo $this->Paginator->counter(array('format' => __('Página {:page} de {:pages}. Mostrando {:current} registros de un total de {:count}, empezando en el registro {:start} y terminando en el {:end}.'))); ?>
 </p>
 
 <div class="paging">
  <?php
   echo $this->Paginator->prev('<- ' . __('Anterior '), array(), null, array('class' => 'prev disabled'));
   echo $this->Paginator->numbers(array('separator' => ''));
   echo $this->Paginator->next(__(' Siguiente') . ' ->', array(), null, array('class' => 'next disabled'));
  ?>
 </div>
</div>

