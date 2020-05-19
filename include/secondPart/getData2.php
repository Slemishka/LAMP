<?php
header("Content-Type: application/json");

$id = $_POST['id'];

$form = $_POST['form'];

$mainArray = [];
$mainArray['Path_Info'] = array();
$mainArray['End_Point'] = array();
$mainArray['Mid_Point'] = array();

$conn = new mysqli("localhost","group12","yelemeno","MicrowaveRadioSystem");

// Check connection
if ($conn->connect_error) {
    echo json_encode("Connection failed: " . $conn->connect_error);
}



//check which button was clicked:
if ($form == 1){
    $sql =  "SELECT * FROM Path_Info WHERE path_id = '$id'";

    $result = $conn->query($sql);
    if ($result->num_rows>0){
        while($row = $result->fetch_array()){
            array_push($mainArray['Path_Info'],$row);
        }
        echo json_encode($mainArray['Path_Info']);
    }else{
        echo '{"status":"failed:"}';
    }
    $conn->close();
}

if ($form == 2){
    $sql =  "SELECT * FROM End_Point WHERE end_point_path_id = '$id'";

    $result = $conn->query($sql);
    if ($result->num_rows>0){
        while($row = $result->fetch_array()){
            array_push($mainArray['End_Point'],$row);
        }
        echo json_encode($mainArray['End_Point']);
    }else{
        echo '{"status":"failed:"}';
    }
    $conn->close();

}
if ($form == 3){
    $sql =  "SELECT * FROM PhysicalFactors WHERE pf_path_id = '$id'";

    $result = $conn->query($sql);
    if ($result->num_rows>0){
        while($row = $result->fetch_array()){
            array_push($mainArray['Mid_Point'],$row);
        }
        echo json_encode($mainArray['Mid_Point']);
    }else{
        echo '{"status":"failed:"}';
    }
    $conn->close();

}












