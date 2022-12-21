<?php
    session_start();
    include 'connection.php';
    $trader= $_SESSION['trader'];
    $z="";

                if(isset($_POST['submit'])) {
                    
                    $shopErr = $locErr = "";

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if(empty($_POST['shopName'])) {
                            $shopErr = "Shop Name is required";
                        }
                        if(empty($_POST['shopLocation'])){
                            $locErr = "Location is required";
                        }
                    }


                    if($locErr == ""  && $shopErr == ""){
                    $shopLocation= $_POST['shopLocation'];
                    $shopName = $_POST['shopName'];
                    $phonenumber = $_POST['phonenumber'];

                $idTrad = "SELECT TRADER_ID FROM T_TRADER WHERE USERNAME =" . "'{$_SESSION['trader']}'";
                $selTra = oci_parse($connection, $idTrad);
                oci_execute($selTra);
                $traderid = oci_fetch_assoc($selTra)['TRADER_ID'];

                
                $chShop = "SELECT COUNT(SHOP_ID) AS SUBCOUNT FROM T_TRADER,S_SHOP WHERE T_TRADER.TRADER_ID= S_SHOP.TRADER_ID AND USERNAME =" . "'{$_SESSION['trader']}'";
                
                $sqlShop = oci_parse($connection, $chShop);
                oci_execute($sqlShop);
                $shCheck = oci_fetch_assoc($sqlShop);
                if($shCheck['SUBCOUNT']<1){
                        $insShop= "INSERT INTO S_SHOP (SHOPNAME, SHOPLOCATION, TRADER_ID)
                    VALUES(  '$shopName', '$shopLocation', '$traderid')";   
                    $sql1 = oci_parse($connection, $insShop);
                    $result = oci_execute($sql1);
                    
                    echo '</br>';

                    if ($result) {
                     echo "New record created successfully";
                    } else {
                    echo "ERROR: Could not able to execute $sql1. " .'</br>';
                    }
                    }
                    else {
                        $z= "You already have a Shop";
                    }
                }
                
            }
                

                
            
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddShop</title>
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="CSS/login.css">
    <link rel="stylesheet" href="CSS/Registration.css">
    <style>
        .z{
            margin: 10px;
        }
        p{
            color: red;
        }
        
    </style>
</head>
<body> 
    <div class="container z">
    <h1>Add Shop Details</h1>
    <form action="" method="post">
        <input type="text" placeholder="Phone Number" name="phonenumber" id="datetime" !require>
        <br><br>

        <input type="text" placeholder="Shop Name" name="shopName" id="datetime" >
        <br>
        <?php 
        if(isset($shopErr)){
        echo "<p> $shopErr </p>" ;}
    ?>
        <br><br>
        <input type="text" placeholder="Shop Location" name="shopLocation" id="datetime" >
        <br>
        <?php 
        if(isset($locErr)){
        echo "<p> $locErr </p>" ;}
    ?>
        <br><br>
        <input type="submit" name="submit" value="Sign Up" placeholder="signup" id="signup">
        <br><br>
        <?php echo $z ?>
    </form>
    <a href="Trader.php">Go Back</a>
    </div>
    
</body>
</html>