<?php
include 'connection.php';
$cart = $_SESSION['cart'];


if (isset($_POST['submit'])) {

    $locErr ="";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (empty($_POST['firstname'])) {
            $locErr = "You need to enter Location";
        }
    }

    if ($locErr == ""){
    foreach($cart as $key => $value) {

        $cartSql = "SELECT * FROM P_PRODUCT WHERE PRODUCT_ID=$key";
        $cartres = oci_parse($connection, $cartSql);
        oci_execute($cartres);

        $cartr = oci_fetch_assoc($cartres);
        $productname = $cartr['PRODUCTNAME'];
        $qtty = $value['quantity'];

        $usrsql = "SELECT USER_ID FROM U_USER WHERE USERNAME= ". "'{$_SESSION['customer']}'";
        $usrres = oci_parse($connection, $usrsql);
        oci_execute($usrres);
        $row = oci_fetch_array($usrres);
        $id=$row['USER_ID'];

        $qtUpdate = "UPDATE P_PRODUCT SET STOCK = STOCK - {$value['quantity']} WHERE PRODUCT_ID = $key"; 
        $query = oci_parse($connection, $qtUpdate);

        $result = oci_execute($query);
        var_dump($result);
        if ($result) {
            oci_commit($connection);
            header('Location: Trader.php');
        } else {
            echo "Error.";
        }
    }
}


    $role = "SELECT ORDER_ID FROM O_ORDER WHERE USERNAME='{$_SESSION['customer']}'";
    $roles = oci_parse($connection, $role);
    oci_execute($roles);
    $row = oci_fetch_assoc($roles);



    $slotinfo = $_POST['slotinfo'];
    $location = $_POST['location'];

    $collinsert = "INSERT INTO C_COLLECTION_SLOT (SLOTINFO, ORDER_ID, SLOTLOCATION)
                    VALUES( '$slotinfo', '{$row['ORDER_ID']}', '$location')";
    $inscoll = oci_parse($connection, $collinsert);
    $result = oci_execute($inscoll);

    if ($result) {
        header('location: PayNow.php');
    } else {
        echo "ERROR: Could not able to execute $inscoll. " . '</br>';
    }





    foreach ($cart as $key => $values) {
        $cartSql = "SELECT * FROM P_PRODUCT WHERE PRODUCT_ID=$key";
        $cartres = oci_parse($connection, $cartSql);
        oci_execute($cartres);
        $cartr = oci_fetch_assoc($cartres);

        $proddetail = "Your Products are" . $cartr['PRODUCTNAME'];
    }

    $csot = "SELECT C_COLLECTIONSEQ.currval FROM dual";
    $colidSel = oci_parse($connection, $csot);
    oci_execute($colidSel);
    $colres = oci_fetch_assoc($colidSel);
    $cid = $colres['CURRVAL'];
    echo "</br>";



    $coldate = date('y-m-d');

    $cartid = $_SESSION['id'];
    $invoiceIns = "INSERT INTO I_INVOICE (USER_ID, COLLECTIONDATE, COLLECTIONLOCATION, TOTAL, PRODDETAIL, CART_ID, COLLECTION_ID) VALUES ($id, TO_DATE('$coldate', 'yyyy/mm/dd'), '$location', {$_SESSION['total']}, '$proddetail', $cartid, $cid)";
    var_dump($invoiceIns);

    $insinv = oci_parse($connection, $invoiceIns);
    $res = oci_execute($insinv);

    if ($res) {
        header('location: PayNow.php');
    } else {
        echo "ERROR: Could not able to execute $insinv. " . '</br>';
    }
}
