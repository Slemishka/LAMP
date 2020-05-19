<?php
$path = "./csv/";
//if clicked submit button
if (isset($_POST['submit'])){
    $conn = mysqli_connect("localhost","group12","yelemeno","MicrowaveRadioSystem");
    $result = mysqli_query($conn,"SELECT max(path_id) AS maxid FROM Path_Info");
    $row = mysqli_fetch_assoc($result);
    global $id;
    $id = $row['maxid']+1;

    //if file was uploaded
    if($_FILES['file']['name']){
        $extension = explode(".",$_FILES['file']['name']);
        if($extension[1]=='csv'){       //if it's a csv file then:
            move_uploaded_file($_FILES['file']['tmp_name'],$path.$id.".".$extension[1]);
            $message = "File got successfully uploaded";
            //read csv file:
            readCsv($path.$id.".".$extension[1]);

        }else{
            $message = "Please upload valid csv file";
        }
    }else{
        $message = "Please upload a file!";
    }
}

function readCsv($csv){
    $handle = fopen($csv,"r");

    $big_array = [];
    while($data = fgetcsv($handle,1000,",")){
        $big_array[]=$data;
    }

    uploadSql($big_array,$csv);
    fclose($csv);

}

function uploadSql($array,$path){
    $conn = mysqli_connect("localhost","group12","yelemeno","MicrowaveRadioSystem");
    for($i=0;$i<count($array);$i++){
        if ($i==0){
            $path_name = mysqli_real_escape_string($conn,$array[$i][0]);
            $operating_frequency = mysqli_real_escape_string($conn,$array[$i][1]);
            $description = mysqli_real_escape_string($conn,$array[$i][2]);
            $note = mysqli_real_escape_string($conn,$array[$i][3]);
            $filePath = $path;
            $query = "INSERT INTO Path_Info(path_name,operating_frequency,description,note,filePath)
                        values('$path_name','$operating_frequency','$description','$note','$filePath')";
            if(mysqli_query($conn,$query)){
                global $last_id;
                $last_id = $conn ->insert_id;
            }else{
                return;
            }

        }
        if ($i==1 || $i==2){
            $distance_from_start = mysqli_escape_string($conn,$array[$i][0]);
            $ground_height = mysqli_escape_string($conn,$array[$i][1]);
            $antenna_height = mysqli_escape_string($conn,$array[$i][2]);
            $antenna_cable_type = mysqli_escape_string($conn,$array[$i][3]);
            $antenna_cable_length = mysqli_escape_string($conn,$array[$i][4]);

            $query = "INSERT INTO End_Point
            (end_point_path_id,distance_from_start,ground_height,antenna_height,antenna_cable_type,antenna_cable_length)
            values('$last_id','$distance_from_start','$ground_height','$antenna_height','$antenna_cable_type','$antenna_cable_length')";
            if (!mysqli_query($conn,$query)){
                return;
            }
        }

        if ($i > 2){
            $distance_from_start = mysqli_escape_string($conn,$array[$i][0]);
            $ground_height = mysqli_escape_string($conn,$array[$i][1]);
            $terrain_type = mysqli_escape_string($conn,$array[$i][2]);
            $obstruction_height = mysqli_escape_string($conn,$array[$i][3]);
            $obsctruction_type = mysqli_escape_string($conn,$array[$i][4]);

            $query = "INSERT INTO PhysicalFactors
            (pf_path_id,distance_from_start,Ground_Height,Terrain_Type,Obstruction_Height,Obstruction_Type)
            values('$last_id','$distance_from_start','$ground_height','$terrain_type','$obstruction_height','$obsctruction_type')";

            if(!mysqli_query($conn,$query)){
                return;
            }
        }
        $_SESSION['allow'] = 'true';
    }
}
//validation doesn't work
function validate($array){
    print_r($array);
    for($i = 0;$i<count($array);$i++){
        if ($i=0){
            if (empty($array[$i][0])){
                echo $i."wrong0";
                return;
            }elseif (empty($array[$i][1]) || var_dump(is_float($array[$i][1])) == false){
                echo $i."wrong1";
                return;
            }elseif (empty($array[$i][2]) || strlen($array[$i][2])>255){
                echo $i."wrong2";
                return;
            }
        }elseif ($i=1 || $i=2){
            if (empty($array[$i][0])){
                echo $i."wrong0";
                return;
            }elseif (empty($array[$i][1]) || var_dump(is_float($array[$i][1])) == false){
                echo $i."wrong1";
                return;
            }elseif (empty($array[$i][2]) || var_dump(is_float($array[$i][2])) ==false){
                echo $i."wrong2";
                return;
            }elseif (empty($array[$i][3])){
                echo $i."wrong3";
                return;
            }elseif (empty($array[$i][4]) || var_dump(is_float($array[$i][4])) ==false){
                echo $i."wrong4";
                return;
            }
        }elseif ($i>2){
            if (empty($array[$i][0]) || var_dump(is_float($array[$i][0])) == false){
                echo $i."wrong0";
                return;
            }elseif (empty($array[$i][1]) || var_dump(is_float($array[$i][1])) == false){
                echo $i."wrong1";
                return;
            }elseif (empty($array[$i][2]) || strlen($array[$i][2])>50){
                echo $i."wrong2";
                return;
            }elseif (empty($array[$i][3]) || var_dump(is_float($array[$i][3])) == false){
                echo $i."wrong3";
                return;
            }elseif (empty($array[$i][4]) || strlen($array[$i][4])>50){
                return;
            }
        }
    }

}
?>
