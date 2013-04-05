<?php /* Formulario generación de tumbas */ ?>
<div class="special form">
 <?php echo $this->Form->create('Tumba'); ?>
  <fieldset>
   <legend><?php echo __('Datos para la generación de tumbas'); ?></legend>
   <?php
    echo $this->Form->input('Tumba.t_tumba', array('label' => 'Tipo de tumba:', 'type' => 'select', 'options' => $tipo, 'empty' => ''));
    echo $this->Form->input('Tumba.n_tumbas', array('label' => 'Número total de tumbas:'));
    echo $this->Form->input('Tumba.letra', array('label' => 'Letra asociada:'));
    echo $this->Form->input('Tumba.n_filas', array('label' => 'Número de filas:'));
    echo $this->Form->input('Tumba.n_patio', array('label' => 'Número de patio:'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Generar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
