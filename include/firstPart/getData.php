<?php
header("Content-Type: application/json");

$id = $_POST['id'];
$conn = mysqli_connect("localhost","group12","yelemeno","MicrowaveRadioSystem");
$mainArray = [];
$mainArray['Path_Info'] = array();
$mainArray['End_Point'] = array();
$mainArray['Mid_Point'] = array();

$result = mysqli_query($conn,"SELECT * FROM Path_Info WHERE path_id = '$id'");

while($row = mysqli_fetch_array($result)){
    array_push($mainArray['Path_Info'],$row);
}

$result = mysqli_query($conn,"SELECT * FROM End_Point WHERE end_point_path_id = '$id'");

while($row = mysqli_fetch_array($result)){
    array_push($mainArray['End_Point'],$row);
}

$result = mysqli_query($conn,"SELECT * FROM PhysicalFactors WHERE pf_path_id = '$id'");
while($row = mysqli_fetch_array($result)){
    array_push($mainArray['Mid_Point'],$row);
}


echo json_encode($mainArray);
?>