<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido(strtolower($this->name), $this->Session->read('Movimiento.id'), $this->Session->read('Movimiento.fecha_motivo')); ?>
</div>

<?php
 
 echo '<pre>';
 print_r($this->request->data);
 print_r($this->validationErrors);
 echo '</pre>';
 
?>

<?php
 /* Cambiar el número iniFormsCount de sheepIt si hay datos para que los muestre */
 if (isset($this->request->data['DifuntoMovimiento'])) {
  if ($this->request->data['Movimiento']['tipo'] == "Inhumación"){
   $inicial = sizeof($this->request->data['DifuntoMovimiento']);
   $datos = array();
   foreach($this->request->data['DifuntoMovimiento'] as $difunto) {
    array_push($datos, array("DifuntoMovimiento#index#DifuntoBonito" => $difunto['difunto_bonito'], "DifuntoMovimiento#index#DifuntoId" => $difunto['difunto_id']));
   }
   $datos = json_encode($datos);
  }
  else {
   $inicial = 0;
   $datos = "[]";
  }
 }
 else {
  $inicial = 0;
  $datos = "[]";
 }
 
 /* Cargar mensajes de error para los campos generados con sheepIt */
 if (isset($this->validationErrors['DifuntoMovimiento'])) {
  $tam = count($this->validationErrors['DifuntoMovimiento']);
  $mensajes_error = array();
  for ($i = 0; $tam > 0; $i++) {
   if (isset($this->validationErrors['DifuntoMovimiento'][$i])) {
    array_push($mensajes_error, array($i + 1 => $this->validationErrors['DifuntoMovimiento'][$i]['difunto_bonito'][0]));
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
 var tum_org = <?php if (isset($this->request->data['MovimientoTumba'][0]['tumba_id'])) {echo '"' . $this->request->data['MovimientoTumba'][0]['tumba_id'] . '"';} else {echo '""';} ?>;
 
 $(function() {
   var seleccionado = $("#MovimientoTipo").val();
   
   /* Mostrar campos del formulario adecuados a cada tipo de movimiento */
   $("#MovimientoTipo").change(function(event, ui) {
     event.preventDefault();
     if (seleccionado != $("#MovimientoTipo").val()) {
       seleccionado = $("#MovimientoTipo").val();
       if (seleccionado == "Exhumación") {
         $("#Origen").show(),
         $("#FormularioDifuntos").hide(),
         $("#ListaDifuntos").show(),
         $("#Destino").hide()
       }
       else if (seleccionado == "Inhumación") {
         $("#Origen").hide(),
         $("#FormularioDifuntos").show(),
         $("#ListaDifuntos").hide(),
         $("#Destino").show()
       }
       else if (seleccionado == "Traslado") {
         $("#Origen").show(),
         $("#FormularioDifuntos").hide(),
         $("#ListaDifuntos").show(),
         $("#Destino").show()
       }
       else {
         $("#Origen").hide(),
         $("#FormularioDifuntos").hide(),
         $("#ListaDifuntos").hide(),
         $("#Destino").hide()
       }
     }
   });
   
   /* Mostrar campos adecuados si se recarga */
   if (seleccionado == "Exhumación") {
     $("#Origen").show(),
     $("#FormularioDifuntos").hide(),
     $("#ListaDifuntos").show(),
     $.get(
       "<?php echo $this->Html->url(array('controller' => 'tumbas', 'action' => 'muertos_tumba')); ?>",
       {term: tum_org},
       function(respuesta){
         $("#ListaDifuntos").html(respuesta);
       }),
     $("#Destino").hide()
   }
   else if (seleccionado == "Inhumación") {
     $("#Origen").hide(),
     $("#FormularioDifuntos").show(),
     $("#ListaDifuntos").hide(),
     $("#Destino").show()
   }
   else if (seleccionado == "Traslado") {
     $("#Origen").show(),
     $("#FormularioDifuntos").hide(),
     $("#ListaDifuntos").show(),
     $.get(
       "<?php echo $this->Html->url(array('controller' => 'tumbas', 'action' => 'muertos_tumba')); ?>",
       {term: tum_org},
       function(respuesta){
         $("#ListaDifuntos").html(respuesta);
       }),
     $("#Destino").show()
   }
   else {
     $("#Origen").hide(),
     $("#FormularioDifuntos").hide(),
     $("#ListaDifuntos").hide(),
     $("#Destino").hide()
   }
   
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#MovimientoFechaBonita").datepicker({
     altField: "#MovimientoFecha",
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
   
   /* Formulario sheepIt para agregar difuntos */
   $("#SubFormularioDifunto").sheepIt({
     separator: '',
     allowRemoveLast: true,
     allowRemoveCurrent: true,
     allowRemoveAll: true,
     allowAdd: true,
     allowAddN: false,
     maxFormsCount: 100,
     minFormsCount: 0,
     continuousIndex: false,
     iniFormsCount: <?php echo h($inicial); ?>,
     removeAllConfirmationMsg: '¿Eliminar todos las difuntos a mover?',
     data: <?php echo $datos; ?>,
     afterAdd: function(source, newForm) {
       /* Obtener identificadores de campos */
       var auto = "#" + $(newForm).children("div").children("input[id$='DifuntoBonito']").attr("id");
       var auto_oc = auto.replace("Bonito", "Id");
       
       /* Establecer opciones de 'UI Autocomplete' para jQuery */
       $(auto).autocomplete({
         source: function(request, response) {
           $.ajax({
             url: "<?php echo $this->Html->url(array('controller' => 'difuntos', 'action' => 'autocomplete')); ?>",
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
   
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#MovimientoTumbaOrigen").autocomplete({
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
       $("#MovimientoTumbaOrigen").val(ui.item.label),
       $("#MovimientoTumba0TumbaId").val(ui.item.value),
//if(("#MovimientoTipo").val() == "Traslado")
       /* Cargar los difuntos de la tumba */
       $.get(
         "<?php echo $this->Html->url(array('controller' => 'tumbas', 'action' => 'muertos_tumba')); ?>",
         {term: ui.item.value},
         function(respuesta){/*
$.each(respuesta, function (iteration, item) {
          $("#Difuntos").append(
    $(document.createElement("li"))
    .append(
        $(document.createElement("input")).attr({
            id: 'topicFilter-' + item
            , name: item
            , value: item
            , type: 'checkbox'
            , checked: true
        })
        //onclick
        .click(function (event) {
            var cbox = $(this)[0];
            alert(cbox.value);
        })
    )
    .append(
        $(document.createElement('label')).attr({
            'for': 'topicFilter' + '-' + item.label
        })
        .text(item.value)
    )
)
      });*/
           $("#ListaDifuntos").html(respuesta);
       }) 
     },
     open: function() {
       $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
     },
     close: function() {
       $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
     }
   });
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#MovimientoTumbaDestino").autocomplete({
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
       $("#MovimientoTumbaDestino").val(ui.item.label),
       $("#MovimientoTumba1TumbaId").val(ui.item.value)
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

<?php /* Formulario nuevo movimiento */ ?>
<div class="add form">
 <?php echo $this->Form->create('Movimiento');?>
  <fieldset>
   <legend><?php echo __('Datos del movimiento'); ?></legend>
   <?php
    echo $this->Form->input('Movimiento.tipo', array('label' => 'Clase de movimiento:', 'type' => 'select', 'options' => $tipo, 'empty' => '', 'readonly' => 'readonly'));
    echo $this->Form->input('Movimiento.fecha_bonita', array('label' => 'Fecha de movimiento:')); //Campo imaginario
    echo $this->Form->input('Movimiento.fecha', array('type' => 'hidden'));
    echo $this->Form->input('Movimiento.motivo', array('label' => 'Motivo:'));
    echo $this->Form->input('Movimiento.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Datos de origen'); ?></legend>
   <div id="Origen" style="display:none;">
    <?php /* Campos */
    echo $this->Form->input('Movimiento.cementerio_origen', array('label' => 'Cementerio de origen:', 'default' => 'Motril'));
    echo $this->Form->input('Movimiento.tumba_origen', array('label' => 'Tumba de origen:')); //Campo imaginario
    echo $this->Form->input('MovimientoTumba.0.tumba_id', array('type' => 'hidden'));
   ?>
   </div>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Difuntos a mover'); ?></legend>
   <div id="ListaDifuntos"></div>
   <div id="FormularioDifuntos" style="display:none;">
   <div id="SubFormularioDifunto">
    <div id="SubFormularioDifunto_template">
     <?php /* Campos */
      echo $this->Form->input('DifuntoMovimiento.#index#.difunto_bonito', array('label' => 'Difunto:')); //Campo imaginario
      echo $this->Form->input('DifuntoMovimiento.#index#.difunto_id', array('type' => 'hidden'));
     ?>
     <a id="SubFormularioDifunto_remove_current" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'class' => 'delete', 'style' => 'height:16px; width:16px;')); ?> </a>
    </div>
    <div id="SubFormularioDifunto_noforms_template">No hay difuntos a mover</div>
    <div id="SubFormularioDifunto_controls">
     <a id="SubFormularioDifunto_add" class="boton"> <?php echo $this->Html->image('nuevo.png', array('alt' => 'nuevo', 'style' => 'height:24px; width:24px;')) . ' Añadir difunto'; ?> </a>
     <a id="SubFormularioDifunto_remove_last" class="boton"> <?php echo $this->Html->image('cancelar.png', array('alt' => 'cancelar', 'style' => 'height:24px; width:24px;')) . ' Eliminar último difunto'; ?> </a>
     <a id="SubFormularioDifunto_remove_all" class="boton"> <?php echo $this->Html->image('limpiar.png', array('alt' => 'limpiar', 'style' => 'height:24px; width:24px;')) . ' Eliminar todas los difuntos'; ?> </a>
    </div>
   </div>
  </div>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Datos de destino'); ?></legend>
   <div id="Destino" style="display:none;">
    <?php /* Campos */
    echo $this->Form->input('Movimiento.cementerio_destino', array('label' => 'Cementerio de destino:', 'default' => 'Motril'));
    echo $this->Form->input('Movimiento.tumba_destino', array('label' => 'Tumba de destino:')); //Campo imaginario
    echo $this->Form->input('MovimientoTumba.1.tumba_id', array('type' => 'hidden'));
   ?>
   </div>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Modificar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Descartar cambios'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
