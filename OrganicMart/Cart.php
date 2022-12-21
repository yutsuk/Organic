
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            padding: 50px;
            width: 70%;
            margin: auto auto;
        }
        .totalcheck {
            margin-top: 20px;
            width: 60%;
            margin: auto auto;
            display: flex;
            justify-content: space-between;
        }
        input[type=submit] {
            padding: 10px;
            background-color: #2A9D74;
            color: white;
            border: none;
        }

        #del {
            padding: 10px;
            border: none;
            background-color: #ba181b;
        }
        #del a {
            color: white;
        }
        #check {
            background-color: #FDD261;
            color: black;
        }
        #upd {
            background-color: #2A9D8F;
            padding: 10px;
            border: none;
        }
        #upd a {
            text-decoration: none;
            color: white;
        }
        
        
        td {
            padding: 10px;
        }
        th {
            padding: 10px;
        }
        img {
            width: 80px;
            height: 80px;
        }
    </style>
</head>
<body>
    <?php 
        include 'connection.php';
        include 'navigation.php';
        $cartempty="";
    ?>
    <?php if(empty($cart)){ 
        $cart = $_SESSION['cart'];
        ?>
    <h1 align:"center">Your Cart Items:</h1>
    <table class="table">
        <thead>
            <th>S.No</th>
            <th>Name</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total Price</th>
            <th>Update</th>
            <th>Delete</th>
        </thead>
        <tbody>
        <?php 
        //print_r($cart); 
        $sno = 1;
        $total = 0;
        foreach($cart as $key => $values) {
            $cartSql = "SELECT DISTINCT P_PRODUCT.*, quant
            FROM P_PRODUCT, C_CART, (
                SELECT P_PRODUCT.PRODUCT_ID PRODUCT_ID, sum(C_CART.QUANTITY) quant
                FROM P_PRODUCT, C_CART
                WHERE P_PRODUCT.PRODUCT_ID = C_CART.PRODUCT_ID
                GROUP BY P_PRODUCT.PRODUCT_ID 
            ) X
            WHERE X.PRODUCT_ID = P_PRODUCT.PRODUCT_ID AND X.PRODUCT_ID = $key
            ";
            $cartres = oci_parse($connection, $cartSql);
            oci_execute($cartres);
            $cartr = oci_fetch_assoc($cartres);

            
    ?>
            <form action="updateCart.php" method="post">
            <tr>
                <td>
                    <?php echo $sno++ ?>
                </td>
                <td>
                   <?php echo $cartr['PRODUCTNAME'] ?>
                </td>
                <td>
                    <img width="100px" height="100px" src="IMAGES/<?php echo $cartr['PRODUCTIMAGE'] ?>" alt="">
                </td>
                <td>
                    <input type="number" name="qtty" value="<?php echo $values['quantity']; ?>" min="1" max="20" placeholder="1">
                    <input type="hidden" name="PRODUCT_ID" id="z" value="<?php echo $key; ?>">
                </td>
                <td>
                <?php echo '$'. $cartr['PRICE'] ?>
                </td>
                <td>
                <?php echo $cartr['PRICE'] * $values['quantity']; ?>
                </td>
                <td>
                <button type="submit" name="upd" id="upd"> Update </button>
                </td>
                <td>
                <button type="submit" id="del"> <a href="deleteCart.php?PRODUCT_ID=<?php echo $key; ?>">Delete</a> </button>
                </td>
            </tr>
            </form>

            
                <?php $total = $total+ $cartr['PRICE'] * $values['quantity']?>
                <?php $_SESSION['total'] = $total ?>
            <?php } ?>
        </tbody>
    </table>
    <div class="totalcheck">
    <div class="total">
                <h3>Your Total:</h3>
                <p><?php echo '$'. $total; ?></p>
    </div>
    <div class="checkout">
    <button type="submit" name="submit" class="checkoutBtn"><a href="Checkout.php">Chekcout</a></button>
    </div>
    </div>
    <?php 
    
    } else {
        $cartempty = "Your Cart is empty!";
    }

    ?>
    <h1><?php if(isset($cartempty)) {
        echo $cartempty;
    }; ?></h1>
    

</body>
</html>