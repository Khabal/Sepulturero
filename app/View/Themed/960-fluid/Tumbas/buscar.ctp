<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('tumbas'); ?>
</div>

<script>
 $(document).ready(function(){
   var seleccionado = $("#TumbaTipo").val();
   
   /* Mostrar campos del formulario adecuados a cada tipo de tumba */
   $("#TumbaTipo").change(function(event, ui) {
     event.preventDefault();
     if (seleccionado != $("#TumbaTipo").val()) {
       seleccionado = $("#TumbaTipo").val();
       if (seleccionado == "Columbario") {
         $("#Columbario").show(),
         $("#Nicho").hide(),
         $("#Panteon").hide()
       }
       else if (seleccionado == "Nicho") {
         $("#Columbario").hide(),
         $("#Nicho").show(),
         $("#Panteon").hide()
       }
       else if (seleccionado == "Panteón") {
         $("#Columbario").hide(),
         $("#Nicho").hide(),
         $("#Panteon").show()
       }
       else {
         $("#Columbario").hide(),
         $("#Nicho").hide(),
         $("#Panteon").hide()
       }
     }
   });
   
   /* Mostrar campos adecuados si se recarga */
   if (seleccionado == "Columbario") {
     $("#Columbario").show(),
     $("#Nicho").hide(),
     $("#Panteon").hide()
   }
   else if (seleccionado == "Nicho") {
     $("#Columbario").hide(),
     $("#Nicho").show(),
     $("#Panteon").hide()
   }
   else if (seleccionado == "Panteón") {
     $("#Columbario").hide(),
     $("#Nicho").hide(),
     $("#Panteon").show()
   }
   else {
     $("#Columbario").hide(),
     $("#Nicho").hide(),
     $("#Panteon").hide()
   }
   
 });
</script>

<?php /* Formulario buscar tumbas */ ?>
<div class="find form">
 <?php echo $this->Form->create('Tumba', array(
    'url' => array('controller' => strtolower($this->name), 'action' => 'index'),
    'type' => 'get'
  ));
 ?>
  <fieldset>
  <legend><?php echo __('Información sobre la tumba'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('tipo', array('label' => 'Tipo de tumba:', 'type' => 'select', 'options' => $tipo, 'empty' => ''));
   ?>
   <div id="Columbario" style="display:none;">
    <?php
     /* Campos nuevo columbario */
     echo $this->Form->input('Columbario.numero_columbario', array('label' => 'Número de columbario:', 'required' => false));
     echo $this->Form->input('Columbario.letra', array('label' => 'Letra:', 'required' => false));
     echo $this->Form->input('Columbario.fila', array('label' => 'Fila:', 'required' => false));
     echo $this->Form->input('Columbario.patio', array('label' => 'Patio:', 'required' => false));
    ?>
   </div>
   <div id="Nicho" style="display:none;">
    <?php
     /* Campos nuevo nicho */
     echo $this->Form->input('Nicho.numero_nicho', array('label' => 'Número de nicho:', 'required' => false));
     echo $this->Form->input('Nicho.letra', array('label' => 'Letra:', 'required' => false));
     echo $this->Form->input('Nicho.fila', array('label' => 'Fila:', 'required' => false));
     echo $this->Form->input('Nicho.patio', array('label' => 'Patio:', 'required' => false));
    ?>
   </div>
   <div id="Panteon" style="display:none;">
    <?php
     /* Campos nuevo panteón */
     echo $this->Form->input('Panteon.numero_panteon', array('label' => 'Número de panteón:', 'required' => false));
     echo $this->Form->input('Panteon.familia', array('label' => 'Familia:', 'required' => false));
     echo $this->Form->input('Panteon.patio', array('label' => 'Patio:', 'required' => false));
    ?>
   </div>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Buscar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
