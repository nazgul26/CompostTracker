<canvas id="canvas" width="400" height="800"></canvas>
<script>
window.chartColors = [
	'rgb(75, 192, 192)', // green
	'rgb(54, 162, 235)', // blue
	'rgb(153, 102, 255)', //purple
	'rgb(201, 203, 207)', // grey
    'rgb(255, 99, 132)', //red
	'rgb(255, 159, 64)', // orange
	'rgb(255, 205, 86)', // yellow
];


        var config = {
            type: 'line',
            data: {
                datasets: [
               
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title:{
                    display:true,
                    text:"<?= $clientName ?> Co2 Diversion Chart"
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        type: 'time',
                        stacked: true,
                        time: {
                            unit: 'month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        stacked: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Pounds Co2 Diverted'
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx, config);
        };
</script>