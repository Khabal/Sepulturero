<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('pagos', $this->Session->read('Pago.id'), $this->Session->read('Pago.fecha')); ?>
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
 if (isset($this->request->data['PagoTasa'])) {
  $ini_t = sizeof($this->request->data['PagoTasa']);
  $data_t = array();
  foreach($this->request->data['PagoTasa'] as $tasa) {
   array_push($data_t, array("PagoTasa#index#TasaBonita" => $tasa['tasa_bonita'], "PagoTasa#index#TasaId" => $tasa['tasa_id']));
  }
  $data_t = json_encode($data_t);
 }
 else {
  $ini_t = 0;
  $data_t = "[]";
 }
 
 /* Cargar mensajes de error para los campos generados con sheepIt */
 if (isset($this->validationErrors['PagoTasa'])) {
  $tam_t = count($this->validationErrors['PagoTasa']);
  $mensajes_error_t = array();
  for ($i = 0; $tam_t > 0; $i++) {
   if (isset($this->validationErrors['PagoTasa'][$i])) {
    array_push($mensajes_error_t, array($i + 1 => $this->validationErrors['PagoTasa'][$i]['tasa_bonita'][0]));
    $tam_t--;
   }
   else {
    array_push($mensajes_error_t, array($i + 1 => ""));
   }
  }
  $mensajes_error_t = json_encode($mensajes_error_t);
 }
 else {
  $mensajes_error_t = "[]";
 }
?>

<script>
 var errores = <?php echo $mensajes_error_t; ?>;
 var num = 0;
