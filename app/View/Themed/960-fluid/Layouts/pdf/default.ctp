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
   echo $this->Html->css(array('general', 'cabeza', 'pie', 'jquery.simpledialog.0.1'));
   /* Archivos Javascript JQuery */
   echo $this->Html->script(array('jquery-1.3.2.min.js', 'jquery-ui.js', 'jquery-fluid16.js', 'jquery.simpledialog.0.1'));
   /* Copia de scripts */
   echo $scripts_for_layout;
  ?>
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
     
     </div>
     
     <div class="clear"></div>
     
    </div>
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
Los datos personales aquí guardados forman parte de un fichero titularidad del AYUNTAMIENTO DE MOTRIL cuya finalidad es la de mantener el registro de difuntos sepultados en el c ementerio municipal y el contacto con los arrendatarios. De acuerdo con la Ley Orgánica 15/1999, un arrendatario puede ejercitar sus derechos de acceso, rectificación, cancelación y, en su caso, oposición enviando una solicitud por escrito, acompañada de una fotocopia de su D.N.I. dirigida a AYUNTAMIENTO DE MOTRIL. PLAZA DE ESPAÑA Nº 1, 18600 MOTRIL (GRANADA).
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
