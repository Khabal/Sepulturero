<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <?php echo $this->Html->charset(); ?>
  <title><?php echo $title_for_layout; ?></title>
  <?php
   /* Icono de la web */
   echo $this->Html->meta('icon');
   /* Archivos CSS de 960 Grid System */
   echo $this->Html->css(array('reset', 'text', 'grid', 'layout', 'nav'));
   /* Archivos CSS particulares */
   echo $this->Html->css(array('general', 'cabeza', 'pie'));
   /* Archivos Javascript JQuery */
/*echo $this->Html->css('smoothness/jquery-ui-1.9.2.custom');
echo $this->Html->script('jquery-1.8.3.js');
echo $this->Html->script('1.9.2/jquery-ui.js');
   echo $this->Html->script(array('jquery-fluid16.js', 'jquery.simpledialog.0.1'));*/


   /* Copia de scripts */
echo $this->fetch('script');
//   echo $scripts_for_layout;
  ?>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<?php
echo $this->Html->script('jquery.sheepItPlugin.js');
?>
  <script>
   /* Inicializaciones globales */
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
     $.datepicker.setDefaults($.datepicker.regional['es']);
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
echo $this->Form->submit(__('Buscar'), array('div' => false, 'class' => 'search button'));
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
     <li><!-- Enterramientos -->
      <?php echo $this->Html->link(__('Enterramientos'), array('controller' => 'enterramientos', 'action' => 'index')); ?>
      <ul>
       <li>
        <?php echo $this->Html->link(__('Listado'), array('controller' => 'enterramientos', 'action' => 'index')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'enterramientos', 'action' => 'nuevo')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Buscar'), array('controller' => 'enterramientos', 'action' => 'buscar')); ?>
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
     <li><!-- Licencias -->
      <?php echo $this->Html->link(__('Licencias'), array('controller' => 'licencias', 'action' => 'index')); ?>
      <ul>
       <li>
        <?php echo $this->Html->link(__('Listado'), array('controller' => 'licencias', 'action' => 'index')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'licencias', 'action' => 'nuevo')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Buscar'), array('controller' => 'licencias', 'action' => 'buscar')); ?>
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
     <li><!-- Traslados -->
      <?php echo $this->Html->link(__('Traslados'), array('controller' => 'traslados', 'action' => 'index')); ?>
      <ul>
       <li>
        <?php echo $this->Html->link(__('Listado'), array('controller' => 'traslados', 'action' => 'index')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Nuevo'), array('controller' => 'traslados', 'action' => 'nuevo')); ?>
       </li>
       <li>
        <?php echo $this->Html->link(__('Buscar'), array('controller' => 'traslados', 'action' => 'buscar')); ?>
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
       <li><a href="#" id="acerca" rel="olo"> Acerca de</a></li>
       <li><a href="http://www.motril.es">Motril</a></li>
      </ul>
     </div>
     
     <div class="clear"></div>
     
    </div>
   </div>
   
   <div class="clear"></div>
   
  </div>
  
  <!-- Cuadro "Acerca de" -->
  <div style="display:none;" id="olo">
   <h2> Gestión Municipal de Cementerios (GMC) </h2>
   <p> Registro informatizado para la gestión de cementerios. </p>
   <p style="font-style:italic;"> LaBellotaSoft - Khabal 2012. </p>
  </div>
  
  <!-- Volcado de la consula SQL a la base de datos -->
  <?php echo $this->element('sql_dump'); ?>
  
 </body>
</html>
