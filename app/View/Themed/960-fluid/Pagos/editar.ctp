<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php $pago = $this->request->data; ?>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('pagos', $this->Session->read('Pago.id'), $this->Session->read('Pago.fecha')); ?>
</div>

<script>
 /* Establecer opciones de 'UI datepicker' para JQuery */
 $(function() {
   $("#fecha").datepicker({
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
   $("#tasa").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'tasas', 'action' => 'autocomplete')); ?>",
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
     minLength: 1,
     select: function(event, ui) {
       event.preventDefault(),
       $("#tasa").val(ui.item.label),
       $("#PagoTasaId").val(ui.item.value)
     },
     open: function() {
       $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
     },
     close: function() {
       $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
     }
   });
 });
</script>

<?php /* Formulario editar pago */ ?>
<div class="edit form">
 <?php echo $this->Form->create('Pago', array('type' => 'post')); ?>
  <fieldset>
   <legend><?php echo __('Datos del pago');?></legend>
   <div class="input text required">
    <label for="fecha">Fecha:</label>
    <input id="fecha" value="<?php if ($this->request->data) { echo date('d/m/Y', strtotime($this->request->data['Pago']['fecha'])); } ?>"/>
   </div>
   <?php echo $this->Form->input('Pago.fecha', array('type' => 'hidden')); ?>
   <?php
    echo $this->Form->input('Pago.cantidad', array('label' => 'Cantidad:'));
   ?>
   <div class="input text required">
    <label for="TasaMoneda">Moneda:</label>
    <?php echo $this->Form->select('Pago.moneda', $monedas); ?>
   </div>
   <?php
    echo $this->Form->input('Pago.motivo', array('label' => 'Motivo:'));
    echo $this->Form->input('Pago.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Tasa asociada'); ?></legend>
   <?php /* Campos */ ?>
   <div class="input text required">
    <label for="tasa">Tasa:</label>
    <input id="tasa" value="<?php if ($this->request->data) { echo $this->request->data['Tasa']['tipo']; } ?>"/>
   </div>
   <?php echo $this->Form->input('Pago.tasa_id', array('type' => 'hidden')); ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Documento asociado'); ?></legend>
   <?php /* Campos */
	/*echo $this->AutoComplete->input('Funeraria.nombre', array('label' => 'Funeraria:')/*, array('source' => '/arrendatarios/kkkk/'));*/
    echo $this->Form->input('Documento', array('label' => 'Documento:'));
    ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Modificar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Descartar cambios'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
