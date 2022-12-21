<?php

include 'connection.php';

$selprod = "SELECT * FROM P_PRODUCT";
$sqlsel = oci_parse($connection, $selprod);
oci_execute($sqlsel);

//catagory filter

if (isset($_POST['submit'])) {
    $CATAGORYTYPE = $_POST['vnf'];

    $catProd = "SELECT * FROM P_PRODUCT WHERE CATAGORYTYPE= '$CATAGORYTYPE'";
    $catsql = oci_parse($connection, $catProd);
    oci_execute($catsql);
    $sqlsel = $catsql;
}
if (isset($_POST['Price'])) {
    $CATAGORYTYPE = $_POST['vnf'];
    $procProd = "SELECT * FROM P_PRODUCT WHERE CATAGORYTYPE= '$CATAGORYTYPE' ORDER BY PRICE ASC";
    $catPrice = oci_parse($connection, $procProd);
    oci_execute($catPrice);
    $sqlsel = $catPrice;
}

if (isset($_POST['Rating'])) {
    $revProd = "SELECT DISTINCT P_PRODUCT.*, average
    FROM P_PRODUCT, R_REVIEW, (
        SELECT P_PRODUCT.PRODUCT_ID PRODUCT_ID, avg(R_REVIEW.REVIEWRATING) average
        FROM P_PRODUCT, R_REVIEW
        WHERE P_PRODUCT.PRODUCT_ID = R_REVIEW.PRODUCT_ID
        GROUP BY P_PRODUCT.PRODUCT_ID 
    ) X
    WHERE X.PRODUCT_ID = P_PRODUCT.PRODUCT_ID 
    ORDER BY average asc
    ";
    $catReview = oci_parse($connection, $revProd);
    oci_execute($catReview);
    $sqlsel = $catReview;
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="CSS/Product.css">
    <title>All products</title>
</head>

<body>
    <?php
    include 'navigation.php';
    ?>
    <div class="filters">
        <form action="" method="post">
            <div class="catg">
                <h3>Filter:</h3>

                <select style="margin-left: 20px;" name="vnf" id="users" aria-placeholder="Filters">
                    <option value="Veg">Veg</option>
                    <option value="Non-Veg">Non-Veg</option>
                    <option value="Fruit">Fruit</option>
                    <select>
                        <input type="radio" name="Price""> <label for=" price">Price(low-high)</label>
                        <input type="radio" name="Rating"> <label for="rating">Rating</label>
                        <input style="margin-left:10px; background-color:#2A9D74; border:none; padding:15px; color:white;" type="submit" name="submit" id="username" value="Filter">

            </div>
        </form>
    </div>
    <form action="addtocart.php" method="get">
        <div class="products">
            <h3 id="pN">Products:</h3>
            <div class="prod">
                <?php
                while ($filter = oci_fetch_array($sqlsel)) {

                ?>
                    <div class="product">

                        <img src="Images/<?php echo $filter['PRODUCTIMAGE'] ?>" alt="Product-Image" width="100%" height="367px">
                        <div class="namePrice">
                            <h3> <?php echo $filter['PRODUCTNAME'] ?> </h3>
                            <h3>$<?php echo $filter['PRICE'] ?></h3>
                        </div>
                        <p><?php echo $filter['DESCRIPTIONS'] ?></p>
                        <div class="viewAddBtn">
                            <button class="AC"><a style="color: black; text-decoration:none" href="addtocart.php?PRODUCT_ID=<?php echo $filter['PRODUCT_ID']; ?>">Add To Cart</a></button>
                            <button class="vP"><a style="color: black; text-decoration:none" href="ProductDetails.php?PRODUCT_ID=<?php echo $filter['PRODUCT_ID']; ?>">View Product</a></button>
                        </div>



                    </div>

                <?php } ?>

            </div>


        </div>
    </form>
    <?php
    include 'footer.php';
    ?>
</body>

</html>