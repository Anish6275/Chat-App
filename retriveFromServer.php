<?php
    include 'db_connect.php';
    $uid = $_POST['user'];
    $sql = "SELECT destinationUID, originUID FROM `message` WHERE `originUID` LIKE '{$uid}' OR `destinationUID` LIKE '{$uid}' ORDER BY `time` DESC;";
    $result = mysqli_query($conn, $sql);
    $sortedName = array();
    $finalList = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
                array_push($sortedName, $row["destinationUID"], $row["originUID"]);       
        }
        $finalList = array_diff((array_unique($sortedName)), array("{$uid}"));
    }
    $res = "";
    $l = 0;
    foreach($finalList as $curId){
        if(!($curId == $uid)){
            $l++;
            $sql1 = "SELECT SUM(readORnot) FROM `message` WHERE `originUID` LIKE '{$curId}' AND `destinationUID` LIKE '{$uid}';";
            if(mysqli_query($conn, $sql1)){
                $cResult = (mysqli_query($conn, $sql1));
                if($cResult->num_rows > 0){
                $countResult = $cResult->fetch_assoc()['SUM(readORnot)'];
                }
            }else{ $countResult = 0;}
            $sql2 = "SELECT * FROM `user_data` WHERE `uid` LIKE '{$curId}';";            
            $result = mysqli_query($conn, $sql2)->fetch_assoc();
            $na = explode(' ', trim($result['name']));
            $res = $res ."<li class='person chatboxhead active' id='chatbox1_{$na[0]}' ";
            $res = $res . "data-chat='person_{$l}' href='javascript:void(0)' ";
            $res = $res . 'onclick="'."runFunctionMb('$curId', '{$l}'); clear('{$curId}', '{$uid}');setNm('{$na[0]}'); chatWith('".$na[0]."','".$curId."','".$uid."','" .$l."','ghhj','Online')".'">';
            $res = $res . " <a href='javascript:void(0)'>";
            $res = $res . "<span class='userimage profile-picture min-profile-picture'>";
            $res = $res . "<img src='{$result['image']}' alt='{$na[0]}'";
            $res = $res . "class='avatar-image is-loaded bg-theme' width='100%'></span>";
            $res = $res . "<span><span class='bname personName'>{$na[0]}</span>";
            $res = $res . "<span class='personStatus'></span></span>";
            if($countResult > 0){
                $res = $res . "<span class='count'><span class='icon-meta unread-count'>".$countResult."</span></span>";
            }$res = $res . "<br></span></a></li>";
        }
    }    
    echo $res;
?>