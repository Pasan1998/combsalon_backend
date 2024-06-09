<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combined Data</title>
</head>

<body>

    <?php
    // Your database connection code here
    include '../function.php';
    $db = dbConn();
    
    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Get the start and end dates from the form
        $from = $_POST['from'];
        $to = $_POST['to'];

        // Perform the first query with date range
        $query1 = "SELECT DATE(Addeddate) AS Cashout_day, SUM(Amountcashout) AS total_cashouts FROM tbl_cashout WHERE Addeddate BETWEEN '$from' AND '$to' GROUP BY DATE(Addeddate) ORDER BY DATE(Addeddate) DESC";
        $result1 =  $db->query($query1);

        // Perform the second query with date range
        $query2 = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleCost) AS total_cost FROM tbl_sales WHERE SaleDate BETWEEN '$from' AND '$to' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
        $result2 =  $db->query($query2);

        // Fetch results and combine based on date
       
        $combinedData = array();
        krsort($combinedData);
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $combinedData[$row1['Cashout_day']] = array('total_cashouts' => $row1['total_cashouts'], 'total_cost' => 0, 'net_total' => $row1['total_cashouts']);
        }

        while ($row2 = mysqli_fetch_assoc($result2)) {
            $date = $row2['sale_day'];
            if (!isset($combinedData[$date])) {
                $combinedData[$date] = array('total_cashouts' => 0, 'total_cost' => $row2['total_cost'], 'net_total' => $row2['total_cost']);
            } else {
                $combinedData[$date]['total_cost'] += $row2['total_cost'];
                $combinedData[$date]['net_total'] = $combinedData[$date]['total_cost'] + $combinedData[$date]['total_cashouts'];
            }
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="from">From Date:</label>
        <input type="date" name="from" required>

        <label for="to">To Date:</label>
        <input type="date" name="to" required>

        <input type="submit" name="submit" value="Submit">
    </form>

    <?php if (isset($_POST['submit'])) : ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Cost</th>
                    <th>Total Cashouts</th>
                    <th>Net Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($combinedData as $date => $data) : ?>
                    <tr>
                        <td><?= $date ?></td>
                        <td><?= $data['total_cost'] ?></td>
                        <td><?= $data['total_cashouts'] ?></td>
                        <td><?= $data['net_total'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>

</html>
