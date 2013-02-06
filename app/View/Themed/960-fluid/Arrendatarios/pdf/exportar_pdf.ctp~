<!-- Datos arrendatario -->
<div class="arrendatarios view box">
 <h2><?php  echo __('Arrendatario'); ?></h2>
 <dl>
  <dt><?php echo __('Nombre'); ?>:</dt>
  <dd>
   <?php echo h($arrendatario['Persona']['nombre_completo']); ?>&nbsp;
  </dd>
  <dt><?php echo __('D.N.I.'); ?>:</dt>
  <dd>
   <?php echo h($arrendatario['Persona']['dni']); ?>&nbsp;
  </dd>
  <dt><?php echo __('Dirección'); ?>:</dt>
  <dd>
   <?php echo h($arrendatario['Arrendatario']['direccion']); ?>&nbsp;
  </dd>
  <dt><?php echo __('Localidad'); ?>:</dt>
  <dd>
   <?php echo h($arrendatario['Arrendatario']['localidad']); ?>&nbsp;
  </dd>
  <dt><?php echo __('Provincia'); ?>:</dt>
  <dd>
   <?php echo h($arrendatario['Arrendatario']['provincia']); ?>&nbsp;
  </dd>
  <dt><?php echo __('País'); ?>:</dt>
  <dd>
   <?php echo h($arrendatario['Arrendatario']['pais']); ?>&nbsp;
  </dd>
  <dt><?php echo __('Código postal'); ?>:</dt>
  <dd>
   <?php echo h($arrendatario['Arrendatario']['codigo_postal']); ?>&nbsp;
  </dd>
  <dt><?php echo __('Teléfono'); ?>:</dt>
  <dd>
   <?php echo h($arrendatario['Arrendatario']['telefono']); ?>&nbsp;
  </dd>
  <dt><?php echo __('Correo electrónico'); ?>:</dt>
  <dd>
   <?php echo h($arrendatario['Arrendatario']['correo_electronico']); ?>&nbsp;
  </dd>
 </dl>
</div>

<!-- Funerarias relacionadas -->
<div class="related box">
 <h2><?php echo __('Funerarias contratadas'); ?></h2>
	<?php if (!empty($arrendatario['Funeraria'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Direccion'); ?></th>
		<th><?php echo __('Telefono'); ?></th>
		<th><?php echo __('Web'); ?></th>
		<th><?php echo __('Correo Electronico'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($arrendatario['Funeraria'] as $funeraria): ?>
		<tr>
			<td><?php echo $funeraria['id']; ?></td>
			<td><?php echo $funeraria['nombre']; ?></td>
			<td><?php echo $funeraria['direccion']; ?></td>
			<td><?php echo $funeraria['telefono']; ?></td>
			<td><?php echo $funeraria['web']; ?></td>
			<td><?php echo $funeraria['correo_electronico']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'funerarias', 'action' => 'view', $funeraria['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'funerarias', 'action' => 'edit', $funeraria['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'funerarias', 'action' => 'delete', $funeraria['id']), null, __('Are you sure you want to delete # %s?', $funeraria['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Funeraria'), array('controller' => 'funerarias', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

<!-- Tumbas relacionadas -->
<div class="related box">
 <h2><?php echo __('Tumbas arrendadas'); ?></h2>
	<?php if (!empty($arrendatario['Tumba'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Patio'); ?></th>
		<th><?php echo __('Poblacion'); ?></th>
		<th><?php echo __('Observaciones'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($arrendatario['Tumba'] as $tumba): ?>
		<tr>
			<td><?php echo $tumba['id']; ?></td>
			<td><?php echo $tumba['patio']; ?></td>
			<td><?php echo $tumba['poblacion']; ?></td>
			<td><?php echo $tumba['observaciones']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'tumbas', 'action' => 'view', $tumba['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'tumbas', 'action' => 'edit', $tumba['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'tumbas', 'action' => 'delete', $tumba['id']), null, __('Are you sure you want to delete # %s?', $tumba['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Tumba'), array('controller' => 'tumbas', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
