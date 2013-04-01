<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<?php
 /*
 echo '<pre>';
 print_r($this->request->data);
 print_r($this->validationErrors);
 echo '</pre>';
 */
?>

<?php
 /* Cambiar el número iniFormsCount de sheepIt si hay datos para que los muestre */
 if (isset($this->request->data['ArrendatarioFuneraria'])) {
  $ini_f = sizeof($this->request->data['ArrendatarioFuneraria']);
  $data_f = array();
  foreach($this->request->data['ArrendatarioFuneraria'] as $funeraria) {
   array_push($data_f, array("ArrendatarioFuneraria#index#FunerariaBonita" => $funeraria['funeraria_bonita'], "ArrendatarioFuneraria#index#FunerariaId" => $funeraria['funeraria_id']));
  }
  $data_f = json_encode($data_f);
 }
 else {
  $ini_f = 0;
  $data_f = "[]";
 }
 
 /* Cargar mensajes de error para los campos generados con sheepIt */
 if (isset($this->validationErrors['ArrendatarioFuneraria'])) {
  $tam = count($this->validationErrors['ArrendatarioFuneraria']);
  $mensajes_error = array();
  for ($i = 0; $tam > 0; $i++) {
   if (isset($this->validationErrors['ArrendatarioFuneraria'][$i])) {
    array_push($mensajes_error, array($i + 1 => $this->validationErrors['ArrendatarioFuneraria'][$i]['funeraria_bonita'][0]));
    $tam--;
   }
   else {
    array_push($mensajes_error, array($i + 1 => ""));
   }
  }
  $mensajes_error = json_encode($mensajes_error);
 }
 else {
  $mensajes_error = "[]";
 }
?>

<script>
 var errores = <?php echo $mensajes_error; ?>;
 var num = 0;
 
 $(function() {
   /* Formulario sheepIt para agregar funerarias */
   $("#SubFormularioFuneraria").sheepIt({
     separator: '',
     allowRemoveLast: true,
     allowRemoveCurrent: true,
     allowRemoveAll: true,
     allowAdd: true,
     allowAddN: false,
     maxFormsCount: 100,
     minFormsCount: 0,
     continuousIndex: false,
     iniFormsCount: <?php echo h($ini_f); ?>,
     removeAllConfirmationMsg: '¿Eliminar todas las funerarias asociadas?',
     data: <?php echo $data_f; ?>,
     afterAdd: function(source, newForm) {
       /* Obtener identificadores de campos */
       var auto = "#" + $(newForm).children("div").children("input[id$='FunerariaBonita']").attr("id");
       var auto_oc = auto.replace("Bonita", "Id");
       
       /* Establecer opciones de 'UI Autocomplete' para jQuery */
       $(auto).autocomplete({
         source: function(request, response) {
           $.ajax({
             url: "<?php echo $this->Html->url(array('controller' => 'funerarias', 'action' => 'autocomplete')); ?>",
             dataType: "json",
             type: "GET",
             data: {
               term: request.term
             },
             timeout: 2000,
             success: function(data) {
               response($.map(data, function(x) {
                 return {
                   label: x.label,
                   value: x.value
                 }
               }));
             }
           });
         },
         minLength: 2,
         select: function(event, ui) {
           event.preventDefault(),
           $(auto).val(ui.item.label),
           $(auto_oc).val(ui.item.value)
         },
         open: function() {
           $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
         },
         close: function() {
           $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
         }
       });
       
       /* Mostrar mensajes de errores si los hubiera */
       if(errores[num] != undefined) {
         if(errores[num][num + 1] != "") {
           $(newForm).append('<div class="error-message">' + errores[num][num + 1] + '</div>');
       }
         num++;
       }
       
     }
   });
 });
</script>

<?php /* Formulario nuevo arrendatario */ ?>
<div class="add form">
 <?php echo $this->Form->create('Arrendatario'); ?>
  <fieldset>
   <legend><?php echo __('Datos del arrendatario'); ?></legend>
   <?php
    echo $this->Form->input('Persona.nombre', array('label' => 'Nombre:'));
    echo $this->Form->input('Persona.apellido1', array('label' => 'Primer apellido:'));
    echo $this->Form->input('Persona.apellido2', array('label' => 'Segundo apellido:'));
    echo $this->Form->input('Persona.dni', array('label' => 'D.N.I.:'));
    echo $this->Form->input('Persona.nacionalidad', array('label' => 'Nacionalidad:'));
    echo $this->Form->input('Arrendatario.direccion', array('label' => 'Dirección:'));
    echo $this->Form->input('Arrendatario.localidad', array('label' => 'Localidad:', 'default' => 'Motril'));
    echo $this->Form->input('Arrendatario.provincia', array('label' => 'Provincia:', 'default' => 'Granada'));
    echo $this->Form->input('Arrendatario.pais', array('label' => 'País:', 'default' => 'España'));
    echo $this->Form->input('Arrendatario.codigo_postal', array('label' => 'Código postal:', 'default' => '18600'));
    echo $this->Form->input('Arrendatario.telefono', array('label' => 'Teléfono:'));
    echo $this->Form->input('Arrendatario.correo_electronico', array('label' => 'Correo electrónico:'));
    echo $this->Form->input('Persona.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Funerarias contratadas'); ?></legend>
   <div id="SubFormularioFuneraria">
    <div id="SubFormularioFuneraria_template">
     <?php /* Campos */
      echo $this->Form->input('ArrendatarioFuneraria.#index#.funeraria_bonita', array('label' => 'Funeraria:')); //Campo imaginario
      echo $this->Form->input('ArrendatarioFuneraria.#index#.funeraria_id', array('type' => 'hidden'));
     ?>
     <a id="SubFormularioFuneraria_remove_current" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'class' => 'delete', 'style' => 'height:16px; width:16px;')); ?> </a>
    </div>
    <div id="SubFormularioFuneraria_noforms_template">No hay funerarias contratadas</div>
    <div id="SubFormularioFuneraria_controls">
     <a id="SubFormularioFuneraria_add" class="boton"> <?php echo $this->Html->image('nuevo.png', array('alt' => 'nuevo', 'style' => 'height:24px; width:24px;')) . ' Añadir funeraria'; ?> </a>
     <a id="SubFormularioFuneraria_remove_last" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'style' => 'height:24px; width:24px;')) . ' Eliminar última funeraria'; ?> </a>
     <a id="SubFormularioFuneraria_remove_all" class="boton"> <?php echo $this->Html->image('limpiar.png', array('alt' => 'limpiar', 'style' => 'height:24px; width:24px;')) . ' Eliminar todas las funerarias'; ?> </a>
    </div>
   </div>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar'), array('type' => 'submit', 'name' => 'guardar', 'class' => 'boton'));
  echo $this->Form->button(__('Guardar y Nuevo'), array('type' => 'submit', 'name' => 'guardar_y_nuevo', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
