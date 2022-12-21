<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/Registration.css">
    <link rel="stylesheet" href="CSS/homepage.css">
    <title>Registration </title>
    <style>
        p {
            color: red;
        }
    </style>
</head>

<body>
    <?php
    include 'navigation.php';
    include 'connection.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function sendMail($email, $v_code)
    {
        //Load Composer's autoloader
        require 'phpmailer/Exception.php';
        require 'phpmailer/PHPMailer.php';
        require 'phpmailer/SMTP.php';

        $mail = new PHPMailer(true);
        try {
            //Server settings                     //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'organicmart1z@gmail.com';                     //SMTP username
            $mail->Password   = 'Organicmart12345';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('organicmart1z@gmail.com', 'Organic Mart');
            $mail->addAddress($email);     //Add a recipient



            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Email Verification From Organic Mart';
            $mail->Body    = "Thanks for verification. Click the link bleow to verify.
            <a href='http://localhost/ORGANICMART/verify.php?email=$email&v_code=$v_code'>Verify</a></b>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    if (isset($_POST['submit'])) {

        //checking for errors//
        //
        //
        $userErr = $emailErr = $passErr  = $firstErr = $lastErr = "";
        $email = $usrName = $password = $firstname = $lastname = $birthdate = $phonenumber = $gender = "";
        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
        $passPattern = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/";


        //
        //if(isset($_POST['submit'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_POST['email'])) {
                $emailErr = "Email field is required!!";
            } else {
                $email = $_POST['email'];
                if (!preg_match($pattern, $email)) {
                    $emailErr = "Invalid email format";
                }
            }
            if (empty($_POST['firstname'])) {
                $firstErr = "First Name is required";
            }

            if (empty($_POST['lastname'])) {
                $lastErr = "Last Name is required";
            }

            if (empty($_POST['username'])) {
                $userErr = "Username is required";
            } else {
                $usrName = $_POST['username'];
                if (!preg_match("/^[a-zA-z]*$/", $usrName)) {
                    $userErr = "Only alphabets and spaces all0wed!!";
                }
            }

            if (empty($_POST['password'])) {
                $passErr = "Password is required";
            } else {
                $password = $_POST['password'];
                if (!preg_match($passPattern, $password)) {
                    $passErr = "Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters";
                }
            }
        }


        //
        //
        //If no error and form is empty.
        //
        //
        //

        if ($userErr == "" && $emailErr == "" && $passErr == "" && $lastErr == "" && $firstErr == "") {
            $username = $_POST["username"];
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passHash = password_hash($password, PASSWORD_DEFAULT);
            $birthdate = $_POST["birthdate"];
            $gender = $_POST["gender"];
            $usertype = $_POST["usertype"];

            $vkey = bin2hex(random_bytes(16));


            //
            //
            //
            //Insert into U_USER
            //
            //
            //
            $ins = "INSERT INTO U_USER (FIRSTNAME, LASTNAME, USERNAME, PASSW, EMAIL, BIRTHDATE, GENDER, USERTYPE, PHONENUMBER, vkey, verified)
                VALUES( '$firstname', '$lastname', '$username', '$passHash', '$email', TO_DATE('$birthdate', 'yyyy/mm/dd'), '$gender', '$usertype', '$phonenumber', '$vkey', '0')";
            $sql = oci_parse($connection, $ins);
            $result = oci_execute($sql);
            if ($result && sendMail($_POST['email'], $vkey)) {
                $success = "New record added successfully. Please Verify Your Account.";
            } else {
                echo "<p style='color:#ba181b;'>ERROR: Could not able to execute $sql. </p>" . '</br>';
            }




            //
            //IF usertype is Trader insert it in trader
            //
            //
            //
            if ($usertype == 'Trader') {
                $insTrader = "INSERT INTO T_TRADER (FIRSTNAME, LASTNAME, USERNAME, PASSW, EMAIL, BIRTHDATE, GENDER, USERTYPE, PHONENUMBER)
                    VALUES( '$firstname', '$lastname', '$username', '$passHash', '$email',TO_DATE('$birthdate', 'yyyy/mm/dd'), '$gender', '$usertype', '$phonenumber')";
                $sql2 = oci_parse($connection, $insTrader);
                $result = oci_execute($sql2);

                if ($result) {
                    echo ".";
                } else {
                    echo "ERROR: Could not able to execute $sql2. " . '</br>';
                }
            }
        }
    }

    ?>


    <div class="container">

        <?php
        if (isset($success)) {
            echo "<p style='background-color: #D9E6DB; padding:20px; color: black;'>$success</p>";
        }
        ?>
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
        <div class="forms">

            <div class="vl"></div>
            <div class="signup">
                <h3>Sign Up:</h3>
                <form action="" method="POST">
                    <input type="text" name="firstname" id="username" placeholder="First Name">
                    <br>
                    <?php
                    if (isset($firstErr)) {
                        echo "<p> $firstErr </p>";
                    }
                    ?>
                    <br><br>
                    <input type="text" name="lastname" id="username" placeholder="Last Name">
                    <br>
                    <?php
                    if (isset($lastErr)) {
                        echo "<p> $lastErr </p>";
                    }
                    ?>
                    <br><br>
                    <input type="text" name="email" id="username" placeholder="Email">
                    <br>
                    <?php
                    if (isset($emailErr)) {
                        echo "<p> $emailErr </p>";
                    }
                    ?>
                    <br><br>

                    <input type="text" name="username" id="username" placeholder="Username">
                    <br>
                    <?php
                    if (isset($userErr)) {
                        echo "<p> $userErr </p>";
                    }
                    ?>
                    <br><br>
                    <input type="password" name="password" id="username" placeholder="Password">
                    <br>
                    <?php
                    if (isset($passErr)) {
                        echo "<p> $passErr </p>";
                    }
                    ?>
                    <br><br>
                    <input type="date" name="birthdate" id="datetime" !require>
                    <br><br>
                    <label for="users">Male:</label>
                    <input type="radio" value="Male" name="gender" id="gender">
                    <label for="users">Female:</label>
                    <input type="radio" value="Female" name="gender" id="gender">
                    <br><br>
                    <label for="users">User Type:</label>
                    <select name="usertype" id="users">
                        <option value="Customer">Customer</option>
                        <option value="Trader">Trader</option>
                        <select>
                            <br><br>
                            <input type="submit" name="submit" value="Sign Up" placeholder="signup" id="signup">
                </form>
                <h3>Already Logged In?<a href="login.php">Login</a></h3>
            </div>

        </div>
    </div>
    <?php
    include 'footer.php';
    ?>
</body>

</html>