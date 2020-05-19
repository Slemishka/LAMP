<?php
function displayData(){
    $conn = mysqli_connect("localhost","group12","yelemeno","MicrowaveRadioSystem");
    $query = "SELECT * FROM Path_Info";
    $result = mysqli_query($conn,$query);

    echo    "<select name='path' id='path'>";
    echo        "<option selected disabled>--Select the Path--</option>";
        while($row = mysqli_fetch_array($result)){
            echo "<option id='$row[path_id]'>$row[path_name]</option>";
        }
    echo     "</select>";
}


?>
