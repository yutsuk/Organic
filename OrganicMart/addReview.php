<?php
    include 'connection.php';
    session_start();
    
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    if(isset($_POST['addreview'])){
        
        $prod_id = $_POST['PRODUCT_ID'];
        $rating= $_POST['star'];
        $comment = $_POST['comment'];
        $date = date('y-m-d');
        $seluserId = "SELECT USER_ID FROM U_USER WHERE USERNAME= '{$_SESSION['customer']}'";
        $userparse = oci_parse($connection, $seluserId);
        $userexe = oci_execute($userparse);
        $fetchuserId= oci_fetch_assoc($userparse)['USER_ID'];
        

        $inscomment = "INSERT INTO R_REVIEW(REVIEWDESCRIPTION, REVIEWRATING, REVIEWDATE, USER_ID, PRODUCT_ID) VALUES ('$comment', '$rating',TO_DATE('$date', 'yyyy/mm/dd'), $fetchuserId, $prod_id)";
                    $sql2 = oci_parse($connection, $inscomment);
                    $result = oci_execute($sql2);

                    if ($result) {
                        echo "Your Review was added!";
                   } else {
                       echo "ERROR: Could not able to execute $sql2. " .'</br>';
                   }
        
    }
}
else {
    echo "<h1> You Need To Login First. <span style='color:grey;'>Redirecting...</span></h1>";
    header('Refresh: 4; URL=http://localhost/ORGANICMART/login.php');
    
} 
?>