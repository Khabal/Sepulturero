<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <?php echo $this->Html->charset(); ?>
  
  <title><?php echo $title_for_layout; ?></title>
  
  <?php
   /* Icono de la web */
   echo $this->Html->meta('icon');
   /* JavaScript */
   echo $scripts_for_layout;
   /* Archivos CSS de 960 Grid System */
   echo $this->Html->css(array('reset', 'text', 'grid', 'layout', 'nav'));
   /* Archivos varios de jQuery UI */
   echo $this->Html->css('smoothness/jquery-ui-1.10.2.custom');
   echo $this->Html->script('jquery-1.9.1.js');
   echo $this->Html->script('jquery-ui-1.10.2.js');
   /* Pulgin de jQuery UI para formularios */
   echo $this->Html->script('jquery.sheepItPlugin.js');
   /* Archivos CSS particulares */
   echo $this->Html->css(array('general', 'cabeza', 'pie'));
  ?>
  
  <script>
   /* Inicializaciones globales de jQuery UI */
   jQuery(function($){
     /* Inicialización en español para 'UI datepicker' para jQuery. */
     $.datepicker.regional['es'] = {
       closeText: 'Cerrar',
       prevText: 'Anterior',
       nextText: 'Siguiente',
       currentText: 'Hoy',
       monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
       dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
       dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
       dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
       weekHeader: 'Se',
       dateFormat: 'dd/mm/yy',
       firstDay: 1,
       isRTL: false,
       showMonthAfterYear: false,
       yearSuffix: ''
     };
     
     /* Establecer opciones en español como por defecto para 'UI datepicker' */
     $.datepicker.setDefaults($.datepicker.regional['es']);
     
     /* Establecer opciones de 'UI button' para jQuery */
     $(".boton_buscar").button({
       icons: {
         primary: "icono-buscar"
       },
       text: true
     });
     $(".boton_aceptar").button({
       icons: {
         primary: "icono-aceptar"
       },
       text: true
     });
     $(".boton_cancelar").button({
       icons: {
         primary: "icono-cancelar"
       },
       text: true
     });
     $(".boton_mas").button({
       icons: {
         primary: "icono-anadir"
       },
       text: true
     });
     $(".boton_borrar").button({
       icons: {
         primary: "icono-borrar"
       },
       text: true
     });
     $(".boton_limpiar").button({
       icons: {
         primary: "icono-limpiar"
       },
       text: true
     });
     $(".boton_guardar").button({
       icons: {
         primary: "icono-guardar"
       },
       text: true
     });
     $(".boton_guardar_nuevo").button({
       icons: {
         primary: "icono-guardar-nuevo"
       },
       text: true
     });
     $(".boton_anterior").button({
       icons: {
         primary: "icono-anterior"
       },
       text: true
     });
     $(".boton_siguiente").button({
       icons: {
         secondary: "icono-siguiente"
       },
       text: true
     });
     $(".boton_volver").button({
       icons: {
         primary: "icono-volver"
       },
       text: true
     });
     
     /* Establecer opciones de 'UI dialog' para jQuery */
     $("#dialogo").dialog({
       autoOpen: false,
       buttons: [{
         text: "Aceptar",
         click: function() {
           $(this).dialog("close");
         }
       }],
       height: 250,
       hide: {
         effect: "explode",
         duration: 500
       },
       modal: true,
       resizable: false,
       show: {
         effect: "explode",
         duration: 500
       },
       width: 500
     });
     
     /* Establecer opciones para el enlace para abrir 'UI dialog' para jQuery */
     $("#abrir_dialogo").click(function(event) {
       $("#dialogo").dialog("open");
       event.preventDefault();
     });
     
     /* Establecer opciones de 'UI tooltip' para jQuery */
     /* NOTA: Se mostrará lo que esté dentro del atributo 'title' */
     $(document).tooltip({ // Habilitar 'UI tooltip' en todo el documento
       hide: {
         effect: "explode",
         delay: 250
       },
       show: {
         effect: "explode",
         delay: 250
       },
       track: true
     });
   });
  </script>

 </head>
 <body>
  <!-- Contenedor de basura azul para cartón -->
  <div class="container_16">
   
   <!-- Cabecera -->			
   <div class="grid_16">
    <div class="bordes_redondeados degradado_gris" id="cabecera">
     <div class="grid_2">
      <?php echo $this->Html->image('Cruz-1.png', array('alt' => '+', 'class' => 'imagen')); ?>
     </div>
     <div class="grid_10">
       <h1>Cementerio Municipal de Motril</h1>
     </div>
     <div class="grid_4">
      <?php echo $this->Html->image('Motril.png', array('alt' => 'Ayuntamiento de Motril', 'class' => 'logo')); ?>
     </div>
     
     <div class="clear"></div>
     
     <div class="grid_10">
      <h2 style="margin:15px;" id="page-heading">Registro informático</h2>
     </div>
     <div class="grid_6">
      <div style="margin:15px;" class="box">
       <h2>
        <a style="cursor:pointer;" href="#" id="toggle-search">Búsqueda en el registro</a>
       </h2>
       <div style="margin:0px; position:static; overflow:hidden;">
        <div style="margin:0px;" class="block" id="search">

