<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu('pagos'); ?>
</div>

<script>
   
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#PagoFechaDesde").datepicker({
     altField: "#PagoDesde",
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
     onClose: function(selectedDate) {
       $("#PagoFechaHasta").datepicker("option", "minDate", selectedDate);
     }
   });
   
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#PagoFechaHasta").datepicker({
     altField: "#PagoHasta",
     altFormat: "yy-mm-dd",
     buttonImage: "img/calendario.gif",
     changeMonth: true,
     changeYear: true,
     selectOtherMonths: true,
     showAnim: "slide",
     showOn: "both",
     showButtonPanel: true,
     showOtherMonths: true,
     showWeek: true,
     onClose: function(selectedDate) {
       $("#PagoFechaDesde").datepicker("option", "maxDate", selectedDate);
     }
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

<?php /* Formulario nuevo pago */ ?>
<div class="add form">
 <?php echo $this->Form->create('Pago');?>
  <fieldset>
   <legend><?php echo __('Datos del pago'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('Pago.tipo_pagador', array('label' => 'Tipo de pagador:', 'type' => 'select', 'options' => $pagadores, 'empty' => ''));
?>
   <div id="Particular" style="display:none;">
    <?php
     /* Campos arrendatario */
    echo $this->Form->input('Pago.arrendatario_bonito', array('label' => 'Particular:')); //Campo imaginario
    echo $this->Form->input('Pago.arrendatario_id', array('type' => 'hidden'));
    ?>
   </div>
   <div id="Funeraria" style="display:none;">
    <?php
     /* Campos funeraria */
    echo $this->Form->input('Pago.funeraria_bonita', array('label' => 'Funeraria:')); //Campo imaginario
    echo $this->Form->input('Pago.funeraria_id', array('type' => 'hidden'));
    ?>
   </div>
    <?php
    echo $this->Form->input('Pago.tumba_bonita', array('label' => 'Tumba:')); //Campo imaginario
    echo $this->Form->input('Pago.tumba_id', array('type' => 'hidden'));
    echo $this->Form->input('Pago.fecha_bonita', array('label' => 'Fecha de pago:')); //Campo imaginario
    echo $this->Form->input('Pago.fecha', array('type' => 'hidden'));
    echo $this->Form->input('Pago.total', array('label' => 'Total:', 'default' => '0', 'readonly' => 'readonly'));
    echo $this->Form->input('Pago.moneda', array('label' => 'Moneda:', 'type' => 'select', 'options' => $monedas, 'empty' => ''));
    echo $this->Form->input('Pago.observaciones', array('label' => 'Anotaciones:'));
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
  echo $this->GuarritasEnergeticas->burtones_nuevo();
  echo $this->Form->end();
 ?>
 
</div>
