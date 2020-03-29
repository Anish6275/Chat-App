<?php
include 'db_connect.php';
$uid = $_POST['uid'];
$cid = $_POST['cid'];
$sql = "UPDATE `message` SET `readORnot`='0' WHERE `originUID` = '{$cid}' and `destinationUID` = '{$uid}' ;";
mysqli_query($conn, $sql);
?>