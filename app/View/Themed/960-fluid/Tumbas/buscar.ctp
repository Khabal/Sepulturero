<?php /* Menú de accciones */ ?>
<div class="actions box">
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
 <?php echo $this->Form->create('Tumba', array('url' => array('controller' => 'tumbas', 'action' => 'index'), 'type' => 'get')); ?>
 <fieldset>
 <legend><?php echo __('Información sobre la tumba'); ?></legend>
  <?php /* Campos */
   echo $this->Form->input('tipo', array('label' => 'Tipo de tumba:', 'type' => 'select', 'options' => $tipo, 'empty' => ''));
  ?>
  <div id="Columbario" style="display:none;">
   <?php
    /* Campos nuevo columbario */
    echo $this->Form->input('numero_columbario', array('label' => 'Número de columbario:'));
    echo $this->Form->input('letra_columbario', array('label' => 'Letra:'));
    echo $this->Form->input('fila_columbario', array('label' => 'Fila:'));
    echo $this->Form->input('patio_columbario', array('label' => 'Patio:'));
   ?>
  </div>
  <div id="Nicho" style="display:none;">
   <?php
    /* Campos nuevo nicho */
    echo $this->Form->input('numero_nicho', array('label' => 'Número de nicho:'));
    echo $this->Form->input('letra_nicho', array('label' => 'Letra:'));
    echo $this->Form->input('fila_nicho', array('label' => 'Fila:'));
    echo $this->Form->input('patio_nicho', array('label' => 'Patio:'));
   ?>
  </div>
  <div id="Panteon" style="display:none;">
   <?php
    /* Campos nuevo panteón */
    echo $this->Form->input('numero_panteon', array('label' => 'Número de panteón:'));
    echo $this->Form->input('familia_panteon', array('label' => 'Familia:'));
    echo $this->Form->input('patio_panteon', array('label' => 'Patio:'));
   ?>
  </div>
 </fieldset>
 
 <?php /* Botones */
  echo $this->GuarritasEnergeticas->burtones_buscar();
  echo $this->Form->end();
 ?>
 
</div>
