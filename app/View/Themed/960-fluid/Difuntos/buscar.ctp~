<?php /* Menú de accciones */ ?>
<div class="actions box">
 <h2><?php echo __('Menú de accciones'); ?></h2>
 <?php echo $this->GuarritasEnergeticas->guarrita_menu(strtolower($this->name)); ?>
</div>

<script>
 $(function() {
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#DifuntoFechaDesde").datepicker({
     altField: "#DifuntoDesde",
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
       $("#DifuntoFechaHasta").datepicker("option", "minDate", selectedDate);
     }
   });
   
   /* Establecer opciones de 'UI datepicker' para JQuery */
   $("#DifuntoFechaHasta").datepicker({
     altField: "#DifuntoHasta",
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
       $("#DifuntoFechaDesde").datepicker("option", "maxDate", selectedDate);
     }
   });
   
   /* Establecer opciones de 'UI autocomplete' para JQuery */
   $("#DifuntoTumba").autocomplete({
     source: function(request, response) {
       $.ajax({
         url: "<?php echo $this->Html->url(array('controller' => 'tumbas', 'action' => 'autocomplete')); ?>",
         dataType: "json",
         type: "GET",
         data: {
           term: request.term
         },
         timeout: 2000,
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
       $("#DifuntoTumba").val(ui.item.label),
       $("#DifuntoTumbaId").val(ui.item.value)
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

<?php /* Formulario buscar concesión */ ?>
<div class="find form">
 <?php echo $this->Form->create('Difunto', array(
    'url' => array('controller' => strtolower($this->name), 'action' => 'index'),
    'type' => 'get'
  ));
 ?>
  <fieldset>
   <legend><?php echo __('Información sobre la concesión'); ?></legend>
   <?php /* Campos */
    echo $this->Form->input('nombre', array('label' => 'Nombre:'));
    echo $this->Form->input('apellido1', array('label' => 'Primer apellido:'));
    echo $this->Form->input('apellido2', array('label' => 'Segundo apellido:'));
    echo $this->Form->input('dni', array('label' => 'D.N.I.:'));
    echo $this->Form->input('sexo', array('label' => 'Sexo:', 'type' => 'select', 'options' => $sexo, 'empty' => ''));
    echo $this->Form->input('nacionalidad', array('label' => 'Nacionalidad:'));
    echo $this->Form->input('tumba', array('label' => 'Tumba:')); //Campo imaginario
    echo $this->Form->input('tumba_id', array('type' => 'hidden'));
    echo $this->Form->input('estado', array('label' => 'Estado del cuerpo:', 'type' => 'select', 'options' => $estado, 'empty' => ''));
    echo '<div class="intervalo">';
    echo $this->Form->input('fecha_desde', array('label' => 'Fecha de defunción desde:')); //Campo imaginario
    echo $this->Form->input('desde', array('type' => 'hidden'));
    echo $this->Form->input('fecha_hasta', array('label' => 'hasta:')); //Campo imaginario
    echo $this->Form->input('hasta', array('type' => 'hidden'));
    echo '</div>';
    echo $this->Form->input('edad', array('label' => 'Edad:'));
    echo $this->Form->input('causa_fallecimiento', array('label' => 'Causa de fallecimiento:'));
    echo $this->Form->input('certificado_defuncion', array('label' => 'Certificado de defunción:'));
   ?>
  </fieldset>
 <?php /* Botones */
  echo $this->Form->button(__('Limpiar'), array('type' => 'reset', 'class' => 'boton'));
  echo $this->Form->button(__('Buscar'), array('type' => 'submit', 'class' => 'boton'));
  echo $this->Form->end();
 ?>
</div>
