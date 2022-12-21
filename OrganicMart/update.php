<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/Registration.css">
    <link rel="stylesheet" href="CSS/homepage.css">
    <title>Add Product</title>
</head>

<body>
    <?php
    include 'connection.php';
    include 'navigation.php';



    if (count($_POST) > 0) {
        $file_name = $_FILES['prodImg']['name'];
        $file_tmp = $_FILES['prodImg']['tmp_name'];
        $file_store = "Images/".$file_name;
        var_dump($file_store);
        move_uploaded_file($file_tmp, $file_store);
        $updprod = "UPDATE P_PRODUCT SET PRODUCTNAME='" . $_POST['prodName'] . "', DESCRIPTIONS='" . $_POST['prodDesc'] . "', PRODUCTIMAGE='" . $file_name . "' , ALLERGYINFORMATION='" . $_POST['allergyInfo'] . "', STOCK='" . $_POST['stock'] . "' , PRICE='" . $_POST['price']  . "', OFFERPRICE='" . $_POST['offer'] . "', CATAGORYTYPE='" . $_POST['vnf'] . "' WHERE PRODUCT_ID='" . $_GET['PRODUCT_ID'] . "'";
        

        $query = oci_parse($connection, $updprod);

        $result = oci_execute($query);
        var_dump($result);
        if ($result) {
            oci_commit($connection);
            header('Location: Trader.php');
        } else {
            echo "Error.";
        }
    }



    $query = "SELECT * FROM P_PRODUCT WHERE PRODUCT_ID='" . $_GET['PRODUCT_ID'] . "'";
    $result = oci_parse($connection, $query);
    oci_execute($result);
    $row = oci_fetch_array($result);


    ?>
    <div class="forms">
        <div class="signup">
            <h3>Add A Product:</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="prodName" id="username" placeholder="Product Name" value="<?php echo $row['PRODUCTNAME']; ?>">
                <br>
                <?php if (isset($nameErr)) {
                    echo "<p> $nameErr </p>";
                } ?>
                <br><br>
                <textarea rows="4" cols="50" name="prodDesc" id="username" value="<?php echo $row['DESCRIPTIONS']; ?>">Product Information</textarea>
                <br>
                <?php if (isset($desErr)) {
                    echo "<p> $desErr </p>";
                } ?>
                <br><br>
                <input type="file" id="username" name="prodImg" value="<?php echo $row['PRODUCTIMAGE']; ?>">
                <br>
                <?php if (isset($imageErr)) {
                    echo "<p> $imageErr </p>";
                } ?>
                <br><br>

                <textarea rows="4" cols="50" name="allergyInfo" id="username" value="<?php echo $row['ALLERGYINFORMATION']; ?>">Allergy Information</textarea>
                <br>
                <?php if (isset($allergyErr)) {
                    echo "<p> $allergyErr </p>";
                } ?>
                <br><br>
                <input type="number" name="stock" id="username" placeholder="Stock" value="<?php echo $row['STOCK']; ?>">
                <br>
                <?php if (isset($stockErr)) {
                    echo "<p> $stockErr </p>";
                } ?>
                <br><br>
                <input placeholder="Price" type="number" name="price" id="username" !require value="<?php echo $row['PRICE']; ?>">
                <br><br>
                <input placeholder="Discount" type="number" name="offer" id="username" !require value="<?php echo $row['OFFERPRICE']; ?>">
                <br>
                <?php if (isset($priceErr)) {
                    echo "<p> $priceErr </p>";
                } ?>
                <br><br>
                <label for="users">Product Category:</label>
                <select name="vnf" id="users" value="<?php echo $row['CATAGORYTYPE']; ?>">
                    <option value="Veg" <?php if ($row['CATAGORYTYPE'] == 'Veg') {
                                            echo 'selected';
                                        } ?>>Veg</option>
                    <option value="Non-Veg" <?php if ($row['CATAGORYTYPE'] == 'Non-Veg') {
                                                echo 'selected';
                                            } ?>>Non-Veg</option>
                    <option value="Fruit" <?php if ($row['CATAGORYTYPE'] == 'Fruit') {
                                                echo 'selected';
                                            } ?>>Fruits</option>
                    <select>
                        <br><br>
                        <input type="submit" name="Add" value="Add" placeholder="Add" id="signup">
            </form>
            <a style="margin-top:60px;" href="Trader.php">Go Back</a>
        </div>

    </div>

    <?php include 'footer.php'; ?>
</body>

</html>