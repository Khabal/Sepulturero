<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($this->request->data);
 echo '</pre>';
 */
?>

<script>
 $(document).ready(function(){
   $("#TumbaTipo").change(function(event, ui) {
     event.preventDefault();
     if (seleccionado != $("#TumbaTipo").val()) {
       var seleccionado = $("#TumbaTipo").val();
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
   if (seleccionado != undefined) {
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
</script>

<?php /* Formulario nueva tumba */ ?>
<div class="add form">
 <?php echo $this->Form->create('Tumba'); ?>
  <fieldset>
   <legend><?php echo __('Datos de la tumba'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Tumba.tipo', array('label' => 'Tipo de tumba:', 'type' => 'select', 'options' => $tipo, 'empty' => ''));
   ?>
   <div id="Columbario" <?php //if(!empty($this->request->data['Tumba']['tipo'])) { if($this->request->data['Tumba']['tipo'] == "Columbario") {} } else {echo 'style="display:none;"';} ?>>
    <?php
     /* Campos nuevo columbario */
     echo $this->Form->input('Columbario.numero_columbario', array('label' => 'Número de columbario:'));
     echo $this->Form->input('Columbario.letra', array('label' => 'Letra:'));
     echo $this->Form->input('Columbario.fila', array('label' => 'Fila:'));
     echo $this->Form->input('Columbario.patio', array('label' => 'Patio:'));
    ?>
   </div>
   <div id="Nicho" <?php if($this->request->data) { if($this->request->data['Tumba']['tipo'] != "Nicho") {echo 'style="display:none;"';} } else {echo 'style="display:none;"';} ?>>
    <?php
     /* Campos nuevo nicho */
     echo $this->Form->input('Nicho.numero_nicho', array('label' => 'Número de nicho:'));
     echo $this->Form->input('Nicho.letra', array('label' => 'Letra:'));
     echo $this->Form->input('Nicho.fila', array('label' => 'Fila:'));
     echo $this->Form->input('Nicho.patio', array('label' => 'Patio:'));
    ?>
   </div>
   <div id="Panteon" <?php if($this->request->data) { if($this->request->data['Tumba']['tipo'] != "Panteón") {echo 'style="display:none;"';} } else {echo 'style="display:none;"';} ?>>
    <?php
     /* Campos nuevo panteón */
     echo $this->Form->input('Panteon.numero_panteon', array('label' => 'Número de panteón:'));
     echo $this->Form->input('Panteon.familia', array('label' => 'Familia:'));
     echo $this->Form->input('Panteon.patio', array('label' => 'Patio:'));
    ?>
   </div>
   <?php
    echo $this->Form->input('Tumba.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar'), array('type' => 'submit', 'name' => 'guardar', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar y Nuevo'), array('type' => 'submit', 'name' => 'guardar_y_nuevo', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
