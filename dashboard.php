<?php

session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');

$user = $_SESSION['user'];

include('database/cs-stats-graph-pie.php');

include('database/cs-stats-graph-bar.php');

include('database/linegrph.php');

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <title>Dashboard of C&C</title>
</head>

<body>
    <div id="dMaincont">
        <?php include('ps/sbApp.php') ?>
        <div class="dcontentcont" id="dcontentcont">
            <?php include('ps/tnavApp.php') ?>
            <div class="dcontent">
                <div class="dcontentmain">
                  <div class="col50">
                  <figure class="highcharts-figure">
                    <div id="container"></div>
           
                  </figure>
                  </div>
                  <div class="col50">
                  <figure class="highcharts-figure">
                    <div id="containerBarChart"></div>
                      
                  </figure>
                  </div>
                        
           
        </div>
        <div id="linegrph">

        </div>

        </div>
    </div>
    </div>
    <script src="JS/sc.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        var graphData = <?= json_encode($results) ?>;
        Highcharts.chart('container', {
  chart: {
    type: 'pie'
  },
  title: {
    text: 'Capital and Sales of Cream & Cakes',
    align: 'left'
  },
  credits: {
    enabled: false
  },
  tooltip: {
    valueSuffix: 'k'
  },
  subtitle: {
    text:
    '<a href="https://www.mdpi.com/2072-6643/11/3/684/htm" target="_default"></a>'
  },
  plotOptions: {
    series: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: [{
        enabled: true,
        distance: 20
      }, {
        enabled: true,
        distance: -40,
        format: '{point.percentage:.1f}%',
        style: {
          fontSize: '1.2em',
          textOutline: 'none',
          opacity: 0.7
        },
        filter: {
          operator: '>',
          property: 'percentage',
          value: 10
        }
      }]
    }
  },
  series: [{
      name: 'Sales & Capital',
      colorByPoint: true,
      data: graphData
    }]
});

var barGraphData = <?= json_encode($barchartdata) ?>;
var barGraphCategories = <?= json_encode($categories) ?>;
Highcharts.chart('containerBarChart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Brands Used of Cream & Cakes',
        align: 'left'
    },
    credits: {
        enabled: false
    },
    xAxis: {
        categories: barGraphCategories,
    
        crosshair: true
        
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    tooltip: {
        pointFormatter: function(){
          var point = this,
              series = point.series;

          return `<b>${'Ingredients'}</b>: ${point.y}`
        }
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
            name: 'Brands',
            data: barGraphData
        
        }
    ]
});

var lineGraphData = <?= json_encode($line_Graph) ?>;
var linegres = <?= json_encode($line_gres) ?>;
Highcharts.chart('linegrph', {
    chart: {
        type: 'spline'
    },

title: {
    text: 'Sales Range of Cream & Cakes',
    align: 'center'
},
credits: {
    enabled: false
},

yAxis: {
    title: {
        text: ''
    }
},

xAxis: {
   categories: lineGraphData
},

legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle'
},

plotOptions: {
    series: {
        label: {
            connectorAllowed: false
        },
       
    }
},

series: [{
    name: 'Sales By Date',
    data: linegres

}],

responsive: {
    rules: [{
        condition: {
            maxWidth: 500
        },
        chartOptions: {
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
            }
        }
    }]
}

});


    </script>
</body>

</html>