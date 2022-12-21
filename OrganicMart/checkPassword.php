<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<style>
    form {
        padding: 20px;
    }
    input {
        padding: 10px;
        margin: 10px;
    }
</style>
<body>
    
    <?php 
    session_start();
    include 'connection.php';
        
        
        $sel = "SELECT PASSW FROM U_USER WHERE USERNAME = '{$_SESSION['customer']}'";
            $sql = oci_parse($connection, $sel);
            $passE =oci_execute($sql);
            $rw=oci_fetch_assoc($sql);
            
    
            
                if(isset($_POST['submit'])) {
                    $epassword= $_POST['epassword'];
                    $npassword = $_POST['npassword'];
                    $passHash = password_hash($npassword, PASSWORD_DEFAULT);
                    if(password_verify($epassword,$rw["PASSW"])){
                        $trName= $_SESSION['customer'];
                        $updCat = "UPDATE U_USER SET PASSW= '$passHash' WHERE USERNAME='$trName'";
                        
                        $CatUpd = oci_parse($connection, $updCat );
                    
                    $catRes = oci_execute($CatUpd);  


                    if($catRes)  
                    {  
                        oci_commit($connection);
                        header('Location: index.php');
                    }
                    else{
                        echo "Error.";
                    }


                  
                        $updusr = "UPDATE T_TRADER SET PASSW= '$passHash' WHERE USERNAME='$trName'";
                        
                        $updtrpass = oci_parse($connection, $updusr );
                    
                    $tratRes = oci_execute($updtrpass);  


                    if($tratRes)  
                    {  
                        oci_commit($connection);
                        header('Location: index.php');
                    }
                    else{
                        echo "Error.";
                    }
                }  else {
                    echo "<br> Current password do not match!";
                } 
            }
    ?>
    <form action="" method="post">
        <label for="existing password">Your Existing Password</label>
        <input type="password" name="epassword" id="username">
        <label for="new password">New Password</label>
        <input type="password" name="npassword" id="username">
        <input type="submit" name="submit" value="Change Password" placeholder="signup" id="signup">
    </form>
    <br>
    <a href="userprofile.php">Go Back</a>
</body>
</html>