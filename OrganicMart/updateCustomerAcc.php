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
        
        $updprod = "UPDATE U_USER SET FIRSTNAME='" . $_POST['FIRSTNAME'] . "', EMAIL='" . $_POST['EMAIL'] . "', USERNAME='" . $_POST['USERNAME'] . "', GENDER='" . $_POST['GENDER'] . "' , DATE='" . $_POST['DATE']  . "' WHERE USERNAME='" . $_SESSION['customer'] . "'";
        

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



    $query = "SELECT * FROM U_USER WHERE USERNAME='" . $_SESSION['customer'] . "'";
    $result = oci_parse($connection, $query);
    oci_execute($result);
    $row = oci_fetch_array($result);


    ?>
    <div class="forms">
        <div class="signup">
            <h3>Add A Product:</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="firstname" id="username" placeholder="Product Name" value="<?php echo $row['firstname']; ?>">
                <br>
                <?php if (isset($nameErr)) {
                    echo "<p> $nameErr </p>";
                } ?>
                <br><br>
                <input name="email" id="username" value="<?php echo $row['email']; ?>"
                <br>
                <?php if (isset($desErr)) {
                    echo "<p> $desErr </p>";
                } ?>
                <br><br>

                <textarea rows="4" cols="50" name="username" id="username" value="<?php echo $row['username']; ?>">Allergy Information</textarea>
                <br>
                <?php if (isset($allergyErr)) {
                    echo "<p> $allergyErr </p>";
                } ?>
                <br><br>
                <input type="submit" name="Add" value="Add" placeholder="Add" id="signup">
            </form>
            <a style="margin-top:60px;" href="Trader.php">Go Back</a>
        </div>

    </div>

    <?php include 'footer.php'; ?>
</body>

</html>