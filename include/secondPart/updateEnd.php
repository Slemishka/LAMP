<?php
header("Content-Type: application/json");
$array = json_decode(stripslashes($_POST['array']));

$conn = new mysqli("localhost","group12","yelemeno","MicrowaveRadioSystem");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}

$message = "";
if (empty($array)){
    $message = "You didn't edit anything";
}
for ($i=0;$i<count($array);$i++){

    $id = explode(',',$array[$i]->id);

    $cell = $id[1];//2:distanceFromStart 3:GroundHeight 4:antennaHeight 5:antenaCableType 6:antenaCableLength
    $value = $array[$i]->value;
    $dbId = $id[2];

    if ($cell == 2){
        $sql ="UPDATE End_Point SET distance_from_start = '$value' WHERE end_point_id = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" |Distance From Start updated '$value'| \r\n";
        }else{
            $message.=" |error updating Distance From Start| \r\n";
        }
    }elseif ($cell== 3){
        $sql ="UPDATE End_Point SET ground_height = '$value' WHERE end_point_id = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" |Ground Height updated '$value'| \r\n";
        }else{
            $message.=" |error updating Ground Height| \r\n";
        }
    }elseif ($cell== 4){
        $sql ="UPDATE End_Point SET antenna_height = '$value' WHERE end_point_id = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" |Antenna Height updated '$value'| \r\n";
        }else{
            $message.=" |error updating Antenna Height| \r\n";
        }
    }elseif ($cell== 5){
        $sql ="UPDATE End_Point SET antenna_cable_type = '$value' WHERE end_point_id = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" |Antenna cable height updated '$value'| \r\n";
        }else{
            $message.=" |error updating Antenna cable height| \r\n";
        }
    }elseif ($cell== 6){
        $sql ="UPDATE End_Point SET antenna_cable_length = '$value' WHERE end_point_id = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" |Antenna Cable Length updated '$value'| \r\n";
        }else{
            $message.=" |error updating Antenna Cable Length| \r\n";
        }
    }

}

echo json_encode(array("msg"=>$message));
