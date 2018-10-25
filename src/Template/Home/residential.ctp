<h2>Residential Summary</h2>
 <hr/>
 <p>
 Welcome to Rust Belt Riders residential services.

 <div class="panel panel-success">
   <div class="panel-heading">Account Details</div>
    <div class="panel-body">
        <div class="container">
            <div class="row row-spaced">
                <div class="col-md-2"><b>Customer Number</b></div>
                <div class="col-md-4"><?= $userId ?></div>
            </div>
            <div class="row row-spaced">
                <div class="col-md-2"><b>Member Since</b></div>
                <div class="col-md-4"><?= date_format( $accountCreatedDate, "F, Y") ?></div>
            </div>
            <div class="row row-spaced">
                <div class="col-md-2"><b>Collection Day</b></div>
                <div class="col-md-4"><?= $collectionDay ?></div>
            </div>
            <div class="row row-spaced">
                <div class="col-md-2"><b>Last Collection Note</b></div>
                <div class="col-md-4"><?= $collections->first() ? $collections->first()->note : "" ?></div>
            </div>
        </div>
    </div>
 </div>
 <br/>

 <div class="panel panel-success">
   <div class="panel-heading">Collection History</div>
    <div class="panel-body">
    <canvas id="canvas" width="400" height="400"></canvas>
    </div>
 </div>

 </p>

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
                    {
                        label: "Collections",
                        backgroundColor: window.chartColors[1],
                        borderColor: window.chartColors[1],
                        data: [
                            <?php
                                $pounds = 0;
                            foreach ($collections as $pickup):
                                $pounds = ($pickup->pounds * .72);
                                echo  "{ x: '" . $pickup->pickup_date->i18nFormat('yyyy-MM-dd') . "',  y: " . $pounds. "}, ";
                            endforeach; ?>
                        ],
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title:{
                    display:true,
                    text:"Co2 Diversion Chart"
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
