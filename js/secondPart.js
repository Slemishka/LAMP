$(document).ready(function () {
    //hide all edit tables
    $("#editForm,#editFormEnd,#editFormMid").hide();


//first
    $("#editPath").click(function () {
        const id = $("#path").children(":selected").attr("id");
        //clear tables
        $("#editFormTable").children().not(':first-child').remove();
        $.post("include/secondPart/getData2.php",{id:id,form:1},received);
    });
    let received = function (result) {
        //show form
        $("#editForm").show();
        //hide table
        $("#t1,#editPath").hide();
        console.log(result);

        let array = result[0];

        let tr = $("<tr></tr>");
        for (let i = 1; i < 5; i++) {
            let td = $("<td></td>");
            let input = $("<input />",{type:"text",value:array[i],id:i+","+array[0]});  //id stands for which cell,which id
            td.append(input);
            tr.append(td);
        }
        $("#editFormTable").append(tr);




    };
    //on submit function:
    $("#editForm").submit(function () {
        console.log("submitted");
        let array = [];
        $("#editFormTable").find(":input").each(function (i) {
            if ($(this).val() !== $(this).prop("defaultValue")){

                let input = {
                    id : $(this).attr('id'),
                    value : $(this).val()
                };

                array.push(input);
            }
        });
        let arrayToJson = JSON.stringify(array);
        $.post("include/secondPart/updateMain.php",{array:arrayToJson},updatedMain);
        if($("#path").change()) {
            $("#editForm").hide();
            $("#t1,#editPath").show();
        }
        return false;   //same as preventDefault
    });
    let updatedMain = function (result) {alert(result.msg);};
    //on cancel
    $("#cancel").click(function () {
        $("#path").change();
        $("#editForm").hide();
        $("#t1,#editPath").show();
    });


    //second
    $("#editPathEnd").click(function () {
        const id = $("#path").children(":selected").attr("id");
        //clear tables
        $("#editFormEndTable").children().not(':first-child').remove();
        $.post("include/secondPart/getData2.php",{id:id,form:2},receivedEnd);
    });
    let receivedEnd = function (result) {
        $("#editFormEnd").show();
        $("#t2,#editPathEnd").hide();
        console.log(result);

        let array = result;

        for (let i = 0; i < array.length; i++) {
            let tr = $("<tr></tr>");
            for (let j = 2; j < 7; j++) {
                let td = $("<td></td>");
                //id below means: which array,which cell,which end point id, which main point foreign id
                let input = $("<input />",{type:"text",value:array[i][j],id:i+","+j+","+array[i][0]+","+array[i][1]});
                td.append(input);
                tr.append(td);
            }
            $("#editFormEndTable").append(tr);
        }

    };
    //on submit second
    $("#editFormEnd").submit(function () {
        console.log("submited");
        let array = [];
        $("#editFormEndTable").find(":input").each(function(){
            if ($(this).val() !== $(this).prop("defaultValue")){

                let input = {
                    id : $(this).attr('id'),
                    value : $(this).val()
                };

                array.push(input);
            }
        });
        console.log(array);
        let arrayToJson = JSON.stringify(array);
        $.post("include/secondPart/updateEnd.php",{array:arrayToJson},updatedEnd);
        if($("#path").change()) {
            $("#editFormEnd").hide();
            $("#t2,#editPathEnd").show();
        }
        return false;
    });
    let updatedEnd = function(response){alert(response.msg);};
    //on cancel
    $("#cancelEnd").click(function () {
        $("#path").change();
        $("#editFormEnd").hide();
        $("#t2,#editPathEnd").show();
    });

    //third
    $("#editPathMid").click(function () {
        const id = $("#path").children(":selected").attr("id");
        //clear tables
        $("#editFormMidTable").children().not(':first-child').remove();
        $.post("include/secondPart/getData2.php",{id:id,form:3},receivedMid);
    });
    let receivedMid = function (result) {
        $("#editFormMid").show();
        $("#t3,#editPathMid").hide();
        console.log(result);

        let array = result;

        for (let i = 0; i < array.length; i++) {
            let tr = $("<tr></tr>");
            for (let j = 2; j < 7; j++) {
                let td = $("<td></td>");
                //id below means: which array,which cell,which end point id, which main point foreign id
                let input = $("<input />",{type:"text",value:array[i][j],id:i+","+j+","+array[i][0]+","+array[i][1]});
                td.append(input);
                tr.append(td);
            }
            $("#editFormMidTable").append(tr);
        }
    };
    //onsubmitThird
    $("#editFormMid").submit(function () {
        console.log("submited");
        let array = [];
        $("#editFormMidTable").find(":input").each(function(){
            if ($(this).val() !== $(this).prop("defaultValue")){

                let input = {
                    id : $(this).attr('id'),
                    value : $(this).val()
                };

                array.push(input);
            }
        });
        console.log(array);
        let arrayToJson = JSON.stringify(array);
        $.post("include/secondPart/updateMid.php",{array:arrayToJson},updatedMid);
        if ($("#path").change()) {
            $("#editFormMid").hide();
            $("#t3,#editPathMid").show();
        }
        return false;
    });
    let updatedMid = function(response){alert(response.msg);console.log(response)};
    //on cancel
    $("#cancelMid").click(function () {
        $("#path").change();
        $("#editFormMid").hide();
        $("#t3,#editPathMid").show();
    });
});