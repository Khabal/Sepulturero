<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu_extendido('traslados', $this->Session->read('Traslado.id'), $this->Session->read('Traslado.fecha_motivo')); ?>
</div>

<pre>
<?php print_r($this->Session->read()); ?>
<?php print_r($this->request->data); ?>
</pre>

<script>
 $(function() {
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#TrasladoFechaBonita").datepicker({
     altField: "#TrasladoFecha",
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
   $("#TrasladoTumbaOrigen").autocomplete({
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
     minLength: 1,
     select: function(event, ui) {
       event.preventDefault(),
       $("#TrasladoTumbaOrigen").val(ui.item.label),
       $("#TrasladoTumba0TumbaId").val(ui.item.value),
       /* Cargar los difuntos de la tumba */
       $.get(
         "<?php echo $this->Html->url(array('controller' => 'difuntos', 'action' => 'muertos_tumba')); ?>",
         {term: ui.item.value},
         function(respuesta){
           $("#Difuntos").html(respuesta);
       }) 
     },
     open: function() {
       $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
     },
     close: function() {
       $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
     }
   });
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#TrasladoTumbaDestino").autocomplete({
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
     minLength: 1,
     select: function(event, ui) {
       event.preventDefault(),
       $("#TrasladoTumbaDestino").val(ui.item.label),
       $("#TrasladoTumba1TumbaId").val(ui.item.value)
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

<?php /* Formulario traslado */ ?>
<div class="edit form">
 <?php echo $this->Form->create('Traslado');?>
  <fieldset>
   <legend><?php echo __('Datos del traslado');?></legend>
   <?php
    echo $this->Form->input('Traslado.fecha_bonita', array('label' => 'Fecha de traslado:')); //Campo imaginario
    echo $this->Form->input('Traslado.fecha', array('type' => 'hidden'));
    echo $this->Form->input('Traslado.cementerio_origen', array('label' => 'Cementerio de origen:'));
    echo $this->Form->input('Traslado.cementerio_destino', array('label' => 'Cementerio de destino:'));
    echo $this->Form->input('Traslado.motivo', array('label' => 'Motivo:'));
    echo $this->Form->input('Traslado.observaciones', array('label' => 'Anotaciones:'));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Tumba de origen'); ?></legend>
    <?php /* Campos */
    echo $this->Form->input('Traslado.tumba_origen', array('label' => 'Tumba:')); //Campo imaginario
    echo $this->Form->input('TrasladoTumba.0.tumba_id', array('type' => 'hidden'));
   ?>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Difuntos a trasladar'); ?></legend>
   <div id="Difuntos">
    <?php /* Campos */
if($this->request->data['DifuntoTumba']){
//if($this->request->data['DifuntoTraslado']){
  $i = 0;
  foreach($this->request->data['DifuntoTumba'] as $morido) {
$marcar=false;
  foreach($this->request->data['DifuntoTraslado'] as $fiambre) {
if($morido['Difunto']['id'] == $fiambre['Difunto']['id']){$marcar=true;break;}
}
   echo $this->Form->input('DifuntoTraslado.'.$i.'.difunto_id', array('label' => $morido['Persona']['nombre_completo'], 'type' => 'checkbox', 'value' => $morido['Difunto']['id'], 'checked' => $marcar));
   $i++;
  }
}
else
{
  echo "La tumba de origen está vacía.";
}
   ?>
   </div>
  </fieldset>
  <fieldset>
   <legend><?php echo __('Tumba de destino'); ?></legend>
    <?php /* Campos */
    echo $this->Form->input('Traslado.tumba_destino', array('label' => 'Tumba:')); //Campo imaginario
    echo $this->Form->input('TrasladoTumba.1.tumba_id', array('type' => 'hidden'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Modificar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->button(__('Descartar cambios'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>