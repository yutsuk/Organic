<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/Login.css">
    <title>Login</title>
    <style>
        p {
            color: red;
        }
    </style>
</head>
<body>
    <?php
        include 'connection.php';
        
        include 'navigation.php';
        $message ="";
        $type = "";
        if(isset($_POST['login'])) {

            $userErr = $passErr = "";

            $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
            $passPattern="/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if(empty($_POST['username'])) {
                    $userErr = "Username is required";
                }else {
                    $usrName = $_POST['username'];
                    if(!preg_match ("/^[a-zA-z]*$/", $usrName)) {
                        $userErr = "Only alphabets and spaces all0wed!!";
                    }
                }
    
                if(empty($_POST['password'])) {
                    $passErr = "Password is required";
                }else {
                    $password = $_POST['password'];
                    if(!preg_match($passPattern,$password)) {
                        $passErr = "Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters";
    
                    }
                    
                }
            }
            if($userErr == ""  && $passErr == ""){
            $username = $_POST["username"];
            $password = $_POST["password"];

            
            $sel = "SELECT * FROM U_USER WHERE USERNAME='$username'";
            $sql = oci_parse($connection, $sel);
            oci_execute($sql);
            $row = oci_fetch_array($sql);
            if($row['VERIFIED']== 1){
            if(password_verify($password,$row["PASSW"])){
                if(oci_num_rows($sql)==1) {
                    echo $username;
                    $role = "SELECT USERTYPE FROM U_USER WHERE USERNAME='$username'";
                    $roles = oci_parse($connection, $role);
                    oci_execute($roles);
                    $row = oci_fetch_assoc($roles);
                    var_dump($row);
                    
                    if($row["USERTYPE"] == "Trader") {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['trader'] = $username;
                        header('Location:Trader.php');
                    }
                    else if($row["USERTYPE"] == "Customer") {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['customer'] = $username;
                        header('Location:index.php');
                    }
                    
                }
            }
            
            else{
                echo "Invalid Password";
            }
        }else{
            echo '
                <script>
                    alert("Please verify your email which is sent in gmail account");
                </script>
            ';
        }
    }
        
        }
        
    ?>
    <div class="signup">
                <h3>Sign Up:</h3>
                <form action="" method="POST">
                    <input type="text" name="username" id="username" placeholder="Username">
                    <br>
                    <?php 
        if(isset($userErr)){
        echo "<p> $userErr </p>" ;}
    ?>
                    <br><br>
                    <input type="password" name="password" id="username" placeholder="Password">
                    <br>
                    <?php 
        if(isset($passErr)){
        echo "<p> $passErr </p>" ;}
    ?>
                    <br><br>
          <input type="submit" name="login" value="Login" placeholder="Login" id="signup">
                </form>
                <h3>Create an account?<a href="Registration.php">Register</a></h3>
            </div>
            
        </div>
    </div>
    <?php
        include 'footer.php';
    ?>
</body>
</html>