var dineuros = 0;
 
 $(function() {
   /* Formulario sheepIt para agregar tasas */
   $("#SubFormularioTasa").sheepIt({
     separator: '',
     allowRemoveLast: true,
     allowRemoveCurrent: true,
     allowRemoveAll: true,
     allowAdd: true,
     allowAddN: false,
     maxFormsCount: 100,
     minFormsCount: 0,
     continuousIndex: false,
     iniFormsCount: <?php echo h($ini_t); ?>,
     removeAllConfirmationMsg: '¿Eliminar todas las tasas del pago?',
     data: <?php echo $data_t; ?>,
     afterAdd: function(source, newForm) {
       /* Obtener identificadores de campos */
       var auto = "#" + $(newForm).children("div").children("input[id$='TasaBonita']").attr("id");
       var auto_oc = auto.replace("Bonita", "Id");
       
       /* Establecer opciones de 'UI Autocomplete' para jQuery */
       $(auto).autocomplete({
         source: function(request, response) {
           $.ajax({
             url: "<?php echo $this->Html->url(array('controller' => 'tasas', 'action' => 'autocomplete')); ?>",
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
                   value: x.value,
                   dinero: x.dinero
                 }
               }));
             }
           });
         },
         minLength: 2,
         select: function(event, ui) {
           event.preventDefault(),
           $(auto).val(ui.item.label),
           $(auto_oc).val(ui.item.value),
           dineuros = parseFloat($("#PagoTotal").val()) + parseFloat(ui.item.dinero),
           $("#PagoTotal").val(dineuros.toString().replace(/\./g,','))
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

<script>
 /* Establecer opciones de 'UI datepicker' para JQuery */
 $(function() {
   $("#PagoFechaBonita").datepicker({
     altField: "#PagoFecha",
     altFormat: "yy-mm-dd",
     buttonImage: "calendario.gif",
     changeMonth: true,
     changeYear: true,
     selectOtherMonths: true,
     showAnim: "slide",
     showOn: "both",
     showButtonPanel: true,
     showOtherMonths: true,
     showWeek: true,
   });
   
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#PagoArrendatarioBonito").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'arrendatarios', 'action' => 'autocomplete')); ?>",
         dataType: "json",
         type: "GET",
         data: {
           term: request.term
         },
         success: function(data) {
           response( $.map(data, function(x) {
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
       $("#PagoArrendatarioBonito").val(ui.item.label),
       $("#PagoArrendatarioId").val(ui.item.value),
       /* Borrar contenido de funeraria pagadora */
       $("#PagoFunerariaBonita").val(""),
       $("#PagoFunerariaId").val("")
     },
     open: function() {
       $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
     },
     close: function() {
       $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
     }
   });
   
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#PagoFunerariaBonita").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'funerarias', 'action' => 'autocomplete')); ?>",
         dataType: "json",
         type: "GET",
         data: {
           term: request.term
         },
         success: function(data) {
           response( $.map(data, function(x) {
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
       $("#PagoFunerariaBonita").val(ui.item.label),
       $("#PagoFunerariaId").val(ui.item.value),
       /* Borrar contenido de arrendatario pagador */
       $("#PagoArrendatarioBonito").val(""),
       $("#PagoArrendatarioId").val("")
     },
     open: function() {
       $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
     },
     close: function() {
       $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
     }
   });
   
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#PagoTumbaBonita").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'tumbas', 'action' => 'autocomplete')); ?>",
         dataType: "json",
         type: "GET",
         data: {
           term: request.term
         },
         success: function(data) {
           response( $.map(data, function(x) {
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
       $("#PagoTumbaBonita").val(ui.item.label),
       $("#PagoTumbaId").val(ui.item.value)
     },
     open: function() {
       $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
     },
     close: function() {
       $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
     }
   });
   
 });
</script>

<script>
 $(document).ready(function(){
   var seleccionado = $("#PagoTipoPagador").val();
   
   /* Mostrar campos del formulario adecuados a cada tipo de tumba */
   $("#PagoTipoPagador").change(function(event, ui) {
     event.preventDefault();
     if (seleccionado != $("#PagoTipoPagador").val()) {
       seleccionado = $("#PagoTipoPagador").val();
       if (seleccionado == "Particular") {
         $("#Particular").show(),
         $("#Funeraria").hide()
       }
       else if (seleccionado == "Funeraria") {
         $("#Particular").hide(),
         $("#Funeraria").show()
       }
       else {
         $("#Particular").hide(),
         $("#Funeraria").hide()
       }
     }
   });
   
   /* Mostrar campos adecuados si se recarga */
   if (seleccionado == "Particular") {
     $("#Particular").show(),
     $("#Funeraria").hide()
   }
   else if (seleccionado == "Funeraria") {
     $("#Particular").hide(),
     $("#Funeraria").show()
   }
   else {
     $("#Particular").hide(),
     $("#Funeraria").hide()
   }
   
 });
</script>

<?php /* Formulario editar pago */ ?>
<div class="edit form">
 <?php echo $this->Form->create('Pago');?>
  <fieldset>
   <legend><?php echo __('Datos del pago'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Pago.tipo_pagador', array('label' => 'Tipo de pagador:', 'type' => 'select', 'options' => $pagadores, 'empty' => ''));
?>
   <div id="Particular" style="display:none;">
    <?php
     /* Campos arrendatario */
    echo $this->Form->input('Pago.arrendatario_bonito', array('label' => 'Particular:', 'class' => 'texto')); //Campo imaginario
    echo $this->Form->input('Pago.arrendatario_id', array('type' => 'hidden'));
    ?>
   </div>
   <div id="Funeraria" style="display:none;">
    <?php
     /* Campos funeraria */
    echo $this->Form->input('Pago.funeraria_bonita', array('label' => 'Funeraria:', 'class' => 'texto')); //Campo imaginario
    echo $this->Form->input('Pago.funeraria_id', array('type' => 'hidden'));
    ?>
   </div>
    <?php
    echo $this->Form->input('Pago.tumba_bonita', array('label' => 'Tumba:')); //Campo imaginario
    echo $this->Form->input('Pago.tumba_id', array('type' => 'hidden'));
    echo $this->Form->input('Pago.fecha_bonita', array('label' => 'Fecha de pago:', 'class' => 'fecha')); //Campo imaginario
    echo $this->Form->input('Pago.fecha', array('type' => 'hidden'));
    echo $this->Form->input('Pago.total', array('label' => 'Total:', 'default' => '0', 'readonly' => 'readonly'));
    echo $this->Form->input('Pago.moneda', array('label' => 'Moneda:', 'type' => 'select', 'options' => $monedas, 'empty' => ''));
    echo $this->Form->input('Pago.observaciones', array('label' => 'Anotaciones:', 'class' => 'anotaciones'));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Tasas pagadas'); ?></legend>
   <div id="SubFormularioTasa">
    <div id="SubFormularioTasa_template">
     <?php /* Campos */
      echo $this->Form->input('PagoTasa.#index#.tasa_bonita', array('label' => 'Tasa:')); //Campo imaginario
      echo $this->Form->input('PagoTasa.#index#.tasa_id', array('type' => 'hidden'));
      echo $this->Form->input('PagoTasa.#index#.detalle', array('label' => 'Detalle:'));
     ?>
     <a id="SubFormularioTasa_remove_current" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'class' => 'delete', 'style' => 'height:16px; width:16px;')); ?> </a>
    </div>
    <div id="SubFormularioTasa_noforms_template">No hay tasas a pagar</div>
    <div id="SubFormularioTasa_controls">
     <a id="SubFormularioTasa_add" class="boton"> <?php echo $this->Html->image('nuevo.png', array('alt' => 'nuevo', 'style' => 'height:24px; width:24px;')) . ' Añadir tasa'; ?> </a>
     <a id="SubFormularioTasa_remove_last" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'style' => 'height:24px; width:24px;')) . ' Eliminar última tasa'; ?> </a>
     <a id="SubFormularioTasa_remove_all" class="boton"> <?php echo $this->Html->image('limpiar.png', array('alt' => 'limpiar', 'style' => 'height:24px; width:24px;')) . ' Eliminar todas las tasas'; ?> </a>
    </div>
   </div>
  </fieldset>
 
 <?php /* Botones */
  echo $this->GuarritasEnergeticas->burtones_editar();
  echo $this->Form->end();
 ?>
 
</div>
