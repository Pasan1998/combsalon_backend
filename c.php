<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizontal Bar Chart with Right Y-axis</title>
    <!-- Include Google Charts library -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawRightY);

        function drawRightY() {
            var data = google.visualization.arrayToDataTable([
                ['City', '2010 Population'],
                ['New York City, NY', 8175000],
                ['Los Angeles, CA', 3792000],
                ['Chicago, IL', 2695000],
                ['Houston, TX', 2099000],
                ['Philadelphia, PA', 1526000]
            ]);

            var materialOptions = {
                chart: {
                    title: 'Population of Largest U.S. Cities',
                    subtitle: 'Based on most recent and previous census data'
                },
                hAxis: {
                    title: 'Total Population',
                    minValue: 0,
                },
                vAxis: {
                    title: 'City'
                },
                bars: 'horizontal',
                axes: {
                    y: {
                        0: {side: 'right'}
                    }
                }
            };

            var materialChart = new google.charts.Bar(document.getElementById('chart_div'));
            materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
        }
    </script>
</head>
<body>
    <!-- Create a div element to render the chart -->
    <div id="chart_div" style="width: 600px; height: 400px;"></div>
</body>
</html>
