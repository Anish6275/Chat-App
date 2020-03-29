<?php
    include 'db_connect.php';
    $uid = $_POST['user'];
    $curId = $_POST['client'];
    $sqlN = "SELECT name, image, uid FROM `user_data` WHERE `uid` LIKE '{$curId}' OR `uid` LIKE '{$uid}'";
    $resultN = mysqli_query($conn, $sqlN);
    while($rowN = $resultN->fetch_assoc()){
        if($rowN['uid'] == $curId){
            $na = $row['name'];
            $img = $rowN['image'];
        }else{
            $una = $row['name'];
            $uimg = $rowN['image'];
        }
    }   
    $res = "<div id='chatbox_{$na}' class='chat chatboxcontent active-chat' ";
    $res = $res . "data-chat='person_{$_POST['index']}' client='{$na}'>";
    $res = "";
    $sortedMsg = array();
    $sql = "SELECT * FROM `message` WHERE (`originUID` LIKE '{$curId}' AND `destinationUID` LIKE '{$uid}') OR (`originUID` LIKE '{$uid}' AND `destinationUID` LIKE '{$curId}') ORDER BY `MsgNo`;";
    if(mysqli_query($conn, $sql)){
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row['originUID']==$curId){
                    $res = $res . "<div class='col-xs-12 p-b-10'>";
                    $res = $res . "<div class='chat-image  profile-picture max-profile-picture'>";
                    $res = $res . "<img alt='{$na}' src='{$img}' class='bg-theme'>";
                    $res = $res . "</div><div class='chat-body'><div class='chat-text'>";
                    $res = $res . "<h4>{$na}</h4><p>{$row["chat"]}</p>";
                    date_default_timezone_set('Asia/Kolkata');
                    $date1 = strtotime($row['time']);  
                    $date2 = strtotime(date_default_timezone_get());                                    
                    $diff = abs($date2 - $date1);
                    $years = floor($diff / (365*60*60*24));  
                    $months = floor(($diff - $years * 365*60*60*24)/(30*60*60*24));  
                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
                    $hours = (floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60))) - 9;  
                    $minutes = (floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60)) -570;  
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
                    $res = $res . "<img alt='{$una}' src='{$uimg}'>";
                    $res = $res . "</div><div class='chat-body'><div class='chat-text'>";
                    $res = $res . "<h4>{$una}</h4><p>{$row['chat']}</p>";                                   
                    date_default_timezone_set('Asia/Kolkata');
                    $date1 = strtotime($row['time']);  
                    $date2 = strtotime(date_default_timezone_get());                                    
                    $diff = abs($date2 - $date1);
                    $years = floor($diff / (365*60*60*24));  
                    $months = floor(($diff - $years * 365*60*60*24)/(30*60*60*24));  
                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
                    $hours = (floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60))) - 9;  
                    $minutes = (floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60)) - 570;  
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
        $res = $res . "</div>";
        echo $res; 
    }  
?>



