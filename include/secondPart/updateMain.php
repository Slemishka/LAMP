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

    $cell = $id[0];     // if cell is 2:OperatingFreq 3:description4:note
    $value = $array[$i]->value;
    $dbId = $id[1];

    if ($cell==2){
        $sql = "UPDATE Path_Info SET operating_frequency = '$value' WHERE path_id = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" |Operating Frequency updated '$value'| \r\n";
        }else{
            $message.=" |error updating Operating Frequency| \r\n";
        }
    }
    elseif ($cell==3){
        $sql ="UPDATE Path_Info SET Description = '$value' WHERE path_id = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" |Description updated '$value'| \r\n";
        }else{
            $message.=" |error updating Description| \r\n";
        }
    }elseif ($cell==4){
        $sql ="UPDATE Path_Info SET Note = '$value' WHERE path_id = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" |Note updated '$value'| \r\n";
        }else{
            $message.=" |error updating Note| \r\n";
        }
    }
}

echo json_encode(array("msg"=>$message));

/*
        $sql ="UPDATE SET = '$value' WHERE = '$dbId'";
        if($conn->query($sql)==true){
            $message.=" | updated '$dbId' '$value'| ";
        }else{
            $message.=" | error updating| ";
        }
*/
?>