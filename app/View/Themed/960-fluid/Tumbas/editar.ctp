<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('tumbas', $this->Session->read('Tumba.id'), $this->Session->read('Tumba.identificador')); ?>
</div>

<script>
 $(document).ready(function(){
   $("#TumbaTipo").change( function(event, ui) {
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
     else {
       
     }
   });
 });
</script>

<?php /* Formulario editar tumba */ ?>
<div class="edit form">
 <?php echo $this->Form->create('Tumba', array('type' => 'post')); ?>
  <fieldset>
   <legend><?php echo __('Datos de la tumba'); ?></legend>
   <div class="input text required">
    <label for="TumbaTipo">Tipo de tumba:</label>
    <?php echo $this->Form->select('Tumba.tipo', $tipo); ?>
   </div>
   <div id="Columbario" <?php if($this->request->data) { if($this->request->data['Tumba']['tipo'] != "Columbario") {echo 'style="display:none;"';} } else {echo 'style="display:none;"';} ?>>
    <?php
     /* Campos nuevo columbario */
     echo $this->Form->input('Columbario.numero_columbario', array('label' => 'Número de columbario:'));
     echo $this->Form->input('Columbario.fila', array('label' => 'Fila:'));
     echo $this->Form->input('Columbario.patio', array('label' => 'Patio:'));
    ?>
   </div>
   <div id="Nicho" <?php if($this->request->data) { if($this->request->data['Tumba']['tipo'] != "Nicho") {echo 'style="display:none;"';} } else {echo 'style="display:none;"';} ?>>
    <?php
     /* Campos nuevo nicho */
     echo $this->Form->input('Nicho.numero_nicho', array('label' => 'Número de nicho:'));
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
  echo $this->Form->button(__('Modificar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Descartar cambios'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
