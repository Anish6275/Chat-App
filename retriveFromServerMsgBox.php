<?php

    include 'db_connect.php';

    $uid = $_POST['user'];
    //$connn = $conn;
    function get_name($N){
        $sqlN = "SELECT name FROM `user_data` WHERE `uid` LIKE '{$N}'";
        global $conn;
        $resultN = mysqli_query($conn, $sqlN);
        $rowN = $resultN->fetch_assoc();
        return $rowN['name'];
    $res = "";    
    }

    $sql = "SELECT destinationUID, originUID FROM `message` WHERE `originUID` LIKE '{$uid}' OR `destinationUID` LIKE '{$uid}' ORDER BY `time` DESC;";
    $result = mysqli_query($conn, $sql);
    $sortedName = array();
    $finalList = array();
    $sortedMsg = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
                array_push($sortedName, $row["destinationUID"], $row["originUID"]);       
        }
        $finalList = array_diff((array_unique($sortedName)), array("{$uid}"));
        //print_r($finalList);
    //echo sizeof($finalList);
    $res = "";
    $l = 0;
    foreach($finalList as $curId){        
        foreach ($sortedMsg as $i => $value) {
            unset($sortedMsg[$i]);
        }
        if(!($curId == $uid)){
            //echo '00';
            $l++;
            
            $na = explode(' ', trim($curId));
            $res = "";
            $res = "<div id='chatbox_{$na[0]}' class='chat chatboxcontent active-chat' ";
            $res = $res . "data-chat='person_{$l}' client='{$na[0]}'>";
            // finding msg
            $sql = "SELECT MsgNo FROM `message` WHERE (`originUID` LIKE '{$curId}' AND `destinationUID` LIKE '{$uid}') OR (`originUID` LIKE '{$uid}' AND `destinationUID` LIKE '{$curId}') ORDER BY `MsgNo`;";
            if(mysqli_query($conn, $sql)){
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        //echo $row['MsgNo'];
                        array_push($sortedMsg, $row['MsgNo']);
                    }
                }
                // adding msg                
                foreach($sortedMsg as $msg){
                    //echo $msg . '<br>';
                    $sql = "SELECT * FROM `message` WHERE `MsgNo` LIKE '{$msg}'";
                    if(mysqli_query($conn, $sql)){
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result)>0) {
                            while($row = mysqli_fetch_assoc($result)){
                                echo $l . $na[0];
                                if($row['originUID']==$curId){
                                    $res = $res . "<div class='col-xs-12 p-b-10'>";
                                    $res = $res . "<div class='chat-image  profile-picture max-profile-picture'>";
                                    $res = $res . "<img alt='".get_name($curId)."' src='storage/user_image/Kritina.jpg' class='bg-theme'>";
                                    $res = $res . "</div><div class='chat-body'><div class='chat-text'>";
                                    $res = $res . "<h4>".get_name($curId)."</h4><p>{$row["chat"]}</p>";
                                    date_default_timezone_set('Asia/Kolkata');
                                    $date1 = strtotime($row['time']);  
                                    $date2 = strtotime(date_default_timezone_get());                                    
                                    $diff = abs($date2 - $date1);
                                    $years = floor($diff / (365*60*60*24));  
                                    $months = floor(($diff - $years * 365*60*60*24)/(30*60*60*24));  
                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
                                    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
                                    $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);  
                                    $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));  
                                    
                                    if($days > 0){ 
                                        $res = $res . "<b>{$days} day ago</b></div></div></div>";
                                    }else if($hours > 0){  
                                        $res = $res . "<b>{$hours} hour ago</b></div></div></div>";
                                    }else if($minutes > 0){  
                                        $res = $res . "<b>{$minutes} min ago</b></div></div></div>";
                                    }else
                                        $res = $res . "<b>Just Now</b></div></div></div>";  

                                }else{
                                    $res = $res . "<div class='col-xs-12 p-b-10 odd'>";
                                    $res = $res . "<div class='chat-image  profile-picture max-profile-picture'>";
                                    $res = $res . "<img alt='".get_name($uid)."' src='storage/user_image/Bylancer.jpg'>";
                                    $res = $res . "</div><div class='chat-body'><div class='chat-text'>";
                                    $res = $res . "<h4>".get_name($uid)."</h4><p>{$row['chat']}</p>";                                   
                                    date_default_timezone_set('Asia/Kolkata');
                                    $date1 = strtotime($row['time']);  
                                    $date2 = strtotime(date_default_timezone_get());                                    
                                    $diff = abs($date2 - $date1);
                                    $years = floor($diff / (365*60*60*24));  
                                    $months = floor(($diff - $years * 365*60*60*24)/(30*60*60*24));  
                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
                                    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
                                    $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);  
                                    $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));  
                                    
                                    if($days > 0){   
                                        $res = $res . "<b>{$days} day ago</b></div></div></div>";
                                    }else if($hours > 0){         
                                        $res = $res . "<b>{$hours} hour ago</b></div></div></div>";
                                    }else if($minutes > 0){       
                                        $res = $res . "<b>{$minutes} min ago</b></div></div></div>";
                                    }else
                                        $res = $res . "<b>Just Now</b></div></div></div>"; 
                                }
                            }
                            
                        }
                    }                        
                }
                $res = $res . "</div>";
        echo $res;
        }        
        
        }
    }
    
}
    
    
?>



