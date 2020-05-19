<?php
session_start();

$pathInfo = $_SESSION['mainArray']['Path_Info'];
$endPoint = $_SESSION['mainArray']['End_Point'];
$midPoint = $_SESSION['mainArray']['Mid_Point'];

$ecf = $_SESSION['ecf'];


//$D is the total length of the path in km;
$D = $endPoint[1][2];
$fGHz = $pathInfo[0][2];


for ($x = 0; $x < count($midPoint);$x++){

    $cur = $midPoint[$x];
    $d1 = $cur[2];
    $d2 = $D - $d1;

    //h:
    $h = null;
    if ($ecf == 4){
        $h = round(($d1*$d2)/17,4);
    }elseif ($ecf == 1){
        $h = round(($d1*$d2)/12.75,4);
    }elseif ($ecf == 2){
        $h = round(($d1*$d2)/8.5,4);
    }elseif ($ecf == "i"){
        $h = 0;
    }
    //h Done

    //apparent ground height
    $groundHeight = $cur[3];
    $obstructionHeight = $cur[5];
    $appGroundHeight = $groundHeight + $obstructionHeight + $h;
    // apparent ground height DONE

    //First Frenzel Zone

    $F1 = round(17.3*sqrt(($d1*$d2)/($fGHz*$D)),4);
    //First Frenzel Zone DONE

    //total clearance height
    $totalClHeight = round($appGroundHeight + $F1,4);
    //total clearance height DONE

    //Path Loss
    $pathLoss = round(92.4 + 20*log10($fGHz)+20*log10($D),1);
    //Path Loss Done


    $midPoint[$x][7] = $midPoint[$x]['curvature_height'] =  $h;
    $midPoint[$x][8] = $midPoint[$x]['apparent_Ground_Height'] = $appGroundHeight;
    $midPoint[$x][9] = $midPoint[$x]['First_Freznel_Zone'] = $F1;
    $midPoint[$x][10] = $midPoint[$x]['Total_Clearance_Height'] = $totalClHeight;
    $midPoint[$x][11] = $midPoint[$x]['Path_Loss'] = $pathLoss;
}
$midPoint[0][12] = $endPoint[0][3]+$endPoint[0][4];
$midPoint[0][13] = $endPoint[1][3]+$endPoint[1][4];
echo json_encode($midPoint);