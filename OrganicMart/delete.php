<?php
  session_start();
    include 'connection.php';


    $query = oci_parse($connection, "DELETE FROM P_PRODUCT WHERE PRODUCT_ID='" . $_GET['PRODUCT_ID'] . "'");
    $result = oci_execute($query);  
    if($result)  
    {  
      oci_commit($connection); //*** Commit Transaction ***// 
      header('LOCATION: Trader.php');
    }
    else{
      echo "Error.";
    }
    
?>