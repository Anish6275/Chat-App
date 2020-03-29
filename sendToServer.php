<?php

include 'db_connect.php';

$msg = $_POST['text'];
$from = $_POST['org'];
$to = $_POST['dest'];
//date_default_timezone_set('Asia/Kolkata');


$sql = "INSERT INTO `message` (`Group_ID`, `originUID`, `destinationUID`, `time`, `chat`, `readORnot`)
         VALUES ('0', '{$from}', '{$to}', CURRENT_TIMESTAMP, '{$msg}', '1');";
mysqli_query($conn, $sql);
mysqli_close($conn);

?>