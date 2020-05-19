$(document).ready(function () {
    $("#calcRootDiv").hide();

    $("#calculateBtn").click(function () {
        const id = $("#path").children(":selected").attr("id");
        const ecf = $("#ecf").val();
        $.post("include/thirdPart/getData3.php",{id:id,ecf:ecf},calculated);


        $("#mainTables").hide();
    });

    let calculated = function (result) {
        console.log(result);
        for (let i = 0; i < result.length; i++) {
            let tr = $("<tr></tr>");
            for (let j = 2; j < 11; j++) {
                let td = $("<td></td>").text(result[i][j]);
                tr.append(td);
            }
            $("#calcTable").append(tr);
        }

        drawGraph(result);

        $("#pathLoss").html("Path Attenuation (dB): "+result[0][11])

        $('body > :not(#tables),#tables > :not(#calcRootDiv)').hide();
        $("#calcRootDiv").show();
    };

    $("#return").click(function () {
        $("#calcHeading").parent().children().not(':first-child').remove();
        $("#calcRootDiv").hide();
        $('body > :not(#tables),#tables > :not(#calcRootDiv),#mainTables').show();
    });

});

function drawGraph(array) {

    let distance = [],
        gnd = [],
        frenzel = [],
        path = [],
        series = [],
        startPoint = array[0][12],
        endPoint = array[0][13];

    const addby = ((endPoint-startPoint)/array.length).toFixed(2);
    path[0]=startPoint;
    let newPoint = parseFloat(startPoint);
    for (let i = 2; i < array.length; i++) {
        newPoint+=parseFloat(addby);
        path.push(newPoint);
    }
    path.push(endPoint);

    for (let i = 0; i < array.length; i++) {
        distance.push(i+1);
        let appG = array[i][8],
            total = array[i][10];
        gnd.push(appG);
        frenzel.push(total);
    }

    series.push(gnd,frenzel,path);

    let chart = new Chartist.Line('.ct-chart', {
        labels: distance,
        series: series
    }, {
        low: 0,
        width: '80%',
        height:'600px'
    });

// Let's put a sequence number aside so we can use it in the event callbacks
    let seq = 0,
        delays = 80,
        durations = 500;

// Once the chart is fully created we reset the sequence
    chart.on('created', function() {
        seq = 0;
    });

// On each drawn element by Chartist we use the Chartist.Svg API to trigger SMIL animations
    chart.on('draw', function(data) {
        seq++;

        if(data.type === 'line') {
            // If the drawn element is a line we do a simple opacity fade in. This could also be achieved using CSS3 animations.
            data.element.animate({
                opacity: {
                    // The delay when we like to start the animation
                    begin: seq * delays + 1000,
                    // Duration of the animation
                    dur: durations,
                    // The value where the animation should start
                    from: 0,
                    // The value where it should end
                    to: 1
                }
            });
        } else if(data.type === 'label' && data.axis === 'x') {
            data.element.animate({
                y: {
                    begin: seq * delays,
                    dur: durations,
                    from: data.y + 100,
                    to: data.y,
                    // We can specify an easing function from Chartist.Svg.Easing
                    easing: 'easeOutQuart'
                }
            });
        } else if(data.type === 'label' && data.axis === 'y') {
            data.element.animate({
                x: {
                    begin: seq * delays,
                    dur: durations,
                    from: data.x - 100,
                    to: data.x,
                    easing: 'easeOutQuart'
                }
            });
        } else if(data.type === 'point') {
            data.element.animate({
                x1: {
                    begin: seq * delays,
                    dur: durations,
                    from: data.x - 10,
                    to: data.x,
                    easing: 'easeOutQuart'
                },
                x2: {
                    begin: seq * delays,
                    dur: durations,
                    from: data.x - 10,
                    to: data.x,
                    easing: 'easeOutQuart'
                },
                opacity: {
                    begin: seq * delays,
                    dur: durations,
                    from: 0,
                    to: 1,
                    easing: 'easeOutQuart'
                }
            });
        } else if(data.type === 'grid') {
            // Using data.axis we get x or y which we can use to construct our animation definition objects
            let pos1Animation = {
                begin: seq * delays,
                dur: durations,
                from: data[data.axis.units.pos + '1'] - 30,
                to: data[data.axis.units.pos + '1'],
                easing: 'easeOutQuart'
            };

            let pos2Animation = {
                begin: seq * delays,
                dur: durations,
                from: data[data.axis.units.pos + '2'] - 100,
                to: data[data.axis.units.pos + '2'],
                easing: 'easeOutQuart'
            };

            let animations = {};
            animations[data.axis.units.pos + '1'] = pos1Animation;
            animations[data.axis.units.pos + '2'] = pos2Animation;
            animations['opacity'] = {
                begin: seq * delays,
                dur: durations,
                from: 0,
                to: 1,
                easing: 'easeOutQuart'
            };

            data.element.animate(animations);
        }
    });
}