<?php
echo $this->Form->create('User', array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
    ),
    'url' => array('controller' => strtolower($this->name), 'action' => 'index'),
    'type' => 'get'
));

    
echo $this->Form->input('clave', array('label' => '', 'type' => 'text', 'class' => 'search text'));
echo $this->Form->submit(__('Buscar'), array('div' => false, 'class' => 'boton_buscar'));
 echo $this->Form->end(); ?>
        </div>
       </div>
      </div>
     </div>
     
     <div class="clear"></div>
     
    </div>
   </div>
   
   <div style="height:5px;" class="clear"></div>
   
   <!-- Menú -->
   <div class="grid_16 bordes_redondeados">
    <ul class="nav main">
     <li><!-- Arrendamientos -->
      <?php echo $this->Html->link(__('Arrendamientos'), array('controller' => 'arrendamientos', 'action' => 'index')); ?>
      <ul>
       <li>
        <?php echo $this->Html->link(__('Listado'), array('controller' => 'arrendamientos', 'action' => 'index')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'arrendamientos', 'action' => 'nuevo')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Buscar'), array('controller' => 'arrendamientos', 'action' => 'buscar')); ?>
       </li>
      </ul>
     </li>
     <li><!-- Arrendatarios -->
      <?php echo $this->Html->link(__('Arrendatarios'), array('controller' => 'arrendatarios', 'action' => 'index')); ?>
      <ul>
       <li>
        <?php echo $this->Html->link(__('Listado'), array('controller' => 'arrendatarios', 'action' => 'index')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'arrendatarios', 'action' => 'nuevo')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Buscar'), array('controller' => 'arrendatarios', 'action' => 'buscar')); ?>
       </li>
      </ul>
     </li>
     <li><!-- Concesiones -->
      <?php echo $this->Html->link(__('Concesiones'), array('controller' => 'concesiones', 'action' => 'index')); ?>
      <ul>
       <li>
        <?php echo $this->Html->link(__('Listado'), array('controller' => 'concesiones', 'action' => 'index')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'concesiones', 'action' => 'nuevo')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Buscar'), array('controller' => 'concesiones', 'action' => 'buscar')); ?>
       </li>
      </ul>
     </li>
     <li><!-- Difuntos -->
      <?php echo $this->Html->link(__('Difuntos'), array('controller' => 'difuntos', 'action' => 'index')); ?>
      <ul>
       <li>
        <?php echo $this->Html->link(__('Listado'), array('controller' => 'difuntos', 'action' => 'index')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'difuntos', 'action' => 'nuevo')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Buscar'), array('controller' => 'difuntos', 'action' => 'buscar')); ?>
       </li>
      </ul>
     </li>
     <li><!-- Forenses -->
      <?php echo $this->Html->link(__('Forenses'), array('controller' => 'forenses', 'action' => 'index')); ?>
      <ul>
       <li>
        <?php echo $this->Html->link(__('Listado'), array('controller' => 'forenses', 'action' => 'index')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'forenses', 'action' => 'nuevo')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Buscar'), array('controller' => 'forenses', 'action' => 'buscar')); ?>
       </li>
      </ul>
     </li>
     <li><!-- Funerarias -->
      <?php echo $this->Html->link(__('Funerarias'), array('controller' => 'funerarias', 'action' => 'index')); ?>
      <ul>
       <li>
        <?php echo $this->Html->link(__('Listado'), array('controller' => 'funerarias', 'action' => 'index')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'funerarias', 'action' => 'nuevo')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Buscar'), array('controller' => 'funerarias', 'action' => 'buscar')); ?>
       </li>
      </ul>
     </li>
     <li><!-- Movimientos -->
      <?php echo $this->Html->link(__('Movimientos'), array('controller' => 'movimientos', 'action' => 'index')); ?>
      <ul>
       <li>
        <?php echo $this->Html->link(__('Listado'), array('controller' => 'movimientos', 'action' => 'index')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'movimientos', 'action' => 'nuevo')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Buscar'), array('controller' => 'movimientos', 'action' => 'buscar')); ?>
       </li>
      </ul>
     </li>
     <li><!-- Pagos -->
      <?php echo $this->Html->link(__('Pagos'), array('controller' => 'pagos', 'action' => 'index')); ?>
      <ul>
       <li>
        <?php echo $this->Html->link(__('Listado'), array('controller' => 'pagos', 'action' => 'index')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'pagos', 'action' => 'nuevo')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Buscar'), array('controller' => 'pagos', 'action' => 'buscar')); ?>
       </li>
      </ul>
     </li>
     <li><!-- Tasas -->
      <?php echo $this->Html->link(__('Tasas'), array('controller' => 'tasas', 'action' => 'index')); ?>
      <ul>
       <li>
        <?php echo $this->Html->link(__('Listado'), array('controller' => 'tasas', 'action' => 'index')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'tasas', 'action' => 'nuevo')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Buscar'), array('controller' => 'tasas', 'action' => 'buscar')); ?>
       </li>
      </ul>
     </li>
     <li><!-- Tumbas -->
      <?php echo $this->Html->link(__('Tumbas'), array('controller' => 'tumbas', 'action' => 'index')); ?>
      <ul>
       <li>
        <?php echo $this->Html->link(__('Listado'), array('controller' => 'tumbas', 'action' => 'index')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'tumbas', 'action' => 'nuevo')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Buscar'), array('controller' => 'tumbas', 'action' => 'buscar')); ?>
       </li>
      </ul>
     </li>
     <li class="secondary">
      <a href="http://960.gs/" title="The 960 CSS Grid System">The 960 CSS Grid System</a>
     </li>
    </ul>
   </div>
   
   <div style="height:5px;" class="clear"></div>
   
   <!-- La manteca -->
   <div class="grid_16">
    <div class="bordes_redondeados degradado_gris_blanco" id="contenedor">
     <div style="height:2cm; width:100%;" class="clear"></div>
     <?php echo $this->Session->flash(); ?>
     <?php echo $content_for_layout; ?>
    </div>
   </div>
   
   <div class="clear"></div>
   
   <!-- Mesón del Pie Amigo -->
   <div class="grid_16">
    <div class="bordes_redondeados degradado_azul_negro" id="pie">
     <div class="grid_4"> <!-- Logo corporativo -->
      <?php echo $this->Html->image('Nuevas_Tecnologias.png', array('alt' => 'Nuevas Tecnologías', 'class' => 'logo')); ?>
     </div>
     <div class="grid_8"> <!-- Texto -->
      <p class="resaltado">Registro informatizado del cementerio municipal de Motril.</p>
     </div>
     <div class="grid_4"> <!-- Validación Web -->
      <ul>
       <li>
        <a style="text-decoration:none;" href="http://jigsaw.w3.org/css-validator/check/referer">
         <?php echo $this->Html->image('valid-xhtml11-blue.png', array('alt' => 'HTML validator')); ?>
        </a>
       </li>
       <li>
        <a style="text-decoration:none;" href="http://validator.w3.org/check?uri=referer">
         <?php echo $this->Html->image('valid-css-blue.png', array('alt' => 'CSS validator')); ?>
        </a>
       </li>
      </ul>
     </div>
     
     <div class="clear"></div>
     
     <div class="grid_4"> <!-- Logo corporativo -->
      <?php echo $this->Html->image('Salud_Consumo.png', array('alt' => 'Salud y Consumo', 'class' => 'logo')); ?>
     </div>
     <div class="grid_8"> <!-- Texto LOPD -->
      <p id="lopd">
