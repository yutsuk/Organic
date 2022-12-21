<?php
    include 'navigation.php';
    include 'connection.php';

    $prodName = $_POST['prodName'];
    $selprod = "SELECT * FROM P_PRODUCT WHERE PRODUCTNAME LIKE '%$prodName%'";
    $sqlsel = oci_parse($connection, $selprod);
    oci_execute($sqlsel);
    var_dump($selprod);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Searched Product</title>
</head>
<body>  
<div class="container">
        <div class="traders">
            <h2>Traders:</h2>
            <div class="traderImg">
                <img src="Images/Fish.jpg" alt="">
                <img src="Images/Butcher.jpg" alt="">
                <img src="Images/Bakery.jpg" alt="">
                <img src="Images/Veg.jpg" alt="">
                <img src="Images/Fruit.jpg" alt="">
            </div>
        </div>
        <div class="products">
        <h3 id="pN">Products:</h3>
        <div class="prod">
        <?php
      while( $row = oci_fetch_array($sqlsel)){
        ?>
            <div class="product">
            
                <img src="Images/<?php echo $row['PRODUCTIMAGE']?>" alt="Product-Image" width="100%" height="367px">
                <div class="namePrice">
                    <h3> <?php echo $row['PRODUCTNAME'] ?> </h3>
                    <h3>$<?php echo $row['PRICE'] ?></h3>
                </div>
                <p><?php echo $row['DESCRIPTIONS'] ?></p>
                <div class="viewAddBtn">
                    <button class="AC"><a style="color: black; text-decoration:none" href="addtocart.php?PRODUCT_ID=<?php echo $row['PRODUCT_ID']; ?>">Add To Cart</a></button>
                    <button class="vP"><a style="color: black; text-decoration:none" href="ProductDetails.php?PRODUCT_ID=<?php echo $row['PRODUCT_ID']; ?>">View Product</a></button>
                </div>
               
                
                
            </div>
            
            <?php } ?>
            
        </div>

        
    </div>
    </div>
    <?php include 'footer.php' ?>
</body>
</html>