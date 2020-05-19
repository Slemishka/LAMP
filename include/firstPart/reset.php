<?php
header("Content-Type: application/json");
$path = $_POST['path'];
$id = $_POST['id'];
$handle = fopen("../.".$path,"r");

$big_array = [];
while($data = fgetcsv($handle,1000,",")){
    $big_array[]=$data;
}

resetSql($big_array,$id);
function resetSql($array,$id)
{
    $conn = mysqli_connect("localhost", "group12", "yelemeno", "MicrowaveRadioSystem");
    // delete end points and mid points:
    $query = "DELETE FROM End_Point WHERE end_point_path_id = '$id'";
    if (!mysqli_query($conn, $query)) {
        echo '{"status":"fail"}';
        return;
    }
    $query ="DELETE FROM PhysicalFactors WHERE pf_path_id = '$id'";
    if (!mysqli_query($conn, $query)) {
        echo '{"status":"fail"}';
        return;
    }


    for ($i = 0; $i < count($array); $i++) {
        if ($i == 0) {
            $path_name = mysqli_real_escape_string($conn, $array[$i][0]);
            $operating_frequency = mysqli_real_escape_string($conn, $array[$i][1]);
            $description = mysqli_real_escape_string($conn, $array[$i][2]);
            $note = mysqli_real_escape_string($conn, $array[$i][3]);
            $query = "UPDATE Path_Info 
                        SET path_name='$path_name',
                            operating_frequency='$operating_frequency',
                            description='$description',
                            note='$note'
                        WHERE Path_id = '$id'
                        ";
            if (!mysqli_query($conn, $query)) {
                echo '{"status":"fail"}';
                return;
            }
        }
        if ($i == 1 || $i == 2) {
            $distance_from_start = mysqli_escape_string($conn, $array[$i][0]);
            $ground_height = mysqli_escape_string($conn, $array[$i][1]);
            $antenna_height = mysqli_escape_string($conn, $array[$i][2]);
            $antenna_cable_type = mysqli_escape_string($conn, $array[$i][3]);
            $antenna_cable_length = mysqli_escape_string($conn, $array[$i][4]);
            $query = "INSERT INTO End_Point
            (end_point_path_id,distance_from_start,ground_height,antenna_height,antenna_cable_type,antenna_cable_length)
            values('$id','$distance_from_start','$ground_height','$antenna_height','$antenna_cable_type','$antenna_cable_length')";

            if (!mysqli_query($conn, $query)) {
                echo '{"status":"fail"}';
                return;
            }
        }

        if ($i > 2) {
            $distance_from_start = mysqli_escape_string($conn, $array[$i][0]);
            $ground_height = mysqli_escape_string($conn, $array[$i][1]);
            $terrain_type = mysqli_escape_string($conn, $array[$i][2]);
            $obstruction_height = mysqli_escape_string($conn, $array[$i][3]);
            $obsctruction_type = mysqli_escape_string($conn, $array[$i][4]);


            $query = "INSERT INTO PhysicalFactors
            (pf_path_id,distance_from_start,Ground_Height,Terrain_Type,Obstruction_Height,Obstruction_Type)
            values('$id','$distance_from_start','$ground_height','$terrain_type','$obstruction_height','$obsctruction_type')";
            if (!mysqli_query($conn, $query)) {
                echo '{"status":"fail"}';
                return;
            }
        }
    }
    echo '{"status":"done"}';
}