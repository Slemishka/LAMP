$(document).ready(function () {
    $("#path").change(function(){
        let id = $(this).children(":selected").attr("id");
        $.post("include/firstPart/getData.php",{id:id},received);
    });

    let path,
        id;
    let received = function(result){
       // console.log(result);
        //show tables
        $("#tables").removeAttr("hidden");
        //clear tables
        $(".tHeading").parent().children().not(':first-child').remove();

        let pathInfo = result['Path_Info'],
            endPoint = result['End_Point'],
            midPoint = result['Mid_Point'];

        //display 1st table content:
        for (let i = 0; i < pathInfo.length; i++) {
            let tr = $("<tr></tr>");
            for (let j = 1; j < 5; j++) {
                let td = $("<td></td>").text(pathInfo[i][j]);
                tr.append(td);
            }
            $("#t1").append(tr);
        }
        //display second table content:
        for (let i = 0; i < endPoint.length; i++) {
            let tr = $("<tr></tr>");
            for (let j = 2; j < 7; j++) {
                let td = $("<td></td>").text(endPoint[i][j]);
                tr.append(td);
            }
            $("#t2").append(tr);
        }
        //display third table content:
        for (let i = 0; i < midPoint.length; i++) {
            let tr = $("<tr></tr>");
            for (let j = 2; j < 7; j++) {
                let td = $("<td></td>").text(midPoint[i][j]);
                tr.append(td);
            }
            $("#t3").append(tr);
        }

        path = pathInfo[0][5];
        id = pathInfo[0][0];
    };

    $("#resetBtn").click(function () {
        console.log(path+"  id:"+id);

        $.post("include/firstPart/reset.php",{path:path,id:id},reseted);
    });

    var reseted = function (response) {
        console.log(response);
        if (response.status==="done"){
            console.log("updated");

            $("#path").change();
        }else if (response.status==="fail"){
            console.log("fail");
        }
    }
});