Los datos personales aquí guardados forman parte de un fichero titularidad del AYUNTAMIENTO DE MOTRIL cuya finalidad es la de mantener el registro de difuntos sepultados en el cementerio municipal y el contacto con los arrendatarios. De acuerdo con la Ley Orgánica 15/1999, un arrendatario puede ejercitar sus derechos de acceso, rectificación, cancelación y, en su caso, oposición enviando una solicitud por escrito, acompañada de una fotocopia de su D.N.I. dirigida a AYUNTAMIENTO DE MOTRIL. PLAZA DE ESPAÑA Nº 1, 18600 MOTRIL (GRANADA).
      </p>
     </div>
     <div class="grid_4"> <!-- Enlaces y varios -->
      <ul>
       <li><a href="#" id="abrir_dialogo"> Acerca de</a></li>
       <li><a href="http://www.motril.es">Motril</a></li>
      </ul>
     </div>
     
     <div class="clear"></div>
     
    </div>
   </div>
   
   <div class="clear"></div>
   
  </div>
  
  <!-- Cuadro "Acerca de" -->
  <div id="dialogo">
   <h2> Gestión Municipal de Cementerios (GMC) </h2>
   <p> Registro informatizado para la gestión de cementerios. </p>
   <p style="font-style:italic;"> LaBellotaSoft - Khabal 2013. </p>
  </div>
  
  <!-- Volcado de la consula SQL a la base de datos -->
  <?php echo $this->element('sql_dump'); ?>
  
 </body>
</html>
