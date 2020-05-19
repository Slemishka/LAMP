<?php
header("Content-Type: application/json");
session_start();
$id = $_POST['id'];

$ecf = $_POST['ecf'];

$mainArray = [];
$mainArray['Path_Info'] = array();
$mainArray['End_Point'] = array();
$mainArray['Mid_Point'] = array();

$conn = new mysqli("localhost","group12","yelemeno","MicrowaveRadioSystem");

// Check connection
if ($conn->connect_error) {
    echo json_encode("Connection failed: " . $conn->connect_error);
}

$sql =  "SELECT * FROM Path_Info WHERE path_id = '$id'";

$result = $conn->query($sql);
if ($result->num_rows>0){
    while($row = $result->fetch_array()){
        array_push($mainArray['Path_Info'],$row);
    }
}else{
    echo '{"status":"failed:"}';
}

$sql =  "SELECT * FROM End_Point WHERE end_point_path_id = '$id'";

$result = $conn->query($sql);
if ($result->num_rows>0){
    while($row = $result->fetch_array()){
        array_push($mainArray['End_Point'],$row);
    }
}else{
    echo '{"status":"failed:"}';
}

$sql =  "SELECT * FROM PhysicalFactors WHERE pf_path_id = '$id'";

$result = $conn->query($sql);
if ($result->num_rows>0){
    while($row = $result->fetch_array()){
        array_push($mainArray['Mid_Point'],$row);
    }
}else{
    echo '{"status":"failed:"}';
}
$conn->close();

$_SESSION['mainArray'] = $mainArray;
$_SESSION['ecf'] = $ecf;
include_once "calculate.php";