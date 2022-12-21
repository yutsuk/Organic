<?php 
    include 'connection.php';
    
    if(isset($_GET['email']) && isset($_GET['v_code'])) {
        $querry = "SELECT * FROM U_USER WHERE email='$_GET[email]' AND vkey='$_GET[v_code]'";
        $result = oci_parse($connection, $querry);
        $row = oci_execute($result);
        $row = oci_fetch_array($result);
        if($result) {

            if(oci_num_rows($result) ==1) {
                $email_fetch = $row['EMAIL'];
                if($row['VERIFIED']== 0) {   
                    $update = "UPDATE U_USER SET verified = 1 WHERE email= '$email_fetch'";
                    $fe=oci_parse($connection, $update);
                    oci_execute($fe);
                    if($fe) {
                        echo '<script>alert("You are now verified")</script>';
                    }
                    else {
                        echo '<script>alert("Cannot run querry!")</script>';
                    }
                }
                else{
                    echo '<script>alert("User already registered")</script>';
                    

                }
            }
            
        }
    }

?>