<div class="difuntos index">
<h2><?php __('Difuntos');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>

<?php
	echo $this->Form->create('Difunto', array(
		'url' => array_merge(array('action' => 'find'), $this->params['pass'])
		));
	//echo $this->Form->input('title', array('div' => false));
	echo $this->Form->submit(__('Search', true), array('div' => false));
	echo $this->Form->end();
?>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort('persona_id');?></th>
	<th><?php echo $this->Paginator->sort('tumba_id');?></th>
	<th><?php echo $this->Paginator->sort('estado');?></th>
	<th><?php echo $this->Paginator->sort('fecha_defuncion');?></th>
	<th><?php echo $this->Paginator->sort('edad_defuncion');?></th>
	<th><?php echo $this->Paginator->sort('causa_defuncion');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($difuntos as $difunto):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $difunto['Difunto']['id']; ?>
		</td>
		<td>
			<?php echo $this->Html->link($difunto['Persona']['id'], array('controller' => 'personas', 'action' => 'view', $difunto['Persona']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($difunto['Tumba']['id'], array('controller' => 'tumbas', 'action' => 'view', $difunto['Tumba']['id'])); ?>
		</td>
		<td>
			<?php echo $difunto['Difunto']['estado']; ?>
		</td>
		<td>
			<?php echo $difunto['Difunto']['fecha_defuncion']; ?>
		</td>
		<td>
			<?php echo $difunto['Difunto']['edad_defuncion']; ?>
		</td>
		<td>
			<?php echo $difunto['Difunto']['causa_defuncion']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $difunto['Difunto']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $difunto['Difunto']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $difunto['Difunto']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<?php echo $this->element('paging', array('plugin' => 'Templates')); ?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New Difunto', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Personas', true), array('controller' => 'personas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Persona', true), array('controller' => 'personas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tumbas', true), array('controller' => 'tumbas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tumba', true), array('controller' => 'tumbas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Enterramientos', true), array('controller' => 'enterramientos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Enterramiento', true), array('controller' => 'enterramientos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Traslados', true), array('controller' => 'traslados', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Traslado', true), array('controller' => 'traslados', 'action' => 'add')); ?> </li>
	</ul>
</div>
