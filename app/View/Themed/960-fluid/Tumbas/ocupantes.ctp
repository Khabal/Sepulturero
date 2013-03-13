<?php
 if (empty($moridos)) {
  echo "La tumba de origen está vacía.";
 }
 else {
  $i = 0;
  foreach($moridos as $morido) {
   echo $this->Form->input('DifuntoMovimiento.'.$i.'.difunto_id', array('label' => $morido['label'], 'type' => 'checkbox', 'value' => $morido['value']));
   $i++;
  }
 }
?>
