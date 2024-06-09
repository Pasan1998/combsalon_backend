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
         $query2 = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleCost) AS total_cost ,SUM(SaleProfit) AS total_profit ,SUM(SaleDiscount) AS total_discounts,SUM(SalesSpecialdiscounts) AS total_special_discount FROM tbl_sales WHERE SaleDate BETWEEN '$from' AND '$to' GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
        $result2 =  $db->query($query2);

        // Fetch results and combine based on date
        $combinedData = array();
        $datesArray = array();
        $netTotalArray = array();

        while ($row1 = mysqli_fetch_assoc($result1)) {
            $date = $row1['Cashout_day'];
            $datesArray[] = $date;
            $combinedData[$date] = array('total_cashouts' => $row1['total_cashouts']);
        }

        while ($row2 = mysqli_fetch_assoc($result2)) {
            $date = $row2['sale_day'];
            if (!in_array($date, $datesArray)) {
                $datesArray[] = $date;
            }
          
            if (isset($combinedData[$date])) {
                $combinedData[$date]['total_cost'] = $row2['total_cost'];
                $combinedData[$date]['total_special_discount'] = $row2['total_special_discount'];
                $combinedData[$date]['total_discounts'] = $row2['total_discounts'];
                $combinedData[$date]['total_profit'] = $row2['total_profit'];
                $combinedData[$date]['net_total'] = ($row2['total_cost'] + $combinedData[$date]['total_cashouts'] + $row2['total_discounts'] +  $row2['total_special_discount']);
                $combinedData[$date]['net_totalz'] = ( @$combinedData[$date]['total_cashouts'] + $row2['total_discounts'] +  $row2['total_special_discount']);
            } else {
                $combinedData[$date] = array(
                    'total_cost' => $row2['total_cost'],
                    'total_cashouts' => 0,
                    'net_total' => ($row2['total_cost'] + $row2['total_discounts'] +  $row2['total_special_discount']),
                    'total_discounts' => $row2['total_discounts'],
                    'total_special_discount' => $row2['total_special_discount'],
                    'total_profit'  => $row2['total_profit'],
                    'net_totalz' => @$combinedData[$date]['total_cashouts'] + $row2['total_discounts'] +  $row2['total_special_discount']
                ); 
            }
            $netTotalArray[] = $combinedData[$date]['total_profit'] - $combinedData[$date]['net_totalz'];
        }

        // Sort the array in descending order by date
        krsort($combinedData);
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
                    <th>Total sale Cost</th>
                    <th>Total Cashouts</th>
                    <th>Total discounts</th>
                    <th>Total Special discounts</th>
                    <th>Net Cost</th>
                    <th>Sale Profit</th>
                    <th>Profit / Loss</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($combinedData as $date => $data) : ?>
                    <tr>
                        <td><?= $date ?></td>
                        <td><?= $data['total_cost'] ?></td>
                        <td><?= $data['total_cashouts'] ?></td>
                         <td><?= $data['total_discounts'] ?></td> 
                        <td><?= $data['total_special_discount'] ?></td>
                        <td><?= $data['net_total'] ?></td>
                        <td><?= $data['total_profit'] ?></td>
                        <td><?= $data['total_profit'] - $data['net_totalz'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <pre>
        <?php
        // Display the arrays
        rsort($datesArray);
        echo "<br>";
       echo  "'" . implode("','", $datesArray) . "'";
        //print_r($datesArray);
        echo "<br>";
        echo implode(",", $netTotalArray);
        echo "<br>";
        print_r($netTotalArray);
        ?>
        </pre>
    <?php endif; ?>

</body>

</html>
