<?php
 if (empty($moridos)) {
  echo "La tumba de origen está vacía.";
  //echo $this->Form->input('DifuntoTraslado.0.difunto_id', array('type' => 'hidden', 'value' => ''));
 }
 else {
  $i = 0;
  foreach($moridos as $morido) {
   echo $this->Form->input('DifuntoTraslado.'.$i.'.difunto_id', array('label' => $morido['label'], 'type' => 'checkbox', 'value' => $morido['value']));
   $i++;
  }
 }
?>
