<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doughnut Chart Example</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Create a canvas element to render the chart -->
    <canvas id="myDoughnutChart" width="400" height="400"></canvas>

    <script>
        // Sample data for the doughnut chart
        var data = {
            labels: ['Label 1', 'Label 2', 'Label 3'],
            datasets: [{
                data: [30, 40, 30], // Values for each segment
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'], // Colors for each segment
                hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'] // Hover colors for each segment
            }]
        };

        // Configuration options
        var options = {
            cutoutPercentage: 50, // Percentage of the center that is cut out (doughnut hole)
            responsive: true,
            maintainAspectRatio: false
        };

        // Get the canvas element
        var ctx10 = document.getElementById('myDoughnutChart').getContext('2d');

        // Create the doughnut chart
        var myDoughnutChart = new Chart(ctx10, {
            type: 'doughnut',
            data: data,
            options: options
        });
    </script>
</body>
</html>
