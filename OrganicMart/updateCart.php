<?php
    include 'connection.php';
    if(isset($_POST['upd'])) {
        $qtty = $_POST['qtty'];
        $PRODUCT_ID = $_POST['PRODUCT_ID'];
        $sql = "UPDATE C_CART SET QUANTITY= $qtty WHERE PRODUCT_ID = $PRODUCT_ID";
        $sqparse = oci_parse($connection, $sql);
        oci_execute($sqparse);

        
        header('Location: Cart.php');
    }
    

?>