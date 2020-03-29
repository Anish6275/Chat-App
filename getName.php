<?php
include 'db_connect.php';
$uid = $_POST['user'];


$sql = "SELECT * FROM `user_data` WHERE `uid` LIKE '{$uid}';";
$result = mysqli_query($conn, $sql);
$res = '';
if ($result->num_rows > 0) {
    $res = $row["name"];   
} else {
    //echo "0 results";
    echo $uid;
}
echo $res;
?>