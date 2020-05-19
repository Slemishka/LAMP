<?php
session_start();
$_SESSION['allow'] = 'false';
include "include/firstPart/openFile.php";
include "include/firstPart/displayData.php";
?>
<html lang="EN">
<head>
    <title>Lamp2GroupProject</title>
    <link rel="stylesheet" href="js/chartist/dist/chartist.min.css">

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="js/chartist/dist/chartist.min.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/secondPart.js"></script>
    <script src="js/thirdPart.js"></script>
    <style>
        th,td {
            border: 1px solid black;
        }
        .ct-series-b .ct-line, .ct-series-b .ct-point{
            stroke: blue;
        }
        .dot{
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
        }
    </style>
</head>
<body>

<h1>Import your CSV file</h1>
<h1><?php echo $message?></h1>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" name="submit" value="import">
</form>
<?php
    if ($_SESSION['allow']=='true'){
        displayData();
    }
?>
<div id="tables" hidden>
    <div id="mainTables">
        <br><br><br>
        <input type="button" id="resetBtn" value="Reset">
        <br><br><br>
        <h3>Path Info</h3>
        <table id="t1" style="border:1px solid black;display:inline-block">
            <tr class="tHeading">
                <th>Path Name:</th>
                <th>Operating Frequency</th>
                <th>Description</th>
                <th>Note</th>
            </tr>
        </table>
        <input type="button" id="editPath" value="Edit Path Info">

    <!--    Edit    -->
        <div id="formPath">
            <form id="editForm" action="#">
                <table id="editFormTable" style="border:1px solid black">
                    <tr class="tHeading">
                        <th>Path Name:</th>
                        <th>Operating Frequency</th>
                        <th>Description</th>
                        <th>Note</th>
                    </tr>
                </table>
                <input type="submit" value="submit" name="submit">
                <input type="button" value="cancel" id="cancel">
            </form>
        </div>


        <h3>Path End Points:</h3>
        <table id="t2" style="border:1px solid black;display:inline-block">
            <tr class="tHeading">
                <th>Distance From Start</th>
                <th>Ground Height</th>
                <th>Antenna Height</th>
                <th>Antenna Cable Type</th>
                <th>Antenna Cable Length</th>
            </tr>
        </table>
        <input type="button" id="editPathEnd" value="Edit Path End Info">
    <!--  Edit  -->
        <div id="formPathEnd">
            <form action="#" id="editFormEnd" >
                <table id="editFormEndTable" style="border:1px solid black">
                    <tr class="tHeading">
                        <th>Distance From Start</th>
                        <th>Ground Height</th>
                        <th>Antenna Height</th>
                        <th>Antenna Cable Type</th>
                        <th>Antenna Cable Length</th>
                    </tr>
                </table>
                <input type="submit" value="submit" name="submit">
                <input type="button" value="cancel" id="cancelEnd">
            </form>
        </div>

        <h3>Path Mid Points:</h3>
        <table id="t3" style="border:1px solid black;display:inline-block">
            <tr class="tHeading">
                <th>Distance From Start</th>
                <th>Ground Height</th>
                <th>Terrain Type</th>
                <th>Obstruction Height</th>
                <th>Obstruction Type</th>
            </tr>
        </table>
        <input type="button" id="editPathMid" value="Edit Path Mid Info">
    <!--  Edit  -->
        <div id="formPathMid">
            <form action="#" id="editFormMid">
                <table id="editFormMidTable" style="border:1px solid black">
                    <tr class="tHeading">
                        <th>Distance From Start</th>
                        <th>Ground Height</th>
                        <th>Terrain Type</th>
                        <th>Obstruction Height</th>
                        <th>Obstruction Type</th>
                    </tr>
                </table>
                <input type="submit" value="submit" name="submit">
                <input type="button" value="cancel" id="cancelMid">
            </form>
        </div>

    </div>
    <div id="calcRootDiv">
        <h1>Calculation Results</h1>
        <br><br>
        <h3 id="pathLoss"></h3>
        <br><br>
        <table id="calcTable" style="border:1px solid black">
            <tr id="calcHeading">
                <th>Distance From Start</th>
                <th>Ground Height</th>
                <th>Terrain Type</th>
                <th>Obstruction Height</th>
                <th>Obstruction Type</th>
                <th>Curvature Height</th>
                <th>Apparent Ground and Obstruction Height</th>
                <th>1st Freznel Zone</th>
                <th>Total Clearance Height</th>
            </tr>
        </table>
        <br><br>
        <span style="color: #d70206">
            <span style="background-color: #d70206;" class="dot"></span>Apparent Ground and Obstruction Height
        </span><br>
        <span style="color: blue">
            <span style="background-color: blue" class="dot"></span>1st Frenzel Zone
        </span><br>
        <span style="color: #f4c63d">
            <span style="background-color:#f4c63d;" class="dot"></span>Path
        </span>
        <div class="ct-chart"></div>

        <br>
        <input type="button" id="return" value="Return" style="background-color: red;padding: 20px;font-size: 1.5em">
    </div>

    <br><br>
<!--  Earth Curvature Factor  -->
    <label for="ecf">Choose Earth Curvature Factor:</label>
    <select id="ecf">
        <option value="4">4/3</option>
        <option value="1">1</option>
        <option value="2">2/3</option>
        <option value="i">Infinity</option>
    </select>
    <br><br>
    <input type="button" id="calculateBtn" value="Calculate" style="background-color: red;padding: 20px;font-size: 1.5em">


</div>

</body>
</html>

