<?php
include 'connection.php';
include 'navigation.php';
$selprod = "SELECT * FROM P_PRODUCT WHERE PRODUCT_ID = '{$_GET['PRODUCT_ID']}'";
$sqlsel = oci_parse($connection, $selprod);
$prodIdexe = oci_execute($sqlsel);
$row = oci_fetch_array($sqlsel);

$selreview = "SELECT * FROM R_REVIEW WHERE ROWNUM <= 5 AND PRODUCT_ID = '{$_GET['PRODUCT_ID']}'";
$userparse = oci_parse($connection, $selreview);
$userexe = oci_execute($userparse);


$avgreview = "SELECT AVG(REVIEWRATING) FROM R_REVIEW WHERE PRODUCT_ID='{$_GET['PRODUCT_ID']}'";
$revavg = oci_parse($connection, $avgreview);
$usrexe = oci_execute($revavg);
$revfetch = oci_fetch_assoc($revavg);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/ProductDetails.css">
    <link rel="stylesheet" href="CSS/homepage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">
    <title>Organic Mart</title>
</head>

<body>
    <div class="container">
        <form action="addtocart.php" method="get">
            <div class="singleProduct">
                <?php

                ?>
                <img src="Images/<?php echo $row['PRODUCTIMAGE'] ?>" alt="single-product" width="500px" height="500px">
                <div class="single">

                    <div class="namePrice">
                        <h3><?php echo $row['PRODUCTNAME'] ?></h3>
                        <h3>$<?php echo $row['PRICE'] ?></h3>
                    </div>
                    <p>by <a href="#trader">Trader Name</a></p>
                    <div class="quantityRating">
                        <input type="hidden" name="PRODUCT_ID" value="<?php echo $row['PRODUCT_ID'] ?>">
                        <input type="number" name="qtty" min="1" max="20" placeholder="1">
                        <div class="rating">

                            <input <?php if ($revfetch['AVG(REVIEWRATING)'] == 5) {
                                        echo 'checked';
                                    } ?> type="radio" name="star" class="r1" id="star1"><label for="star1"></label>
                            <input <?php if ($revfetch['AVG(REVIEWRATING)'] == 4) {
                                        echo 'checked';
                                    } ?> type="radio" class="r1" name="star" id="star2"><label for="star2"></label>
                            <input <?php if ($revfetch['AVG(REVIEWRATING)'] == 3) {
                                        echo 'checked';
                                    } ?> type="radio" class="r1" name="star" id="star3"><label for="star3"></label>
                            <input <?php if ($revfetch['AVG(REVIEWRATING)'] == 2) {
                                        echo 'checked';
                                    } ?> type="radio" class="r1" name="star" id="star4"><label for="star4"></label>
                            <input <?php if ($revfetch['AVG(REVIEWRATING)'] == 1) {
                                        echo 'checked';
                                    } ?> type="radio" class="r1" name="star" id="star5"><label for="star5"></label>
                        </div>
                    </div>
                    <h3 class="des">Description:</h3>
                    <p><?php echo $row['DESCRIPTIONS'] ?>
                    </p>
                    <input type="submit" name="addtocart" class="cart" value="Add To Cart">

                </div>
            </div>
        </form>

        <h2>Allergy Information:</h2>
        <p><?php echo $row['ALLERGYINFORMATION'] ?></p>



        <div class="reviews">
            <h4>Reviews</h4>
            <form action="addReview.php" method="post">
                <textarea rows="4" cols="50" name="comment" id="username" placeholder="Add a review"></textarea>
                <div class="ratings">
                    if
                    <input type="radio" name="star" id="star6" value="5"><label for="star6"></label>
                    <input type="radio" name="star" id="star7" value="4"><label for="star7"></label>
                    <input type="radio" name="star" id="star8" value="3"><label for="star8"></label>
                    <input type="radio" name="star" id="star9" value="2"><label for="star9"></label>
                    <input type="radio" name="star" id="star10" value="1"><label for="star10"></label>
                </div>
                <input type="hidden" name="PRODUCT_ID" value="<?php echo $_GET['PRODUCT_ID'] ?>">
                <input type="submit" name="addreview" value="Add a review" id="review">

            </form>
            <div class="usrdate" style="display: flex; justify-content: space-between;">
                <?php while ($fetchuserId = oci_fetch_assoc($userparse)) { ?>
                    <h4>Username</h4>
                    <p style="color:grey"><?php echo $fetchuserId['REVIEWDATE'] ?></p>
            </div>

            <p><?php echo $fetchuserId['REVIEWDESCRIPTION'] ?></p>
        <?php }; ?>
        </div>

    </div>

    <?php include 'footer.php' ?>
</body>

</html>