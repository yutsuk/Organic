<?php
include 'connection.php';
$sel = "SELECT * FROM O_ORDER";
$sql = oci_parse($connection, $sel);
oci_execute($sql);
while($row = oci_fetch_array($sql)){
?>

<?php echo "<p>INSERT INTO O_ORDER VALUES("."{$row['ORDER_ID']}" . ", ". "'{$row['FULLNAME']}'"  . ", ". "'{$row['USERNAME']}'" . ", ". "'{$row['EMAIL']}'" . ", ". "'{$row['LOCATION']}'" . ", ". "{$row['PHONENUMBER']}" . ", ". "{$row['PRODUCT_ID']}" . ", ". $row['TOTALPRICE'] . ", ". "{$row['CART_ID']}" . ");</p>"   ?>
<?php }; ?>
