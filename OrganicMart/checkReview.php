<?php 
    session_start();
    include 'connection.php';
    $cart = $_SESSION['cart'];
    $total = $_SESSION['total'];

    if(isset($_POST['chkout'])) {
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

            
            $user_id=$row['USER_ID'];
            $ins = "INSERT INTO C_CART (PRODUCTNAME, QUANTITY, USER_ID, PRODUCT_ID)
            VALUES( '$productname', $qtty, $user_id, $key)";
            $sql = oci_parse($connection, $ins);
            $re = oci_execute($sql);    
            if( $re) {
                echo "success cart <br>";
            } else {
               echo "ERROR: Could not able to execute $sql. " .'</br>';
            }


            $cartSel = "SELECT C_CARTSEQ.currval FROM dual";
            $sqlSel = oci_parse($connection, $cartSel);
            oci_execute($sqlSel);
            $res = oci_fetch_assoc($sqlSel);
            $id= $res["CURRVAL"];
            var_dump($id);


            $_SESSION['id']=$id;

            $fullname = $_POST['fullname'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $location = $_POST['location'];
            $phonenumber = $_POST['phonenumber'];


            $ins = "INSERT INTO O_ORDER (FULLNAME, USERNAME, EMAIL, LOCATION, PHONENUMBER, PRODUCT_ID, TOTALPRICE, CART_ID)
            VALUES( '$fullname', '$username', '$email', '$location', $phonenumber,  $key, $total, $id)";
            $sql = oci_parse($connection, $ins);
            $re = oci_execute($sql);  
            if( $re) {
                header('location: collectionslot.php');
            } else {
               echo "ERROR: Could not able to execute $sql. " .'</br>';
               $ORDER_ID = $db->insert_id;
               $_SESSION['order_id'] = $ORDER_ID;
            }
        }
    }
 ?>