<?php $connection = oci_connect('organic mart', 'Fineill12345', '//localhost/xe'); 
if (!$connection) {
   $m = oci_error();
   echo $m['message'], "\n";
   } 
    ?>