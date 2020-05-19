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

    $cell = $id[1]; //2:distFromStart 3:groundHeight 4:terrainType 5:obstrHeight 6:obstrType
    $value = $array[$i]->value;
    $dbId = $id[2];

    if ($cell == 2){
        $sql ="UPDATE PhysicalFactors SET distance_from_start  = '$value' WHERE physical_factor_id = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" |distance_from_start updated '$value'| \r\n";
        }else{
            $message.=" |error updating distance_from_start| \r\n";
        }
    }elseif ($cell== 3){
        $sql ="UPDATE PhysicalFactors SET Ground_Height = '$value' WHERE physical_factor_id = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" |Ground_Height updated '$value'| \r\n";
        }else{
            $message.=" |error updating Ground_Height| \r\n";
        }
    }elseif ($cell== 4){
        $sql ="UPDATE PhysicalFactors SET Terrain_Type = '$value' WHERE physical_factor_id = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" |Terrain_Type updated '$value'| \r\n";
        }else{
            $message.=" |error updating Terrain_Type| \r\n";
        }
    }elseif ($cell== 5){
        $sql ="UPDATE PhysicalFactors SET Obstruction_Height = '$value' WHERE physical_factor_id = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" |Obstruction_Height updated '$value'| \r\n";
        }else{
            $message.=" |error updating Obstruction_Height| \r\n";
        }
    }elseif ($cell== 6){
        $sql ="UPDATE PhysicalFactors SET Obstruction_Type = '$value' WHERE physical_factor_id = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" |Obstruction_Type updated '$value'| \r\n";
        }else{
            $message.=" |error updating Obstruction_Type| \r\n";
        }
    }

}

echo json_encode(array("msg"=>$message));
